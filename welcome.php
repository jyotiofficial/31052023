<?php

//index.php

// Include Configuration File
require_once 'config.php';

$login_button = '';

if (isset($yourArray['access_token'])) {
  // Access the value of "access_token" here
  $accessToken = $yourArray['access_token'];
  if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);
  
    // Get profile info
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();
    $userinfo = [
      'email' => $google_account_info['email'],
      'first_name' => $google_account_info['givenName'],
      'last_name' => $google_account_info['familyName'],
      'gender' => $google_account_info['gender'],
      'full_name' => $google_account_info['name'],
      'picture' => $google_account_info['picture'],
      'verifiedEmail' => $google_account_info['verifiedEmail'],
      'token' => $google_account_info['id'],
    ];
  
    // Checking if user already exists in the database
    $sql = "SELECT * FROM users WHERE email ='{$userinfo['email']}'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
      // User already exists
      $userinfo = mysqli_fetch_assoc($result);
      $welcome_message = "Welcome, " . $userinfo['first_name'] . " " . $userinfo['last_name'];
      
      $token = $userinfo['token'];
    } else {
      // User does not exist, insert into database
      $sql = "INSERT INTO users (email, first_name, last_name, gender, full_name, picture, verifiedEmail, token) VALUES ('{$userinfo['email']}', '{$userinfo['first_name']}', '{$userinfo['last_name']}', '{$userinfo['gender']}', '{$userinfo['full_name']}', '{$userinfo['picture']}', '{$userinfo['verifiedEmail']}', '{$userinfo['token']}')";
      $result = mysqli_query($conn, $sql);
      if ($result) {
        $token = $userinfo['token'];
        $welcome_message = "Welcome, " . $userinfo['first_name'] . " " . $userinfo['last_name'];
      } else {
        echo "User is not created";
        die();
      }
    }
  
    // Save user data into session
    $_SESSION['user_token'] = $token;
    // Rest of your code
  } else {
    // Handle the case when "access_token" is not defined in the array
    // Additional code or error handling can be placed here
    if (!isset($_SESSION['user_token'])) {
      header("Location: index.php");
      die();
    }

    // Checking if user already exists in the database
    $sql = "SELECT * FROM users WHERE token ='{$_SESSION['user_token']}'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
      // User exists
      $userinfo = mysqli_fetch_assoc($result);
      // Welcome message with username
      $welcome_message = "Welcome, " . $userinfo['first_name'] . " " . $userinfo['last_name'];
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome</title>
</head>

<body>
  <?php if(isset($welcome_message)): ?>
    <h1><?= $welcome_message ?></h1>
    <img src="<?= $userinfo['picture'] ?>" alt="" width="90px" height="90px">
    <ul>
      <li>Full Name: <?= $userinfo['full_name'] ?></li>
      <li>Email Address: <?= $userinfo['email'] ?></li>
      <li>Gender: <?= $userinfo['gender'] ?></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  <?php endif; ?>
</body>

</html>