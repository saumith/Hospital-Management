<!DOCTYPE html>
<html>
<head>
  <title>Subject Selection</title>
</head>
<body>
  <h1>Subject Selection</h1>
  <form id="subjectForm">
    <ul>
      <li><input type="checkbox" name="subject" value="Mathematics">Mathematics (3 credits)</li>
      <li><input type="checkbox" name="subject" value="English">English (3 credits)</li>
      <li><input type="checkbox" name="subject" value="Science">Science (3 credits)</li>
      <li><input type="checkbox" name="subject" value="History">History (3 credits)</li>
      <li><input type="checkbox" name="subject" value="Computer Science">Computer Science (3 credits)</li>
      <li><input type="checkbox" name="subject" value="Music">Music (3 credits)</li>
      <li><input type="checkbox" name="subject" value="Art">Art (3 credits)</li>
    </ul>
    <button type="button" onclick="checkCredits()">Submit</button>
  </form>
  <div id="message"></div>

  <script>
    function checkCredits() {
      const form = document.getElementById("subjectForm");
      const selectedSubjects = form.querySelectorAll('input[name="subject"]:checked');
      let totalCredits = 0;
      for (let i = 0; i < selectedSubjects.length; i++) {
        totalCredits += 3;
      }

      const messageDiv = document.getElementById("message");
      if (totalCredits < 5) {
        messageDiv.textContent = "Credits less than Minimum Required";
        messageDiv.style.color = "red";
      } else if (totalCredits > 20) {
        messageDiv.textContent = "You may be overloaded. Reduce your Credits if possible";
        messageDiv.style.color = "aqua";
      } else if (totalCredits >= 12 && totalCredits <= 18) {
        messageDiv.textContent = "Request accepted";
        messageDiv.style.color = "green";
      }
    }
  </script>
</body>
</html>
