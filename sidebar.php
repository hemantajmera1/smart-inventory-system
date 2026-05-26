<?php

$current_page = basename($_SERVER['PHP_SELF']);

?>

<style>

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

    border-right:1px solid rgba(255,255,255,0.08);

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

@media(max-width:768px){

    .sidebar{
        width:100%;
        height:auto;
        position:relative;
    }
}

</style>

<div class="sidebar">

<div class="logo">
📦 Smart Inventory
</div>

<a href="dashboard.php"
class="<?php if($current_page=='dashboard.php'){ echo 'active'; } ?>">

<i class="fa fa-house"></i>
Dashboard

</a>

<a href="products.php"
class="<?php if($current_page=='products.php'){ echo 'active'; } ?>">

<i class="fa fa-box"></i>
Products

</a>

<a href="suppliers.php"
class="<?php if($current_page=='suppliers.php'){ echo 'active'; } ?>">

<i class="fa fa-truck"></i>
Suppliers

</a>

<a href="stock_in.php"
class="<?php if($current_page=='stock_in.php'){ echo 'active'; } ?>">

<i class="fa fa-arrow-trend-up"></i>
Stock In

</a>



<a href="billing.php"
class="<?php if($current_page=='billing.php'){ echo 'active'; } ?>">

<i class="fa fa-file-invoice"></i>
Billing

</a>

<a href="profile.php"
class="<?php if($current_page=='profile.php'){ echo 'active'; } ?>">

<i class="fa fa-user"></i>
Profile

</a>

<a href="change_password.php"
class="<?php if($current_page=='change_password.php'){ echo 'active'; } ?>">

<i class="fa fa-key"></i>
Change Password

</a>

<a href="logout.php">

<i class="fa fa-right-from-bracket"></i>
Logout

</a>

</div>