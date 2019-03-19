<?php 

class WeightedProduct
{
	private $nbf = [];
	private $nbe = [];

	public function do_wp($data)
	{
		$this->calculate_nbf($data);
		$this->calculate_nbe($data);
		$this->calculate_tbe();
		$this->sort_tbe();
		return $this->nbe;
	}

	private function calculate_nbf($data)
	{
		$sum 		= 0;
		$kriteria 	= $data[0]['kriteria']['bobot'];
		$sum 		= array_sum($kriteria);
		foreach ($kriteria as $value) 
		{
			array_push($this->nbf, $value / $sum);
		}
	}

	private function calculate_nbe($data)
	{
		foreach ($data as $value) 
		{
			$calon 			= [];
			$val_nbe 		= [];
			$calon["nama"] 	= $value["nama"];  
			for ($i = 0; $i < sizeof($value["kriteria"]["nama"]); $i++) 
			{
				array_push($val_nbe, pow($this->nbf[$i], -1 * $value["faktor"]["bobot"][$i]));
			}
			$calon["nbe"] 	= $val_nbe;
			array_push($this->nbe, $calon);
		}
	}

	private function calculate_tbe()
	{
        for ($i = 0; $i < sizeof($this->nbe); $i++) 
        { 
        	$tbe = 1;
        	foreach ($this->nbe[$i]['nbe'] as $nbe)
        	{
        		$tbe *= $nbe;
        	}
           $this->nbe[$i]["tbe"] = $tbe;
        }
	}

	private function sort_tbe()
	{
		$sort = [];
		foreach ($this->nbe as $index => $value) 
		{
			$sort[$index] = $value["tbe"];
		}

		array_multisort($sort, SORT_DESC, $this->nbe);
	}
}