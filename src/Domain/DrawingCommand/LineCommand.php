<?php

namespace Drawing\Domain\DrawingCommand;

class LineCommand implements DrawingCommand
{
	/** int */
	private $x1;

	/** int */
	private $y1;

	/** int */
	private $x2;

	/** int */
	private $y2;

	private function __construct($x1, $y1, $x2, $y2)
	{
		$this->x1 = $x1;
		$this->y1 = $y1;
		$this->x2 = $x2;
		$this->y2 = $y2;
	}

	public static function fromRawCommand($rawCommand)
	{
		$commandAsArray = explode(" ", $rawCommand);

		if (count($commandAsArray) !== 5) {
			throw new \LogicException("Line command must have 3 arguments");
		}

		// if (!is_int($commandAsArray[1]) && !is_int($commandAsArray[2]) && !is_int($commandAsArray[3]) && !is_int($commandAsArray[4])) {
		// 	throw new \LogicException("Line coors for command must be integers");
		// }

		return new self(
			$commandAsArray[1],
			$commandAsArray[2],
			$commandAsArray[3],
			$commandAsArray[4]
		);
	}

	public static function fromCoordinates($x1, $y1, $x2, $y2)
	{
		return new self($x1, $y1, $x2, $y2);
	}

	public function getX1()
	{
		return $this->x1;
	}

	public function getY1()
	{
		return $this->y1;
	}

	public function getX2()
	{
		return $this->x2;
	}

	public function getY2()
	{
		return $this->y2;
	}
}