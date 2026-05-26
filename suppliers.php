<?php

session_start();

include 'db.php';

// ADMIN CHECK
if(!isset($_SESSION['admin'])){

    header("Location: login.php");
    exit();
}

// ADD SUPPLIER
if(isset($_POST['add_supplier'])){

    $name = mysqli_real_escape_string($conn,$_POST['supplier_name']);

    $phone = mysqli_real_escape_string($conn,$_POST['phone']);

    $address = mysqli_real_escape_string($conn,$_POST['address']);

    $query = "INSERT INTO suppliers
    (
        supplier_name,
        phone,
        address
    )

    VALUES

    (
        '$name',
        '$phone',
        '$address'
    )";

    mysqli_query($conn,$query);

    header("Location: suppliers.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Suppliers</title>

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

<a href="suppliers.php" class="active">
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

<!-- MAIN CONTENT -->

<div class="main-content">

<!-- ADD SUPPLIER -->

<div class="card p-4">

<h2 class="mb-4">
🚚 Add Supplier
</h2>

<form method="POST">

<div class="row">

<div class="col-md-6">

<input type="text"
name="supplier_name"
class="form-control mb-3"
placeholder="Supplier Name"
required>

</div>

<div class="col-md-6">

<input type="text"
name="phone"
class="form-control mb-3"
placeholder="Phone Number"
required>

</div>

<div class="col-md-12">

<textarea
name="address"
class="form-control mb-3"
placeholder="Address"
rows="4"></textarea>

</div>

</div>

<button
name="add_supplier"
class="btn btn-primary">

➕ Add Supplier

</button>

</form>

</div>

<!-- SUPPLIER LIST -->

<div class="card p-4 mt-4">

<h2 class="mb-4">
📋 Supplier List
</h2>

<div class="table-responsive">

<table class="table table-bordered table-striped text-center align-middle">

<tr>

<th>ID</th>

<th>Name</th>

<th>Phone</th>

<th>Address</th>

<th>Action</th>

</tr>

<?php

$query = "SELECT * FROM suppliers ORDER BY id DESC";

$result = mysqli_query($conn,$query);

while($row = mysqli_fetch_assoc($result)){

?>

<tr>

<td>

<?php echo $row['id']; ?>

</td>

<td>

<?php echo $row['supplier_name']; ?>

</td>

<td>

<?php echo $row['phone']; ?>

</td>

<td>

<?php echo $row['address']; ?>

</td>

<td>

<a
href="delete_supplier.php?id=<?php echo $row['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete Supplier?')">

🗑 Delete

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</div>

</body>
</html>