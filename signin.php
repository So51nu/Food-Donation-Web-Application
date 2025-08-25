<?php
session_start();
include 'connection.php';

$msg = 0; 
$account_not_exist = false;

if (isset($_POST['sign'])) {
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);

    $sql = "SELECT * FROM login WHERE email='$email'";
    $result = mysqli_query($connection, $sql);
    $num = mysqli_num_rows($result);

    if ($num == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $row['name'];
            $_SESSION['gender'] = $row['gender'];
            header("Location: home.html");
            exit();
        } else {
            $msg = 1; // Incorrect password
        }
    } else {
        $account_not_exist = true; // Account does not exist
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Food Donate</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;900&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #1f293a, #0c0f15);
            overflow: hidden;
        }

        .container {
            width: 400px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            color: #00ff88;
            text-align: center;
            margin-bottom: 20px;
            font-size: 2em;
            animation: slideIn 1s ease-in-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .input-box {
            position: relative;
            margin: 20px 0;
        }

        .input-box input {
            width: 100%;
            height: 50px;
            border: none;
            outline: none;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            color: #fff;
            padding: 0 20px;
            font-size: 1em;
            transition: all 0.3s ease;
        }

        .input-box input:focus {
            border-color: #00ff88;
            box-shadow: 0 0 10px rgba(0, 255, 136, 0.5);
        }

        .input-box label {
            position: absolute;
            top: 50%;
            left: 20px;
            transform: translateY(-50%);
            font-size: 0.9em;
            color: #aaa;
            pointer-events: none;
            transition: all 0.3s ease;
        }

        .input-box input:focus~label,
        .input-box input:valid~label {
            top: 5px;
            font-size: 0.8em;
            color: #00ff88;
        }

        .btn {
            width: 100%;
            height: 50px;
            background: linear-gradient(135deg, #00ff88, #00c6ff);
            border: none;
            border-radius: 25px;
            color: #1f293a;
            font-size: 1em;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background: linear-gradient(135deg, #00c6ff, #00ff88);
            transform: scale(1.05);
        }

        .error {
            color: #ff4d4d;
            text-align: center;
            margin-top: 10px;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% {
                transform: translateX(0);
            }
            25%, 75% {
                transform: translateX(-10px);
            }
            50% {
                transform: translateX(10px);
            }
        }

        .signup-link {
            text-align: center;
            margin-top: 20px;
            color: #aaa;
        }

        .signup-link a {
            color: #00ff88;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .signup-link a:hover {
            color: #00c6ff;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Sign In</h2>
        <form id="loginForm" action="" method="post">
            <div class="input-box">
                <input type="email" name="email" required>
                <label>Email</label>
            </div>
            <div class="input-box">
                <input type="password" name="password" id="password" required>
                <label>Password</label>
            </div>
            <?php if ($msg == 1) : ?>
                <p class="error">Incorrect password. Please try again.</p>
            <?php endif; ?>
            <?php if ($account_not_exist) : ?>
                <p class="error">Account does not exist. Please register.</p>
            <?php endif; ?>
            <button type="submit" name="sign" class="btn">Login</button>
            <div class="signup-link">
                <p>Don't have an account? <a href="signup.php">Register</a></p>
            </div>
        </form>
    </div>

    <script>
        // JavaScript for form validation and animations
        document.getElementById('loginForm').addEventListener('submit', function (event) {
            const email = document.querySelector('input[name="email"]').value;
            const password = document.querySelector('input[name="password"]').value;

            if (!email || !password) {
                event.preventDefault(); // Prevent form submission
                alert('Please fill in all fields.');
            }
        });

        // Add animation to input fields on focus
        const inputs = document.querySelectorAll('.input-box input');
        inputs.forEach(input => {
            input.addEventListener('focus', () => {
                input.parentElement.style.transform = 'scale(1.02)';
                input.parentElement.style.transition = 'transform 0.3s ease';
            });

            input.addEventListener('blur', () => {
                input.parentElement.style.transform = 'scale(1)';
            });
        });
    </script>
</body>

</html>