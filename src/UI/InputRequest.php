<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\UI;


class InputRequest implements InputRequestInterface
{
    /**
     * @var InputReader
     */
    protected $inputReader;

    /**
     * @var RendererInterface
     */
    protected $renderer;

    /**
     * @param InputReader $inputReader
     * @param RendererInterface $renderer
     */
    public function __construct(
        InputReader $inputReader,
        RendererInterface $renderer
    ) {
        $this->inputReader = $inputReader;
        $this->renderer = $renderer;
    }

    /**
     * @param string $inputTip
     * @param array $possibleOptions
     * @return string
     */
    public function requestInput(string $inputTip, array $possibleOptions): string
    {
        $this->renderer->renderPhrase($inputTip);
        $userResponse = $this->inputReader->readInput();
        $userResponse = $this->formatUserResponse($userResponse);

        while (!in_array($userResponse, $possibleOptions))  {
            vprintf("%sYour response does not match required input options:%s%s %s", [
                PHP_EOL,
                PHP_EOL,
                $this->formatPossibleOptions($possibleOptions),
                PHP_EOL
            ]);

            $userResponse = $this->formatUserResponse($this->inputReader->readInput());
        }

        return $userResponse;
    }

    /**
     * @param $possibleOptions
     * @return string
     */
    protected function formatPossibleOptions($possibleOptions)
    {
        return implode(" ", $possibleOptions);

    }

    /**
     * @param $userResponse
     * @return string
     */
    protected function formatUserResponse($userResponse): string
    {
        return !empty($userResponse) ? mb_strtoupper($userResponse) : $userResponse;
    }
}
