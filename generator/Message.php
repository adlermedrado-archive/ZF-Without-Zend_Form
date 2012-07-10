<?php
class Message
{
    private $message;
    
    public function __construct($message)
    {
        $this->setMessage($message);
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }
}