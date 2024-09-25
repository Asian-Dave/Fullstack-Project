<?php

?>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="/frontend/HTML/home.php">TutorTime</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php if (isset($_SESSION["role"])) {
                    if ($_SESSION["role"] == "student") {
                        echo "
                    <li class='nav-item'>
                        <a class='nav-link active' aria-current='page' href='/frontend/HTML/home.php'>Home</a>
                    </li>
                     <li class='nav-item'>
                    <a class='nav-link active' aria-current='page' href='/frontend/HTML/user-profile.php'>User Profile</a>
                </li>
            </ul>
            <a href='../../login/logout.php' class='nav-item btn btn-danger'>Log out</a>
                ";
                    } elseif ($_SESSION["role"] == "admin") {
                        echo "
                    <li class='nav-item'>
                        <a class='nav-link active' aria-current='page' href='/frontend/HTML/dashboard.php'>Dashboard</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link active' aria-current='page' href='/frontend/HTML/create-offer.php'>Create new offer</a>
                    </li>
                    <li class='nav-item'>
                    <a class='nav-link active' aria-current='page' href='/frontend/HTML/user-profile.php'>User Profile</a>
                </li>
            </ul>
            <a href='../../login/logout.php' class='nav-item btn btn-danger'>Log out</a>
                    ";
                    } elseif ($_SESSION["role"] == "trainer") {
                        echo "
                    <li class='nav-item'>
                        <a class='nav-link active' aria-current='page' href='/frontend/HTML/mainpanel.php'>Main Panel</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link active' aria-current='page' href='/frontend/HTML/create-offer.php'>Create new offer</a>
                    </li>
                    <li class='nav-item'>
                    <a class='nav-link active' aria-current='page' href='/frontend/HTML/user-profile.php'>User Profile</a>
                </li>
            </ul>
            <a href='../../login/logout.php' class='nav-item btn btn-danger'>Log out</a>
                    ";
                    }
                } else {
                    echo "</ul>
                    <a href='../../login/login.php' class='nav-item btn btn-primary'>Log in</a>";
                } ?>

        </div>
    </div>
</nav>