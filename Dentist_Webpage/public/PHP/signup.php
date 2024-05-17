<?php
// Start a session to store form date
session_start();



// Server connection
$servername = "localhost";
$username = "";
$password = "";
$dbname = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
$isFormSubmitted = $_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST);
$successMessage = '';

if ($isFormSubmitted) {
    // Retrive values from client end
    $firstName = $_POST['first-name'] ?? null;
    $middleInitial = $_POST['middle-initial'] ?? null;
    $lastName = $_POST['last-name'] ?? null;
    $DOB = $_POST['DOB'] ?? null;  
    $SSN = $_POST['SSN'] ?? null;
    $address1 = $_POST['address1'] ?? null;
    $address2 = $_POST['address2'] ?? null;
    $city = $_POST['city'] ?? null;
    $state = $_POST['state'] ?? null;
    $zipCode = $_POST['zip'] ?? null;
    $email = $_POST['email'] ?? null;
    $phone = $_POST['phone'] ?? null;
    $medicalBackground = $_POST['medical-background'] ?? null;
    $ageGroup = $_POST['age-group'] ?? null;
    $coffeeIntake = $_POST['coffee-consumption'] ?? null; 
    $insured = isset($_POST['insured']) ? 1 : 0; 
    $userID = $_POST['userID'] ?? null;
    $password = $_POST['password1'] ?? null;

    // Ensure datetime 
    if($DOB)
    {
        $date = new DateTime($DOB);
        $DOB  = $date->format('Y-m-d'); 
    }
    // Hash sensitive values 
    $SSNHashed = password_hash($_POST['SSN'], PASSWORD_DEFAULT); // Hash SSN
    $passwordHashed = password_hash($_POST['password1'], PASSWORD_DEFAULT); // Hash password

    // Prepare SQL script 
    $sql = "INSERT INTO GaboTable (firstName, middleInitial, lastName, DOB, SSNHashed, address1, address2, city, state, zipCode, email, phone, ageGroup, medicalBackground, insured, coffeeIntake, userID, passwordHashed)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if(!$stmt)
    {
        die('MySQL prepare error: ' . $conn->error);
    }

    // Bind parameters
    $bind = $stmt->bind_param("ssssssssssssssiiss", $firstName, $middleInitial, $lastName, $DOB, $SSNHashed, $address1, $address2, $city, $state, $zipCode, $email, $phone, $ageGroup, $medicalBackground, $insured, $coffeeIntake, $userID, $passwordHashed);


    // Check for valid binding
    if(false === $bind)
    {
        die('MySQL bind error: ' . $stm->error);
    }

    // execute 
    if ($stmt->execute()) {
        echo "New record created successfully";
        header("Location: /HomePage.html");
        sleep(1);
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connections
    $stmt->close();
    $conn->close();
}

if (!$isFormSubmitted || !empty($successMessage)) {
    if (!empty($successMessage)) {
        echo "<p>$successMessage</p>";
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sign Up Page</title>
        <link rel="stylesheet" href="updated_signup.css">
        <script src="GalvezDental.js" defer></script>
    </head>
    <body>
        <header class="title">New User Sign Up</header>
        <div class="form-container">
            <form id="signupForm" method="post" action="" onsubmit="return validateData();">
                <div>
                    <label for="first-name">First Name:</label>
                    <input type="text" id="first-name" name="first-name" maxlength="30" pattern="[A-Za-z ']+"
                        placeholder="First Name" required>
                    <span class="error-message" id="error-first-name"></span>
                </div>
                <div>
                    <label for="middle-initial">Middle Initial:</label>
                    <input type="text" id="middle-initial" name="middle-initial" maxlength="1" pattern="[A-Z]"
                        placeholder="MI">
                    <span class="error-message" id="error-middle-initial"></span>
                </div>
                <div>
                    <label for="last-name">Last Name:</label>
                    <input type="text" id="last-name" name="last-name" maxlength="30" pattern="[A-Za-z ']+"
                        placeholder="Last Name" required>
                    <span class="error-message" id="error-last-name"></span>
                </div>
                <div>
                    <label for="DOB">Date of Birth:</label>
                    <input type="date" id="DOB" name="DOB" required>
                    <span class="error-message" id="error-DOB"></span>
                </div>
                <div>
                    <label for="SSN">Social Security Number:</label>
                    <input type="password" id="SSN" name="SSN" maxlength="9" pattern="\d{9}"
                        placeholder="SSN" required>
                    <span class="error-message" id="error-SSN"></span>
                </div>
                <div>
                    <label for="address1">Address 1:</label>
                    <input type="text" id="address1" name="address1" maxlength="30" required>
                    <span class="error-message" id="error-address1"></span>
                </div>
                <div>
                    <label for="address2">Address 2:</label>
                    <input type="text" id="address2" name="address2" maxlength="30">
                </div>
                <div>
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" maxlength="30" required>
                    <span class="error-message" id="error-city"></span>
                </div>
                <div>
                    <label for="state">State:</label>
                    <select id="state" name="state" required>
                        <option value=""></option>
                        <option value="AL">Alabama</option>
                        <option value="AK">Alaska</option>
                        <option value="AZ">Arizona</option>
                        <option value="AR">Arkansas</option>
                        <option value="CA">California</option>
                        <option value="CO">Colorado</option>
                        <option value="CT">Connecticut</option>
                        <option value="DE">Delaware</option>
                        <option value="DC">District Of Columbia</option>
                        <option value="FL">Florida</option>
                        <option value="GA">Georgia</option>
                        <option value="HI">Hawaii</option>
                        <option value="ID">Idaho</option>
                        <option value="IL">Illinois</option>
                        <option value="IN">Indiana</option>
                        <option value="IA">Iowa</option>
                        <option value="KS">Kansas</option>
                        <option value="KY">Kentucky</option>
                        <option value="LA">Louisiana</option>
                        <option value="ME">Maine</option>
                        <option value="MD">Maryland</option>
                        <option value="MA">Massachusetts</option>
                        <option value="MI">Michigan</option>
                        <option value="MN">Minnesota</option>
                        <option value="MS">Mississippi</option>
                        <option value="MO">Missouri</option>
                        <option value="MT">Montana</option>
                        <option value="NE">Nebraska</option>
                        <option value="NV">Nevada</option>
                        <option value="NH">New Hampshire</option>
                        <option value="NJ">New Jersey</option>
                        <option value="NM">New Mexico</option>
                        <option value="NY">New York</option>
                        <option value="NC">North Carolina</option>
                        <option value="ND">North Dakota</option>
                        <option value="OH">Ohio</option>
                        <option value="OK">Oklahoma</option>
                        <option value="OR">Oregon</option>
                        <option value="PA">Pennsylvania</option>
                        <option value="RI">Rhode Island</option>
                        <option value="SC">South Carolina</option>
                        <option value="SD">South Dakota</option>
                        <option value="TN">Tennessee</option>
                        <option value="TX">Texas</option>
                        <option value="UT">Utah</option>
                        <option value="VT">Vermont</option>
                        <option value="VA">Virginia</option>
                        <option value="WA">Washington</option>
                        <option value="WV">West Virginia</option>
                        <option value="WI">Wisconsin</option>
                        <option value="WY">Wyoming</option>
                    </select>
                    <span class="error-message" id="error-state"></span>
                </div>
                <div>
                    <label for="zip">Zip Code:</label>
                    <input type="text" id="zip" name="zip" pattern="\d{5}" maxlength="5" required>
                    <span class="error-message" id="error-zip"></span>
                </div>
                <div>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                    <span class="error-message" id="error-email"></span>
                </div>
                <div>
                    <label for="phone">Phone Number:</label>
                    <input type="text" id="phone" name="phone" pattern="\d{10}" maxlength="10" required>
                    <span class="error-message" id="error-phone"></span>
                </div>
                <div>
                    <label for="medical-background">Medical Background:</label>
                    <textarea id="medical-background" name="medical-background" rows="5" cols="50" maxlength="500"></textarea>
                </div>
                <div>
                    <label>Age Group:</label>
                    <input type="radio" id="Infant" name="age-group" value="Infant">
                    <label for="infant">Infant</label>
                    <input type="radio" id="Adult" name="age-group" value="Adult">
                    <label for="adult">Adult</label>
                    <input type="radio" id="Elder" name="age-group" value="Elder">
                    <label for="elder">Elder</label>
                </div>
                <div>
                    <label for="coffee-consumption">Coffee Consumption Level:</label>
                    <input type="range" id="coffee-consumption" name="coffee-consumption" min="0" max="10" oninput="updateCoffeeBean();">
                    <div class="coffee-beans-container" id="coffee-beans-container"></div>
                </div>
                <div>
                    <label for="insured">Insured?</label>
                    <input type="checkbox" id="insured" name="insured">
                </div>
                <div>
                    <label for="userID">Username:</label>
                    <input type="text" id="userID" name="userID" maxlength="20" required>
                    <span class="error-message" id="error-userID"></span>
                </div>
                <div>
                    <label for="password1">Password:</label>
                    <input type="password" id="password1" name="password1" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                        minlength="8" maxlength="20" required>
                    <span class="error-message" id="error-password1"></span>
                </div>
                <div>
                    <label for="password2">Confirm Password:</label>
                    <input type="password" id="password2" name="password2" minlength="8" maxlength="20" required>
                    <span class="error-message" id="error-password2"></span>
                </div>
                <div class="button-container">
                    <button type="submit">Submit</button>
                    <button type="reset">Clear</button>
                </div>
            </form>
        </div>
        <footer>
            <div class="footer-info">
                <div>Galvez Dental</div>
                <div>Houston, TX | 77004</div>
                <img src="https://png.pngtree.com/png-vector/20220622/ourmid/pngtree-smile-dental-logo-template-vector-illustration-icon-design-png-image_5273471.png" alt="Footer Image">
            </div>
    </footer>
    </body>
    </html>
    <?php
}
?>
