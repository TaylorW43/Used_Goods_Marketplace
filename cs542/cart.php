<?php
include('functions.php');
if (!isLoggedIn()) {
	$_SESSION['msg'] = "You must log in first";
	header('location: login.php');
}
?>


<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

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
//echo "DB Connection Successful"."<br>";

//GET Buyer BID
$BID = $_SESSION['user']['Bid'];

$Cartid = getcartid($BID, $conn);

$result = getPIDs($Cartid, $conn);

$allow = true;

function querymul($sql, $attr, $conn){
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $results_array[] = $row[$attr];
    }
    return $results_array;
}

function query($sql, $attr, $conn){
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            return $row[$attr];
        }
    }
}

function itemcheck($PID, $conn){
    $sql = 'SELECT EXISTS( SELECT 1 FROM Products WHERE PID="'.$PID.'") AS mycheck';
    $attr = "mycheck";
    $result = query($sql, $attr, $conn);
    return $result;
}

//Return the card id of the current buyer
function getcartid($BID, $conn){
    $sql_cartid = 'SELECT B.Cartid FROM Buy B  WHERE BID="'.$BID.'"';
    $attr_cartid = "Cartid";
    $result[] = query($sql_cartid, $attr_cartid, $conn);
    return $result[0];
}

function getPIDs($CID, $conn){
    $sql_PID = 'SELECT C.PID FROM in_cart C  WHERE C.Cartid = "'.$CID.'"';
    $attr_Name = "PID";
    $result = querymul($sql_PID, $attr_Name, $conn);
    return $result;
}

function getproducts_main($PID, $conn){

    $sql_Name = 'SELECT P.PName FROM Products P  WHERE PID="'.$PID.'"';
    $attr_Name = "PName";
    $sql_Price = 'SELECT P.Price FROM Products P WHERE PID="'.$PID.'"';
    $attr_Price = "Price";
    $sql_Make = 'SELECT P.PMake FROM Products P WHERE PID="'.$PID.'"';
    $attr_Make = "PMake";
    $sql_Pic = 'SELECT P.PicPath FROM Products P WHERE PID="'.$PID.'"';
    $attr_Pic = "PicPath";

    $result[] = query($sql_Name, $attr_Name, $conn);
    $result[] = query($sql_Price, $attr_Price, $conn);
    $result[] = query($sql_Make, $attr_Make, $conn);
    $result[] = query($sql_Pic, $attr_Pic, $conn);
    $result[] = $PID;

    return $result;
}

?>

<script>

    function remove(str) {
        var PID_del

        if (str ==""){
            // Nothing is being passed
            return;
        }
        else{
            // Passs the PID_del in, and initialize the request
            PID_del = str
            xmlhttp = new XMLHttpRequest();
            // GET to the controller php
            xmlhttp.open("GET","cart_deleteController.php?PID_del="+PID_del,true);
            xmlhttp.send();
            // Pop alert box to buy time for PHP
            alert("Remove Successfull");
            location.reload();
        }
    }

</script>


<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-10 col-md-offset-1">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Product</th>
                    <th class="text-center">Price</th>
                    <th> </th>
                </tr>
                </thead>
                <tbody>

                <?php
                $Total = 0.0;
                if (empty($result)){
                    echo "<h1>You have nothing in your Cart</h1>";
                }
                else {
                    foreach ($result as $PID) {
                        $display = true;
                        $stas = itemcheck($PID, $conn);
                        if ($stas){
                            // Current item is good to be check out, display normal
                            $display = true;

                        }
                        else {
                            // Else, shadow the item, set global allow = false.
                            // Display info for user to remove item.
                            $allow = false;
                            $display =  false;
                        }
                        $product = getproducts_main($PID, $conn);
                        $Total = $Total + (double)$product[1];
                        echo '<tr>';
                        echo '<td class="col-sm-8 col-md-6">';
                        echo '<div class="media">';
                        echo '<a class="thumbnail pull-left" href="#"> <img class="media-object" src="https://stefanzhang.com/cs542/pic/Usertemp/' . $product[3] . '"style="width: 72px; height: 72px;"> </a>';
                        echo '<div class="media-body">';
                        echo '<h4 class="media-heading">' . $product[0] . '</h4>';
                        echo '<h5 class="media-heading"> by ' . $product[2] . '</h5>';
                        echo '<span>Status: </span><span class="text-success"><strong>In Stock</strong></span>';
                        echo '</div>';
                        echo '</div>';
                        echo '</td>';
                        echo '<td class="col-sm-1 col-md-1 text-center"><strong>$' . $product[1] . '</strong></td>';
                        echo '<td class="col-sm-1 col-md-1">';
                        echo '<button type="button" class="btn btn-danger" id="' . $product[4] . '" onclick="remove(this.id)"><span class="glyphicon glyphicon-remove"></span> Remove</button></td>';
                        echo '</tr>';
                    }
                }
                ?>

                <tr>
                    <td><h3>Total</h3></td>
                    <?php echo '<td class="text-right"><h3><strong> $'.$Total.'</strong></h3></td>';?>
                </tr>
                <tr>
                    <td>
                        <button type="button" class="btn btn-default">
                            <span class="glyphicon glyphicon-shopping-cart"></span> <a href="https://stefanzhang.com/cs542/index.php" /a>Continue Shopping
                        </button></td>
                    <td>
                        <button type="button" class="btn btn-success">
                            <?php
                            echo '<span class="glyphicon glyphicon-play""></span>';
                            echo '<a href="https://stefanzhang.com/cs542/cart_checkoutController.php?BID='.$BID.'&Cartid='.$Cartid.'">Checkout</a>';
                            ?>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
