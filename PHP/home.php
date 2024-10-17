<?php session_start(); ?>
<?php
//include database connection
require_once 'conn.php';
$itemList = '';
$items = '';
$errors = array();

if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $query = "SELECT * FROM item WHERE (genericName LIKE '%{$search}%' OR brandName LIKE '%{$search}%') AND isDeleted = 0 ORDER BY genericName";

    $items = mysqli_query($conn, $query);
    if ($items) {

        while ($item = mysqli_fetch_assoc($items)) {
            $itemList .= "<a href=\"searchedItem.php?item_ID={$item['itemID']}\">{$item['genericName']} / {$item['brandName']}</a>";
        }
    } else {

        $errors[] = 'Database query failed.';
    }
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
        <link rel="stylesheet" href="../CSS/home.css">
        
        <script src="../JS/home.js"></script>
        <style>
            .flex-item-left1 {
                background-image: url("../Images/prescrip.svg");
            }

            .flex-item-middle1 {
                background-image: url("../Images/shopnow.svg");
            }
        </style>
    </head>

    <body>
    <div class="nav-box">
        <div class="header">
            <a onclick="home();"><img class="mmlogo" src="../Images/medimart_logo.png" alt="MediMart Logo"></a>
    <div class="header-right">
    <?php

    if (isset($_SESSION['user_id'])) {
        echo "<a onclick=\"myacc();\"><img src='../Images/profile_icon.png' alt='Profile Icon' style='display:inline-block; width: 40px; height: 40px;'><br>&nbsp;&nbsp;&nbsp;" . $_SESSION['name'] . "</a>";
    } else {

        echo "<a onclick=\"register();\"><img src=\"../Images/profile_icon.png\" alt=\"Profile Icon\" style=\"width: 40px; height: 40px;\"><br>Sign in</a>";
    }

    if (!empty($_SESSION["shopping_cart"])) {
        $cart_count = count(array_keys($_SESSION["shopping_cart"]));
        echo "<a href='cart.php'><img src='../Images/cart_icon.png' style='width:25px; height:25px;'> : " . $cart_count . "</a>";
    }
    ?>
</div>

        </div>
        <div class="menu">
            <div class="menu-links">
               <a class="active" href="#" onclick="home();">Home</a>
               <a href="#" onclick="medicine();">Medicines</a>
               <a href="#" onclick="medicalDevices();">Medical Devices</a>
               <a href="#" onclick="traditionalRemedies();">Traditional Remedies</a>
               <a href="#" onclick="aboutUs();">About us</a>
           </div>
           <div class="search-container">

               <form action="home.php" method="GET">
                   <input type="text" placeholder="Search.." name="search"/>
                   
               </form>
               <div class="dropdown-content" id="drop">
                   <?php
                    if ($items) {
                        echo $itemList;
                    }
                   ?>
                </div>
            </div>
        </div>
    </div>
    <div id="slider1">
        <figure>
            <img src="../Images/slider1.svg">
            <img src="../Images/slider2.svg">
            <img src="../Images/slider4.svg">
        </figure>
    </div>
    <div class="iconimage">
        <img src="../Images/Iconbar.jpg" alt="unclickable icons">
    </div>
    <div class="flex-container">
        <div class="flex-item-left1">
            <div class="container">
                <button class="btn" onclick="preupload();">
                    <a href="#">Upload Prescription</a>
                </button>
            </div>
        </div>
        
        <div class="flex-item-middle1">
            <div class="container">
                <button class="btn" onclick="medicine();">Shop Now</button>
            </div>
        </div>
        
        <div class="flex-item-right1">
            <div class="flex-item-right1-up-down">
                <div class="flex-item-right1-up">
                    <div id="bsi">
                        <h3>Best selling items</h3>
                    </div>
                </div>
                <div class="flex-item-right1-down">
                    <div id="slider2">
                        <figure>
                            <img src="../Images/medd1.jpg" alt/>
                            <img src="../Images/medd2.jpg" alt/>
                            <img src="../Images/medd3.jpg" alt/>
                            <img src="../Images/medd4.jpg" alt/>
                            <img src="../Images/medd5.jpg" alt/>
                        </figure>
                    </div>
                </div>
            </div>
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
                <h3>Customer Service</h3>
                <ul>
                    <li>
                        <a href="#" onclick="contactUs();">Contact Us</a>
                    </li>
                    <li>
                        <a href="#" onclick="privacyPolicy();">Privacy Policy</a>
                    </li>
                    <li>
                        <a href="#" onclick="aboutUs();">About Us</a>
                    </li>
                </ul>
            </div>
            <div class="column subscribe">
                <h3>Newsletter</h3>
                <div class="footersearch">
                <form action="newsletter.php" method="post" onsubmit="return validateEmail()">
                <input type="email" id="email" placeholder="Your email id here" name="email" required/>
                <button type="submit" name="submit">Subscribe</button>
            </form>
            </div>

            <script>
                function validateEmail() {
               var email = document.getElementById('email').value;
               var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        
               if (!emailPattern.test(email)) {
                   alert("Please enter a valid email address. Example: user@example.com");
                   return false;
                }
                   return true;
                }
            </script>

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