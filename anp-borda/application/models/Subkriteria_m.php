<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class Subkriteria_m extends Eloquent
{
	protected $table		= 'subkriteria';
	protected $primaryKey	= 'id';

	public function kriteria()
	{
		require_once __DIR__ . '/Kriteria_m.php';
		return $this->hasOne('Kriteria_m', 'id', 'id_kriteria');
	}
}