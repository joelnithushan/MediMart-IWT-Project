function additem() {
    alert("item added successfully");
    return true;
}

function modifyitem() {
    alert("item Modified successfully");
    return true;
}

function validateForm() {
    
    let genericName = document.forms["itemForm"]["genericname"].value;
    let genericNamePattern = /^[a-zA-Z0-9\s\.\,\-]+$/;

    if (!genericName || !genericNamePattern.test(genericName)) {
        alert("Generic Name is required and can only contain letters, numbers, spaces, and ., - characters.");
        return false;
    }

    let brandName = document.forms["itemForm"]["brandname"].value;
    let brandNamePattern = /^[a-zA-Z0-9\s\.\,\-]+$/;
    if (!brandName || !brandNamePattern.test(brandName)) {
        alert("Brand Name is required and can only contain letters, numbers, spaces, and ., - characters.");
        return false;
    }

    let code = document.forms["itemForm"]["code"].value;
    let codePattern = /^[a-zA-Z0-9]+$/;
    if (!code || !codePattern.test(code)) {
        alert("Code is required and can only contain letters and numbers.");
        return false;
    }

    let price = document.forms["itemForm"]["itmprice"].value;
    if (!price || isNaN(price) || price < 0 || price > 40000) {
        alert("Price must be a valid number between 0 and 40,000.");
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

//validation for my page(joel)
