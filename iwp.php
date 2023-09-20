<?php
// Establish database connection
$mysqli = new mysqli("localhost", "root", "", "da");

// Check connection
if ($mysqli->connect_error) {
  die("Connection failed: " . $mysqli->connect_error);
}

// Retrieve data from form submission
if(isset($_POST['submit'])){



$regNumbers = $_POST['reg-no'];
$names = $_POST['name'];
$phones = $_POST['phone'];
$emails = $_POST['email'];
$projectTitle = $_POST['project-title'];
$projectAbstract = $_POST['project-abstract'];
$projectFunctionalities = $_POST['project-functionalities'];
$resourcesRequired = $_POST['resources-required'];
$dataModelName = $_FILES['dataModel']['name'];
$dataModelTmpName = $_FILES['dataModel']['tmp_name'];

// Insert team details into teams table
$stmt = $mysqli->prepare("INSERT INTO teams (project_title, project_abstract, project_functionalities, resources_required, data_model_image) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss",$projectTitle, $projectAbstract, $projectFunctionalities, $resourcesRequired, $dataModelName);
$stmt->execute();

// Get team ID of the inserted team
$teamId = $stmt->insert_id;

// Insert team members into team_members table
$stmt = $mysqli->prepare("INSERT INTO team_members (registration_number, name, phone_number, email,team_id) VALUES (?, ?, ?, ?, ?)");
for ($i = 0; $i < count($regNumbers); $i++) {
  $stmt->bind_param("issss",$regNumbers[$i], $names[$i], $phones[$i], $emails[$i],$teamId);
  $stmt->execute();
}

// Upload data model image file
$targetDir = "iwp_da/uploads/";
$targetFile = $targetDir . basename($dataModelName);
move_uploaded_file($dataModelTmpName, $targetFile);

$stmt->close();
$mysqli->close();

// Redirect to success page
header("Location: success.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>DA-1</title>
  
</head>

<body>
  <form id="registration-form" method="post" action="">
    <h2>Team Members</h2>
    <div id="team-members">
      <div class="team-member">
        <label for="reg-no-1">Registration Number:</label>
        <input type="text" id="reg-no-1" name="reg-no[]" required pattern="\d{2}[A-Z]{3}\d{4}" />
        <label for="name-1">Name:</label>
        <input type="text" id="name-1" name="name[]" required pattern="[^\s]+" />
        <label for="phone-1">Phone Number:</label>
        <input type="tel" id="phone-1" name="phone[]" required pattern="\+91\d{10}" />
        <label for="email-1">Email:</label>
        <input type="email" id="email-1" name="email[]" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" />
      </div>
    </div>
    <button type="button" id="add-team-member">Add Team Member</button>

    <h2>Project Details</h2>
    <label for="project-title">Project Title:</label>
    <input type="text" id="project-title" name="project-title" required />
    <label for="project-abstract">Project Abstract:</label>
    <textarea id="project-abstract" name="project-abstract" required></textarea>
    <label for="project-functionalities">Project Functionalities:</label>
    <textarea id="project-functionalities" name="project-functionalities" required></textarea>
    <label for="resources-required">Resources Required:</label>
    <textarea id="resources-required" name="resources-required" required></textarea>
    <label for="dataModel">Data Model (JPG only):</label>
		<input type="file" id="dataModel" name="dataModel" accept="image/jpeg" required>
    <br>

    <button type="submit" name="submit" id="submit">Submit</button>
  </form>

  <script>
    const addTeamMemberBtn = document.getElementById("add-team-member");
    const teamMembers = document.getElementById("team-members");
    let memberCount = 1;

    addTeamMemberBtn.addEventListener("click", () => {
      const newMember = document.createElement("div");
      newMember.classList.add("team-member");
      newMember.innerHTML = `
    <label for="reg-no-${memberCount + 1}">Registration Number:</label>
    <input type="text" id="reg-no-${memberCount + 1
        }" name="reg-no[]" required pattern="\d{2}[A-Z]{3}\d{4}">
    <label for="name-${memberCount + 1}">Name:</label>
    <input type="text" id="name-${memberCount + 1
        }" name="name[]" required pattern="[^\s]+">
    <label for="phone-${memberCount + 1}">Phone Number:</label>
    <input type="tel" id="phone-${memberCount + 1
        }" name="phone[]" required pattern="^\+91\d{10}$">
    <label for="email-${memberCount + 1}">Email:</label>
    <input type="email" id="email-${memberCount + 1
        }" name="email[]" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
  `;
      teamMembers.appendChild(newMember);
      memberCount++;
    });
  </script>
</body>

</html>

<script>
  function validateForm() {
    const regNoInputs = document.querySelectorAll('input[name="reg-no[]"]');
    const nameInputs = document.querySelectorAll('input[name="name[]"]');
    const phoneInputs = document.querySelectorAll('input[name="phone[]"]');
    const emailInputs = document.querySelectorAll('input[name="email[]"]');
    const projectTitleInput = document.getElementById("project-title");
    const projectAbstractInput = document.getElementById("project-abstract");
    const projectFunctionalitiesInput = document.getElementById(
      "project-functionalities"
    );
    const resourcesRequiredInput =
      document.getElementById("resources-required");
    const dataModelInput = document.getElementById("dataModel");

    let isValid = true;

    // Validate team member inputs
    regNoInputs.forEach((input) => {
      if (!input.checkValidity()) {
        isValid = false;
        input.classList.add("invalid");
      } else {
        input.classList.remove("invalid");
      }
    });

    nameInputs.forEach((input) => {
      if (!input.checkValidity()) {
        isValid = false;
        input.classList.add("invalid");
      } else {
        input.classList.remove("invalid");
      }
    });

    phoneInputs.forEach((input) => {
      if (!input.checkValidity()) {
        isValid = false;
        input.classList.add("invalid");
      } else {
        input.classList.remove("invalid");
      }
    });

    emailInputs.forEach((input) => {
      if (!input.checkValidity()) {
        isValid = false;
        input.classList.add("invalid");
      } else {
        input.classList.remove("invalid");
      }
    });

    // Validate project inputs
    if (!projectTitleInput.checkValidity()) {
      isValid = false;
      projectTitleInput.classList.add("invalid");
    } else {
      projectTitleInput.classList.remove("invalid");
    }

    if (!projectAbstractInput.checkValidity()) {
      isValid = false;
      projectAbstractInput.classList.add("invalid");
    } else {
      projectAbstractInput.classList.remove("invalid");
    }

    if (!projectFunctionalitiesInput.checkValidity()) {
      isValid = false;
      projectFunctionalitiesInput.classList.add("invalid");
    } else {
      projectFunctionalitiesInput.classList.remove("invalid");
    }

    if (!resourcesRequiredInput.checkValidity()) {
      isValid = false;
      resourcesRequiredInput.classList.add("invalid");
    } else {
      resourcesRequiredInput.classList.remove("invalid");
    }

    if (!dataModelInput.checkValidity()) {
      isValid = false;
      dataModelInput.classList.add("invalid");
    } else {
      dataModelInput.classList.remove("invalid");
    }

    return isValid;
  }
</script>