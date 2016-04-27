<?php

namespace Droid\Plugin\HipChat\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use RuntimeException;
use HipChat\HipChat;

class HipChatRoomMessageCommand extends Command
{
    public function configure()
    {
        $this->setName('hipchat:room-message')
            ->setDescription('Sends a HipChat message to a room')
            ->addArgument(
                'token',
                InputArgument::REQUIRED,
                'Your API token'
            )
            ->addArgument(
                'room',
                InputArgument::REQUIRED,
                'Room Name or ID'
            )
            ->addArgument(
                'message',
                InputArgument::REQUIRED,
                'Message to send'
            )
            ->addOption(
                'notify',
                null,
                InputOption::VALUE_NONE,
                'Whether or not this message should trigger a notification for people in the room'
            )
            ->addOption(
                'color',
                'c',
                InputOption::VALUE_REQUIRED,
                'Background color for message. One of yellow, red, green, purple, gray, or random. (default: yellow)'
            )
        ;
    }
    
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $token = $input->getArgument('token');
        $room = $input->getArgument('room');
        $message = $input->getArgument('message');
        $from = 'Droid';
        
        if (strlen($from)>15) {
            throw new RuntimeException('From-name may be maximum 15 characters');
        }
        $notify = false;
        if ($input->getOption('notify')) {
            $notify = true;
        }
        $color = null;
        if ($input->getOption('color')) {
            $color = $input->getOption('color');
        }
        $client = new HipChat($token);
        $res = $client->message_room(
            $room,
            $from,
            $message,
            $notify,
            $color
        );
        if (!$res) {
            throw new RuntimeException("Message not sent");
        }
        
    }
}
