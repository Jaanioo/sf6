<?php

namespace App\MessageHandler;

use App\Message\SendKey;
use App\Repository\UserRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class SendKeyHandler
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {
    }

    public function __invoke(SendKey $message)
    {
        throw new \RecoverableMessageHandlingException('test');

        $user = $this->userRepository->find($message->getUserId());

        if (!$user) {
            return;
        }

        $this->sendEmail($user->getEmail(), $this->getKey());
    }

    private function sendEmail(string $email, int $key)
    {
        file_put_contents('email'.$key.'.txt', $email . ' ' . $key);
    }

    private function getKey(): int
    {
        sleep(5);
        return random_int(1000, 9999);
    }
}