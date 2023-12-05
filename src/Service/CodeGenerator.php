<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;

class CodeGenerator
{

    public function __construct(
        private readonly Filesystem $filesystem,
        private readonly string $codePrefix,
        private readonly CodeCreatorDecorator $codeCreator,
    ) {
    }

    public function generate(): string
    {
        $code = $this->codeCreator->createCode($this->codePrefix);

        $this->filesystem->mkdir('codes');
        $this->filesystem->touch('codes/'.$code.'.txt');
        file_put_contents('codes/'.$code.'.txt', $code);

        return $code;
    }

    public function pickRandomGames(): array
    {
        $topGames = [
            'CS',
            'LOL',
            'CSGO',
            'PUBG',
            'WITCHER',
            'CYBERPUNK 2077',
            'TFT',
            'POKEMON FIRE RED',
            'POKEMON FIRE BLUE',
            'POKEMON FIRE GOLD',
        ];

        $topPickedGames = [];

        if (!empty($topGames)) {
            for ($i = 0; $i < 5; $i++) {
                $randomIndex = array_rand($topGames);
                $pickedGame = $topGames[$randomIndex];
                $topPickedGames[] = $pickedGame;

                array_splice($topGames, $randomIndex, 1);
            }
        }

        return $topPickedGames;
    }
}