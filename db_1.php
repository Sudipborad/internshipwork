<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>Home</title>


</head>

<body>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db_name = "demo_db";

    $conn = new mysqli($servername, $username, $password, $db_name);


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $errors = [];
    $hasErrors = false;

    if (isset($_POST["submit"])) {

        $gp = !isset($_POST["gender"]);

        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $mail = $_POST["email"];
        $mobile = $_POST["number"];


        $fp = preg_match('/^[a-zA-Z]{1,30}$/', $fname);
        $lp = preg_match('/^[a-zA-Z]{1,30}$/', $lname);
        $map = preg_match('/^[\w\.-]+@[\w\.-]+\.\w\D+$/', $mail);
        $mp = preg_match('/^\d{10}$/', $mobile);

        $error['fname'] = "Invalid first name";
        $error['lname'] = "Invalid last name";
        $error['email1'] = "Enter mail";
        $error['email2'] = "Enter proper mail";
        $error['mobile'] = "Enter 10 digit mobile number only";



        if (!$fp) $hasErrors = true;
        if (!$lp) $hasErrors = true;
        if (empty($mail)) $hasErrors = true;
        if (!empty($mail) && !$map) $hasErrors = true;
        if (!$mp) $hasErrors = true;

        $name = $fname . " " . $lname;

        if (!$hasErrors) {

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "INSERT INTO demo (name,email,number) VALUES ('$name' , '$mail', '$mobile')";

            if ($conn->query($sql) === TRUE) {
                echo "New record inserted successfully. ID: " . $conn->insert_id;
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }

    if (isset($_POST["show"])) {
        $searchName = $_POST["search"];


        // $stmt = $conn->prepare("DELETE FROM Demo WHERE name= ?");
        // $stmt->bind_param("s", $searchName);
        // $stmt->execute();

        // $stmt = $conn->prepare("SELECT * FROM demo ORDER BY id ASC ");
        // $stmt = $conn->prepare("SELECT * FROM demo ORDER BY id DESC ");
        $stmt = $conn->prepare("UPDATE demo SET name='Nand Kothiya' WHERE name='Bhavin Prajapati' ");
        $stmt->execute();
        $stmt = $conn->prepare("SELECT * FROM Demo");
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<table id='phptable' border='1' cellpadding='10' cellspacing='0'>";
                echo "<tr><th>Field</th><th>Value</th></tr>";
                echo "<tr> <td>ID number</td><td>{$row["id"]}</td></tr>";
                echo "<tr> <td>Name</td><td>{$row["name"]}</td></tr>";
                echo "<tr><td>Email</td><td>{$row["email"]}</td></tr>";
                echo "<tr><td>Mobile</td><td>{$row["number"]}</td></tr><br>";
                echo "</table>";
            }
        } else {
            echo "0 results";
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
                        <tr>
                            <td><br />
                                <input type="submit" value="Submit" name="submit" />
                            </td>
                            <td><br />
                                <input type="reset" value="Reset" name="Reset" />
                            </td>

                        </tr>
                        <tr></tr>

                        <tr><br />

                            <td><input type="text" name="search" placeholder="Enter full name"></td>
                            <td>
                                <input type="submit" value="Show Data" name="show" />
                            </td>
                        </tr>


                    </table>
                </form>


            </div>
        </center>

    </div>


</body>

</html>