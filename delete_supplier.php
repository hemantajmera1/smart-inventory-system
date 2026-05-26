<?php

include 'db.php';

$id = $_GET['id'];

$query = "DELETE FROM suppliers WHERE id='$id'";

mysqli_query($conn,$query);

header("Location: suppliers.php");

?>