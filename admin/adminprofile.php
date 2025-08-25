<?php
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
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <title>Admin Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        :root {
            --primary-color: #4f46e5;
            --secondary-color: #818cf8;
            --background-color: #1e1b4b;
            --text-color: #ffffff;
            --card-bg: rgba(255, 255, 255, 0.1);
            --hover-color: #6366f1;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1e1b4b, #3730a3);
            color: var(--text-color);
            overflow-x: hidden;
        }

        /* Glassmorphism Nav */
        nav {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 280px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            transition: 0.3s;
            z-index: 1000;
        }

        nav .logo-name {
            padding: 20px 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        nav .logo-name .logo_name {
            font-size: 28px;
            font-weight: 600;
            background: linear-gradient(45deg, #fff, #818cf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        nav .menu-items {
            margin-top: 30px;
        }

        nav .menu-items li {
            list-style: none;
        }

        nav .menu-items li a {
            display: flex;
            align-items: center;
            padding: 15px;
            margin: 8px 0;
            text-decoration: none;
            color: var(--text-color);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        nav .menu-items li a:hover {
            background: var(--hover-color);
            transform: translateX(5px);
        }

        nav .menu-items li a i {
            font-size: 20px;
            margin-right: 15px;
        }

        /* Dashboard Content */
        .dashboard {
            margin-left: 280px;
            padding: 30px;
            transition: margin-left 0.3s;
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
        }

        .top .logo {
            font-size: 24px;
            color: var(--text-color);
        }

        .mobile-toggle {
            display: none;
            font-size: 24px;
            cursor: pointer;
        }

        /* Statistics Cards */
        .summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .summary .card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 25px;
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: transform 0.3s ease;
        }

        .summary .card:hover {
            transform: translateY(-5px);
        }

        .summary .card h3 {
            font-size: 20px;
            margin-bottom: 15px;
            color: #818cf8;
        }

        .summary .card p {
            font-size: 28px;
            font-weight: 600;
        }

        /* Search Box */
        .search-box {
            margin-bottom: 20px;
        }

        .search-box input {
            width: 100%;
            padding: 15px;
            border: none;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            color: var(--text-color);
            font-size: 16px;
        }

        .search-box input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        /* Activity Section */
        .activity {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 25px;
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .activity h2 {
            color: #818cf8;
            margin-bottom: 20px;
            font-size: 24px;
        }

        /* Table Styles */
        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 8px;
            margin-top: 20px;
        }

        table th {
            background: rgba(79, 70, 229, 0.3);
            color: var(--text-color);
            padding: 15px;
            text-align: left;
            font-weight: 500;
            white-space: nowrap;
        }

        table td {
            background: rgba(255, 255, 255, 0.05);
            padding: 15px;
            color: var(--text-color);
        }

        table tr:hover td {
            background: rgba(255, 255, 255, 0.1);
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .mobile-toggle {
                display: block;
            }

            nav {
                transform: translateX(-100%);
            }

            nav.active {
                transform: translateX(0);
            }

            .dashboard {
                margin-left: 0;
                padding: 20px;
            }

            .summary {
                grid-template-columns: 1fr;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .summary .card, .activity {
            animation: fadeIn 0.5s ease forwards;
        }
    </style>
</head>
<body>
    <nav id="sidebar">
        <div class="logo-name">
            <span class="logo_name">ADMIN</span>
        </div>
        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="admin.php">
                    <i class="uil uil-estate"></i>
                    <span class="link-name">Dashboard</span>
                </a></li>
                <li><a href="analytics.php">
                    <i class="uil uil-chart"></i>
                    <span class="link-name">Analytics</span>
                </a></li>
                <li><a href="donate.php">
                    <i class="uil uil-heart"></i>
                    <span class="link-name">Donates</span>
                </a></li>
                <li><a href="feedback.php">
                    <i class="uil uil-comments"></i>
                    <span class="link-name">Feedbacks</span>
                </a></li>
                <li><a href="#">
                    <i class="uil uil-user"></i>
                    <span class="link-name">Profile</span>
                </a></li>
            </ul>
            <ul class="logout-mode">
                <li><a href="../logout.php">
                    <i class="uil uil-signout"></i>
                    <span class="link-name">Logout</span>
                </a></li>
            </ul>
        </div>
    </nav>

    <section class="dashboard">
        <div class="top">
            <div class="mobile-toggle" onclick="toggleSidebar()">
                <i class="uil uil-bars"></i>
            </div>
            <p class="logo">Welcome, <b style="color: #818cf8;"><?php echo $_SESSION['name']; ?></b></p>
        </div>
        
        <div class="summary">
            <div class="card">
                <h3>Total Donations</h3>
                <p><?php
                    $sql = "SELECT COUNT(*) as total FROM food_donations WHERE assigned_to = {$_SESSION['Aid']}";
                    $result = mysqli_query($connection, $sql);
                    $data = mysqli_fetch_assoc($result);
                    echo $data['total'];
                ?></p>
            </div>
            <div class="card">
                <h3>Total Quantity</h3>
                <p><?php
                    $sql = "SELECT SUM(quantity) as total_quantity FROM food_donations WHERE assigned_to = {$_SESSION['Aid']}";
                    $result = mysqli_query($connection, $sql);
                    $data = mysqli_fetch_assoc($result);
                    echo $data['total_quantity'] ?? '0';
                ?></p>
            </div>
        </div>

        <div class="search-box">
            <input type="text" id="searchInput" placeholder="Search by name or food..." onkeyup="filterTable()">
        </div>

        <div class="activity">
            <h2>Food Donation History</h2>
            <div class="table-container">
                <table id="donationTable">
                    <thead>
                        <tr>
                            <th onclick="sortTable(0)">Name</th>
                            <th onclick="sortTable(1)">Food</th>
                            <th onclick="sortTable(2)">Category</th>
                            <th onclick="sortTable(3)">Phone No</th>
                            <th onclick="sortTable(4)">Date/Time</th>
                            <th onclick="sortTable(5)">Address</th>
                            <th onclick="sortTable(6)">Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $id = $_SESSION['Aid'];
                        $sql = "SELECT * FROM food_donations WHERE assigned_to = $id";
                        $result = mysqli_query($connection, $sql);

                        if (!$result) {
                            die("Error executing query: " . mysqli_error($connection));
                        }

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                <td>{$row['name']}</td>
                                <td>{$row['food']}</td>
                                <td>{$row['category']}</td>
                                <td>{$row['phoneno']}</td>
                                <td>{$row['date']}</td>
                                <td>{$row['address']}</td>
                                <td>{$row['quantity']}</td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }

        function filterTable() {
            const input = document.getElementById("searchInput");
            const filter = input.value.toLowerCase();
            const table = document.getElementById("donationTable");
            const tr = table.getElementsByTagName("tr");

            for (let i = 1; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName("td");
                let found = false;
                for (let j = 0; j < td.length; j++) {
                    if (td[j]) {
                        const txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toLowerCase().indexOf(filter) > -1) {
                            found = true;
                        }
                    }
                }
                tr[i].style.display = found ? "" : "none";
            }
        }

        function sortTable(n) {
            const table = document.getElementById("donationTable");
            let switching = true;
            let dir = "asc"; 
            let switchcount = 0;

            while (switching) {
                switching = false;
                const rows = table.rows;

                for (let i = 1; i < (rows.length - 1); i++) {
                    let shouldSwitch = false;
                    const x = rows[i].getElementsByTagName("TD")[n];
                    const y = rows[i + 1].getElementsByTagName("TD")[n];

                    if (dir === "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    } else if (dir === "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    switchcount++;
                } else {
                    if (switchcount === 0 && dir === "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        }
    </script>
</body>
</html>