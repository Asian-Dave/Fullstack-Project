document.addEventListener("DOMContentLoaded", () => {
  loadUserProfile();
  loadUserReviews();
  loadUserBookings();

  document
    .querySelector("#calendar-tab")
    .addEventListener("shown.bs.tab", function () {
      initializeCalendar();
    });
});

function loadUserProfile() {
  let ajReq = new XMLHttpRequest();
  ajReq.open("GET", "../../students/api_profile_read.php");
  ajReq.onload = function () {
    if (ajReq.status == 200) {
      const response = JSON.parse(ajReq.responseText);
      const user = response.data[0];

      document.getElementById(
        "userName"
      ).textContent = `${user.firstname} ${user.lastname}`;
      document.getElementById(
        "fullname"
      ).textContent = `${user.firstname} ${user.lastname}`;
      document.getElementById("fname").textContent = user.firstname;
      document.getElementById("lname").textContent = user.lastname;
      document.getElementById(
        "side-image"
      ).innerHTML = `<img src='/components/pictures/${user.picture}' class='img-fluid rounded-circle' alt='${user.firstname} ${user.lastname}' />`;
      document.getElementById("userEmail").textContent = user.email;
      document.getElementById("userRole").textContent = user.role;
      document.getElementById("description").textContent = user.description;
      document.getElementById("profileInfo").textContent = user.description;
    } else {
      console.error("Failed to load user profile");
    }
  };
  ajReq.send();
}

function loadUserReviews() {
  let ajReq = new XMLHttpRequest();
  ajReq.open("GET", "../../students/api_read_reviews.php");
  ajReq.onload = function () {
    if (ajReq.status == 200) {
      const response = JSON.parse(ajReq.responseText);
      const reviews = response.data;
      const reviewsContainer = document.getElementById("reviews");
      reviewsContainer.innerHTML = "";

      reviews.forEach((review) => {
        const reviewHTML = `
        <div class="card">
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
            <p class="mb-2 font-weight-bold">${review.title} | ${
          review.subject
        }</p>
            <p class="mb-2">
              <i class="fa-solid fa-quote-left" style="color: #a9b1b9"></i>
              <span id="comment-${review.id}">${review.comment}</span>
              <i class="fa-solid fa-quote-right" style="color: #a9b1b9"></i>
            </p>
              <!-- Buttons for Edit and Delete -->
            <div class="d-flex justify-content-end mt-4">
             <div class="d-flex justify-content-between mt-3">
              <button type="button" class="btn btn-primary me-2" onclick="editReview(${
                review.id
              })">Edit</button>   
              <button type="button" class="btn btn-danger" onclick="deleteReview(${
                review.id
              })")>Delete</button>
            </div>
          </div>
        </div>`;
        reviewsContainer.innerHTML += reviewHTML;
      });
    } else {
      console.error("Failed to load user reviews");
    }
  };
  ajReq.send();
}

function loadUserBookings() {
  let ajReq = new XMLHttpRequest();
  ajReq.open("GET", "../../students/api_read_bookings.php");
  ajReq.onload = function () {
    if (ajReq.status == 200) {
      const response = JSON.parse(ajReq.responseText);
      const bookings = response.data;
      const bookingsContainer = document.getElementById("bookings");
      bookingsContainer.innerHTML = "";

      bookings.forEach((booking) => {
        let buttonHTML = "";

        if (booking.status === "cancelled") {
          buttonHTML = `
                <button class="btn btn-sm btn-secondary" disabled>
                  Canceled
                </button>`;
        } else if (booking.status === "completed") {
          buttonHTML = `
                <button class="btn btn-sm btn-success" disabled>
                  Completed
                </button>
                <button class="btn btn-sm btn-primary" data-bs-toggle="collapse" data-bs-target="#reviewForm-${booking.booking_id}" aria-expanded="false" aria-controls="reviewForm-${booking.booking_id}">
                  Write Review
                </button>`;
        } else {
          buttonHTML = `
                <button class="btn btn-sm btn-danger" onclick="cancelBooking(${booking.booking_id})">
                  Cancel Booking
                </button>`;
        }

        const bookingHTML = `
              <div class="card">
                <div class="card-body py-4 mt-2">
                  <h4 class="font-weight-bold">${booking.subject_name}</h4>
                  <p><strong>Trainer:</strong> ${booking.trainer_firstname} ${
          booking.trainer_lastname
        }</p>
                  <p><strong>Price:</strong> ${booking.price}</p>
                  <p><strong>Capacity:</strong> ${booking.capacity}</p>
                  <p><strong>Date:</strong> ${new Date(
                    booking.date_from
                  ).toLocaleString()} - ${new Date(
          booking.date_to
        ).toLocaleString()}</p>
                  <p><strong>Booking Date:</strong> ${new Date(
                    booking.booking_date
                  ).toLocaleString()}</p>
                  <div class="d-flex justify-content-between mt-3">
                    ${buttonHTML}
                  </div>
                  <div class="collapse mt-3" id="reviewForm-${
                    booking.booking_id
                  }">
                    <div class="card card-body">
                      <div class="mb-3">
                        <label for="reviewRating-${
                          booking.booking_id
                        }" class="form-label">Rating</label>
                        <select class="form-select" id="reviewRating-${
                          booking.booking_id
                        }" required>
                          <option value="5">5 - Excellent</option>
                          <option value="4">4 - Very Good</option>
                          <option value="3">3 - Good</option>
                          <option value="2">2 - Fair</option>
                          <option value="1">1 - Poor</option>
                        </select>
                      </div>
                      <div class="mb-3">
                        <label for="reviewComment-${
                          booking.booking_id
                        }" class="form-label">Comment</label>
                        <textarea class="form-control" id="reviewComment-${
                          booking.booking_id
                        }" rows="3" required></textarea>
                      </div>
                      <button class="btn btn-primary" onclick="submitReview(${
                        booking.booking_id
                      }, ${
          booking.tutoring_service_id
        },)">Submit Review</button>
                    </div>
                  </div>
                </div>
              </div>
            `;
        bookingsContainer.innerHTML += bookingHTML;
      });
    } else {
      console.error("Failed to load user bookings");
    }
  };
  ajReq.send();
}

function initializeCalendar() {
  let calendarEl = document.getElementById("calendar");

  let calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: "dayGridMonth",
    events: fetchCalendarEvents,
  });

  calendar.render();
}

function fetchCalendarEvents(info, successCallback, failureCallback) {
  let ajReq = new XMLHttpRequest();
  ajReq.open("GET", "../../students/api_read_bookings.php");
  ajReq.onload = function () {
    if (ajReq.status == 200) {
      const response = JSON.parse(ajReq.responseText);
      const bookings = response.data;
      const events = bookings.map((booking) => {
        return {
          title: booking.subject_name,
          start: booking.date_from,
          end: booking.date_to,
        };
      });
      successCallback(events);
    } else {
      failureCallback("Failed to load events");
    }
  };
  ajReq.send();
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

function cancelBooking(bookingId) {
  if (confirm("Are you sure you want to cancel this booking?")) {
    let ajReq = new XMLHttpRequest();
    ajReq.open("POST", "../../students/api_cancel_booking.php");
    ajReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajReq.onload = function () {
      if (ajReq.status == 200) {
        alert("Booking canceled successfully");
        loadUserBookings(); // Reload the bookings after cancellation
      } else {
        console.error("Failed to cancel booking");
      }
    };
    ajReq.send(`booking_id=${bookingId}`);
  }
}

function editReview(reviewId) {
  console.log(reviewId);

  const commentElement = document.getElementById(`comment-${reviewId}`);

  const currentComment = commentElement.textContent.trim();

  const newComment = prompt("Edit your comment:", currentComment);
  if (newComment && newComment !== currentComment) {
    let ajReq = new XMLHttpRequest();
    ajReq.open("POST", "../../students/api_edit_review.php");
    ajReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajReq.onload = function () {
      if (ajReq.status == 200) {
        commentElement.innerHTML = `${newComment}`;
      } else {
        console.error("Failed to edit review");
      }
    };
    ajReq.send(
      `review_id=${reviewId}&comment=${encodeURIComponent(newComment)}`
    );
  }
}

function deleteReview(reviewId) {
  if (confirm("Are you sure you want to delete this review?")) {
    let ajReq = new XMLHttpRequest();
    ajReq.open("POST", "../../students/api_delete_review.php");
    ajReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajReq.onload = function () {
      if (ajReq.status == 200) {
        document
          .getElementById(`comment-${reviewId}`)
          .closest(".card")
          .remove();
      } else {
        console.error("Failed to delete review");
      }
    };
    ajReq.send(`review_id=${reviewId}`);
  }
}
function submitReview(bookingId, tutoringServiceId) {
  const rating = document.getElementById(`reviewRating-${bookingId}`).value;
  const comment = document.getElementById(`reviewComment-${bookingId}`).value;

  console.log(rating, comment, tutoringServiceId);

  let ajReq = new XMLHttpRequest();
  ajReq.open("POST", "../../students/api_submit_review.php");
  ajReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajReq.onload = function () {
    console.log(this.responseText);

    if (ajReq.status == 200) {
      alert("Review submitted successfully");
      loadUserReviews();
      const collapseElement = document.getElementById(
        `reviewForm-${bookingId}`
      );
      const bsCollapse = new bootstrap.Collapse(collapseElement, {
        toggle: false,
      });
      bsCollapse.hide();
    } else {
      console.error("Failed to submit review");
    }
  };
  ajReq.send(
    `booking_id=${bookingId}&tutoring_service_id=${tutoringServiceId}&rating=${rating}&comment=${encodeURIComponent(
      comment
    )}`
  );
}
