
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>J Component Project Registration System</title>
</head>
<body>
    <form action="process.php" method="post" enctype="multipart/form-data" onsubmit="return validateform()">
        <h3>Team Member 1</h3>
        <input type="text" name="registration_number1" placeholder="Registration Number">
        <input type="text" name="name1" placeholder="Name">
        <input type="text" name="phone_number1" placeholder="Phone Number">
        <input type="text" name="email1" placeholder="Email">
      
        <div id="team-members"></div>
      
        <button type="button" onclick="addMember()">Add Team Member</button>
      
        <h3>Project Details</h3>
        <input type="text" name="project_title" placeholder="Project Title">
        <textarea name="project_abstract" placeholder="Project Abstract"></textarea>
        <textarea name="project_functionalities" placeholder="Project Functionalities"></textarea>
        <input type="text" name="resources_required" placeholder="Resources Required">
        <input type="file" name="data_model" accept="image/jpeg">
      
        <button type="submit">Submit</button>
      </form>
    
</body>
<script>
function validateForm() {
  let valid = true;

  // Validate team member fields
  for (let i = 1; i <= 3; i++) {
    const registration_number = document.querySelector(`input[name="registration_number${i}"]`).value.trim();
    const name = document.querySelector(`input[name="name${i}"]`).value.trim();
    const phone_number = document.querySelector(`input[name="phone_number${i}"]`).value.trim();
    const email = document.querySelector(`input[name="email${i}"]`).value.trim();

    // Validate registration number
    if (!/^\d{2}[A-Za-z]{3}\d{4}$/.test(registration_number)) {
      valid = false;
      alert(`Invalid registration number for team member ${i}`);
      break;
    }

    // Validate name
    if (!/^[A-Za-z]+\s?[A-Za-z]+$/.test(name)) {
      valid = false;
      alert(`Invalid name for team member ${i}`);
      break;
    }

    // Validate phone number
    if (!/^\+91\d{10}$/.test(phone_number)) {
      valid = false;
      alert(`Invalid phone number for team member ${i}`);
      break;
    }

    // Validate email
    if (!/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/.test(email)) {
      valid = false;
      alert(`Invalid email for team member ${i}`);
      break;
    }
  }

  // Validate project details fields
  const project_title = document.querySelector(`input[name="project_title"]`).value.trim();
  const project_abstract = document.querySelector(`textarea[name="project_abstract"]`).value.trim();
  const project_functionalities = document.querySelector(`textarea[name="project_functionalities"]`).value.trim();
  const resources_required = document.querySelector(`input[name="resources_required"]`).value.trim();
  const data_model = document.querySelector(`input[name="data_model"]`).value.trim();

  if (!project_title) {
    valid = false;
    alert("Project title is required");
  }

  if (!project_abstract) {
    valid = false;
    alert("Project abstract is required");
  }

  if (!project_functionalities) {
    valid = false;
    alert("Project functionalities are required");
  }

  if (!resources_required) {
    valid = false

</script>

</html>
<?php

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
  // Connect to database
  $servername = "localhost";
  $username = "username";
  $password = "password";
  $dbname = "database";

  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Process team member data
  for ($i = 1; $i <= 3; $i++) {
    $registration_number = $_POST['registration_number' . $i];
    $name = $_POST['name' . $i];
    $phone_number = $_POST['phone_number' . $i];
    $email = $_POST['email' . $i];

    // Insert team member data into database
    $sql = "INSERT INTO team_members (registration_number, name, phone_number, email) VALUES ('$registration_number', '$name', '$phone_number', '$email')";

    if ($conn->query($sql) !== TRUE) {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }

  // Process project data
  $project_title = $_POST['project_title'];
  $project_abstract = $_POST['project_abstract'];
  $project_functionalities = $_POST['project_functionalities'];
  $resources_required = $_POST['resources_required'];

  // Upload data model image
  $target_dir = "uploads/";
  $target_file = $target_dir . basename($_FILES["data_model"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

  // Check if image file is a actual image or fake image
  if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["data_model"]["tmp_name"]);
    if($check !== false) {
      $uploadOk = 1;
    } else {
      echo "File is not an image.";
      $uploadOk = 0;
    }
  }

  // Check if file already exists
  if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
  }

  // Check file size
  if ($_FILES["data_model"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
  }

  // Allow certain file formats
  if($imageFileType != "jpg") {
    echo "Sorry, only JPG files are allowed.";
    $uploadOk = 0;
  }

  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["data_model"]["tmp_name"], $target_file)) {
      echo "The file ". htmlspecialchars( basename( $_FILES["data_model"]["name"])). " has been uploaded.";
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }

  // Insert project data into database
  $sql = "INSERT INTO projects (project_title, project_abstract, project_functionalities, resources_required, data_model) VALUES ('$project_title', '$project_abstract', '$project_functional


  