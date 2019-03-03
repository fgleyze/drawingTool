<?php

namespace Drawing\Domain;

use Drawing\Domain\DrawingCommand\CanvasCommand;
use Drawing\Domain\DrawingCommand\LineCommand;
use Drawing\Domain\DrawingCommand\RectangleCommand;
use Drawing\Domain\DrawingCommand\AreaFillingCommand;

class DrawingCommandFactory
{
	CONST CANVAS_COMMAND_CODE = 'C';
	CONST LINE_COMMAND_CODE = 'L';
	CONST RECTANGLE_COMMAND_CODE = 'R';
	CONST AREA_FILLING_COMMAND_CODE = 'B';

	CONST COMMAND_CODES = array(
		self::CANVAS_COMMAND_CODE,
		self::LINE_COMMAND_CODE,
		self::RECTANGLE_COMMAND_CODE,
		self::AREA_FILLING_COMMAND_CODE
		);

	public static function getCommand($rawCommand)
	{
		$commandCode = self::getCommandCode($rawCommand);

		if ($commandCode == self::CANVAS_COMMAND_CODE)
		{
			return new CanvasCommand($rawCommand);
		}
		elseif ($commandCode == self::LINE_COMMAND_CODE)
		{
			return LineCommand::fromRawCommand($rawCommand);
		}
		elseif ($commandCode == self::RECTANGLE_COMMAND_CODE)
		{
			return new RectangleCommand($rawCommand);
		}
		elseif ($commandCode == self::AREA_FILLING_COMMAND_CODE)
		{
			return new AreaFillingCommand($rawCommand);
		}
	}

	private static function getCommandCode($rawCommand)
	{
		$commandCode = mb_substr($rawCommand, 0, 1);

		if (!in_array($commandCode, self::COMMAND_CODES)) {
			throw new \LogicException(sprintf('%s is not a valid command code',
				$commandCode));
		}

		return $commandCode;
	}
}