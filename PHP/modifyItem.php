<?php session_start(); ?>
<?php
//include database connection
require_once 'conn.php'; ?>
<?php

if (!isset($_SESSION['user_id'])) {
    header('location: loginForm.php');
}

$errors = array();
$genericname = '';
$brandname = '';
$itmprice = '';
$fileName = '';
$type = '';

if (isset($_GET['item_ID'])) {
   
    $item_ID = mysqli_real_escape_string($conn, $_GET['item_ID']);
    $query = "SELECT * FROM item WHERE itemID = {$item_ID} LIMIT 1";

    $result_set = mysqli_query($conn, $query);
    if ($result_set) {
        if (mysqli_num_rows($result_set) == 1) {
            
            $result = mysqli_fetch_assoc($result_set);
            $genericname = $result['genericName'];
            $brandname = $result['brandName'];
            $itmprice = $result['itemPrice'];
            $fileName = $result['itemImage']; 
            $type = $result['type'];
        } else {
          
            header('Location: itemlist.php?err=item_not_found');
        }
    } else {
   
        header('Location: itemlist.php?err=query_failed');
    }
}


if (isset($_POST['submit'])) {
    $item_ID = $_POST['item_ID'];
    $genericname = $_POST['genericname'];
    $brandname = $_POST['brandname'];
    $itmprice = $_POST['itmprice'];
    $type = $_POST['type'];


    if (!empty($_FILES['itemImgUpload']['name'])) {
        $fileName = $_FILES['itemImgUpload']['name'];
        $fileType = $_FILES['itemImgUpload']['type'];
        $fileSize = $_FILES['itemImgUpload']['size'];
        $tempName = $_FILES['itemImgUpload']['tmp_name'];

        //upload directory path
        $uploadTo = 'itemImg/';

        
        if ($fileType == 'image/jpeg' || $fileType == 'image/png') {
        
            move_uploaded_file($tempName, $uploadTo . $fileName);
        } else {
            $errors[] = "Invalid file type. Only JPG or PNG allowed.";
        }
    }

    //checking items already exists
    $item = mysqli_real_escape_string($conn, $genericname);
    $query = "SELECT * FROM item WHERE genericName = '{$item}' AND itemID != {$item_ID} LIMIT 1";

    $result_set = mysqli_query($conn, $query);

    if ($result_set) {
        if (mysqli_num_rows($result_set) == 1) {
            $errors[] = 'Item already exists';
        }
    }

    if (empty($errors)) {
        
        $genericname = mysqli_real_escape_string($conn, $_POST['genericname']);
        $brandname = mysqli_real_escape_string($conn, $_POST['brandname']);
        $itmprice = mysqli_real_escape_string($conn, $_POST['itmprice']);
        $type = mysqli_real_escape_string($conn, $_POST['type']);

        $query = "UPDATE item SET ";
        $query .= "genericName = '{$genericname}', ";
        $query .= "brandName = '{$brandname}', ";
        $query .= "itemPrice = '{$itmprice}', ";
        if (!empty($_FILES['itemImgUpload']['name'])) { 
            $query .= "itemImage = '{$fileName}', ";
        }
        $query .= "type = '{$type}' ";
        $query .= "WHERE itemID = {$item_ID} LIMIT 1";

        $result = mysqli_query($conn, $query);

        if ($result) {
            
            header('location: admindashboard.php?item_modified=true');
        } else {
            $errors[] = 'Failed to modify the record';
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
    <link rel="stylesheet" href="../CSS/modifyItem.css">
    
    <script src="../JS/cancel.js"></script>
</head>

<body>
<div class="nav-box">
    <div class="header">
        <a href="#default" class="logo"><img class="mmlogo" src="../Images/medimart_logo.png" alt="MediMart Logo"></a>
        <div class="header-right">
            <a href="#" onclick="adminDashBoard();"><img src="../Images/profile_icon.png" alt="Profile Icon" style="width: 40px; height: 40px;\"><br>&nbsp;&nbsp;&nbsp;<?php echo $_SESSION['name']; ?></a>
        </div>
    </div>
    <div class="menu">
        <div class="menu-links">
            <a class="active" onclick="adminDashBoard();">Home</a>
            <a href="#" onclick="addnewItem();">Add New Items</a>
            <a href="#" onclick="viewItems();">View Items, Update & Delete</a>
            <a href="#" onclick="viewContactUs();">View Contact Us</a>
            <a href="#" onclick="viewPreupOrders();">View Prescription Orders</a>
            <a href="#" onclick="viewCartOrders();">View Cart Orders</a>
        </div>
        <div class="search-container">
        </div>
    </div>
</div>

<div class="addNewItemPage">
    <form name="itemForm" action="modifyItem.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm();">
        <div class="addNewItemPage-container">
            <h1>View / Modify Item</h1>
            <hr/>
            <input type="hidden" name="item_ID" value="<?php echo $item_ID; ?>"/>
            
            <label for="genericname"><b>Generic Name</b></label>
            <input type="text" placeholder="Enter generic name of the item" name="genericname" value="<?php echo $genericname; ?>">

            <label for="brandname"><b>Brand Name</b></label>
            <input type="text" placeholder="Enter Brand name of the item" name="brandname" value="<?php echo $brandname; ?>">

            <label for="itmprice"><b>Price Rs.</b></label>
            <input type="text" placeholder="Enter Price of the item" name="itmprice" value="<?php echo $itmprice; ?>">

            <h3>Type :</h3>
            <label for="medicine">Medicine</label>
            <input type="radio" id="medicine" name="type" value="medicine" <?php if ($type == 'medicine') echo 'checked'; ?> />
            <label for="medical-devices">Medical Devices</label>
            <input type="radio" id="medical-devices" name="type" value="medical devices" <?php if ($type == 'medical devices') echo 'checked'; ?> />
            <label for="traditional-remedies">Traditional Remedies</label>
            <input type="radio" id="traditional-remedies" name="type" value="traditional remedies" <?php if ($type == 'traditional remedies') echo 'checked'; ?> />

            <h3>Upload Image for the Item :</h3>
            <?php
            if (!empty($errors)) {
                echo "<p class='errors'>". implode('<br>', $errors) . "</p>";
            }
            ?>
            <input type="file" class="itemImgUpload" name="itemImgUpload"/><br>
            <p>If no file is selected, the current image will remain.</p>
            <br>
            <button type="submit" name="submit">Submit</button>
        </div>

        <div class="cancelbtn-container">
            <button type="button" class="cancelbtn" onclick="cancelModify()">Cancel</button>
        </div>
    </form>
</div>

<footer>
    <div class="row primary">
        <div class="column about">
            <h3><img src="../Images/medimart_logo.png" style="width:250; height:80px" alt="MediMart Logo"></h3>
            <p>At Medi Mart, your health is our top priority...</p>
        </div>
        <div class="social">
            <a href="#"><img src="../Images/fb.png" style="width:40px; height:40px;"></a>
            <a href="#"><img src="../Images/ig.png" style="width:40px; height:40px;"></a>
            <a href="#"><img src="../Images/x.png" style="width:40px; height:40px;"></a>
        </div>
    </div>
    <div class="row copyright">
        <p>© 2024 MadiMart.inc. All rights reserved.</p>
    </div>
</footer>

<script>
    function validateForm() {
        const genericname = document.forms['itemForm']['genericname'].value;
        const brandname = document.forms['itemForm']['brandname'].value;
        const itmprice = document.forms['itemForm']['itmprice'].value;

        const genericnamePattern = /^[A-Za-z0-9\s\-\_\.\,]+$/; 
        const brandnamePattern = /^[A-Za-z\s]+$/; 
        const pricePattern = /^[0-9]+$/;
        
        if (genericname && !genericnamePattern.test(genericname)) {
            alert('Please enter a valid generic name (letters, numbers, or certain characters)');
            return false;
        }

        if (brandname && !brandnamePattern.test(brandname)) {
            alert('Please enter a valid brand name (letters only)');
            return false;
        }

        if (itmprice && (!pricePattern.test(itmprice) || itmprice < 0 || itmprice > 40000)) {
            alert('Please enter a valid price between 0 and 40,000');
            return false;
        }

        return true;
    }
</script>
</body>
</html>

<?php
//close connection to database
mysqli_close($conn);
?>