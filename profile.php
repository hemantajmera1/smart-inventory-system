<?php

session_start();

include 'db.php';

// ADMIN CHECK

if(!isset($_SESSION['admin'])){

    header("Location: login.php");
    exit();
}

$username = $_SESSION['admin'];

$query = "SELECT * FROM users WHERE username='$username'";

$result = mysqli_query($conn,$query);

$user = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Admin Profile</title>

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

/* PROFILE */

.profile-box{

    text-align:center;
}

.profile-icon{

    width:120px;

    height:120px;

    border-radius:50%;

    background:linear-gradient(
        135deg,
        #2563eb,
        #7c3aed
    );

    display:flex;

    align-items:center;

    justify-content:center;

    margin:auto;

    font-size:50px;

    margin-bottom:20px;

    box-shadow:0px 5px 20px rgba(0,0,0,0.3);
}

.info-box{

    background:rgba(255,255,255,0.08);

    padding:15px;

    border-radius:14px;

    margin-bottom:15px;
}

.info-box h5{

    color:#cbd5e1;

    margin-bottom:5px;

    font-size:15px;
}

.info-box p{

    margin:0;

    font-size:17px;

    font-weight:600;
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

<a href="stock_in.php">
<i class="fa fa-arrow-trend-up"></i> Stock In
</a>



<a href="billing.php">
<i class="fa fa-file-invoice"></i> Billing
</a>

<a href="profile.php" class="active">
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

<div class="card p-5">

<div class="profile-box">

<div class="profile-icon">

<i class="fa fa-user"></i>

</div>

<h2 class="mb-4">
👤 Admin Profile
</h2>

</div>

<div class="info-box">

<h5>
Full Name
</h5>

<p>
<?php echo $user['full_name']; ?>
</p>

</div>

<div class="info-box">

<h5>
Username
</h5>

<p>
<?php echo $user['username']; ?>
</p>

</div>

<div class="info-box">

<h5>
Email
</h5>

<p>
<?php echo $user['email']; ?>
</p>

</div>

<div class="info-box">

<h5>
Role
</h5>

<p>
<?php echo $user['role']; ?>
</p>

</div>

</div>

</div>

</body>
</html>