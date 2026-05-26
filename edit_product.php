<?php

session_start();

include 'db.php';

// ADMIN CHECK

if(!isset($_SESSION['admin'])){

    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

// FETCH PRODUCT

$query = "SELECT * FROM products WHERE id='$id'";

$result = mysqli_query($conn,$query);

$row = mysqli_fetch_assoc($result);

// UPDATE PRODUCT

if(isset($_POST['update_product'])){

    $name = mysqli_real_escape_string($conn,$_POST['product_name']);

    $category = mysqli_real_escape_string($conn,$_POST['category']);

    $barcode = mysqli_real_escape_string($conn,$_POST['barcode']);

    $cost_price = $_POST['cost_price'];

    $selling_price = $_POST['selling_price'];

    $quantity = $_POST['quantity'];

    // IMAGE UPDATE

    if($_FILES['image']['name'] != ''){

        $image = $_FILES['image']['name'];

        $tmp_name = $_FILES['image']['tmp_name'];

        $image_name = time().'_'.$image;

        move_uploaded_file($tmp_name,"uploads/".$image_name);

        $update = "UPDATE products SET

        product_name='$name',
        category='$category',
        barcode='$barcode',
        cost_price='$cost_price',
        selling_price='$selling_price',
        quantity='$quantity',
        image='$image_name'

        WHERE id='$id'";

    }else{

        $update = "UPDATE products SET

        product_name='$name',
        category='$category',
        barcode='$barcode',
        cost_price='$cost_price',
        selling_price='$selling_price',
        quantity='$quantity'

        WHERE id='$id'";
    }

    mysqli_query($conn,$update);

    header("Location: products.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Edit Product</title>

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

    border-radius:20px;

    box-shadow:0px 5px 20px rgba(0,0,0,0.4);
}

/* FORM */

.form-control{

    border-radius:12px;

    padding:12px;

    border:none;
}

.btn{

    border-radius:30px;

    font-weight:600;
}

/* IMAGE */

.product-img{

    width:120px;

    height:120px;

    object-fit:cover;

    border-radius:15px;

    border:3px solid white;
}

/* PROFIT BOX */

.profit-box{

    background:#198754;

    color:white;

    padding:12px;

    border-radius:12px;

    font-size:18px;

    font-weight:bold;

    text-align:center;
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

<a href="products.php" class="active">
<i class="fa fa-box"></i> Products
</a>

<a href="suppliers.php">
<i class="fa fa-truck"></i> Suppliers
</a>

<a href="stock_in.php">
<i class="fa fa-arrow-trend-up"></i> Stock In
</a>

<a href="stock_out.php">
<i class="fa fa-arrow-trend-down"></i> Stock Out
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

<div class="container">

<div class="card p-4">

<h2 class="mb-4">
✏️ Edit Product
</h2>

<form method="POST" enctype="multipart/form-data">

<div class="text-center mb-4">

<img
src="uploads/<?php echo $row['image']; ?>"
class="product-img">

</div>

<label class="mb-2">
📦 Product Name
</label>

<input type="text"
name="product_name"
class="form-control mb-3"
value="<?php echo $row['product_name']; ?>"
required>

<label class="mb-2">
📂 Category
</label>

<input type="text"
name="category"
class="form-control mb-3"
value="<?php echo $row['category']; ?>"
required>

<label class="mb-2">
📡 Barcode
</label>

<input type="text"
name="barcode"
class="form-control mb-3"
value="<?php echo $row['barcode']; ?>"
required>

<label class="mb-2">
💰 Cost Price
</label>

<input type="number"
step="0.01"
name="cost_price"
id="cost_price"
class="form-control mb-3"
value="<?php echo $row['cost_price']; ?>"
required>

<label class="mb-2">
🏷 Selling Price
</label>

<input type="number"
step="0.01"
name="selling_price"
id="selling_price"
class="form-control mb-3"
value="<?php echo $row['selling_price']; ?>"
required>

<div class="profit-box mb-3">

Profit :
₹ <span id="profit">

<?php echo $row['selling_price'] - $row['cost_price']; ?>

</span>

</div>

<label class="mb-2">
📦 Quantity
</label>

<input type="number"
name="quantity"
class="form-control mb-3"
value="<?php echo $row['quantity']; ?>"
required>

<label class="mb-2">
🖼 Change Image
</label>

<input type="file"
name="image"
class="form-control mb-4">

<button
name="update_product"
class="btn btn-success px-4">

✅ Update Product

</button>

<a href="products.php"
class="btn btn-danger px-4">

⬅ Back

</a>

</form>

</div>

</div>

</div>

<script>

// LIVE PROFIT CALCULATION

const costPrice =
document.getElementById("cost_price");

const sellingPrice =
document.getElementById("selling_price");

const profit =
document.getElementById("profit");

function calculateProfit(){

    let cost = parseFloat(costPrice.value) || 0;

    let sell = parseFloat(sellingPrice.value) || 0;

    let totalProfit = sell - cost;

    profit.innerHTML = totalProfit.toFixed(2);
}

costPrice.addEventListener("input", calculateProfit);

sellingPrice.addEventListener("input", calculateProfit);

</script>

</body>
</html>