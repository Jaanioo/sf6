<?php

namespace App\Tests;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AddNewGameTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail('jan.palen971@gmail.com');

        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/game/new');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h3', 'Add');
    }
}
