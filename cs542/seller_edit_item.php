<?php
include('functions.php');
if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: sellerlogin.php');
}

$pid_result= $_GET['pid_result'];
$Seller_ID= $_GET['Seller_ID'];
$current_page=2;

$PicPath = $_GET['PicPath'];
//echo $PicPath;
//echo $pid_result;
//echo $Seller_ID;
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        /* Add padding to containers */
        .container {
            padding: 16px;
            background-color: white;
        }

        /* Full-width input fields */
        input[type=text], input[type=password] {
            width: 100%;
            padding: 15px;
            margin: 5px 0 22px 0;
            display: inline-block;
            border: none;
            background: #f1f1f1;
        }

        input[type=text]:focus, input[type=password]:focus {
            background-color: #ddd;
            outline: none;
        }

        /* Overwrite default styles of hr */
        hr {
            border: 1px solid #f1f1f1;
            margin-bottom: 25px;
        }

        /* Add a blue text color to links */
        a {
            color: dodgerblue;
        }

    </style>
</head>
<body>
<!---
<h1>seller id:</h1>
<?php
echo $Seller_ID;
?>
--->

<form method="post" action="seller_edit_item.php">

    <div class="container">
        <h1>Edit Item</h1>
        <hr>

        <br>

        <label for="Pname"><b>Product Name</b></label>
        <input id="Pname" type="text" name="Pname" value="<?php echo $Pname; ?>">
        <span id="Pname_error"></span>
        <br>


        <label for="PDescription"><b>Product Description</b></label>
        <input id="PDescription" type="text" name="PDescription" value="<?php echo $PDescription; ?>">
        <span id="PDescription_error"></span>
        <br>

        <label for="Price"><b>Price</b></label>
        <input id="Price" type="text" name="Price" value="<?php echo $Price; ?>">
        <span id="Price_error"></span>
        <br>

        <label for="Pmake"><b>Make</b></label>
        <input id="Pmake" type="text" name="Pmake" value="<?php echo $Pmake; ?>">
        <span id="Pmake_error"></span>
        <br>

        <div class="form-group">
            <label>Category</label>
            <input type="text" class="form-control" name="pCategory" placeholder="Electronics/Furniture/Storage/Kitchen/Gym/Books/Other" value="<?php echo $pCategory; ?>">
        </div>

        <label for="PQuantity"><b>Quantity</b></label>
        <input id="PQuantity" type="text" name="PQuantity" value="<?php echo $PQuantity; ?>">
        <span id="PQuantity_error"></span>
        <br>

        <div class="form-group">
            <?php
            echo '<a href="upload_pic_html.php?pid_result='.$pid_result.'&Seller_ID='.$Seller_ID.'&current_page='.$current_page.'">Upload Picture</a>';
            ?>
        </div>

        <input type="hidden" name="PicPath" value="<?php echo $PicPath; ?>">
        <input type="hidden" name="pid_result" value="<?php echo $pid_result; ?>">
        <input type="hidden" name="Seller_ID" value="<?php echo $Seller_ID; ?>">

        </hr>

        <div class="modal-footer">
            <?php
            echo '<a href="https://stefanzhang.com/cs542/sellerEdit.php?Seller_ID='.$Seller_ID.'">Cancel</a>';
            ?>

            <?php if ($PicPath!=null) {?>
                <input type="submit" class="btn btn-success" name="btn_edit" id="btn_edit" value="Save">
            <?php }else{echo "Picture is required!";}
            ?>

        </div>
    </div>
</form>
<!---
<?php
echo "pid:";
echo $pid_result;
?>
--->
</body>

</html>

