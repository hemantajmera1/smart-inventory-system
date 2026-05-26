<?php

session_start();

include 'db.php';

// CART SESSION

if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = [];
}

// ADMIN LOGIN CHECK

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

$message = "";

// ADD TO CART

if(isset($_POST['add_to_cart'])){

    $customer = trim($_POST['customer_name']);

    $_SESSION['customer_name'] = $customer;

    $product_id = intval($_POST['product_id']);

    $quantity = intval($_POST['quantity']);

    // PRODUCT DETAILS

    $product_query = "SELECT * FROM products WHERE id='$product_id'";

    $product_result = mysqli_query($conn,$product_query);

    if(mysqli_num_rows($product_result) > 0){

        $product = mysqli_fetch_assoc($product_result);

        $product_name = $product['product_name'];

        $price = $product['selling_price'];

        $gst = $product['gst'];

        $stock = $product['quantity'];

        
// GST INCLUDED PRICE CALCULATION

$final_price = $price;

$base_price =
($price * 100) / (100 + $gst);

$gst_amount =
$final_price - $base_price;

        // STOCK CHECK

        if($quantity > $stock){

            $message = "
            <div class='alert alert-danger'>
            ❌ Only $stock items available in stock
            </div>
            ";

        }else{

            $found = false;

            foreach($_SESSION['cart'] as &$item){

                if($item['product_id'] == $product_id){

                    $newQty = $item['quantity'] + $quantity;

                    if($newQty > $stock){

                        $message = "
                        <div class='alert alert-danger'>
                        ❌ Stock limit exceeded
                        </div>
                        ";

                    }else{

                        $item['quantity'] = $newQty;

                        header("Location: billing.php");
                        exit();
                    }

                    $found = true;

                    break;
                }
            }

            // NEW PRODUCT ADD

            if(!$found){

                $_SESSION['cart'][] = [

                    "product_id" => $product_id,

                    "product_name" => $product_name,

                    "price" => $price,
                    "base_price" => $base_price,
                    "gst" => $gst,

                    "gst_amount" => $gst_amount,

                    "final_price" => $final_price,

                    "quantity" => $quantity

                ];

                header("Location: billing.php");
                exit();
            }
        }
    }
}
// REMOVE ITEM

if(isset($_GET['remove'])){

    $index = $_GET['remove'];

    unset($_SESSION['cart'][$index]);

    $_SESSION['cart'] =
    array_values($_SESSION['cart']);

    header("Location: billing.php");

    exit();
}
// UPDATE QUANTITY

if(isset($_POST['update_qty'])){

    $index = $_POST['index'];

    $qty = intval($_POST['quantity']);

    if($qty > 0){

        $_SESSION['cart'][$index]['quantity']
        = $qty;
    }

    header("Location: billing.php");

    exit();
}
// GENERATE BILL

if(isset($_POST['generate_bill'])){

    if(!empty($_SESSION['cart'])){

        $customer = trim($_POST['customer_name']);

        $bill_no = "INV".time();

        foreach($_SESSION['cart'] as $item){

            $total =
            $item['final_price'] * $item['quantity'];

            $gst_total =
            $item['gst_amount'] * $item['quantity'];

            // INSERT INVOICE

            $insert = "INSERT INTO invoices
            (
                bill_no,
                customer_name,
                product_name,
                quantity,
                price,
                total,
                gst,
                gst_amount
            )

            VALUES

            (
                '$bill_no',
                '$customer',
                '{$item['product_name']}',
                '{$item['quantity']}',
                '{$item['price']}',
                '$total',
                '{$item['gst']}',
                '$gst_total'
            )";

            mysqli_query($conn,$insert);

            // STOCK UPDATE

            $pid = $item['product_id'];

            $stock_q = mysqli_query($conn,"
            SELECT quantity FROM products
            WHERE id='$pid'
            ");

            $stock = mysqli_fetch_assoc($stock_q);

            $new_stock =
            $stock['quantity'] - $item['quantity'];

            mysqli_query($conn,"
            UPDATE products
            SET quantity='$new_stock'
            WHERE id='$pid'
            ");
        }

        // CLEAR CART

        $_SESSION['cart'] = [];

        unset($_SESSION['customer_name']);

        header("Location: print_invoice.php?bill_no=$bill_no");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Smart Billing System</title>

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
    #0f172a,
    #111827,
    #1e293b
    );

    min-height:100vh;

    color:#f8fafc;

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

    z-index:1000;
}

.logo{

    text-align:center;

    font-size:28px;

    font-weight:700;

    color:#ffffff;

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
    0px 8px 20px rgba(37,99,235,0.4);
}

/* MAIN CONTENT */

.main-content{

    margin-left:260px;

    padding:30px;

    width:calc(100% - 260px);
}

/* CARD */

.card{

    border:none;

    border-radius:24px;

    overflow:hidden;

    box-shadow:
    0px 10px 30px rgba(0,0,0,0.35);
}

.main-card{

    background:
    rgba(15,23,42,0.96);

    color:#f8fafc;

    border:
    1px solid rgba(255,255,255,0.06);
}

/* FORM */

.form-control{

    background:#1e293b;

    border:1px solid #334155;

    color:white;

    border-radius:14px;

    padding:12px;
}

.form-control:focus{

    background:#1e293b;

    color:white;

    border-color:#3b82f6;

    box-shadow:
    0px 0px 10px rgba(59,130,246,0.35);
}

.form-control::placeholder{

    color:#94a3b8;
}

.form-label{

    color:#e2e8f0;

    font-weight:500;
}

/* TABLE */

.table-responsive{

    width:100%;

    overflow-x:auto;

    border-radius:18px;
}

.table{

    width:100%;

    min-width:900px;

    background:#0f172a;

    color:white;

    border-radius:18px;

    overflow:hidden;

    margin-bottom:0;
}

.table th{

    background:
    linear-gradient(
    135deg,
    #2563eb,
    #1d4ed8
    );

    color:white;

    border:none;

    padding:14px;

    font-size:15px;

    white-space:nowrap;
}

.table td{

    background:#111827;

    color:#f8fafc;

    border-color:#1e293b;

    padding:14px;

    vertical-align:middle;

    white-space:nowrap;
}

.table tr:hover td{

    background:#fff;
}

/* TOTAL ROW */

.total-row td{

    background:#0f172a !important;

    color:#38bdf8;

    font-size:18px;

    font-weight:700;
}

/* BUTTON */

.btn{

    border-radius:30px;

    font-weight:600;

    padding:10px 18px;

    transition:0.3s ease;
}

.btn:hover{

    transform:translateY(-2px);
}

.btn-warning{

    background:
    linear-gradient(
    135deg,
    #f59e0b,
    #d97706
    );

    border:none;

    color:white;
}

.btn-success{

    background:
    linear-gradient(
    135deg,
    #10b981,
    #059669
    );

    border:none;

    color:white;
}

.btn-sm{

    padding:8px 16px;

    font-size:14px;
}

/* ALERT */

.alert-danger{

    background:#7f1d1d;

    border:none;

    color:white;

    border-radius:14px;
}

/* HISTORY CARD */

.history-card{

    margin-top:35px;
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

        width:100%;

        padding:15px;
    }

    .table{

        min-width:750px;
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



<a href="billing.php" class="active">
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

<!-- BILLING CARD -->

<div class="card main-card p-4">

<h2 class="mb-4 text-center">
🧾 Smart Billing System
</h2>

<?php echo $message; ?>

<form method="POST" id="billingForm">
<input type="hidden" name="add_to_cart" value="1">
<div class="mb-3">

<label class="form-label">
👤 Customer Name
</label>

<input type="text"
name="customer_name"
class="form-control"
placeholder="Enter Customer Name"
value="<?php echo $_SESSION['customer_name'] ?? ''; ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">
📡 Scan Barcode
</label>

<input type="text"
id="barcode"
class="form-control"
placeholder="Scan Barcode Here">

</div>

<div class="mb-3">

<label class="form-label">
📦 Select Product
</label>

<select
name="product_id"
id="productSelect"
class="form-control"
required>

<option value="">
Select Product
</option>

<?php

$query =
"SELECT * FROM products WHERE quantity > 0";

$result =
mysqli_query($conn,$query);

while($row = mysqli_fetch_assoc($result)){

?>

<option
value="<?php echo $row['id']; ?>"
data-barcode="<?php echo $row['barcode']; ?>">

<?php echo $row['product_name']; ?>
(GST: <?php echo $row['gst']; ?>%)
(Stock: <?php echo $row['quantity']; ?>)

</option>

<?php } ?>

</select>

</div>

<div class="mb-3">

<label class="form-label">
🔢 Quantity
</label>

<input type="number"
name="quantity"
id="quantity"
class="form-control"
placeholder="Enter Quantity"
min="1"
required>

</div>

<button type="submit"
name="add_to_cart"
class="btn btn-warning w-100">

➕ Add To Cart

</button>

</form>

<!-- CART -->

<h3 class="mt-5">
🛒 Cart Details
</h3>

<div class="table-responsive">

<table class="table table-bordered text-center align-middle">

<tr>

<th>Product</th>
<th>Base Price</th>
<th>GST %</th>
<th>GST Amount</th>
<th>Final Price</th>
<th>Qty</th>
<th>Total</th>
<th>Action</th>

</tr>

<?php

$grand_total = 0;

if(!empty($_SESSION['cart'])){

    foreach($_SESSION['cart'] as $index => $item){

        $total =
        $item['final_price'] * $item['quantity'];

        $grand_total += $total;

        echo "

<tr>

<td>
{$item['product_name']}
</td>

<td>
₹ ".number_format($item['base_price'],2)."
</td>

<td>
".$item['gst']."%
</td>

<td>
₹ ".number_format($item['gst_amount'],2)."
</td>

<td>
₹ ".number_format($item['final_price'],2)."
</td>

<td>
".$item['quantity']."
</td>

<td>
₹ ".number_format($total,2)."
</td>

<td>

<form method='POST'
style='display:flex;gap:5px;'>

<input type='hidden'
name='index'
value='".$index."'>

<input type='number'
name='quantity'
value='".$item['quantity']."'
min='1'
class='form-control'
style='width:80px;'>

<button
type='submit'
name='update_qty'
class='btn btn-primary btn-sm'>

✏

</button>

<a href='billing.php?remove=".$index."'
class='btn btn-danger btn-sm'>

🗑

</a>

</form>

</td>

</tr>

";
    }
}
?>

<tr class="total-row">

<td colspan="6" class="text-end">
Grand Total
</td>

<td>
₹ <?php echo number_format($grand_total,2); ?>
</td>

</tr>

</table>

</div>

<?php if(!empty($_SESSION['cart'])){ ?>

<form method="POST">

<input type="hidden"
name="customer_name"
value="<?php echo $_SESSION['customer_name'] ?? ''; ?>">

<button
type="submit"
name="generate_bill"
class="btn btn-success w-100 mt-3">

🧾 Generate Final Bill

</button>

</form>

<?php } ?>

</div>

<!-- BILLING HISTORY -->

<div class="card main-card p-4 history-card">

<h2 class="mb-4 text-center">
📜 Billing History
</h2>

<div class="table-responsive">

<table class="table table-bordered text-center align-middle">

<tr>

<th>Bill No</th>
<th>Customer</th>
<th>Total Amount</th>
<th>Date</th>
<th>Print</th>

</tr>

<?php

$history_query = "

SELECT 
bill_no,
MAX(customer_name) as customer_name,
SUM(total) as grand_total,
MAX(invoice_date) as invoice_date

FROM invoices

GROUP BY bill_no

ORDER BY invoice_date DESC

LIMIT 10

";

$history_result = mysqli_query($conn,$history_query);

while($history = mysqli_fetch_assoc($history_result)){

?>

<tr>

<td>
<?php echo $history['bill_no']; ?>
</td>

<td>
<?php echo $history['customer_name']; ?>
</td>

<td>
₹ <?php echo number_format($history['grand_total'],2); ?>
</td>

<td>
<?php echo $history['invoice_date']; ?>
</td>

<td>

<a
href="print_invoice.php?bill_no=<?php echo $history['bill_no']; ?>"
class="btn btn-success btn-sm">

🖨 Print

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</div>

<script>

const barcodeInput =
document.getElementById("barcode");

const productSelect =
document.getElementById("productSelect");

const quantityInput =
document.getElementById("quantity");

const billingForm =
document.getElementById("billingForm");

// AUTO FOCUS

window.onload = function(){

    barcodeInput.focus();
};

// BARCODE SCAN

barcodeInput.addEventListener("keydown", function(e){

    // ENTER PRESS

    if(e.key === "Enter"){

        e.preventDefault();

        let barcode =
        barcodeInput.value.trim();

        let found = false;

        for(let option of productSelect.options){

            if(option.dataset.barcode === barcode){

                // SELECT PRODUCT

                productSelect.value = option.value;

                // AUTO QUANTITY

                quantityInput.value = 1;

                found = true;

                break;
            }
        }

        // AUTO SUBMIT

        if(found){

            billingForm.submit();
        }

        // CLEAR INPUT

        barcodeInput.value = "";

        // REFOCUS

        setTimeout(() => {

            barcodeInput.focus();

        }, 300);
    }
});

</script>



</body>
</html>