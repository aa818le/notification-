<?php
require __DIR__ . '/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

// serviceAccountKey.json faylingizni chaqiring
$factory = (new Factory)->withServiceAccount(__DIR__.'/serviceAccountKey.json')
                        ->withDatabaseUri('https://giper-8fd92-default-rtdb.firebaseio.com');

$database = $factory->createDatabase();
$messaging = $factory->createMessaging();

// Admin.html dan kelgan POST
$data = json_decode(file_get_contents("php://input"), true);
$title = $data['title'] ?? 'No title';
$body = $data['message'] ?? 'No message';

// Barcha tokenlarni olish
$tokensRef = $database->getReference("NOTIFICATION")->getValue();

if (!$tokensRef) {
    die("Token topilmadi!");
}

$tokens = array_keys($tokensRef);

$notification = Notification::create($title, $body);

$messages = [];
foreach ($tokens as $token) {
    $messages[] = CloudMessage::withTarget('token', $token)->withNotification($notification);
}

try {
    $messaging->sendAll($messages);
    echo "Yuborildi: ".count($messages)." ta foydalanuvchiga";
} catch (Exception $e) {
    echo "Xato: ".$e->getMessage();
}
