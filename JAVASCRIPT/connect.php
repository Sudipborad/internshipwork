<?php

class Connect
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $db_name = "demo_db";
    public $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->db_name);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function insert($data)
    {
        $hasErrors = false;

        $fullname = $data['fullname'];
        $email = $data['email'];
        $mobile = $data['mobile'];
        $iname = $data['imgname'];
        $tempname = $data['tmp_name'];
        $folder = $data['folder'];
        $filesize = $data['size'];
        $filetype = $data['type'];


        $ext = pathinfo($iname, PATHINFO_EXTENSION);
        $time = date('d-m-y-h-i-s', time());
        $imgname = $time . "." . $ext;
        // echo $imgname;
        $namepattern = preg_match('/^[a-zA-Z\s]{1,30}$/', $fullname);
        $mailpattern = preg_match('/^[\w\.-]+@[\w\.-]+\.\w\D+$/', $email);
        $mobilepattern = preg_match('/^\d{10}$/', $mobile);

        if (!$namepattern) $hasErrors = true;
        if (isset($email) && !$mailpattern) $hasErrors = true;
        if (!$mobilepattern) $hasErrors = true;

        $allowed = array("image/jpeg", "image/gif", "image/png");
        if (!in_array($filetype, $allowed)) {
            $error_message = '<h2>Only jpg, gif, and png files are allowed.</h2>';
            echo $error_message;
        } else {
            if ($filesize < 500000) {

                if (!$hasErrors) {
                    $esql = "SELECT * FROM demo WHERE email='$email'";
                    $result = $this->conn->query($esql);
                    $row = $result->fetch_assoc();
                    if (!$row) {
                        $sql = "INSERT INTO demo (name,email,number,image) VALUES ('$fullname' , '$email', $mobile, '$imgname' )";
                        if (move_uploaded_file($tempname,  "./upload/" . $imgname)) {
                            echo "<h3>&nbsp; Image uploaded successfully!</h3>";
                        } else {
                            echo "<h3>&nbsp; Failed to upload image!</h3>";
                        }

                        if ($this->conn->query($sql) === TRUE) {
                            header("Location:showData.php");
                        } else {
                            echo "Error: " . $sql . "<br>" . $this->conn->error;
                        }
                    } else {
                        echo "<h3>Email already exists</h3>";
                    }
                } else {
                    echo "Error";
                }
            } else {
                echo "<h2>Image upload size limit is 500 KB only</h2>";
            }
        }
    }

    public function showdata()
    {
        $sql = "SELECT * FROM demo";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function getdata($id)
    {

        $sql = "SELECT * FROM demo WHERE id=$id";
        $result = $this->conn->query($sql);
        return $row = $result->fetch_assoc();
    }

    public function delete($id)
    {

        $sql = "SELECT * FROM demo WHERE id=$id";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        $dSql = "DELETE FROM demo WHERE id=$id";
        if ($this->conn->query($dSql) === TRUE) {
            unlink("upload/" . $row["image"]);
            header("Location: showData.php");
        } else {
            echo "Error deleting record: " . $this->conn->error;
        }
    }



    public function update($data)
    {
        $hasErrors = false;
        $name = $data["fullname"];
        $email = $data["email"];
        $mobile = $data["mobile"];
        $imgname = $data['imgname'];
        $tempname = $data['tmp_name'];
        $filesize = $data['size'];
        $filetype = $data['type'];
        $id = $data["id"];

        $sql = "SELECT * FROM demo WHERE id=$id";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();



        $np = preg_match('/^[a-zA-Z\s]{1,30}$/', $name);
        $map = preg_match('/^[\w\.-]+@[\w\.-]+\.\w\D+$/', $email);
        $mp = preg_match('/^\d{10}$/', $mobile);

        if (!$np) {
            echo "Invalid name";
            $hasErrors = true;
        }

        if (isset($email) && !$map) {
            $hasErrors = true;
            echo "Invalid email";
        }

        if (!$mp) {
            $hasErrors = true;
            echo "Invalid mobile";
        }

        if (!$hasErrors) {
            if ($imgname != $data['oldimage']) {
                $allowed = array("image/jpeg", "image/gif", "image/png");

                if (!in_array($filetype, $allowed)) {
                    echo "<h2>Only jpg, gif, and png files are allowed.</h2>";
                    return;
                }

                if ($filesize > 500000) {
                    echo "<h2>Image upload size limit is 500 KB only</h2>";
                    return;
                }

                $ext = pathinfo($imgname, PATHINFO_EXTENSION);
                $time = date('d-m-y-h-i-s', time());
                $newImageName = $time . "." . $ext;

                if (move_uploaded_file($tempname, "./upload/" . $newImageName)) {
                    echo "<h3> Image uploaded successfully!</h3>";
                    $updateimagename = $newImageName;

                    if (file_exists("upload/" . $row["image"])) {
                        unlink("upload/" . $row["image"]);
                    }
                } else {
                    echo "<h3>Failed to upload image!</h3>";
                    return;
                }
            } else {
                $updateimagename = $data['oldimage'];
            }
            $esql = "SELECT * FROM demo WHERE email='$email' AND id != $id";
            $result = $this->conn->query($esql);
            $row = $result->fetch_assoc();
            if(!$row){
            $sql = "UPDATE demo SET name='$name', email='$email', number='$mobile', image='$updateimagename' WHERE id=$id";


            if ($this->conn->query($sql) === TRUE) {
                header("Location:showData.php");
            } else {
                echo "Error: " . $sql . "<br>" . $this->conn->error;
            }}else{
                echo"<h2>Email already exists</h2>";
            }
        } else {
            echo "<h3>Error</h3>";
        }
    }
}
