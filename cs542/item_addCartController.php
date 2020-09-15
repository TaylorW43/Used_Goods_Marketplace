<?php
include('functions.php');

if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}



$servername = "localhost";
$username = "cs542";
$password = "cs542";
$dbname = "cs542";
// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
// 检测连接
if (!$conn) {
    die("DB Connection failed: " . mysqli_connect_error());
}

$PID = $_GET['PID'];
$Cartid = $_GET['Cartid'];

function insert_cart($PID, $Cartid, $conn){
    $SQL = 'INSERT INTO in_cart (Cartid, Pid) VALUES ("'.$Cartid.'","'.$PID.'")';
    if ($conn->query($SQL)){
        echo '<h1> Add to Cart Successfull</h1>';
    }

    else {
        echo "<h1> SQL ERROR, Item is already in the Cart</h1>";
    }
}

// Insert corresponding item to the cart
insert_cart($PID, $Cartid, $conn);
?>

<a href="https://stefanzhang.com/cs542"> Return </a>
