<?php 

class Decision_maker extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->module = 'decision_maker';

		$id_pengguna	= $this->session->userdata('id_pengguna');
	    $username 		= $this->session->userdata('username');
	    $id_role		= $this->session->userdata('id_role');
		if (!isset($id_pengguna, $username, $id_role) or $id_role != 2)
		{
			$this->session->sess_destroy();
			redirect('login');
		}
	}

	public function index()
	{
		$this->load->model('Kriteria_m');
		$this->data['kriteria']	= Kriteria_m::get();
		$this->data['excluded'] = [
			'l'	=> [2, 3, 4], 'r' => [5, 6, 7]
		];

		if ($this->POST('submit'))
		{
			$bobotKriteriaSistem 	= [];
			$bobotL 				= [];
			$bobotR 				= [];

			foreach ($this->data['kriteria'] as $kriteria)
			{
				// $bobotKriteriaSistem []= $kriteria->bobot;
				if (!in_array($kriteria->id, $this->data['excluded']['l']))
				{
					$bobotL []= $this->POST('kriteria_l_' . $kriteria->id);	
				}
				else
				{
					$bobotL []= 0;
				}

				if (!in_array($kriteria->id, $this->data['excluded']['r']))
				{
					$bobotR []= $this->POST('kriteria_r_' . $kriteria->id);	
				}
				else
				{
					$bobotR []= 0;
				}
			}

			// $results[0] = $this->executeAnp($bobotKriteriaSistem);
			$results[0] = $this->executeAnp($bobotL);
			$results[1] = $this->executeAnp($bobotR);

			$this->data['result'] = $this->executeBorda($results);
			$bobotNormalisasi = [];
			foreach ($this->data['result'] as $row)
			{
				$bobotNormalisasi []= $row->normalized_score;
			}
			$this->data['result'] 	= $this->data['result']->toArray();
			$this->data['rank']		= [];
			
			$this->data['temp']		= $this->data['result'];
			array_multisort($bobotNormalisasi, SORT_DESC, $this->data['temp']);
			for ($i = 0; $i < count($this->data['temp']); $i++)
			{
				$this->data['rank'][$this->data['temp'][$i]['id'] . '-' . $this->data['temp'][$i]['nama']] = ($i + 1);
			}
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
			redirect('decision-maker/penilaian-karyawan/' . $this->data['id_karyawan']);
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
			
			redirect('decision-maker/data-karyawan');
		}
		$this->data['karyawan']	= Karyawan_m::with('divisi')->get();
		$this->data['title']	= 'Data Karyawan';
		$this->data['content']	= 'data_karyawan';
		$this->template($this->data, $this->module);
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
}