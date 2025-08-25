<?php
ob_start(); 
include("connect.php"); 
include '../connection.php';

if ($_SESSION['name'] == '') {
    header("location:deliverylogin.php");
}
$name = $_SESSION['name'];
$id = $_SESSION['Did'];
// Handle order acceptance
if(isset($_POST['food'])) {
    $order_id = $_POST['order_id'];
    $delivery_person_id = $_POST['delivery_person_id'];
    
    $update_query = "UPDATE food_donations SET delivery_by = '$delivery_person_id' WHERE Fid = '$order_id'";
    if(mysqli_query($connection, $update_query)) {
        $success_message = "Order accepted successfully!";
    } else {
        $error_message = "Error accepting order: " . mysqli_error($connection);
    }
}

$ch=curl_init();
curl_setopt($ch,CURLOPT_URL,"http://ip-api.com/json");
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
$result=curl_exec($ch);
$result=json_decode($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        * {
            font-family: 'Poppins', sans-serif;
        }

        :root {
            --primary-color: #2563eb;
            --secondary-color: #1d4ed8;
            --accent-color: #3b82f6;
        }

        .gradient-bg {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }

        .sidebar {
            background: #1e293b;
            min-height: 100vh;
        }

        .content-area {
            background: #f1f5f9;
        }

        .nav-link {
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background: rgba(59, 130, 246, 0.1);
            transform: translateX(5px);
        }

        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .order-table th {
            background: #f8fafc;
        }

        .order-table tr {
            transition: all 0.3s ease;
        }

        .order-table tr:hover {
            background: #f1f5f9;
        }

        .btn-primary {
            background: var(--primary-color);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-size: 0.875rem;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <aside class="sidebar w-64 fixed h-full text-white">
            <div class="p-6">
                <h1 class="text-2xl font-bold mb-8">Food<span class="text-blue-400">Donate</span></h1>
                <nav class="space-y-4">
                    <a href="#home" class="nav-link flex items-center space-x-3 text-gray-300 p-3 rounded-lg">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
                    </a>
                    <a href="openmap.php" class="nav-link flex items-center space-x-3 text-gray-300 p-3 rounded-lg">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Map</span>
                    </a>
                    <a href="deliverymyord.php" class="nav-link flex items-center space-x-3 text-gray-300 p-3 rounded-lg">
                        <i class="fas fa-list"></i>
                        <span>My Orders</span>
                    </a>
                    <a href="logout.php" class="nav-link flex items-center space-x-3 text-gray-300 p-3 rounded-lg">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="content-area ml-64 flex-1 p-8">
            <!-- Welcome Section -->
            <div class="gradient-bg rounded-2xl p-8 text-white mb-8 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold mb-2">Welcome back, <?php echo htmlspecialchars($name); ?>!</h1>
                        <p class="opacity-90">Ready to deliver happiness today?</p>
                    </div>
                    <img src="../img/delivery1.gif" alt="Delivery Animation" class="w-32 h-32 object-cover rounded-full border-4 border-white">
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <?php
                $total_orders = mysqli_query($connection, "SELECT COUNT(*) as count FROM food_donations WHERE assigned_to IS NOT NULL AND delivery_by IS NULL");
                $pending_orders = mysqli_fetch_assoc($total_orders)['count'];
                ?>
                <div class="card bg-white p-6 rounded-xl shadow-md">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-blue-100 rounded-full">
                            <i class="fas fa-truck text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Available Orders</p>
                            <h3 class="text-2xl font-bold text-gray-800"><?php echo $pending_orders; ?></h3>
                        </div>
                    </div>
                </div>
                <!-- Add more stat cards as needed -->
            </div>

            <!-- Orders Table -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-semibold text-gray-800">Available Orders</h2>
                        <div class="relative">
                            <input type="text" id="searchInput" placeholder="Search orders..." 
                                   class="pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <?php
                if(isset($success_message)){
                    echo "<div class='p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg' role='alert'>$success_message</div>";
                }
                if(isset($error_message)){
                    echo "<div class='p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg' role='alert'>$error_message</div>";
                }

                $sql = "SELECT fd.Fid AS Fid, fd.location as cure, fd.name, fd.phoneno, fd.date, fd.delivery_by, 
                        fd.address as From_address, ad.name AS delivery_person_name, ad.address AS To_address
                        FROM food_donations fd
                        LEFT JOIN admin ad ON fd.assigned_to = ad.Aid 
                        WHERE fd.assigned_to IS NOT NULL AND fd.delivery_by IS NULL";

                $result = mysqli_query($connection, $sql);
                if (!$result) {
                    die("Error executing query: " . mysqli_error($connection));
                }

                $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
                
                if (count($data) > 0): ?>
                    <div class="overflow-x-auto">
                        <table class="order-table min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order Details</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Addresses</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($data as $row): ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($row['name']); ?></div>
                                            <div class="text-sm text-gray-500"><?php echo date('d M Y H:i', strtotime($row['date'])); ?></div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900"><?php echo htmlspecialchars($row['phoneno']); ?></div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900">
                                                <div class="mb-2">
                                                    <span class="font-medium">Pickup:</span> <?php echo htmlspecialchars($row['From_address']); ?>
                                                </div>
                                                <div>
                                                    <span class="font-medium">Delivery:</span> <?php echo htmlspecialchars($row['To_address']); ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <?php if ($row['delivery_by'] == null): ?>
                                                <form method="post" action="">
                                                    <input type="hidden" name="order_id" value="<?php echo $row['Fid']; ?>">
                                                    <input type="hidden" name="delivery_person_id" value="<?php echo $id; ?>">
                                                    <button type="submit" name="food" 
                                                            class="btn-primary text-white px-4 py-2 rounded-lg inline-flex items-center space-x-2">
                                                        <i class="fas fa-truck"></i>
                                                        <span>Accept Order</span>
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <span class="status-badge bg-gray-100 text-gray-800">
                                                    Already assigned
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="p-8 text-center">
                        <div class="text-gray-500">No orders available at the moment</div>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <script>
        // Search functionality
        document.getElementById('searchInput')?.addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                let text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    </script>
</body>
</html>

