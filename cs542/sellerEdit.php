<?php
include('functions.php');
if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: sellerlogin.php');
}

$Seller_ID = $_GET['Seller_ID'];
//$PicPath = $_GET['PicPath'];
//$if_delete=false;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style type="text/css">
        body {
            color: #566787;
            background: #f5f5f5;
            font-family: 'Varela Round', sans-serif;
            font-size: 13px;
        }
        .table-wrapper {
            background: #fff;
            padding: 20px 25px;
            margin: 30px 0;
            border-radius: 3px;
            box-shadow: 0 1px 1px rgba(0,0,0,.05);
        }
        .table-title {
            padding-bottom: 15px;
            background: #435d7d;
            color: #fff;
            padding: 16px 30px;
            margin: -20px -25px 10px;
            border-radius: 3px 3px 0 0;
        }
        .table-title h2 {
            margin: 5px 0 0;
            font-size: 24px;
        }

        .table-title .btn {
            color: #fff;
            float: right;
            font-size: 13px;
            border: none;
            min-width: 50px;
            border-radius: 2px;
            border: none;
            outline: none !important;
            margin-left: 10px;
        }
        .table-title .btn i {
            float: left;
            font-size: 21px;
            margin-right: 5px;
        }
        .table-title .btn span {
            float: left;
            margin-top: 2px;
        }
        table.table tr th, table.table tr td {
            border-color: #e9e9e9;
            padding: 12px 15px;
            vertical-align: middle;
        }
        table.table tr th:first-child {
            width: 60px;
        }
        table.table tr th:last-child {
            width: 100px;
        }
        table.table-striped tbody tr:nth-of-type(odd) {
            background-color: #fcfcfc;
        }
        table.table-striped.table-hover tbody tr:hover {
            background: #f5f5f5;
        }
        table.table th i {
            font-size: 13px;
            margin: 0 5px;
            cursor: pointer;
        }
        table.table td:last-child i {
            opacity: 0.9;
            font-size: 22px;
            margin: 0 5px;
        }
        table.table td a {
            font-weight: bold;
            color: #566787;
            display: inline-block;
            text-decoration: none;
            outline: none !important;
        }
        table.table td a:hover {
            color: #2196F3;
        }
        table.table td a.edit {
            color: #FFC107;
        }
        table.table td a.delete {
            color: #F44336;
        }
        table.table td i {
            font-size: 19px;
        }

        .pagination li a {
            border: none;
            font-size: 13px;
            min-width: 30px;
            min-height: 30px;
            color: #999;
            margin: 0 2px;
            line-height: 30px;
            border-radius: 2px !important;
            text-align: center;
            padding: 0 6px;
        }
        .pagination li a:hover {
            color: #666;
        }
        .pagination li.active a, .pagination li.active a.page-link {
            background: #03A9F4;
        }
        .pagination li.active a:hover {
            background: #0397d6;
        }
        .pagination li.disabled i {
            color: #ccc;
        }
        .pagination li i {
            font-size: 16px;
            padding-top: 6px
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
    <script type="text/javascript">
        $(document).ready(function(){
            // Activate tooltip
            $('[data-toggle="tooltip"]').tooltip();

            // Select/Deselect checkboxes
            var checkbox = $('table tbody input[type="checkbox"]');
            $("#selectAll").click(function(){
                if(this.checked){
                    checkbox.each(function(){
                        this.checked = true;
                    });
                } else{
                    checkbox.each(function(){
                        this.checked = false;
                    });
                }
            });
            checkbox.click(function(){
                if(!this.checked){
                    $("#selectAll").prop("checked", false);
                }
            });
        });
    </script>
</head>
<body>
<!---
<h1>seller id:</h1>
<?php
echo $Seller_ID;
?>
--->
<form method="post">
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-6">
                    <h2>Manage My Items</h2>
                </div>
                <div class="col-sm-6">
                    <a href="sellerHome.php" class="btn btn-danger" ><i class="material-icons">&#xE15C;</i> <span>Cancel</span></a>

                    <?php
                        echo '<a href="https://stefanzhang.com/cs542/seller_add_item.php?Seller_ID='.$Seller_ID.'" class="btn btn-success" ><i class="material-icons">&#xE147;</i> <span>Add New Item</span></a>';
                    ?>

                    <!---
                    <a href="#addModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Item</span></a>

                    <a href="#deleteModal" class="btn btn-danger" data-toggle="modal"><i class="material-icons">&#xE15C;</i> <span>Delete</span></a>
                    --->
                    <button type="submit" class="btn btn-danger" name="btn_delete" id="btn_delete">Delete</button>
                </div>
            </div>
        </div>
        <table class="table table-striped table-hover" id="table_to_loop">
            <thead>
            <tr>
                <th>
							<span class="custom-checkbox">
								<input type="checkbox" id="selectAll">
								<label for="selectAll"></label>
							</span>
                </th>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Maker</th>
                <th>Quantity</th>
                <th>Image_path</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <?php
            //if ($if_delete==false)
            //{
                display_table();
            //}
            ?>
            </tr>
            </tbody>
        </table>
</div>
    <!---<input type="submit" name="btn_delete" value="Submit" >--->
</form>

<?php
if(isset($_POST['btn_delete'])){//to run PHP script on submit
    //$my_pids=[];
    $if_delete=true;
    if(!empty($_POST['check_list'])){
        // Loop to store and display values of individual checked checkbox.
        foreach($_POST['check_list'] as $selected){
            //echo $selected."</br>";
            //array_push($my_pids,$selected);

            $query_delete_has="DELETE FROM Has WHERE Pid='$selected'";
            if (mysqli_query($db, $query_delete_has)) {
                $query="DELETE FROM Sell WHERE Pid='$selected'";
                if (mysqli_query($db, $query)){
                    $query2="DELETE FROM Products WHERE Pid='$selected'";
                    if (mysqli_query($db, $query2)){
                        //echo "delete record successfully";
                    }
                    else
                    {
                        printf("Error: %s\n", mysqli_error($db));
                    }
                }
                else
                {
                    printf("Error: %s\n", mysqli_error($db));
                }
            }
            else
            {
                printf("Error: %s\n", mysqli_error($db));
            }

        }
        //print_r($my_pids);
    }

    echo '<script type="text/javascript">',
    'window.location.href=window.location.href',
    '</script>'
    ;
}
?>
<?php
function display_table()
{
    global $Seller_ID, $db;
    $Pid = "SELECT Pid FROM Sell WHERE Sid='$Seller_ID'";
    if ($Pid_result = mysqli_query($db, $Pid))
    {
        //echo "in if";
        //echo $Pid;
        while($row1 = mysqli_fetch_assoc($Pid_result))
        {
            //echo "in while";
            //echo $row1["Pid"];
            //$pid_result = $row1["Pid"];
            //echo $pid_result;
            //echo $row1["Pid"];
            //echo "     ";
            //echo $row1["Pid"];
            //echo "<br>";
            $pid_result = $row1["Pid"];
            $query = "SELECT * FROM Products WHERE Pid='$pid_result'";
            if ($query_result = mysqli_query($db, $query))
            {
                //echo "in if";
                while ($row = mysqli_fetch_assoc($query_result))
                {
                    //echo "in while2";
                    $field1 = $row["Pid"];
                    $field2 = $row["Pname"];
                    $field3 = $row["PDescription"];
                    $field4 = $row["Price"];
                    $field5 = $row["Pmake"];
                    $field6 = $row["PQuantity"];
                    $field7 = $row["PicPath"];


                    echo "<td>
                            <span class=\"custom-checkbox\" id='.$field1.'>
								<input type=\"checkbox\" name=\"check_list[]\" value='$field1'>
								<!---<input type='text' placeholder='.$field1.'>--->
								<label for='.$field1.'></label>
							</span></td>";

                    echo "<td>" . $field1 . "</td>";
                    echo "<td>" . $field2 . "</td>";
                    echo "<td>" . $field3 . "</td>";
                    echo "<td>" . $field4 . "</td>";
                    echo "<td>" . $field5 . "</td>";
                    echo "<td>" . $field6 . "</td>";
                    echo "<td>" . $field7 . "</td>";
                    echo "<td>";

                    //echo "<a href=\"#deleteModal\" class=\"delete\" data-toggle=\"modal\"><i class=\"material-icons\" data-toggle=\"tooltip\" title=\"Delete\">&#xE872;</i></a>";

                    echo '<a href="https://stefanzhang.com/cs542/seller_edit_item.php?Seller_ID='.$Seller_ID.'&pid_result='.$pid_result.'" class="edit" data-toggle="modal" ><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>';


                    echo "</td>";

                }
                echo "<tr></tr>";
            }
        }
    }
    else
    {
        echo "Error getting Pid.";
    }

}
?>
</body>
<!---
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript">
    $(function () {
        //Assign Click event to Button.
        $("#btn_delete").click(function () {
            var temp = "";
            var my_PIDS=[];

            //Loop through all checked CheckBoxes in GridView.
            $("#table_to_loop input[type=checkbox]:checked").each(function () {
                temp = $(this).closest("tr")[0];
                my_PIDS.push(temp.cells[1].innerHTML);
            });

            //Display selected Row data in Alert Box.
            //alert(my_PIDS);

        });
    });
</script>
--->

</html>