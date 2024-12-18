<?php
// Include database connection
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $phoneNo = $_POST['phoneNo'];
    $email = $_POST['email'];
    $password = password_hash($_POST['create password'], PASSWORD_BCRYPT);
    $password = password_hash($_POST['confirm password'], PASSWORD_BCRYPT); // Hash the password for security

    // Check if email already exists
    $sql_check = "SELECT * FROM users WHERE email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo "Email already registered!";
    } else {
        // Insert new user
        $sql_insert = "INSERT INTO users (firstname, email, password) VALUES (?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("sss", $username, $email, $password);

        if ($stmt_insert->execute()) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $stmt_insert->error;
        }
    }

    $stmt_check->close();
    $stmt_insert->close();
    $conn->close();
}
?>
