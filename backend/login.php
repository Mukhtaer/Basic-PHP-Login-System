<?php

session_start();

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Get the submitted credentials
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Connect to the database
  $conn = new mysqli('localhost', 'username', 'password', 'database_name');

  // Check for connection errors
  if ($conn->connect_error) {
    echo json_encode([
      'success' => false,
      'message' => 'Database connection error'
    ]);
    exit();
  }

  // Prepare the query
  $stmt = $conn->prepare('SELECT * FROM users WHERE username = ?');

  // Bind the username parameter
  $stmt->bind_param('s', $username);

  // Execute the query
  $stmt->execute();

  // Get the query result
  $result = $stmt->get_result();

  // Check if the username exists in the database
  if ($result->num_rows === 1) {

    // Fetch the user data
    $row = $result->fetch_assoc();

    // Verify the password
    if (password_verify($password, $row['password'])) {

      // Set the user session
      $_SESSION['user'] = $username;

      // Return a success JSON response
      echo json_encode([
        'success' => true,
        'message' => 'Login successful'
      ]);

    } else {

      // Return an error JSON response
      echo json_encode([
        'success' => false,
        'message' => 'Invalid username or password'
      ]);

    }

  } else {

    // Return an error JSON response
    echo json_encode([
      'success' => false,
      'message' => 'Invalid username or password'
    ]);

  }

  // Close the statement and database connection
  $stmt->close();
  $conn->close();

} else {
  
  // Return a bad request JSON response
  http_response_code(400);
  echo json_encode([
    'success' => false,
    'message' => 'Bad request'
  ]);

}
