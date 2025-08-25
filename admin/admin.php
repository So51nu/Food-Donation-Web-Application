<?php
ob_start();
include("connect.php");
if ($_SESSION['name'] == '') {
    header("location:signin.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #06C167;
            --secondary-color: #0E4BF1;
            --background-color: #f0f8ff;
            --text-color: #333;
            --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background-color: var(--background-color);
            color: var(--text-color);
        }
        .dashboard {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            background-color: #fff;
            padding: 20px;
            box-shadow: var(--box-shadow);
        }
        .logo {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 30px;
        }
        .nav-links {
            list-style: none;
        }
        .nav-links li {
            margin-bottom: 15px;
        }
        .nav-links a {
            text-decoration: none;
            color: var(--text-color);
            font-size: 16px;
            display: flex;
            align-items: center;
        }
        .nav-links a i {
            margin-right: 10px;
            font-size: 18px;
        }
        .nav-links a:hover {
            color: var(--primary-color);
        }
        .main-content {
            flex: 1;
            padding: 30px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 28px;
            color: var(--primary-color);
        }
        .user-info {
            display: flex;
            align-items: center;
        }
        .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: var(--box-shadow);
            text-align: center;
        }
        .stat-card h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .stat-card p {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-color);
        }
        .recent-donations {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: var(--box-shadow);
        }
        .recent-donations h2 {
            font-size: 20px;
            margin-bottom: 20px;
            color: var(--primary-color);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            font-weight: 600;
        }
        .btn {
            padding: 8px 12px;
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #05a057;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <div class="sidebar">
            <div class="logo">Food Donate</div>
            <ul class="nav-links">
                <li><a href="#"><i class="fas fa-home"></i>Dashboard</a></li>
                <li><a href="analytics.php"><i class="fas fa-chart-bar"></i>Analytics</a></li>
                <li><a href="donate.php"><i class="fas fa-hand-holding-heart"></i>Donations</a></li>
                <li><a href="feedback.php"><i class="fas fa-comments"></i>Feedbacks</a></li>
                <li><a href="adminprofile.php"><i class="fas fa-user"></i>Profile</a></li>
                <li><a href="../logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
            </ul>
        </div>
        <div class="main-content">
            <div class="header">
                <h1>Admin Dashboard</h1>
                <div class="user-info">
                    <img src="2.webp" alt="Admin">
                    <span><?php echo $_SESSION['name']; ?></span>
                </div>
            </div>
            <div class="stats">
                <div class="stat-card">
                    <h3>Total Users</h3>
                    <?php
                    $query = "SELECT COUNT(*) as count FROM login";
                    $result = mysqli_query($connection, $query);
                    $row = mysqli_fetch_assoc($result);
                    echo "<p>" . $row['count'] . "</p>";
                    ?>
                </div>
                <div class="stat-card">
                    <h3>Total Feedbacks</h3>
                    <?php
                    $query = "SELECT COUNT(*) as count FROM user_feedback";
                    $result = mysqli_query($connection, $query);
                    $row = mysqli_fetch_assoc($result);
                    echo "<p>" . $row['count'] . "</p>";
                    ?>
                </div>
                <div class="stat-card">
                    <h3>Total Donations</h3>
                    <?php
                    $query = "SELECT COUNT(*) as count FROM food_donations";
                    $result = mysqli_query($connection, $query);
                    $row = mysqli_fetch_assoc($result);
                    echo "<p>" . $row['count'] . "</p>";
                    ?>
                </div>
                <div class="stat-card">
                    <h3>Pending Donations</h3>
                    <?php
                    $query = "SELECT COUNT(*) as count FROM food_donations WHERE assigned_to IS NULL";
                    $result = mysqli_query($connection, $query);
                    $row = mysqli_fetch_assoc($result);
                    echo "<p>" . $row['count'] . "</p>";
                    ?>
                </div>
            </div>
            <div class="recent-donations">
                <h2>Recent Donations</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Food</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Date/Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM food_donations ORDER BY date DESC LIMIT 5";
                        $result = mysqli_query($connection, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . $row['food'] . "</td>";
                            echo "<td>" . $row['category'] . "</td>";
                            echo "<td>" . $row['quantity'] . "</td>";
                            echo "<td>" . $row['date'] . "</td>";
                            echo "<td>";
                            if ($row['assigned_to'] == null) {
                                echo "<form method='post' action=''>";
                                echo "<input type='hidden' name='order_id' value='" . $row['Fid'] . "'>";
                                echo "<button type='submit' name='assign_food' class='btn'>Assign</button>";
                                echo "</form>";
                            } else {
                                echo "Assigned";
                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</body>
</html>
<?php
if (isset($_POST['assign_food'])) {
    $order_id = $_POST['order_id'];
    $admin_id = $_SESSION['Aid'];
    $sql = "UPDATE food_donations SET assigned_to = $admin_id WHERE Fid = $order_id";
    $result = mysqli_query($connection, $sql);
    if ($result) {
        echo "<script>alert('Donation assigned successfully!');</script>";
        echo "<script>window.location.href = 'admin.php';</script>";
    } else {
        echo "<script>alert('Error assigning donation. Please try again.');</script>";
    }
}
ob_end_flush();
?>

