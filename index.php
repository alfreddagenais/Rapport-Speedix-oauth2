<?php

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

session_start();


?><html>

<head>
  <title><?php echo $_ENV['APP_NAME']; ?> - php oauth2 example</title>
</head>

<body>
  <br /><br />
  <a href="signin.php">Sign-In</a>
  <br /><hr /><br />
  <a href="signin.php?getcode=true">Sign-In, but get code Only</a>
</body>

</html>