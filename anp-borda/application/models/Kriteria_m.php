<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class Kriteria_m extends Eloquent
{
	protected $table		= 'kriteria';
	protected $primaryKey	= 'id';

	public function subkriteria()
	{
		require_once __DIR__ . '/Subkriteria_m.php';
		return $this->hasMany('Subkriteria_m', 'id_kriteria', 'id');
	}

}