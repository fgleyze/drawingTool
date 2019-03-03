<?php

namespace Drawing\Domain\DrawingCommand;

class RectangleCommand implements DrawingCommand
{
	/** int */
	private $x1;

	/** int */
	private $y1;

	/** int */
	private $x2;

	/** int */
	private $y2;

	public function __construct($rawCommand)
	{
		$commandAsArray = explode(" ", $rawCommand);

		if (count($commandAsArray) !== 5) {
			throw new \LogicException("Rectangle command must have 3 arguments");
		}

		// if (!is_int($commandAsArray[1]) && !is_int($commandAsArray[2]) && !is_int($commandAsArray[3]) && !is_int($commandAsArray[4])) {
		// 	throw new \LogicException("Rectangle coors for command must be integers");
		// }

		$this->x1 = $commandAsArray[1];
		$this->y1 = $commandAsArray[2];
		$this->x2 = $commandAsArray[3];
		$this->y2 = $commandAsArray[4];
	}

	public function getTopLineCommand()
	{
		return LineCommand::fromCoordinates($this->x1, $this->y1, $this->x2,
			$this->y1);
	}

	public function getBottomLineCommand()
	{
		return LineCommand::fromCoordinates($this->x1, $this->y2, $this->x2,
			$this->y2);
	}

	public function getLeftLineCommand()
	{
		return LineCommand::fromCoordinates($this->x1, $this->y1, $this->x1,
			$this->y2);
	}

	public function getRightLineCommand()
	{
		return LineCommand::fromCoordinates($this->x2, $this->y1, $this->x2,
			$this->y2);
	}
}
