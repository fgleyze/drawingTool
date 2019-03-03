<?php

namespace Drawing\Domain;

use Drawing\Domain\DrawingCommand\DrawingCommand;
use Drawing\Domain\DrawingCommand\CanvasCommand;
use Drawing\Domain\DrawingCommand\LineCommand;
use Drawing\Domain\DrawingCommand\RectangleCommand;
use Drawing\Domain\DrawingCommand\AreaFillingCommand;
use Drawing\Domain\Drawing\Drawing;

class DrawingModifier
{
	CONST LINE_DRAWING_CHARACTER = 'x';

	public static function modifyFromCommand(DrawingCommand $command, Drawing $drawing)
	{
		if ($command instanceof LineCommand)
		{
			$drawing = self::drawLine($command, $drawing);
		}
		else {
			throw new \LogicException('No implementation was found for this Command');
		}

		return $drawing;
	}

	private static function drawLine(LineCommand $command, Drawing $drawing)
	{
		if ($command->getX1() === $command->getX2()) {
			// vertical line
			$from = min($command->getY1(), $command->getY2());
			$to = max($command->getY1(), $command->getY2());

			$i = $from;
			while ($i <= $to) {
				$drawing->setCell($i, $command->getX1(), self::LINE_DRAWING_CHARACTER);
				$i++;
			}
		} elseif ($command->getY1() === $command->getY2()) {
			// horizontal line
			$from = min($command->getX1(), $command->getX2());
			$to = max($command->getX1(), $command->getX2());

			$i = $from;
			while ($i <= $to) {
				$drawing->setCell($command->getY1(), $i, self::LINE_DRAWING_CHARACTER);
				$i++;
			}
		} else {
			throw new \LogicException('Line must be horizontal or vertical');
		}

		return $drawing;
	}
}
