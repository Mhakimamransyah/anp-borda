<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class Divisi_m extends Eloquent
{
	protected $table		= 'divisi';
	protected $primaryKey	= 'id';

	public function karyawan()
	{
		require_once __DIR__ . '/Karyawan_m.php';
		return $this->hasOne('Karyawan_m', 'id_divisi', 'id');
	}

}