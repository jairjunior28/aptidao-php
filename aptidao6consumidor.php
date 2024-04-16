<?php
/**
 * Para garantir que a mensagem foi devidamente processada:Confirmações de Entrega
 * (Acknowledgments):Após o consumidor processar a mensagem, ele envia um acknowledgment
 *  para o RabbitMQ.Se o RabbitMQ não receber um acknowledgment dentro de um determinado
 * período, ele pode reenviar a mensagem para outro consumidor.Você pode usar o método
 * basic_ack do canal para enviar um acknowledgment para o RabbitMQ.Aqui está um exemplo
 * básico de como criar um consumidor que confirma as mensagens
 */
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
