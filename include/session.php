<?php
// Start or resume a session
session_start();

// Function to check if a user is logged in
function isUserLoggedIn()
{
    return isset($_SESSION['loggedin']);
}

// Function to set a user as logged in
function setUserLoggedIn($user_id, $username)
{
    $_SESSION['loggedin'] = true;
    $_SESSION['user_id'] = $user_id;
    $_SESSION['username'] = $username;
}

// Function to get the user's ID
function getUserId()
{
    if (isUserLoggedIn()) {
        return $_SESSION['user_id'];
    } else {
        return null;
    }
}

// Function to log out the user
function logout()
{
    session_unset();
    session_destroy();
}
