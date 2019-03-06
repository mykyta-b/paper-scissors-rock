<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Tests\Functional\Mechanics\Commands;


use PSRG\Core\Builder\BoardBuilderInterface;
use PSRG\Core\DTO\BoardDTO;
use PSRG\Core\DTO\PlayerDTO;
use PSRG\Mechanics\Commands\Play;
use PSRG\Mechanics\Commands\Play\PlayerTurn;
use PSRG\Mechanics\GameStateAnalyzer;
use PSRG\UI\InputRequestInterface;
use PSRG\UI\RendererInterface;

class PlayCommandForTests extends Play
{
    protected $playerTurns;

    public function __construct(
        RendererInterface $renderer,
        InputRequestInterface $inputRequest,
        BoardBuilderInterface $boardBuilder,
        PlayerTurn $turnMaker,
        GameStateAnalyzer $gameStateAnalyzer,
        $playerTurns
    ) {
        $this->renderer = $renderer;
        $this->inputRequest = $inputRequest;
        $this->boardBuilder = $boardBuilder;
        $this->turnMaker = $turnMaker;
        $this->gameStateAnalyzer = $gameStateAnalyzer;
        parent::__construct($renderer, $inputRequest, $boardBuilder, $turnMaker, $gameStateAnalyzer);
        $this->playerTurns = $playerTurns;
    }

    protected function getNextTurn(PlayerDTO $player, BoardDTO $boardDTO): string
    {
        return $this->playerTurns[$player->getAlias()];
    }

    /**
     * @param int $param
     * @param BoardDTO $boardDTO
     * @return bool
     * @throws GameIsHangingTestException
     */
    protected function gameIsNotHung(int $param, BoardDTO $boardDTO): bool
    {
        $maxNumberOfTurns = count($boardDTO->getBoard()) * count($boardDTO->getBoard());
        if ($param > $maxNumberOfTurns) {
            throw new GameIsHangingTestException ('Game is hunging');
        }

        return true;
    }
}
