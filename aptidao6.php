<?php
require_once _DIR_ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

// Conecta ao servidor RabbitMQ
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

// Declara uma fila
$queueName = 'hello';
$channel->queue_declare($queueName, false, false, false, false);

// Cria uma mensagem com um identificador único
$messageData = [
    'id' => uniqid(),
    'content' => 'Hello, RabbitMQ!'
];
$messageBody = json_encode($messageData);
$message = new AMQPMessage($messageBody, ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);

// Publica a mensagem na fila
$channel->basic_publish($message, '', $queueName);

echo " [x] Sent '{$messageBody}'\n";

// Fecha o canal e a conexão
$channel->close();
$connection->close();

?>
