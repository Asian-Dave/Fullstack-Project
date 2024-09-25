function show_reviews() {
  let xhttp = new XMLHttpRequest();
  xhttp.open("GET", "http://localhost:3000/students/api_read_reviews.php");
  xhttp.onload = function () {
    if (this.status == 200) {
      let reviews = JSON.parse(this.responseText);
      for (let review of reviews.data) {
        document.getElementById("reviews").innerHTML += `             
                <p>${review.firstname}</p>
                <p>${review.lastname}</p>
                <p>${review.description}</p>
                <p>${review.rating}</p>
                <p>${review.comment}</p>
                `;
      }
    }
  };
  xhttp.send();
}
show_reviews();
