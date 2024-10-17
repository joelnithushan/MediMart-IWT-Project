//Full validation for registration page

document.addEventListener('DOMContentLoaded', function () {
    const form = document.forms['RegForm'];

    form.addEventListener('submit', function (event) {
        const name = form['Name'].value;
        const email = form['email'].value;
        const mobileNo = form['MobileNo'].value;
        const address = form['address'].value;
        const city = form['city'].value;
        const psw = form['psw'].value;
        const pswRepeat = form['psw-repeat'].value;

        let errors = [];

        
        const namePattern = /^[a-zA-Z\s]+$/;
        if (!namePattern.test(name)) {
            errors.push('Full Name should only contain letters and spaces.');
        }

        
        const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        if (!emailPattern.test(email)) {
            errors.push('Please enter a valid email (e.g., example@domain.com).');
        }

        //phone number validation
        const mobilePattern = /^0\d{9}$/;
        if (!mobilePattern.test(mobileNo)) {
            errors.push('Mobile number must be 10 digits and start with 0.');
        }

    
        const cityPattern = /^[a-zA-Z\s]+$/;
        if (city && !cityPattern.test(city)) {
            errors.push('City should only contain letters and spaces.');
        }

        
        if (psw.length < 8) {
            errors.push('Password must be at least 8 characters long.');
        }

        
        if (psw !== pswRepeat) {
            errors.push('Passwords do not match.');
        }

        if (errors.length > 0) {
            event.preventDefault();
            alert('Error(s):\n' + errors.join('\n'));
        }
    });
});
