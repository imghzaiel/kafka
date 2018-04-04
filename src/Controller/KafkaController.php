<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Enqueue\RdKafka\RdKafkaConnectionFactory;

class KafkaController extends Controller {

    /**
     * @Route("/kafka", name="kafka")
     */
    public function Createcontext() {
        //Create context
        $connectionFactory = new RdKafkaConnectionFactory();
        $connectionFactory = new RdKafkaConnectionFactory('kafka:');
        $connectionFactory = new RdKafkaConnectionFactory([]);
        $connectionFactory = new RdKafkaConnectionFactory([
            'global' => [
                'group.id' => uniqid('', true),
                'metadata.broker.list' => 'example.com:1000',
                'enable.auto.commit' => 'false',
            ],
            'topic' => [
                'auto.offset.reset' => 'beginning',
            ],
        ]);
        $psrContext = $connectionFactory->createContext();
        $psrContext = \Enqueue\dsn_to_context('kafka:');
    }

    public function SendMessageToTopic() {
        /** @var \Enqueue\RdKafka\RdKafkaContext $psrContext */
        $message = $psrContext->createMessage('Hello world!');
        $fooTopic = $psrContext->createTopic('foo');
        $psrContext->createProducer()->send($fooTopic, $message);
    }

    public function SendMessageToQueue() {
        /** @var \Enqueue\RdKafka\RdKafkaContext $psrContext */
        $message = $psrContext->createMessage('Hello world!');
        $fooQueue = $psrContext->createQueue('foo');
        $psrContext->createProducer()->send($fooQueue, $message);
    }

    public function ConsumeMessage() {
        /** @var \Enqueue\RdKafka\RdKafkaContext $psrContext */
        $fooQueue = $psrContext->createQueue('foo');
        $consumer = $psrContext->createConsumer($fooQueue);

        $message = $consumer->receive();

        $consumer->acknowledge($message);
    }

    public function ChangeOffset() {
        /** @var \Enqueue\RdKafka\RdKafkaContext $psrContext */
        $fooQueue = $psrContext->createQueue('foo');

        $consumer = $psrContext->createConsumer($fooQueue);
        $consumer->setOffset(123);

        $message = $consumer->receive(2000);
    }

}
