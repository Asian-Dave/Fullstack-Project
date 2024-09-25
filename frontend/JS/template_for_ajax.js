//Shown example down belows is a relation between frontend html and backend communication
//create an html and with this thing down below as the boilerplate to test the individual steps.
//if possible inside the html folder, if its either a html or php doesnt matter, dont forget to link this script file to the html

//@Dave

//boilerplate

// <!DOCTYPE html>
// <html lang="en">

// <head>
//   <meta charset="UTF-8" />
//   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
//   <title>Document</title>
// </head>

// <body>
//   <form method="post" id="dropdownForm">
//     <select class="form-select" aria-label="Default select example" id="subject">
//     </select>
//   </form>
//   <div id="result"></div>
// </body>
// <script src="INSERT SCRIPT FILE"></script>
// </html>

//code down below

//When the page opens it ask for a get Method so it receives data it can fill its dropdown box
loadApiContent();

function loadApiContent() {
  let ajReq = new XMLHttpRequest();
  ajReq.open("GET", "../../students/api_lessons.php");
  ajReq.onload = function () {
    if (ajReq.status == 200) {
      const response = JSON.parse(ajReq.responseText);
      const subjects = response.data;
      const subjectDropdown = document.getElementById("subject");
      subjectDropdown.innerHTML = "";
      console.log(subjects);

      for (const subject of subjects) {
        subjectDropdown.innerHTML += `<option value="${subject.id}">${subject.name}</option>`;
      }
    }
  };
  ajReq.send();
}

//POST method so it sends the data to the backend and gets an answer immediatly
document.getElementById("subject").addEventListener("change", selectSubject);

function selectSubject(e) {
  const selectedSubjectId = e.target.value;
  console.log(selectedSubjectId);

  e.preventDefault();
  let xhttp = new XMLHttpRequest();
  xhttp.open("POST", "../../students/api_lessons.php");
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("subject_id=" + selectedSubjectId);

  xhttp.onload = function () {
    if (this.status == 200) {
      let response = JSON.parse(this.responseText);
      console.log(response);

      let lesson = response.data;
      lesson.forEach((element) => {
        document.getElementById(
          "result"
        ).innerHTML += `<p>${element.description}</p>`;
      });
    } else {
      document.getElementById("result").innerHTML =
        "There was an error with the request.";
    }
  };
}
