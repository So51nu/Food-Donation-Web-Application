<?php
include '../connection.php';
$msg = 0;
$account_exists = false;

if(isset($_POST['sign']))
{
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $location = $_POST['district'];

    $pass = password_hash($password, PASSWORD_DEFAULT);
    $sql = "SELECT * FROM delivery_persons WHERE email='$email'";
    $result = mysqli_query($connection, $sql);
    $num = mysqli_num_rows($result);
    
    if($num == 1){
        $account_exists = true;
    } else {
        $query = "INSERT INTO delivery_persons(name, email, password, city) VALUES ('$username', '$email', '$pass', '$location')";
        $query_run = mysqli_query($connection, $query);
        if($query_run)
        {
            header("location:delivery.php");
        }
        else{
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
    <title>Delivery Person Registration</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .container {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            width: 400px;
            padding: 40px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-weight: 600;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: 500;
        }

        .input-group input,
        .input-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .input-group input:focus,
        .input-group select:focus {
            border-color: #667eea;
            outline: none;
        }

        .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            width: 100%;
            font-size: 16px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-3px);
        }

        .error-message {
            color: #d93025;
            text-align: center;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .signup-link {
            text-align: center;
            margin-top: 20px;
            color: #555;
        }

        .signup-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .container {
                width: 90%;
                padding: 30px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Register as Delivery Person</h1>
        <?php
        if($account_exists){
            echo '<p class="error-message">Account already exists</p>';
        }
        ?>
        <form method="post" action="">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required/>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required/>
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required/>
            </div>
            <div class="input-group">
                <label for="district">District</label>
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
            <button type="submit" name="sign" class="btn">Register</button>
            <div class="signup-link">
                Already a member? <a href="deliverylogin.php">Sign in</a>
            </div>
        </form>
    </div>
</body>
</html>

