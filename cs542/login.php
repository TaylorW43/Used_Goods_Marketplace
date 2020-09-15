<?php include('functions.php') ?>



<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {font-family: Arial, Helvetica, sans-serif;}
        form {border: 3px solid #f1f1f1;}

        input[type=text], input[type=password] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            opacity: 0.8;
        }

        .cancelbtn {
            width: auto;
            padding: 10px 18px;
            background-color: #f44336;
            color: white;
            cursor: pointer;
        }

        .imgcontainer {
            text-align: center;
            margin: 24px 0 12px 0;
        }

        img.avatar {
            width: 20%;
            border-radius: 20%;
        }

        .container {
            padding: 16px;
            resize: both;
        }

        span.psw {
            float: right;
        }

        /* Change styles for span and cancel button on extra small screens */
        @media screen and (max-width: 300px) {
            span.psw {
                display: block;
                float: none;
            }
            .cancelbtn {
                width: 100%;
            }

        }
    </style>
</head>
<body>

<!---<form action="index.php" method="post">--->
<form action="login.php" method="post">

    <?php echo display_error(); ?>

    <div class="imgcontainer">
        <img src="bootstrap/js/avatar.png" alt="Avatar" class="avatar">
    </div>

    <div class="container">

        <label for="uname"><b>Username</b></label>
        <input type="text" placeholder="Please Enter Username" name="username" required>


        <label for="psw"><b>Password</b></label>
        <input type="password" placeholder="Please Enter Password" name="password" required>


        <!---
        <form action="testradiobutton.php" method="post">
            <input type="radio" name="usertype" value="seller"> I am a seller
            <input type="radio" name="usertype" value="buyer"> I am a buyer<br>
        </form>
        --->


        <button type="submit" value="Login" name="buyer_login_btn">Login</button>
        <label>
            <input type="checkbox" checked="checked" name="remember"> Remember me
        </label>

        <span class="psw">Forgot <a href="recoverpasswd.php">password?</a></span>

    </div>

    <div class="container" >
        <a href="index.php" style="text-decoration:none" class="cancelbtn">Cancel</a>
        <!---<a href="adminlogin.php" style="text-decoration:none" class="cancelbtn">Administrator Login</a>--->
        <a href="sellerlogin.php" style="text-decoration:none" class="cancelbtn">Seller Login</a>
    </div>


</form>

</body>
</html>

