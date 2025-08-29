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

        $name = $data["name"];
        $email = $data["email"];
        $mobile = $data["mobile"];

        $namepattern = preg_match('/^[a-zA-Z\s]{1,30}$/', $name);
        $mailpattern = preg_match('/^[\w\.-]+@[\w\.-]+\.\w\D+$/', $email);
        $mobilepattern = preg_match('/^\d{10}$/', $mobile);

        if (!$namepattern) $hasErrors = true;
        if (isset($email) && !$mailpattern) $hasErrors = true;
        if (!$mobilepattern) $hasErrors = true;

        if (!$hasErrors) {
            $sql = "INSERT INTO demo (name,email,number) VALUES ('$name' , '$email', $mobile) ";

            if ($this->conn->query($sql) === TRUE) {
                header("Location:showData.php");
            } else {
                echo "Error: " . $sql . "<br>" . $this->conn->error;
            }
        } else {
            echo "Error";
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

    public function delete($id){
        
        $dSql = "DELETE FROM demo WHERE id=$id";
        if ($this->conn->query($dSql) === TRUE) {
            echo "Success";
            header("Location: showData.php");
        } else {
            echo "Error deleting record: " . $this->conn->error;
        }}
        
    

    public function update($data)
    {
        $hasErrors = false;

        $name = $data["name"];
        $email = $data["email"];
        $mobile = $data["number"];
        $id = $data["id"];

        $np = preg_match('/^[a-zA-Z\s]{1,30}$/', $name);
        $map = preg_match('/^[\w\.-]+@[\w\.-]+\.\w\D+$/', $email);
        $mp = preg_match('/^\d{10}$/', $mobile);

        if (!$np) $hasErrors = true;
        if (isset($email) && !$map) $hasErrors = true;
        if (!$mp) $hasErrors = true;

        if (!$hasErrors) {
            $usql = "UPDATE demo SET name='$name', email='$email', number='$mobile' WHERE id=$id";
            if ($this->conn->query($usql) === TRUE) {
                header("Location: showData.php");
            } else {
                echo "Error";
            }
        } else {
            echo "Error";
        }
    }
}
