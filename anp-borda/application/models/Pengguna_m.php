<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class Pengguna_m extends Eloquent
{
	protected $table		= 'pengguna';
	protected $primaryKey	= 'id';

	public function role()
	{
		require_once __DIR__ . '/Role_m.php';
		return $this->hasOne('Role_m', 'id', 'id_role');
	}

}