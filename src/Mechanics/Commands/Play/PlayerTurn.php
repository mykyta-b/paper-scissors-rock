<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Mechanics\Commands\Play;


use PSRG\Core\DTO\BoardDTO;
use PSRG\Core\DTO\PlayerDTO;
use PSRG\Mechanics\MechanicsConstants;
use PSRG\UI\InputRequestInterface;
use PSRG\UI\RendererInterface;

class PlayerTurn implements PlayerTurnInterface
{
    const DEMONSTRATE_RESULT_FOR_2_SECONDS = 2;
    /**
     * @var RendererInterface
     */
    protected $renderer;

    /**
     * @var InputRequestInterface
     */
    protected $inputRequest;

    protected $turnMethod = [
        MechanicsConstants::PLAYER_TYPE_COMPUTER => 'getComputerPlayerTurn',
        MechanicsConstants::PLAYER_TYPE_HUMAN => 'getHumanPlayerTurn'
    ];

    /**
     * @var AutoPlayer
     */
    protected $computerTurnMaker;

    /**
     * @param RendererInterface $renderer
     * @param InputRequestInterface $inputRequest
     * @param AutoPlayer $computerTurnMaker
     */
    public function __construct(
        RendererInterface $renderer,
        InputRequestInterface $inputRequest,
        AutoPlayer $computerTurnMaker
    ) {
        $this->renderer = $renderer;
        $this->inputRequest = $inputRequest;
        $this->computerTurnMaker = $computerTurnMaker;
    }

    /**
     * @param PlayerDTO $player
     * @return string
     */
    public function getNextTurn(PlayerDTO $player): string
    {
        $method = $this->turnMethod[$player->getType()];
        return $this->$method($player);
    }

    /**
     * @param PlayerDTO $player
     * @return string
     */
    protected function getHumanPlayerTurn(PlayerDTO $player): string
    {
        $userResponse = $this->inputRequest->requestInput(
            vsprintf("Player %s make your turn P(paper),R(rock),S(scissors):", [$player->getAlias()]) ,
            $this->getAvailableTurns()
        );

        return $userResponse;
    }

    /**
     * @param PlayerDTO $player
     * @return string
     */
    protected function getComputerPlayerTurn(PlayerDTO $player): string
    {
        $turn = $this->computerTurnMaker->getNextTurn($player);

        return $turn;
    }

    private function getAvailableTurns()
    {
        return MechanicsConstants::PLAYER_TURN_OPTIONS;
    }
}
