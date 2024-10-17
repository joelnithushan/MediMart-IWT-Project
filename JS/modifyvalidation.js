//validation for items
function validateForm() {

    let genericName = document.forms["itemForm"]["genericname"].value;
    if (!genericName || !/^[a-zA-Z0-9\s\.\,\-]+$/.test(genericName)) {
        alert("Generic Name is required and can only contain letters, numbers, spaces, and ., - characters.");
        return false;
    }

    
    let brandName = document.forms["itemForm"]["brandname"].value;
    if (!brandName || !/^[a-zA-Z0-9\s\.\,\-]+$/.test(brandName)) {
        alert("Brand Name is required and can only contain letters, numbers, spaces, and ., - characters.");
        return false;
    }


    let itemPrice = document.forms["itemForm"]["itmprice"].value;
    if (!itemPrice || isNaN(itemPrice) || itemPrice < 0 || itemPrice > 40000) {
        alert("Please enter a valid price between 0 and 40,000.");
        return false;
    }


    let itemType = document.forms["itemForm"]["type"].value;
    if (!itemType) {
        alert("Please select a type for the item.");
        return false;
    }


    let fileInput = document.forms["itemForm"]["itemImgUpload"];
    let filePath = fileInput.value;
    let allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
    if (!fileInput.files.length || !allowedExtensions.exec(filePath)) {
        alert("Please upload a valid JPG or PNG image file.");
        return false;
    }

    return true;
}
