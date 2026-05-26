<?php

session_start();

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

include 'db.php';

// ================= TOTAL PRODUCTS =================

$product_query = "SELECT * FROM products";
$product_result = mysqli_query($conn,$product_query);
$total_products = mysqli_num_rows($product_result);

// ================= TOTAL SUPPLIERS =================

$supplier_query = "SELECT * FROM suppliers";
$supplier_result = mysqli_query($conn,$supplier_query);
$total_suppliers = mysqli_num_rows($supplier_result);

// ================= TOTAL STOCK IN =================

$stockin_query = "SELECT * FROM stock_in";
$stockin_result = mysqli_query($conn,$stockin_query);
$total_stockin = mysqli_num_rows($stockin_result);


// ================= TODAY SALES =================

$today_sales = 0;

$today_sales_query = "
SELECT SUM(total) as total_sales
FROM invoices
WHERE DATE(invoice_date)=CURDATE()
";

$today_sales_result =
mysqli_query($conn,$today_sales_query);

$today_sales_row =
mysqli_fetch_assoc($today_sales_result);

$today_sales =
$today_sales_row['total_sales'] ?? 0;


// ================= MONTHLY SALES =================

$monthly_sales = 0;

$monthly_sales_query = "
SELECT SUM(total) as total_sales
FROM invoices
WHERE MONTH(invoice_date)=MONTH(CURDATE())
AND YEAR(invoice_date)=YEAR(CURDATE())
";

$monthly_sales_result =
mysqli_query($conn,$monthly_sales_query);

$monthly_sales_row =
mysqli_fetch_assoc($monthly_sales_result);

$monthly_sales =
$monthly_sales_row['total_sales'] ?? 0;


// ================= TODAY PROFIT =================

$today_profit = 0;

$today_query = "
SELECT invoices.*, products.cost_price
FROM invoices
INNER JOIN products
ON invoices.product_name = products.product_name
WHERE DATE(invoice_date)=CURDATE()
";

$today_result = mysqli_query($conn,$today_query);

while($row = mysqli_fetch_assoc($today_result)){

   // SELLING PRICE (MRP)

$selling_price = $row['price'];

// GST %

$gst = $row['gst'];

// BASE SELLING PRICE

$base_price =
($selling_price * 100) / (100 + $gst);

// PROFIT

$profit =
($base_price - $row['cost_price'])
* $row['quantity'];

    $today_profit += $profit;
}


// ================= MONTHLY PROFIT =================

$month_profit = 0;

$month_query = "
SELECT invoices.*, products.cost_price
FROM invoices
INNER JOIN products
ON invoices.product_name = products.product_name
WHERE MONTH(invoice_date)=MONTH(CURDATE())
AND YEAR(invoice_date)=YEAR(CURDATE())
";

$month_result = mysqli_query($conn,$month_query);

while($row = mysqli_fetch_assoc($month_result)){

// SELLING PRICE (MRP)

$selling_price = $row['price'];

// GST %

$gst = $row['gst'];

// BASE SELLING PRICE

$base_price =
($selling_price * 100) / (100 + $gst);

// PROFIT

$profit =
($base_price - $row['cost_price'])
* $row['quantity'];

    $month_profit += $profit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Smart Inventory Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{

    background:
    linear-gradient(
    135deg,
    #020617,
    #0f172a,
    #111827
    );

    color:#f8fafc;

    font-family:'Poppins',sans-serif;

    overflow-x:hidden;
}

/* ================= SIDEBAR ================= */

.sidebar{

    position:fixed;

    top:0;

    left:0;

    width:260px;

    height:100vh;

    background:
    linear-gradient(
    180deg,
    #020617,
    #0f172a,
    #1e293b
    );

    padding-top:20px;

    box-shadow:
    5px 0px 25px rgba(0,0,0,0.45);

    border-right:
    1px solid rgba(255,255,255,0.05);

    z-index:1000;
}

.logo{

    text-align:center;

    font-size:28px;

    font-weight:700;

    color:#ffffff;

    margin-bottom:35px;

    line-height:1.4;
}

.sidebar a{

    display:block;

    color:#cbd5e1;

    text-decoration:none;

    padding:14px 22px;

    margin:10px 14px;

    border-radius:14px;

    transition:0.3s ease;

    font-size:15px;

    font-weight:500;
}

.sidebar a i{
    margin-right:10px;
}

.sidebar a:hover,
.sidebar a.active{

    background:
    linear-gradient(
    135deg,
    #2563eb,
    #3b82f6
    );

    color:white;

    transform:translateX(5px);

    box-shadow:
    0px 8px 20px rgba(37,99,235,0.35);
}

/* ================= MAIN CONTENT ================= */

.main-content{

    margin-left:260px;

    padding:30px;
}

/* ================= TOPBAR ================= */

.topbar{

    background:
    rgba(15,23,42,0.92);

    border-radius:22px;

    padding:22px 28px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:35px;

    border:
    1px solid rgba(255,255,255,0.06);

    box-shadow:
    0px 8px 25px rgba(0,0,0,0.35);
}

.topbar h2{

    font-weight:700;

    margin:0;

    color:#ffffff;
}

.topbar h5{

    margin:0;

    color:#cbd5e1;

    font-weight:500;
}

/* ================= DASHBOARD CARDS ================= */

/* ================= DASHBOARD CARDS ================= */

.dashboard-card{

    position:relative;

    overflow:hidden;

    border-radius:28px;

    padding:32px;

    color:white;

    transition:0.35s ease;

    box-shadow:
    0px 12px 30px rgba(0,0,0,0.35);

    min-height:190px;

    display:flex;

    align-items:center;
}

.dashboard-card:hover{

    transform:translateY(-8px) scale(1.02);

    box-shadow:
    0px 18px 35px rgba(0,0,0,0.45);
}

.dashboard-card::before{

    content:"";

    position:absolute;

    width:190px;

    height:190px;

    background:rgba(255,255,255,0.08);

    border-radius:50%;

    top:-70px;

    right:-70px;
}

.dashboard-card h5{

    font-size:17px;

    margin-bottom:14px;

    color:rgba(255,255,255,0.92);

    font-weight:500;
}

.dashboard-card h1{

    font-size:34px;

    font-weight:700;

    line-height:1.4;

    margin:0;
}

/* ICON STYLE */

.dashboard-card i{

    color:rgba(255,255,255,0.28);

    transition:0.3s ease;
}

.dashboard-card:hover i{

    transform:scale(1.12) rotate(-4deg);
}

/* ================= CARD COLORS ================= */

.blue{
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
}

.green{
    background:linear-gradient(135deg,#059669,#047857);
}

.orange{
    background:linear-gradient(135deg,#f59e0b,#d97706);
}

.red{
    background:linear-gradient(135deg,#ef4444,#dc2626);
}

.sky{
    background:linear-gradient(135deg,#0ea5e9,#0284c7);
}

.purple{
    background:linear-gradient(135deg,#7c3aed,#6d28d9);
}

.teal{
    background:linear-gradient(135deg,#14b8a6,#0f766e);
}

/* ================= MOBILE ================= */

@media(max-width:768px){

    .dashboard-card{

        min-height:160px;

        padding:24px;
    }

    .dashboard-card h1{

        font-size:26px;
    }

    .dashboard-card i{

        font-size:40px !important;
    }
}

</style>

</head>

<body>

<!-- ================= SIDEBAR ================= -->

<div class="sidebar">

<div class="logo">
📦 Smart<br>Inventory
</div>

<a href="dashboard.php" class="active">
<i class="fa fa-house"></i> Dashboard
</a>

<a href="products.php">
<i class="fa fa-box"></i> Products
</a>

<a href="suppliers.php">
<i class="fa fa-truck"></i> Suppliers
</a>

<a href="stock_in.php">
<i class="fa fa-arrow-trend-up"></i> Stock In
</a>

<a href="billing.php">
<i class="fa fa-file-invoice"></i> Billing
</a>

<a href="profile.php">
<i class="fa fa-user"></i> Profile
</a>

<a href="change_password.php">
<i class="fa fa-key"></i> Change Password
</a>

<a href="logout.php">
<i class="fa fa-right-from-bracket"></i> Logout
</a>

</div>

<!-- ================= MAIN CONTENT ================= -->

<div class="main-content">

<!-- TOPBAR -->

<div class="topbar">

<h2>
✨ Dashboard Overview
</h2>

<h5>
👋 Welcome,
<?php echo $_SESSION['admin']; ?>
</h5>

</div>

<!-- ================= DASHBOARD CARDS ================= -->

<div class="row g-4">

<!-- ================= FIRST ROW ================= -->

<div class="col-xl-4 col-md-6">
    <div class="dashboard-card blue">
        
        <div class="d-flex justify-content-between align-items-center">

            <div>
                <h5>📦 Total Products</h5>

                <h1>
                    <?php echo $total_products; ?>
                </h1>
            </div>

            <i class="fa fa-box fa-3x opacity-50"></i>

        </div>

    </div>
</div>

<div class="col-xl-4 col-md-6">
    <div class="dashboard-card green">

        <div class="d-flex justify-content-between align-items-center">

            <div>
                <h5>🚚 Suppliers</h5>

                <h1>
                    <?php echo $total_suppliers; ?>
                </h1>
            </div>

            <i class="fa fa-truck fa-3x opacity-50"></i>

        </div>

    </div>
</div>

<div class="col-xl-4 col-md-12">
    <div class="dashboard-card orange">

        <div class="d-flex justify-content-between align-items-center">

            <div>
                <h5>📈 Stock In</h5>

                <h1>
                    <?php echo $total_stockin; ?>
                </h1>
            </div>

            <i class="fa fa-arrow-trend-up fa-3x opacity-50"></i>

        </div>

    </div>
</div>

<!-- ================= SECOND ROW ================= -->

<div class="col-xl-6 col-md-6">
    <div class="dashboard-card red">

        <div class="d-flex justify-content-between align-items-center">

            <div>
                <h5>💵 Today's Sales</h5>

                <h1>
                    ₹ <?php echo number_format($today_sales,2); ?>
                </h1>
            </div>

            <i class="fa fa-indian-rupee-sign fa-3x opacity-50"></i>

        </div>

    </div>
</div>

<div class="col-xl-6 col-md-6">
    <div class="dashboard-card sky">

        <div class="d-flex justify-content-between align-items-center">

            <div>
                <h5>📅 Monthly Sales</h5>

                <h1>
                    ₹ <?php echo number_format($monthly_sales,2); ?>
                </h1>
            </div>

            <i class="fa fa-chart-line fa-3x opacity-50"></i>

        </div>

    </div>
</div>

<!-- ================= THIRD ROW ================= -->

<div class="col-xl-6 col-md-6">
    <div class="dashboard-card purple">

        <div class="d-flex justify-content-between align-items-center">

            <div>
                <h5>💰 Today's Profit</h5>

                <h1>
                    ₹ <?php echo number_format($today_profit,2); ?>
                </h1>
            </div>

            <i class="fa fa-wallet fa-3x opacity-50"></i>

        </div>

    </div>
</div>

<div class="col-xl-6 col-md-6">
    <div class="dashboard-card teal">

        <div class="d-flex justify-content-between align-items-center">

            <div>
                <h5>📊 Monthly Profit</h5>

                <h1>
                    ₹ <?php echo number_format($month_profit,2); ?>
                </h1>
            </div>

            <i class="fa fa-sack-dollar fa-3x opacity-50"></i>

        </div>

    </div>
</div>

</div>
<!-- ================= CHART ================= -->


</body>
</html>