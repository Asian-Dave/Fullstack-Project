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
let lessonList = "";
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
      lessonList = JSON.parse(this.responseText);
      console.log(lessonList);

      let lesson = lessonList.data;
      lesson.forEach((element) => {
        document.getElementById(
          "result"
        ).innerHTML += `<p class="lesson">${element.description}</p>`;
      });
    } else {
      document.getElementById("result").innerHTML =
        "There was an error with the request.";
    }
    lessonList = document.querySelectorAll(".lesson");
  };
  lesson.forEach((element) => {
    element.addEventListener("click", function () {
      for (let i = 0; i < lesson.length; i++) {
        if (element === lesson[i].description) {
          matchFound = true;
          console.log("Match found at index:", i);
          console.log("Matching object:", objectArray[i]);
          break;
        }
      }
    });
  });
}
