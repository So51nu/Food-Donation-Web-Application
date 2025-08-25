<?php
include "../connection.php";
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
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Food Donation Admin Dashboard</title> 
</head>
<body class="bg-gray-100">
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md">
            <div class="p-4">
                <h1 class="text-2xl font-semibold text-gray-800">Admin Panel</h1>
            </div>
            <nav class="mt-4">
                <a href="admin.php" class="block py-2 px-4 text-gray-700 hover:bg-gray-200">
                    <i class="fas fa-home mr-2"></i>Dashboard
                </a>
                <a href="analytics.php" class="block py-2 px-4 text-gray-700 hover:bg-gray-200">
                    <i class="fas fa-chart-bar mr-2"></i>Analytics
                </a>
                <a href="#" class="block py-2 px-4 bg-gray-200 text-green-600">
                    <i class="fas fa-heart mr-2"></i>Donations
                </a>
                <a href="feedback.php" class="block py-2 px-4 text-gray-700 hover:bg-gray-200">
                    <i class="fas fa-comments mr-2"></i>Feedbacks
                </a>
                <a href="adminprofile.php" class="block py-2 px-4 text-gray-700 hover:bg-gray-200">
                    <i class="fas fa-user mr-2"></i>Profile
                </a>
                <a href="../logout.php" class="block py-2 px-4 text-gray-700 hover:bg-gray-200">
                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-semibold text-gray-800">Donation Details</h2>
                <div class="relative">
                    <input type="text" placeholder="Search donations..." class="pl-8 pr-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-600">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>

            <!-- Donation Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <?php
                $total_donations = mysqli_query($connection, "SELECT COUNT(*) as total FROM food_donations");
                $total_count = mysqli_fetch_assoc($total_donations)['total'];
                
                $total_quantity = mysqli_query($connection, "SELECT SUM(quantity) as total FROM food_donations");
                $total_qty = mysqli_fetch_assoc($total_quantity)['total'];

                $locations = mysqli_query($connection, "SELECT COUNT(DISTINCT location) as total FROM food_donations");
                $location_count = mysqli_fetch_assoc($locations)['total'];

                $recent_donation = mysqli_query($connection, "SELECT date FROM food_donations ORDER BY date DESC LIMIT 1");
                $recent_date = mysqli_fetch_assoc($recent_donation)['date'];
                ?>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Total Donations</h3>
                    <p class="text-3xl font-bold text-green-600"><?php echo $total_count; ?></p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Total Quantity</h3>
                    <p class="text-3xl font-bold text-green-600"><?php echo $total_qty; ?></p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Locations Served</h3>
                    <p class="text-3xl font-bold text-green-600"><?php echo $location_count; ?></p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Latest Donation</h3>
                    <p class="text-3xl font-bold text-green-600"><?php echo date('d M Y', strtotime($recent_date)); ?></p>
                </div>
            </div>

            <!-- Location Filter -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <form method="post" class="flex items-center">
                    <label for="location" class="mr-4 text-gray-700">Select Location:</label>
                    <select id="location" name="location" class="mr-4 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-600">
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
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition duration-300">Get Details</button>
                </form>
            </div>

            <!-- Donation Table -->
            <?php
            if(isset($_POST['location'])) {
                $location = $_POST['location'];
                $sql = "SELECT * FROM food_donations WHERE location='$location'";
                $result = mysqli_query($connection, $sql);
                if ($result->num_rows > 0) {
                    echo "<div class='bg-white rounded-lg shadow-md overflow-hidden'>";
                    echo "<table class='min-w-full divide-y divide-gray-200'>";
                    echo "<thead class='bg-gray-50'><tr>
                            <th class='px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'>Name</th>
                            <th class='px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'>Food</th>
                            <th class='px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'>Category</th>
                            <th class='px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'>Phone</th>
                            <th class='px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'>Date/Time</th>
                            <th class='px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'>Address</th>
                            <th class='px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'>Quantity</th>
                            
                          </tr></thead><tbody class='bg-white divide-y divide-gray-200'>";
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td class='px-6 py-4 whitespace-nowrap'>".$row['name']."</td>
                                <td class='px-6 py-4 whitespace-nowrap'>".$row['food']."</td>
                                <td class='px-6 py-4 whitespace-nowrap'>".$row['category']."</td>
                                <td class='px-6 py-4 whitespace-nowrap'>".$row['phoneno']."</td>
                                <td class='px-6 py-4 whitespace-nowrap'>".$row['date']."</td>
                                <td class='px-6 py-4 whitespace-nowrap'>".$row['address']."</td>
                                <td class='px-6 py-4 whitespace-nowrap'>".$row['quantity']."</td>
                                                             </tr>";
                    }
                    echo "</tbody></table></div>";
                } else {
                    echo "<p class='text-gray-600'>No donations found for this location.</p>";
                }
            }
            ?>
        </main>
    </div>

    <script>
        // You can add any necessary JavaScript here
    </script>
</body>
</html>