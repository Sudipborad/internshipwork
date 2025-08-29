<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>N-Level Categories</title>
    <style>
        .category-tree {
            margin-left: 20px;
        }
        .category-item {
            margin: 5px 0;
        }
        .category-name {
            cursor: pointer;
            padding: 5px;
            border-radius: 3px;
        }
        .category-name:hover {
            background-color: #f0f0f0;
        }
        .subcategories {
            display: none;
            margin-left: 20px;
        }
        .expanded > .subcategories {
            display: block;
        }
    </style>
</head>
<body>
    <h1>Category Hierarchy</h1>
    <div id="category-container">
        <?php
        require 'connect.php';

        class CategoryManager {
            private $conn;
            
            public function __construct($conn) {
                $this->conn = $conn;
            }

            public function getChildCategories($parentId = 0) {
                $sql = "SELECT id, name, description, image FROM category WHERE parent_id = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("i", $parentId);
                $stmt->execute();
                return $stmt->get_result();
            }

            public function displayCategoryTree($parentId = 0, $level = 0) {
                $categories = $this->getChildCategories($parentId);
                
                if ($categories->num_rows > 0) {
                    echo '<div class="category-tree">';
                    while ($category = $categories->fetch_assoc()) {
                        $hasChildren = $this->getChildCategories($category['id'])->num_rows > 0;
                        $categoryClass = $hasChildren ? 'category-item has-children' : 'category-item';
                        
                        echo '<div class="' . $categoryClass . '">';
                        echo '<div class="category-name" onclick="toggleCategory(this)">';
                        echo htmlspecialchars($category['name']);
                        if ($hasChildren) {
                            echo ' <span class="toggle-icon">▼</span>';
                        }
                        echo '</div>';
                        
                        if ($hasChildren) {
                            echo '<div class="subcategories">';
                            $this->displayCategoryTree($category['id'], $level + 1);
                            echo '</div>';
                        }
                        
                        echo '</div>';
                    }
                    echo '</div>';
                }
            }
        }

        $obj = new Connect();
        $categoryManager = new CategoryManager($obj->conn);
        $categoryManager->displayCategoryTree();
        ?>
    </div>

    <script>
        function toggleCategory(element) {
            const parent = element.parentElement;
            parent.classList.toggle('expanded');
            const toggleIcon = element.querySelector('.toggle-icon');
            if (toggleIcon) {
                toggleIcon.textContent = parent.classList.contains('expanded') ? '▼' : '▶';
            }
        }
    </script>
</body>
</html> 




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get Category</title>
    <style>
        .category-select {
            margin-bottom: 10px;
        }
        .category-path {
            margin-bottom: 5px;
            color: #666;
        }
    </style>
</head>

<body>
    <?php
    require 'connect.php';

    class CategoryForm {
        private $conn;
        
        public function __construct($conn) {
            $this->conn = $conn;
        }

        public function getCategoryPath($categoryId) {
            $path = [];
            while ($categoryId > 0) {
                $sql = "SELECT id, name, parent_id FROM category WHERE id = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("i", $categoryId);
                $stmt->execute();
                $result = $stmt->get_result();
                $category = $result->fetch_assoc();
                
                if ($category) {
                    array_unshift($path, $category);
                    $categoryId = $category['parent_id'];
                } else {
                    break;
                }
            }
            return $path;
        }

        public function displayCategorySelect($selectedId = null) {
            $sql = "SELECT id, name, parent_id FROM category ORDER BY parent_id, name";
            $result = $this->conn->query($sql);
            
            $categories = [];
            while ($row = $result->fetch_assoc()) {
                $categories[] = $row;
            }
            
            $categoryTree = $this->buildCategoryTree($categories);
            $this->renderCategoryOptions($categoryTree, $selectedId);
        }

        private function buildCategoryTree($categories, $parentId = 0) {
            $tree = [];
            foreach ($categories as $category) {
                if ($category['parent_id'] == $parentId) {
                    $children = $this->buildCategoryTree($categories, $category['id']);
                    if ($children) {
                        $category['children'] = $children;
                    }
                    $tree[] = $category;
                }
            }
            return $tree;
        }

        private function renderCategoryOptions($categories, $selectedId, $level = 0) {
            foreach ($categories as $category) {
                $indent = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level);
                $selected = ($selectedId == $category['id']) ? 'selected' : '';
                echo "<option value='{$category['id']}' {$selected}>{$indent}{$category['name']}</option>";
                
                if (isset($category['children'])) {
                    $this->renderCategoryOptions($category['children'], $selectedId, $level + 1);
                }
            }
        }
    }

    $obj = new Connect();
    $categoryForm = new CategoryForm($obj->conn);

    if (isset($_POST["submit"])) {
        $name = $_POST["name"];
        $categoryId = $_POST["category"];
        $description = $_POST["description"];

        $count = count($_FILES['image']['name']);

        $img_arr = array();
        $timg_arr = array();
        for ($i = 0; $i < $count; $i++) {
            $imageName = $_FILES["image"]["name"][$i];
            $tempName = $_FILES["image"]["tmp_name"][$i];
            array_push($img_arr, $imageName);
            array_push($timg_arr, $tempName);
        }

        $data = [
            'name'        => $name,
            'pid'         => $categoryId,
            'description' => $description,
            'imgname'     => $img_arr,
            'tmp_name'    => $timg_arr,
        ];

        $obj->insert($data);
    }
    ?>

    <form method="post" enctype="multipart/form-data">
        <label for="name">Name</label><br>
        <input type="text" id="name" name="name" placeholder="Product name" required><br><br>

        <label for="category">Choose a Category</label><br>
        <select name="category" id="category" required>
            <option value="0">Select a category</option>
            <?php $categoryForm->displayCategorySelect(); ?>
        </select>
        <br><br>

        <label for="image">Upload Image</label><br>
        <input type="file" accept="image/*" multiple name="image[]" required><br><br>

        <label for="description">Description</label><br>
        <textarea type="text" id="description" name="description" placeholder="Enter description" required></textarea><br><br>

        <button type="submit" name="submit">Submit</button>
        <button type="reset" name="reset">Reset</button>
    </form>
</body>

</html>