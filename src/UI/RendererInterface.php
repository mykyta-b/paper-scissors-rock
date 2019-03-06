<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\UI;

use PSRG\Core\DTO\PlayerDTO;

interface RendererInterface
{
    /**
     * @param PlayerDTO[] $players
     */
    public function renderPlayers(array $players);

    public function renderSeparator(): void;

    public function renderPhrase(string $phrase): void;

    /**
     * @param PlayerDTO[] $players
     * @return void
     */
    public function renderGameResult(array $players): void;
}
