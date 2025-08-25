<?php
ob_start(); 

include '../connection.php';
include("connect.php"); 
if($_SESSION['name']==''){
    header("location:deliverylogin.php");
}
$name=$_SESSION['name'];
$id=$_SESSION['Did'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Orders</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        :root {
            --primary: #007BFF; /* Bright Blue */
            --secondary: #FF6F20; /* Vibrant Orange */
            --dark: #343A40; /* Dark Gray */
            --light: #F8F9FA; /* Light Gray */
            --gray: #CED4DA; /* Medium Gray */
            --shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: var(--light);
            color: var(--dark);
            line-height: 1.6;
        }

        header {
            background: var(--primary);
            color: var(--light);
            padding: 1rem 2rem;
            box-shadow: var(--shadow);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .nav-bar {
            display: flex;
            justify-content: flex-end;
        }

        .nav-bar ul {
            display: flex;
            list-style: none;
            gap: 1.5rem;
        }

        .nav-bar ul li a {
            color: var(--light);
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .nav-bar ul li a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .nav-bar ul li a.active {
            background: var(--secondary);
        }

        .main-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        .welcome-section {
            background: var(--secondary);
            color: var(--light);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: var(--shadow);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .welcome-text {
            flex: 1;
        }

        .welcome-text h1 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .welcome-text p {
            margin-bottom: 1rem;
        }

        .action-button {
            background: var(--primary);
            color: var(--light);
            padding: 0.75rem 1.5rem;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .action-button:hover {
            background: #0056b3; /* Darker Blue */
        }

        .orders-container {
            background: var(--light);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: var(--shadow);
        }

        .orders-title {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: var(--primary);
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .orders-table th {
            background: var(--primary);
            color: var(--light);
            padding: 1rem;
            text-align: left;
            font-weight: 600;
        }

        .orders-table td {
            padding: 1rem;
            border-bottom: 1px solid var(--gray);
            color: var(--dark);
        }

        .orders-table tr:hover {
            background: rgba(0, 123, 255, 0.1);
        }

        .empty-state {
            text-align: center;
            padding: 50px 20px;
            color: var(--dark);
        }

        .empty-state i {
            font-size: 48px;
            color: var(--primary);
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .welcome-section {
                flex-direction: column;
                text-align: center;
            }

            .nav-bar {
                flex-direction: column;
                align-items: center;
            }

            .nav-bar ul {
                flex-direction: column;
                padding: 10px;
            }

            .nav-bar ul li {
                margin: 5px 0;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">Food <b>Donate</b></div>
        <nav class="nav-bar">
            <ul>
                <li><a href="delivery.php">Home</a></li>
                <li><a href="openmap.php">Map</a></li>
                <li><a href="deliverymyord.php" class="active">My Orders</a></li>
            </ul>
        </nav>
    </header>

    <div class="main-container">
        <div class="welcome-section">
            <div class="welcome-text">
                <h1>Welcome, <?php echo htmlspecialchars($name); ?>!</h1>
                <p>Manage your delivery orders efficiently.</p>
                <a href="delivery.php" class="action-button">Take New Orders</a>
            </div>
            <img src="../img/delivery1.gif" alt="Delivery Animation" style="width: 150px; border-radius: 10px;">
        </div>

        <div class="orders-container">
            <h2 class="orders-title">Your Assigned Orders</h2>
            
            <?php
            $sql = "SELECT fd.Fid AS Fid, fd.name, fd.phoneno, fd.date, fd.delivery_by, fd.address as From_address, 
        ad.name AS delivery_person_name, ad.address AS To_address
        FROM food_donations fd
        LEFT JOIN admin ad ON fd.assigned_to = ad.Aid 
        WHERE fd.delivery_by = '$id'";

            $result = mysqli_query($connection, $sql);
            if (!$result) {
                die("Error executing query: " . mysqli_error($connection));
            }

            if (mysqli_num_rows($result) > 0) {
                echo '<table class="orders-table">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Name</th>';
                echo '<th>Phone Number</th>';
                echo '<th>Date/Time</th>';
                echo '<th>Pickup Address</th>';
                echo '<th>Delivery Address</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>'.htmlspecialchars($row['name']).'</td>';
                    echo '<td>'.htmlspecialchars($row['phoneno']).'</td>';
                    echo '<td>'.date('M d, Y H:i', strtotime($row['date'])).'</td>';
                    echo '<td>'.htmlspecialchars($row['From_address']).'</td>';
                    echo '<td>'.htmlspecialchars($row['To_address']).'</td>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
            } else {
                echo '<div class="empty-state">';
                echo '<i class="fas fa-inbox"></i>';
                echo '<p>No orders assigned yet. Take new orders to get started!</p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</body>
</html>