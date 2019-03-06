<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

use PSRG\DI;

define('ROOT_DIR', dirname(__FILE__));
define('CONFIG_PATH', ROOT_DIR. '/config/game.ini');

include ROOT_DIR. '/vendor/autoload.php';

$container = new DI();
$gameSettingsDTO = $container->createConfigParserDecorator()->parseConfigFile(CONFIG_PATH);
$gameDTO = $container->createGameBuilder()->buildGameDTO($gameSettingsDTO);
$gameState = $container->createGameState();
$gameStateCommandsStrategy = $container->createCommandsStrategy();

do {
    $command = $gameStateCommandsStrategy->pickCommand($gameState->getCurrentState());
    $command->execute($gameDTO, $gameState);

} while($gameState->gameNotOver());

$container->createGameOverCommand()->execute($gameDTO, $gameState);

