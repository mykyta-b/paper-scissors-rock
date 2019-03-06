<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Mechanics\Commands;



use PSRG\Core\DTO\GameDTO;
use PSRG\Core\State\GameStateInterface;
use PSRG\Mechanics\MechanicsConstants;
use PSRG\UI\InputRequestInterface;
use PSRG\UI\RendererInterface;

class Begin extends CommandTemplate
{
    const OPTIONS = [
        "Y" => MechanicsConstants::PLAY,
        "N" => MechanicsConstants::END,
    ];

    /**
     * @var string
     */
    protected $commandState = MechanicsConstants::BEGIN;

    /**
     * @var RendererInterface
     */
    protected $renderer;

    /**
     * @var InputRequestInterface
     */
    protected $inputRequest;

    public function __construct(
        RendererInterface $renderer,
        InputRequestInterface $inputRequest
    ) {
        $this->renderer = $renderer;
        $this->inputRequest = $inputRequest;
    }

    public function execute(GameDTO $gameDTO, GameStateInterface $gameState): void
    {

        $this->renderer->renderPlayers($gameDTO->getPlayers());

        $userResponse = $this->inputRequest->requestInput(
            "Do you agree to proceed with these settings Y/N (Y - proceed, N - exit game)?",
            array_keys(static::OPTIONS)
        );

        $gameState->changeState(static::OPTIONS[$userResponse]);
        $gameDTO->setState(static::OPTIONS[$userResponse]);
    }
}
