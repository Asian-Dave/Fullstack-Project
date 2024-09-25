document
  .getElementById("create-review")
  .addEventListener("submit", createReview);

function createReview(e) {
  e.preventDefault();

  let student_id = document.getElementById("student_id").value;

  let tutoring_service_id = document.getElementById(
    "tutoring_service_id"
  ).value;

  let rating = document.getElementById("rating").value;

  let comment = document.getElementById("comment").value;

  let params = `student_id=${student_id}&tutoring_service_id=${tutoring_service_id}&rating=${rating}&comment=${comment}`;

  console.log(params);

  let xml = new XMLHttpRequest();
  xml.onload = function () {
    if (this.status == 200) {
      console.log(this.responseText);
      let parsedData = JSON.parse(this.responseText);
      console.log(parsedData);

      document.getElementById("comment").value = "";
    }
  };
  xml.open("POST", "/students/api_create_review.php");
  xml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  xml.send(params);
}
