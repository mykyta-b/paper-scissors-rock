<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG;


use PSRG\Core\Builder\GameBuilder;
use PSRG\Core\Builder\PlayersBuilder;
use PSRG\Core\Config\ConfigParser;
use PSRG\Core\Config\ConfigValidationDecorator;
use PSRG\Core\State\GameState;
use PSRG\Mechanics\Commands\Begin;
use PSRG\Mechanics\Commands\Draw;
use PSRG\Mechanics\Commands\End;
use PSRG\Mechanics\Commands\Error;
use PSRG\Mechanics\Commands\Play;
use PSRG\Mechanics\Commands\Play\AutoPlayer;
use PSRG\Mechanics\Commands\Play\PlayerTurn;
use PSRG\Mechanics\Commands\Win;
use PSRG\Mechanics\CommandsStrategy;
use PSRG\Mechanics\GameStateAnalyzer;
use PSRG\UI\InputReader;
use PSRG\UI\InputRequest;
use PSRG\UI\InputRequestInterface;
use PSRG\UI\Renderer;
use PSRG\UI\RendererInterface;
use PSRG\UI\TableRenderer;

class DI
{
    public function createGameState()
    {
        return new GameState();
    }

    public function createCommandsStrategy()
    {
        return new CommandsStrategy(
            [
                $this->createBeginCommand(),
                $this->createPlayCommand(),
                $this->createWinCommand(),
                $this->createDrawCommand()
            ],
            $this->createDefaultCommand()
        );
    }

    public function createConfigParserDecorator()
    {
        return new ConfigValidationDecorator(
            $this->createConfigParser()
        );
    }

    protected function createBeginCommand()
    {
        return new Begin(
            $this->createRenderer(),
            $this->createInputRequest()
        );
    }


    public function createPlayersBuilder()
    {
        return new PlayersBuilder();
    }

    protected function createDefaultCommand()
    {
        return new Error(
            $this->createRenderer()
        );
    }

    protected function createPlayCommand()
    {
        return new Play(
            $this->createRenderer(),
            $this->createInputRequest(),
            $this->createAutoPlayer(),
            $this->createGameStateAnalyzer()
        );
    }

    public function createGameOverCommand()
    {
        return new End(
            $this->createRenderer()
        );
    }

    public function createRenderer(): RendererInterface
    {
        return new Renderer(
            $this->createTableRenderer()
        );
    }

    protected function createInputRequest(): InputRequestInterface
    {
        return new InputRequest(
            $this->createInputReader(),
            $this->createRenderer()
        );
    }

    protected function createInputReader()
    {
        return new InputReader();
    }

    protected function createAutoPlayer()
    {
        return new PlayerTurn(
            $this->createRenderer(),
            $this->createInputRequest(),
            $this->createComputerTurnMaker()
        );
    }

    protected function createGameStateAnalyzer()
    {
        return new GameStateAnalyzer();
    }

    protected function createWinCommand()
    {
        return new Win(
            $this->createRenderer()
        );
    }

    protected function createDrawCommand()
    {
        return new Draw(
            $this->createRenderer()
        );
    }

    public function createComputerTurnMaker()
    {
        return new AutoPlayer(

        );
    }

    /**
     * @return ConfigParser
     */
    protected function createConfigParser(): ConfigParser
    {
        return new ConfigParser();
    }

    protected function createTableRenderer()
    {
        return new TableRenderer();
    }

    public function createGameBuilder()
    {
        return new GameBuilder(
            $this->createPlayersBuilder()
        );
    }
}
