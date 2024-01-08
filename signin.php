<?php

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

session_start();

$clientId = $_ENV['CLIENT_ID'];
$clientSecret = $_ENV['CLIENT_SECRET'];
$redirectUri = "{$_ENV['APP_OAUTH2_URL']}/signin.php";
$appUrl = $_ENV['APP_URL'];

if (isset($_GET['getcode'])) {
  $_SESSION['getcode'] = true;
}

$provider = new \League\OAuth2\Client\Provider\GenericProvider([
  'clientId'                => $clientId,
  'clientSecret'            => $clientSecret,
  'redirectUri'             => $redirectUri,
  'urlAuthorize'            => "{$appUrl}/oauth/authorize",
  'urlAccessToken'          => "{$appUrl}/oauth/token",
  'urlResourceOwnerDetails' => "{$appUrl}/oauth/users",
]);

// If we don't have an authorization code then get one
if (!isset($_GET['code'])) {

  $options = [
    // 'scope' => ['openid email profile offline_access accounting.transactions accounting.settings accounting.contacts']
    'scope' => null,
  ];

  // Fetch the authorization URL from the provider; this returns the
  // urlAuthorize option and generates and applies any necessary parameters (e.g. state).
  $authorizationUrl = $provider->getAuthorizationUrl($options);

  // Get the state generated for you and store it to the session.
  $_SESSION['oauth2state'] = $provider->getState();

  // Redirect the user to the authorization URL.
  header('Location: ' . $authorizationUrl);
  exit();

  // Check given state against previously stored one to mitigate CSRF attack
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
  unset($_SESSION['oauth2state']);
  exit('Invalid state');

  // Redirect back with code in query string param
} else {

  try {
    //echo '<pre>';
    //echo '_GET: ' . print_r($_GET, true) . "<hr />";
    //die();

    // password
    // authorization_code
    // client_credentials
    // refresh_token
    // personal_access

    if (isset($_SESSION['getcode'])) {
      echo "<h1>Congrats with code only</h1>";

      echo '<textarea style="width:100%;padding:20px;height:200px;">';
      echo $_GET['code'];
      echo '</textarea>';
      die();
    }

    // Try to get an access token using the authorization code grant.
    $accessToken = $provider->getAccessToken('authorization_code', [
      'code' => $_GET['code'],
    ]);
  } catch (Exception $e) {
    // Failed to get the access token or user details.
    echo '<pre>';
    echo $e->getMessage();
    echo "\n\n";
    echo print_r($e, true);
    exit();
  }
}

?>
<html>

<head>
  <title>php oauth2 example</title>
  <style>
    textarea {
      border: 1px solid #999999;
      width: 75%;
      height: 75%;
      margin: 5px 0;
      padding: 3px;
    }
  </style>
</head>

<body>
  <h1>Congrats Success!</h1>

  <?php

  echo "access token: " . $accessToken->getToken() . "<hr />";
  echo "refresh token: " . $accessToken->getRefreshToken() . "<hr />";

  ?>

</body>

</html>