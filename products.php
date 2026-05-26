<?php

session_start();

include 'db.php';

// ADMIN CHECK

if(!isset($_SESSION['admin'])){

    header("Location: login.php");
    exit();
}

// ADD PRODUCT

if(isset($_POST['add_product'])){

    $name = mysqli_real_escape_string(
        $conn,
        $_POST['product_name']
    );

    $category = mysqli_real_escape_string(
        $conn,
        $_POST['category']
    );

    $barcode = mysqli_real_escape_string(
        $conn,
        $_POST['barcode']
    );

    $cost_price = $_POST['cost_price'];

    $selling_price = $_POST['selling_price'];

    $gst = $_POST['gst'];

    $quantity = $_POST['quantity'];

    // IMAGE

    $image = $_FILES['image']['name'];

    $tmp_name = $_FILES['image']['tmp_name'];

    $image_name = time().'_'.$image;

    move_uploaded_file(
        $tmp_name,
        "uploads/".$image_name
    );

    // INSERT PRODUCT

    $query = "INSERT INTO products
    (
        product_name,
        category,
        barcode,
        cost_price,
        selling_price,
        gst,
        quantity,
        image
    )

    VALUES
    (
        '$name',
        '$category',
        '$barcode',
        '$cost_price',
        '$selling_price',
        '$gst',
        '$quantity',
        '$image_name'
    )";

    mysqli_query($conn,$query);

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

<title>Products</title>

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

    background:linear-gradient(
        135deg,
        #4e54c8,
        #8f94fb
    );

    min-height:100vh;

    font-family:'Poppins',sans-serif;

    overflow-x:hidden;

    color:white;
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

    z-index:1000;

    box-shadow:5px 0px 25px rgba(0,0,0,0.3);
}

.logo{

    text-align:center;

    font-size:28px;

    font-weight:700;

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

/* MAIN */

.main-content{

    margin-left:260px;

    padding:30px;
}

/* CARD */

.card{

    background:rgba(17,24,39,0.92);

    border:none;

    border-radius:22px;

    box-shadow:0px 8px 25px rgba(0,0,0,0.35);

    color:white;
}

/* FORM */

.form-control{

    border-radius:14px;

    border:none;

    padding:12px;

    font-weight:500;
}

/* BUTTON */

.btn{

    border-radius:30px;

    font-weight:600;

    padding:10px 20px;
}

/* TABLE */

.table{

    color:white !important;
}

.table th{

    background:#4f46e5;

    border:none;
}

/* PRODUCT IMAGE */

.product-img{

    width:70px;

    height:70px;

    object-fit:cover;

    border-radius:12px;

    border:2px solid rgba(255,255,255,0.2);
}

/* BADGES */

.badge{

    padding:8px 12px;

    border-radius:20px;

    font-size:13px;
}

.profit{

    background:#16a34a;
}

.loss{

    background:#dc2626;
}

.noprofit{

    background:#64748b;
}

/* RESPONSIVE */

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

<a href="products.php" class="active">
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

<!-- MAIN CONTENT -->

<div class="main-content">

<!-- ADD PRODUCT -->

<div class="card p-4 mb-4">

<h2 class="mb-4">
➕ Add Product
</h2>

<form method="POST" enctype="multipart/form-data">

<div class="row">

<div class="col-md-6">

<input type="text"
name="product_name"
class="form-control mb-3"
placeholder="Product Name"
required>

</div>

<div class="col-md-6">

<input type="text"
name="category"
class="form-control mb-3"
placeholder="Category"
required>

</div>

<div class="col-md-6">

<input type="text"
name="barcode"
class="form-control mb-3"
placeholder="Barcode"
required>

</div>

<div class="col-md-6">

<input type="number"
step="0.01"
name="cost_price"
id="cost_price"
class="form-control mb-3"
placeholder="Cost Price"
required>

</div>

<div class="col-md-6">

<input type="number"
step="0.01"
name="selling_price"
id="selling_price"
class="form-control mb-3"
placeholder="Selling Price"
required>

</div>

<div class="col-md-6">

<select
name="gst"
class="form-control mb-3"
required>

<option value="">
Select GST %
</option>

<option value="0">
0%
</option>

<option value="5">
5%
</option>

<option value="12">
12%
</option>

<option value="18">
18%
</option>

<option value="28">
28%
</option>

</select>

</div>

<div class="col-md-6">

<input type="number"
name="quantity"
class="form-control mb-3"
placeholder="Quantity"
required>

</div>

<div class="col-md-12">

<input type="file"
name="image"
class="form-control mb-3"
required>

</div>

</div>

<!-- LIVE PROFIT -->

<div class="alert alert-success">

<b>
Profit:
₹ <span id="profit">0</span>
</b>

</div>

<button
type="submit"
name="add_product"
class="btn btn-primary">

➕ Add Product

</button>

</form>

</div>

<!-- PRODUCT LIST -->

<div class="card p-4">

<h2 class="mb-4">
📦 Product Inventory
</h2>

<div class="table-responsive">

<table class="table table-dark table-bordered table-hover text-center align-middle">

<tr>

<th>ID</th>
<th>Image</th>
<th>Name</th>
<th>Category</th>
<th>Barcode</th>
<th>Cost</th>
<th>Selling</th>
<th>GST</th>
<th>Profit</th>
<th>Qty</th>
<th>Action</th>

</tr>

<?php

$query = "SELECT * FROM products ORDER BY id DESC";

$result = mysqli_query($conn,$query);

while($row = mysqli_fetch_assoc($result)){

    $base_selling_price =
($row['selling_price'] * 100) /
(100 + $row['gst']);

$profit =
$base_selling_price - $row['cost_price'];

?>

<tr>

<td>
<?php echo $row['id']; ?>
</td>

<td>

<img
src="uploads/<?php echo $row['image']; ?>"
class="product-img">

</td>

<td>
<?php echo $row['product_name']; ?>
</td>

<td>
<?php echo $row['category']; ?>
</td>

<td>
<?php echo $row['barcode']; ?>
</td>

<td>
₹ <?php echo $row['cost_price']; ?>
</td>

<td>
₹ <?php echo $row['selling_price']; ?>
</td>

<td>

<span class="badge bg-info">

<?php echo $row['gst']; ?>%

</span>

</td>

<td>

<?php

if($profit > 0){

    echo "<span class='badge profit'>
    Profit ₹ ".number_format($profit,2)."
    </span>";

}elseif($profit < 0){

    echo "<span class='badge loss'>
    Loss ₹ ".number_format(abs($profit),2)."
    </span>";

}else{

    echo "<span class='badge noprofit'>
    No Profit
    </span>";
}

?>

</td>

<td>

<?php

if($row['quantity'] < 10){

    echo "<span class='badge bg-danger'>
    ".$row['quantity']."
    </span>";

}else{

    echo "<span class='badge bg-primary'>
    ".$row['quantity']."
    </span>";
}

?>

</td>

<td>

<a
href="edit_product.php?id=<?php echo $row['id']; ?>"
class="btn btn-warning btn-sm">

✏ Edit

</a>

<a
href="delete_product.php?id=<?php echo $row['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete Product?')">

🗑 Delete

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</div>

<script>

const costPrice =
document.getElementById("cost_price");

const sellingPrice =
document.getElementById("selling_price");

const profit =
document.getElementById("profit");

function calculateProfit(){

    let cost =
    parseFloat(costPrice.value) || 0;

    let sell =
    parseFloat(sellingPrice.value) || 0;

   let gst =
parseFloat(
document.querySelector('[name="gst"]').value
) || 0;

let baseSelling =
(sell * 100) / (100 + gst);

let totalProfit =
baseSelling - cost;

    profit.innerHTML =
    totalProfit.toFixed(2);
}

costPrice.addEventListener(
    "input",
    calculateProfit
);

sellingPrice.addEventListener(
    "input",
    calculateProfit
);

</script>

</body>
</html>