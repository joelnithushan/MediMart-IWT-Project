<?php
//include database connection
require_once 'conn.php'; ?>
<?php session_start(); ?>
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
<?php

$status = "";
//add to cart process
if (isset($_POST['code']) && $_POST['code'] != "") {
    $code = $_POST['code'];
    $result = mysqli_query($conn, "SELECT * FROM `item` WHERE `code`='$code'");
   
    $row = mysqli_fetch_assoc($result);
    $genericName = $row['genericName'];
    $brandName = $row['brandName'];
    $code = $row['code'];
    $itemPrice = $row['itemPrice'];
    $itemImage = $row['itemImage'];

    $cartArray = array(
        $code => array(
            'genericName' => $genericName,
            'brandName' => $brandName,
            'code' => $code,
            'itemPrice' => $itemPrice,
            'quantity' => 1,
            'itemImage' => $itemImage,
        ),
    );
    if (empty($_SESSION["shopping_cart"])) {
        $_SESSION["shopping_cart"] = $cartArray;
        $status = "Product is added to your cart!";
    } else {
        $array_keys = array_keys($_SESSION["shopping_cart"]);
        if (in_array($code, $array_keys)) {
            $status = "<p class=\"red\">Product is already added to your cart!<p>";
        } else {
            $_SESSION["shopping_cart"] = array_merge($_SESSION["shopping_cart"], $cartArray);
            $status = "Product is added to your cart!";
        }
    }
}

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Medi Mart</title>
        <link rel="icon" href="../Images/medimart_logo.png"/>
        <link rel="stylesheet" href="../CSS/template.css"/>
        <link rel="stylesheet" href="../CSS/store.css"/>
        
        
        <script src="../JS/home.js"></script>
    </head>

    <body>
    <div class="nav-box">
    <div class="header">
        <a onclick="home();"><img class="mmlogo" src="../Images/medimart_logo.png" alt="MediMart Logo"></a>
        <div class="header-right">
            <?php
            //if there is a user display username
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
            <form action="traditionalRemedies.php" method="GET">
                <input type="text" placeholder="Search.." name="search"/>
                
            </form>
            <div class="dropdown-content" id="drop">
                <?php
                //display searched items
                if ($items) {
                    echo $itemList;
                }
                ?>
            </div>
        </div>
    </div>
    </div>
    <br>
    <h2>
        <t>&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;Traditional Remedies
    </h2>

    <div class="status" id="status1">
        <?php echo $status; ?>
    </div>
    <section id="product1" class="section-p1">
        <div class="pro-container">

            <?php
            $result = mysqli_query($conn, "SELECT * FROM `item` WHERE `type` = 'traditional remedies'");

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='pro'>
                  <form method='post' action=''>
                  <input type='hidden' name='code' value=" . $row['code'] . " />
                  <img src='../Images/itemImg/" . $row['itemImage'] . "' />
                  <div class='des'>
                  <span>" . $row['genericName'] . "</span>
                  <h5>" . $row['brandName'] . "</h5>
                  <h4>Rs. " . $row['itemPrice'] . "</h4>
                  <button type='submit' class='button'>Add to Cart</button>
                  </div>
                  </form>
                     </div>";
            }
            ?>
        </div>
    </section>
    
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