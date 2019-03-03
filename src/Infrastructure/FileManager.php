<?php

namespace Drawing\Infrastructure;

class FileManager
{
	public function importInput($inputFileName)
	{
        $inputFilePath = sprintf("./public/%s", $inputFileName);

		$inputFile = fopen($inputFilePath, "r") or die("Unable to open file");
		$input = fread($inputFile, filesize($inputFilePath));
        fclose($inputFile);
        
        return $input;
	}

	public function exportOutput($output, $outputFileName = 'output.txt')
	{
        $inputFilePath = sprintf("./public/%s", $outputFileName);

        $outputFile = fopen($inputFilePath, "w");
        fwrite($outputFile, $output);
		fclose($outputFile);
	}
}