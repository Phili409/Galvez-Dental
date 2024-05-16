document.addEventListener('DOMContentLoaded', function () {
    // Add submit event listener to the signup form to validate data before submission
    const signupForm = document.getElementById('signupForm');
    signupForm.addEventListener('submit', function(event) {
        if (!validateData()) {
            event.preventDefault(); // Prevent form submission if validation fails
            alert('Please correct the errors before submitting.');
        }
    });
});

// Function to update the date and time displayed on the homepage
function updateDateTime() {
    const now = new Date();
    const options = { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric', 
        hour: '2-digit', 
        minute: '2-digit' 
    };
    document.getElementById("liveDateTime").textContent = now.toLocaleDateString("en-US", options);
}
// Update date and time every minute
setInterval(updateDateTime, 60000);

// Function to add an image of a coffee bean to the coffee beans container
function addCoffeeImage(image) {
    const img = document.createElement("img");
    img.src = image;
    img.alt = "Coffee Bean";
    img.classList.add("coffee-bean");
    document.getElementById("coffee-beans-container").appendChild(img);
}

// Function to update the coffee beans display based on user's coffee consumption level
function updateCoffeeBean() {
    const consumptionLevel = document.getElementById("coffee-consumption").value;
    const beanContainer = document.getElementById("coffee-beans-container");
    beanContainer.innerHTML = ""; // Clear previous coffee beans

    // Add coffee bean images based on consumption level
    if (consumptionLevel >= 0 && consumptionLevel <= 4) {
        addCoffeeImage("https://png.pngitem.com/pimgs/s/188-1880850_coffee-beans-outline-coffee-bean-outline-png-transparent.png");
    } else if (consumptionLevel >= 5 && consumptionLevel <= 8) {
        addCoffeeImage("https://png.pngitem.com/pimgs/s/188-1880850_coffee-beans-outline-coffee-bean-outline-png-transparent.png");
        addCoffeeImage("https://png.pngitem.com/pimgs/s/188-1880850_coffee-beans-outline-coffee-bean-outline-png-transparent.png");
    } else if (consumptionLevel >= 9 && consumptionLevel <= 10) {
        addCoffeeImage("https://png.pngitem.com/pimgs/s/188-1880850_coffee-beans-outline-coffee-bean-outline-png-transparent.png");
        addCoffeeImage("https://png.pngitem.com/pimgs/s/188-1880850_coffee-beans-outline-coffee-bean-outline-png-transparent.png");
        addCoffeeImage("https://png.pngitem.com/pimgs/s/188-1880850_coffee-beans-outline-coffee-bean-outline-png-transparent.png");
    }
}

// Function to check if a username already exists in the database
function check_for_existing_value(value, callback) {
    const url = `check_userID.php?userID=${encodeURIComponent(value)}`;
    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.value_exists) {
                console.log('Username already taken.');
                callback(true);
            } else {
                console.log('Username available.');
                callback(false);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            callback(false); // Assume false on error
        });
}

// Function to validate a single input element in the signup form
function validateInput(inputElement) {
    let valid = true; // Default to valid
    let errorMessage = '';
    const validity = inputElement.validity;
    const errorElementId = 'error-' + inputElement.id;
    const errorElement = document.getElementById(errorElementId);

    if (inputElement.id === 'password2') {
        const password1 = document.getElementById('password1').value;
        if (inputElement.value !== password1) {
            errorMessage = 'Passwords do not match.';
            valid = false;
        }
    }

    if (validity.valueMissing) {
        errorMessage = 'This field is required.';
        valid = false;
    } else if (validity.patternMismatch) {
        errorMessage = 'Please enter a valid value.';
        valid = false;
    } else if (validity.tooShort) {
        errorMessage = 'The value is too short.';
        valid = false;
    } else if (validity.tooLong) {
        errorMessage = 'The value is too long.';
        valid = false;
    } else if (validity.typeMismatch) {
        errorMessage = 'Please enter a value that matches the required format.';
        valid = false;
    }

    inputElement.setCustomValidity(errorMessage);
    if (errorElement) {
        errorElement.textContent = errorMessage;
    }
    return valid;
}

// Function to validate all required inputs in the signup form
function validateData() {
    let isValid = true; // Default to true
    const inputs = document.querySelectorAll('#signupForm input[required]');
    inputs.forEach(input => {
        if (!validateInput(input)) {
            isValid = false;
        } else {
            document.getElementById(`error-${input.id}`).textContent = '';
        }
    });
    return isValid;
}

// Function to navigate to the homepage
function HomePage() {
    window.location.href = 'HomePage.html';
}

// Function to generate a random user ID
function generateID() {
    return 'user_' + Math.random().toString(36).substring(2, 9);
}

// Function to create a new user cookie
function newUserCookie() {
    bakeCookie("ClientID", generateID(), 365);
    document.getElementById('cookieConsent').style.display = 'none';
}

// Function to create a cookie with a given name, value, and expiration days
function bakeCookie(name, value, days) {
    const d = new Date();
    d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
    const expires = "expires=" + d.toUTCString();
    document.cookie = name + "=" + value + ";" + expires + ";path=/";
}

// Function to update an existing cookie
function updateCookie(cname, cvalue, days) {
    bakeCookie(cname, cvalue, days);
}

// Function to delete an existing cookie
function eatCookie(cname) {
    const mold_date = "expires=Thu, 01 Jan 1970 00:00:00 UTC;";
    document.cookie = cname + "=;" + mold_date + "path=/;";
}

// Function to get the value of a cookie by name
function getCookie(cname) {
    const name = cname + "=";
    const Cookies = decodeURIComponent(document.cookie);
    const cookieCrumbs = Cookies.split(";");

    for (let i = 0; i < cookieCrumbs.length; i++) {
        let current_cookie = cookieCrumbs[i];
        while (current_cookie.charAt(0) === ' ') current_cookie = current_cookie.substring(1);

        if (current_cookie.indexOf(name) === 0) {
            return current_cookie.substring(name.length, current_cookie.length);
        }
    }
    return "";
}

// Function to check if a cookie exists by name
function checkCookieJar(cname) {
    const cookie_value = getCookie(cname);
    return cookie_value !== "";
}

// Function to display a welcome message on the homepage based on cookie presence
function homepageUserWelcome() {
    const returningUser = checkCookieJar("ClientID");
    const ClientName = getCookie("ClientName");

    if (returningUser) {
        document.getElementById('cookieConsent').style.display = 'none';
        document.getElementById('container-text').textContent = "Welcome Back " + ClientName + "! Login And Continue!";
    } else {
        document.getElementById('container-text').textContent = '\nWelcome to Galvez Dental!\nSign Up And Join Us Today!';
        document.getElementById('cookieConsent').style.display = 'block';
    }
}

// Function to check for existing signup form data and prompt user to continue or restart the form
function checkSignUp() {
    const fields = ['first-name', 'middle-initial', 'last-name', 'DOB', 'address1', 'address2', 'city', 'state', 'zip', 'email', 'phone', 'age-group', 'medical-background', 'insured', 'coffee-consumption', 'userID'];
    let userData = {};

    // Retrieve saved form data from cookies
    for (let field of fields) {
        if ((checkCookieJar(field) !== "") && (getCookie(field) !== "")) {
            let value = getCookie(field);
            userData[field] = value;
        }
    }

    // If there is saved data, prompt user to continue or restart the form
    if (Object.values(userData).length > 0) {
        let reSubmission = window.confirm("Do you wish to restart the form?");

        if (reSubmission) {
            for (const name in userData) {
                eatCookie(name);
            }
        } else {
            for (const name in userData) {
                if (name === "age-group") {
                    const value = userData[name];
                    const selectedElement = document.getElementById(value);
                    if (selectedElement) selectedElement.checked = true;
                } else if (name === "insured") {
                    const selectedElement = document.getElementById(name);
                    if (selectedElement) selectedElement.checked = !selectedElement.checked;
                } else {
                    const selectedElement = document.getElementById(name);
                    if (selectedElement) selectedElement.value = userData[name];
                }
            }
        }
    }
}

// Function to handle user login (to be implemented)
function login() {
    // Implement login
}
