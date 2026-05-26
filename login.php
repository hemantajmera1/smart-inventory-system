<?php
session_start();
include 'db.php';

$error = "";

if(isset($_POST['login'])){

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM users 
              WHERE username='$username' 
              AND password='$password'";

    $result = mysqli_query($conn,$query);

    if(mysqli_num_rows($result) > 0){

        $_SESSION['admin'] = $username;
        header("Location: dashboard.php");
        exit();

    }else{
        $error = "Invalid Username or Password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Smart Inventory Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

/* ===== MATCHED DASHBOARD STYLE THEME ===== */

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    overflow:hidden;
    background:#d3cefb; /* SAME DASHBOARD BASE */
    position:relative;
}

/* BACKGROUND GLOW (same dashboard vibe) */

.circle{
    position:absolute;
    border-radius:50%;
    filter:blur(30px);
}

.circle1{
    width:300px;
    height:300px;
    background:#607dfd;
    top:-100px;
    left:-100px;
    opacity:0.35;
}

.circle2{
    width:350px;
    height:350px;
    background:#1761ff;
    bottom:-120px;
    right:-120px;
    opacity:0.25;
}

.circle3{
    width:200px;
    height:200px;
    background:#8fa8ff;
    top:50%;
    left:10%;
    opacity:0.2;
}

/* LOGIN CARD (dashboard style dark glass) */

.login-box{
    width:420px;
    padding:40px;
    border-radius:25px;

    background: rgba(17,24,39,0.92);
    backdrop-filter: blur(14px);

    border:1px solid rgba(255,255,255,0.06);

    box-shadow:0px 15px 40px rgba(0,0,0,0.4);

    z-index:10;
    animation:fadeIn 1s ease;
}

@keyframes fadeIn{
    from{opacity:0; transform:translateY(40px);}
    to{opacity:1; transform:translateY(0);}
}

/* LOGO */

.logo{
    text-align:center;
    margin-bottom:25px;
}

.logo-circle{
    width:85px;
    height:85px;
    margin:auto;
    border-radius:50%;
    display:flex;
    justify-content:center;
    align-items:center;

    background:linear-gradient(135deg,#2563eb,#3b82f6);
    box-shadow:0 0 20px rgba(37,99,235,0.5);
}

.logo-circle i{
    font-size:38px;
    color:white;
}

.logo h2{
    color:white;
    margin-top:15px;
    font-weight:700;
}

.logo p{
    color:#cbd5e1;
    font-size:14px;
}

/* INPUTS */

.input-box{
    position:relative;
    margin-bottom:18px;
}

.input-box input{
    width:100%;
    height:55px;
    border:none;
    outline:none;
    border-radius:14px;

    background:rgba(255,255,255,0.06);
    color:white;

    padding-left:50px;
    font-size:15px;
}

.input-box input::placeholder{
    color:#94a3b8;
}

.input-box i{
    position:absolute;
    left:18px;
    top:18px;
    color:#94a3b8;
}

/* ERROR */

.error-box{
    background:linear-gradient(135deg,#ef4444,#ff6b6b);
    color:white;
    padding:10px;
    border-radius:12px;
    text-align:center;
    margin-bottom:15px;
}

/* BUTTON */

.login-btn{
    width:100%;
    height:55px;
    border:none;
    border-radius:14px;

    background:linear-gradient(135deg,#2563eb,#3b82f6);
    color:white;

    font-size:17px;
    font-weight:600;

    transition:0.3s;
}

.login-btn:hover{
    transform:translateY(-3px);
    box-shadow:0 10px 20px rgba(37,99,235,0.4);
}

/* FOOTER */

.footer{
    text-align:center;
    margin-top:20px;
    color:#94a3b8;
    font-size:13px;
}

/* RESPONSIVE */

@media(max-width:480px){
    .login-box{
        width:92%;
        padding:30px;
    }
}

</style>

</head>

<body>

<div class="circle circle1"></div>
<div class="circle circle2"></div>
<div class="circle circle3"></div>

<div class="login-box">

    <div class="logo">
        <div class="logo-circle">
    <i class="fa-solid fa-warehouse"></i>
</div>
        <h2>Smart Inventory</h2>
        <p>Inventory Management System</p>
    </div>

    <?php if($error != ""){ ?>
        <div class="error-box"><?php echo $error; ?></div>
    <?php } ?>

    <form method="POST">

        <div class="input-box">
            <i class="fa fa-user"></i>
            <input type="text" name="username" placeholder="Enter Username" required>
        </div>

        <div class="input-box">
            <i class="fa fa-lock"></i>
            <input type="password" name="password" placeholder="Enter Password" required>
        </div>

        <button class="login-btn" name="login">
            Login Now
        </button>

    </form>

    <div class="footer">
    Secure • Fast • Smart Inventory Control
</div>
</div>

</body>
</html>