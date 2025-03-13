<?php
// Prevent caching so that logged-in users never see an old page.
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

session_start();
// If user is already logged in, redirect to Home.php
if (isset($_SESSION['user_id'])) {
    header("Location: Home.php");
    exit();
}

include('db_connection.php'); // Ensure this file sets up $conn correctly

// --- Process Sign-up ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $firstname        = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname         = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email            = mysqli_real_escape_string($conn, $_POST['email']);
    $password         = mysqli_real_escape_string($conn, $_POST['password']);
    $confirmpassword  = mysqli_real_escape_string($conn, $_POST['confirmpassword']);
    $user_type        = mysqli_real_escape_string($conn, $_POST['user_type']);
    
    if ($password !== $confirmpassword) {
        echo "<script>alert('Passwords do not match. Please try again.'); window.location.href='signup.php';</script>";
        exit();
    }    
    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Check if email already exists in ServiceProvider to avoid duplicates
    $checkEmailSql = "SELECT * FROM ServiceProvider WHERE email = '$email'";
    $result = $conn->query($checkEmailSql);
    if ($result->num_rows > 0) {
        die("Error: Email already exists in the system.");
    }
    
    if ($user_type === "customer") {
        $sql = "INSERT INTO Customer (f_name, l_name, email, password) 
                VALUES ('$firstname', '$lastname', '$email', '$hashed_password')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>
                    alert('Registration successful! You can now log in.');
                    window.location.href = 'signup.php?form=login';
                  </script>";
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif ($user_type === "worker") {
        $sql = "INSERT INTO ServiceProvider (f_name, l_name, email, password) 
                VALUES ('$firstname', '$lastname', '$email', '$hashed_password')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>
                    alert('Registration successful! You can now log in.');
                    window.location.href = 'signup.php?form=login';
                  </script>";
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }    
}

// --- Process Login ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['pswd']);
    
    // Hardcoded admin check
    if ($email === "admin@gmail.com" && $password === "password") {
        $_SESSION['user_id']    = "admin"; // Use a unique ID for admin
        $_SESSION['user_email'] = "admin@gmail.com";
        $_SESSION['user_name']  = "Admin";
        $_SESSION['user_type']  = 'admin';
        
        echo "<script>
                alert('Admin login successful!');
                window.location.href = 'admin.php';
              </script>";
        exit();
    }

    // Check in Customer table (for customers)
    $customerSql    = "SELECT * FROM Customer WHERE email = '$email'";
    $customerResult = $conn->query($customerSql);
    
    if ($customerResult->num_rows > 0) {
        $customer = $customerResult->fetch_assoc();
        if (password_verify($password, $customer['password'])) {
            $_SESSION['user_id']    = $customer['c_id'];
            $_SESSION['user_email'] = $customer['email'];
            $_SESSION['user_name']  = $customer['f_name'];
            $_SESSION['user_type']  = 'customer';
            
            header("Location: Home.php");
            exit();
        } else {
            echo "<script>
                    alert('Invalid password. Please try again.');
                    window.location.href = 'signup.php?form=login';
                  </script>";
            exit();
        }
    } else {
        // Check in ServiceProvider table (for workers)
        $workerSql    = "SELECT * FROM ServiceProvider WHERE email = '$email'";
        $workerResult = $conn->query($workerSql);
        
        if ($workerResult->num_rows > 0) {
            $worker = $workerResult->fetch_assoc();
            if (password_verify($password, $worker['password'])) {
                $_SESSION['user_id']    = $worker['sp_id'];
                $_SESSION['user_email'] = $worker['email'];
                $_SESSION['user_name']  = $worker['f_name'];
                $_SESSION['user_type']  = 'worker';
                
                header("Location: SPProfile.php");
                exit();
            } else {
                echo "<script>
                        alert('Invalid password. Please try again.');
                        window.location.href = 'signup.php?form=login';
                      </script>";
                exit();
            }
        } else {
            echo "<script>
                    alert('User not found. Please check your email or sign up.');
                    window.location.href = 'signup.php?form=login';
                  </script>";
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Slide Navbar</title>
    <link rel="stylesheet" type="text/css" href="signup.css">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
</head>
<body>
    <div class="main">
        <!-- Hidden checkbox toggles between signup and login forms -->
        <input type="checkbox" id="chk" aria-hidden="true">
        <div class="signup">
            <form action="signup.php" method="POST">
                <label for="chk" aria-hidden="true">Sign up</label>
                <input type="text" name="firstname" placeholder="First Name" required="">
                <input type="text" name="lastname" placeholder="Last Name" required="">
                <input type="email" name="email" placeholder="Email" required="">
                <input type="password" name="password" placeholder="Password" required="">
                <input type="password" name="confirmpassword" placeholder="Confirm Password" required="">
                <select name="user_type" required="">
                    <option value="customer">Customer</option>
                    <option value="worker">Worker</option>
                </select>
                <button type="submit" name="signup">Sign up</button>
            </form>
        </div>
        
        <div class="login">
            <form action="signup.php" method="POST">
                <label for="chk" aria-hidden="true">Login</label>
                <input type="email" name="email" placeholder="Email" required="">
                <input type="password" name="pswd" placeholder="Password" required="">
                <button type="submit" name="login">Login</button>
            </form>
        </div>
    </div>
    
    <!-- Toggle to show login form if URL contains ?form=login -->
    <script>
       window.onload = function() {
         const params = new URLSearchParams(window.location.search);
         if (params.get('form') === 'login') {
           document.getElementById('chk').checked = true;
         }
       };
    </script>
</body>
</html>