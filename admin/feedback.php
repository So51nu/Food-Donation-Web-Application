<?php
include '../connection.php';
include("connect.php"); 
if($_SESSION['name']==''){
    header("location:signin.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Admin Feedback Dashboard</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        :root {
            --primary-color: #4A90E2;
            --secondary-color: #5C6BC0;
            --background: #F0F2F5;
            --text-primary: #2C3E50;
            --text-secondary: #34495E;
            --card-bg: #FFFFFF;
            --hover-color: #3498DB;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: var(--text-primary);
            overflow-x: hidden;
        }

        body.dark {
            background: linear-gradient(135deg, #1a1c20 0%, #2d3436 100%);
        }

        /* Sidebar Styles */
        nav {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 250px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            transition: 0.3s;
            z-index: 1000;
        }

        nav .logo-name {
            padding: 20px 0;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        nav .logo-image {
            display: flex;
            justify-content: center;
            min-width: 45px;
            color: #fff;
            font-size: 24px;
        }

        nav .logo_name {
            font-size: 24px;
            font-weight: 600;
            color: #fff;
            margin-left: 14px;
        }

        nav .menu-items {
            margin-top: 40px;
            height: calc(100% - 90px);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .menu-items li {
            list-style: none;
            margin: 15px 0;
        }

        .menu-items li a {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            text-decoration: none;
            color: #fff;
            border-radius: 10px;
            transition: 0.3s;
        }

        .menu-items li a:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }

        .menu-items li a i {
            font-size: 20px;
            margin-right: 15px;
        }

        .logout-mode {
            margin-top: auto;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 20px;
        }

        .mode {
            display: flex;
            align-items: center;
            white-space: nowrap;
        }

        .mode-toggle {
            position: absolute;
            right: 14px;
            height: 50px;
            min-width: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .switch {
            position: relative;
            display: inline-block;
            height: 22px;
            width: 40px;
            border-radius: 25px;
            background-color: #ddd;
        }

        .switch:before {
            content: "";
            position: absolute;
            left: 5px;
            top: 50%;
            transform: translateY(-50%);
            height: 15px;
            width: 15px;
            background-color: #fff;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        body.dark .switch:before {
            left: 20px;
        }

        /* Dashboard Content */
        .dashboard {
            margin-left: 250px;
            padding: 20px;
            transition: 0.3s;
        }

        .top {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #fff;
        }

        .sidebar-toggle {
            cursor: pointer;
            font-size: 20px;
        }

        .activity {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .title {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            color: var(--text-primary);
        }

        .title i {
            font-size: 28px;
            margin-right: 15px;
            color: var(--primary-color);
        }

        .feedback-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px 0;
        }

        .feedback-item {
            background: #fff;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .feedback-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .feedback-item h3 {
            color: var(--primary-color);
            font-size: 1.2em;
            margin-bottom: 10px;
        }

        .feedback-item p {
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .feedback-meta {
            display: flex;
            justify-content: space-between;
            padding-top: 15px;
            border-top: 1px solid #eee;
            color: #666;
            font-size: 0.9em;
        }

        .feedback-meta i {
            margin-right: 5px;
        }

        /* Dark Mode Styles */
        body.dark .activity {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
        }

        body.dark .feedback-item {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
        }

        body.dark .feedback-meta {
            border-top-color: rgba(255, 255, 255, 0.1);
            color: #ccc;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            nav {
                width: 70px;
                padding: 15px;
            }

            nav .logo_name,
            nav .link-name {
                display: none;
            }

            .dashboard {
                margin-left: 70px;
            }

            .feedback-container {
                grid-template-columns: 1fr;
            }

            .top {
                padding: 15px;
            }

            .activity {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <nav>
        <div class="logo-name">
            <div class="logo-image">
                <i class="fas fa-user-shield"></i>
            </div>
            <span class="logo_name">ADMIN</span>
        </div>
        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="admin.php">
                    <i class="fas fa-home"></i>
                    <span class="link-name">Dashboard</span>
                </a></li>
                <li><a href="analytics.php">
                    <i class="fas fa-chart-bar"></i>
                    <span class="link-name">Analytics</span>
                </a></li>
                <li><a href="donate.php">
                    <i class="fas fa-hand-holding-heart"></i>
                    <span class="link-name">Donations</span>
                </a></li>
                <li><a href="#">
                    <i class="fas fa-comments"></i>
                    <span class="link-name">Feedbacks</span>
                </a></li>
                <li><a href="adminprofile.php">
                    <i class="fas fa-user"></i>
                    <span class="link-name">Profile</span>
                </a></li>
            </ul>
            <ul class="logout-mode">
                <li><a href="../logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="link-name">Logout</span>
                </a></li>
                <li class="mode">
                    <a href="#">
                        <i class="fas fa-moon"></i>
                        <span class="link-name">Dark Mode</span>
                    </a>
                    <div class="mode-toggle">
                        <span class="switch"></span>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <section class="dashboard">
        <div class="top">
            <i class="fas fa-bars sidebar-toggle"></i>
            <p class="logo">Feed<b style="color: #5C6BC0">back</b> Dashboard</p>
        </div>
        <div class="activity">
            <div class="title">
                <i class="fas fa-comments"></i>
                <span class="text">Recent Feedbacks</span>
            </div>
            <div class="feedback-container">
                <?php
                $query = "SELECT * FROM user_feedback ORDER BY id DESC LIMIT 10";
                $result = mysqli_query($connection, $query);
                if($result && mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        echo "<div class='feedback-item'>";
                        echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
                        echo "<p>" . htmlspecialchars($row['message']) . "</p>";
                        echo "<div class='feedback-meta'>";
                        echo "<span><i class='fas fa-envelope'></i> " . htmlspecialchars($row['email']) . "</span>";
                        echo "<span><i class='fas fa-calendar'></i> " . date('M d, Y', strtotime($row['created_at'])) . "</span>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<div class='feedback-item'><p>No feedback available at this time.</p></div>";
                }
                ?>
            </div>
        </div>
    </section>

    <script>
        const body = document.querySelector("body"),
        sidebar = body.querySelector("nav"),
        toggle = body.querySelector(".sidebar-toggle"),
        modeSwitch = body.querySelector(".switch"),
        modeText = body.querySelector(".mode .link-name");

        toggle.addEventListener("click", () => {
            sidebar.classList.toggle("close");
            if(sidebar.classList.contains("close")){
                document.querySelector(".dashboard").style.marginLeft = "70px";
            } else {
                document.querySelector(".dashboard").style.marginLeft = "250px";
            }
        });

        modeSwitch.addEventListener("click", () => {
            body.classList.toggle("dark");
            
            if(body.classList.contains("dark")) {
                modeText.innerText = "Light Mode";
            } else {
                modeText.innerText = "Dark Mode";
            }
        });
    </script>
</body>
</html>