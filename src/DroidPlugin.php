<?php

namespace Droid\Plugin\HipChat;

class DroidPlugin
{
    public function __construct($droid)
    {
        $this->droid = $droid;
    }
    
    public function getCommands()
    {
        $commands = [];
        $commands[] = new \Droid\Plugin\HipChat\Command\HipChatRoomMessageCommand();
        return $commands;
    }
}
