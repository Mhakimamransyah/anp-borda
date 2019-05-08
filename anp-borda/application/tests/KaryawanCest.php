<?php 
require_once __DIR__ . '/../libraries/SpreadsheetHandler.php';

class KaryawanCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {

    	$spreadsheet = new SpreadsheetHandler();
    	$path = 'C:/xampp/htdocs/anp-borda/anp-borda/data/data.xlsx';
		$sheet = $spreadsheet->read($path);
		$data = $spreadsheet->serialize($sheet, 4, 54);
		
		$divisi = [
			'Marketing'			=> 2,
			'Collection'		=> 3,
			'Administration'	=> 4
		];

		$I->amOnPage('/admin/tambah-karyawan');

		foreach ($data as $i => $row)
		{
			$I->fillField('nama', $row[2]);
			$I->fillField('nik', $row[1]);
			$I->selectOption('id_divisi', $divisi[$row[3]]);

			$lamaBekerja = explode(' ', $row[4]);
			$I->fillField('lama_bekerja', $lamaBekerja[0]);
			$I->selectOption('status', $row[5]);
			$I->click('submit');
			$I->see('Data karyawan baru berhasil ditambahkan');

			$I->amOnPage('/admin/penilaian-karyawan/' . ($i + 1));
			
			$I->fillField('#nilai_0', $row[6]);
			$I->fillField('#nilai_1', $row[7]);
			$I->fillField('#nilai_2', $row[8]);
			$I->fillField('#nilai_3', $row[9]);
			$I->fillField('#nilai_4', $row[10]);
			$I->fillField('#nilai_5', $row[11]);
			$I->fillField('#nilai_6', $row[12]);
			$I->fillField('#nilai_7', $row[14]);
			$I->fillField('#nilai_8', $row[15]);
			$I->fillField('#nilai_9', $row[16]);
			$I->fillField('#nilai_10', $row[17]);
			$I->fillField('#nilai_11', $row[18]);
			$I->click('submit');
			$I->see('Data penilaian karyawan berhasil dimasukkan');

			$I->amOnPage('/admin/tambah-karyawan');
		}
    }
}
