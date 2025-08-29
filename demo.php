<!DOCTYPE html>
<html>
<head>
    <title>Student Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        
        table {
            border-collapse: collapse;
            width: 100%;
        }
        
        td {
            padding: 8px;
            vertical-align: top;
        }
        
        input, select, textarea {
            padding: 5px;
        }
        
        .error {
            color: red;
            font-size: 12px;
        }
        
        .result-table {
            border: 1px solid black;
            margin-top: 20px;
        }
        
        .result-table td, .result-table th {
            border: 1px solid black;
            padding: 10px;
        }
    </style>
</head>
<body>

<?php
// Check if form is submitted
if (isset($_POST["submit"])) {
    
    // Get all form data
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $day = $_POST["day"];
    $month = $_POST["month"];
    $year = $_POST["year"];
    $email = $_POST["email"];
    $mobile = $_POST["mobile"];
    $gender = $_POST["gender"];
    $address = $_POST["address"];
    $city = $_POST["city"];
    $pin = $_POST["pin"];
    $state = $_POST["state"];
    $country = $_POST["country"];
    $hobbies = $_POST["hobbies"];
    $other_hobby = $_POST["other_hobby"];
    $course = $_POST["course"];
    
    // Check for errors
    $errors = array();
    
    // Check first name
    if (empty($fname)) {
        $errors['fname'] = "First name is required";
    }
    
    // Check last name
    if (empty($lname)) {
        $errors['lname'] = "Last name is required";
    }
    
    // Check date of birth
    if (empty($day) || empty($month) || empty($year)) {
        $errors['dob'] = "Please enter complete date of birth";
    }
    
    // Check email
    if (empty($email)) {
        $errors['email'] = "Email is required";
    }
    
    // Check mobile
    if (empty($mobile)) {
        $errors['mobile'] = "Mobile number is required";
    } elseif (strlen($mobile) != 10) {
        $errors['mobile'] = "Mobile number must be 10 digits";
    }
    
    // Check gender
    if (empty($gender)) {
        $errors['gender'] = "Please select gender";
    }
    
    // Check address
    if (empty($address)) {
        $errors['address'] = "Address is required";
    }
    
    // Check city
    if (empty($city)) {
        $errors['city'] = "City is required";
    }
    
    // Check pin code
    if (empty($pin)) {
        $errors['pin'] = "PIN code is required";
    }
    
    // Check state
    if (empty($state)) {
        $errors['state'] = "State is required";
    }
    
    // Check country
    if (empty($country)) {
        $errors['country'] = "Country is required";
    }
    
    // Check hobbies
    if (empty($hobbies)) {
        $errors['hobbies'] = "Please select at least one hobby";
    } elseif (in_array("Others", $hobbies) && empty($other_hobby)) {
        $errors['hobbies'] = "Please write your other hobby";
    }
    
    // Check course
    if (empty($course)) {
        $errors['course'] = "Please select a course";
    }
    
    // If no errors, show the result table
    if (empty($errors)) {
        echo "<h2>Registration Successful!</h2>";
        echo "<table class='result-table'>";
        echo "<tr><th>Field</th><th>Value</th></tr>";
        
        $full_name = $fname . " " . $lname;
        echo "<tr><td>Name</td><td>$full_name</td></tr>";
        
        $full_dob = $day . "/" . $month . "/" . $year;
        echo "<tr><td>Date of Birth</td><td>$full_dob</td></tr>";
        
        echo "<tr><td>Email</td><td>$email</td></tr>";
        echo "<tr><td>Mobile</td><td>$mobile</td></tr>";
        echo "<tr><td>Gender</td><td>$gender</td></tr>";
        
        $full_address = $address . ", " . $city . ", " . $pin . ", " . $state . ", " . $country;
        echo "<tr><td>Address</td><td>$full_address</td></tr>";
        
        if (in_array("Others", $hobbies)) {
            echo "<tr><td>Hobbies</td><td>$other_hobby</td></tr>";
        } else {
            $hobby_list = implode(", ", $hobbies);
            echo "<tr><td>Hobbies</td><td>$hobby_list</td></tr>";
        }
        
        echo "<tr><td>Course</td><td>$course</td></tr>";
        echo "</table>";
        
        exit; // Stop here and don't show the form again
    }
}
?>

<h1>Student Registration Form</h1>

<form method="post">
    <table>
        <tr>
            <td>First Name:</td>
            <td>
                <input type="text" name="fname" value="<?php echo $fname ?? ''; ?>">
                <?php if (isset($errors['fname'])) echo "<br><span class='error'>" . $errors['fname'] . "</span>"; ?>
            </td>
        </tr>
        
        <tr>
            <td>Last Name:</td>
            <td>
                <input type="text" name="lname" value="<?php echo $lname ?? ''; ?>">
                <?php if (isset($errors['lname'])) echo "<br><span class='error'>" . $errors['lname'] . "</span>"; ?>
            </td>
        </tr>
        
        <tr>
            <td>Date of Birth:</td>
            <td>
                <input type="number" name="day" placeholder="Day" min="1" max="31" value="<?php echo $day ?? ''; ?>">
                <select name="month">
                    <option value="">Month</option>
                    <option value="Jan" <?php if (($month ?? '') == 'Jan') echo 'selected'; ?>>Jan</option>
                    <option value="Feb" <?php if (($month ?? '') == 'Feb') echo 'selected'; ?>>Feb</option>
                    <option value="Mar" <?php if (($month ?? '') == 'Mar') echo 'selected'; ?>>Mar</option>
                    <option value="Apr" <?php if (($month ?? '') == 'Apr') echo 'selected'; ?>>Apr</option>
                    <option value="May" <?php if (($month ?? '') == 'May') echo 'selected'; ?>>May</option>
                    <option value="Jun" <?php if (($month ?? '') == 'Jun') echo 'selected'; ?>>Jun</option>
                    <option value="Jul" <?php if (($month ?? '') == 'Jul') echo 'selected'; ?>>Jul</option>
                    <option value="Aug" <?php if (($month ?? '') == 'Aug') echo 'selected'; ?>>Aug</option>
                    <option value="Sep" <?php if (($month ?? '') == 'Sep') echo 'selected'; ?>>Sep</option>
                    <option value="Oct" <?php if (($month ?? '') == 'Oct') echo 'selected'; ?>>Oct</option>
                    <option value="Nov" <?php if (($month ?? '') == 'Nov') echo 'selected'; ?>>Nov</option>
                    <option value="Dec" <?php if (($month ?? '') == 'Dec') echo 'selected'; ?>>Dec</option>
                </select>
                <input type="number" name="year" placeholder="Year" value="<?php echo $year ?? ''; ?>">
                <?php if (isset($errors['dob'])) echo "<br><span class='error'>" . $errors['dob'] . "</span>"; ?>
            </td>
        </tr>
        
        <tr>
            <td>Email:</td>
            <td>
                <input type="email" name="email" value="<?php echo $email ?? ''; ?>">
                <?php if (isset($errors['email'])) echo "<br><span class='error'>" . $errors['email'] . "</span>"; ?>
            </td>
        </tr>
        
        <tr>
            <td>Mobile Number:</td>
            <td>
                <input type="text" name="mobile" value="<?php echo $mobile ?? ''; ?>">
                <?php if (isset($errors['mobile'])) echo "<br><span class='error'>" . $errors['mobile'] . "</span>"; ?>
            </td>
        </tr>
        
        <tr>
            <td>Gender:</td>
            <td>
                <input type="radio" name="gender" value="Male" <?php if (($gender ?? '') == 'Male') echo 'checked'; ?>> Male
                <input type="radio" name="gender" value="Female" <?php if (($gender ?? '') == 'Female') echo 'checked'; ?>> Female
                <?php if (isset($errors['gender'])) echo "<br><span class='error'>" . $errors['gender'] . "</span>"; ?>
            </td>
        </tr>
        
        <tr>
            <td>Address:</td>
            <td>
                <textarea name="address" rows="3" cols="30"><?php echo $address ?? ''; ?></textarea>
                <?php if (isset($errors['address'])) echo "<br><span class='error'>" . $errors['address'] . "</span>"; ?>
            </td>
        </tr>
        
        <tr>
            <td>City:</td>
            <td>
                <input type="text" name="city" value="<?php echo $city ?? ''; ?>">
                <?php if (isset($errors['city'])) echo "<br><span class='error'>" . $errors['city'] . "</span>"; ?>
            </td>
        </tr>
        
        <tr>
            <td>PIN Code:</td>
            <td>
                <input type="text" name="pin" value="<?php echo $pin ?? ''; ?>">
                <?php if (isset($errors['pin'])) echo "<br><span class='error'>" . $errors['pin'] . "</span>"; ?>
            </td>
        </tr>
        
        <tr>
            <td>State:</td>
            <td>
                <input type="text" name="state" value="<?php echo $state ?? ''; ?>">
                <?php if (isset($errors['state'])) echo "<br><span class='error'>" . $errors['state'] . "</span>"; ?>
            </td>
        </tr>
        
        <tr>
            <td>Country:</td>
            <td>
                <input type="text" name="country" value="<?php echo $country ?? ''; ?>">
                <?php if (isset($errors['country'])) echo "<br><span class='error'>" . $errors['country'] . "</span>"; ?>
            </td>
        </tr>
        
        <tr>
            <td>Hobbies:</td>
            <td>
                <input type="checkbox" name="hobbies[]" value="Reading" <?php if (in_array('Reading', $hobbies ?? [])) echo 'checked'; ?>> Reading<br>
                <input type="checkbox" name="hobbies[]" value="Writing" <?php if (in_array('Writing', $hobbies ?? [])) echo 'checked'; ?>> Writing<br>
                <input type="checkbox" name="hobbies[]" value="Sports" <?php if (in_array('Sports', $hobbies ?? [])) echo 'checked'; ?>> Sports<br>
                <input type="checkbox" name="hobbies[]" value="Music" <?php if (in_array('Music', $hobbies ?? [])) echo 'checked'; ?>> Music<br>
                <input type="checkbox" name="hobbies[]" value="Others" <?php if (in_array('Others', $hobbies ?? [])) echo 'checked'; ?>> Others
                <input type="text" name="other_hobby" placeholder="Write other hobby" value="<?php echo $other_hobby ?? ''; ?>">
                <?php if (isset($errors['hobbies'])) echo "<br><span class='error'>" . $errors['hobbies'] . "</span>"; ?>
            </td>
        </tr>
        
        <tr>
            <td>Course:</td>
            <td>
                <input type="radio" name="course" value="BCA" <?php if (($course ?? '') == 'BCA') echo 'checked'; ?>> BCA<br>
                <input type="radio" name="course" value="B.Com" <?php if (($course ?? '') == 'B.Com') echo 'checked'; ?>> B.Com<br>
                <input type="radio" name="course" value="B.Sc" <?php if (($course ?? '') == 'B.Sc') echo 'checked'; ?>> B.Sc<br>
                <input type="radio" name="course" value="B.A" <?php if (($course ?? '') == 'B.A') echo 'checked'; ?>> B.A<br>
                <?php if (isset($errors['course'])) echo "<br><span class='error'>" . $errors['course'] . "</span>"; ?>
            </td>
        </tr>
        
        <tr>
            <td></td>
            <td>
                <input type="submit" name="submit" value="Submit">
                <input type="reset" value="Reset">
            </td>
        </tr>
    </table>
</form>

</body>
</html>