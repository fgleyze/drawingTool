<?php

namespace Drawing\Domain\Drawing;

class DrawingRow
{
	private $cells;

	public function __construct($length, $content)
	{
		$this->checkContentLenght($content);

		$this->cells = array_fill(1, $length, $content);
	}

	public function getCells()
	{
		return $this->cells;
	}

	public function getCell($offset)
	{
		$this->checkOffset($offset);

		return $this->cells[$offset];
	}

	public function setCell($offset, $content)
	{
		$this->checkOffset($offset);
		$this->checkContentLenght($content);

		$this->cells[$offset] = $content;
	}

	public function hasCell($offset)
	{
		return  array_key_exists($offset, $this->cells);
	}

	public function isCellEmpty($offset)
	{
		return $this->getCell($offset) === ' ';
	}

	private function checkContentLenght($content)
	{
		if (mb_strlen($content) !== 1) {
			//a cell can contain only 1 character
		}
	}

	private function checkOffset($offset)
	{
		// check if is int
		// check if exists
	}
}
