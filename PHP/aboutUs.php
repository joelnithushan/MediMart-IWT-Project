<?php session_start(); ?>

<?php

require_once 'conn.php'; //include database connection

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
    <link rel="stylesheet" href="../CSS/aboutUs.css">

    <script src="../JS/home.js"></script>
</head>

<body>
<div class="nav-box">
<div class="header">
    <a onclick="home();"><img class="mmlogo" src="../Images/medimart_logo.png" alt="MediMart Logo"></a>

    <div class="header-right">

        <?php

        if (isset($_SESSION['user_id'])) {
                echo "<a onclick=\"myacc();\"><img src='../Images/profile_icon.png' alt='Profile Icon' style='width: 40px; height: 40px;'><br>&nbsp;&nbsp;&nbsp;";
                echo $_SESSION['name'] . "</a>";
            } else {
                
                echo "<a onclick=\"register();\"><img src=\"../Images/profile_icon.png\" alt=\"Profile Icon\" style=\"width: 40px; height: 40px;\"><br>Sign in</a>";
            }
        ?>
        
        <?php

        if (!empty($_SESSION["shopping_cart"])) {
            $cart_count = count(array_keys($_SESSION["shopping_cart"]));
            ?>
            <a href="cart.php"><img src="../Images/cart_icon.png" style="width:25px; height:25px;"> : <?php echo $cart_count; ?></a>
            <?php
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

        <form action="aboutUs.php" method="GET">
            <input type="text" placeholder="Search" name="search"/>
            
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


<section id="aboutusi" class="section-1">
    <div class="aboutusimg">
        <img src="../Images/aboutus.svg">
    </div>
    <div class="details">
        <h1>About Medi Mart</h1>
        <p>
        MediMart is a leading online publisher of healthcare media, providing consumers with easy-to-read,
         authoritative medical information through our user-friendly and interactive website.<br>

        Led by a team of professionals, MediMart has introduced an innovative retail concept focused on delivering
        an exceptional shopping experience through outstanding service, cutting-edge technology, a wide product range,
        competitive pricing, and added value. This approach has established MediMart as a market leader in drugstore retailing,
        with a loyal customer base.<br>

        To accommodate busy schedules and traffic challenges, we launched our online pharmacy service. Through the 'MediMart Pharmacy Online' platform,
         customers can easily upload medical prescriptions or order medical equipment and medications. Our licensed dispensers ensure that your order is delivered
          right to your doorstep. Our staff is trained to provide advice on medical products, prescriptions, and offer demonstrations or installations of medical equipment.<br>

        At MediMart, our mission is to set the standard in healthcare retailing.
         We go beyond being just a pharmacy—our business model focuses on helping customers live better and look better,
          with a holistic approach to healthcare retailing.
        </p>

        <h2>Our Vision</h2>
        <p>To be Sri Lanka's most admired healthcare retailer.</p>

        <h2>Our Mission</h2>
        <p>
            To provide the Customer and the Community with superior Pharma,
            Wellness, and Beauty solutions.
        </p>
        <br>
        <div>
            <button class="register" onclick="register();">Register to our website</button>
        </div>
        <br>
</section>
<!--footer start-->
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
                    <a onclick="contactUs();">Contact Us</a>
                </li>
                <li>
                    <a onclick="privacyPolicy();">Privacy Policy</a>
                </li>
                <li>
                    <a onclick="aboutUs();">About Us</a>
                </li>
            </ul>
        </div>
        <div class="column subscribe">
            <h3>Newsletter</h3>
            <div class="footersearch">
                <input type="email" placeholder="Your email id here"/>
                <button>Subscribe</button>
            </div>
        </div>
    </div>
    <div class="row copyright">
        <p>© 2024 MediMart.inc. All rights reserved.</p>
    </div>
</footer>
</body>
</html>