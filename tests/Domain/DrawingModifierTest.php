<?php

use PHPUnit\Framework\TestCase;
use Drawing\Domain\DrawingCommand\LineCommand;
use Drawing\Domain\Drawing\Drawing;
use Drawing\Domain\DrawingModifier;

final class DrawingModifierTest extends TestCase
{
    /**
     * @test
     */
    public function drawing_can_be_modified_by_adding_a_virtual_line()
    {
        $drawing = new Drawing(5, 5);

        $this->assertEquals($drawing->getCell(1, 2), ' ');
        $this->assertEquals($drawing->getCell(2, 2), ' ');
        $this->assertEquals($drawing->getCell(3, 2), ' ');
        $this->assertEquals($drawing->getCell(4, 2), ' ');
        $this->assertEquals($drawing->getCell(5, 2), ' ');

        $drawing = DrawingModifier::modifyFromCommand(
            LineCommand::fromCoordinates(2, 2, 2, 4),
            $drawing
        );

        $this->assertEquals($drawing->getCell(1, 2), ' ');
        $this->assertEquals($drawing->getCell(2, 2), 'x');
        $this->assertEquals($drawing->getCell(3, 2), 'x');
        $this->assertEquals($drawing->getCell(4, 2), 'x');
        $this->assertEquals($drawing->getCell(5, 2), ' ');
    }
}