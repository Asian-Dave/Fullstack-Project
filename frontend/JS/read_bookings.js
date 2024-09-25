function show_bookings() {
  let xhttp = new XMLHttpRequest();
  xhttp.open("GET", "../../admin/api_read_bookings.php");
  xhttp.onload = function () {
    if (this.status == 200) {
      let response = JSON.parse(this.responseText);
      let bookings = response.data;

      document.getElementById("booking").innerHTML = "";
      for (let booking of bookings) {
        let bookingHTML = `
            <tr>
                <th scope="row">${booking.id}</th>
                <td>${booking.subject_name}</td>
                <td>${booking.description}</td>
                <td>${booking.trainer_firstname} ${
          booking.trainer_lastname
        }</td>
                <td>${booking.price}€</td>
                <td>${booking.capacity}</td>
                <td>${new Date(booking.booking_date).toLocaleString([], {
                  hour: "2-digit",
                  minute: "2-digit",
                  year: "numeric",
                  month: "2-digit",
                  day: "2-digit",
                })}</td>
                <td>${booking.student_firstname} ${booking.student_lastname} (${
          booking.student_email
        })</td>
        <td>${booking.status}</td>
        <td>
        <div class="d-flex">
                <a href="/frontend/HTML/edit_booking.php?id=${
                  booking.id
                }" class="btn btn-warning">Edit</a>
                <a href="../../admin/delete_booking.php?id=${
                  booking.id
                }" class="btn btn-danger">Delete</a>
                </div>
              </td>
            </tr>`;
        document.getElementById("booking").innerHTML += bookingHTML;
      }
    }
  };
  xhttp.send();
}

show_bookings();
