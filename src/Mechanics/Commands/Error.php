<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Mechanics\Commands;


use PSRG\Core\DTO\GameDTO;
use PSRG\Core\State\GameStateInterface;
use PSRG\Mechanics\MechanicsConstants;
use PSRG\UI\RendererInterface;

class Error extends CommandTemplate
{

    /**
     * @var RendererInterface
     */
    protected $renderer;

    public function __construct(RendererInterface $renderer) {
        $this->renderer = $renderer;
    }

    public function execute(GameDTO $gameDTO, GameStateInterface $gameState): void
    {
        $this->renderer->renderSeparator();
        $this->renderer->renderPhrase("Something went wrong! Abnormal program termination");

        $gameState->changeState(MechanicsConstants::END);
        $gameDTO->setState(MechanicsConstants::END);
    }
}
