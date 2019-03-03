<?php

namespace Drawing\Domain\Drawing;

class Drawing
{
	/** DrawingRow[] */
	private $rows;

	public function __construct($width, $height, $content = ' ')
	{
		$i = 1;
		while ($i <= $height) {
			$this->rows[$i] = new DrawingRow($width, $content);
			$i++;
		}
	}

	public function getCell($rowOffset, $cellOffset)
	{
		return $this->getRow($rowOffset)->getCell($cellOffset);
	}

	public function setCell($rowOffset, $cellOffset, $content)
	{
		$this->getRow($rowOffset)->setCell($cellOffset, $content);
	}

	public function getRows()
	{
		return $this->rows;
	}

	public function getWidth()
	{
		return count(reset($this->rows)->getCells());
	}

	public function getHeight()
	{
		return count($this->rows);
	}

	public function hasCell($rowOffset, $cellOffset)
	{
		if (!array_key_exists($rowOffset, $this->rows)) {
			return false;
		}

		return $this->getRow($rowOffset)->hasCell($cellOffset);
	}

	public function isCellEmpty($rowOffset, $cellOffset)
	{
		return $this->getRow($rowOffset)->isCellEmpty($cellOffset);
	}

	public function getAsArray()
	{
		return array_map(function(DrawingRow $row) {
			return $row->getCells();
		}, $this->getRows());
	}

	private function getRow($offset)
	{
		$this->checkOffset($offset);

		return $this->rows[$offset];
	}

	private function checkOffset($offset)
	{
	// check if is int
	// check if exists
	}
}
