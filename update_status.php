<?php
$servername = "localhost";
$username = "bit_academy";
$password = "bit_academy";
$dbname = "groot";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // Set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["taskId"])) {
  $taskId = $_POST["taskId"];

  // Update the task's status to "done" in the database
  $updateSql = "UPDATE tasks SET status = 'done' WHERE id = :taskId";
  $updateStmt = $conn->prepare($updateSql);
  $updateStmt->bindParam(":taskId", $taskId, PDO::PARAM_INT);

  try {
    $updateStmt->execute();
    // Redirect back to the page where the task was clicked
    header("Location: " . $_SERVER["HTTP_REFERER"]);
    exit;
  } catch (PDOException $e) {
    // Handle errors as needed
  }
}
