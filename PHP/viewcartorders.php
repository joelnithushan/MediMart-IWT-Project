<?php session_start(); ?>
<?php

require_once 'conn.php'; ?>
<?php

if (!isset($_SESSION['user_id'])) {
    header('location: loginForm.php');
}
$viewCartOrders = '';


$query = "SELECT * FROM cart ORDER BY CID DESC";
$CartOrders = mysqli_query($conn, $query);

if ($CartOrders) {

    while ($CartOrder = mysqli_fetch_assoc($CartOrders)) {
        $viewCartOrders .= "<tr>";
        $viewCartOrders .= "<td>{$CartOrder['CID']}</td>";
        $viewCartOrders .= "<td>{$CartOrder['uname']}</td>";
        $viewCartOrders .= "<td>{$CartOrder['email']}</td>";
        $viewCartOrders .= "<td>{$CartOrder['mobileNo']}</td>";
        $viewCartOrders .= "<td>{$CartOrder['address1']}</td>";
        $viewCartOrders .= "<td>{$CartOrder['payment']}</td>";
        $viewCartOrders .= "<td>{$CartOrder['newAddress']}</td>";
        $viewCartOrders .= "<td>{$CartOrder['itemsAndQuantity']}</td>";
        $viewCartOrders .= "<td>{$CartOrder['Ordered-date-and-Time']}</td>";
        $viewCartOrders .= "</tr>";
    }
} else {
    echo "Database query failed.";
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
    <link rel="stylesheet" href="../CSS/viewcartorders.css">
    
    <script src="../JS/admindashboard.js"></script>
</head>

<!--header-->
<body>
<div class="nav-box">
<div class="header">
    <a href="#default" class="logo"><img class="mmlogo" src="../Images/medimart_logo.png" alt="MediMart Logo"></a>
    <div class="header-right">
        <a href="#" onclick="adminDashBoard();"><img src="../Images/profile_icon.png" style='width: 40px; height: 40px;' ><br>&nbsp;&nbsp;&nbsp;<?php echo $_SESSION['name']; ?></a>
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

<main class="viewCartOrders-main">
    <h2>Cart Order list</h2>
    <br>
    <table class="viewCartOrders">
        <tr>
            <th>Cart Order ID</th>
            <th>Name</th>
            <th>E-mail</th>
            <th>Mobile No</th>
            <th>Address</th>
            <th>Payment</th>
            <th>New Address</th>
            <th>Items and Quantity</th>
            <th>Added date and time</th>

        </tr>

        <?php echo $viewCartOrders; ?>
    </table>
</main>
<footer>
    <div class="row primary">
        <div class="column about">
            <h3><img src="../Images/medimart_logo.png" style="width:250; height:80px" alt="MediMart Logo"></h3>
            <p>
                We are committed to your health at Medi Mart. We now offer an
                online shopping and ordering experience to make health and wellness
                products more accessible to you. You may browse thousands of home
                health and over-the-counter goods on our site.
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