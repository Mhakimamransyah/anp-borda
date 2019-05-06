<?php 

class Admin extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->module = 'admin';
	}

	public function index()
	{
		$this->data['title']	= 'Dashboard';
		$this->data['content']	= 'dashboard';
		$this->template($this->data, $this->module);
	}

	public function data_karyawan()
	{
		$this->load->model('Karyawan_m');
		$this->data['karyawan']	= Karyawan_m::get();
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
			$karyawan->nik = $this->POST('nik');
			$karyawan->nama = $this->POST('nama');
			$karyawan->id_divisi = $this->POST('id_divisi');
			$karyawan->lama_bekerja = $this->POST('lama_bekerja');
			$karyawan->status = $this->POST('status');
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