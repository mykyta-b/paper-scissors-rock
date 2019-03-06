<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Tests\Unit\UI;


use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use PSRG\UI\InputReader;
use PSRG\UI\InputRequest;
use PSRG\UI\RendererInterface;

class InputRequestTest extends TestCase
{
    public function testPositiveRequestInput(): void
    {
        $inputReader = $this->getInputReaderMock();

        $renderer = $this->getRendererMock();

        $inputRequest = new InputRequest($inputReader, $renderer);

        $input = $inputRequest->requestInput("Input tip", ["S", "R", "P"]);

        $this->assertEquals($input, "S");

    }

    public function testBadRequestInput(): void
    {

        $inputReader = $this->getInputReaderMockWithIncorrectResponse();

        $renderer = $this->getRendererMock();

        $inputRequest = new InputRequest($inputReader, $renderer);

        ob_start();
        $input = $inputRequest->requestInput("Input tip", ["S", "R", "P"]);
        $response = ob_get_clean();
        $this->assertEquals(1, preg_match("~Your response does not match required input options~", $response));
        $this->assertEquals($input, "R");

    }

    /**
     * @return MockObject
     */
    protected function getRendererMock(): MockObject
    {
        $renderer = $this->createMock(RendererInterface::class);
        $renderer->expects($this->once())
            ->method('renderPhrase')->willReturn(
                ""
            );
        return $renderer;
    }

    /**
     * @return MockObject
     */
    protected function getInputReaderMock(): MockObject
    {
        $inputReader = $this->createMock(Inputreader::class);
        $inputReader->expects($this->once())
        ->method('readInput')->willReturn(
            "S"
        );
        return $inputReader;
    }

    /**
     * @return MockObject
     */
    protected function getInputReaderMockWithIncorrectResponse(): MockObject
    {
        $inputReader = $this->createMock(Inputreader::class);
        $inputReader
            ->expects($this->at(0))
            ->method('readInput')
            ->willReturn("incorrect");

        $inputReader->expects($this->at(1))
            ->method('readInput')
            ->willReturn("R");
        return $inputReader;
    }
}
