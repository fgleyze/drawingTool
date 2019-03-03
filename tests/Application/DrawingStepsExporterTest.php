<?php

use PHPUnit\Framework\TestCase;
use  Drawing\Application\DrawingStepsExporter;
use Drawing\Infrastructure\FileManager;

final class DrawingStepsExporterTest extends TestCase
{
    /** FileManager */
    protected $fileManager;

    /** DrawingStepsExporter */
    protected $drawingStepExporter;

    protected function setUp(): void
    {
        $this->fileManager = $this->createMock(FileManager::class);
        $this->drawingStepExporter = new DrawingStepsExporter($this->fileManager);
    }

    /**
     * @test
     * @dataProvider provider_for_a_given_input_should_return_an_expected_output
     */
    public function a_given_input_should_return_an_expected_output($input, $output)
    {
        $this->fileManager->method('importInput')->willReturn($input);
        
        $this->fileManager->expects($this->once())
                 ->method('exportOutput')
                 ->with($this->equalTo($output));

        $this->drawingStepExporter->exportFromInputFile();
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_first_command_is_not_a_canvas()
    {
        $input = <<<EOT
L 1 2 6 2
R 16 1 20 3
B 10 3 o
EOT;

        $this->fileManager->method('importInput')->willReturn($input);
        $this->expectException(\LogicException::class);

        $this->drawingStepExporter->exportFromInputFile();
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_a_command_is_not_valid()
    {
        $input = <<<EOT
C 20 4
X 12 23
L 1 2 6 2
EOT;

        $this->fileManager->method('importInput')->willReturn($input);
        $this->expectException(\LogicException::class);

        $this->drawingStepExporter->exportFromInputFile();
    }


    public function provider_for_a_given_input_should_return_an_expected_output()
    {
        $input1 = <<<EOT
C 20 4
L 1 2 6 2
L 6 3 6 4
R 16 1 20 3
B 10 3 o
EOT;
        
        $output1 = <<<EOT
----------------------
|                    |
|                    |
|                    |
|                    |
----------------------
----------------------
|                    |
|xxxxxx              |
|                    |
|                    |
----------------------
----------------------
|                    |
|xxxxxx              |
|     x              |
|     x              |
----------------------
----------------------
|               xxxxx|
|xxxxxx         x   x|
|     x         xxxxx|
|     x              |
----------------------
----------------------
|oooooooooooooooxxxxx|
|xxxxxxooooooooox   x|
|     xoooooooooxxxxx|
|     xoooooooooooooo|
----------------------

EOT;

    $input2 = <<<EOT
C 15 4
R 5 2 14 4
B 10 3 A
L 10 1 10 4
B 1 2 B
B 11 1 C
EOT;

    $output2 = <<<EOT
-----------------
|               |
|               |
|               |
|               |
-----------------
-----------------
|               |
|    xxxxxxxxxx |
|    x        x |
|    xxxxxxxxxx |
-----------------
-----------------
|               |
|    xxxxxxxxxx |
|    xAAAAAAAAx |
|    xxxxxxxxxx |
-----------------
-----------------
|         x     |
|    xxxxxxxxxx |
|    xAAAAxAAAx |
|    xxxxxxxxxx |
-----------------
-----------------
|BBBBBBBBBx     |
|BBBBxxxxxxxxxx |
|BBBBxAAAAxAAAx |
|BBBBxxxxxxxxxx |
-----------------
-----------------
|BBBBBBBBBxCCCCC|
|BBBBxxxxxxxxxxC|
|BBBBxAAAAxAAAxC|
|BBBBxxxxxxxxxxC|
-----------------

EOT;

        return array(
            array($input1, $output1),
            array($input2, $output2),
        );
    }

}