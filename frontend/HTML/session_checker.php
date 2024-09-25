<?php

function noUser()
{
    if (!isset($_SESSION["role"])) {
        header("Location: home.php");
        exit();
    }
}
function adminOnly()
{
    if (!isset($_SESSION["role"]) == "admin") {
        header("Location: home.php");
        exit();
    }
}
function trainerOnly()
{
    if (!isset($_SESSION["role"]) == "trainer" || !isset($_SESSION["role"]) == "admin") {
        header("Location: home.php");
        exit();
    }
}
