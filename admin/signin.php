<?php
session_start();
include '../connection.php';
$msg = 0;
$account_error = '';

if (isset($_POST['sign'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sanitized_emailid =  mysqli_real_escape_string($connection, $email);
    $sanitized_password =  mysqli_real_escape_string($connection, $password);

    $sql = "SELECT * FROM admin WHERE email='$sanitized_emailid'";
    $result = mysqli_query($connection, $sql);
    $num = mysqli_num_rows($result);
 
    if ($num == 1) {
        while ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($sanitized_password, $row['password'])) {
                $_SESSION['email'] = $email;
                $_SESSION['name'] = $row['name'];
                $_SESSION['location'] = $row['location'];
                $_SESSION['Aid'] = $row['Aid'];
                header("location:admin.php");
            } else {
                $msg = 1;
            }
        }
    } else {
        $account_error = "Account does not exist";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');
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
            background: #1f293a;
            overflow: hidden;
        }
        .container {
            position: relative;
            width: 400px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 6px;
            overflow: hidden;
            z-index: 10;
            backdrop-filter: blur(15px);
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            border-left: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 5px 5px 30px rgba(0, 0, 0, 0.2);
        }
        .container .form {
            padding: 40px;
        }
        .container h2 {
            font-size: 2em;
            color: #0ef;
            text-align: center;
            margin-bottom: 30px;
        }
        .input-box {
            position: relative;
            width: 100%;
            margin-top: 20px;
        }
        .input-box input {
            width: 100%;
            padding: 10px 0;
            font-size: 1em;
            color: #fff;
            letter-spacing: 1px;
            margin-bottom: 30px;
            border: none;
            border-bottom: 1px solid #fff;
            outline: none;
            background: transparent;
        }
        .input-box label {
            position: absolute;
            top: 0;
            left: 0;
            padding: 10px 0;
            font-size: 1em;
            color: #fff;
            pointer-events: none;
            transition: .5s;
        }
        .input-box input:focus ~ label,
        .input-box input:valid ~ label {
            top: -20px;
            left: 0;
            color: #0ef;
            font-size: 12px;
        }
        .forgot-pass {
            display: flex;
            justify-content: space-between;
            margin: -15px 0 15px;
        }
        .forgot-pass a {
            color: #fff;
            font-size: 14px;
            text-decoration: none;
        }
        .forgot-pass a:hover {
            text-decoration: underline;
        }
        input[type="submit"] {
            background: #0ef;
            color: #1f293a;
            border: none;
            outline: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 1em;
            font-weight: 600;
            width: 100%;
            margin-top: 20px;
        }
        .signup-link {
            color: #fff;
            text-align: center;
            margin: 20px 0 10px;
            font-size: 14px;
        }
        .signup-link a {
            color: #0ef;
            text-decoration: none;
            font-weight: 600;
        }
        .signup-link a:hover {
            text-decoration: underline;
        }
        .error-message {
            color: #ff3333;
            text-align: center;
            margin-bottom: 15px;
        }
        .background-animation {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            overflow: hidden;
            z-index: -1;
        }
        .background-animation span {
            position: absolute;
            display: block;
            width: 20px;
            height: 20px;
            background: rgba(255, 255, 255, 0.1);
            animation: animate 25s linear infinite;
            bottom: -150px;
        }
        .background-animation span:nth-child(5n) {
            background: #ff2d75;
            box-shadow: 0 0 0 10px #ff2d7544, 0 0 50px #ff2d75, 0 0 100px #ff2d75;
        }
        .background-animation span:nth-child(5n+1) {
            background: #4fc3dc;
            box-shadow: 0 0 0 10px #4fc3dc44, 0 0 50px #4fc3dc, 0 0 100px #4fc3dc;
        }
        .background-animation span:nth-child(5n+2) {
            background: #ffeb3b;
            box-shadow: 0 0 0 10px #ffeb3b44, 0 0 50px #ffeb3b, 0 0 100px #ffeb3b;
        }
        .background-animation span:nth-child(5n+3) {
            background: #ff7675;
            box-shadow: 0 0 0 10px #ff767544, 0 0 50px #ff7675, 0 0 100px #ff7675;
        }
        .background-animation span:nth-child(5n+4) {
            background: #00cec9;
            box-shadow: 0 0 0 10px #00cec944, 0 0 50px #00cec9, 0 0 100px #00cec9;
        }
        @keyframes animate {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 1;
                border-radius: 0;
            }
            100% {
                transform: translateY(-1000px) rotate(720deg);
                opacity: 0;
                border-radius: 50%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form">
            <h2>Login</h2>
            <form action="" method="post">
                <?php
                if ($account_error) {
                    echo "<p class='error-message'>$account_error</p>";
                }
                ?>
                <div class="input-box">
                    <input type="text" name="email" required>
                    <label>Email</label>
                </div>
                <div class="input-box">
                    <input type="password" name="password" required class="<?php echo $msg == 1 ? 'error' : ''; ?>">
                    <label>Password</label>
                </div>
                <?php
                if($msg == 1){
                    echo '<p class="error-message">Password doesn\'t match.</p>';
                }
                ?>
                <div class="forgot-pass">
                    <a href="#">Forgot Password?</a>
                </div>
                <input type="submit" name="sign" value="Login">
                <div class="signup-link">
                    Don't have an account? <a href="signup.php">Register</a>
                </div>
            </form>
        </div>
    </div>
   </body>
</html>