function show_offers() {
  let xhttp = new XMLHttpRequest();
  xhttp.open("GET", "http://localhost:3000/tutor/api_read_offer.php");
  xhttp.onload = function () {
    if (this.status == 200) {
      let response = JSON.parse(this.responseText);
      let offers = response.data;
      let userRole = response.role;
      document.getElementById("offers").innerHTML = "";
      for (let offer of offers) {
        if (userRole === "student" || userRole === "trainer") {
          let offerHTML = `
          <div>
            <div class="card shadow mb-4">
              <div class="card-body p-0">`;
          if (userRole === "student") {
            offerHTML += `
                <h5 class="card-title-extra text-center">Trainer: ${offer.firstname} ${offer.lastname}</h5>`;
          } else {
            offerHTML += `<h5 class="card-title-extra text-center">Your Training</h5>`;
          }
          offerHTML += `         
                <div class="p-3">
                  <ul class="list-group">
                    <li class="list-group-item"><strong>Subject:</strong> ${offer.subject_name}</li>                
                    <li class="list-group-item"><strong>Price:</strong> ${offer.price}</li>
                    <li class="list-group-item"><strong>Capacity:</strong> ${offer.capacity}</li>
                    <li class="list-group-item"><strong>University:</strong> ${offer.university_name}</li>
                    <li class="list-group-item"><strong>Description:</strong> ${offer.description}</li>
                  </ul>
                </div>
              <div class="card-buttons-extra d-flex mt-4">
                <a href="/frontend/HTML/edit-offer.php?id=${offer.id}" class="btn btn-custom-extra w-50 m-1">Edit</a>
                <a href="/frontend/HTML/details.php?id=${offer.id}" class="btn btn-custom-extra w-50 m-1">Details</a>
                <a href="/tutor/delete_offer.php?id=${offer.id}" class="btn btn-custom-extra w-50 m-1">Delete</a>
              </div>
            </div>
          </div>`;
          document.getElementById("offers").innerHTML += offerHTML;
        } else if (userRole === "admin") {
          let offerHTML = `
          <tr>
              <th scope="row">${offer.id}</th>
              <td>${offer.title}</td>
              <td>${offer.firstname} 
              ${offer.lastname}</td>              
              <td>${offer.capacity}</td>
              <td>${offer.subject_name}</td>
              <td>${offer.university_name}</td>
              <td>${new Date(offer.date_from).toLocaleString([], {
                hour: "2-digit",
                minute: "2-digit",
                year: "numeric",
                month: "2-digit",
                day: "2-digit",
              })}</td>
              <td>${new Date(offer.date_to).toLocaleString([], {
                hour: "2-digit",
                minute: "2-digit",
                year: "numeric",
                month: "2-digit",
                day: "2-digit",
              })}</td>
              <td>
              <div class="d-flex">
                <a href="../HTML/edit-offer.php?id=${
                  offer.id
                }" class="btn btn-warning">Edit</a>
                <a href="../../tutor/delete_offer.php?id=${
                  offer.id
                }" class="btn btn-danger">Delete</a>
                </div>
              </td>
            </tr>
          `;
          document.getElementById("offers").innerHTML += offerHTML;
        }
      }
    }
  };
  xhttp.send();
}

show_offers();
