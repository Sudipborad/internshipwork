<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Data</title>
</head>

<body>
    <?php
    require 'connect.php';

    $obj = new Connect();

    if (isset($_POST["submit"])) {
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $mobile = $_POST["mobile"];

    $imageName = $_FILES["image"]["name"];
    $tempName = $_FILES["image"]["tmp_name"];
    $imageSize = $_FILES["image"]["size"];
    $imageType = $_FILES["image"]["type"];
    $uploadPath = "./upload/";

    
    $data = [
        'fullname'  => $fullname,
        'email'     => $email,
        'mobile'    => $mobile,
        'imgname'   => $imageName,
        'tmp_name'  => $tempName,
        'size'      => $imageSize,
        'type'      => $imageType,
        'folder'    => $uploadPath
    ];

    $obj->insert($data);
}
?>

    <form method="post" enctype="multipart/form-data" onsubmit=" return showdata()">
        <label for="name">Name</label><br>
        <input type="text" id="fullname" name="fullname" placeholder="Enter your name"><br><br>

        <label for="email">Email</label><br>
        <input type="text" id="email" name="email" placeholder="Enter your name"><br><br>

        <label for="mobile">Mobile Number</label><br>
        <input type="number" id="mobile" name="mobile" placeholder="Enter your mobile number"><br><br>

        <label for="image">Upload Image</label><br>
        <input type="file" accept="image/*" name="image"><br><br>
        <button type="submit" name="submit">Submit</button>
        <button type="reset" name="reset">Reset</button>
    </form>
</body>
<script>
    function showdata() {

        let fullname = document.getElementById('fullname').value;
        let email = document.getElementById('email').value;
        let mobile = document.getElementById('mobile').value;

        let nameregex = /^[A-Za-z\s.'-]+$/;
        let emailregex = /^(?![0-9]+$)[a-zA-Z][a-zA-Z0-9._%+-]+@[a-zA-Z][a-zA-Z0-9-]+\.[a-zA-Z]{2,}$/;
        let mobileregex = /^\d{10}$/;


        if (!fullname == " " || !email == " " || !mobile == " ") {
            if (!nameregex.test(fullname)) {
                alert("Enter name properly");
                return false;
            } else if (!emailregex.test(email)) {
                alert("Enter proper mail");
                return false;
            } else if (!mobileregex.test(mobile)) {
                alert("Enter proper mobile number");
                return false;
            } else {
                alert("Data entered correctly! \n The data entered is \nName: " + fullname + "\nEmail: " + email + "\nMobile Number: " + mobile);
                return true;
            }
        } else {
            alert("Enter data in all fields");
            return false;

        }
    }
</script>

</html>