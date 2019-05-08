<?php 

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class SpreadsheetHandler
{
	private $reader;

	public function __construct()
	{
		$this->reader = new Xlsx(); 
	}

	public function read($filepath)
	{
		$spreadsheet 	= $this->reader->load($filepath);
		$sheet 			= $spreadsheet->getActiveSheet();
		return $sheet;
	}

	public function serialize($sheet, $startRow = 1, $endRow = null)
	{
		$data 		= [];
		$columns 	= [];
		foreach ($sheet->getRowIterator() as $i => $row)
		{
			if ($endRow != null && $i > $endRow)
			{
				break;
			}

			if ($i <= $startRow)
			{
				continue;
			}

			$cellIterator 	= $row->getCellIterator();
			$record 		= [];
			$j = 0;
			foreach ($cellIterator as $cell)
			{
				$record []= $cell->getValue();
				$j++;
			}

			$data []= $record;
		}

		return $data;
	}
}