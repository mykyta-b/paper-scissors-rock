<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Mechanics;


use PSRG\Core\State\GameStateInterface;
use PSRG\Mechanics\Commands\CommandInterface;

class CommandsStrategy
{
    /**
     * @var CommandInterface[]
     */
    protected $commands;

    /**
     * @var CommandInterface
     */
    protected $defaultCommand;

    /**
     * @param $commands CommandInterface[]
     * @param $defaultCommand CommandInterface
     */
    public function __construct(
        $commands,
        $defaultCommand
    ) {
        $this->commands = $commands;
        $this->defaultCommand = $defaultCommand;
    }

    /**
     * @param string $currentGameState
     * @return CommandInterface
     */
    public function pickCommand(string $currentGameState): CommandInterface
    {
        foreach ($this->commands as $command) {
            if ($command->shouldBeRunWithGameState($currentGameState)) {
                return $command;
            }
        }

        return $this->defaultCommand;
    }
}
