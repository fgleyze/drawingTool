<?php

use PHPUnit\Framework\TestCase;
use Drawing\Domain\DrawingCommand\LineCommand;
use Drawing\Domain\Drawing\Drawing;
use Drawing\Domain\DrawingModifier;

final class DrawingTest extends TestCase
{
    /**
     * @test
     */
    public function a_drawing_has_given_width_and_height()
    {
        $drawing = new Drawing(5, 7);

        $this->assertEquals($drawing->getWidth(), 5);
        $this->assertEquals($drawing->getHeight(), 5);
    }
}