<?php 

class Admin extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->module = 'admin';

		$id_pengguna	= $this->session->userdata('id_pengguna');
	    $username 		= $this->session->userdata('username');
	    $id_role		= $this->session->userdata('id_role');
		if (!isset($id_pengguna, $username, $id_role) or $id_role != 1)
		{
			$this->session->sess_destroy();
			redirect('login');
		}
	}

	// PRIVATE SECTION START

	private function weighting($matrix, $weights)
	{
		foreach ($matrix as $i => $row)
		{
			foreach ($row as $j => $cell)
			{
				$matrix[$i][$j] = $cell * $weights[$j - (ceil($j / 2))];
			}
		}
		return $matrix;
	}

	private function sumSubkriteria($matrix)
	{
		$newMatrix = [];
		foreach ($matrix as $i => $row)
		{
			$rec = [];
			for ($j = 0; $j < count($row); $j++)
			{
				if ($j % 2 != 0)
				{
					continue;
				}

				$rec []= ($row[$j] + $row[$j + 1]);
			}
			$newMatrix []= $rec;
		}
		return $newMatrix;
	}

	private function constructMatrix($data)
	{
		$matrix = [];
		foreach ($data as $row)
		{
			$rec = [];
			foreach ($row->penilaian as $penilaian)
			{
				$rec []= $penilaian->nilai;
			}
			$matrix []= $rec;
		}
		return $matrix;
	}

	private function executeAnp($weights)
	{
		$this->load->model('Karyawan_m');
		$karyawan = Karyawan_m::with('penilaian')->get();
		$matrix = $this->constructMatrix($karyawan);
		$matrix = $this->weighting($matrix, $weights);
		$matrix = $this->sumSubkriteria($matrix);	
	
		$this->load->library('analyticalnetworkprocess');
		$width = count($matrix[0]);
		$result = [];
		for ($i = 0; $i < $width; $i++)
		{
			$weightedValue = $this->analyticalnetworkprocess->calculateWeight(array_column($matrix, $i));
			foreach ($weightedValue as $j => $val)
			{
				if (isset($result[$j]))
				{
					$result[$j] []= $val;
				}
				else
				{
					$result[$j] = [$val];
				}
			}
		}

		return $result;
	}

	private function executeBorda($results)
	{
		$this->load->model('Karyawan_m');
		$karyawan = Karyawan_m::with('penilaian')->get();
		$n = count($karyawan);
		$votes = [];
		for ($i = 0; $i < $n; $i++)
		{
			// $karyawan[$i]->votes = array_fill(0, $n, 0);
			$votes []= array_fill(0, $n, 0);
		}

		foreach ($results as $result)
		{
			$totalScores = $this->sumWidth($result);
			$temp = $karyawan->toArray();
			array_multisort($totalScores, SORT_DESC, $temp);
			for ($i = 0; $i < $n; $i++)
			{
				$tempIndex = $this->getKaryawanIndexById($temp, $karyawan[$i]->id);
				$votes[$i][$tempIndex]++;
			}
		}

		for ($i = 0; $i < $n; $i++)
		{
			$karyawan[$i]->votes = $votes[$i];
		}

		// construct borda matrix
		$bordaMatrix = $this->constructBordaMatrix($karyawan);

		$this->load->library('borda');
		$finalScores = $this->borda->score($bordaMatrix);
		$totalScore  = array_sum($finalScores);
		
		for ($i = 0; $i < $n; $i++)
		{
			$karyawan[$i]->final_score 		= $finalScores[$i];
			$karyawan[$i]->normalized_score	= $finalScores[$i] / $totalScore;
		}

		return $karyawan;
	}

	private function constructBordaMatrix($data)
	{
		$matrix = [];
		foreach ($data as $row)
		{
			$matrix []= $row->votes;
		}
		return $matrix;
	}

	private function getKaryawanIndexById($karyawan, $id)
	{
		foreach ($karyawan as $i => $row)
		{
			if ($row['id'] == $id)
			{
				return $i;
			}
		}

		return -1;
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

	// PRIVATE SECTION END

	public function index()
	{
		$this->load->model('Kriteria_m');
		$this->data['kriteria']	= Kriteria_m::get();

		if ($this->POST('submit'))
		{
			$bobotKriteriaSistem 	= [];
			$bobotL 				= [];
			$bobotR 				= [];

			foreach ($this->data['kriteria'] as $kriteria)
			{
				$bobotKriteriaSistem []= $kriteria->bobot;
				$bobotL []= $this->POST('kriteria_l_' . $kriteria->id);
				$bobotR []= $this->POST('kriteria_r_' . $kriteria->id);
			}

			$results[0] = $this->executeAnp($bobotKriteriaSistem);
			$results[1] = $this->executeAnp($bobotL);
			$results[2] = $this->executeAnp($bobotR);

			$this->data['result'] = $this->executeBorda($results);
			$bobotNormalisasi = [];
			foreach ($this->data['result'] as $row)
			{
				$bobotNormalisasi []= $row->normalized_score;
			}
			$this->data['result'] = $this->data['result']->toArray();
			array_multisort($bobotNormalisasi, SORT_DESC, $this->data['result']);
		}

		$this->data['title']	= 'Dashboard';
		$this->data['content']	= 'dashboard';
		$this->template($this->data, $this->module);
	}

	public function penilaian_karyawan()
	{
		$this->data['id_karyawan']	= $this->uri->segment(3);
		$this->check_allowance(!isset($this->data['id_karyawan']));

		$this->load->model('PenilaianKaryawan_m');
		$this->load->model('Subkriteria_m');
		$this->load->model('Karyawan_m');
		$this->data['karyawan'] = Karyawan_m::with('penilaian', 'penilaian.subkriteria', 'divisi')->find($this->data['id_karyawan']);
		$this->check_allowance(!isset($this->data['karyawan']), ['Data karyawan dengan ID ' . $this->data['id_karyawan'] . ' tidak ditemukan', 'danger']);

		if ($this->POST('submit'))
		{
			PenilaianKaryawan_m::where('id_karyawan', $this->data['id_karyawan'])->delete();
			$penilaian 		= [];
			$idSubkriteria 	= $this->POST('id_subkriteria');
			$nilai 			= $this->POST('nilai');
			foreach ($idSubkriteria as $i => $id)
			{
				$penilaian []= [
					'id_karyawan'		=> $this->data['karyawan']->id,
					'id_subkriteria'	=> $id,
					'nilai'				=> $nilai[$i]
				];
			}
			PenilaianKaryawan_m::insert($penilaian);
			$this->flashmsg('Data penilaian karyawan berhasil dimasukkan');
			redirect('admin/penilaian-karyawan/' . $this->data['id_karyawan']);
		}

		$this->data['subkriteria']	= Subkriteria_m::get();
		$this->data['title']		= 'Tambah Penilaian Karyawan';
		$this->data['content']		= 'tambah_penilaian_karyawan';
		$this->template($this->data, $this->module);
	}

	public function data_karyawan()
	{
		$this->load->model('Karyawan_m');
		if ($this->GET('id'))
		{
			$karyawan = Karyawan_m::find($this->GET('id'));
			if (isset($karyawan))
			{
				$karyawan->delete();
				$this->flashmsg('Data karyawan dengan ID ' . $this->GET('id') . ' berhasil dihapus');
			}
			else
			{
				$this->flashmsg('Data karyawan dengan ID ' . $this->GET('id') . ' gagal dihapus. Data tidak ditemukan.', 'danger');
			}
			
			redirect('admin/data-karyawan');
		}
		$this->data['karyawan']	= Karyawan_m::with('divisi')->get();
		$this->data['title']	= 'Data Karyawan';
		$this->data['content']	= 'data_karyawan';
		$this->template($this->data, $this->module);
	}

	public function tambah_karyawan()
	{
		if ($this->POST('submit'))
		{
			$this->load->model('Karyawan_m');
			$karyawan = new Karyawan_m();
			$karyawan->nik 			= $this->POST('nik');
			$karyawan->nama 		= $this->POST('nama');
			$karyawan->id_divisi 	= $this->POST('id_divisi');
			$karyawan->lama_bekerja = $this->POST('lama_bekerja');
			$karyawan->status 		= $this->POST('status');
			$karyawan->save();

			$this->flashmsg('Data karyawan baru berhasil ditambahkan');
			redirect('admin/tambah-karyawan');
		}

		$this->load->model('Divisi_m');
		$this->data['divisi']	= Divisi_m::get();
		$this->data['title']	= 'Form Tambah Karyawan';
		$this->data['content']	= 'tambah_karyawan';
		$this->template($this->data, $this->module);
	}

	public function edit_karyawan()
	{

	}

	public function data_divisi()
	{
		$this->load->model('Divisi_m');
		if ($this->GET('id'))
		{
			$divisi = Divisi_m::find($this->GET('id'));
			if (isset($divisi))
			{
				$divisi->delete();
				$this->flashmsg('Data divisi dengan ID ' . $this->GET('id') . ' berhasil dihapus');
			}
			else
			{
				$this->flashmsg('Data divisi dengan ID ' . $this->GET('id') . ' gagal dihapus. Data tidak ditemukan.', 'danger');
			}
			
			redirect('admin/data-divisi');
		}
		$this->data['divisi'] 	= Divisi_m::get();
		$this->data['title']	= 'Data Divisi';
		$this->data['content']	= 'data_divisi';
		$this->template($this->data, $this->module);
	}

	public function tambah_divisi()
	{
		if ($this->POST('submit'))
		{
			$this->load->model('Divisi_m');
			$divisi = new Divisi_m();
			$divisi->divisi 	= $this->POST('divisi');
			$divisi->deskripsi 	= $this->POST('deskripsi');
			$divisi->save();

			$this->flashmsg('Data divisi baru berhasil ditambahkan');
			redirect('admin/tambah-divisi');
		}

		$this->data['title']	= 'Form Tambah Data Divisi';
		$this->data['content']	= 'tambah_divisi';
		$this->template($this->data, $this->module);	
	}

	public function edit_divisi()
	{

	}

	public function data_kriteria()
	{
		$this->load->model('Kriteria_m');
		if ($this->GET('id'))
		{
			$kriteria = Kriteria_m::find($this->GET('id'));
			if (isset($kriteria))
			{
				$kriteria->delete();
				$this->flashmsg('Data kriteria dengan ID ' . $this->GET('id') . ' berhasil dihapus');
			}
			else
			{
				$this->flashmsg('Data kriteria dengan ID ' . $this->GET('id') . ' gagal dihapus. Data tidak ditemukan.', 'danger');
			}
			
			redirect('admin/data-kriteria');
		}
		$this->data['kriteria']	= Kriteria_m::get();
		$this->data['title']	= 'Data Kriteria';
		$this->data['content']	= 'data_kriteria';
		$this->template($this->data, $this->module);
	}

	public function tambah_kriteria()
	{
		if ($this->POST('submit'))
		{
			$this->load->model('Kriteria_m');
			$this->load->model('Subkriteria_m');

			$kriteria = new Kriteria_m();
			$kriteria->kriteria 	= $this->POST('kriteria');
			$kriteria->deskripsi 	= $this->POST('deskripsi');
			$kriteria->bobot 		= $this->POST('bobot');
			$kriteria->save();

			$subkriteria = $this->POST('subkriteria');
			foreach ($subkriteria as $row)
			{
				if (!empty($row))
				{
					$sub = new Subkriteria_m();
					$sub->subkriteria = $row;
					$sub->id_kriteria = $kriteria->id;
					$sub->save();
				}
			}

			$this->flashmsg('Kriteria baru berhasil ditambahkan');
			redirect('admin/tambah-kriteria');
		}

		$this->data['title']	= 'Form Tambah Kriteria';
		$this->data['content']	= 'tambah_kriteria';
		$this->template($this->data, $this->module);
	}

	public function edit_kriteria()
	{
		
	}

	public function perangkingan()
	{
		$this->data['title']	= 'Perangkingan';
		$this->data['content']	= 'perangkingan';
		$this->template($this->data, $this->module);
	}
}