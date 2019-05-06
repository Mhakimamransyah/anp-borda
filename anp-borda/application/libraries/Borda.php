<?php 

class Borda
{
	public function score($matrix)
	{
		$matrix = $this->weighting($matrix);
		return $this->sumWidth($matrix);
	}

	private function weighting($matrix)
	{
		$height = count($matrix);
		$width 	= count($matrix[0]);
		
		for ($i = 0; $i < $height; $i++)
		{
			for ($j = 0; $j < $width; $j++)
			{
				$matrix[$i][$j] = ($matrix[$i][$j] * ($width - 1 - $j));
			}
		}

		return $matrix;
	}

	private function sumWidth($mat)
	{
		$summations = [];
		$height = count($mat);
		
		for ($i = 0; $i < $height; $i++)
		{
			$summations []= array_sum($mat[$i]);
		}

		return $summations;
	}
}