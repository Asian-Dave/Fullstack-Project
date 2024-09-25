<?php
session_start();
require_once "session_checker.php";
noUser();
$userRole = isset($_SESSION['role']) ? $_SESSION['role'] : null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
</head>

<body>
    <?php include "../php_components/navbar.php" ?>
    <section class="bg-light py-3 py-md-5 py-xl-8">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-12 col-md-10 col-lg-8 col-xl-7 col-xxl-6">
                    <h2 class="mb-4 display-5 text-center">Profile</h2>
                    <hr class="w-50 mx-auto mb-5 mb-xl-9 border-dark-subtle" />
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row gy-4 gy-lg-0">
                <div class="col-12 col-lg-4 col-xl-3">
                    <div class="row gy-4">
                        <div class="col-12">
                            <div class="card widget-card border-light shadow-sm">
                                <div class="card-header text-bg-primary">
                                    Welcome, <span id="userName"></span>
                                </div>
                                <div class="card-body">
                                    <div class="text-center mb-3" id="side-image"></div>
                                    <h5 class="text-center mb-1" id="fullname"></h5>
                                    <p class="text-center text-secondary mb-4" id="userRole"></p>
                                    <p class="text-center">
                                        <a class="btn btn-primary" href="/frontend/HTML/edit_profile.php" role="button">Edit Profile</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-8 col-xl-9">
                    <div class="card widget-card border-light shadow-sm">
                        <div class="card-body p-4">
                            <ul class="nav nav-tabs" id="profileTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview-tab-pane" type="button" role="tab" aria-controls="overview-tab-pane" aria-selected="true">
                                        Overview
                                    </button>
                                </li>

                                <?php if ($userRole === 'student') : ?>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#review-tab-pane" type="button" role="tab" aria-controls="review-tab-pane" aria-selected="false">
                                            Reviews
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="booking-tab" data-bs-toggle="tab" data-bs-target="#booking-tab-pane" type="button" role="tab" aria-controls="booking-tab-pane" aria-selected="false">
                                            Bookings
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="calendar-tab" data-bs-toggle="tab" data-bs-target="#calendar-tab-pane" type="button" role="tab" aria-controls="calendar-tab-pane" aria-selected="false">
                                            Calendar
                                        </button>
                                    </li>
                                <?php endif; ?>
                            </ul>
                            <div class="tab-content pt-4" id="profileTabContent">
                                <div class="tab-pane fade show active" id="overview-tab-pane" role="tabpanel" aria-labelledby="overview-tab" tabindex="0">
                                    <h5 class="mb-3">About</h5>
                                    <p class="lead mb-3" id="description"></p>
                                    <h5 class="mb-3">Profile</h5>
                                    <div class="row g-0">
                                        <div class="col-5 col-md-3 bg-light border-bottom border-white border-3">
                                            <div class="p-2">First Name</div>
                                        </div>
                                        <div class="col-7 col-md-9 bg-light border-start border-bottom border-white border-3">
                                            <div class="p-2" id="fname"></div>
                                        </div>
                                        <div class="col-5 col-md-3 bg-light border-bottom border-white border-3">
                                            <div class="p-2">Last Name</div>
                                        </div>
                                        <div class="col-7 col-md-9 bg-light border-start border-bottom border-white border-3">
                                            <div class="p-2" id="lname"></div>
                                        </div>
                                        <div class="col-5 col-md-3 bg-light border-bottom border-white border-3">
                                            <div class="p-2">E-Mail</div>
                                        </div>
                                        <div class="col-7 col-md-9 bg-light border-start border-bottom border-white border-3">
                                            <div class="p-2" id="userEmail"></div>
                                        </div>
                                        <div class="col-5 col-md-3 bg-light border-bottom border-white border-3">
                                            <div class="p-2">Profile Info</div>
                                        </div>
                                        <div class="col-7 col-md-9 bg-light border-start border-bottom border-white border-3">
                                            <div class="p-2" id="profileInfo">Profile info</div>
                                        </div>
                                    </div>
                                </div>

                                <?php if ($userRole === 'student') : ?>
                                    <div class="tab-pane fade" id="review-tab-pane" role="tabpanel" aria-labelledby="review-tab" tabindex="0">
                                        <h5 class="mb-3">Your Reviews</h5>
                                        <div class="row row-cols-lg-3 row-cols-md-2 row-cols-sm-1 row-cols-xs-1" id="reviews">

                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="booking-tab-pane" role="tabpanel" aria-labelledby="booking-tab" tabindex="0">
                                        <h5 class="mb-3">Your Bookings</h5>
                                        <div class="row row-cols-lg-3 row-cols-md-2 row-cols-sm-1 row-cols-xs-1" id="bookings">

                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="calendar-tab-pane" role="tabpanel" aria-labelledby="calendar-tab" tabindex="0">
                                        <div class="m-5" id="calendar"></div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../JS/user-profile.js"></script>

</body>

</html>