<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class Pengguna_m extends Eloquent
{
	protected $table		= 'pengguna';
	protected $primaryKey	= 'id';

	public function subkriteria()
	{
		require_once __DIR__ . '/Role_m.php';
		return $this->hasMany('Role_m', 'id_role', 'id');
	}

}