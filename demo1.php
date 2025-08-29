<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="form.css">

    <title>Home</title>


</head>

<body>

    <?php
    $errors = [];
    $hasErrors = false;

    if (isset($_POST["submit"])) {

        $gp = !isset($_POST["gender"]);

        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $mail = $_POST["email"];
        $day = $_POST["day"];
        $month = $_POST["month"];
        $year = $_POST["year"];
        $mobile = $_POST["number"];
        if (!empty($_POST["gender"])) {
            $gender = $_POST["gender"];
        }
        $address = $_POST["address"];
        $city = $_POST["city"];
        $pincode = $_POST["pin"];
        $state = $_POST["STATE"];
        $country = $_POST["country"];
        $Xboard = $_POST["Xboard"];
        $Xpercentage = $_POST["Xpercentage"];
        $Xpass = $_POST["Xpass"];
        $XIIboard = $_POST["XIIboard"];
        $XIIpercentage = $_POST["XIIpercentage"];
        $XIIpass = $_POST["XIIpass"];
        $Gboard = $_POST["Gboard"];
        $Gpercentage = $_POST["Gpercentage"];
        $Gpass = $_POST["Gpass"];
        $Mboard = $_POST["Mboard"];
        $Mpercentage = $_POST["Mpercentage"];
        $Mpass = $_POST["Mpass"];

        $fp = preg_match('/^[a-zA-Z]{1,30}$/', $fname);
        $lp = preg_match('/^[a-zA-Z]{1,30}$/', $lname);
        $dp = empty($_POST["day"]) || empty($_POST["month"]) || empty($_POST["year"]);
        $map = preg_match('/^[\w\.-]+@[\w\.-]+\.\w\D+$/', $mail);
        $mp = preg_match('/^\d{10}$/', $mobile);

        $error['fname'] = "Invalid first name";
        $error['lname'] = "Invalid last name";
        $error['dob'] = "Enter proper date of birth";
        $error['email1'] = "Enter mail";
        $error['email2'] = "Enter proper mail";
        $error['mobile'] = "Enter 10 digit mobile number only";
        $error['gender'] = "Select a gender";
        $error['address'] = 'Enter address properly';
        $error['hobby1'] = "<tr><td></td><td>Select a Hobbie</td></tr>";
        $error['hobby2'] = "<tr><td></td><td><tr><td>Hobbie</td><td>If selected Other in hobbies, write in the input box</td></tr></td></tr>";
        $error['qerror'] = "<span>Enter this field properly<span></span>";
        $error['course'] = "<tr><td><td>Select a course</td></td></tr>";

        if (!$fp) $hasErrors = true;
        if (!$lp) $hasErrors = true;
        if ($dp) $hasErrors = true;
        if (empty($mail)) $hasErrors = true;
        if (!empty($mail) && !$map) $hasErrors = true;
        if (!$mp) $hasErrors = true;
        if ($gp) $hasErrors = true;
        if (empty($_POST["address"])) $hasErrors = true;
        if (empty($_POST["city"])) $hasErrors = true;
        if (empty($_POST["pin"])) $hasErrors = true;
        if (empty($_POST["STATE"])) $hasErrors = true;
        if (empty($_POST["country"])) $hasErrors = true;
        if (empty($_POST["HOBBIES"])) $hasErrors = true;
        if (!empty($_POST["HOBBIES"]) && in_array("Others", $_POST["HOBBIES"]) && empty($_POST["Hobbie"])) $hasErrors = true;
        if (empty($_POST["Xboard"])) $hasErrors = true;
        if (empty($_POST["Xpercentage"])) $hasErrors = true;
        if (empty($_POST["Xpass"])) $hasErrors = true;
        if (empty($_POST["XIIboard"])) $hasErrors = true;
        if (empty($_POST["XIIpercentage"])) $hasErrors = true;
        if (empty($_POST["XIIpass"])) $hasErrors = true;
        if (empty($_POST["Gboard"])) $hasErrors = true;
        if (empty($_POST["Gpercentage"])) $hasErrors = true;
        if (empty($_POST["Gpass"])) $hasErrors = true;
        if (empty($_POST["Mboard"])) $hasErrors = true;
        if (empty($_POST["Mpercentage"])) $hasErrors = true;
        if (empty($_POST["Mpass"])) $hasErrors = true;
        if (empty($_POST["COURSES"])) $hasErrors = true;

        if (!$hasErrors) {
            echo "<table id='phptable' border='1' cellpadding='10' cellspacing='0'>";
            echo "<tr><th>Field</th><th>Value</th></tr>";

            $name = $fname . " " . $lname;
            echo "<tr> <td>Name</td><td>$name</td></tr>";
            $dob = $day . " " . $month . " " . $year;
            echo "<tr><td>Date of Birth</td><td>$dob</td></tr>";
            echo "<tr><td>Email</td><td>$mail</td></tr>";
            echo "<tr><td>Mobile</td><td>$mobile</td></tr>";

            if (!empty($_POST["gender"])) {
                echo "<tr><td>Gender</td><td>$gender</td></tr>";
            }

            $Faddress =  $address . " , " . $city . " , " . "$pincode" . " , " . "$state" . " , " . "$country" . "<br>";
            echo "<tr><td>Address</td><td>$Faddress</td></tr>";

            if (!empty($_POST["HOBBIES"])) {
                if (in_array("Others", $_POST["HOBBIES"])) {
                    if (!empty($_POST["Hobbie"])) {
                        $hobbies = $_POST["Hobbie"];
                        echo "<tr><td>Hobbie</td><td>$hobbies</td></tr>";
                    }
                } else {
                    $hobby = implode(" , ", $_POST["HOBBIES"]);
                    echo "<tr><td>Hobbies</td><td>$hobby</td></tr>";
                }
            }

            $X = "Board: " . $Xboard . ", Percentage: " . $Xpercentage . " , Passing year: " . $Xpass;
            $XII = "Board: " . $XIIboard . ", Percentage: " . $XIIpercentage . " , Passing year: " . $XIIpass;
            $G = "Board: " . $Gboard . ", Percentage: " . $Gpercentage . " , Passing year: " . $Gpass;
            $M = "Board: " . $Mboard . ", Percentage: " . $Mpercentage . " , Passing year: " . $Mpass;

            echo "<tr><td>Class X Qualification </td><td>$X</td></tr>";
            echo "<tr><td>Class XII Qualification </td><td>$XII</td></tr>";
            echo "<tr><td>Graduation Qualification </td><td>$G</td></tr>";
            echo "<tr><td>Masters Qualification </td><td>$M</td></tr>";

            if (!empty($_POST["COURSES"])) {
                $course = $_POST["COURSES"];
                echo "<tr><td>Course</td><td>$course</td></tr>";
            }

            echo "</table>";
        }
    }
    ?>

    <div id="bg">
        <center>
            <br>


            <b><u>
                    <h1>STUDENT REGISTRATION FORM</h1>
                </u> </b>
            <div>
                <form method="post">
                    <table id="table">
                        <tr>
                            <td>FIRST NAME:</td>
                            <td>
                                <input type="text" name="fname" size="30"
                                    maxlength="30" placeholder="Enter first name" />
                                (max 30 characters A-Z and a-z)
                                <?php
                                if (isset($_POST["submit"]) && !$fp) echo "<tr><td></td><td>{$error['fname']}</td></tr>";
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>LAST NAME:
                            </td>
                            <td><input type="text" name="lname" size="30"
                                    maxlength="30" placeholder="Enter last name" />
                                (max 30 characters A-Z and a-z)
                                <?php
                                if (isset($_POST["submit"]) && !$lp) echo "<tr><td></td><td>{$error['lname']}</td></tr>";
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>

                                DATE OF BIRTH:
                            </td>
                            <td>
                                <input type="number" name="day" size="2"
                                    maxlength="2" placeholder="Day" min="1" max="31" />
                                <select name="month">
                                    <option value="">Month</option>
                                    <option value="Jan">Jan</option>
                                    <option value="Feb">Feb</option>
                                    <option value="Mar">Mar</option>
                                    <option value="Apr">Apr</option>
                                    <option value="May">May</option>
                                    <option value="June">June</option>
                                    <option value="July">July</option>
                                    <option value="Aug">Aug</option>
                                    <option value="Sep">Sep</option>
                                    <option value="Oct">Oct</option>
                                    <option value="Nov">Nov</option>
                                    <option value="Dec">Dec</option>

                                </select>
                                <input type="text" name="year" size="5"
                                    maxlength="4" placeholder="Year" min="1991" max="2005" />
                                <?php if (isset($_POST["submit"]) && $dp) echo "<tr><td></td><td>{$error['dob']}</td></tr>"; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>EMAIL ID:
                            </td>
                            <td><input id="email" type="text" name="email" placeholder="Enter mail" size="30" maxlength="100" />
                                <?php if (isset($_POST["submit"]) && empty($mail)) echo "<tr><td></td><td>{$error['email1']}</td></tr>";
                                if (isset($_POST["submit"]) && !empty($mail) && !$map) echo "<tr><td></td><td>{$error['email2']}</td></tr>"; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                MOBILE NO:

                            </td>
                            <td><input type="number" name="number" placeholder="Enter Mobile no" />
                                (10 digits number)
                                <?php if (isset($_POST["submit"]) && !$mp) echo "<tr><td></td><td>{$error['mobile']}</td></tr>"; ?>
                            </td>

                        </tr>
                        <tr>
                            <td>GENDER:</td>
                            <td><input id="female" type="radio" name="gender" value="Female">
                                <label for="female">Female</label>
                                <input id="male" type="radio" name="gender" value="Male">
                                <label for="male">Male</label>
                                <?php if (isset($_POST["submit"]) && $gp) echo "<tr><td></td><td>{$error['gender']}</td></tr>"; ?>

                            </td>
                        </tr>
                        <tr>
                            <td>ADDRESS:</td>
                            <td><textarea rows="4" cols="40" id="comments" name="address">
                                <?php if (isset($_POST["submit"]) && empty($_POST["address"])) echo "<tr><td></td><td>{$error['address']}</td></tr>"; ?>
                    </textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>CITY:</td>
                            <td>
                                <input type="text" name="city" size="30"
                                    maxlength="30" placeholder="Enter your city name" />
                                <?php if (isset($_POST["submit"]) && empty($_POST["city"])) echo "<tr><td></td><td>{$error['address']}</td></tr>"; ?>

                            </td>


                        </tr>
                        <tr>

                            <td>PIN CODE:</td>
                            <td>
                                <input type="text" name="pin" size="30"
                                    minlength="5" maxlength="6" placeholder="Enter pin code" />
                                (6 digits number)
                                <?php if (isset($_POST["submit"]) && empty($_POST["pin"])) echo "<tr><td></td><td>{$error['address']}</td></tr>"; ?>

                            </td>
                        </tr>
                        <tr>
                            <td>STATE:</td>
                            <td>
                                <input type="text" name="STATE"
                                    maxlength="30" placeholder="Enter your state name" />
                                <?php if (isset($_POST["submit"]) && empty($_POST["STATE"])) echo "<tr><td></td><td>{$error['address']}</td></tr>"; ?>
                            </td>


                        </tr>
                        <tr>
                            <td>COUNTRY:</td>
                            <td>
                                <input type="text" name="country"
                                    maxlength="30" placeholder="Enter your city name" />
                                <?php if (isset($_POST["submit"]) && empty($_POST["country"])) echo "<tr><td></td><td>{$error['address']}</td></tr>"; ?>
                            </td>


                        </tr>


                        <tr>
                            <td>HOBBIES</td>
                            <td>
                                <input type="checkbox" name="HOBBIES[]" value="Singing" /> Singing
                                <input type="checkbox" name="HOBBIES[]"
                                    value="Dancing" /> Dancing
                                <input type="checkbox" name="HOBBIES[]"
                                    value="Drawing" /> Drawing
                                <input type="checkbox" name="HOBBIES[]"
                                    value="Sketching" /> Sketching
                                <br />
                                <input type="checkbox" name="HOBBIES[]"
                                    value="Others" /> Others<input type="text" name="Hobbie" size="30"
                                    maxlength="30" placeholder="Enter any other hobby" />
                                <?php if (isset($_POST["submit"]) && empty($_POST["HOBBIES"])) echo "{$error['hobby1']}";
                                if (isset($_POST["submit"]) && !empty($_POST["HOBBIES"]) && empty($_POST["Hobbie"]) && in_array("Others", $_POST["HOBBIES"])) echo "{$error['hobby2']}"; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>QUALIFICATION</td>
                            <td>
                                <table width="600px" , height="150px">
                                    <tr>
                                        <th>S.N0</th>
                                        <th>Examination</th>
                                        <th>Board</th>
                                        <th>Percentage</th>
                                        <th>Year of Passing</th>
                                    </tr><br>
                                    <tr>
                                        <td>1.</td>
                                        <th>Class X</th>
                                        <td> <input type="text" name="Xboard" size="20" maxlength="20" />
                                            <?php if (isset($_POST["submit"]) && empty($_POST["Xboard"])) echo "{$error['qerror']}"; ?>
                                        </td>
                                        <td><input type="text" name="Xpercentage" size="15" maxlength="10" />
                                            <?php if (isset($_POST["submit"]) && empty($_POST["Xpercentage"])) echo "{$error['qerror']}"; ?>
                                        </td>
                                        <td><input type="text" name="Xpass" size="15" maxlength="4" />
                                            <?php if (isset($_POST["submit"]) && empty($_POST["Xpass"])) echo "{$error['qerror']}"; ?>

                                        </td>

                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <th>Class XII</th>
                                        <td> <input type="text" name="XIIboard" size="20" maxlength="20" />
                                            <?php if (isset($_POST["submit"]) && empty($_POST["XIIboard"])) echo "{$error['qerror']}"; ?>
                                        </td>
                                        <td><input type="text" name="XIIpercentage" size="15" maxlength="10" />
                                            <?php if (isset($_POST["submit"]) && empty($_POST["XIIpercentage"])) echo "{$error['qerror']}"; ?>

                                        </td>
                                        <td><input type="text" name="XIIpass" size="15" maxlength="10" />
                                            <?php if (isset($_POST["submit"]) && empty($_POST["XIIpass"])) echo "{$error['qerror']}"; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <th>Graduation</th>
                                        <td> <input type="text" name="Gboard" size="20" maxlength="20" />
                                            <?php if (isset($_POST["submit"]) && empty($_POST["Gboard"])) echo "{$error['qerror']}"; ?>
                                        </td>
                                        <td><input type="text" name="Gpercentage" size="15" maxlength="10" />
                                            <?php if (isset($_POST["submit"]) && empty($_POST["Gpercentage"])) echo "{$error['qerror']}"; ?>
                                        </td>
                                        <td><input type="text" name="Gpass" size="15" maxlength="10" />
                                            <?php if (isset($_POST["submit"]) && empty($_POST["Gpass"])) echo "{$error['qerror']}"; ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4.</td>
                                        <th>Masters</th>
                                        <td> <input type="text" name="Mboard" size="20" maxlength="20" />
                                            <?php if (isset($_POST["submit"]) && empty($_POST["Mboard"])) echo "{$error['qerror']}"; ?>
                                        </td>
                                        <td><input type="text" name="Mpercentage" size="15" maxlength="10" />
                                            <?php if (isset($_POST["submit"]) && empty($_POST["Mpercentage"])) echo "{$error['qerror']}"; ?>
                                        </td>
                                        <td><input type="text" name="Mpass" size="15" maxlength="10" />
                                            <?php if (isset($_POST["submit"]) && empty($_POST["Mpass"])) echo "{$error['qerror']}"; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>(10 char max)</td>
                                        <td>(upto to decimal)</td>
                                        <td></td>
                                    </tr>
                                </table>

                            </td>
                        </tr>
                        <tr>
                            <td>COURSES:</td>
                            <td><input id="BCA" type="radio" name="COURSES"
                                    value="BCA" />
                                <label for="BCA">BCA</label>
                                <input id="B.Com" type="radio" name="COURSES"
                                    value="B.Com" />
                                <label for="B.Com">B.Com</label>
                                <input id="B.Sc" type="radio" name="COURSES"
                                    value="B.Sc" />
                                <label for="B.Sc">B.Sc</label>
                                <input id="B.A" type="radio" name="COURSES"
                                    value="B.A" />
                                <label for="B.A">B.A</label>

                                <?php if (isset($_POST["submit"]) && empty($_POST["COURSES"])) echo "<tr><td></td><td>{$error['course']}</td></tr>"; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><br />
                                <input type="submit" value="Submit" name="submit" />
                            </td>
                            <td><br />
                                <input type="reset" value="Reset" name="Reset" />
                            </td>
                        </tr>


                    </table>
                </form>


            </div>
        </center>

    </div>


</body>

</html>