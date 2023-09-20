<?php

$categories = array('sports', 'music', 'automobile');

if (isset($_POST['category'])) {

  $selected_category = $_POST['category'];
  setcookie('news_category', $selected_category, time() + (86400 * 30), "/"); // 30 days expiration
  echo "You have selected " . $selected_category . " category. Please refresh the page to see the news.";

} else {
  if (isset($_COOKIE['news_category'])) {
    $selected_category = $_COOKIE['news_category'];
    $conn = mysqli_connect('localhost', 'username', 'password', 'news_db');
    $query = "SELECT * FROM news WHERE category = '$selected_category'";
    $result = mysqli_query($conn, $query);
    echo "<h2>News of " . $selected_category . " category:</h2>";
    echo "<ul>";
    while ($row = mysqli_fetch_assoc($result)) {
      echo "<li>" . $row['topic'] . "</li>";
      echo "<p>" . $row['content'] . "</p>";
    }
    echo "</ul>";
    mysqli_close($conn);

  } else {
    echo "<form method='post'>";
    echo "<p>Select a category:</p>";
    foreach ($categories as $category) {
      echo "<label><input type='radio' name='category' value='" . $category . "'> " . $category . "</label><br>";
    }
    echo "<br><input type='submit' value='Submit'>";
    echo "</form>";

  }

}

// Delete the cookie
if (isset($_POST['delete_cookie'])) {
  setcookie('news_category', '', time() - 3600, '/');
  echo "The cookie has been deleted. Please refresh the page.";
}

// Show the logout button to the user
echo "<form method='post'>";
echo "<br><input type='submit' name='delete_cookie' value='Logout'>";
echo "</form>";
