<?php session_start(); ?>
<?php
//include database connection
require_once 'conn.php';
$errors = array();
if (isset($_POST['submit'])) {
    $uName = $_POST['Name'];
    $uEmail = $_POST['email'];
    $uMobileNo = $_POST['MobileNo'];
    $uAddress = $_POST['address'];
    $city = $_POST['city'];
    $PSW = $_POST['psw'];
    $CPSW = $_POST['psw-repeat'];

    //checking email address already exists
    $uEmail = mysqli_real_escape_string($conn, $_POST['email']);
    $query = "SELECT * FROM mmuser WHERE eMailAddress = '{$uEmail}' LIMIT 1";

    $result_set = mysqli_query($conn, $query);

    if ($result_set) {
        if (mysqli_num_rows($result_set) == 1) {
            $errors[] = 'email address already exists';
        }
    }
    if ($PSW != $CPSW) {
        $errors[] = 'password mismatch';
    }

    if (empty($errors)) {
        
        $uName = mysqli_real_escape_string($conn, $_POST['Name']);
        $uEmail = mysqli_real_escape_string($conn, $_POST['email']);
        $uMobileNo = mysqli_real_escape_string($conn, $_POST['MobileNo']);
        $uAddress = mysqli_real_escape_string($conn, $_POST['address']);
        $city = mysqli_real_escape_string($conn, $_POST['city']);
        $PSW = mysqli_real_escape_string($conn, $_POST['psw']); 

        $query = "INSERT INTO mmuser (uName, eMailAddress, uMobileNo, uAddress, city, UPW) 
                    VALUES ('{$uName}', '{$uEmail}', '{$uMobileNo}', '{$uAddress}', '{$city}', '{$PSW}')";


        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "<script>alert('registration successful, please login using ur credentials')</script>";
            
            header('location: loginForm.php?item_added=true');
        } else {
            $errors[] = 'Failed to add the record';
        }
    }
}
?>
<?php
$itemList = '';
$items = '';
//check if there is a search term
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
        <meta charset="UTF-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Medi Mart</title>
        <link rel="icon" href="../Images/medimart_logo.png"/>
        <link rel="stylesheet" href="../CSS/template.css"/>
        <link rel="stylesheet" href="../CSS/register.css"/>
        
        <script src="../JS/home.js"></script>
        <script src="../JS/cancel.js"></script>
        <script src="../JS/form.js"></script>

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
            <form action="register.php" method="GET">
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
    <div class="register-mother-left-right">
        <div class="register-child-left">
            <img src="../Images/aboutus.svg">
        </div>
        <div class="register-child-right">
            <div class="Sign-Up">
                <form action="register.php" method="POST" name="RegForm" enctype="multipart/form-data">
                    <div class="signup-container">
                        <h1>Sign Up</h1>
                        <p>Please fill in this form to create an account.</p>
                        <div class="already-member"><a href="#" onclick="alreadyAmember();">Alredy a member : Login
                                here</a></div>

                        <hr/>
                        
                        <?php
                        if (!empty($errors)) {
                            echo '<div class="error">';
                            echo '<b>There were error(s) on your form.</b><br>';
                            echo "<script>alert('There were error(s) on your form!')</script>";
                            foreach ($errors as $error) {
                                echo $error . '<br>';
                            }
                            echo '</div><br>';
                        }
                        ?>
                        <p>
                            <label for="Name"><b>Full Name</b></label>
                            <input type="text" placeholder="Enter your full name" name="Name" required/>
                            <label for="email"><b>Email</b></label>
                            <input type="email" placeholder="Enter Email" name="email" required/>
                            <label for="MobileNo"><b>Mobile Number</b></label>
                            <input type="text" placeholder="Enter your mobile number" name="MobileNo" required/>
                            <label for="address"><b>Address</b></label>
                            <input type="text" placeholder="Enter your address" name="address" required/>
                            <label for="city"><b>City</b></label>
                            <input type="text" placeholder="Enter your city" name="city"/>
                            <label for="psw"><b>Password</b></label>
                            <input type="password" placeholder="Enter Password" name="psw" minlength="8" required/>
                            <label for="psw-repeat"><b>Repeat Password</b></label>
                            <input type="password" placeholder="Repeat Password" name="psw-repeat" required/>
                        <p>
                            By creating an account you agree to our
                            <a href="privacyPolicy.php">Terms & Privacy</a>.
                        </p>
                        <div class="signupfrom-buttons">
                            <button type="submit" class="signupbtn" name="submit">Sign Up</button>
                            <button type="button" class="cancelbtn" onclick="cancelregister();">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!--footer-->
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
            </div>
            <div class="column">
                <h3>Help</h3>
                <ul>
                    <li><a href="#" onclick="FAQs();">FAQs</a></li>
                    <li><a href="#" onclick="disputes();">Disputes</a></li>
                    <li><a href="#" onclick="shipping();">Shipping</a></li>
                    <li><a href="#" onclick="returns();">Returns</a></li>
                </ul>
            </div>
            <div class="column">
                <h3>Account</h3>
                <ul>
                    <li><a href="#" onclick="myacc();">My Account</a></li>
                    <li><a href="#" onclick="register();">Register</a></li>
                    <li><a href="#" onclick="cart();">View Cart</a></li>
                    <li><a href="#" onclick="help();">Help</a></li>
                </ul>
            </div>
            <div class="column">
                <h3>Social</h3>
                <div class="social">
                <a href="#"><img src="../Images/fb.png" style="width:40px; height:40px;" id="i1" onclick="fbLogin();"></a>
                <a href="#"><img src="../Images/ig.png" style="width:40px; height:40px;" id="i2" onclick="instaLogin();"></a>
                <a href="#"><img src="../Images/x.png" style="width:40px; height:40px;" id="i3" onclick="twitterLogin();"></a>
                <a href="#"><img src="../Images/yt.png" style="width:40px; height:40px;" id="i4" onclick="youtube();"></a>
                <a href="#"><img src="../Images/wa.png" style="width:40px; height:40px;" id="i5" onclick="whatsapp();"></a>
            </div>
            </div>
        </div>
    </footer>

    </body>
    </html>
