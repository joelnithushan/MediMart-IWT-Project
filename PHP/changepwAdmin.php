<?php session_start(); ?>
<?php

if (!isset($_SESSION['user_id'])) {
    header('location: loginForm.php');
}
?>
<?php
//include database connection
require_once 'conn.php';
$errors = array();
$PSW = '';
$CPSW = '';

if (isset($_GET['user_ID'])) {
    //getting the user information
    $user_ID = mysqli_real_escape_string($conn, $_GET['user_ID']);
    $query = "SELECT * FROM mmuser WHERE mmUID = {$user_ID} LIMIT 1";

    $result_set = mysqli_query($conn, $query);
    if ($result_set) {
        if (mysqli_num_rows($result_set) == 1) {
            //user found
            $result = mysqli_fetch_assoc($result_set);
            $PSW = $result['UPW'];
        } else {

            header('Location: myaccAdmin.php?err=user_not_found');
        }
    } else {

        header('Location: myaccAdmin.php?err=query_failed');
    }
}
if (isset($_POST['submit'])) {
    $user_ID = $_POST['user_ID'];
    $PSW = $_POST['psw'];
    $CPSW = $_POST['psw-repeat'];

    if ($PSW != $CPSW) {
        $errors[] = 'Password mismatch';
    }

    if (empty($errors)) {

        $PSW = mysqli_real_escape_string($conn, $PSW); 

        $query = "UPDATE mmuser SET ";
        $query .= "UPW = '{$PSW}' "; //set plain password directly
        $query .= "WHERE mmUID = {$user_ID} LIMIT 1";

        $result = mysqli_query($conn, $query);

        if ($result) {
            header('location: loginForm.php?password_updated=true');
        } else {
            $errors[] = 'Failed to update the record';
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
    <link rel="stylesheet" href="../CSS/changepw.css"/>
    
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

<div class="register-mother-left-right">
    <div class="register-child-left">
        <img src="../Images/aboutus.svg">
    </div>
    <div class="register-child-right">
        <div class="Sign-Up">
            <form action="changepwAdmin.php" method="POST" name="RegForm" enctype="multipart/form-data">
                <div class="signup-container">
                    <h1>Change Password</h1>
                    <p>Please fill this form to update your password.</p>
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
                        <label for="psw"><b>Enter New Password</b></label>
                        <input type="password" placeholder="Enter Password" name="psw" minlength="8" required/>
                        <label for="psw-repeat"><b>Repeat New Password</b></label>
                        <input type="password" placeholder="Repeat Password" name="psw-repeat" required/>
                    <p>
                    </p>
                    <div class="signupfrom-buttons">
                        <button type="submit" class="signupbtn" name="submit"
                                onclick="return confirm('Are you sure you want to update your Password?');">Update
                            Password
                        </button>
                        <button type="button" class="cancelbtn" onclick="cancel();">Cancel</button>
                    </div>
                </div>
            </form>
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
mysqli_close($conn);
?>
