
<?php include('functions.php') ?>



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
            resize: both;
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

        /* Set a style for the submit button */
        .buyer_registerbtn {
            background-color: #4CAF50;
            color: white;
            padding: 16px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
            opacity: 0.9;
        }

        .buyer_registerbtn:hover {
            opacity: 1;
        }

        .cancelbtn {
            width: auto;
            padding: 10px 18px;
            background-color: #f44336;
            color: white;
            cursor: pointer;
        }

        /* Add a blue text color to links */
        a {
            color: dodgerblue;
        }

        /* Set a grey background color and center the text of the "sign in" section */
        .signin {
            background-color: #f1f1f1;
            text-align: center;
        }
    </style>
</head>
<body>

<!---
<script>
    function formSubmit(username, email, Phone_Number, Address, card, card_cvv, psw)
    {
        var dataString = 'username='+ username + '&email='+ email + '&Phone_Number='+ Phone_Number
            + '&Address='+ Address + '&card='+ card + '&card_cvv='+ card_cvv + '&psw='+ psw;
        window.location.replace("https://stefanzhang.com/cs542/register_addController.php?"+dataString);
    }

    function validation(){
        var username = document.getElementById("username").value;
        var email = document.getElementById("email").value;
        var Phone_Number = document.getElementById("Phone_Number").value;
        var Address = document.getElementById("Address").value;
        var card = document.getElementById("card").value;
        var card_cvv = document.getElementById("card_cvv").value;
        var psw = document.getElementById("psw").value;

        formSubmit(username, email, Phone_Number, Address, card, card_cvv, psw);
    }

</script>
--->

<form method="post" action="register.php">

    <?php echo display_error(); ?>

    <div class="container">
        <h1>Register</h1>
        <p>Please fill in this form to create an account. If you are an seller,<a href="seller_register.php"> register here.</a></p>
        <hr>

        <!---
        <form action="testradiobutton.php" method="post">
            <input type="radio" name="usertype" value="seller"> I am a seller
            <input type="radio" name="usertype" value="buyer"> I am a buyer<br>
        </form>
        --->

        <br>

        <label for="username"><b>Username</b></label>
        <input id="username" type="text" placeholder="Please Choose A Username" name="username" value="<?php echo $username; ?>">
        <span id="username_error"></span>
        <br>


        <label for="psw"><b>Password</b></label>
        <input id="psw" type="password" placeholder="Please Enter Password" name="password_1" value="<?php echo $password; ?>">
        <span id="psw_error"</span>
        <br>


        <label>Confirm Password</label>
        <input type="password" placeholder="Please Confirm Password" name="password_2" value="<?php echo $password; ?>">
        <br>

        <label for="email"><b>Email</b></label>
        <br>
        <input id="email" type="email" placeholder="Please Enter Email" name="email" value="<?php echo $email; ?>">
        <span id="email_error"></span>
        <br>
        <br>

        <label for="Phone Number"><b>Phone Number</b></label>
        <input id="Phone_Number" type="text" placeholder="Please Enter Phone Number" name="phone_number" value="<?php echo $phone_number; ?>">
        <span id="phone_error"></span>
        <br>

        <label for="Address"><b>Address</b></label>
        <input id="Address" type="text" placeholder="Please Enter Address" name="address" value="<?php echo $address; ?>">
        <span id="Address_error"></span>
        <br>

        <label for="card"><b>Credit Card</b></label>
        <input id="card" type="text" placeholder="Please Enter Credit Card information" name="card" value="<?php echo $card; ?>">
        <span id="card_error"></span>
        <br>

        <label for="card_cvv"><b>Credit Card CVV</b></label>
        <input id="card_cvv" type="text" placeholder="Please Enter Credit Card CVV" name="cvv" length="3" value="<?php echo $cvv; ?>">
        <span id="card_cvv_error"></span>
        <br>

        </hr>
        <p>By creating an account you agree to our <a href="TP.php">Terms & Privacy</a>.</p>

        <button type="submit" class="buyer_registerbtn" name="buyer_registerbtn">Register</button>

    </div>


    <div class="container signin">
        <p>Already have an account? <a href="login.php">Sign in</a>.</p>
    </div>
    <div class="container signin">
        <a href="index.php" style="text-decoration:none" class="cancelbtn">Cancel</a>
    </div>
</form>

</body>
</html>

