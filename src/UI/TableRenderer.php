<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\UI;


class TableRenderer implements TableRendererInterface
{

    /**
     * @param array $table
     * @return string
     */
    public function renderTable(array $table): string
    {
        $maxLeng = $this->findMaxCellValueLength($table);
        return $this->renderRowByRow($table, $maxLeng);
    }

    /**
     * @param array $row
     * @param int $padLength
     * @return string
     */
    public function renderRow(array $row, $padLength = 2): string
    {
        $output = [];
        foreach ($row as $cell) {
            $output[] = $this->stringPad($cell, $padLength);
        }

        return vsprintf("%s%s%s", [
            "|",
            implode("|", $output),
            "|"
            ]
        );
    }

    /**
     * @param $input
     * @param $padLength
     * @param string $padString
     * @return string
     */
    protected  function stringPad($input, $padLength, $padString = ' ') {
        $encoding = mb_internal_encoding();
        $diff = mb_strlen($input) - mb_strlen($input, $encoding);
        return str_pad($input, $padLength + $diff, $padString, STR_PAD_BOTH);
    }

    /**
     * @param array $table
     * @return int
     */
    protected function findMaxCellValueLength(array $table): int
    {
        $maxLen = 1;

        foreach ($table as $row) {
            foreach ($row as $cellValue) {
                $cellLen = mb_strlen($cellValue);
                if ($cellLen > $maxLen) {
                    $maxLen = $cellLen;
                }
            }
        }

        $extendsMaxLengthFor2Symbols = 2;
        return $maxLen + $extendsMaxLengthFor2Symbols;
    }

    /**
     * @param array $table
     * @param $maxLeng
     * @return string
     */
    protected function renderRowByRow(array $table, $maxLeng): string
    {
        $output = [];
        foreach ($table as $row) {
            $renderedRow = $this->renderRow($row, $maxLeng);
            $output[] = $renderedRow;
        }

        $rowSeparator = $this->getRowSeparator($row, $maxLeng);

        return vsprintf(PHP_EOL . "%s" . PHP_EOL . "%s" . PHP_EOL . "%s" . PHP_EOL, [
                $rowSeparator,
                implode(PHP_EOL . "$rowSeparator" . PHP_EOL, $output),
                $rowSeparator
            ]
        );
    }

    /**
     * The function draws a line between cells
     *
     * @param array $row
     * @param int $maxLength
     * @return string
     */
    protected function getRowSeparator(array $row, int $maxLength): string
    {
        $cellSeparator = str_repeat('-', $maxLength );
        $cellSeparators = [];
        for($i =0 ; $i < count($row); $i++) {
            $cellSeparators[] = $cellSeparator;
        }

        return '+' . implode('+', $cellSeparators) . '+';
    }
}
