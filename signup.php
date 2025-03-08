<?php
// Include the database connection
include('db_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirmpassword = mysqli_real_escape_string($conn, $_POST['confirmpassword']);
    $user_type = mysqli_real_escape_string($conn, $_POST['user_type']);
    
    // Check if passwords match
    if ($password !== $confirmpassword) {
        die("Passwords do not match.");
    }

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if the user type is 'customer'
    if ($user_type === "customer") {
        // Prepare the SQL statement to insert data into the customer table
        $sql = "INSERT INTO customer (f_name, l_name, email, password) 
                VALUES ('$firstname', '$lastname', '$email', '$hashed_password')";

        // Execute the query
        if ($conn->query($sql) === TRUE) {
            // Redirect to home.html if the customer is added successfully
            header("Location: Home.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Invalid user type.";
    }
}


?>