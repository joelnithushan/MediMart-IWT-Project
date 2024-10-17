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

if (isset($_POST['submit'])) {
    $genericname = $_POST['genericname'];
    $brandname = $_POST['brandname'];
    $code = $_POST['code'];
    $itmprice = $_POST['itmprice'];
    $type = $_POST['type'];


    $fileName = $_FILES['itemImgUpload']['name'];
    $fileType = $_FILES['itemImgUpload']['type'];
    $fileSize = $_FILES['itemImgUpload']['size'];
 
    $tempName = $_FILES['itemImgUpload']['tmp_name'];

    //upload directory path
    $uploadTo = '../Images/itemImg/';

    //checking file type
    if ($fileType == 'image/jpeg' || $fileType == 'image/png') {

        $fileUplpaded = move_uploaded_file($tempName, $uploadTo . $fileName);
    } else {
        $errors[] = "file type is invalid";
    }

    //checking item already exists
    $item = mysqli_real_escape_string($conn, $genericname);
    $query = "SELECT * FROM item WHERE genericName = '{$item}'LIMIT 1";

    $result_set = mysqli_query($conn, $query);

    if ($result_set) {
        if (mysqli_num_rows($result_set) == 1) {
            $errors[] = 'item address already exists';
        }
    }

    if (empty($errors)) {

        $genericname = mysqli_real_escape_string($conn, $_POST['genericname']);
        $brandname = mysqli_real_escape_string($conn, $_POST['brandname']);
        $code = mysqli_real_escape_string($conn, $_POST['code']);
        $itmprice = mysqli_real_escape_string($conn, $_POST['itmprice']);
        $type = mysqli_real_escape_string($conn, $_POST['type']);

        $query = "INSERT INTO item ( ";
        $query .= "genericName,brandName,code,itemPrice,itemImage,type";
        $query .= ") VALUES (";
        $query .= "'{$genericname}','{$brandname}','{$code}','{$itmprice}','{$fileName}','{$type}'";
        $query .= ")";

        $result = mysqli_query($conn, $query);

        if ($result) {
    
            header('location: admindashboard.php?item_added=true');
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
        <link rel="stylesheet" href="../CSS/addnewitem.css">
        
        <script src="../JS/admindashboard.js"></script>
        <script src="../JS/addnewitem.js"></script>
        <script src="../JS/cancel.js"></script>
    </head>

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
    <div class="addNewItemPage">
    <form name="itemForm" action="addnewitem.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm();">

            <div class="addNewItemPage-container">
                <h1>Add New Item</h1>
                <hr/>
                <label for="genericname"><b>Generic Name</b></label>
                <input type="text" placeholder="Enter generic name of the item " name="genericname" required/>

                <label for="brandname"><b>Brand Name</b></label>
                <input type="text" placeholder="Enter Brand name of the item" name="brandname" required/>

                <label for="code"><b>Code</b></label>
                <input type="text" placeholder="Enter Code of the item" name="code" required/>

                <label for="itmprice"><b>Price Rs.</b></label>
                <input type="text" placeholder="Enter Price of the item" name="itmprice" required/>

                <h3>Type :</h3>
                <label for="medicine">medicine</label>
                <input type="radio" id="medicine" name="type" value="medicine" required/>
                <label for="medicine">medical devices</label>
                <input type="radio" id="medical-devices" name="type" value="medical devices" required/>
                 <label for="medicine">traditional remedies</label>
                <input type="radio" id="traditional-remedies" name="type" value="traditional remedies" required/>
                

                <h3>Upload Image for the Item :</h3>
                <?php
                if (!empty($errors)) {
                    echo "<p class=errors>*invalid file type</p>";
                }
                ?>
                <input type="file" class="itemImgUpload" name="itemImgUpload" required/><br>
                <p>
                    Select a JPG / PNG . Once selected, your image
                    file is shown above.
                </p>
                <br>

                <button type="submit" name="submit">Submit</button>
            </div>

            <div class="cancelbtn-container">
                <button type="button" class="cancelbtn" onclick="cancelAdd();">Cancel</button>
            </div>
        </form>
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
//close connection to database
mysqli_close($conn);
?>