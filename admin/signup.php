<?php
include '../connection.php';
$msg = 0;
if (isset($_POST['sign'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $location = $_POST['district'];
    $address = $_POST['address'];

    $pass = password_hash($password, PASSWORD_DEFAULT);
    $sql = "SELECT * FROM admin WHERE email='$email'";
    $result = mysqli_query($connection, $sql);
    $num = mysqli_num_rows($result);
    if ($num == 1) {
        $msg = 1; // Set error message flag
    } else {
        $query = "INSERT INTO admin(name, email, password, location, address) VALUES('$username', '$email', '$pass', '$location', '$address')";
        $query_run = mysqli_query($connection, $query);
        if ($query_run) {
            header("location:signin.php");
        } else {
            echo '<script type="text/javascript">alert("Data not saved")</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <title>Register</title>
    <style>
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
        }

        .container {
            width: 100%;
            max-width: 450px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            transform: translateY(20px);
            opacity: 0;
            animation: fadeIn 0.5s ease-out forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .container .title {
            font-size: 28px;
            font-weight: 600;
            color: #e73c7e;
            text-align: center;
            position: relative;
            margin-bottom: 30px;
        }

        .container .title::before {
            content: '';
            position: absolute;
            left: 50%;
            bottom: -10px;
            transform: translateX(-50%);
            height: 3px;
            width: 50px;
            background-color: #e73c7e;
            border-radius: 5px;
        }

        .input-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
        }

        .input-group label {
            font-size: 16px;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }

        .input-group input,
        .input-group select,
        .input-group textarea {
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            padding: 12px;
            width: 100%;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .input-group input:focus,
        .input-group select:focus,
        .input-group textarea:focus {
            border-color: #23a6d5;
            outline: none;
            box-shadow: 0 0 0 2px rgba(35, 166, 213, 0.1);
        }

        .password-group {
            position: relative;
        }

        .password-group input {
            padding-right: 40px;
        }

        .password-group i {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            font-size: 20px;
            cursor: pointer;
            color: #999;
            transition: color 0.3s ease;
        }

        .password-group i:hover {
            color: #23a6d5;
        }

        .error-message {
            color: #ff3860;
            font-weight: bold;
            text-align: center;
            margin-bottom: 15px;
            padding: 10px;
            background-color: #ffeff1;
            border-radius: 5px;
            animation: shake 0.82s cubic-bezier(.36,.07,.19,.97) both;
        }

        @keyframes shake {
            10%, 90% { transform: translate3d(-1px, 0, 0); }
            20%, 80% { transform: translate3d(2px, 0, 0); }
            30%, 50%, 70% { transform: translate3d(-4px, 0, 0); }
            40%, 60% { transform: translate3d(4px, 0, 0); }
        }

        button {
            background-color: #23a6d5;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 14px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            margin: 20px 0;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        button:hover {
            background-color: #1c8ab1;
        }

        button:active {
            transform: scale(0.98);
        }

        button::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%);
            transform-origin: 50% 50%;
        }

        @keyframes ripple {
            0% {
                transform: scale(0, 0);
                opacity: 1;
            }
            20% {
                transform: scale(25, 25);
                opacity: 1;
            }
            100% {
                opacity: 0;
                transform: scale(40, 40);
            }
        }

        button:focus:not(:active)::after {
            animation: ripple 1s ease-out;
        }

        .login-signup {
            text-align: center;
            margin-top: 15px;
        }

        .login-signup a {
            color: #23a6d5;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .login-signup a:hover {
            color: #1c8ab1;
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .container {
                width: 90%;
                padding: 30px;
            }

            .container .title {
                font-size: 24px;
            }

            .input-group label {
                font-size: 14px;
            }

            .input-group input,
            .input-group select,
            .input-group textarea {
                font-size: 14px;
                padding: 10px;
            }

            button {
                font-size: 16px;
                padding: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="" method="post" id="form">
            <h2 class="title">Register</h2>
            <?php
            if ($msg == 1) {
                echo '<p class="error-message">Account already exists</p>';
            }
            ?>
            <div class="input-group">
                <label for="username">Name</label>
                <input type="text" id="username" name="username" required />
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required />
            </div>
            <div class="input-group password-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required />
                <i class="uil uil-eye-slash" id="showpassword"></i>
            </div>
            <div class="input-group">
                <label for="address">Address</label>
                <textarea id="address" name="address" required></textarea>
            </div>
            <div class="input-group">
                <label for="district">Please Select Area</label>
                <select id="district" name="district">
                    <option value="andheri">Andheri</option>
                    <option value="marine drive">Marine Drive</option>
                    <option value="bandra">Bandra</option>
                    <option value="juhu">Juhu</option>
                    <option value="pawai">Pawai</option>
                    <option value="goregaon">Goregaon</option>
                    <option value="malad">Malad</option>
                    <option value="sakinaka">Sakinaka</option>
                    <option value="kurla">Kurla</option>
                    <option value="chakala">Chakala</option>
                    <option value="dadar">Dadar</option>
                    <option value="borivali">Borivali</option>
                    <option value="vashi">Vashi</option>
                    <option value="chembur">Chembur</option>
                    <option value="lower parel">Lower Parel</option>
                </select>
            </div>
            <button type="submit" name="sign">Register</button>
            <div class="login-signup">
                <span class="text">Already a member?
                    <a href="signin.php" class="login-link">Login Now</a>
                </span>
            </div>
        </form>
    </div>
    <script>
        document.getElementById("showpassword").addEventListener("click", function () {
            const passwordField = document.getElementById("password");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                this.classList.replace("uil-eye-slash", "uil-eye");
            } else {
                passwordField.type = "password";
                this.classList.replace("uil-eye", "uil-eye-slash");
            }
        });

        // Add animation to form inputs
        const inputs = document.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.style.transform = 'scale(1.05)';
            });
            input.addEventListener('blur', function() {
                this.style.transform = 'scale(1)';
            });
        });

        // Add ripple effect to button
        const button = document.querySelector('button');
        button.addEventListener('click', function(e) {
            let x = e.clientX - e.target.offsetLeft;
            let y = e.clientY - e.target.offsetTop;
            let ripple = document.createElement('span');
            ripple.style.left = `${x}px`;
            ripple.style.top = `${y}px`;
            this.appendChild(ripple);
            setTimeout(function() {
                ripple.remove();
            }, 600);
        });
    </script>
</body>
</html>

