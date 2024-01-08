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
  <a href="signin.php">signin</a>
</body>

</html>