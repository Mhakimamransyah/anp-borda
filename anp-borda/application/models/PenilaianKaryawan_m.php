<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class PenilaianKaryawan_m extends Eloquent
{
	protected $table		= 'penilaian_karyawan';
	protected $primaryKey	= 'id';

	public function karyawan()
	{
		require_once __DIR__ . '/Karyawan_m.php';
		return $this->hasOne('Karyawan_m', 'id', 'id_karyawan');
	}

	public function subkriteria()
	{
		require_once __DIR__ . '/Subkriteria_m.php';
		return $this->hasOne('Subkriteria_m', 'id', 'id_subkriteria');
	}
}