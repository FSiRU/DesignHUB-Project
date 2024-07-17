<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in • DesignHUB</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="main">
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure>
                            <img src="https://colorlib.com/etc/regform/colorlib-regform-7/images/signin-image.jpg" alt="sign in image">
                        </figure>
                        <a href="sign up.php" class="signup-image-link">Create an account</a>
                    </div>
                    <div class="signin-form">
                        <h2 class="form-title">Sign in</h2>
                        <form method="POST" action="" class="register-form" id="login-form">
                            <div class="form-group">
                                <label for="your_email">
                                    <i class="zmdi zmdi-account material-icons-name"></i>
                                </label>
                                <input type="email" name="email" id="your_email" placeholder="Your Email" pattern="[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com)$" title="Please enter a valid email address" required />
                            </div>
                            <div class="form-group">
                                <label for="your_pass">
                                    <i class="zmdi zmdi-lock"></i>
                                </label>
                                <input type="password" name="password" id="your_pass" placeholder="Password" required />
                            </div>
                            <div class="form-group">
                                <label for="user_account">
                                    <i class="zmdi zmdi-account-box"></i>
                                </label>
                                <select name="user_account" id="user_account" required>
                                    <option value="" disabled selected>Select User account</option>
                                    <option value="student">Student</option>
                                    <option value="lecturer">Lecturer</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Log in" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <footer class="footer">
        <p>&copy; 2024 DesignHUB. All rights reserved.</p>
    </footer>

    <script>
        document.getElementById('login-form').addEventListener('submit', function(event) {
            var emailField = document.getElementById('your_email');
            var emailPattern = /^[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com)$/;
            if (!emailPattern.test(emailField.value)) {
                alert('Please enter a valid email address.');
                emailField.focus();
                event.preventDefault();
            }
        });
    </script>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "my_notes";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user_account = $_POST['user_account'];

    $stmt = $conn->prepare("SELECT * FROM user_data WHERE email = ? AND user_account = ?");
    $stmt->bind_param("ss", $email, $user_account);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Check the password if user exists
        $row = $result->fetch_assoc();
        if ($row['password'] == $password) {
            echo "<script>alert('Login successful!'); window.location.href = 'index.html';</script>";
        } else {
            echo "<script>alert('Login failed! Please check your password.'); window.location.href = 'login.php';</script>";
        }
    } else {
        echo "<script>alert('Login failed! Please check your user account.'); window.location.href = 'login.php';</script>";
    }

    $stmt->close();
}

$conn->close();
?>

</body>
</html>
