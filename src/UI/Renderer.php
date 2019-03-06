<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\UI;


use PSRG\Core\DTO\PlayerDTO;

class Renderer implements RendererInterface
{
    /**
     * @var TableRendererInterface
     */
    protected $tableRenderer;

    public function __construct(TableRendererInterface $tableRenderer)
    {
        $this->tableRenderer = $tableRenderer;
    }

    /**
     * @param PlayerDTO[] $players
     * @return string
     */
    public function renderPlayers(array $players)
    {
        $this->renderPhrase('Players');

        $output[] = [
            'Player Alias',
            'Player Name',
            'Player Type',
            'Player Strategy',
        ];

        foreach ($players as  $player) {
            $output[] =
                [
                    $player->getAlias(),
                    $player->getName(),
                    $player->getType(),
                    $player->getStrategy(),
                ]
            ;

        }

        echo $this->tableRenderer->renderTable($output);
    }


    /**
     * @param PlayerDTO[] $players
     * @return void
     */
    public function renderGameResult(array $players): void
    {
        $this->renderPhrase('Players');

        $output[] = [
            'Player Name',
            'Player',
            'Player Strategy',
            'Player Turn',
        ];

        foreach ($players as  $player) {
            $output[] =
                [
                    $player->getName(),
                    $player->getType(),
                    $player->getStrategy(),
                    $player->getTurn(),
                ]
            ;

        }

        echo $this->tableRenderer->renderTable($output);
    }

    public function renderSeparator(): void
    {
        vprintf("%s%s%s%s", [
           PHP_EOL,
           PHP_EOL,
           str_repeat("-", 40),
           PHP_EOL,
        ]);
    }

    /**
     * @param string $phrase
     */
    public function renderPhrase(string $phrase): void
    {
        vprintf("%s%s%s", [
            PHP_EOL,
            $phrase,
            PHP_EOL,
        ]);
    }
}
