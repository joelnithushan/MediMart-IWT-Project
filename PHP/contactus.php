<?php session_start(); ?>
<?php
//include database connection
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
<?php

if (isset($_POST['csubmit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobileNo = $_POST['mobileNo'];
    $userIdeas = $_POST['userIdeas'];

    $sql = "INSERT INTO contactus(uname,email,mobileNo,userIdeas) VALUES('$name','$email','$mobileNo','$userIdeas')";

    $result = mysqli_query($conn, $sql);

    //redirect to home page
    header('location: home.php');
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
        <link rel="stylesheet" href="../CSS/contactus.css">
        
        <script src="../JS/home.js"></script>
        <script src="../JS/contactus.js"></script>
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
            <form action="contactus.php" method="GET">
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
    <div class="flex-container-contactus">
        <div class="flex-container-contactus-left">


            <div class="contactus-form">
                <h2>Contact Us</h2>
                <form action="contactus.php" method="POST" onsubmit="return validateContactForm();">
    <label for="Name"><b>Name</b></label>
    <input type="text" name="name" id="name" required />
    
    <label for="Email"><b>Email</b></label>
    <input type="email" name="email" id="email" required />
    
    <label for="Mobilenumber"><b>Mobile number</b></label>
    <input type="text" name="mobileNo" id="mobileNo" />
    
    <p>
        <label for="Whatisonyourmind">What is on your mind....</label>
    </p>
    <textarea id="userIdeas" name="userIdeas" rows="8" cols="50" required></textarea>
    <br />
    
    <button type="submit" name="csubmit">Submit</button>
</form>

<script>
function validateContactForm() {
    //get form values
    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const mobileNo = document.getElementById("mobileNo").value.trim();
    const userIdeas = document.getElementById("userIdeas").value.trim();

    //validation
    const namePattern = /^[A-Za-z ]+$/;
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    const mobilePattern = /^0[0-9]{9}$/; 

    if (!namePattern.test(name)) {
        alert("Please enter a valid name (letters and spaces only).");
        return false;
    }

    if (!emailPattern.test(email)) {
        alert("Please enter a valid email address.");
        return false;
    }

    if (mobileNo && !mobilePattern.test(mobileNo)) {
        alert("Please enter a valid 10-digit mobile number starting with 0.");
        return false; 
    }

    if (!userIdeas) {
        alert("Please enter your thoughts or ideas.");
        return false; 
    }

    return true; 
}
</script>

            </div>


        </div>
        <div class="flex-container-contactus-right">
            <div class="flex-container-contactus-right-up-down">
                <div class="flex-container-contactus-right-up">
                    <div class="getintouch">
                        <h2>Get in Touch</h2>
                        <h3>MediMart Pharmacy Limited</h3>
                        <h3>Address</h3>
                        <p>Kantharmadam junction,Jaffna, Sri Lanka.</p>
                        <h3>Tel:</h3>
                        <p>+94 76 942 3167</p>
                        <h3>E mail:</h3>
                        <p>medimart@gmail.com</p>
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