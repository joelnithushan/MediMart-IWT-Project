<?php session_start(); ?>
<?php
//include database connection
require_once 'conn.php'; ?>
<?php

if (!isset($_SESSION['user_id'])) {
    header('location: loginForm.php');
}
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Medi Mart</title>
        <link rel="icon" href="../Images/medimart_logo.png">

        <link rel="stylesheet" href="../CSS/template.css">
        <link rel="stylesheet" href="../CSS/myaccAdmin.css">
        
        <script src="../JS/home.js"></script>
        <script src="../JS/admindashboard.js"></script>
        <script src="../JS/cancel.js"></script>
    </head>

    <body>
        <div class="nav-box">
    <div class="header">
        <a href="#default" class="logo"><img class="mmlogo" src="../Images/medimart_logo.png" alt="MediMart Logo"></a>
        <div class="header-right">
            <?php
            if (isset($_SESSION['user_id'])) {
                echo "<a onclick=\"myaccAdmin();\"><img src=\"../Images/profile_icon.png\" style='width: 40px; height: 40px;' ><br>&nbsp;&nbsp;&nbsp;";
                echo $_SESSION['name'] . "</a>";
            }
            ?>
        </div>
    </div>
    <div class="menu">
        <div class="menu-links">
            <a class="active" onclick="adminDashBoard();">Home</a>
            <a href="#" onclick="addnewItem();">Add Items</a>
            <a href="#" onclick="viewItems();">View Items, Update & Delete</a>
            <a href="#" onclick="viewContactUs();">Contact Us</a>
            <a href="#" onclick="viewPreupOrders();">Prescription Orders</a>
            <a href="#" onclick="viewCartOrders();">Cart Orders</a>
        </div>
        <div class="search-container">

        </div>
    </div>
    </div>
    <!--Admin Account-->
    <div class="ymyacc">
        <div class="ymyaccleft">
            <h1>My Profile</h1>

            <h4>Account Information</h4>

            <hr/>

            <h4>Contact Information</h4>

            <p>Name : <?php echo $_SESSION['name']; ?></p>
            <p>E-mail : <?php echo $_SESSION['email']; ?></p>
            <p>Mobile Number: 0<?php echo $_SESSION['mobileNo']; ?></p>

            <br>

            <h4>Address Book</h4>

            <hr/>

            <p>Address</p>

            <p>
                <?php echo $_SESSION['address']; ?>
            </p>
            <br>

            <div class="myacc-btnbox">
                <button class="myacc-editbtn"><?php echo "<a href=\"editAdminAcc.php?user_ID={$_SESSION['user_id']}\">Edit Account Infomation</a> "; ?></button>
                <button type="submit" name="changepw"
                        class="myacc-changepwbtn"><?php echo "<a href=\"changepwAdmin.php?user_ID={$_SESSION['user_id']}\">Change Password</a> "; ?></button>
                <button class="myacc-logoutbtn" onclick="return confirm('Are you sure you want to Log Out ?');"><a
                            href="logout.php">Log Out</a></button>
            </div>
        </div>
        <div class="ymyaccright">
            <img src="../Images/myacc.jpg" alt=""/>
        </div>
    </div>
    <footer>
        <div class="row primary">
            <div class="column about">
                <h3><img src="../Images/medimart_logo.png" style="width:250; height:80px" alt="MediMart Logo"></h3>
                <p>
            At Medi Mart, your health is our top priority. 
            We've introduced an online shopping and ordering experience to make accessing health and wellness products easier than ever. 
            Browse through thousands of home healthcare and over-the-counter products right from our site,
            and enjoy the convenience of having them delivered to your door.

            </p>
                <div class="social">
                <a href="#"><img src="../Images/fb.png" style="width:40px; height:40px;" id="i1" onclick="fbLogin();"></a>
                <a href="#"><img src="../Images/ig.png" style="width:40px; height:40px;" id="i2" onclick="instaLogin();"></a>
                <a href="#"><img src="../Images/x.png" style="width:40px; height:40px;" id="i3" onclick="twitterLogin();"></a>
                <a href="#"><img src="../Images/yt.png" style="width:40px; height:40px;" id="i4" onclick="youtube();"></a>
                <a href="#"><img src="../Images/wa.png" style="width:40px; height:40px;" id="i5" onclick="whatsapp();"></a>
            </div>
            </div>
            <div class="column links">

            </div>
            <div class="column subscribe">
            </div>
        </div>
        <div class="row copyright">
            <p>© 2024 MadiMart.inc. All rights reserved.</p>
        </div>
    </footer>

    </body>

    </html>
<?php
//close connection to database
mysqli_close($conn);
?>