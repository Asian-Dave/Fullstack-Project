document
  .getElementById("create_offer_form")
  .addEventListener("submit", createOffer);

function createOffer(e) {
  e.preventDefault();

  let trainer_id = document.getElementById("trainer_id").value;

  let subject_id = document.getElementById("subject_id").value;

  let university_id = document.getElementById("university_id").value;

  let price = document.getElementById("price").value;
  let title = document.getElementById("title").value;


  let description = document.getElementById("description").value;

  let capacity = document.getElementById("capacity").value;
  let start_date_raw = document.getElementById("start_date").value;
  let end_date_raw = document.getElementById("end_date").value;

  let start_date = start_date_raw.replace("T", " ") + ":00";
  let end_date = end_date_raw.replace("T", " ") + ":00";


  let params = `trainer_id=${trainer_id}&subject_id=${subject_id}&university_id=${university_id}&price=${price}&description=${description}&title=${title}&capacity=${capacity}&start_date=${start_date}&end_date=${end_date}`;

  let xml = new XMLHttpRequest();
  xml.onload = function () {
    if (this.status == 200) {
      // action empty inputs and show success message

      document.getElementById("price").value = "";
      document.getElementById("description").value = "";
      document.getElementById("title").value = "";
      document.getElementById("capacity").value = "";
      document.getElementById("start_date").value = "";
      document.getElementById("end_date").value = "";
       alert("Offer has been successfully created!");
    } else {
      // Mostrar alerta de error si la solicitud no fue exitosa
      alert("An error occurred while creating the offer.");
    }
  };
  xml.open("POST", "../../tutor/api_create_offer.php");
  xml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  xml.send(params);
}
