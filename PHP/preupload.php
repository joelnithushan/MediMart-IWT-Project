<?php session_start(); ?>
<?php

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
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobileNo = $_POST['mobileNo'];
    $address1 = $_POST['address1'];
    $frequency = $_POST['frequency'];
    $fullfillment = $_POST['fullfillment'];
    $subsitues = $_POST['subsitues'];
    $days = $_POST['days'];
    $paymentoption = $_POST['paymentoption'];
    $refund = $_POST['refund'];
    $pretxt = $_POST['pretxt'];
    $newaddress = $_POST['newaddress'];

    
    $fileName = $_FILES['fileupload']['name'];
    $fileType = $_FILES['fileupload']['type'];
    $fileSize = $_FILES['fileupload']['size'];
 
    $tempName = $_FILES['fileupload']['tmp_name'];

    //upload directory path
    $uploadTo = '../Images/presupload/';

    //checking file type
    if ($fileType == 'image/jpeg' || $fileType == 'image/png' || $fileType == 'application/pdf' || $fileType == null) {
        
        $fileUplpaded = move_uploaded_file($tempName, $uploadTo . $fileName);
    } else {
        $errors[] = "file type is invalid";
    }

    if (empty($errors)) {
    
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $mobileNo = mysqli_real_escape_string($conn, $_POST['mobileNo']);
        $address1 = mysqli_real_escape_string($conn, $_POST['address1']);
        $frequency = mysqli_real_escape_string($conn, $_POST['frequency']);
        $fullfillment = mysqli_real_escape_string($conn, $_POST['fullfillment']);
        $subsitues = mysqli_real_escape_string($conn, $_POST['subsitues']);
        $days = mysqli_real_escape_string($conn, $_POST['days']);
        $paymentoption = mysqli_real_escape_string($conn, $_POST['paymentoption']);
        $refund = mysqli_real_escape_string($conn, $_POST['refund']);
        $pretxt = mysqli_real_escape_string($conn, $_POST['pretxt']);
        $newaddress = mysqli_real_escape_string($conn, $_POST['newaddress']);

        $query = "INSERT INTO pupload ( ";
        $query .= "uname,email,mobileNo,address1,frequency,fullfillment,substitutes,days,payment,refund,prescriptionTxt,prescriptionFile,newAddress";
        $query .= ") VALUES (";
        $query .= "'{$name}','{$email}','{$mobileNo}','{$address1}','{$frequency}','{$fullfillment}','{$subsitues}','{$days}','{$paymentoption}','{$refund}','{$pretxt}','{$fileName}','{$newaddress}'";
        $query .= ")";

        $result = mysqli_query($conn, $query);

        if ($result) {
            
            header('location: home.php?prescription_added=true');
        } else {
            $errors[] = 'Failed to add the record';
        }
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
        <link rel="stylesheet" href="../CSS/preupload.css">
        
        
        <script src="../JS/preupload.js"></script>
        <script src="../JS/home.js"></script>
        <script src="../JS/cancel.js"></script>
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
            <form action="preupload.php" method="GET">
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
    <section class="presup-main">
        <h1 class="yhead1">Prescription Upload</h1>
        <br>
        <h3 class="ynote">Prescription Requirement for Medication Orders</h3>
        <p>
        To ensure the safe dispensing of prescription medications, 
        we require a valid image of your doctor's prescription, 
        registered with the Sri Lanka Medical Council (SLMC). 
        Please upload a clear image of the prescription for verification. 
        Once our pharmacist reviews and approves your order, you will receive a secure payment link via the email associated with your account.

        </p>
        <br>
        <form action="preupload.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm();">

    <input type="hidden" name="name" <?php echo 'value ="' . $_SESSION['name'] . '"'; ?> />

    <input type="hidden" name="email" <?php echo 'value ="' . $_SESSION['email'] . '"'; ?> />

    <input type="hidden" name="mobileNo" <?php echo 'value = "0' . $_SESSION['mobileNo'] . '"'; ?> />

    <input type="hidden" name="address1" <?php echo 'value ="' . $_SESSION['address'] . '"'; ?> />

    <h3>Frequency:</h3>
    <input type="radio" id="yradio" name="frequency" value="One Time" required />
    <label for="yradio">One Time &nbsp </label>
    <input type="radio" id="yradio" name="frequency" value="On Going" required />
    <label for="yradio">On Going</label><br />

    <h3>Fullfillment:</h3>
    <input type="radio" id="yradio" name="fullfillment" value="Full" required />
    <label for="yradio">Full &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</label>
    <input type="radio" id="yradio" name="fullfillment" value="Partial" required />
    <label for="yradio">Partial</label><br />

    <h3>I'm Ok to receive substitutes:</h3>
    <input type="radio" id="yradio" name="subsitues" value="Yes" required />
    <label for="yradio">Yes &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</label>
    <input type="radio" id="yradio" name="subsitues" value="No" required />
    <label for="yradio">No</label><br />

    <h3>For How Many Days:</h3>
    <input type="text" id="days" name="days" size="20" placeholder="Enter Time Period..." required />

    <h3>Payment Option:</h3>
    <input type="radio" id="yradio" name="paymentoption" value="Card Payment" required />
    <label for="yradio">Card Payment &nbsp&nbsp &nbsp&nbsp &nbsp </label>
    <input type="radio" id="yradio" name="paymentoption" value="Cash On Delivery" required />
    <label for="yradio">Cash On Delivery</label><br />

    <h3>I prefer receiving any refund as:</h3>
    <input type="radio" id="yradio" name="refund" value="Cash" required />
    <label for="yradio">Cash &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</label>
    <input type="radio" id="yradio" name="refund" value="Online Banking" required />
    <label for="yradio">Online Banking</label><br />

    <h4>
        Enter the Prescription items and quantity - Ex: Crestor 5mg - 10 Qty / Crestor 10mg - 10 Qty:
    </h4>
    <textarea class="presup-ytxtarea" id="pretxt" name="pretxt" rows="10" cols="100"
        placeholder="Enter your prescription here..." required></textarea>

    <h3>Upload Prescription File (Optional):</h3>
    <?php
    if (!empty($errors)) {
        echo "<p class=errors>*invalid file type</p>";
    }
    ?>
    <input type="file" class="yupload" name="fileupload" /><br />
    <p>Select a JPG / PNG / PDF file. Once selected, your prescription image file is shown above.</p>
    <br />

    <h3>Default Shipping Address:</h3>
    <p>Address:</p>
    <p><?php echo $_SESSION['address']; ?></p>

    <h4>Enter a New Address here (Optional):</h4>
    <textarea class="presup-ytxtarea" name="newaddress" rows="5" cols="100"
        placeholder="Enter your new address here..."></textarea>
    <br /><br />
    <input type="submit" name="submit" value="Proceed to Check out" class="presup-submit" />
    <br />
    <img src="../Images/aboutus.svg" alt="vectorgraphic" />
    <br />
</form>

<script>
    //form validation function
    function validateForm() {
        
        let days = document.getElementById("days").value;
        if (isNaN(days) || days <= 0) {
            alert("Please enter a valid positive number for 'For How Many Days'.");
            return false;
        }

        let presItems = document.getElementById("pretxt").value;
        if (presItems.trim() === "") {
            alert("Please enter the prescription items and quantity.");
            return false;
        }

        return true;
    }
</script>

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