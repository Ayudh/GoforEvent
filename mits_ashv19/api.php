<?php
require_once '../vendor/autoload.php';
// Create and configure Slim app
$config = ['settings' => [
    'addContentLengthHeader' => false,
]];
$app = new \Slim\App($config);

// Define app routes
$app->get('/hello/{email}', function ($request, $response, $args) {
    $email = $args['email'];
    require_once './db/db.php';
  $db = new db();
  $conn = $db->connect();
  $sql = "select * from ashv_cse_events where people_email=:people_email";
  $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
  $stmt->execute(array(':people_email' => $email));
  $result = $stmt->fetchAll();
  echo json_encode($result);
});

// Run app
$app->run();