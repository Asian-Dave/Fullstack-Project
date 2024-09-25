function show_users() {
  let xhttp = new XMLHttpRequest();
  xhttp.open("GET", "../../admin/api_read_users.php");
  xhttp.onload = function () {
    if (this.status == 200) {
      console.log(this.responseText);

      let users = JSON.parse(this.responseText);
      for (let user of users.data) {
        document.getElementById("users").innerHTML += `
            <tr>
              <th scope="row">${user.id}</th>
              <td><img src="/components/pictures/${user.picture}" alt="User picture" style="width: 5vh; border-radius: 50%;"></td>              
              <td>${user.firstname}</td>
              <td>${user.lastname}</td>
              <td> ${user.email}</td>
              <td>${user.role}</td>
              <td>${user.profile_info}</td>
              <td>
              <div class="d-flex">
                <a href="/frontend/HTML/edit_profile.php?id=${user.id}" class="btn btn-warning">Edit</a>
                <a href="../../admin/delete_user.php?id=${user.id}" class="btn btn-danger">Delete</a>
                </div>
              </td>
            </tr>`;
      }
    }
  };
  xhttp.send();
}
show_users();
