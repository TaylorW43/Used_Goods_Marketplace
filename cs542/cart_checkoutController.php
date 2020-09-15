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

$BID = $_GET['BID'];
$CID = $_GET['Cartid'];

function query($sql, $attr, $conn){
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            return $row[$attr];
        }
    }
}

function querymul($sql, $attr, $conn){
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $results_array[] = $row[$attr];
    }
    return $results_array;
}

function getPIDs($CID, $conn){
    $sql_PID = 'SELECT C.PID FROM in_cart C  WHERE C.Cartid = "'.$CID.'"';
    $attr_Name = "PID";
    $result = querymul($sql_PID, $attr_Name, $conn);
    return $result;
}
//

function deleteCart_item($CID, $conn){
    $sql = 'DELETE FROM in_cart WHERE Cartid = "'.$CID.'"';
    if ($conn->query($sql) === TRUE) {
        echo "<h2> Check out successfully </h2>";
        echo "<hr />";
    } else {
        echo "Error checkout record: " . $conn->error;
    }
}

function deleteproduct($PID, $conn){
    $sql = 'DELETE FROM Products WHERE Pid = "'.$PID.'"';
    $conn->query($sql);
}

function findproductname($PID, $conn){
    $sql = 'SELECT Pname FROM Products  WHERE Pid = "'.$PID.'"';
    $attr = "Pname";
    $name = query($sql, $attr, $conn);
    return $name;
}

function findOID($Item, $conn){
    $sql = 'SELECT Orderid FROM Order_history WHERE Item = "'.$Item.'"';
    $attr = "Orderid";
    $OID = query($sql, $attr, $conn);
    return $OID;
}

function deletefromsell($PID, $conn){
    $sql = 'DELETE FROM Sell WHERE Pid = "'.$PID.'"';
    $conn->query($sql);
}

function deletefromhas($PID, $conn){
    $sql = 'DELETE FROM Has WHERE Pid = "'.$PID.'"';
    $conn->query($sql);
}


// Find all the corresponding product ID
$Pids = getPIDs($CID, $conn);

// Insert to Order_history and has_order
foreach ($Pids as $PID) {
    $Item = findproductname($PID, $conn);
    $Item_quant = 1;
    // insert into order_history
    $sql = 'INSERT INTO Order_history (Item, Item_quant) VALUES ("'.$Item.'", "'.$Item_quant.'")';
    $conn->query($sql);

    // Return the item's OID to insert to has_order
    $OID = findOID($Item, $conn);
    // insert into has_order
    $sql2 = 'INSERT INTO Has_order (Orderid, Bid) VALUES ("'.$OID.'", "'.$BID.'")';
    $conn->query($sql2);
}

// Delete In-cart item
deleteCart_item($CID, $conn);

// For each checkout product
foreach ($Pids as $PID) {
    // Delete sell relation
    deletefromsell($PID, $conn);
    // Delete Has relation
    deletefromhas($PID, $conn);
    // Delete product
    deleteproduct($PID, $conn);
}

?>
<a href="https://stefanzhang.com/cs542"> Return </a>