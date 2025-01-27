<?php
session_start();
require 'config.php';

// Function to check if a user is logged in
function isLoggedIn() {
    return isset($_SESSION['user']);
}

// Function to check user role
function isAdmin() {
    return isLoggedIn() && $_SESSION['user']['role'] === 'Admin';
}

// Redirect if not logged in
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit();
    }
}

// Redirect if not admin
function requireAdmin() {
    if (!isAdmin()) {
        header('Location: ../common/dashboard.php');
        exit();
    }
}
?>