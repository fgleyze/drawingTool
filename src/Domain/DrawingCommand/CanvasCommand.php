<?php

namespace Drawing\Domain\DrawingCommand;

class CanvasCommand implements DrawingCommand
{
	/** int */
	private $width;

	/** int */
	private $height;

	public function __construct($rawCommand)
	{
		$commandAsArray = explode(" ", $rawCommand);

		if (count($commandAsArray) !== 3) {
			throw new \LogicException("Canvas command must have 3 arguments");
		}

		// if (!is_int($commandAsArray[1]) && !is_int($commandAsArray[2])) {
		// 	throw new \LogicException("Canvas coors for command must be integers");
		// }

		$this->width = $commandAsArray[1];
		$this->height = $commandAsArray[2];
	}

	public function getWidth()
	{
		return $this->width;
	}

	public function getHeight()
	{
		return $this->height;
	}
}