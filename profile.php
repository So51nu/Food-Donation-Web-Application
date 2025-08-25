<?php
include("login.php"); 
if($_SESSION['name']==''){
    header("location: signup.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Food Donate</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        :root {
            --primary-color: #06C167;
            --secondary-color: #FFA000;
            --background-color: #F5F5F5;
            --text-color: #333;
            --card-bg-color: #FFFFFF;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            background-color: var(--background-color);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        header {
            background-color: var(--card-bg-color);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
        }

        .logo {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-color);
        }

        .logo b {
            color: var(--primary-color);
        }

        .nav-links {
            display: flex;
            list-style: none;
        }

        .nav-links li {
            margin-left: 30px;
        }

        .nav-links a {
            color: var(--text-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-links a:hover, .nav-links a.active {
            color: var(--primary-color);
        }

        .hamburger {
            display: none;
            cursor: pointer;
        }

        .hamburger .line {
            width: 25px;
            height: 3px;
            background-color: var(--text-color);
            margin: 5px 0;
            transition: all 0.3s ease;
        }

        .profile {
            margin-top: 80px;
            padding: 40px 0;
        }

        .profile-card {
            background-color: var(--card-bg-color);
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            padding: 30px;
            margin-bottom: 30px;
            transition: transform 0.3s ease;
        }

        .profile-card:hover {
            transform: translateY(-5px);
        }

        .profile-header {
            margin-bottom: 30px;
        }

        .profile-name {
            font-size: 28px;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        .profile-email {
            font-size: 16px;
            color: #777;
        }

        .profile-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .profile-info p {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .btn {
            display: inline-block;
            background-color: var(--primary-color);
            color: #fff;
            padding: 12px 24px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn:hover {
            background-color: #059152;
            transform: translateY(-3px);
        }

        .donations-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: var(--card-bg-color);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .donations-table th, .donations-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .donations-table th {
            background-color: var(--primary-color);
            color: #fff;
            font-weight: 600;
            text-transform: uppercase;
        }

        .donations-table tr:last-child td {
            border-bottom: none;
        }

        .donations-table tr:hover {
            background-color: #f5f5f5;
        }

        .stats-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .stat-card {
            background-color: var(--card-bg-color);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            flex: 1;
            margin: 0 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .stat-number {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 14px;
            color: #777;
        }

        @media (max-width: 768px) {
            .hamburger {
                display: block;
            }

            .nav-links {
                display: none;
                flex-direction: column;
                position: absolute;
                top: 70px;
                left: 0;
                right: 0;
                background-color: var(--card-bg-color);
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
                padding: 20px;
            }

            .nav-links.active {
                display: flex;
            }

            .nav-links li {
                margin: 15px 0;
            }

            .profile-header {
                text-align: center;
            }

            .profile-info {
                flex-direction: column;
            }

            .btn {
                margin-top: 20px;
            }

            .stats-container {
                flex-direction: column;
            }

            .stat-card {
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <nav class="navbar">
                <div class="logo">Food <b>Donate</b></div>
                <ul class="nav-links">
                    <li><a href="home.html">Home</a></li>
                    <li><a href="about.html">About</a></li>
                    <li><a href="contact.html">Contact</a></li>
                    <li><a href="profile.php" class="active">Profile</a></li>
                </ul>
                <div class="hamburger">
                    <div class="line"></div>
                    <div class="line"></div>
                    <div class="line"></div>
                </div>
            </nav>
        </div>
    </header>

    <div class="profile">
        <div class="container">
            <div class="profile-card">
                <div class="profile-header">
                    <h2 class="profile-name"><?php echo $_SESSION['name']; ?></h2>
                    <p class="profile-email"><?php echo $_SESSION['email']; ?></p>
                </div>
                <div class="profile-info">
                    <p><strong>Gender:</strong> <?php echo $_SESSION['gender']; ?></p>
                    <a href="logout.php" class="btn">Logout</a>
                </div>
            </div>

            <div class="profile-card">
                <h3>Donation Statistics</h3>
                <div class="stats-container">
                    <?php
                    $email = $_SESSION['email'];
                    $query = "SELECT COUNT(*) as total_donations, SUM(CASE WHEN type = 'Perishable' THEN 1 ELSE 0 END) as perishable_count, SUM(CASE WHEN type = 'Non-Perishable' THEN 1 ELSE 0 END) as non_perishable_count FROM food_donations WHERE email='$email'";
                    $result = mysqli_query($connection, $query);
                    if ($result) {
                        $row = mysqli_fetch_assoc($result);
                        $total_donations = $row['total_donations'];
                        $perishable_count = $row['perishable_count'];
                        $non_perishable_count = $row['non_perishable_count'];
                    ?>
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $total_donations; ?></div>
                        <div class="stat-label">Total Donations</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $perishable_count; ?></div>
                        <div class="stat-label">Perishable Items</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $non_perishable_count; ?></div>
                        <div class="stat-label">Non-Perishable Items</div>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </div>

            <div class="profile-card">
                <h3>Your Donations</h3>
                <div class="table-container">
                    <table class="donations-table">
                        <thead>
                            <tr>
                                <th>Food</th>
                                <th>Type</th>
                                <th>Category</th>
                                <th>Date/Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM food_donations WHERE email='$email' ORDER BY date DESC";
                            $result = mysqli_query($connection, $query);
                            if ($result == true) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['food']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['type']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['category']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['date']) . "</td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        const hamburger = document.querySelector(".hamburger");
        const navLinks = document.querySelector(".nav-links");

        hamburger.addEventListener("click", () => {
            navLinks.classList.toggle("active");
            hamburger.classList.toggle("active");
        });
    </script>
</body>
</html>

