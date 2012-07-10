<?php
class Messaging
{
    private static $_messages = array();
    
    public static function getMessages()
    {
        return self::$_messages;
    }

    public static function setMessages(Message $message)
    {
        self::$_messages[] = $message;
    }


}