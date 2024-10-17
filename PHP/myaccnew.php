<?php
session_start();


require_once 'conn.php';


if (!isset($_SESSION['user_id'])) {
    header('Location: loginForm.php');
    exit();
}


$itemList = '';
$items = '';
$errors = array();
$message = '';


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


if (isset($_GET['deleteAccount'])) {

    $userID = $_SESSION['user_id'];


    $query = "DELETE FROM mmuser WHERE mmUID = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $userID);


    if (mysqli_stmt_execute($stmt)) {

        session_destroy();
        $message = "<h1 style='text-align:center;'>Your Account Has Been Deleted</h1>
                    <p style='text-align:center;'>We are sorry to see you go! If you change your mind, you can always create a new account.</p>
                    <a class='return-login' href='loginForm.php'>Return to Login</a><br>";
    } else {

        $errors[] = "Unable to delete account.";
    }

    //Close the statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
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
    <link rel="stylesheet" href="../CSS/myaccnew.css">

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
            <form action="myaccnew.php" method="GET">
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

<!-- MY Account -->
<div class="ymyacc">
    <div class="ymyaccleft">
        <h1>My Profile</h1>

        <h4>Account Information</h4>
        <hr/>

        <h4>Contact Information</h4>

        <p>Name : <?php echo $_SESSION['name']; ?></p>
        <p>E-mail : <?php echo $_SESSION['email']; ?></p>
        <p>Mobile Number: 0<?php echo $_SESSION['mobileNo']; ?></p>

        <br>

        <h4>Address Book</h4>
        <hr/>

        <p>Address</p>
        <p><?php echo $_SESSION['address']; ?></p>
        <br>

        <div class="myacc-btnbox">
            <button class="myacc-editbtn"><?php echo "<a href=\"editacc.php?user_ID={$_SESSION['user_id']}\">Edit Account Information</a> "; ?></button>
            <button type="submit" name="changepw" class="myacc-changepwbtn"><?php echo "<a href=\"changepw.php?user_ID={$_SESSION['user_id']}\">Change Password</a> "; ?></button>
            <button class="myacc-logoutbtn" onclick="return confirm('Are you sure you want to Log Out ?');"><a href="logout.php">Log Out</a></button>
            <button class="myacc-deletebtn" onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                <a href="myaccnew.php?deleteAccount=1">Delete Account</a>
            </button>
        </div>
    </div>
    <div class="ymyaccright">
        <img src="../Images/myacc.jpg" alt=""/>
    </div>
</div>


<?php if (!empty($message)): ?>
    <div class="goodbye-message">
        <?php echo $message; ?>
    </div>
<?php elseif (!empty($errors)): ?>
    <div class="error-message">
        <?php foreach ($errors as $error) { echo "<p>$error</p>"; } ?>
    </div>
<?php endif; ?>

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
    </div>
    <div class="row copyright">
        <p>© 2024 MediMart.inc. All rights reserved.</p>
    </div>
</footer>

</body>
</html>
