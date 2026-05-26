<?php

include 'db.php';

$bill_no = $_GET['bill_no'];

// FETCH INVOICE

$query = "SELECT * FROM invoices WHERE bill_no='$bill_no'";

$result = mysqli_query($conn,$query);

$first = mysqli_fetch_assoc($result);

$customer_name = !empty($first['customer_name']) 
? $first['customer_name'] 
: 'Customer';

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Print Invoice</title>

<!-- BOOTSTRAP -->

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- FONT AWESOME -->

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<!-- GOOGLE FONT -->

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

body{

    background:#f1f5f9;

    font-family:'Poppins',sans-serif;
}

.invoice-box{

    max-width:950px;

    margin:auto;

    background:white;

    padding:35px;

    border-radius:20px;

    box-shadow:0px 5px 25px rgba(0,0,0,0.12);

    margin-top:40px;
}

.invoice-title{

    text-align:center;

    font-size:34px;

    font-weight:700;

    color:#4f46e5;

    margin-bottom:25px;
}

.info-box{

    background:#eef2ff;

    padding:18px;

    border-radius:15px;

    margin-bottom:25px;
}

.info-box p{

    margin-bottom:8px;

    font-size:15px;

    font-weight:500;
}

.table{

    border-radius:15px;

    overflow:hidden;
}

.table th{

    background:#4f46e5;

    color:white;

    text-align:center;

    font-size:15px;
}

.table td{

    text-align:center;

    vertical-align:middle;
}

.total-box{

    background:#dcfce7;

    padding:18px;

    border-radius:15px;

    font-size:22px;

    font-weight:700;

    text-align:right;

    color:#166534;

    margin-top:20px;
}

.btn{

    border-radius:30px;

    padding:10px 25px;

    font-weight:600;
}

@media print{

    .no-print{

        display:none;
    }

    body{

        background:white;
    }

    .invoice-box{

        box-shadow:none;

        margin-top:0;
    }
}

</style>

</head>

<body>

<div class="invoice-box">

<h2 class="invoice-title">
🧾 Smart Invoice
</h2>

<!-- INFO -->

<div class="info-box">

<div class="row">

<div class="col-md-6">

<p>
<b>Bill No :</b>
<?php echo $bill_no; ?>
</p>

<p>
<b>Customer :</b>
<?php echo $customer_name; ?>
</p>

</div>

<div class="col-md-6 text-md-end">

<p>
<b>Date :</b>
<?php echo $first['invoice_date']; ?>
</p>

</div>

</div>

</div>

<!-- TABLE -->

<div class="table-responsive">

<table class="table table-bordered">

<tr>

<th>Product</th>
<th>Base Price</th>
<th>GST %</th>
<th>GST Amount</th>
<th>Final Price</th>
<th>Qty</th>
<th>Total</th>

</tr>

<?php

$total_amount = 0;

$result = mysqli_query(
    $conn,
    "SELECT * FROM invoices WHERE bill_no='$bill_no'"
);

while($row = mysqli_fetch_assoc($result)){

    $price = $row['price'];

$qty = $row['quantity'];

$gst_percent = isset($row['gst']) 
? $row['gst'] 
: 0;

$gst_amount = isset($row['gst_amount']) 
? $row['gst_amount'] 
: 0;

// FINAL PRICE (MRP)

$final_price = $price;

// BASE PRICE

$base_price =
$final_price - ($gst_amount / $qty);

$base_price = round($base_price,2);

    $total = $row['total'];

    $total_amount += $total;

?>

<tr>

<td>
<?php echo $row['product_name']; ?>
</td>

<td>
₹ <?php echo number_format($base_price,2); ?>
</td>

<td>
<?php echo number_format($gst_percent,2); ?>%
</td>
 
<td>
₹ <?php echo number_format($gst_amount,2); ?>
</td>

<td>
₹ <?php echo number_format($final_price,2); ?>
</td>

<td>
<?php echo $qty; ?>
</td>

<td>
₹ <?php echo number_format($total,2); ?>
</td>

</tr>

<?php } ?>

</table>

</div>

<!-- GRAND TOTAL -->

<div class="total-box">

Grand Total :
₹ <?php echo number_format($total_amount,2); ?>

</div>

<!-- BUTTONS -->

<div class="mt-4 no-print">

<button
onclick="window.print()"
class="btn btn-primary">

🖨 Print Invoice

</button>

<a href="billing.php"
class="btn btn-secondary">

⬅ Back

</a>

</div>

</div>

</body>
</html>