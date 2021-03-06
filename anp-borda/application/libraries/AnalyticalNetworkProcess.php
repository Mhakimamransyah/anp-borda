<?php 

class AnalyticalNetworkProcess
{
	private $RANDOM_INDEX = [
		0.000, 0.000, 0.580, 0.900, 1.120, 
		1.240, 1.320, 1.410, 1.450, 1.490, 
		1.510, 1.480, 1.560, 1.570, 1.590
	];

	public function __construct()
	{
	
	}

	private function pairwiseComparison($criteria)
	{
		$tables = [];
		foreach ($criteria as $key => $value)
		{
			if ($value == 0)
			{
				$tables []= 0;
				continue;
			}

			$row = [];
			foreach ($criteria as $k => $v)
			{
				$row []= $value / $v;
			}

			$tables []= $row;
		}
		return $tables;
	}

	private function matrixMultiplication($matA, $matB)
	{
		$heightA 	= count($matA);
		$widthA 	= $matA[0] ? count($matA[0]) : 1;

		$heightB 	= count($matB);
		$widthB 	= $matB[0] ? count($matB[0]) : 1;

		$newMatrix 	= [];

		for ($i = 0; $i < $heightA; $i++)
		{
			for ($j = 0; $j < $widthA; $j++)
			{
				$sum = 0;
				for ($k = 0; $k < $heightB; $k++)
				{
					$sum += ($matA[$i][$k] * $matB[$k][$j]);
				}
				$newMatrix[$i][$j] = $sum;
			}
		} 

		return $newMatrix;
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

	private function sumHeight($mat)
	{
		$summations = [];
		$width = count($mat);

		for ($i = 0; $i < $width; $i++)
		{
			$summations []= array_sum(array_column($mat, $i));
		}

		return $summations;
	}

	private function calculateEigenValue($mat)
	{
		$summations = $this->sumWidth($mat);
		$total 		= array_sum($summations);
		$eigens 	= [];
		foreach ($summations as $sum)
		{
			if ($sum == 0)
			{
				$eigens []= 0;
				continue;
			}
			$eigens []= $sum / $total;
		}
		return $eigens;
	}

	private function calculateMaxEigenValue($mat)
	{
		// var_dump($mat);
		$eigens 		= $this->calculateEigenValue($mat);
		$sumHeights		= $this->sumHeight($mat);
		$maxEigen 		= 0;
		foreach ($eigens as $i => $eigen)
		{
			// echo $eigen . ' * ' . $sumHeights[$i] . '<br>';
			$maxEigen += ($eigen * $sumHeights[$i]);
		}
		// echo 'Eigens: ' . json_encode($eigens) . '<br>';
		// echo 'Sum Heights: ' . json_encode($sumHeights) . '<br>';
		return $maxEigen;
	}

	private function calculateConsistencyIndex($matrix)
	{
		$n 			= count($matrix);
		$maxEigen 	= $this->calculateMaxEigenValue($matrix);
		// echo 'Max Eigen: ' . $maxEigen . '<br>';
		return ($maxEigen - $n) / ($n - 1);
	}

	private function calculateConsistencyRatio($matrix)
	{
		$n = count($matrix);
		$consistencyIndex = $this->calculateConsistencyIndex($matrix);
		if ($n > 15)
		{
			$n = 15;
		}
		// echo 'CI: ' . $consistencyIndex . '<br>';
		return $consistencyIndex / $this->RANDOM_INDEX[$n - 1];
	}

	public function calculateWeight($criteria)
	{
		$n = count($criteria);
		$matrix = $this->pairwiseComparison($criteria);
		$cr = 0.0;
		// $i = 0;
		// do
		// {
			$matrix = $this->matrixMultiplication($matrix, $matrix);
			$cr 	= $this->calculateConsistencyRatio($matrix);	
			// $i++;
			// echo $cr . '<br>';
			// if ($i > 10) break;
		// }
		// while ($cr > 0.1);
		
		return $this->sumWidth($matrix);
	}
}