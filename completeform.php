<!DOCTYPE html>
<head>
    <title>Complete Form</title>
</head>

<body>

<h2>A Complete Form</h2>
    <form method="post">
        <label for="name">Name<br/></label>
        <input type="text" name="name" placeholder="Enter Your Name"><br/><br/>

        <label for="email">Email<br/></label>
        <input type="text" name="email" placeholder="Enter Email" >
        <br/><br/>

        <label for="phone">Phone number<br/></label>
        <input type="text" name="phone" placeholder="Enter Phone number" >
        <br/><br/>

        <label for="Password">Password<br/></label>
        <input type="text " name="password" placeholder="Enter password" >
        <br/><br/>

        <label for="Cpassword">Confirm password<br/></label>
        <input type="text " name="cpassword" placeholder="Confirm password" >
        <br/><br/>
        <input type="submit" name="submit" value="Submit"><br/><br/>
    </form>

    <?php
    if(isset($_POST["submit"])){
        $name=$_POST["name"];
        echo"Name:" . $name ."<br>";
        

        $mpattern='/^[\w\.-]+@[\w\.-]+\.\w\D+$/';
        $mail=$_POST["email"];
        if(preg_match($mpattern, $mail)){
            echo"Valid email:" . $mail;
        }
        else{
            echo"Invalid email ";
        }

        $phpattern='/^\d{10}$/';
        $phone=$_POST["phone"];
        if(preg_match($phpattern, $phone)){
            echo"<br>Correct Phone Number:" . $phone;
        }
        else{
            echo"<br>Enter 10 digits in phone number";
        }


        $ppattern='/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*]).{8,}$/';
        $pass=$_POST["password"];
        if(preg_match($ppattern, $pass))
        {
            echo"<br>Correct format password<br>";
        }
        else{
            echo"<br>Wrong format<br>";
        }

        $cpass=$_POST["cpassword"];
        if($pass == $cpass){
            echo"Coreect Confirm password<br>";
        }
        else{
            echo"Enter Confirm password same as password above<br>";
        }
    }

    ?>
</body>
</html>