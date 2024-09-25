document.addEventListener("DOMContentLoaded", (event) => {
  const dateInput = document.getElementById("lessonDate");
  const today = new Date();
  const year = today.getFullYear();
  const month = String(today.getMonth() + 1).padStart(2, "0");
  const day = String(today.getDate()).padStart(2, "0");

  const todayDate = `${year}-${month}-${day}`;

  dateInput.value = todayDate;
  dateInput.min = todayDate;
});

document.addEventListener("DOMContentLoaded", () => {
  loadApiContent();
});

function loadApiContent() {
  let ajReq = new XMLHttpRequest();
  ajReq.open("GET", "../../students/api_lessons.php");
  ajReq.onload = function () {
    if (ajReq.status == 200) {
      const response = JSON.parse(ajReq.responseText);
      const subjects = response.data;
      const subjectDropdown = document.getElementById("subject");
      subjectDropdown.innerHTML = "";

      const selectedSubjectId = sessionStorage.getItem("selectedSubjectId");

      subjects.forEach((subject) => {
        const option = document.createElement("option");
        option.value = subject.id;
        option.textContent = subject.name;

        if (subject.id === selectedSubjectId) {
          option.selected = true;
        }

        subjectDropdown.appendChild(option);
      });

      if (selectedSubjectId) {
        subjectDropdown.dispatchEvent(new Event("change"));
      }
    }
  };
  ajReq.send();
}

document.getElementById("subject").addEventListener("change", selectSubject);
document.getElementById("lessonDate").addEventListener("change", selectSubject);

function selectSubject(e) {
  const selectedSubjectId = document.getElementById("subject").value;
  const selectedDate = document.getElementById("lessonDate").value;

  if (!selectedSubjectId) {
    return;
  }

  sessionStorage.setItem("selectedSubjectId", selectedSubjectId);

  e.preventDefault();
  let xhttp = new XMLHttpRequest();
  xhttp.open("POST", "../../students/api_lessons.php");
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send(
    "subject_id=" +
      selectedSubjectId +
      "&date=" +
      encodeURIComponent(selectedDate)
  );

  xhttp.onload = function () {
    if (this.status == 200) {
      let response = JSON.parse(this.responseText);

      const lessons = response.data;
      document.getElementById("result").innerHTML = "";
      if (lessons.length === 0) {
        document.getElementById("result").innerHTML =
          "<p>No lessons are available for the selected date.</p>";
        return;
      }

      let bookingButtonHtml = "";
      lessons.forEach((element, index) => {
        const isFull = element.booking_count >= element.capacity;
        const isBooked = element.user_booked > 0;
        const dateFrom = new Date(element.date_from).toLocaleString(undefined, {
          weekday: "long",
          year: "numeric",
          month: "long",
          day: "numeric",
          hour: "2-digit",
          minute: "2-digit",
        });
        const dateTo = new Date(element.date_to).toLocaleString(undefined, {
          weekday: "long",
          year: "numeric",
          month: "long",
          day: "numeric",
          hour: "2-digit",
          minute: "2-digit",
        });
        bookingButtonHtml = "";
        if (userRole !== "student" || userRole !== "admin") {
          bookingButtonHtml = ` <button class="btn btn-custom-extra w-50 m-1 book-btn" data-index="${index}" 
                        ${isFull || isBooked ? "disabled" : ""}>
                        ${isFull ? "Full" : isBooked ? "Booked" : "Book it!"}
                      </button>`;
        }

        document.getElementById("result").innerHTML += `
                <div>
                  <div class="card mb-4" style="width: 23rem;">
                    <div class="card shadow">
                      <div class="card-body p-0">
                        <h5 class="card-title card-title-extra text-center" style="height: 10vh;">${element.title}</h5>
                        <div class="p-3">
                          <ul class="list-group">
                            <li class="list-group-item"><strong>Trainer:</strong> ${element.firstname} ${element.lastname}</li>                
                            <li class="list-group-item"><strong>Subject:</strong> ${element.subject_name}</li>                
                            <li class="list-group-item"><strong>Price:</strong> ${element.price}€</li>
                            <li class="list-group-item"><strong>University:</strong> ${element.university_name}</li>
                            <li class="list-group-item"><strong>Bookings:</strong> ${element.booking_count}/${element.capacity}</li>
                            <li class="list-group-item" style="height: 12vh;"><strong>Time:</strong> ${dateFrom} - ${dateTo}</li>
                          </ul>
                        </div>
                        <div class="card-buttons card-buttons-extra d-flex mt-4">
                          <button class="btn btn-custom-extra w-50 m-1 details-btn" data-index="${index}">Details</button>
                          ${bookingButtonHtml}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>`;
      });

      attachLessonClickActions(lessons);
    } else {
      document.getElementById("result").innerHTML =
        "There was an error with the request.";
    }
  };
}

function attachLessonClickActions(lessons) {
  const detailsButtons = document.querySelectorAll(".details-btn");
  const bookButtons = document.querySelectorAll(".book-btn");

  detailsButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const index = button.getAttribute("data-index");
      handleLessonClick(lessons[parseInt(index)], "details");
    });
  });

  bookButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const index = button.getAttribute("data-index");

      handleLessonClick(lessons[parseInt(index)], "book");
    });
  });
}

function handleLessonClick(lesson, action) {
  if (action === "details") {
    const url = `../HTML/details.php?id=${encodeURIComponent(lesson.id)}`;
    window.location.href = url;
  } else if (action === "book") {
    let xhttp = new XMLHttpRequest();
    xhttp.open("POST", "../../students/api_booking.php");
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("lesson_id=" + encodeURIComponent(lesson.id));

    xhttp.onload = function () {
      if (xhttp.status == 200) {
        showAlert(
          "danger",
          "There was an error with your booking. Please try again."
        );

        selectSubject({ target: { value: lesson.subject_id } });
      } else {
        loadApiContent();
        const bookButton = document.querySelector(
          `button.book-btn[data-index="${lesson.index}"]`
        );

        showAlert("success", "Your booking has been successfully added.");
      }
    };
  }
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

document.getElementById("subject").addEventListener("change", selectSubject);
