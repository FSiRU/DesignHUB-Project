<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up • DesignHUB</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="main">
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-image">
                        <figure>
                            <img src="https://colorlib.com/etc/regform/colorlib-regform-7/images/signup-image.jpg" alt="sign up image">
                        </figure>
                        <a href="login.php" class="signup-image-link">Already have an account</a>
                    </div>
                    <div class="signup-form">
                        <h2 class="form-title">Sign up</h2>
                        <form action="" method="POST" class="register-form" id="register-form">
                            <div class="form-group">
                                <label for="name">
                                    <i class="zmdi zmdi-account material-icons-name"></i>
                                </label>
                                <input type="text" name="name" id="name" placeholder="Your Name" required>
                            </div>
                            <div class="form-group">
                                <label for="email">
                                    <i class="zmdi zmdi-email"></i>
                                </label>
                                <input type="email" name="email" id="email" placeholder="Your Email" pattern="[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com)$" title="Please enter a valid email address" required>
                            </div>
                            <div class="form-group">
                                <label for="pass">
                                    <i class="zmdi zmdi-lock"></i>
                                </label>
                                <input type="password" name="password" id="pass" placeholder="Password" required>
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
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Register">
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
        document.getElementById('register-form').addEventListener('submit', function(event) {
            var emailField = document.getElementById('email');
            var emailPattern = /^[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com)$/;
            if (!emailPattern.test(emailField.value)) {
                alert('Please enter a valid email address.');
                emailField.focus();
                event.preventDefault();
            }
        });
    </script>

    <?php
    // Enable error reporting for debugging
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $servername = "localhost";
    $username = "root";
    $password = "root"; // Use the confirmed MAMP password
    $dbname = "my_notes";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if all required fields are set
        if (isset($_POST['name'], $_POST['email'], $_POST['password'], $_POST['user_account'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $user_account = $_POST['user_account'];

            // Use prepared statements to prevent SQL injection
            $stmt = $conn->prepare("INSERT INTO user_data (name, email, password, user_account) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $email, $password, $user_account);

            if ($stmt->execute()) {
                echo "<script>alert('Registration successful!'); window.location.href = 'login.php';</script>";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "All fields are required.";
        }
    }

    $conn->close();
    ?>
</body>
</html>
