<?php
include('functions.php');
if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: sellerlogin.php');
}

$Seller_ID = $_GET['Seller_ID'];

$PicPath = $_GET['PicPath'];

$current_page=1;
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


        /* Custom checkbox */
        .custom-checkbox {
            position: relative;
        }
        .custom-checkbox input[type="checkbox"] {
            opacity: 0;
            position: absolute;
            margin: 5px 0 0 3px;
            z-index: 9;
        }
        .custom-checkbox label:before{
            width: 18px;
            height: 18px;
        }
        .custom-checkbox label:before {
            content: '';
            margin-right: 10px;
            display: inline-block;
            vertical-align: text-top;
            background: white;
            border: 1px solid #bbb;
            border-radius: 2px;
            box-sizing: border-box;
            z-index: 2;
        }
        .custom-checkbox input[type="checkbox"]:checked + label:after {
            content: '';
            position: absolute;
            left: 6px;
            top: 3px;
            width: 6px;
            height: 11px;
            border: solid #000;
            border-width: 0 3px 3px 0;
            transform: inherit;
            z-index: 3;
            transform: rotateZ(45deg);
        }
        .custom-checkbox input[type="checkbox"]:checked + label:before {
            border-color: #03A9F4;
            background: #03A9F4;
        }
        .custom-checkbox input[type="checkbox"]:checked + label:after {
            border-color: #fff;
        }
        .custom-checkbox input[type="checkbox"]:disabled + label:before {
            color: #b8b8b8;
            cursor: auto;
            box-shadow: none;
            background: #ddd;
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

<form method="post" action="seller_add_item.php">

    <div class="container">
        <h1>Add Item</h1>
        <hr>

        <br>

        <label for="Picture"><b>Product Picture</b></label>
        <div class="form-group">
            <?php
            echo '<a href="upload_pic_html.php?current_page='.$current_page.'">Upload Picture</a>';
            ?>
        </div>
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

        <!---
        <div class="form-group">
            <label>Category</label>
            <input type="text" class="form-control" name="pCategory" placeholder="Electronics/Furniture/Storage/Kitchen/Gym/Books/Other" value="<?php echo $pCategory; ?>">
        </div>
        --->

        <div class="form-group">
        <label for="Category">Category</label>
            <br>
            <select id="Category">
                <option value="Electronics">Electronics</option>
                <option value="Furniture">Furniture</option>
                <option value="Storage">Storage</option>
                <option value="Kitchen">Kitchen</option>
                <option value="Gym">Gym</option>
                <option value="Books">Books</option>
                <option value="Other">Other</option>
            </select>
        </div>


        <label for="PQuantity"><b>Quantity</b></label>
        <input id="PQuantity" type="text" name="PQuantity" value="<?php echo $PQuantity; ?>">
        <span id="PQuantity_error"></span>
        <br>


        <input type="hidden" name="PicPath" value="<?php echo $PicPath; ?>">

        </hr>

        <div class="modal-footer">
            <?php
            echo '<a href="https://stefanzhang.com/cs542/sellerEdit.php?Seller_ID='.$Seller_ID.'">Cancel</a>';
            ?>

            <?php if ($PicPath!=null) {?>
                <input type="submit" class="btn btn-success" name="btn_add" value="Add">
            <?php }else{echo "Picture is required!";}
            ?>

        </div>


    </div>
</form>
</body>
</html>

