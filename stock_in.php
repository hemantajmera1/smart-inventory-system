<?php

session_start();

include 'db.php';

// ADMIN CHECK
if(!isset($_SESSION['admin'])){

    header("Location: login.php");
    exit();
}

// STOCK IN
if(isset($_POST['stock_in'])){

    $product_id = $_POST['product_id'];

    $quantity = $_POST['quantity'];

    // INSERT HISTORY

    $insert = "INSERT INTO stock_in(product_id,quantity)

    VALUES('$product_id','$quantity')";

    mysqli_query($conn,$insert);

    // UPDATE PRODUCT QUANTITY

    $update = "UPDATE products

    SET quantity = quantity + '$quantity'

    WHERE id='$product_id'";

    mysqli_query($conn,$update);

    header("Location: stock_in.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Stock In</title>

<!-- BOOTSTRAP -->

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- FONT AWESOME -->

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<!-- GOOGLE FONT -->

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{

    background: linear-gradient(135deg,#4e54c8,#8f94fb);

    min-height:100vh;

    color:white;

    font-family:'Poppins',sans-serif;

    overflow-x:hidden;
}

/* SIDEBAR */

.sidebar{

    position:fixed;

    top:0;

    left:0;

    width:260px;

    height:100vh;

    background:linear-gradient(
        180deg,
        #0f172a,
        #1e293b,
        #334155
    );

    padding-top:20px;

    box-shadow:5px 0px 25px rgba(0,0,0,0.2);

    z-index:1000;
}

.logo{

    text-align:center;

    font-size:28px;

    font-weight:700;

    color:white;

    margin-bottom:35px;

    letter-spacing:1px;
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

    background:linear-gradient(
        135deg,
        #2563eb,
        #3b82f6
    );

    color:white;

    transform:translateX(5px);

    box-shadow:0px 8px 20px rgba(37,99,235,0.3);
}

/* MAIN CONTENT */

.main-content{

    margin-left:260px;

    padding:30px;
}

/* CARD */

.card{

    background: rgba(17,24,39,0.92);

    color:white;

    border:none;

    border-radius:22px;

    box-shadow:0px 8px 25px rgba(0,0,0,0.35);
}

/* FORM */

.form-control{

    border-radius:14px;

    padding:12px;

    border:none;

    font-size:15px;
}

/* TABLE */

.table{

    background:white;

    border-radius:15px;

    overflow:hidden;
}

.table th{

    background:#4f46e5;

    color:white;

    font-weight:600;
}

/* BUTTON */

.btn{

    border-radius:30px;

    font-weight:600;

    padding:8px 18px;
}

/* MOBILE */

@media(max-width:768px){

    .sidebar{

        width:100%;

        height:auto;

        position:relative;
    }

    .main-content{

        margin-left:0;

        padding:15px;
    }
}

</style>

</head>

<body>

<!-- SIDEBAR -->

<div class="sidebar">

<div class="logo">
📦 Smart Inventory
</div>

<a href="dashboard.php">
<i class="fa fa-house"></i> Dashboard
</a>

<a href="products.php">
<i class="fa fa-box"></i> Products
</a>

<a href="suppliers.php">
<i class="fa fa-truck"></i> Suppliers
</a>

<a href="stock_in.php" class="active">
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

<!-- MAIN CONTENT -->

<div class="main-content">

<!-- STOCK IN FORM -->

<div class="card p-4">

<h2 class="mb-4">
📈 Stock In
</h2>

<form method="POST">

<select
name="product_id"
class="form-control mb-3"
required>

<option value="">
Select Product
</option>

<?php

$product = "SELECT * FROM products";

$result = mysqli_query($conn,$product);

while($row = mysqli_fetch_assoc($result)){

?>

<option value="<?php echo $row['id']; ?>">

<?php echo $row['product_name']; ?>

</option>

<?php } ?>

</select>

<input type="number"
name="quantity"
class="form-control mb-3"
placeholder="Enter Quantity"
required>

<button
name="stock_in"
class="btn btn-success">

➕ Add Stock

</button>

</form>

</div>

<!-- HISTORY -->


<div class="card p-4 mt-4">

<h2 class="mb-4">
📜 Stock In History
</h2>

<div class="table-responsive">

<table class="table table-bordered table-striped text-center align-middle">

<tr>

<th>Product Name</th>
<th>Quantity</th>
<th>Date</th>

</tr>

<?php

$history = "
SELECT stock_in.*, products.product_name
FROM stock_in
INNER JOIN products
ON stock_in.product_id = products.id
ORDER BY stock_in.date_added DESC
";

$history_result = mysqli_query($conn,$history);

while($row = mysqli_fetch_assoc($history_result)){

?>

<tr>

<td>
<?php echo $row['product_name']; ?>
</td>

<td>
<?php echo $row['quantity']; ?>
</td>

<td>
<?php echo $row['date_added']; ?>
</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>
</html>