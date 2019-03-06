<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\UI;

interface TableRendererInterface
{
    public function renderRow(array $row);
    public function renderTable(array $table): string;
}