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

    public function cateSubcatTree($parent_id = 0, $sub_mark = '')
        {
            $sql = "SELECT * FROM category WHERE parent_id = $parent_id";

            if ($result=$this->conn->query($sql)) {
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['id'] . '">' . $sub_mark . $row['name'] . '</option>';
                    $this->cateSubcatTree($row['id'], $sub_mark . '--');
                }
            }
        }

    public function insert($data)
    {
        $name = $data['name'];
        $category = $data['category'];
        $pid = $data["pid"];
        $description = $data['description'];
        $imgname = $data["imgname"];

        $timgname = $data['tmp_name'];
        $uploadPath = "./uploads/category/";

        // if (count($imgname) > 3) {
        //     echo "<h2>Only 3 images allowed to upload</h2>";
        //     return;
        // }

        $allowed = array("image/jpeg", "image/png", "image/gif");
        $img_arr = [];

        for ($i = 0; $i < count($imgname); $i++) {
            $filetype = mime_content_type($timgname[$i]);
            $filesize = filesize($timgname[$i]);


            if (!in_array($filetype, $allowed)) {
                echo "<h2>Only JPG, GIF, and PNG files are allowed.</h2>";
                return;
            }

            if ($filesize > 500000) {
                echo "<h2>Image {$imgname[$i]} exceeds 500 KB size limit.</h2>";
                return;
            }

            $imagename = uniqid() . "_" . $imgname[$i];

            $img_arr[] = $imagename;

            if (!move_uploaded_file($timgname[$i], $uploadPath . $imagename)) {
                echo "<h3>&nbsp; Failed to upload image: $imagename</h3>";
                return;
            }
        }

        $sql = "INSERT INTO category (name, parent_id, image, description) VALUES ('$name', $pid, '$img_arr[0]', '$description')";

        if ($this->conn->query($sql)) {
            $last_id = $this->conn->insert_id;
            for ($i = 1; $i < count($imgname); $i++) {
                $sql = "INSERT INTO category_image (image,category_id) VALUES ('$img_arr[$i]',$last_id)";
                if ($this->conn->query($sql)) {
                    // header("Location:showdata.php");
                    // echo "Success";
                } else {
                    echo "Error";
                }
            }
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }
    }


    public function getid($category)
    {
        $sql = "SELECT id from category where name ='$category'";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc();
    }


    public function getcategory()
    {
        $sql = "SELECT name,id FROM category where parent_id=0";
        return $result = $this->conn->query($sql);
    }

    public function getcategorylevel1($id)
    {
        $sql = "SELECT name,id FROM category WHERE parent_id=$id";
        return $result = $this->conn->query($sql);
    }

    public function getallCategories($id)
    {
        $sql = "SELECT cat1.name, cat1.image, cat1.description, cat1.id, cat2.name as parent_name from category cat1 JOIN category cat2 on cat1.parent_id=cat2.id WHERE cat2.id=$id";
        return $this->conn->query($sql);
    }

    public function getdata($id)
    {
        $sql = "SELECT cat1.*, cat2.name as parent_name from category cat1 JOIN category cat2 on cat1.parent_id=cat2.id WHERE cat1.id=$id";
        return $result = $this->conn->query($sql);
    }

    public function showimage($id)
    {
        $sql = "SELECT * FROM category_image WHERE category_id=$id";
        return $this->conn->query($sql);
    }

    public function getProductdata($id)
    {
        $sql = "SELECT c1.name,c1.description,c2.image as img  FROM category c1 LEFT JOIN category_image c2 on c1.id=c2.category_id WHERE c1.id=$id";
        return $this->conn->query($sql);
    }

    public function deleteimg($id)
    {
        $dsql = "SELECT image,category_id from category_image where id=$id";
        $result = $this->conn->query($dsql);
        $cid = $result->fetch_assoc();
        $sql = "DELETE FROM category_image where id=$id";
        if ($this->conn->query($sql)) {
            unlink("uploads/" . $cid["image"]);
            header("Location: edit.php?id={$cid['category_id']}");
        } else {
            echo "Error deleting record: " . $this->conn->error;
        }
    }


    public function delete($id)
    {
        $dsql = "SELECT parent_id,image from category where id=$id";
        $result = $this->conn->query($dsql);
        $cid = $result->fetch_assoc();
        $sql = "DELETE FROM category WHERE id=$id";
        if ($this->conn->query($sql) === TRUE) {
            unlink("uploads/" . $cid["image"]);
            $disql = "SELECT image from category_image WHERE category_id=$id";
            $result = $this->conn->query($disql);
            $isql = "DELETE FROM category_image WHERE category_id=$id";
            if ($this->conn->query($isql)) {
                while ($did = $result->fetch_assoc()) {
                    unlink("uploads/" . $did["image"]);
                }
                echo "Success";
            }

            header("Location: showdata.php?categoryid={$cid['parent_id']}&submit=");
        } else {
            echo "Error deleting record: " . $this->conn->error;
        }
    }

    public function update($data)
    {
        $hasErrors = false;
        $name = $data["name"];
        $description = $data["description"];
        $parent_id = $data["parent_id"];
        $imgname = $data['imgname'];
        $id = $data["id"];
        $timgname = $data['tmp_name'];
        $uploadPath = "./uploads/";


        $sql = "SELECT * FROM category WHERE id=$id";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();

        if (empty($name)) {
            echo "The product name is empty";
            $hasErrors = true;
        }

        if (empty($description)) {
            $hasErrors = true;
            echo "The product description is empty";
        }

        if (!$hasErrors) {

            $allowed = ["image/jpeg", "image/png", "image/gif"];
            $img_arr = [];

            if (!empty($imgname)) {
                for ($i = 0; $i < count($imgname); $i++) {
                    $filetype = mime_content_type($timgname[$i]);
                    $filesize = filesize($timgname[$i]);


                    if (!in_array($filetype, $allowed)) {
                        echo "<h2>Only JPG, GIF, and PNG files are allowed.</h2>";
                        return;
                    }

                    if ($filesize > 500000) {
                        echo "<h2>Image {$imgname[$i]} exceeds 500 KB size limit.</h2>";
                        return;
                    }

                    $imagename = uniqid() . "_" . $imgname[$i];

                    $img_arr[] = $imagename;

                    if (!move_uploaded_file($timgname[$i], $uploadPath . $imagename)) {
                        echo "<h3>&nbsp; Failed to upload image: $imagename</h3>";
                        return;
                    }
                }
            }


            $sql = "UPDATE category SET name='$name',description='$description',parent_id=$parent_id WHERE id=$id";


            if ($this->conn->query($sql) === TRUE) {
                if (!empty($imgname)) {
                    for ($i = 0; $i < count($img_arr); $i++) {
                        $sql = "INSERT INTO category_image (image,category_id) VALUES ('$img_arr[$i]',$id)";
                        if ($this->conn->query($sql)) {
                        } else {
                            echo "Error";
                        }
                    }
                }
                header("Location: showdata.php?categoryid=$parent_id&submit=");
            } else {
                echo "Error: " . $sql . "<br>" . $this->conn->error;
            }
        }
    }

    public function insertproduct($data)

    {
        $hasErrors = false;
        $name = $data['name'];
        $category = $data['category'];
        $row = $this->getid($category);
        $categoryid = $row['id'];
        $description = $data['description'];
        $uploadPath = "./uploads/products/";

        if (empty($name)) {
            echo "Enter Product name";
            $hasErrors = true;
        }

        if (empty($description)) {
            $hasErrors = true;
            echo "Enter description";
        }

        if (empty($category)) {
            $hasErrors = true;
            echo "Select a category";
        }

        if (!$hasErrors) {
            $sql = "INSERT INTO products (name, description, category_id ) VALUES ('$name', '$description', $categoryid)";

            if ($this->conn->query($sql)) {
                $last_id = $this->conn->insert_id;

                foreach ($data['image']['tmp_name'] as $key => $val) {
                    $filename = $data['image']['name'][$key];
                    $filesize = $data['image']['size'][$key];
                    $filetempname = $data['image']['tmp_name'][$key];

                    $fileext = pathinfo($filename, PATHINFO_EXTENSION);
                    $fileext = strtolower($fileext);
                    $allowed = array("jpeg", "png", "jpg");


                    if (!in_array($fileext, $allowed)) {
                        echo "<h2>Only JPG, JPEG, and PNG files are allowed.</h2>";
                        return;
                    }

                    if ($filesize > 500000) {
                        echo "<h2>Image $filename exceeds 500 KB size limit.</h2>";
                        return;
                    }

                    $imagename = uniqid() . "_" . $filename;

                    if (!move_uploaded_file($filetempname, $uploadPath . $imagename)) {
                        echo "<h3>&nbsp; Failed to upload image: $imagename</h3>";
                        return;
                    }

                    $isql = "INSERT INTO product_image (product_id,image) VALUES ($last_id,'$imagename')";
                    if ($this->conn->query($isql)) {
                        // echo "Success";
                    } else {
                        echo "Error";
                    }
                }
                echo "<script>alert('Successful Insertion');</script>";
            } else {
                echo "Error";
            }
        }
    }

    public function getallProducts($id)
    {
        $sql = "SELECT p1.*,c1.name as parent_name FROM products p1 JOIN category c1 on p1.category_id=c1.id where category_id=$id AND status='1'";
        return $this->conn->query($sql) ;
    }

    public function productdata($id)
    {
        $sql = "SELECT* from products where id=$id ";
        return $result = $this->conn->query($sql);
    }

    public function showproductimage($id)
    {
        $sql = "SELECT * FROM product_image WHERE product_id=$id";
        return $this->conn->query($sql);
    }

    public function deleteproductimg($id)
    {
        $dsql = "SELECT image,product_id from product_image where id=$id";
        $result = $this->conn->query($dsql);
        $cid = $result->fetch_assoc();
        $sql = "DELETE FROM product_image where id=$id";
        if ($this->conn->query($sql)) {
            unlink("uploads/products/" . $cid["image"]);
            header("Location: editproduct.php?id={$cid['product_id']}");
        } else {
            echo "Error deleting record: " . $this->conn->error;
        }
    }


    public function updateproduct($data)
    {
        $hasErrors = false;
        $name = $data["name"];
        $description = $data["description"];
        $category_id = $data["category"];
        $id = $data["id"];
        $uploadPath = "./uploads/products/";

        // echo"<pre>";

        if (empty($name)) {
            echo "Enter Product name";
            $hasErrors = true;
        }

        if (empty($description)) {
            $hasErrors = true;
            echo "Enter description";
        }

        if (!$hasErrors) {
            $sql = "UPDATE products SET name='$name',description='$description',category_id=$category_id WHERE id=$id";

            if ($this->conn->query($sql)) {
                if (in_array($data['image'], $data)) {

                    foreach ($data['image']['tmp_name'] as $key => $val) {
                        $filename = $data['image']['name'][$key];
                        $filesize = $data['image']['size'][$key];
                        $filetempname = $data['image']['tmp_name'][$key];

                        $fileext = pathinfo($filename, PATHINFO_EXTENSION);
                        $fileext = strtolower($fileext);
                        $allowed = array("jpeg", "png", "jpg");


                        if (!in_array($fileext, $allowed)) {
                            echo "<h2>Only JPG, JPEG, and PNG files are allowed.</h2>";
                            return;
                        }

                        if ($filesize > 500000) {
                            echo "<h2>Image $filename exceeds 500 KB size limit.</h2>";
                            return;
                        }

                        $imagename = uniqid() . "_" . $filename;

                        if (!move_uploaded_file($filetempname, $uploadPath . $imagename)) {
                            echo "<h3>&nbsp; Failed to upload image: $imagename</h3>";
                            return;
                        }

                        $isql = "INSERT INTO product_image (product_id,image) VALUES ($id,'$imagename')";
                        if ($this->conn->query($isql)) {
                            // echo "<script>alert('Successfully Updated Product data');</script>";
                            // echo "Success";
                        } else {
                            echo "Error";
                            return;
                        }
                    }
                }
                header("Location:editproduct.php?id=$id");
            } else {
                echo "Error";
                return;
            }
        }
    }

    public function deleteproduct($id)
    {
        $dsql = "SELECT category_id from products where id=$id";
        $result = $this->conn->query($dsql);
        $cid = $result->fetch_assoc();
        $sql = "DELETE FROM products WHERE id=$id";
        if ($this->conn->query($sql) === TRUE) {
            unlink("uploads/" . $cid["image"]);
            $disql = "SELECT image from product_image WHERE product_id=$id";
            $result = $this->conn->query($disql);
            $isql = "DELETE FROM product_image WHERE product_id=$id";
            if ($this->conn->query($isql)) {
                while ($did = $result->fetch_assoc()) {
                    unlink("uploads/products/" . $did["image"]);
                }
                echo "Success";
            }

            header("Location: showproduct.php?categoryid={$cid['category_id']}&submit=");
        } else {
            echo "Error deleting record: " . $this->conn->error;
        }
    }


    public function viewproductdata($id)
    {
        $sql = "SELECT products.name,products.description,product_image.image,category.name as parent_name FROM products JOIN product_image ON product_image.product_id=products.id JOIN category ON products.category_id=category.id WHERE products.id=$id";
        return $result = $this->conn->query($sql);
    }
}
