<?php session_start(); ?>
<?php

require_once 'conn.php'; ?>
<?php
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
    <link rel="stylesheet" href="../CSS/privacyPolicy.css">

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
        <form action="privacyPolicy.php" method="GET">
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
<div class="privacy">
    <br>
    <br>
    <h1>Privacy Policy</h1>
    <br>
    <h2>Information We Collect</h2>
    <p>
    We collect your personal and contact information solely to process your orders and ensure timely delivery.
     To enhance your shopping experience, we may gather data on your device and on-site behavior to make our online store more
      user-friendly and personalized.<br><br>
    We work with third-party service providers to offer you the best customer service.
    These partners access only the necessary information to fulfill their responsibilities. 
    For example, payment services use your credit card details, name, and surname to authenticate and process payments. 
    Our suppliers and stockkeepers use your order details to prepare your items, 
    while postal services use your name and address to deliver them.<br><br>
    By continuing to use our website, you agree to the use of your personal information as outlined in this Privacy Policy.
    If you do not agree with these terms, please discontinue using the site.
    </p>
    <br>
    <h2>Use Of Cookies</h2>
    <p>
    We deliver high-quality, effective medication right to your doorstep. 
    At Medi Mart, we operate with integrity—there is no room for fraud or unethical practices, 
    as building and maintaining trust with our customers is a top priority.<br><br>
    Our primary goal is to ensure customer satisfaction through our efficient service and by safeguarding the confidentiality
     of your personal information. We offer a wide selection of FDA-approved generic and branded medications at affordable prices,
      with significant discounts.<br><br>
    Please note that order cancellations are allowed within 12-24 hours of placing an order.
     To request a cancellation, please email Medi Mart. Unfortunately, no cancellation requests will be accepted 
     after the 24-hour period.<br><br>
    Thank you for your understanding and support!
    </p>
    <br>
    <br>
    <br>
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
                <input type="email" placeholder="Your email id here"/>
                <button>Subscribe</button>
            </div>
        </div>
    </div>
    <div class="row copyright">
        <p>© 2024 MadiMart.inc. All rights reserved.</p>
    </div>
</footer>

</body>
</html>