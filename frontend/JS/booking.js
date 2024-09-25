const URL = "http://localhost:3000/students/booking.php";

function show_booking() {
  let xhttp = new XMLHttpRequest();
  xhttp.open("GET", URL);
  xhttp.onload = function () {
    if (this.status == 200) {
      let bookings = JSON.parse(this.responseText);
      for (let booking of bookings.data) {
        let bookingDate = new Date(booking.booking_date);
        let options = { day: "numeric", month: "long", year: "numeric" };
        let formattedDate = bookingDate.toLocaleDateString(undefined, options);

        document.getElementById("bookings").innerHTML += `
        <div>
        <div class="card" style="width: 18rem">
        <div class="card-body">
          <h5 class="card-title">${booking.status}</h5>
            <p class="card-text">${formattedDate}</p>
            <p class="card-text">${booking.description}</p>
        </div>
      </div>
      </div>`;
      }
    }
  };
  xhttp.send();
}
show_booking();
