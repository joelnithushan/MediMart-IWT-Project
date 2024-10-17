<?php session_start(); ?>
<?php
//include database connection
require_once 'conn.php'; ?>

<?php

if (!isset($_SESSION['user_id'])) {
    header('location: loginForm.php');
}

$errors = array();
$uName = '';
$uMobileNo = '';
$uAddress = '';
$city = '';

if (isset($_GET['user_ID'])) {
    
    $user_ID = mysqli_real_escape_string($conn, $_GET['user_ID']);
    $query = "SELECT * FROM mmuser WHERE mmUID = {$user_ID} LIMIT 1";

    $result_set = mysqli_query($conn, $query);
    if ($result_set) {
        if (mysqli_num_rows($result_set) == 1) {
           
            $result = mysqli_fetch_assoc($result_set);
            $uName = $result['uName'];
            $uMobileNo = $result['uMobileNo'];
            $uAddress = $result['uAddress'];
            $city = $result['city'];
        } else {
        
            header('Location: myaccAdmin.php?err=user_not_found');
        }
    } else {
        
        header('Location: myaccAdmin.php?err=query_failed');
    }
}

if (isset($_POST['submit'])) {
    $user_ID = $_POST['user_ID'];
    $uName = $_POST['Name'];
    $uMobileNo = $_POST['MobileNo'];
    $uAddress = $_POST['address'];
    $city = $_POST['city'];

    if (empty($errors)) {
    
        $uName = mysqli_real_escape_string($conn, $_POST['Name']);
        $uMobileNo = mysqli_real_escape_string($conn, $_POST['MobileNo']);
        $uAddress = mysqli_real_escape_string($conn, $_POST['address']);
        $city = mysqli_real_escape_string($conn, $_POST['city']);

        $query = "UPDATE mmuser SET ";
        $query .= "uName = '{$uName}',";
        $query .= "uMobileNo = '{$uMobileNo}',";
        $query .= "uAddress = '{$uAddress}',";
        $query .= "city = '{$city}'";
        $query .= "WHERE mmUID = {$user_ID} LIMIT 1";

        $result = mysqli_query($conn, $query);

        if ($result) {
    
            header('location: loginForm.php?user_modified=true');
        } else {
            $errors[] = 'Failed to modify the record';
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
        <link rel="stylesheet" href="../CSS/editacc.css"/>
        
        
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
            //showing admin name
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
    
    <div class="register-mother-left-right">
        <div class="register-child-left">
            <img src="../Images/aboutus.svg">
        </div>
        <div class="register-child-right">
            <div class="Sign-Up">
            <form action="editAdminAcc.php" method="POST" name="RegForm" enctype="multipart/form-data" onsubmit="return validateForm()">
    <div class="signup-container">
        <h1>Update Admin Account</h1>
        <p>Please fill this form to update your account.</p>
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
            <input type="hidden" name="user_ID" value="<?php echo $user_ID; ?>"/>
            <label for="Name"><b>Full Name</b></label>
            <input type="text" id="Name" placeholder="Enter your full name"
                   name="Name" value="<?php echo $uName; ?>" />
            <label for="MobileNo"><b>Mobile Number</b></label>
            <input type="text" id="MobileNo" placeholder="Enter your 9 digit mobile number without the leading 0"
                   name="MobileNo" value="<?php echo $uMobileNo; ?>" />
            <label for="address"><b>Address</b></label>
            <input type="text" id="address" placeholder="Enter your address"
                   name="address" value="<?php echo $uAddress; ?>" />
            <label for="city"><b>City</b></label>
            <input type="text" id="city" placeholder="Enter your city"
                   name="city" value="<?php echo $city; ?>" />
        <p>

        </p>
        <div class="signupfrom-buttons">
            <button type="submit" class="signupbtn" name="submit"
                    onclick="return confirm('Are you sure you want to update your account?');">Change
                Account Details
            </button>
            <button type="button" class="cancelbtn" onclick="cancel();">Cancel</button>
        </div>
    </div>
</form>

<script>
function validateForm() {

    const name = document.getElementById("Name").value.trim();
    const mobileNo = document.getElementById("MobileNo").value.trim();
    const address = document.getElementById("address").value.trim();
    const city = document.getElementById("city").value.trim();

    const namePattern = /^[A-Za-z ]+$/;
    const mobilePattern = /^[0-9]{9}$/;
    const cityPattern = /^[A-Za-z ]+$/;

    if (name && !namePattern.test(name)) {
        alert("Please enter a valid full name (letters and spaces only).");
        return false;
    }

    if (mobileNo && !mobilePattern.test(mobileNo)) {
        alert("Please enter a valid 10-digit mobile number starting with 0.");
        return false; //its prevent form submission
    }
   
    if (city && !cityPattern.test(city)) {
        alert("Please enter a valid city name (letters and spaces only).");
        return false; //its prevent form submission
    }

    return true; //allow form submission if all validations pass
}
</script>

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
//close database connection
mysqli_close($conn); ?>