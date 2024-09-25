showSubject();
loadStudentContent();
loadReviews();

function showSubject() {
  const selectedSubjectId = document.getElementById("chosenId").innerHTML;

  let xhttp = new XMLHttpRequest();
  xhttp.open("POST", "../../students/api_details.php");
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("id=" + selectedSubjectId);

  xhttp.onload = function () {
    if (this.status == 200) {
      let offers = JSON.parse(this.responseText);

      let offer = offers.data[0];

      const isFull = offer.booking_count >= offer.capacity;
      const isBooked = offer.user_booked > 0;
      const dateFrom = new Date(offer.date_from).toLocaleString(undefined, {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
      });
      const dateTo = new Date(offer.date_to).toLocaleString(undefined, {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
      });
      let bookingButtonHtml = "";
      if (userRole !== "trainer") {
        bookingButtonHtml = `<button class="btn btn-custom-blue book-btn" id="book-btn" 
                                ${isFull || isBooked ? "disabled" : ""}>
                                ${
                                  isFull
                                    ? "Full"
                                    : isBooked
                                    ? "Booked"
                                    : "Book it!"
                                }
                             </button>`;
      }
      document.getElementById("info").innerHTML += `
        <div class="course-details">
          <h4>${offer.title}</h4>
          <h5>${offer.subject_name}</h5>
          <h5>University: ${offer.university_name}, ${offer.university_city}</h5>
        </div>
        <div class="course-meta row">
          <div class="col-md-6">
            <h6>Trainer: ${offer.firstname} ${offer.lastname}</h6>
            <h6>Email: ${offer.users_email}</h6>
            <h6>Price: $${offer.price}</h6>
          </div>
          <div class="col-md-6">
            <h6>Address:</h6>
            <p>${offer.university_address}</p>
          </div>
        </div>
        <div class="course-description mt-5">
          <h5>Description</h5>
          <p>${offer.description}</p>
        </div>
        <div class="course-description mt-5"><strong>Bookings:</strong> ${offer.booking_count}/${offer.capacity}</div>
        <div class="btn-group">
          <button type="button" class="btn btn-back" onclick="window.history.back();">Go Back</button>
          ${bookingButtonHtml}        
        </div>`;
      const bookButton = document.getElementById("book-btn");
      if (!isFull && !isBooked) {
        bookButton.addEventListener("click", () =>
          handleLessonClick(selectedSubjectId)
        );
      }
    }
  };
}
function loadStudentContent() {
  const selectedSubjectId = document.getElementById("chosenId").innerHTML;

  let xhttp = new XMLHttpRequest();
  xhttp.open("POST", "../../tutor/api_student_booking_list.php");
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("id=" + selectedSubjectId);

  xhttp.onload = function () {
    if (this.status == 200) {
      let response = JSON.parse(this.responseText);
      let students = response.data;

      let studentListHtml = `<div class="collapse" id="collapseExample">
                              <div class="card card-body">`;

      students.forEach((student) => {
        studentListHtml += `
          <p><strong>${student.firstname} ${student.lastname}</strong> - ${student.email}</p>`;
      });

      studentListHtml += `</div></div>`;

      document
        .getElementById("students")
        .insertAdjacentHTML("afterend", studentListHtml);
    }
  };
}
function handleLessonClick(selectedSubjectId) {
  let xhttp = new XMLHttpRequest();
  xhttp.open("POST", "../../students/api_booking.php");
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("lesson_id=" + encodeURIComponent(selectedSubjectId));

  xhttp.onload = function () {
    if (xhttp.status == 200) {
      showAlert(
        "danger",
        "There was an error with your booking. Please try again."
      );
    } else {
      console.log(JSON.parse(this.responseText));
      const bookButton = document.getElementById("book-btn");
      bookButton.textContent = "Booked";
      bookButton.disabled = true;

      showAlert("success", "Your booking has been successfully added.");
    }
  };
}

function showAlert(type, message) {
  const alertPlaceholder = document.getElementById("alertPlaceholder");
  const alertId = "alert-" + Date.now();

  alertPlaceholder.innerHTML = `
      <div id="${alertId}" class="alert alert-${type} alert-dismissible fade show" role="alert">
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    `;

  setTimeout(() => {
    const alertElement = document.getElementById(alertId);
    if (alertElement) {
      const alert = new bootstrap.Alert(alertElement);
      alert.close();
    }
  }, 5000);
}
function loadReviews() {
  const selectedSubjectId = document.getElementById("chosenId").innerHTML;

  let xhttp = new XMLHttpRequest();
  xhttp.open("POST", "../../students/api_reviews.php");
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("tutoring_service_id=" + selectedSubjectId);

  xhttp.onload = function () {
    if (this.status == 200) {
      let response = JSON.parse(this.responseText);
      let reviews = response.data;

      let reviewListHtml = "";
      reviews.forEach((review) => {
        console.log(review);

        reviewListHtml += `<div class="card" style="width: 23rem;">
          <div class="card-body py-4 mt-2">
            <div class="d-flex justify-content-center mb-4">
              <img src="../../components/pictures/${
                review.picture
              }" class="rounded-circle shadow-1-strong" width="100" height="100"/>
            </div>
            <h4 class="font-weight-bold">${review.firstname} ${
          review.lastname
        }</h4>
            <h5 class="font-weight-bold my-3">${
              review.rating
            } - ${getRatingText(review.rating)}</h5>
            <p class="mb-2">
              <i class="fa-solid fa-quote-left" style="color: #a9b1b9"></i>
              <span id="comment-${review.id}">${review.comment}</span>
              <i class="fa-solid fa-quote-right" style="color: #a9b1b9"></i>
            </p>
        </div>`;
      });

      document.getElementById("reviewList").innerHTML = reviewListHtml;
    }
  };
}

function getRatingText(rating) {
  rating = parseInt(rating);
  switch (rating) {
    case 1:
      return "Poor";
    case 2:
      return "Fair";
    case 3:
      return "Good";
    case 4:
      return "Very Good";
    case 5:
      return "Excellent";
    default:
      return "Unknown";
  }
}
