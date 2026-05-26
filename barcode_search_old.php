<?php

include 'db.php';

$product = null;

if(isset($_POST['barcode'])){

    $barcode = $_POST['barcode'];

    $query = "SELECT * FROM products
    WHERE barcode='$barcode'";

    $result = mysqli_query($conn,$query);

    $product = mysqli_fetch_assoc($result);

}

?>

<!DOCTYPE html>
<html>

<head>

<title>Auto Barcode Scanner</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{

    background:#121212;

    color:white;

}

.card{

     background: rgba(17,24,39,0.85);
    color:white;

    border:none;

    border-radius:15px;

    box-shadow:0px 2px 10px rgba(0,0,0,0.5);

}

input{

    height:55px;

    font-size:20px !important;

}

</style>

</head>

<body>

<div class="container mt-5">

<div class="card p-5">

<h2>📡 Smart Barcode Scanner</h2>

<hr>

<form method="POST" id="barcodeForm">

<input type="text"
name="barcode"
id="barcode"
class="form-control"
placeholder="Scan Barcode..."
autofocus
onchange="document.getElementById('barcodeForm').submit();"
required>

</form>

</div>

<?php if($product){ ?>

<div class="card p-4 mt-4">

<h3 class="mb-4">✅ Product Found</h3>

<div class="row">

<div class="col-md-4">

<img
src="uploads/<?php echo $product['image']; ?>"
width="200"
style="border-radius:15px;">

</div>

<div class="col-md-8">

<h2>
<?php echo $product['product_name']; ?>
</h2>

<p>
<b>Category:</b>
<?php echo $product['category']; ?>
</p>

<p>
<b>Barcode:</b>
<?php echo $product['barcode']; ?>
</p>

<p>
<b>Price:</b>
₹<?php echo $product['price']; ?>
</p>

<?php if($product['quantity'] > 0){ ?>

<h4 class="text-success">
✅ In Stock
</h4>

<p>
Available Quantity:
<b>
<?php echo $product['quantity']; ?>
</b>
</p>

<?php } else { ?>

<h3 class="text-danger">
❌ Out Of Stock
</h3>

<?php } ?>

</div>

</div>

</div>

<?php } ?>

</div>

<script>

document.getElementById("barcode").focus();

</script>

</body>
</html>