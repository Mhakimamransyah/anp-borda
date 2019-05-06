<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class Karyawan_m extends Eloquent
{
	protected $table		= 'karyawan';
	protected $primaryKey	= 'id';

	public function divisi()
	{
		require_once __DIR__ . '/Divisi_m.php';
		return $this->hasOne('Divisi_m', 'id', 'id_divisi');
	}

	public function penilaian()
	{
		require_once __DIR__ . '/PenilaianKaryawan_m.php';
		return $this->hasMany('PenilaianKaryawan_m', 'id_karyawan', 'id');
	}
}