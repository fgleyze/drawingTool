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
		elseif ($command instanceof RectangleCommand)
		{
			$drawing = self::drawRectangle($command, $drawing);
		}
		elseif ($command instanceof AreaFillingCommand)
		{
			$drawing = self::fillArea($command, $drawing);
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

	private static function drawRectangle(RectangleCommand $command, Drawing $drawing)
	{
		$drawing = self::drawLine($command->getTopLineCommand(), $drawing);
		$drawing = self::drawLine($command->getBottomLineCommand(), $drawing);
		$drawing = self::drawLine($command->getLeftLineCommand(), $drawing);
		$drawing = self::drawLine($command->getRightLineCommand(), $drawing);

		return $drawing;
	}

	private static function fillArea(AreaFillingCommand $command, Drawing $drawing)
	{
		return self::checkAndFillFourDirections($command->getX(), $command->getY(), $command->getColor(), $drawing);
	}

	private static function checkAndFillFourDirections($x, $y, $color, $drawing)
	{
		$directions = array(
			array('x' => $x+1, 'y' => $y),
			array('x' => $x-1, 'y' => $y),
			array('x' => $x, 'y' => $y+1),
			array('x' => $x, 'y' => $y-1),
		);

		foreach ($directions as $coor) {
			if ($drawing->hasCell($coor['y'], $coor['x']) && $drawing->isCellEmpty($coor['y'], $coor['x'])) 
			{
				$drawing->setCell($coor['y'], $coor['x'], $color);
				$drawing = self::checkAndFillFourDirections($coor['x'], $coor['y'], $color, $drawing);
			}
		}

		return $drawing;
	}
}
