<?php

session_start();

include 'db.php';

// ADMIN CHECK

if(!isset($_SESSION['admin'])){

    header("Location: login.php");
    exit();
}

$username = $_SESSION['admin'];

// CHANGE PASSWORD

if(isset($_POST['change_password'])){

    $old_password = $_POST['old_password'];

    $new_password = $_POST['new_password'];

    // CHECK OLD PASSWORD

    $query = "SELECT * FROM users

    WHERE username='$username'

    AND password='$old_password'";

    $result = mysqli_query($conn,$query);

    if(mysqli_num_rows($result) > 0){

        // UPDATE PASSWORD

        $update = "UPDATE users

        SET password='$new_password'

        WHERE username='$username'";

        mysqli_query($conn,$update);

        $success = "✅ Password Changed Successfully";

    }else{

        $error = "❌ Old Password Incorrect";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Change Password</title>

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

    max-width:600px;

    margin:auto;
}

/* FORM */

.form-control{

    border-radius:14px;

    padding:12px;

    border:none;

    font-size:15px;
}

/* BUTTON */

.btn{

    border-radius:30px;

    font-weight:600;

    padding:10px 20px;
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

<a href="profile.php">
<i class="fa fa-user"></i> Profile
</a>

<a href="change_password.php" class="active">
<i class="fa fa-key"></i> Change Password
</a>

<a href="logout.php">
<i class="fa fa-right-from-bracket"></i> Logout
</a>

</div>

<!-- MAIN CONTENT -->

<div class="main-content">

<div class="card p-5">

<h2 class="mb-4">
🔒 Change Password
</h2>

<?php

if(isset($success)){

    echo "<div class='alert alert-success'>$success</div>";
}

if(isset($error)){

    echo "<div class='alert alert-danger'>$error</div>";
}

?>

<form method="POST">

<div class="mb-3">

<input type="password"
name="old_password"
class="form-control"
placeholder="Enter Old Password"
required>

</div>

<div class="mb-3">

<input type="password"
name="new_password"
class="form-control"
placeholder="Enter New Password"
required>

</div>

<button
name="change_password"
class="btn btn-primary w-100">

🔑 Change Password

</button>

</form>

</div>

</div>

</body>
</html>