<?php
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

//GET Buyer BID for now use 1
$BID = $_SESSION['user']['Bid'];

$PID_del = intval($_GET['PID_del']);

function delete_item($conn, $PID_del){
    $sql_delete = "DELETE FROM in_cart WHERE Pid ='".$PID_del."'";
    $conn->query($sql_delete);
}

delete_item($conn, $PID_del);
?>


