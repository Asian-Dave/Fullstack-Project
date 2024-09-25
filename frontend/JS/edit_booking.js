document
  .getElementById("update_booking_form")
  .addEventListener("submit", editBooking);

function editBooking(e) {
  e.preventDefault();
  let booking_id = document.getElementById("booking_id").value;
  let offer_id = document.getElementById("offer_id").value;
  let status = document.getElementById("status").value;

  let params = `id=${booking_id}&offer_id=${offer_id}&status=${status}`;

  let xml = new XMLHttpRequest();
  xml.onload = function () {
     let statusMessageElement = document.getElementById("status_message");
    if (this.status == 200) {
      let parsedData = JSON.parse(this.responseText);
      if (parsedData.message === "Booking updated successfully") {
                statusMessageElement.textContent = "Booking updated successfully!";
                statusMessageElement.style.color = "green";
                statusMessageElement.style.display = "block";
                
                setTimeout(() => {
                    window.location.href = 'dashboard.php'; // Redirige después de 3 segundos
                }, 3000);
            } else {
                statusMessageElement.textContent = "Failed to update the booking.";
                statusMessageElement.style.color = "red";
                statusMessageElement.style.display = "block";
            }
        } else {
            statusMessageElement.textContent = "Something went wrong!";
            statusMessageElement.style.color = "red";
            statusMessageElement.style.display = "block";
        }
    };
  xml.open("POST", "../../admin/api_update_booking.php", true);
  xml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  xml.send(params);
}