<?php

namespace App\serializer;

use Enqueue\RdKafka\Serializer;
use Enqueue\RdKafka\RdKafkaMessage;

class FooSerializer implements Serializer {

public function toMessage($string) {

}

public function toString(RdKafkaMessage $message) {

}
/** @var \Enqueue\RdKafka\RdKafkaContext $psrContext */
//$psrContext->setSerializer(new FooSerializer());
}
