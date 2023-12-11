<?php
// delete_task.php

$servername = "localhost";
$username = "bit_academy";
$password = "bit_academy";
$dbname = "groot";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Extract task ID from the AJAX request
  $requestData = json_decode(file_get_contents("php://input"));
  $taskId = $requestData->taskId;

  // Delete the task from the database
  $deleteSql = "DELETE FROM tasks WHERE id = :taskId";
  $deleteStmt = $conn->prepare($deleteSql);
  $deleteStmt->bindParam(":taskId", $taskId, PDO::PARAM_INT);
  $deleteStmt->execute();
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
} finally {
  $conn = null;
}
