<?php
require 'includes/config.php'; // Include the database connection
session_start();
include "header.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role_id = $_POST['role']; // Role ID from the dropdown

    // Check if email already exists
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query); // $conn is from config.php
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error = "Email is already registered.";
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insert user into the database
        $query = "INSERT INTO users (name, email, password, role_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sssi', $name, $email, $hashedPassword, $role_id);

        if ($stmt->execute()) {
            $success = "Registration successful. You can now log in.";
        } else {
            $error = "Registration failed. Please try again.";
        }
    }
}
?>


<body>
    <div class="container col-md-6">
    <form method="POST">
        <h2>Register</h2>
        <div class="form-group">
        <label for="name">Full Name:</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="Enter your name" required>
        </div>
         <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email"  class="form-control" placeholder="Enter your email" required>
        </div>
         <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" required>
        </div>
         <div class="form-group">
        <label for="role">Select Role:</label>
        <select name="role" id="role" class="form-control" required>
            <?php
            // Fetch roles from the database using MySQLi
            $query = "SELECT * FROM roles";
            $result = $conn->query($query);

            while ($role = $result->fetch_assoc()) {
                echo "<option value='{$role['id']}'>{$role['role_name']}</option>";
            }
            ?>
        </select>
        </div>
        <button type="submit">Register</button>
        <?php 
        if (isset($success)) echo "<p style='color:green;'>$success</p>";
        if (isset($error)) echo "<p style='color:red;'>$error</p>";
        ?>
    </form>

    <p>Already registered? <a href="login.php">Login here</a>.</p>
    </div>
</body>

