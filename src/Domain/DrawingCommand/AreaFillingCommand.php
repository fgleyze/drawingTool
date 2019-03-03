<?php

namespace Drawing\Domain\DrawingCommand;

class AreaFillingCommand implements DrawingCommand
{
	/** int */
	private $x;

	/** int */
	private $y;

	/** string */
	private $color;

	public function __construct($rawCommand)
	{
		$commandAsArray = explode(" ", $rawCommand);

		if (count($commandAsArray) !== 4) {
			throw new \LogicException("Area filling command must have 3 arguments");
		}

		// if (!is_int($commandAsArray[1]) && !is_int($commandAsArray[2])) {
		// 	throw new \LogicException("Area filling coors for command must be integers");
		// }

		if (mb_strlen($commandAsArray[3]) !== 1) {
			throw new \LogicException("Area filling color must be a single character");
		}

		$this->x = $commandAsArray[1];
		$this->y = $commandAsArray[2];
		$this->color = $commandAsArray[3];
	}

	public function getX()
	{
		return $this->x;
	}

	public function getY()
	{
		return $this->y;
	}

	public function getColor()
	{
		return $this->color;
	}
}