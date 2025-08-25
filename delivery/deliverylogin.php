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

  $sql = "SELECT * FROM delivery_persons WHERE email='$sanitized_emailid'";
  $result = mysqli_query($connection, $sql);
  $num = mysqli_num_rows($result);
 
  if ($num == 1) {
    while ($row = mysqli_fetch_assoc($result)) {
      if (password_verify($sanitized_password, $row['password'])) {
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $row['name'];
        $_SESSION['Did'] = $row['Did'];
        $_SESSION['city'] = $row['city'];
        header("location:delivery.php");
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Delivery Login</title>
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
    }
    .container {
        position: relative;
        width: 256px;
        height: 256px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .container span {
        position: absolute;
        left: 0;
        width: 32px;
        height: 6px;
        background: #2c4766;
        border-radius: 8px;
        transform-origin: 128px;
        transform: scale(2.2) rotate(calc(var(--i) * (360deg / 50)));
        animation: animateBlink 3s linear infinite;
        animation-delay: calc(var(--i) * (3s / 50));
    }
    @keyframes animateBlink {
        0% {
            background: #0ef;
        }
        25% {
            background: #2c4766;
        }
    }
    .login-box {
        position: absolute;
        width: 400px;
    }
    .login-box form {
        width: 100%;
        padding: 0 50px;
    }
    h2 {
        font-size: 2em;
        color: #0ef;
        text-align: center;
    }
    .input-box {
        position: relative;
        margin: 25px 0;
    }
    .input-box input {
        width: 100%;
        height: 50px;
        background: transparent;
        border: 2px solid #2c4766;
        outline: none;
        border-radius: 40px;
        font-size: 1em;
        color: #fff;
        padding: 0 20px;
        transition: .5s ease;
    }
    .input-box input:focus,
    .input-box input:valid {
        border-color: #0ef;
    }
    .input-box label {
        position: absolute;
        top: 50%;
        left: 20px;
        transform: translateY(-50%);
        font-size: 1em;
        color: #fff;
        pointer-events: none;
        transition: .5s ease;
    }
    .input-box input:focus~label,
    .input-box input:valid~label {
        top: 1px;
        font-size: .8em;
        background: #1f293a;
        padding: 0 6px;
        color: #0ef;
    }
    .forgot-pass {
        margin: -15px 0 10px;
        text-align: center;
    }
    .forgot-pass a {
        font-size: .85em;
        color: #fff;
        text-decoration: none;
    }
    .forgot-pass a:hover {
        text-decoration: underline;
    }
    .btn {
        width: 100%;
        height: 45px;
        background: #0ef;
        border: none;
        outline: none;
        border-radius: 40px;
        cursor: pointer;
        font-size: 1em;
        color: #1f293a;
        font-weight: 600;
    }
    .signup-link {
        margin: 20px 0 10px;
        text-align: center;
    }
    .signup-link a {
        font-size: 1em;
        color: #0ef;
        text-decoration: none;
        font-weight: 600;
    }
    .signup-link a:hover {
        text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="login-box">
      <h2>Delivery Login</h2>
      <?php
      if ($account_error) {
          echo "<p class='error-message'>$account_error</p>";
      }
      ?>
      <form method="post">
        <div class="input-box">
          <input type="email" name="email" required/>
          <label>Email</label>
        </div>
        <div class="input-box">
          <input type="password" name="password" required/>
          <label>Password</label>
        </div>
        <?php
        if($msg == 1){
          echo '<p class="error-message">Password does not match.</p>';
        }
        ?>
        <button type="submit" class="btn" name="sign">Login</button>
        <div class="signup-link">
          <h4 style="color:#E52020;"><b> Not a Member?</b></h4> <a href="deliverysignup.php">Signup</a>
        </div>
      </form>
    </div>
    <?php
    for ($i = 0; $i < 50; $i++) {
      echo "<span style=\"--i:$i;\"></span>";
    }
    ?>
  </div>
</body>
</html>