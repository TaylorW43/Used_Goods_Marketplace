<?php

session_start();

// connect to database
$db = mysqli_connect('localhost', 'cs542', 'cs542', 'cs542');

// variable declaration
$username = "";
$password = "";
$email    = "";
$phone_number = "";
$address = "";
$card = "";
$cvv = "";
$errors   = array();

$Pname = "";
$PDescription = "";
$Price = "";
$Pmake = "";
$PQuantity = "1";
$PicPath;
$pCategory = "Other";


// call the register() function if register_btn is clicked
if (isset($_POST['buyer_registerbtn'])) {
    buyer_register();
}

if (isset($_POST['seller_registerbtn'])) {
    seller_register();
}

if (isset($_POST['btn_add'])) {
    seller_add_item();
}

if (isset($_POST['btn_edit'])) {
    seller_edit_item();
}


// REGISTER USER
function seller_register(){
    // call these variables with the global keyword to make them available in function
    global $db, $errors, $username, $email, $phone_number, $address, $card, $cvv;

    // receive all input values from the form. Call the e() function
    // defined below to escape form values
    $username    =  e($_POST['username']);
    $email       =  e($_POST['email']);
    $password_1  =  e($_POST['password_1']);
    $password_2  =  e($_POST['password_2']);
    $phone_number=  e($_POST['phone_number']);
    $address     =  e($_POST['address']);
    $card        =  e($_POST['card']);
    $cvv         =  e($_POST['cvv']);

    // form validation: ensure that the form is correctly filled
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password_1)) {
        array_push($errors, "Password is required");
    }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }
    if (empty($phone_number)) {
        array_push($errors, "Phone number is required");
    }
    if (empty($address)) {
        array_push($errors, "Address is required");
    }
    if (empty($card)||strlen($card)!=16||is_numeric($card)==false) {
        array_push($errors, "Card info error");
    }
    if (empty($cvv)||strlen($cvv)!=3||is_numeric($cvv)==false) {
        array_push($errors, "CVV is required");
    }

    // register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = md5($password_1);//encrypt the password before saving in the database

        $card = md5($card);
        $cvv = md5($cvv);


        $query1 = "INSERT INTO Seller (Sname, Semail, Spassword, Sphone, Saddress, Scredit_card, Scredit_card_cvv) 
					  VALUES('$username', '$email', '$password', '$phone_number', '$address', '$card', '$cvv')";
        //mysqli_query($db, $query1);
        if (mysqli_query($db, $query1)) {

            // get id of the created user
            $logged_in_user_id = mysqli_insert_id($db);

            $_SESSION['user'] = seller_getUserById($logged_in_user_id); // put logged in user in session
            $_SESSION['success']  = "You are now logged in";
            header('location: sellerHome.php');

        }
        else {
            echo "Error insert into seller";
            printf("Error: %s\n", mysqli_error($db));
        }

    }
}

function buyer_register(){
    // call these variables with the global keyword to make them available in function
    global $db, $errors, $username, $email, $phone_number, $address, $card, $cvv;
    global $cart_id, $buyer_id_result;

    // receive all input values from the form. Call the e() function
    // defined below to escape form values
    $username    =  e($_POST['username']);
    $email       =  e($_POST['email']);
    $password_1  =  e($_POST['password_1']);
    $password_2  =  e($_POST['password_2']);
    $phone_number=  e($_POST['phone_number']);
    $address     =  e($_POST['address']);
    $card        =  e($_POST['card']);
    $cvv         =  e($_POST['cvv']);

    // form validation: ensure that the form is correctly filled
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password_1)) {
        array_push($errors, "Password is required");
    }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }
    if (empty($phone_number)) {
        array_push($errors, "Phone number is required");
    }
    if (empty($address)) {
        array_push($errors, "Address is required");
    }
    if (empty($card)||strlen($card)!=16||is_numeric($card)==false) {
        array_push($errors, "Card is required");
    }
    if (empty($cvv)||strlen($cvv)!=3||is_numeric($cvv)==false) {
        array_push($errors, "CVV is required");
    }

    // register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = md5($password_1);//encrypt the password before saving in the database

        $card = md5($card);
        $cvv = md5($cvv);


        $query1 = "INSERT INTO Buyer (Bname, Bemail, Bpassword, Bphone, Baddress, Bcredit_card, Bcredit_card_cvv) 
					  VALUES('$username', '$email', '$password', '$phone_number', '$address', '$card', '$cvv')";
        //mysqli_query($db, $query1);
        if (mysqli_query($db, $query1)) {
            echo "Insert into buyer successfully";


            // get id of the created user
            $logged_in_user_id = mysqli_insert_id($db);

            $_SESSION['user'] = buyer_getUserById($logged_in_user_id); // put logged in user in session
            $_SESSION['success']  = "You are now logged in";
            header('location: index.php');

            //get id of buyer from database
            $query_get_buyer_id = "SELECT Bid FROM Buyer WHERE Bname='$username'";
            //$query_get_buyer_id_result = mysqli_query($db, $query_get_buyer_id);
            //$row1 = mysqli_fetch_array($query_get_buyer_id_result);
            //echo $row1;
            if($query_get_buyer_id_result = mysqli_query($db, $query_get_buyer_id))
            {
                //echo "in if get buyer id result";

                while($row1 = mysqli_fetch_assoc($query_get_buyer_id_result))
                {
                    //echo $row1["Bid"];
                    $buyer_id_result = $row1["Bid"];
                }
                //echo $buyer_id_result;
            }/*
            else
            {
                echo "not in if";
            }*/


            //assign a cart
            $query2 = "INSERT INTO Shopping_Cart (cartName) VALUES('$username')";
            //mysqli_query($db, $query2);
            if (mysqli_query($db, $query2)) {
                //echo "insert into shopping cart successfully";

                //get cart id from database
                $query_get_cart_id = "SELECT Cartid FROM Shopping_Cart WHERE cartName='$username'";
                //$query_get_cart_id_result = mysqli_query($db, $query_get_cart_id);
                //$row2 = mysqli_fetch_array($query_get_cart_id_result);
                //echo $row2;

                if($query_get_cart_id_result = mysqli_query($db, $query_get_cart_id))
                {
                    while($row2 = mysqli_fetch_assoc($query_get_cart_id_result))
                    {
                        //echo $row2["Cartid"];
                        $cart_id = $row2["Cartid"];
                    }
                }
            }
            else {
                echo "Error insert into shopping cart";
                printf("Error: %s\n", mysqli_error($db));
                exit();
            }


            $query3 = "INSERT INTO Buy (Cartid, Bid) VALUES('$cart_id', '$buyer_id_result')";
            //mysqli_query($db, $query3);
            if(mysqli_query($db, $query3))
            {
                echo "insert into buy successfully";
            }
            else {
                echo "ERROR: " .$query3. "" . mysqli_error($db);
            }



        }
        else {
            echo "Error insert into buyer";
            printf("Error: %s\n", mysqli_error($db));
        }

    }
}


// return user array from their id
function buyer_getUserById($id){
    global $db;

    $query = "SELECT * FROM Buyer WHERE Bid=" . $id;

    $result = mysqli_query($db, $query);

    return mysqli_fetch_assoc($result);
}

function seller_getUserById($id){
    global $db;

    $query = "SELECT * FROM Seller WHERE Sid=" . $id;

    $result = mysqli_query($db, $query);

    return mysqli_fetch_assoc($result);
}


// escape string
function e($val){
    global $db;
    return mysqli_real_escape_string($db, trim($val));
}

function display_error() {
    global $errors;

    if (count($errors) > 0){
        echo '<div class="error">';
        foreach ($errors as $error){
            echo $error .'<br>';
        }
        echo '</div>';
    }
}

function isLoggedIn()
{
    if (isset($_SESSION['user'])) {
        return true;
    }else{
        return false;
    }
}

// log user out if logout button clicked
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    header("location: index.php");
}
// call the login() function if register_btn is clicked
if (isset($_POST['buyer_login_btn'])) {
    buyer_login();
}

if (isset($_POST['seller_login_btn'])) {
    seller_login();
}

// LOGIN USER
function buyer_login(){
    global $db, $username, $errors;

    // grap form values
    $username = e($_POST['username']);
    $password = e($_POST['password']);

    // make sure form is filled properly
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    // attempt login if no errors on form
    if (count($errors) == 0) {
        $password = md5($password);

        $query = "SELECT * FROM Buyer WHERE Bname='$username' AND Bpassword='$password' LIMIT 1";
        $results = mysqli_query($db, $query);

        if (mysqli_num_rows($results) == 1) { // user found
            // check if user is admin or user
            $logged_in_user = mysqli_fetch_assoc($results);

            $_SESSION['user'] = $logged_in_user;
            $_SESSION['success']  = "You are now logged in";

            header('location: index.php');

        }else {
            array_push($errors, "Wrong username/password combination");
        }
    }
}

function seller_login(){
    global $db, $username, $errors;

    // grap form values
    $username = e($_POST['username']);
    $password = e($_POST['password']);

    // make sure form is filled properly
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    // attempt login if no errors on form
    if (count($errors) == 0) {
        $password = md5($password);

        $query = "SELECT * FROM Seller WHERE Sname='$username' AND Spassword='$password' LIMIT 1";
        $results = mysqli_query($db, $query);

        if (mysqli_num_rows($results) == 1) { // user found

            $logged_in_user = mysqli_fetch_assoc($results);

            $_SESSION['user'] = $logged_in_user;
            $_SESSION['success']  = "You are now logged in";

            header('location: sellerHome.php');

        }else {
            array_push($errors, "Wrong username/password combination");
        }
    }
}
function seller_add_item()
{
    global $db, $errors, $Pname, $PDescription, $Price, $Pmake, $PQuantity, $PicPath, $pCategory;
    global $Pid_result,$PCid_result;

    $Pname = e($_POST['Pname']);
    $PDescription = e($_POST['PDescription']);
    $Price = e($_POST['Price']);
    $Pmake = e($_POST['Pmake']);
    $PQuantity = e($_POST['PQuantity']);
    $PicPath = e($_POST['PicPath']);
    $pCategory = e($_POST['pCategory']);
    //$pCategory = e($_POST['Category']);

    //echo"category is:";
    //echo $pCategory;

    $Seller_ID = $_SESSION['user']['Sid'];
    //echo "Seller_ID: ", $Seller_ID;

    // form validation: ensure that the form is correctly filled
    if (empty($Pname)) {
        array_push($errors, "Name is required");
    }
    if (empty($PDescription)) {
        array_push($errors, "Description is required");
    }
    if (empty($Price||is_double($Price)!=true)) {
        array_push($errors, "Price error");
    }
    if (empty($Pmake)) {
        array_push($errors, "Make is required");
    }
    /*
    if (empty($PQuantity)) {
        array_push($errors, "Quantity is required");
    }
    */
    if (empty($PicPath)) {
        array_push($errors, "Picture is required");
    }

    if (count($errors) == 0) {
        $query = "INSERT INTO Products (Pname, PDescription, Price, Pmake, PicPath, PQuantity)
				  VALUES('$Pname', '$PDescription', '$Price', '$Pmake', '$PicPath', '$PQuantity')";

        if (mysqli_query($db, $query)) {

            //echo "Add item successful!";

            $query_get_Pid = "SELECT Pid FROM Products WHERE Pname='$Pname'";
            if($query_get_Pid_result = mysqli_query($db, $query_get_Pid))
            {
                while($row = mysqli_fetch_assoc($query_get_Pid_result))
                {
                    $Pid_result = $row["Pid"];
                }
            }

            $query2 = "INSERT INTO Sell (Pid, Sid) VALUES('$Pid_result', '$Seller_ID')";
            if(mysqli_query($db, $query2))
            {
                //echo "insert into Sell successfully";
            }
            else {
                echo "ERROR: " .$query2. "" . mysqli_error($db);
            }

            $query_get_PCid = "SELECT PCid FROM Product_Category WHERE catename='$pCategory'";
            if($query_get_PCid_result = mysqli_query($db, $query_get_PCid))
            {
                while($row1 = mysqli_fetch_assoc($query_get_PCid_result))
                {
                    $PCid_result = $row1["PCid"];
                }
            }

            $query3 = "INSERT INTO Has (PCid, Pid) VALUES('$PCid_result', '$Pid_result')";
            if(mysqli_query($db, $query3))
            {
                //echo "insert into Has successfully";
            }
            else {
                echo "ERROR: " .$query3. "" . mysqli_error($db);
            }

            header('location: sellerHome.php');

        }
        else {
            echo "Error add item";
            printf("Error: %s\n", mysqli_error($db));
        }

    }
}
function seller_edit_item()
{
    global $db, $errors;// $Pname, $PDescription, $Price, $Pmake, $PQuantity, $PicPath;

    $Pname = e($_POST['Pname']);
    $PDescription = e($_POST['PDescription']);
    $Price = e($_POST['Price']);
    $Pmake = e($_POST['Pmake']);
    $PQuantity = e($_POST['PQuantity']);
    $PicPath = e($_POST['PicPath']);

    $pCategory = e($_POST['pCategory']);
    $pid_result = e($_POST['pid_result']);
    $Seller_ID = e($_POST['Seller_ID']);

    //$Seller_ID = $_SESSION['user']['Sid'];
    //echo "Seller_ID: ", $Seller_ID;

    // form validation: ensure that the form is correctly filled
    if (empty($Pname)) {
        array_push($errors, "Name is required");
    }
    if (empty($PDescription)) {
        array_push($errors, "Description is required");
    }
    if (empty($Price)||is_double($Price)!=true) {
        array_push($errors, "Price error");
    }
    if (empty($Pmake)) {
        array_push($errors, "Make is required");
    }
    /*
    if (empty($PQuantity)) {
        array_push($errors, "Quantity is required");
    }
    */
    /*
    if (empty($PicPath)) {
        array_push($errors, "Picture is required");
    }*/
    /*
    echo $Pname;
    echo $PDescription;
    echo $Price;
    echo $Pmake;
    echo $pCategory;
    echo $PQuantity;
    */
    echo display_error();
    if (count($errors) == 0) {

        $query_get_PCid = "SELECT PCid FROM Product_Category WHERE catename='$pCategory'";
        if ($query_get_PCid_result=mysqli_query($db, $query_get_PCid)){

            while($row1 = mysqli_fetch_assoc($query_get_PCid_result))
            {
                $get_PCid_result = $row1["PCid"];
            }
            //echo $get_PCid_result;
            $query_update_has="UPDATE Has SET PCid='$get_PCid_result' WHERE Pid='$pid_result'";
            if (mysqli_query($db, $query_update_has))
            {
                $query = "UPDATE Products SET Pname='$Pname', PDescription='$PDescription',Price='$Price',
                    Pmake='$Pmake',PicPath='$PicPath',PQuantity='$PQuantity' WHERE Pid='$pid_result'";
                if (mysqli_query($db, $query))
                {
                    echo "edit successful";
                }
                else {
                    echo "Error edit item";
                    printf("Error: %s\n", mysqli_error($db));
                }
            }
            else {
                echo "Error edit item";
                printf("Error: %s\n", mysqli_error($db));
            }

        }
        else {
            echo "Error edit item";
            printf("Error: %s\n", mysqli_error($db));
        }

    }
    header('location: sellerEdit.php?Seller_ID='.$Seller_ID);
}