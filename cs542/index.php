<?php
include('functions.php');

$Seller_ID = $_GET['Seller_ID'];
?>


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

//Get Current Buyer Bid through Session
$BID = $_SESSION['user']['Bid'];

$Sel = $_GET['Sel'];

// $sql is the sql ready for use, $attr is col name, $conn is connection instance
// This function will return the result as the string, just echo with html
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

function getproducts_main($PID, $conn){

    $sql_Name = 'SELECT P.PName FROM Products P  WHERE PID="'.$PID.'"';
    $attr_Name = "PName";
    $sql_Price = 'SELECT P.Price FROM Products P WHERE PID="'.$PID.'"';
    $attr_Price = "Price";
    $sql_Pic = 'SELECT P.PicPath FROM Products P WHERE PID="'.$PID.'"';
    $attr_Pic = "PicPath";

    $result[] = query($sql_Name, $attr_Name, $conn);
    $result[] = query($sql_Price, $attr_Price, $conn);
    $result[] = query($sql_Pic, $attr_Pic, $conn);

    return $result;
}

function getPCid($Sel, $conn){
    $sql = 'SELECT PCid FROM Product_Category  WHERE catename="'.$Sel.'"';
    $attr = 'PCid';
    $result = query($sql, $attr, $conn);
    return $result;
}

function getprodcutid($PCid, $conn){
    $sql = 'SELECT Pid FROM Has WHERE PCid="'.$PCid.'"';
    $attr = 'Pid';
    $result = querymul($sql, $attr, $conn);
    return $result;
}

if ($Sel){
    // If a value is selected, proceed the corresponding sql

    if ($Sel == "All"){
        $sql_ID_All = 'SELECT P.PID FROM Products P';
        $attr_Name = "PID";
        $result = querymul($sql_ID_All, $attr_Name, $conn);
    }
    else{
        $PCid = getPCid($Sel, $conn);
        $result = getprodcutid($PCid, $conn);
    }
//    $PCid = getPCid($Sel, $conn);
//    $result = getprodcutid($PCid, $conn);


}
else{
    // No val is selected, proceed the normal
    $sql_ID_All = 'SELECT P.PID FROM Products P';
    $attr_Name = "PID";
    $result = querymul($sql_ID_All, $attr_Name, $conn);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>MarketPlace</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <style>
        .fakeimg {
            height: 200px;
            background: #aaa;

        .topnav {
            overflow: hidden;
            background-color: #e9e9e9;
        }


        }
    </style>

    <script>
    function select(){
        var x = document.getElementById("select");
        window.location.href="https://stefanzhang.com/cs542/index.php?Sel="+x.value;
    }

    </script>

</head>
<body>

<!-- notification message -->
<?php if (isset($_SESSION['success'])) : ?>
    <div class="error success" >
        <h3>
            <?php
            echo $_SESSION['success'];
            unset($_SESSION['success']);
            ?>
        </h3>
    </div>
<?php endif ?>


<!-- logged in user information -->
<?php  if (isset($_SESSION['user'])) : ?>
    <strong><?php echo $_SESSION['user']['username']; ?></strong>
        <a href="index.php?logout='1'" style="color: red;">logout</a>
<?php endif ?>

<div class="jumbotron text-center" style="margin-bottom:0">
    <h1>MarketPlace</h1>
    <p>Make a better world!</p>
</div>

<nav class="navbar navbar-inverse">

    <?php if (!isLoggedIn()) {?>

        <ul class="nav navbar-nav navbar-left" >
        <li ><a href = "https://stefanzhang.com/cs542/register.php" ><span class="glyphicon glyphicon-user" ></span > Sign Up </a ></li >
        <li ><a href = "https://stefanzhang.com/cs542/login.php" ><span class="glyphicon glyphicon-log-in" ></span > Login</a ></li >

    </ul >
    </div >
    <?php }
    ?>

    </div>
</nav>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <a class="navbar-brand" href="#">Home</a>
    <!---
    <a class="navbar-brand" href="https://stefanzhang.com/cs542/cart.php">Cart</a>
    <a class="navbar-brand" href="https://stefanzhang.com/cs542/Order_history.php">Order History</a>
    --->

    <?php if ($Seller_ID==null) {?>
        <a class="navbar-brand" href="https://stefanzhang.com/cs542/cart.php">Cart</a>
        <a class="navbar-brand" href="https://stefanzhang.com/cs542/Order_history.php">Order History</a>
    <?php }
    ?>

    <?php if ($Seller_ID!=null) {?>
        <a class="navbar-brand" href="sellerHome.php?Seller_ID='.$Seller_ID.'">My Home Page</a>
    <?php }
    ?>

    <select id="select" >
        <option value="All">All</option>
        <option value="Electronics">Electronics</option>
        <option value="Furniture">Furniture</option>
        <option value="Storage">Storage</option>
        <option value="Kitchen">Kitchen</option>
        <option value="Gym">Gym</option>
        <option value="Books">Books</option>
        <option value="Other">Other</option>
    </select>
    <button onClick="select()">Select </button>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>
</nav>

<div class="container" style="margin-top:40px">
    <h2>Top Selling</h2>
    <div class="row">
        <?php
        if (is_array($result) || is_object($result)) {
            foreach ($result as $PID) {
                $product = getproducts_main($PID, $conn);
                echo '<div class="col-sm-4">';
                echo '<img class="img-responsive" src="https://stefanzhang.com/cs542/pic/Usertemp/'.$product[2].'" alt="Chania" width="260" height="245">';
                //echo '<img class="img-responsive" src="ftp://cs542:cs542@45.63.58.174/pic/Usertemp/'.$product[2].'" alt="Chania" width="260" height="245">';
                echo '<h4>' . $product[0] . '</h4>';
                echo '<h6> $' . $product[1] . '</h6>';
                echo '<a href="https://stefanzhang.com/cs542/item.php?PID=' . $PID . '" type="button" class="btn btn-primary">More Details</a>';
                echo '</div>';
            }
        }
        else{
            echo '<h4>'."No items where under this category".'</h4>';
        }
        ?>
    <div>
<div>


</body>
</html>