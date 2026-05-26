<?php
include 'db.php';
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=products_report.xls");
echo "ID\tProduct Name\tCategory\tPrice\tQuantity\n";
$query = "SELECT * FROM products";
$result = mysqli_query($conn,$query);
while($row = mysqli_fetch_assoc($result)){
    echo $row['id']."\t";
    echo $row['product_name']."\t";
    echo $row['category']."\t";
    echo $row['price']."\t";
    echo $row['quantity']."\n";
}
?>