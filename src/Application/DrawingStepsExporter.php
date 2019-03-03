<?php

namespace Drawing\Application;

use Drawing\Domain\DrawingCommandFactory;
use Drawing\Domain\DrawingModifier;
use Drawing\Domain\DrawingCommand\CanvasCommand;
use Drawing\Domain\Drawing\Drawing;
use Drawing\Infrastructure\FileManager;

class DrawingStepsExporter
{
	/** FileManager */
	private $fileManager;

	public function __construct(FileManager $fileManager)
	{
		$this->fileManager = $fileManager;
	}

	public function exportFromInputFile($inputFileName = 'input.txt', $outputFileName = 'output.txt')
	{
		$input = $this->fileManager->importInput($inputFileName);

		$drawingCommands = self::getDrawingCommandsFromInput($input);

		if (!(reset($drawingCommands) instanceof CanvasCommand)) {
			throw new \LogicException('First drawing command must be to setup a Canvas');
		}

		$drawings = array();
		$renderedDrawingSteps = '';

		foreach ($drawingCommands as $command) {
			if (count($drawings) === 0) {
				$drawing = new Drawing($command->getWidth(), $command->getHeight());
			} else {
				$drawing = DrawingModifier::modifyFromCommand($command, end($drawings));
			}

			$renderedDrawingSteps .= self::render($drawing);
			$drawings[] = $drawing;
			
		}

		$this->fileManager->exportOutput($renderedDrawingSteps);

		print('Successful export');
	}

	private static function getDrawingCommandsFromInput($input)
	{
		$rawDrawingCommands = explode("\n", rtrim($input));

		return array_map(function($rawCommand) {
			return DrawingCommandFactory::getCommand($rawCommand);
		}, $rawDrawingCommands);
	}

	private static function render(Drawing $drawing)
	{
		$drawingAsArray = $drawing->getAsArray();

		$renderedDrawing = '';

		$horizontalBorder = sprintf("%s\n", str_repeat('-', $drawing->getWidth() + 2));

		$renderedDrawing .= $horizontalBorder;

		foreach ($drawingAsArray as $row) {
			$renderedDrawing .= sprintf("|%s|\n", implode('', $row));
		}

		$renderedDrawing .= $horizontalBorder;

		return $renderedDrawing;
	}
}