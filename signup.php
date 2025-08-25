<?php
include 'connection.php';

$error_message = ""; // Initialize error message

if (isset($_POST['sign'])) {
    $username = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $gender = $_POST['gender'] ?? '';

    // Validate form fields
    if (empty($username) || empty($email) || empty($password) || empty($gender)) {
        $error_message = "All fields are required!";
    } elseif (!preg_match("/^[A-Za-z]+$/", $username)) {
        $error_message = "User name should only contain letters (A-Z, a-z)!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format!";
    } elseif (strlen($password) < 8 || strlen($password) > 15) {
        $error_message = "Password must be between 8 and 15 characters!";
    } else {
        // Hash password securely
        $pass = password_hash($password, PASSWORD_DEFAULT);

        // Check if email already exists using prepared statement
        $stmt = $connection->prepare("SELECT id FROM login WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error_message = "Account already exists!";
        } else {
            // Insert new user using prepared statement
            $insert_stmt = $connection->prepare("INSERT INTO login(name, email, password, gender) VALUES (?, ?, ?, ?)");
            $insert_stmt->bind_param("ssss", $username, $email, $pass, $gender);

            if ($insert_stmt->execute()) {
                header("Location: signin.php");
                exit;
            } else {
                $error_message = "Failed to save your data. Please try again.";
            }
        }

        $stmt->close();
        $insert_stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
     <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background: linear-gradient(135deg, #1a1a1a, #2c3e50);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            padding: 40px;
            width: 400px;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }
        .logo {
            font-size: 32px;
            font-weight: 600;
            color: #00ff88;
        }
        #heading {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #fff;
        }
        .error-message {
            color: #ff4444;
            font-size: 14px;
            margin-bottom: 15px;
        }
        .success-message {
            color: #00ff88;
            font-size: 14px;
            margin-bottom: 15px;
        }
        .input {
            margin-bottom: 20px;
            text-align: left;
        }
        .input label {
            font-size: 14px;
            color: #fff;
        }
        .input input {
            width: 100%;
            padding: 10px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 5px;
            margin-top: 5px;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }
        .radio {
            text-align: left;
            margin-bottom: 20px;
        }
        .radio label {
            font-size: 14px;
            color: #fff;
        }
        .btn button {
            width: 100%;
            padding: 10px;
            background: linear-gradient(135deg, #00ff88, #00c6ff);
            border: none;
            border-radius: 5px;
            color: #1a1a1a;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
        }
        .btn button:hover {
            background: linear-gradient(135deg, #00c6ff, #00ff88);
        }
        .signin-up {
            margin-top: 20px;
            font-size: 14px;
        }
        .signin-up p {
            color: #fff;
        }
        .signin-up a {
            color: #00ff88;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
    <script>
        function validateForm() {
            let name = document.getElementById('name').value.trim();
            let email = document.getElementById('email').value.trim();
            let password = document.getElementById('password').value;
            let gender = document.querySelector('input[name="gender"]:checked');
            let errorMessage = '';
            
            if (name === '' || email === '' || password === '' || !gender) {
                errorMessage = "All fields are required!";
            } else if (!/^[A-Za-z]+$/.test(name)) {
                errorMessage = "User name should only contain letters (A-Z, a-z)!";
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                errorMessage = "Invalid email format!";
            } else if (password.length < 8 || password.length > 15) {
                errorMessage = "Password must be between 8 and 15 characters!";
            }
            
            if (errorMessage !== '') {
                document.getElementById('error-message').innerText = errorMessage;
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <div class="container">
        <form id="registrationForm" action="" method="post" onsubmit="return validateForm()">
            <p class="logo">Food <span>Donate</span></p>
            <p id="heading">Create your account</p>

            <?php if (!empty($error_message)): ?>
                <div class="error-message" id="error-message"> <?php echo $error_message; ?> </div>
            <?php else: ?>
                <div class="error-message" id="error-message"></div>
            <?php endif; ?>

            <div class="input">
                <label for="name">User name</label>
                <input type="text" id="name" name="name" required />
            </div>

            <div class="input">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required />
            </div>

            <div class="input">
                <label for="password">Password (Min: 8 Max: 15)</label>
                <input type="password" id="password" name="password" required />
            </div>

            <div class="radio">
                <label><input type="radio" name="gender" value="male" required /> Male</label>
                <label><input type="radio" name="gender" value="female" /> Female</label>
                <label><input type="radio" name="gender" value="other" /> Other</label>
            </div>

            <div class="btn" style="display: flex; gap: 10px;">
                <button type="submit" name="sign" style="flex: 1;">Sign Up</button>
                <button type="button" onclick="history.back()" style="flex: 1; background: linear-gradient(135deg, #00ff88, #00c6ff); border: none; border-radius: 5px; color: #1a1a1a; font-size: 16px; font-weight: 600; cursor: pointer;">Back</button>
            </div>

            <div class="signin-up">
                <p>Already have an account? <a href="signin.php">Sign in</a></p>
            </div>
        </form>
    </div>
</body>
</html>
