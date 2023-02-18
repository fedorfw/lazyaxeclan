<?php

namespace botCases;

class helloWorld
{
    public function sayHello($message)
    {
        $res = 'ты написал "' . $message . '", но я не понял';
        return $res;
    }
}
