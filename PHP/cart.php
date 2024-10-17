<?php session_start(); ?>
<?php
//include database connection
require_once 'conn.php'; ?>
<?php

if (!isset($_SESSION['user_id'])) {
    header('location: loginForm.php');
}
?>
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
//include database connection
require_once 'conn.php'; ?>
<?php
$status = "";

if (isset($_POST['action']) && $_POST['action'] == "remove") {
    if (!empty($_SESSION["shopping_cart"])) {
        foreach ($_SESSION["shopping_cart"] as $key => $value) {
            if ($_POST["code"] == $key) {
                unset($_SESSION["shopping_cart"][$key]);
                $status = "Product is removed from your cart!";
            }
            if (empty($_SESSION["shopping_cart"]))
                unset($_SESSION["shopping_cart"]);
        }
    }
}

if (isset($_POST['action']) && $_POST['action'] == "change") {
    foreach ($_SESSION["shopping_cart"] as &$value) {
        if ($value['code'] === $_POST["code"]) {
            $value['quantity'] = $_POST["quantity"];
            break; //Stop the loop after found the product
        }
    }
}
?>
<?php

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobileNo = $_POST['mobileNo'];
    $address1 = $_POST['address1'];
    $payment = $_POST['payment'];
    $newAddress = $_POST['newAddress'];
    $itemsAndQuantity = $_POST['itemsAndQuantity'];

    //insert data in to table
    $sql = "INSERT INTO cart(uname,email,mobileNo,address1,payment,newAddress,itemsAndQuantity) VALUES('$name','$email','$mobileNo','$address1','$payment','$newAddress','$itemsAndQuantity')";

    $result = mysqli_query($conn, $sql);

    if ($result) {

        $_SESSION["shopping_cart"] = array();
        header('location: home.php?record_added=true');
    } else {
        $errors[] = 'Failed to add the record';
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
        <link rel="stylesheet" href="../CSS/cart.css">
        
        <script src="../JS/home.js"></script>
        <script src="../JS/cart.js"></script>        
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
    <div class="menu">
        <div class="menu-links">
            <a class="active" href="#" onclick="home();">Home</a>
            <a href="#" onclick="medicine();">Medicines</a>
            <a href="#" onclick="medicalDevices();">Medical Devices</a>
            <a href="#" onclick="traditionalRemedies();">Traditional Remedies</a>
            <a href="#" onclick="aboutUs();">About us</a>
        </div>
        <div class="search-container">
            
            <form action="cart.php" method="GET">
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
    </div>
    <br>
    <h2>
        <t>&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;Shopping Cart</t>
    </h2>
    <div>
    </div>
    <div class="y-mycart-left">
        <div class="cart">
            <?php
            if (isset($_SESSION["shopping_cart"])) {
            $total_price = 0;
            ?>
            <table class="table">
                <tbody>
                <tr>
                    <th>Item Image</th>
                    <th>Generic Name</th>
                    <th>Brand Name</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>TOTAL</th>
                    <th>Remove Item</th>
                </tr>
                <?php
        
                foreach ($_SESSION["shopping_cart"] as $product) {
                    ?>
                    <tr>
                        <td><img src='../Images/itemImg/<?php echo $product["itemImage"]; ?>' width="50" height="50"></td>
                        <td><?php echo $product["genericName"]; ?></td>
                        <td><?php echo $product["brandName"]; ?></td>
                        <td>
                            <form method='post' action=''>
                                <input type='hidden' name='code' value="<?php echo $product["code"]; ?>"/>
                                <input type='hidden' name='action' value="change"/>
                                <select name='quantity' class='quantity' onchange="this.form.submit()">
                                    <option <?php if ($product["quantity"] == 1) echo "selected"; ?> value="1">1
                                    </option>
                                    <option <?php if ($product["quantity"] == 2) echo "selected"; ?> value="2">2
                                    </option>
                                    <option <?php if ($product["quantity"] == 3) echo "selected"; ?> value="3">3
                                    </option>
                                    <option <?php if ($product["quantity"] == 4) echo "selected"; ?> value="4">4
                                    </option>
                                    <option <?php if ($product["quantity"] == 5) echo "selected"; ?> value="5">5
                                    </option>
                                </select>
                            </form>
                        </td>
                        <td><?php echo "Rs." . $product["itemPrice"]; ?></td>
                        <td><?php echo "Rs." . $product["itemPrice"] * $product["quantity"]; ?></td>
                        <td>
                            <form method='post' action=''>
                                <input type='hidden' name='code' value="<?php echo $product["code"]; ?>"/>
                                <input type='hidden' name='action' value="remove"/>
                                <button type='submit' class='remove'
                                        onclick="return confirm('Are you sure you want to remove this item from your cart?');">
                                    Remove Item
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php
                    //calculating the total price
                    $total_price += ($product["itemPrice"] * $product["quantity"]);
                }
                ?>
                <tr>
                    <td colspan="7">
                        <strong>TOTAL : <?php echo "Rs." . $total_price; ?> /=</strong>
                    </td>
                </tr>

                </tbody>
            </table>
            <form action="cart.php" method="POST" onsubmit="oderSuccessful();">

                <?php
                $itemsAndQuantity = '';
                //take all the product details to a variable
                foreach ($_SESSION["shopping_cart"] as $product) {
                    $itemsAndQuantity .= $product["genericName"] . " - " . $product["brandName"] . " Qty = " . $product["quantity"] . " / ";
                }
                ?>

                <input type="hidden" name="itemsAndQuantity" <?php echo 'value ="' . $itemsAndQuantity . '"'; ?> />

                <input type="hidden" name="name" <?php echo 'value ="' . $_SESSION['name'] . '"'; ?> />

                <input type="hidden" name="email" <?php echo 'value ="' . $_SESSION['email'] . '"'; ?> />

                <input type="hidden" name="mobileNo" <?php echo 'value = "0' . $_SESSION['mobileNo'] . '"'; ?> />

                <input type="hidden" name="address1" <?php echo 'value ="' . $_SESSION['address'] . '"'; ?> />
                <br>
                <br>
                <br>
                <h3>Payment Option:</h3>

                <input type="radio" id="yradio" name="payment" value="Card Payment" required/>
                <label for="yradio">Card Payment &nbsp&nbsp &nbsp&nbsp &nbsp </label>

                <input type="radio" id="yradio" name="payment" value="Cash On Delivery" required/>
                <label for="yradio">Cash On Delivery</label><br>

                <h4>if you have a new address to receive the products...</h4>
                <textarea class="presup-ytxtarea" name="newAddress" rows="5" cols="100"
                          placeholder="Enter your new address here..."></textarea>
                <br><br>

                <input type="submit" value="Proceed to Check out" class="ysubmit" name="submit"
                       onclick="return confirm('Are you sure you want proceed to check out?');"/>

                <button class="ysubmit1"><a href="medicine.php">Continue Shopping >></a></button>

                <div class="y-payment">

                    <p>We accept :</p>
                    <img src="../Images/cardlogo.png" height="30px"/>

                </div>
            </form>
        </div>
        <?php
        } else {
            echo "<div class='emptyCart'>
          <h1>Your cart is empty!</h1>
          <img class=\"emptyctimg\" src=\"../Images/cart_icon.png\" width:100px; height:100px;>
          </div>";
        }
        ?>
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