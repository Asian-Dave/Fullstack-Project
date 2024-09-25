document
  .getElementById("edit_profile_info")
  .addEventListener("submit", editProfile);

function editProfile(e) {
  e.preventDefault();

  let id = document.getElementById("id").value;
  let fname = document.getElementById("fname").value;
  let lname = document.getElementById("lname").value;
  let email = document.getElementById("email").value;
  let role = document.getElementById("role")
    ? document.getElementById("role").value
    : null;
  let currentrole = document.getElementById("currentrole").value;
  let picture = document.getElementById("picture").files[0];
  let profile_info = document.getElementById("profile_info").value;
  let oldpicture = document.getElementById("oldpicture").value;

  if (!role || role === "") {
    role = currentrole;
  }

  let form = new FormData();
  form.append("picture", picture);
  form.append("fname", fname);
  form.append("lname", lname);
  form.append("email", email);
  form.append("profile_info", profile_info);
  form.append("role", role);
  form.append("oldpicture", oldpicture);

  let xml = new XMLHttpRequest();
  xml.onload = function () {
    if (this.status === 200) {
      let parsedData = JSON.parse(this.responseText);
      let statusMessageElement = document.getElementById("status_message");

      if (parsedData.message === "Validation failed") {
        if (parsedData.errors) {
          // Clear previous errors
          document
            .querySelectorAll(".error-message")
            .forEach((el) => (el.textContent = ""));

          for (const field in parsedData.errors) {
            if (parsedData.errors[field]) {
              let errorElement = document.getElementById(`${field}_error`);
              if (errorElement) {
                errorElement.textContent = parsedData.errors[field];
              }
            }
          }
        }
      } else if (parsedData.message === "Update successful") {
        statusMessageElement.textContent = "Profile updated successfully!";
        statusMessageElement.style.display = "block";
        setTimeout(() => {
          window.location.href = "user-profile.php";
        }, 3000);
      } else {
        statusMessageElement.textContent = "Unexpected response message.";
        statusMessageElement.style.display = "block";
      }
    } else {
      let statusMessageElement = document.getElementById("status_message");
      statusMessageElement.textContent = "Something went wrong!";
      statusMessageElement.style.display = "block";
    }
  };
  xml.open("POST", "/students/api_profile_update.php?id=" + id, true);

  xml.send(form);
}
