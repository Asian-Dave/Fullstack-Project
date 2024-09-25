document
  .getElementById("update_offer_form")
  .addEventListener("submit", editOffer);

function editOffer(e) {
  e.preventDefault();

  let service_id = document.getElementById("service_id").value;
  let trainer_id = document.getElementById("trainer_id")
    ? document.getElementById("trainer_id").value
    : "";
  let subject_id = document.getElementById("subject_id").value;
  let university_id = document.getElementById("university_id").value;
  let price = document.getElementById("price").value;
  let description = document.getElementById("description").value;
  let title = document.getElementById("title").value;
  let capacity = document.getElementById("capacity").value;
  let start_date_raw = document.getElementById("start_date").value;
  let end_date_raw = document.getElementById("end_date").value;

  let start_date = start_date_raw.replace("T", " ") + ":00";
  let end_date = end_date_raw.replace("T", " ") + ":00";

  if (!subject_id || !university_id || !price || !description || !capacity) {
    alert("Please, all fields are required.");
    return;
  }
  let params = `id=${service_id}&trainer_id=${trainer_id}&subject_id=${subject_id}&university_id=${university_id}&price=${price}&description=${description}&title=${title}&capacity=${capacity}&start_date=${start_date}&end_date=${end_date}`;

  if (trainer_id !== null) {
    params += `&trainer_id=${trainer_id}`;
  }

  let xml = new XMLHttpRequest();
  xml.onload = function () {
    // try {
    //   let parsedData = JSON.parse(this.responseText);  // Intenta analizar JSON
    //   console.log(parsedData);
    // } catch (error) {
    //   console.error("Error parsing JSON response: ", error);
    //   console.log("Response received: ", this.responseText);  // Muestra lo que se ha recibido
    // }
    if (this.status == 200) {
      let parsedData = JSON.parse(this.responseText);
      console.log(parsedData);

      alert("Offer has been updated.");
    } else {
      alert("Something were wrong!");
    }
  };
  xml.open("POST", "../../tutor/api_update_offer.php", true);
  xml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  xml.send(params);
}
