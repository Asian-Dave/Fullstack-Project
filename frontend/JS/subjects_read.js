const URL = "http://localhost:3000/students/api_subjets_read_student.php";
let arrayTest = [];
function show_subjects() {
  let xhttp = new XMLHttpRequest();
  xhttp.open("GET", URL);
  xhttp.onload = function () {
    if (this.status == 200) {
      let subjects = JSON.parse(this.responseText);
      document.getElementById("result").innerHTML = "";
      for (let subject of subjects.data) {
        document.getElementById("result").innerHTML += `
      <div>
        <a  class="card-link">
          <div class="card shadow rounded-3 mb-4">
            <div class="card-body" style="cursor:pointer;">
              <h5 class="card-title text-center">${subject.name}</h5>
              </button>
            </div>
          </div>  
        </a>
      </div>`;
        arrayTest.push({ subject });
      }
      console.log(arrayTest);

      document.querySelectorAll(".card").forEach((card, index) => {
        card.addEventListener("click", () => handleSubjectClick(index));
      });
    }
  };
  xhttp.send();
}
show_subjects();
function handleSubjectClick(index) {
  const selectedSubject = arrayTest[index].subject;
  console.log(`Subject clicked: ${selectedSubject.name}, Index: ${index}`);

  sessionStorage.setItem("selectedSubjectId", selectedSubject.id);

  window.location.href = "lesson-list.php";
}
