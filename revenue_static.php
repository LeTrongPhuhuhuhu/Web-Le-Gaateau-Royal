<?php
// Database connection
$pdo = new PDO('mysql:host=localhost;dbname=bakerydb', 'root', '');

// Fetch revenue data
$revenueStmt = $pdo->query("SELECT DATE(update_time) AS order_day, SUM(Total_Amount) AS total_revenue FROM order_detail GROUP BY order_day ORDER BY order_day");
$revenueResult = $revenueStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch top selling products data
$topProductsStmt = $pdo->query("SELECT Orders_Item AS product_name, SUM(Quantity_of_Product) AS quantity_sold FROM order_detail GROUP BY Orders_Item ORDER BY quantity_sold DESC LIMIT 5");
$topProductsResult = $topProductsStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch orders count data
$ordersStmt = $pdo->query("SELECT DATE(update_time) AS order_day, COUNT(Order_Detail_ID) AS total_orders FROM order_detail GROUP BY order_day ORDER BY order_day");
$ordersResult = $ordersStmt->fetchAll(PDO::FETCH_ASSOC);

// Get today's date
$today = date('Y-m-d');

// Fetch today's revenue and orders data
$todayRevenueStmt = $pdo->prepare("SELECT SUM(Total_Amount) AS total_revenue FROM order_detail WHERE DATE(update_time) = ?");
$todayRevenueStmt->execute([$today]);
$todayRevenue = $todayRevenueStmt->fetch(PDO::FETCH_ASSOC)['total_revenue'] ?? 0;

$todayOrdersStmt = $pdo->prepare("SELECT COUNT(Order_Detail_ID) AS total_orders FROM order_detail WHERE DATE(update_time) = ?");
$todayOrdersStmt->execute([$today]);
$todayOrders = $todayOrdersStmt->fetch(PDO::FETCH_ASSOC)['total_orders'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revenue and Orders Statistics</title>
   <link rel="stylesheet" href="admin.css">
</head>
<body>
<?php include 'admin_navbar.php'; ?>
<h1>Revenue and Orders Statistics</h1>

    <!-- Filter By Day/Month/Year -->
    <div class="filter-container">
        <label for="filter">Filter By:</label>
        <select id="filter">
            <option value="day">Day</option>
            <option value="month">Month</option>
            <option value="year">Year</option>
        </select>
    </div>

    <!-- Filtered Revenue Chart -->
    <div class="chart-container">
        <canvas id="filteredRevenueChart"></canvas>
    </div>

    <!-- Revenue Chart -->
    <div class="chart-container">
        <canvas id="revenueChart"></canvas>
    </div>

    <!-- Orders Chart -->
    <div class="chart-container">
        <canvas id="ordersChart"></canvas>
    </div>

    <!-- Top Products Chart -->
    <div class="chart-container">
        <canvas id="topProductsChart"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script>
        // Data for the revenue chart
        const revenueData = {
            labels: [<?php foreach ($revenueResult as $row) echo "'".$row['order_day']."',"; ?>],
            datasets: [{
                label: 'Revenue',
                data: [<?php foreach ($revenueResult as $row) echo $row['total_revenue'].","; ?>],
                backgroundColor: 'rgba(75, 192, 192, 0.7)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        };

        // Revenue Chart
        const revenueChart = new Chart(document.getElementById('revenueChart'), {
            type: 'line',
            data: revenueData,
            options: {
                plugins: {
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        formatter: Math.round,
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                animation: {
                    duration: 2000,
                    easing: 'easeInOutBounce'
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Data for the top products chart
        const topProductsData = {
            labels: [<?php foreach ($topProductsResult as $row) echo "'".$row['product_name']."',"; ?>],
            datasets: [{
                label: 'Top Selling Products',
                data: [<?php foreach ($topProductsResult as $row) echo $row['quantity_sold'].","; ?>],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        };

        // Top Products Chart
        const topProductsChart = new Chart(document.getElementById('topProductsChart'), {
            type: 'bar',
            data: topProductsData,
            options: {
                plugins: {
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        formatter: Math.round,
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                animation: {
                    duration: 2000,
                    easing: 'easeInOutBounce'
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Data for the orders chart
        const ordersData = {
            labels: [<?php foreach ($ordersResult as $row) echo "'".$row['order_day']."',"; ?>],
            datasets: [{
                label: 'Orders',
                data: [<?php foreach ($ordersResult as $row) echo $row['total_orders'].","; ?>],
                backgroundColor: 'rgba(153, 102, 255, 0.7)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        };

        // Orders Chart
        const ordersChart = new Chart(document.getElementById('ordersChart'), {
            type: 'line',
            data: ordersData,
            options: {
                plugins: {
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        formatter: Math.round,
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                animation: {
                    duration: 2000,
                    easing: 'easeInOutBounce'
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Filter Chart
        const filterSelect = document.getElementById('filter');
        const filteredRevenueChartCtx = document.getElementById('filteredRevenueChart').getContext('2d');

        filterSelect.addEventListener('change', function() {
            const filter = this.value;
            // Adjust SQL query and data fetching logic based on the filter here.
            // Example:
            // let filteredData = ... (Fetch filtered data based on the selected filter)
            
            // Sample data for demonstration
            const filteredData = {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'], // Update these based on the filter
                datasets: [{
                    label: `Revenue by ${filter}`,
                    data: [1200, 1500, 900, 2000, 1750], // Update based on the filter
                    backgroundColor: 'rgba(255, 159, 64, 0.7)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 1
                }]
            };

            // Destroy previous chart instance if it exists
            if (window.filteredRevenueChartInstance) {
                window.filteredRevenueChartInstance.destroy();
            }

            // Create new chart with filtered data
            window.filteredRevenueChartInstance = new Chart(filteredRevenueChartCtx, {
                type: 'bar', // or 'line', 'pie', etc. based on the type of chart you want
                data: filteredData,
                options: {
                    plugins: {
                        datalabels: {
                            anchor: 'end',
                            align: 'top',
                            formatter: Math.round,
                            font: {
                                weight: 'bold'
                            }
                        }
                    },
                    animation: {
                        duration: 2000,
                        easing: 'easeInOutBounce'
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });

        // Initialize chart with default filter (day)
        filterSelect.dispatchEvent(new Event('change'));
    </script>
</body>
</html>
