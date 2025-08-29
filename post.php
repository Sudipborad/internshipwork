<!DOCTYPE html>
<html>

<head>
  <title>Simple HTML Form</title>
</head>

<body>
  <h2>Contact Form</h2>

  <form method="post">
    <label for="name">Name:</label><br />
    <input type="text" id="name" name="name" /><br /><br />

    <label for="email">Email:</label><br />
    <input type="email" id="email" name="email" /><br /><br />

    <label for="address">Address:</label><br />
    <textarea id="address" name="address" rows="2" cols="40"></textarea><br /><br />

    <label>Hobbies:</label><br />
    <label for="hobby1">
      <input type="checkbox" name="hobbies[]" value="Reading" />
      Reading
    </label>
    <label for="hobby2">
      <input type="checkbox" name="hobbies[]" value="Coding" />
      Coding
    </label>
    <label for="hobby3">
      <input type="checkbox" name="hobbies[]" value="Gardening" />
      Gardening
    </label><br /><br />

    <label for="gender">Gender:</label><br />
    <label for="male">
      <input type="radio" name="gender" value="male">
      Male
    </label><br>
    <label for="female">
      <input type="radio" name="gender" value="female">
      Female
    </label><br />

    <input type="submit" name="submit" value="Submit" />
  </form>

  <?php
  if (isset($_POST["submit"])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $address = $_POST["address"];

    echo "<h2>Name: $name </h2><br>";
    echo "<h2>Mail address: $email </h2><br>";
    echo "<h2>Address: $address </h2><br>";

    if (isset($_POST["hobbies"])) {
      $hobb = $_POST["hobbies"];

      echo "<h2>Hobbies:</h2>";

      foreach ($hobb as $hob) {
        echo "<h3>$hob </h3>";
      }
    } else {
      echo "No hobbie selected";
    }

    if (isset($_POST["gender"])) {
      $gender = $_POST["gender"];
      echo "<h2>Gender:</h2>";
      echo "<h3>$gender </h3>";
    } else {
      echo "No Gender selected selected";
    }
  }
  ?>
</body>

</html>