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
    <title>Admin Dashboard - Analytics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2980b9;
            --accent-color: #e74c3c;
            --background-color: #ecf0f1;
            --text-color: #34495e;
            --card-bg: #ffffff;
            --success-color: #2ecc71;
            --warning-color: #f39c12;
            --box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            --dark-color: #56021F;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f6f8fd 0%, #f1f4f9 100%);
            color: var(--text-color);
            min-height: 100vh;
        }

        .dashboard {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            padding: 25px;
            color: white;
            position: fixed;
            height: 100vh;
            transition: all 0.3s ease;
        }

        .logo {
            font-size: 26px;
            font-weight: 700;
            color: white;
            margin-bottom: 40px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-links {
            list-style: none;
        }

        .nav-links li {
            margin-bottom: 15px;
        }

        .nav-links a {
            text-decoration: none;
            color: rgba(255, 255, 255, 0.85);
            font-size: 16px;
            display: flex;
            align-items: center;
            padding: 12px 15px;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .nav-links a i {
            margin-right: 15px;
            font-size: 20px;
        }

        .nav-links a:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(5px);
        }

        /* Main Content Styles */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 30px;
        }

        .header {
            background: var(--card-bg);
            padding: 20px 30px;
            border-radius: 15px;
            box-shadow: var(--box-shadow);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 24px;
            color: var(--primary-color);
            font-weight: 600;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
            background: rgba(52, 152, 219, 0.1);
            padding: 10px 20px;
            border-radius: 50px;
        }

        .user-info img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-color);
        }

        /* Stats Grid */
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--card-bg);
            padding: 25px;
            border-radius: 15px;
            box-shadow: var(--box-shadow);
            transition: transform 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card h3 {
            font-size: 18px;
            color: var(--text-color);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .stat-card p {
            font-size: 28px;
            font-weight: 600;
            color: var(--primary-color);
        }

        /* Chart Container Styles */
        .chart-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
        }

        .chart-container {
            background: var(--card-bg);
            padding: 25px;
            border-radius: 15px;
            box-shadow: var(--box-shadow);
            transition: transform 0.3s ease;
        }

        .chart-container:hover {
            transform: translateY(-5px);
        }

        .chart-container h2 {
            font-size: 18px;
            color: var(--text-color);
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .chart-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
                padding: 15px;
            }

            .logo span, .nav-links span {
                display: none;
            }

            .main-content {
                margin-left: 70px;
            }

            .stats {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }

            .header {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <div class="sidebar">
            <div class="logo">Food Donate</div>
            <ul class="nav-links">
                <li><a href="admin.php"><i class="fas fa-home"></i>Dashboard</a></li>
                <li><a href="#"><i class="fas fa-chart-bar"></i>Analytics</a></li>
                <li><a href="donate.php"><i class="fas fa-hand-holding-heart"></i>Donations</a></li>
                <li><a href="feedback.php"><i class="fas fa-comments"></i>Feedbacks</a></li>
                <li><a href="adminprofile.php"><i class="fas fa-user"></i>Profile</a></li>
                <li><a href="../logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
            </ul>
        </div>
        <div class="main-content">
            <div class="header">
                <h1>Analytics Dashboard</h1>
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
            <div class="chart-grid">
                <div class="chart-container">
                    <h2>User Gender Distribution</h2>
                    <canvas id="genderChart"></canvas>
                </div>
                <div class="chart-container">
                    <h2>User Gender Distribution (Bar)</h2>
                    <canvas id="genderBarChart"></canvas>
                </div>
                <div class="chart-container">
                    <h2>Donations by Location</h2>
                    <canvas id="locationChart"></canvas>
                </div>
                <div class="chart-container">
                    <h2>Donations by Location (Pie)</h2>
                    <canvas id="locationPieChart"></canvas>
                </div>
                <div class="chart-container">
                    <h2>Monthly Donation Trends</h2>
                    <canvas id="trendChart"></canvas>
                </div>
                <div class="chart-container">
                    <h2>Monthly Donation Trends (Bar)</h2>
                    <canvas id="trendBarChart"></canvas>
                </div>
                <div class="chart-container">
                    <h2>Food Category Distribution</h2>
                    <canvas id="categoryChart"></canvas>
                </div>
                <div class="chart-container">
                    <h2>Food Category Distribution (Bar)</h2>
                    <canvas id="categoryBarChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <script>
    <?php
    // Gender distribution data
    $query = "SELECT gender, COUNT(*) as count FROM login GROUP BY gender";
    $result = mysqli_query($connection, $query);
    $genderData = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $genderData[$row['gender']] = $row['count'];
    }

    // Location distribution data
    $query = "SELECT location, COUNT(*) as count FROM food_donations GROUP BY location";
    $result = mysqli_query($connection, $query);
    $locationData = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $locationData[$row['location']] = $row['count'];
    }

    // Monthly donation trends
    $query = "SELECT DATE_FORMAT(date, '%Y-%m') as month, COUNT(*) as count FROM food_donations GROUP BY month ORDER BY month DESC LIMIT 6";
    $result = mysqli_query($connection, $query);
    $trendData = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $trendData[$row['month']] = $row['count'];
    }

    // Food category distribution
    $query = "SELECT category, COUNT(*) as count FROM food_donations GROUP BY category";
    $result = mysqli_query($connection, $query);
    $categoryData = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $categoryData[$row['category']] = $row['count'];
    }
    ?>

    // Gender Chart
    new Chart(document.getElementById('genderChart'), {
        type: 'pie',
        data: {
            labels: <?php echo json_encode(array_keys($genderData)); ?>,
            datasets: [{
                data: <?php echo json_encode(array_values($genderData)); ?>,
                backgroundColor: ['#3498db', '#e74c3c', '#f39c12']
            }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'User Gender Distribution'
            }
        }
    });

    // Gender Bar Chart
    new Chart(document.getElementById('genderBarChart'), {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_keys($genderData)); ?>,
            datasets: [{
                label: 'Users',
                data: <?php echo json_encode(array_values($genderData)); ?>,
                backgroundColor: ['#3498db', '#e74c3c', '#f39c12']
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Location Chart
    new Chart(document.getElementById('locationChart'), {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_keys($locationData)); ?>,
            datasets: [{
                label: 'Donations',
                data: <?php echo json_encode(array_values($locationData)); ?>,
                backgroundColor: '#56021F'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Location Pie Chart
    new Chart(document.getElementById('locationPieChart'), {
        type: 'pie',
        data: {
            labels: <?php echo json_encode(array_keys($locationData)); ?>,
            datasets: [{
                data: <?php echo json_encode(array_values($locationData)); ?>,
                backgroundColor: ['#3498db', '#e74c3c', '#f39c12', '#56021F', '#9b59b6', '#34495e']
            }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'Donations by Location'
            }
        }
    });

    // Trend Chart
    new Chart(document.getElementById('trendChart'), {
        type: 'line',
        data: {
            labels: <?php echo json_encode(array_keys($trendData)); ?>,
            datasets: [{
                label: 'Donations',
                data: <?php echo json_encode(array_values($trendData)); ?>,
                borderColor: '#56021F',
                fill: false
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Trend Bar Chart
    new Chart(document.getElementById('trendBarChart'), {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_keys($trendData)); ?>,
            datasets: [{
                label: 'Donations',
                data: <?php echo json_encode(array_values($trendData)); ?>,
                backgroundColor: '#56021F'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Category Chart
    new Chart(document.getElementById('categoryChart'), {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode(array_keys($categoryData)); ?>,
            datasets: [{
                data: <?php echo json_encode(array_values($categoryData)); ?>,
                backgroundColor: ['#3498db', '#e74c3c', '#f39c12', '#56021F', '#9b59b6']
            }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'Food Category Distribution'
            }
        }
    });

    // Category Bar Chart
    new Chart(document.getElementById('categoryBarChart'), {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_keys($categoryData)); ?>,
            datasets: [{
                label: 'Donations',
                data: <?php echo json_encode(array_values($categoryData)); ?>,
                backgroundColor: ['#3498db', '#e74c3c', '#f39c12', '#56021F', '#9b59b6']
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            title: {
                display: true,
                text: 'Food Category Distribution'
            }
        }
    });
    </script>
</body>
</html>
<?php
ob_end_flush();
?>

