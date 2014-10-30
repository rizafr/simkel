<?php
	class surat_Service {
		private static $instance;
		
		private function __construct() {
		}
		
		public static function getInstance() {
			if (!isset(self::$instance)) {
				$c = __CLASS__;
				self::$instance = new $c;
			}
			return self::$instance;
		}
		
		public function getKodeSurat($id_surat){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT  * from surat where id_surat = $id_surat");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		//contoh autonumber 
		function autonumber($tabel, $kolom, $lebar=0, $awalan='')
		{
			$query="select $kolom from $tabel order by $kolom desc limit 1";
			$hasil=mysql_query($query);
			$jumlahrecord = mysql_num_rows($hasil);
			if($jumlahrecord == 0)
			$nomor=1;
			else
			{
				$row=mysql_fetch_array($hasil);
				$nomor=intval(substr($row[0],strlen($awalan)))+1;
			}
			if($lebar>0)
			$angka = $awalan.str_pad($nomor,$lebar,"0",STR_PAD_LEFT);
			else
			$angka = $awalan.$nomor;
			return $angka;
		}
		
		
		//mendapatkan noregistrasi terakhir autoincrement
		public function getNoRegistrasi($lebar=0, $awalan=''){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("select no_registrasi from no_registrasi order by RIGHT(no_registrasi,4) desc limit 1");
				
				$jumlahrecord = count($result);
				
				if($jumlahrecord == 0)
				$nomor=1;
				elseif($jumlahrecord > 0){					
					$nomor=intval(substr($result,strlen($awalan)))+1;
				}
				if($lebar>0)
				$angka = $awalan.str_pad($nomor,$lebar,"0",STR_PAD_LEFT);
				else
				$angka = $awalan.$nomor;
				return $angka;	
				
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		 function selisih($time_1, $time_2){
			date_default_timezone_set('Asia/Jakarta');
			
			$a = explode(":", $time_1);       
			$b = explode(":", $time_2);          
			
			/* Explode parameter $time_1 */
			$a_hour    = $a[0];
			$a_minutes = $a[1];
			$a_seconds = $a[2];
			
			/* Explode parameter $time_2 */
			$b_hour    = $b[0];
			$b_minutes = $b[1];
			$b_seconds = $b[2];
			
			/* declare result variabel */
			$c_hour    = NULL;
			$c_minutes = NULL;
			$c_seconds = NULL;
			
		   /* -----------------------------------------
			* Pengurangan detik
			* -----------------------------------------
			**/
			if($b_seconds >= $a_seconds)
			{
				$c_seconds = $b_seconds - $a_seconds;
			}
			else
			{
				$c_seconds = ($b_seconds + 60) - $a_seconds;
				$b_minutes--;
			}       
			
		   /* -----------------------------------------
			* Pengurangan menit
			* -----------------------------------------
			**/
			if($b_minutes >= $a_minutes)
			{
				$c_minutes = $b_minutes - $a_minutes;
			}
			else
			{
				$c_minutes = ($b_minutes + 60) - $a_minutes;
				$b_hour--;
			}       
			
		   /* -----------------------------------------
			* Pengurangan jam
			* -----------------------------------------
			**/
			if($b_hour >= $a_hour)
			{
				$c_hour = $b_hour - $a_hour;
			}
			else
			{
				$c_hour = ($a_hour - $b_hour);
			}
			
			/* Checking time format */
			if( strlen($c_seconds) == 1) $c_seconds = '0'.$c_seconds;
			if( strlen($c_minutes) == 1) $c_minutes = '0'.$c_minutes;
			if( strlen($c_hour) == 1) $c_hour = '0'.$c_hour;
			
			/* Return result */
			return $c_hour . ':' . $c_minutes . ':' . $c_seconds;
		}
		
		public function getSimpanNoRegistrasi(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("no_registrasi" => $data['no_registrasi'],
				"nik" => $data['nik']);
				
				$db->insert('no_registrasi',$paramInput);
				$db->commit();
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		public function getsimpanarsip(array $data) {
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("nik" => $data['nik'],
							"nama_surat" => $data['nama_surat'],
							"no_surat" => $data['no_surat'],
							"tanggal_surat" => $data['tanggal_surat'],
							"ruangan" => $data['ruangan'],
							"lemari" => $data['lemari'],
							"rak" => $data['rak'],
							"kotak" => $data['kotak'],
							"data_file" => $data['data_file'],
							"path_file" => $data['path_file']
							);
			
			$db->insert('data_arsip',$paramInput);
			$db->commit();
			return 'sukses';
		} catch (Exception $e) {
			 $db->rollBack();
			 echo $e->getMessage().'<br>';
			 return 'gagal';
		}
	}
		
		
		//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!rumah sakit
		//cetak surat Rumah sakit
		public function getrumahsakitcetak($id_permintaan_rumahsakit){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*, k.alamat as alamat_kelurahan, b.alamat as alamat_warga
										FROM permintaan_rumahsakit a, data_penduduk b, pejabat_kelurahan c, kelurahan k
										WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
										AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_rumahsakit = $id_permintaan_rumahsakit");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		//proses simpan antrian -> status menjadi 1
		public function getsimpanrumahsakitantrian(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_pengguna" =>  	$data['id_pengguna'],
				"id_kelurahan" => $data['id_kelurahan'],
				"no_registrasi" => $data['no_registrasi'],
				"nik" => $data['nik'],
				"waktu_antrian" => $data['waktu_antrian'],
				"antrian_oleh" => $data['antrian_oleh'],
				"jam_masuk" => $data['jam_masuk'],
				"status" => $data['status'],
				"no_telp" => $data['no_telp']
				);
				
				$db->insert('permintaan_rumahsakit',$paramInput);
				$db->commit();
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		public function getProsesRumahSakit($id_kelurahan, $offset, $dataPerPage){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_rumahsakit a, data_penduduk b 
										WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik 
										ORDER BY  a.no_registrasi desc , a.tanggal_surat DESC 
										LIMIT $offset , $dataPerPage");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getJumlahRumahSakit($id_kelurahan){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_rumahsakit where id_kelurahan=$id_kelurahan");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getPencarianRumahSakit($id_kelurahan,$pencarian,$id_pencarian){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 	
				
				if(!$pencarian){
					$result = $db->fetchAll("SELECT a.id_permintaan_rumahsakit, a.no_surat, a.tanggal_surat, b.nik, b.nama, b.rt, b.rw, a.status FROM permintaan_rumahsakit a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
					}else{
					if($id_pencarian==1){
						$result = $db->fetchAll("SELECT a.id_permintaan_rumahsakit, a.no_surat, a.tanggal_surat, b.nik, b.nama, b.rt, b.rw, a.status FROM permintaan_rumahsakit a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
						}else if($id_pencarian==2){
						$result = $db->fetchAll("SELECT a.id_permintaan_rumahsakit, a.no_surat, a.tanggal_surat, b.nik, b.nama, b.rt, b.rw, a.status FROM permintaan_rumahsakit a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
					}
				}
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getrumahsakit($id_permintaan_rumahsakit){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* FROM permintaan_rumahsakit a, data_penduduk b, pejabat_kelurahan c WHERE  a.nik = b.nik  AND a.id_permintaan_rumahsakit = $id_permintaan_rumahsakit");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getsimpanprosesrs(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_kelurahan" => $data['id_kelurahan'],
									"id_pejabat" =>  	$data['id_pejabat'],
									"id_jenis_surat" =>  	$data['id_jenis_surat'],						
									"id_surat" =>  $data['id_surat'],	
									"nik" => $data['nik'],
									"no_kip" => $data['no_kip'],
									"no_jamkesmas" => $data['no_jamkesmas'],
									"peruntukan" => $data['peruntukan'],
									"no_surat" => $data['no_surat'],
									"tanggal_surat" => $data['tanggal_surat'],
									"no_surat_pengantar" => $data['no_surat_pengantar'],
									"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
									"masa_berlaku" => $data['masa_berlaku'],
									"nama_rumahsakit" => $data['nama_rumahsakit'],
									"status" => $data['status'],
									"waktu_proses" => $data['waktu_proses'],
									"proses_oleh" => $data['proses_oleh'],
									"ket" => $data['ket']
									);
				
				$where[] = " id_permintaan_rumahsakit = '".$data['id_permintaan_rumahsakit']."'";
				
				$db->update('permintaan_rumahsakit',$paramInput, $where);
				$db->commit();			
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		
		public function getsimpanprosesrsedit(array $data) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_kelurahan" =>  	$data['id_kelurahan'],
									"id_permintaan_rumahsakit" => $data['id_permintaan_rumahsakit'],
									"id_surat" => $data['id_surat'],
									"id_jenis_surat" => $data['id_jenis_surat'],
									"nik" => $data['nik'],
									"no_kip" => $data['no_kip'],
									"no_jamkesmas" => $data['no_jamkesmas'],
									"peruntukan" => $data['peruntukan'],
									"no_surat" => $data['no_surat'],
									"tanggal_surat" => $data['tanggal_surat'],
									"no_surat_pengantar" => $data['no_surat_pengantar'],
									"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
									"masa_berlaku" => $data['masa_berlaku'],
									"nama_rumahsakit" => $data['nama_rumahsakit']);
				
				$where[] = " id_permintaan_rumahsakit = '".$data['id_permintaan_rumahsakit']."'";
				
				$db->update('permintaan_rumahsakit',$paramInput, $where);
				$db->commit();			
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		public function gethapusrumahsakit($id_permintaan_rumahsakit) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$where[] = " id_permintaan_rumahsakit = '".$id_permintaan_rumahsakit."'";
				
				$db->delete('permintaan_rumahsakit', $where);
				$db->commit();
				
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		
		public function getJumlahStatusRumahsakit1(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_rumahsakit where status='1'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getJumlahStatusRumahsakit2(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_rumahsakit where status='2'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getSelesaiRumahsakit($data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("status" =>  $data['status'],
									"waktu_selesai" => $data['waktu_selesai'],
									"waktu_total" => $data['waktu_total']
				);
				
				$where[] = " id_permintaan_rumahsakit = '".$data['id_permintaan_rumahsakit']."'";
				
				$db->update('permintaan_rumahsakit',$paramInput, $where);
				$db->commit();			
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		////////////////////////////////////////////penduduk
		
		public function getPenduduk($nik){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT  * from data_penduduk where nik = '$nik'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getsimpanpenduduk(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("no_kk" =>  	$data['no_kk'],
						"nama_kep" =>  	$data['nama_kep'],
						"alamat" =>  	$data['alamat'],
						"rt" =>  	$data['rt'],
						"rw" =>  	$data['rw'],
						"dusun" =>  	$data['dusun'],
						"kode_pos" =>  	$data['kode_pos'],
						"nik" =>  	$data['nik'],
						"nama" =>  	$data['nama'],
						"jenis_kelamin" =>  	$data['jenis_kelamin'],
						"tempat_lahir" =>  	$data['tempat_lahir'],
						"tanggal_lahir" =>  	$data['tanggal_lahir'],
						"no_akta" =>  	$data['no_akta'],
						"gol_darah" =>  	$data['gol_darah'],
						"agama" =>  	$data['agama'],
						"pekerjaan" =>  	$data['pekerjaan'],
						"nama_ibu" =>  	$data['nama_ibu'],
						"nama_ayah" =>  	$data['nama_ayah'],
						"status_perkawinan" =>  	$data['status_perkawinan'],
						"id_kelurahan" =>  	$data['id_kelurahan']);
				
				$db->insert('data_penduduk',$paramInput);
				$db->commit();
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		public function getPejabatpemperdayaan($id_kelurahan){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT  * from pejabat_kelurahan where id_kelurahan = $id_kelurahan && id_jenis_pengguna = 3");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getPejabattantrib($id_kelurahan){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT  * from pejabat_kelurahan where id_kelurahan = $id_kelurahan && id_jenis_pengguna = 3");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getPejabatekbang($id_kelurahan){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT  * from pejabat_kelurahan where id_kelurahan = $id_kelurahan && id_jenis_pengguna = 3");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getPejabatpemerintahan($id_kelurahan){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT  * from pejabat_kelurahan where id_kelurahan = $id_kelurahan && id_jenis_pengguna = 3");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getPejabatAll($id_kelurahan){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("SELECT  * from pejabat_kelurahan where id_kelurahan = $id_kelurahan");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		////////////////SEKOLAH
		//cetak surat sekolah
		public function getsekolahcetak($id_permintaan_sekolah){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*, k.alamat as alamat_kelurahan, b.alamat as alamat_warga
										FROM permintaan_sekolah a, data_penduduk b, pejabat_kelurahan c, kelurahan k
										WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
										AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_sekolah = $id_permintaan_sekolah");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getProsesSekolah($id_kelurahan,$offset,$dataPerPage){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_sekolah a, data_penduduk b 
				WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik 
				ORDER BY  a.no_registrasi desc  
				LIMIT $offset , $dataPerPage");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getJumlahSekolah($id_kelurahan){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_sekolah where id_kelurahan=$id_kelurahan");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getPencarianSekolah($id_kelurahan,$pencarian,$id_pencarian){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 	
				
				if(!$pencarian){
					$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_sekolah a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
					}else{
					if($id_pencarian==1){
						$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_sekolah a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
						}else if($id_pencarian==2){
						$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_sekolah a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
					}
				}
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		//proses simpan antrian -> status menjadi 1
		public function getsimpansekolahantrian(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_pengguna" =>  	$data['id_pengguna'],
				"id_kelurahan" => $data['id_kelurahan'],
				"no_registrasi" => $data['no_registrasi'],
				"nik" => $data['nik'],
				"waktu_antrian" => $data['waktu_antrian'],
				"antrian_oleh" => $data['antrian_oleh'],
				"jam_masuk" => $data['jam_masuk'],
				"status" => $data['status'],
				"no_telp" => $data['no_telp']
				);
				
				$db->insert('permintaan_sekolah',$paramInput);
				$db->commit();
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		
		public function getsimpanprosessekolah(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array(	"id_pengguna" =>  	$data['id_pengguna'],
				"id_kelurahan" =>  	$data['id_kelurahan'],
				"id_jenis_surat" =>  	$data['id_jenis_surat'],
				"id_surat" =>  	$data['id_surat'],
				"id_pejabat" =>  	$data['id_pejabat'],
				"nik" => $data['nik'],
				"no_kip" => $data['no_kip'],
				"nama_siswa" => $data['nama_siswa'],
				"tempat_lahir_siswa" => $data['tempat_lahir_siswa'],
				"tanggal_lahir_siswa" => $data['tanggal_lahir_siswa'],
				"no_surat" => $data['no_surat'],
				"tanggal_surat" => $data['tanggal_surat'],
				"no_surat_pengantar" => $data['no_surat_pengantar'],
				"hub_keluarga" => $data['hub_keluarga'],
				"nama_sekolah" => $data['nama_sekolah'],
				"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
				"masa_berlaku" => $data['masa_berlaku'],
				"keperluan" => $data['keperluan'],
				"status" => $data['status'],
				"waktu_proses" => $data['waktu_proses'],
				"proses_oleh" => $data['proses_oleh'],
				"ket" => $data['ket']
				);
				
				$where[] = " id_permintaan_sekolah = '".$data['id_permintaan_sekolah']."'";
				
				$db->update('permintaan_sekolah',$paramInput, $where);
				$db->commit();	
				
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		public function gethapussekolah($id_permintaan_sekolah) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$where[] = " id_permintaan_sekolah = '".$id_permintaan_sekolah."'";
				
				$db->delete('permintaan_sekolah', $where);
				$db->commit();
				
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		public function getsekolah($id_permintaan_sekolah){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* 
				FROM permintaan_sekolah a, data_penduduk b, pejabat_kelurahan c
				WHERE  a.nik = b.nik 
				AND a.id_permintaan_sekolah = $id_permintaan_sekolah");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getsimpanprosessekolahedit(array $data) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_kelurahan" =>  	$data['id_kelurahan'],
				"id_permintaan_sekolah" => $data['id_permintaan_sekolah'],
				"nik" => $data['nik'],
				"no_kip" => $data['no_kip'],
				"nama_siswa" => $data['nama_siswa'],
				"tempat_lahir_siswa" => $data['tempat_lahir_siswa'],
				"tanggal_lahir_siswa" => $data['tanggal_lahir_siswa'],
				"no_surat" => $data['no_surat'],
				"tanggal_surat" => $data['tanggal_surat'],
				"no_surat_pengantar" => $data['no_surat_pengantar'],
				"hub_keluarga" => $data['hub_keluarga'],
				"nama_sekolah" => $data['nama_sekolah'],
				"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
				"masa_berlaku" => $data['masa_berlaku'],
				"keperluan" => $data['keperluan']);
				
				$where[] = " id_permintaan_sekolah = '".$data['id_permintaan_sekolah']."'";
				
				$db->update('permintaan_sekolah',$paramInput, $where);
				$db->commit();			
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		
		public function getJumlahStatusSekolah1(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_sekolah where status='1'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getJumlahStatusSekolah2(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_sekolah where status='2'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getSelesaiSekolah($data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("status" =>  $data['status'],
				"waktu_selesai" => $data['waktu_selesai'],
				"waktu_total" => $data['waktu_total']
				);
				
				$where[] = " id_permintaan_sekolah = '".$data['id_permintaan_sekolah']."'";
				
				$db->update('permintaan_sekolah',$paramInput, $where);
				$db->commit();			
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		//----------------------------------- Keterangan ANDON NIKAH
		//cetak surat andonnikah
		public function getandonnikahcetak($id_permintaan_andonnikah){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*, k.alamat as alamat_kelurahan, b.alamat as alamat_warga
										FROM permintaan_andonnikah a, data_penduduk b, pejabat_kelurahan c, kelurahan k
										WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
										AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_andonnikah = $id_permintaan_andonnikah");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		//proses simpan antrian -> status menjadi 1
		public function getsimpanandonnikahantrian(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_pengguna" =>  	$data['id_pengguna'],
				"id_kelurahan" => $data['id_kelurahan'],
				"no_registrasi" => $data['no_registrasi'],
				"nik" => $data['nik'],
				"waktu_antrian" => $data['waktu_antrian'],
				"antrian_oleh" => $data['antrian_oleh'],
				"jam_masuk" => $data['jam_masuk'],
				"status" => $data['status'],
				"no_telp" => $data['no_telp']
				);
				
				$db->insert('permintaan_andonnikah',$paramInput);
				$db->commit();
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		//proses menampilkan untuk memproses antrian 
		public function getProsesAndonNikah($id_kelurahan,$offset,$dataPerPage){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_andonnikah a, data_penduduk b 
				WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik 
				ORDER BY  a.no_registrasi DESC 
				LIMIT $offset , $dataPerPage");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getJumlahAndonNikah($id_kelurahan){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_andonnikah where id_kelurahan=$id_kelurahan");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getPencarianAndonNikah($id_kelurahan,$pencarian,$id_pencarian){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 	
				
				if(!$pencarian){
					$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_andonnikah a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
					}else{
					if($id_pencarian==1){
						$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_andonnikah a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
						}else if($id_pencarian==2){
						$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_andonnikah a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
					}
				}
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getsimpanprosesandonnikah(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array(	"id_kelurahan" =>  	$data['id_kelurahan'],
				"nik" => $data['nik'],
				"id_pejabat" => $data['id_pejabat'],
				"id_jenis_surat" => $data['id_jenis_surat'],
				"id_surat" => $data['id_surat'],
				"no_surat" => $data['no_surat'],
				"tanggal_surat" => $data['tanggal_surat'],
				"no_surat_pengantar" => $data['no_surat_pengantar'],
				"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
				"nama_pasangan" => $data['nama_pasangan'],
				"alamat_pasangan" => $data['alamat_pasangan'],
				"status" => $data['status'],
				"waktu_proses" => $data['waktu_proses'],
				"proses_oleh" => $data['proses_oleh'],
				"ket" => $data['ket']
				);
				
				$where[] = " id_permintaan_andonnikah = '".$data['id_permintaan_andonnikah']."'";
				
				$db->update('permintaan_andonnikah',$paramInput, $where);
				$db->commit();			
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		
		public function gethapusandonnikah($id_permintaan_andonnikah) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$where[] = " id_permintaan_andonnikah = '".$id_permintaan_andonnikah."'";
				
				$db->delete('permintaan_andonnikah', $where);
				$db->commit();
				
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		public function getandonnikah($id_permintaan_andonnikah){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* 
											FROM permintaan_andonnikah a, data_penduduk b, pejabat_kelurahan c 
											WHERE  a.nik = b.nik  
											AND a.id_permintaan_andonnikah = $id_permintaan_andonnikah");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getsimpanprosesandonnikahedit(array $data) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_kelurahan" =>  	$data['id_kelurahan'],
									"id_permintaan_andonnikah" => $data['id_permintaan_andonnikah'],
									"nik" => $data['nik'],
									"no_surat" => $data['no_surat'],
									"tanggal_surat" => $data['tanggal_surat'],
									"no_surat_pengantar" => $data['no_surat_pengantar'],
									"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
									"nama_pasangan" => $data['nama_pasangan'],
									"alamat_pasangan" => $data['alamat_pasangan']);
				
				$where[] = " id_permintaan_andonnikah = '".$data['id_permintaan_andonnikah']."'";
				
				$db->update('permintaan_andonnikah',$paramInput, $where);
				$db->commit();			
				return 'sukses';
			} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		
		//simpan selesai
		public function getSelesaiAndonnikah($data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("status" =>  $data['status'],
				"waktu_selesai" => $data['waktu_selesai'],
				"waktu_total" => $data['waktu_total']
				);
				
				$where[] = " id_permintaan_andonnikah = '".$data['id_permintaan_andonnikah']."'";
				
				$db->update('permintaan_andonnikah',$paramInput, $where);
				$db->commit();			
				return 'sukses';
			} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		public function getJumlahStatusAndonnikah1(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_andonnikah where status='1'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getJumlahStatusAndonnikah2(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_andonnikah where status='2'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		
		///////////////////// KETERANGAN NIKAH
		//----------------------------------- Keterangan ANDON NIKAH
		//cetak surat na
		public function getnacetak($id_permintaan_na){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*, k.alamat as alamat_kelurahan, b.alamat as alamat_warga
										FROM permintaan_na a, data_penduduk b, pejabat_kelurahan c, kelurahan k
										WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
										AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_na = $id_permintaan_na");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		//proses simpan antrian -> status menjadi 1
		public function getsimpannaantrian(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_pengguna" =>  	$data['id_pengguna'],
				"id_kelurahan" => $data['id_kelurahan'],
				"no_registrasi" => $data['no_registrasi'],
				"nik" => $data['nik'],
				"waktu_antrian" => $data['waktu_antrian'],
				"antrian_oleh" => $data['antrian_oleh'],
				"jam_masuk" => $data['jam_masuk'],
				"status" => $data['status'],
				"no_telp" => $data['no_telp']
				);
				
				$db->insert('permintaan_na',$paramInput);
				$db->commit();
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		//proses menampilkan untuk memproses antrian 
		public function getProsesna($id_kelurahan,$offset,$dataPerPage){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_na a, data_penduduk b 
				WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik 
				ORDER BY  a.no_registrasi DESC 
				LIMIT $offset , $dataPerPage");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getJumlahna($id_kelurahan){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_na where id_kelurahan=$id_kelurahan");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getPencarianna($id_kelurahan,$pencarian,$id_pencarian){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 	
				
				if(!$pencarian){
					$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_na a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
					}else{
					if($id_pencarian==1){
						$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_na a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
						}else if($id_pencarian==2){
						$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_na a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
					}
				}
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getsimpanprosesna(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array(	"id_kelurahan" =>  	$data['id_kelurahan'],
				"nik" => $data['nik'],
				"id_pejabat" => $data['id_pejabat'],
				"id_jenis_surat" => $data['id_jenis_surat'],
				"id_surat" => $data['id_surat'],
				"no_surat" => $data['no_surat'],
				"tanggal_surat" => $data['tanggal_surat'],
				"no_surat_pengantar" => $data['no_surat_pengantar'],
				"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
				"nama_pasangan" => $data['nama_pasangan'],
				"alamat_pasangan" => $data['alamat_pasangan'],
				"status" => $data['status'],
				"waktu_proses" => $data['waktu_proses'],
				"proses_oleh" => $data['proses_oleh'],
				"ket" => $data['ket']
				);
				
				$where[] = " id_permintaan_na = '".$data['id_permintaan_na']."'";
				
				$db->update('permintaan_na',$paramInput, $where);
				$db->commit();			
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		
		public function gethapusna($id_permintaan_na) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$where[] = " id_permintaan_na = '".$id_permintaan_na."'";
				
				$db->delete('permintaan_na', $where);
				$db->commit();
				
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		public function getna($id_permintaan_na){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* 
											FROM permintaan_na a, data_penduduk b, pejabat_kelurahan c 
											WHERE  a.nik = b.nik  
											AND a.id_permintaan_na = $id_permintaan_na");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getsimpanprosesnaedit(array $data) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_kelurahan" =>  	$data['id_kelurahan'],
									"id_permintaan_na" => $data['id_permintaan_na'],
									"nik" => $data['nik'],
									"no_surat" => $data['no_surat'],
									"tanggal_surat" => $data['tanggal_surat'],
									"no_surat_pengantar" => $data['no_surat_pengantar'],
									"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
									"nama_pasangan" => $data['nama_pasangan'],
									"alamat_pasangan" => $data['alamat_pasangan']);
				
				$where[] = " id_permintaan_na = '".$data['id_permintaan_na']."'";
				
				$db->update('permintaan_na',$paramInput, $where);
				$db->commit();			
				return 'sukses';
			} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		
		//simpan selesai
		public function getSelesaina($data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("status" =>  $data['status'],
				"waktu_selesai" => $data['waktu_selesai'],
				"waktu_total" => $data['waktu_total']
				);
				
				$where[] = " id_permintaan_na = '".$data['id_permintaan_na']."'";
				
				$db->update('permintaan_na',$paramInput, $where);
				$db->commit();			
				return 'sukses';
			} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		public function getJumlahStatusna1(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_na where status='1'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getJumlahStatusna2(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_na where status='2'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		
		////////////////////////////////////BELUM MENIKAH
		//cetak surat belum nikah cetak
		public function getbelummenikahcetak($id_permintaan_belummenikah){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*, k.alamat as alamat_kelurahan, b.alamat as alamat_warga
										FROM permintaan_belummenikah a, data_penduduk b, pejabat_kelurahan c, kelurahan k
										WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
										AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_belummenikah = $id_permintaan_belummenikah");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		//proses simpan antrian -> status menjadi 1
		public function getsimpanbelummenikahantrian(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_pengguna" =>  	$data['id_pengguna'],
				"id_kelurahan" => $data['id_kelurahan'],
				"no_registrasi" => $data['no_registrasi'],
				"nik" => $data['nik'],
				"waktu_antrian" => $data['waktu_antrian'],
				"antrian_oleh" => $data['antrian_oleh'],
				"jam_masuk" => $data['jam_masuk'],
				"status" => $data['status'],
				"no_telp" => $data['no_telp']
				);
				
				$db->insert('permintaan_belummenikah',$paramInput);
				$db->commit();
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		
		public function getProsesBelumMenikah($id_kelurahan,$offset,$dataPerPage){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_belummenikah a, data_penduduk b 
				WHERE a.id_kelurahan = $id_kelurahan 
				AND a.nik = b.nik 
				ORDER BY a.no_registrasi desc LIMIT $offset , $dataPerPage");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getJumlahbm($id_kelurahan){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_belummenikah where id_kelurahan=$id_kelurahan");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getPencarianBelumMenikah($id_kelurahan,$pencarian,$id_pencarian){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 	
				
				if(!$pencarian){
					$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_belummenikah a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
					}else{
					if($id_pencarian==1){
						$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_belummenikah a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
						}else if($id_pencarian==2){
						$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_belummenikah a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
					}
				}
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getsimpanprosesbelummenikah(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_kelurahan" =>  	$data['id_kelurahan'],
				"nik" => $data['nik'],
				"id_pejabat" => $data['id_pejabat'],
				"id_jenis_surat" => $data['id_jenis_surat'],
				"id_surat" => $data['id_surat'],
				"no_surat" => $data['no_surat'],						
				"no_surat" => $data['no_surat'],
				"tanggal_surat" => $data['tanggal_surat'],
				"no_surat_pengantar" => $data['no_surat_pengantar'],
				"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
				"keperluan" => $data['keperluan'],
				"status" => $data['status'],
				"waktu_proses" => $data['waktu_proses'],
				"proses_oleh" => $data['proses_oleh'],
				"ket" => $data['ket']);
				
				$where[] = " id_permintaan_belummenikah = '".$data['id_permintaan_belummenikah']."'";
				
				$db->update('permintaan_belummenikah',$paramInput, $where);
				$db->commit();
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		public function gethapusbelummenikah($id_permintaan_belummenikah) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$where[] = " id_permintaan_belummenikah = '".$id_permintaan_belummenikah."'";
				
				$db->delete('permintaan_belummenikah', $where);
				$db->commit();
				
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		
		// menampilkan keseluruhan  
		public function getbelummenikah($id_permintaan_belummenikah){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* 
				FROM permintaan_belummenikah a, data_penduduk b, pejabat_kelurahan c 
				WHERE  a.nik = b.nik 											
				AND a.id_permintaan_belummenikah = $id_permintaan_belummenikah");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getsimpanprosesbelummenikahedit(array $data) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_kelurahan" =>  	$data['id_kelurahan'],
				"id_permintaan_belummenikah" => $data['id_permintaan_belummenikah'],
				"nik" => $data['nik'],
				"no_surat" => $data['no_surat'],
				"tanggal_surat" => $data['tanggal_surat'],
				"no_surat_pengantar" => $data['no_surat_pengantar'],
				"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
				"keperluan" => $data['keperluan']);
				
				$where[] = " id_permintaan_belummenikah = '".$data['id_permintaan_belummenikah']."'";
				
				$db->update('permintaan_belummenikah',$paramInput, $where);
				$db->commit();			
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		
		public function getJumlahStatusbelummenikah1(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_belummenikah where status='1'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getJumlahStatusbelummenikah2(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_belummenikah where status='2'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		//simpan selesai
		public function getSelesaiBelummenikah($data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("status" =>  $data['status'],
				"waktu_selesai" => $data['waktu_selesai'],
				"waktu_total" => $data['waktu_total']
				);
				
				$where[] = " id_permintaan_belummenikah = '".$data['id_permintaan_belummenikah']."'";
				
				$db->update('permintaan_belummenikah',$paramInput, $where);
				$db->commit();			
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		////////////////////////////////////BELUM MEMPUNYAI RUMAH
	    //cetak surat BPR
		public function getbprcetak($id_permintaan_bpr){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*, k.alamat as alamat_kelurahan, b.alamat as alamat_warga
										FROM permintaan_bpr a, data_penduduk b, pejabat_kelurahan c, kelurahan k
										WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
										AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_bpr = $id_permintaan_bpr");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		
		//proses simpan antrian -> status menjadi 1
		public function getsimpanbprantrian(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_pengguna" =>  	$data['id_pengguna'],
				"id_kelurahan" => $data['id_kelurahan'],
				"no_registrasi" => $data['no_registrasi'],
				"nik" => $data['nik'],
				"waktu_antrian" => $data['waktu_antrian'],
				"antrian_oleh" => $data['antrian_oleh'],
				"jam_masuk" => $data['jam_masuk'],
				"status" => $data['status'],
				"no_telp" => $data['no_telp']
				);
				
				$db->insert('permintaan_bpr',$paramInput);
				$db->commit();
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		public function getProsesbpr($id_kelurahan,$offset,$dataPerPage){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("SELECT a.*, b.* 
				FROM permintaan_bpr a, data_penduduk b 
				WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik 
				order by a.no_registrasi desc, a.tanggal_surat desc LIMIT $offset , $dataPerPage");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getJumlahbpr($id_kelurahan){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_bpr where id_kelurahan=$id_kelurahan");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getPencarianbpr($id_kelurahan,$pencarian,$id_pencarian){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 	
				
				if(!$pencarian){
					$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_bpr a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
					}else{
					if($id_pencarian==1){
						$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_bpr a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
						}else if($id_pencarian==2){
						$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_bpr a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
					}
				}
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getsimpanprosesbpr(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_kelurahan" =>  	$data['id_kelurahan'],
				"nik" => $data['nik'],
				"id_pejabat" => $data['id_pejabat'],
				"id_jenis_surat" => $data['id_jenis_surat'],
				"id_surat" => $data['id_surat'],
				"no_surat" => $data['no_surat'],
				"tanggal_surat" => $data['tanggal_surat'],
				"no_surat_pengantar" => $data['no_surat_pengantar'],
				"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
				"keperluan" => $data['keperluan'],
				"stl" => $data['stl'],
				"status" => $data['status'],
				"waktu_proses" => $data['waktu_proses'],
				"proses_oleh" => $data['proses_oleh'],
				"ket" => $data['ket']
				);
				
				$where[] = " id_permintaan_bpr = '".$data['id_permintaan_bpr']."'";
				
				$db->update('permintaan_bpr',$paramInput, $where);
				$db->commit();	
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		public function gethapusbpr($id_permintaan_bpr) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$where[] = " id_permintaan_bpr = '".$id_permintaan_bpr."'";
				
				$db->delete('permintaan_bpr', $where);
				$db->commit();
				
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		public function getbpr($id_permintaan_bpr){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* FROM permintaan_bpr a, data_penduduk b, pejabat_kelurahan c WHERE  a.nik = b.nik AND a.id_permintaan_bpr = $id_permintaan_bpr");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getsimpanprosesbpredit(array $data) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_kelurahan" =>  	$data['id_kelurahan'],
				"id_permintaan_bpr" => $data['id_permintaan_bpr'],
				"nik" => $data['nik'],
				"no_surat" => $data['no_surat'],
				"tanggal_surat" => $data['tanggal_surat'],
				"no_surat_pengantar" => $data['no_surat_pengantar'],
				"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
				"keperluan" => $data['keperluan'],
				"stl" => $data['stl']);
				
				$where[] = " id_permintaan_bpr = '".$data['id_permintaan_bpr']."'";
				
				$db->update('permintaan_bpr',$paramInput, $where);
				$db->commit();			
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		
		public function getJumlahStatusbpr1(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_bpr where status='1'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getJumlahStatusbpr2(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_bpr where status='2'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		//simpan selesai
		public function getSelesaiBpr($data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("status" =>  $data['status'],
				"waktu_selesai" => $data['waktu_selesai'],
				"waktu_total" => $data['waktu_total']
				);
				
				$where[] = " id_permintaan_bpr = '".$data['id_permintaan_bpr']."'";
				
				$db->update('permintaan_bpr',$paramInput, $where);
				$db->commit();			
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		
		
		
		////////////////////////////////////IBADAH HAJI
	    //cetak surat ibadah haji
		public function getibadahhajicetak($id_permintaan_ibadahhaji){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*, k.alamat as alamat_kelurahan, b.alamat as alamat_warga
										FROM permintaan_ibadahhaji a, data_penduduk b, pejabat_kelurahan c, kelurahan k
										WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
										AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_ibadahhaji = $id_permintaan_ibadahhaji");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		//proses simpan antrian -> status menjadi 1
		public function getsimpanibadahhajiantrian(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_pengguna" =>  	$data['id_pengguna'],
				"id_kelurahan" => $data['id_kelurahan'],
				"no_registrasi" => $data['no_registrasi'],
				"nik" => $data['nik'],
				"waktu_antrian" => $data['waktu_antrian'],
				"antrian_oleh" => $data['antrian_oleh'],
				"jam_masuk" => $data['jam_masuk'],
				"status" => $data['status'],
				"no_telp" => $data['no_telp']
				);
				
				$db->insert('permintaan_ibadahhaji',$paramInput);
				$db->commit();
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		public function getProsesibadahhaji($id_kelurahan,$offset,$dataPerPage){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_ibadahhaji a, data_penduduk b
				WHERE a.id_kelurahan = $id_kelurahan 
				AND a.nik = b.nik 
				order by a.no_registrasi desc, a.tanggal_surat desc 
				LIMIT $offset , $dataPerPage");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getJumlahih($id_kelurahan){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_ibadahhaji where id_kelurahan=$id_kelurahan");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getPencarianib($id_kelurahan,$pencarian,$id_pencarian){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 	
				
				if(!$pencarian){
					$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_ibadahhaji a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
					}else{
					if($id_pencarian==1){
						$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_ibadahhaji a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
						}else if($id_pencarian==2){
						$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_ibadahhaji a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
					}
				}
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getsimpanprosesibadahhaji(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_kelurahan" =>  	$data['id_kelurahan'],
				"nik" => $data['nik'],
				"id_pejabat" => $data['id_pejabat'],
				"id_jenis_surat" => $data['id_jenis_surat'],
				"id_surat" => $data['id_surat'],
				"no_surat" => $data['no_surat'],
				"tanggal_surat" => $data['tanggal_surat'],
				"no_surat_pengantar" => $data['no_surat_pengantar'],
				"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
				"status" => $data['status'],
				"waktu_proses" => $data['waktu_proses'],
				"proses_oleh" => $data['proses_oleh'],
				"ket" => $data['ket']);
				
				$where[] = " id_permintaan_ibadahhaji = '".$data['id_permintaan_ibadahhaji']."'";
				
				$db->update('permintaan_ibadahhaji',$paramInput, $where);
				$db->commit();	
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		public function gethapusibadahhaji($id_permintaan_ibadahhaji) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$where[] = " id_permintaan_ibadahhaji = '".$id_permintaan_ibadahhaji."'";
				
				$db->delete('permintaan_ibadahhaji', $where);
				$db->commit();
				
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		
		public function getibadahhaji($id_permintaan_ibadahhaji){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* 
				FROM permintaan_ibadahhaji a, data_penduduk b, pejabat_kelurahan c 
				WHERE  a.nik = b.nik  AND a.id_permintaan_ibadahhaji = $id_permintaan_ibadahhaji");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getsimpanprosesibadahhajiedit(array $data) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_kelurahan" =>  	$data['id_kelurahan'],
				"id_permintaan_ibadahhaji" => $data['id_permintaan_ibadahhaji'],
				"nik" => $data['nik'],
				"no_surat" => $data['no_surat'],
				"tanggal_surat" => $data['tanggal_surat'],
				"no_surat_pengantar" => $data['no_surat_pengantar'],
				"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar']);
				
				$where[] = " id_permintaan_ibadahhaji = '".$data['id_permintaan_ibadahhaji']."'";
				
				$db->update('permintaan_ibadahhaji',$paramInput, $where);
				$db->commit();			
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		
		public function getJumlahStatusibadahhaji1(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_ibadahhaji where status='1'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getJumlahStatusibadahhaji2(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_ibadahhaji where status='2'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		//simpan selesai
		public function getSelesaiIbadahhaji($data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("status" =>  $data['status'],
				"waktu_selesai" => $data['waktu_selesai'],
				"waktu_total" => $data['waktu_total']
				);
				
				$where[] = " id_permintaan_ibadahhaji = '".$data['id_permintaan_ibadahhaji']."'";
				
				$db->update('permintaan_ibadahhaji',$paramInput, $where);
				$db->commit();			
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		////////////////////////////////////JANDA
		//cetak surat Janda
		public function getjandacetak($id_permintaan_janda){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*, k.alamat as alamat_kelurahan, b.alamat as alamat_warga
										FROM permintaan_janda a, data_penduduk b, pejabat_kelurahan c, kelurahan k
										WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
										AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_janda = $id_permintaan_janda");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		//proses simpan antrian -> status menjadi 1
		public function getsimpanjandaantrian(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_pengguna" =>  	$data['id_pengguna'],
				"id_kelurahan" => $data['id_kelurahan'],
				"no_registrasi" => $data['no_registrasi'],
				"nik" => $data['nik'],
				"waktu_antrian" => $data['waktu_antrian'],
				"antrian_oleh" => $data['antrian_oleh'],
				"jam_masuk" => $data['jam_masuk'],
				"status" => $data['status'],
				"no_telp" => $data['no_telp']
				);
				
				$db->insert('permintaan_janda',$paramInput);
				$db->commit();
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		public function getProsesjanda($id_kelurahan,$offset,$dataPerPage){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_janda a, data_penduduk b 
				WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik 
				order by a.no_registrasi desc, a.tanggal_surat desc LIMIT $offset , $dataPerPage");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getJumlahJanda($id_kelurahan){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_janda where id_kelurahan=$id_kelurahan");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getPencarianjanda($id_kelurahan,$pencarian,$id_pencarian){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 	
				
				if(!$pencarian){
					$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_janda a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik LIMIT 0 , 30");
					}else{
					if($id_pencarian==1){
						$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_janda a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik AND a.no_surat = '$pencarian'  LIMIT 0 , 30");
						}else if($id_pencarian==2){
						$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_janda a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
					}
				}
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getsimpanprosesjanda(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_kelurahan" =>  	$data['id_kelurahan'],
				"id_pejabat" => $data['id_pejabat'],
				"nik" => $data['nik'],
				"id_jenis_surat" => $data['id_jenis_surat'],
				"id_surat" => $data['id_surat'],
				"no_surat" => $data['no_surat'],
				"tanggal_surat" => $data['tanggal_surat'],
				"no_surat_pengantar" => $data['no_surat_pengantar'],
				"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
				"sebab_janda" => $data['sebab_janda'],
				"keperluan" => $data['keperluan'],
				"status" => $data['status'],
				"waktu_proses" => $data['waktu_proses'],
				"proses_oleh" => $data['proses_oleh'],
				"ket" => $data['ket']);
				
				$where[] = " id_permintaan_janda= '".$data['id_permintaan_janda']."'";
				
				$db->update('permintaan_janda',$paramInput, $where);
				$db->commit();	
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		public function gethapusjanda($id_permintaan_janda) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$where[] = " id_permintaan_janda = '".$id_permintaan_janda."'";
				
				$db->delete('permintaan_janda', $where);
				$db->commit();
				
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		public function getjanda($id_permintaan_janda){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* 
				FROM permintaan_janda a, data_penduduk b, pejabat_kelurahan c 
				WHERE  a.nik = b.nik 
				AND a.id_permintaan_janda = $id_permintaan_janda");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getsimpanprosesjandaedit(array $data) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_kelurahan" =>  	$data['id_kelurahan'],
				"id_permintaan_janda" => $data['id_permintaan_janda'],
				"nik" => $data['nik'],
				"no_surat" => $data['no_surat'],
				"tanggal_surat" => $data['tanggal_surat'],
				"no_surat_pengantar" => $data['no_surat_pengantar'],
				"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
				"sebab_janda" => $data['sebab_janda'],
				"keperluan" => $data['keperluan']);
				
				$where[] = " id_permintaan_janda = '".$data['id_permintaan_janda']."'";
				
				$db->update('permintaan_janda',$paramInput, $where);
				$db->commit();			
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		
		public function getJumlahStatusjanda1(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_janda where status='1'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getJumlahStatusjanda2(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_janda where status='2'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		//simpan selesai
		public function getSelesaiJanda($data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("status" =>  $data['status'],
				"waktu_selesai" => $data['waktu_selesai'],
				"waktu_total" => $data['waktu_total']
				);
				
				$where[] = " id_permintaan_janda = '".$data['id_permintaan_janda']."'";
				
				$db->update('permintaan_janda',$paramInput, $where);
				$db->commit();			
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		
		////////////////////////////////////IJIN KERAMAIAN
		//cetak surat Ijin Keramaian
		public function getikcetak($id_permintaan_ik){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*, k.alamat as alamat_kelurahan, b.alamat as alamat_warga
										FROM permintaan_ik a, data_penduduk b, pejabat_kelurahan c, kelurahan k
										WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
										AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_ik = $id_permintaan_ik");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		//proses simpan antrian -> status menjadi 1
		public function getsimpanikantrian(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_pengguna" =>  	$data['id_pengguna'],
				"id_kelurahan" => $data['id_kelurahan'],
				"no_registrasi" => $data['no_registrasi'],
				"nik" => $data['nik'],
				"waktu_antrian" => $data['waktu_antrian'],
				"antrian_oleh" => $data['antrian_oleh'],
				"jam_masuk" => $data['jam_masuk'],
				"status" => $data['status'],
				"no_telp" => $data['no_telp']
				);
				
				$db->insert('permintaan_ik',$paramInput);
				$db->commit();
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		
		public function getProsesik($id_kelurahan,$offset,$dataPerPage){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_ik a, data_penduduk b 
				WHERE a.id_kelurahan = $id_kelurahan 
				AND a.nik = b.nik 
				order by  a.no_registrasi desc, a.tanggal_surat desc LIMIT $offset , $dataPerPage");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getJumlahik($id_kelurahan){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_ik where id_kelurahan=$id_kelurahan");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getPencarianik($id_kelurahan,$pencarian,$id_pencarian){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 	
				
				if(!$pencarian){
					$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_ik a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
					}else{
					if($id_pencarian==1){
						$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_ik a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
						}else if($id_pencarian==2){
						$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_ik a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
					}
				}
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getsimpanprosesik(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_kelurahan" =>  	$data['id_kelurahan'],
				"nik" => $data['nik'],
				"id_pejabat" => $data['id_pejabat'],
				"id_jenis_surat" => $data['id_jenis_surat'],
				"id_surat" => $data['id_surat'],
				"no_surat" => $data['no_surat'],
				"tanggal_surat" => $data['tanggal_surat'],
				"no_surat_pengantar" => $data['no_surat_pengantar'],
				"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],

				"nama_kegiatan" => $data['nama_kegiatan'],
				"tempat_kegiatan" => $data['tempat_kegiatan'],
				"hiburan" => $data['hiburan'],
				"hari_kegiatan" => $data['hari_kegiatan'],
				"tanggal_kegiatan" => $data['tanggal_kegiatan'],
				"waktu" => $data['waktu'],
				
				"status" => $data['status'],
				"waktu_proses" => $data['waktu_proses'],
				"proses_oleh" => $data['proses_oleh'],
				"ket" => $data['ket']
				);
				
				
				$where[] = " id_permintaan_ik = '".$data['id_permintaan_ik']."'";
				
				$db->update('permintaan_ik',$paramInput, $where);
				$db->commit();	
				
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		public function gethapusik($id_permintaan_ik) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$where[] = " id_permintaan_ik = '".$id_permintaan_ik."'";
				
				$db->delete('permintaan_ik', $where);
				$db->commit();
				
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		public function getik($id_permintaan_ik){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* 
				FROM permintaan_ik a, data_penduduk b, pejabat_kelurahan c 
				WHERE  a.nik = b.nik 
				AND a.id_permintaan_ik = $id_permintaan_ik");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getsimpanprosesikedit(array $data) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_kelurahan" =>  	$data['id_kelurahan'],
				"id_permintaan_ik" => $data['id_permintaan_ik'],
				"nik" => $data['nik'],
				"no_surat" => $data['no_surat'],
				"tanggal_surat" => $data['tanggal_surat'],
				"no_surat_pengantar" => $data['no_surat_pengantar'],
				"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
				
				"nama_kegiatan" => $data['nama_kegiatan'],
				"tempat_kegiatan" => $data['tempat_kegiatan'],
				"hiburan" => $data['hiburan'],
				"hari_kegiatan" => $data['hari_kegiatan'],
				"tanggal_kegiatan" => $data['tanggal_kegiatan'],
				"waktu" => $data['waktu']
				);
				
				$where[] = " id_permintaan_ik = '".$data['id_permintaan_ik']."'";
				
				$db->update('permintaan_ik',$paramInput, $where);
				$db->commit();			
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		
		public function getJumlahStatusik1(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_ik where status='1'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getJumlahStatusik2(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_ik where status='2'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		//simpan selesai
		public function getSelesaiIk($data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("status" =>  $data['status'],
				"waktu_selesai" => $data['waktu_selesai'],
				"waktu_total" => $data['waktu_total']
				);
				
				$where[] = " id_permintaan_ik = '".$data['id_permintaan_ik']."'";
				
				$db->update('permintaan_ik',$paramInput, $where);
				$db->commit();			
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		
		////////////////////////////////////BELUM Pengantar SKCK
		//cetak surat Pengantar SKCK
		public function getpscetak($id_permintaan_ps){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*, k.alamat as alamat_kelurahan, b.alamat as alamat_warga
										FROM permintaan_ps a, data_penduduk b, pejabat_kelurahan c, kelurahan k
										WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
										AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_ps = $id_permintaan_ps");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		//proses simpan antrian -> status menjadi 1
		public function getsimpanpsantrian(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_pengguna" =>  	$data['id_pengguna'],
										"id_kelurahan" => $data['id_kelurahan'],
										"no_registrasi" => $data['no_registrasi'],
										"nik" => $data['nik'],
										"waktu_antrian" => $data['waktu_antrian'],
										"antrian_oleh" => $data['antrian_oleh'],
										"jam_masuk" => $data['jam_masuk'],
										"status" => $data['status'],
										"no_telp" => $data['no_telp']
									);
				
				$db->insert('permintaan_ps',$paramInput);
				$db->commit();
				return 'sukses';
				
			} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		
		public function getProsesps($id_kelurahan,$offset,$dataPerPage){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_ps a, data_penduduk b 
															WHERE a.id_kelurahan = $id_kelurahan 
															AND a.nik = b.nik 
															ORDER BY  a.no_registrasi DESC , a.tanggal_surat desc 
															LIMIT $offset , $dataPerPage");
				return $result;
			} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getJumlahps($id_kelurahan){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_ps where id_kelurahan=$id_kelurahan");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getPencarianps($id_kelurahan,$pencarian,$id_pencarian){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 	
				
				if(!$pencarian){
					$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_ps a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
					}else{
					if($id_pencarian==1){
						$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_ps a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
						}else if($id_pencarian==2){
						$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_ps a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
					}
				}
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getsimpanprosesps(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_kelurahan" =>  	$data['id_kelurahan'],
									"id_pejabat" => $data['id_pejabat'],
									"id_jenis_surat" => $data['id_jenis_surat'],
									"id_surat" => $data['id_surat'],
									"nik" => $data['nik'],
									"no_surat" => $data['no_surat'],
									"tanggal_surat" => $data['tanggal_surat'],
									"no_surat_pengantar" => $data['no_surat_pengantar'],
									"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
									"keperluan" => $data['keperluan'],
									"status" => $data['status'],
									"waktu_proses" => $data['waktu_proses'],
									"proses_oleh" => $data['proses_oleh'],
									"ket" => $data['ket']
								);
				
				$where[] = " id_permintaan_ps = '".$data['id_permintaan_ps']."'";
				
				$db->update('permintaan_ps',$paramInput, $where);
				$db->commit();
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		public function gethapusps($id_permintaan_ps) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$where[] = " id_permintaan_ps = '".$id_permintaan_ps."'";
				
				$db->delete('permintaan_ps', $where);
				$db->commit();
				
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		public function getps($id_permintaan_ps){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* 
											FROM permintaan_ps a, data_penduduk b, pejabat_kelurahan c 
											WHERE  a.nik = b.nik 
											AND a.id_permintaan_ps = $id_permintaan_ps");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getsimpanprosespsedit(array $data) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_kelurahan" =>  	$data['id_kelurahan'],
									"id_permintaan_ps" => $data['id_permintaan_ps'],
									"nik" => $data['nik'],
									"no_surat" => $data['no_surat'],
									"tanggal_surat" => $data['tanggal_surat'],
									"no_surat_pengantar" => $data['no_surat_pengantar'],
									"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
									"keperluan" => $data['keperluan']);
				
				$where[] = " id_permintaan_ps = '".$data['id_permintaan_ps']."'";
				
				$db->update('permintaan_ps',$paramInput, $where);
				$db->commit();			
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		
		public function getJumlahStatusps1(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_ps where status='1'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getJumlahStatusps2(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_ps where status='2'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		
		//simpan selesai
		public function getSelesaiPs($data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("status" =>  $data['status'],
									"waktu_selesai" => $data['waktu_selesai'],
									"waktu_total" => $data['waktu_total']
				);
				
				$where[] = " id_permintaan_ps = '".$data['id_permintaan_ps']."'";
				
				$db->update('permintaan_ps',$paramInput, $where);
				$db->commit();			
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		
		////////////////////////////////////BERSIH DIRI
		//cetak surat Bersih Diri
		public function getbdcetak($id_permintaan_bd){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*, k.alamat as alamat_kelurahan, b.alamat as alamat_warga
										FROM permintaan_bd a, data_penduduk b, pejabat_kelurahan c, kelurahan k
										WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
										AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_bd = $id_permintaan_bd");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		//proses simpan antrian -> status menjadi 1
		public function getsimpanbdantrian(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_pengguna" =>  	$data['id_pengguna'],
									"id_kelurahan" => $data['id_kelurahan'],
									"no_registrasi" => $data['no_registrasi'],
									"nik" => $data['nik'],
									"waktu_antrian" => $data['waktu_antrian'],
									"antrian_oleh" => $data['antrian_oleh'],
									"jam_masuk" => $data['jam_masuk'],
									"status" => $data['status'],
				"no_telp" => $data['no_telp']
				);
				
				$db->insert('permintaan_bd',$paramInput);
				$db->commit();
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		public function getProsesbd($id_kelurahan,$offset,$dataPerPage){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_bd a, data_penduduk b 
											WHERE a.id_kelurahan = $id_kelurahan 
											AND a.nik = b.nik 
											order by  a.no_registrasi desc, a.tanggal_surat desc 
											LIMIT $offset , $dataPerPage");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getJumlahbd($id_kelurahan){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_bd where id_kelurahan=$id_kelurahan");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getPencarianbd($id_kelurahan,$pencarian,$id_pencarian){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 	
				
				if(!$pencarian){
					$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_bd a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
					}else{
					if($id_pencarian==1){
						$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_bd a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
						}else if($id_pencarian==2){
						$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_bd a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
					}
				}
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getsimpanprosesbd(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_kelurahan" =>  	$data['id_kelurahan'],
									"nik" => $data['nik'],
									"id_pejabat" => $data['id_pejabat'],
									"id_jenis_surat" => $data['id_jenis_surat'],
									"id_surat" => $data['id_surat'],
									"alamat_ayah" => $data['alamat_ayah'],
									"pekerjaan_ayah" => $data['pekerjaan_ayah'],
									"agama_ayah" => $data['agama_ayah'],
									"agama_ibu" => $data['agama_ibu'],
									"alamat_ibu" => $data['alamat_ibu'],
									"pekerjaan_ibu" => $data['pekerjaan_ibu'],
									"no_surat" => $data['no_surat'],
									"tanggal_surat" => $data['tanggal_surat'],
									"no_surat_pengantar" => $data['no_surat_pengantar'],
									"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
									"keperluan" => $data['keperluan'],
									"status" => $data['status'],
									"waktu_proses" => $data['waktu_proses'],
									"proses_oleh" => $data['proses_oleh'],
									"ket" => $data['ket']);
				
				$where[] = " id_permintaan_bd = '".$data['id_permintaan_bd']."'";
				
				$db->update('permintaan_bd',$paramInput, $where);
				$db->commit();	
				return 'sukses';
				} catch (Exception $e) {
					$db->rollBack();
					echo $e->getMessage().'<br>';
					return 'gagal';
			}
		}
		public function gethapusbd($id_permintaan_bd) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$where[] = " id_permintaan_bd = '".$id_permintaan_bd."'";
				
				$db->delete('permintaan_bd', $where);
				$db->commit();
				
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		public function getbd($id_permintaan_bd){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* 
											FROM permintaan_bd a, data_penduduk b, pejabat_kelurahan c 
											WHERE  a.nik = b.nik 
											AND a.id_permintaan_bd = $id_permintaan_bd");
				return $result;
			} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getsimpanprosesbdedit(array $data) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_kelurahan" =>  	$data['id_kelurahan'],
									"id_permintaan_bd" => $data['id_permintaan_bd'],
									"nik" => $data['nik'],
									"alamat_ayah" => $data['alamat_ayah'],
									"pekerjaan_ayah" => $data['pekerjaan_ayah'],
									"agama_ayah" => $data['agama_ayah'],
									"alamat_ibu" => $data['alamat_ibu'],
									"pekerjaan_ibu" => $data['pekerjaan_ibu'],
									"agama_ibu" => $data['agama_ibu'],
									"no_surat" => $data['no_surat'],
									"tanggal_surat" => $data['tanggal_surat'],
									"no_surat_pengantar" => $data['no_surat_pengantar'],
									"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
									"keperluan" => $data['keperluan']);
				
				$where[] = " id_permintaan_bd = '".$data['id_permintaan_bd']."'";
				
				$db->update('permintaan_bd',$paramInput, $where);
				$db->commit();			
				return 'sukses';
			
			} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		
		public function getJumlahStatusbd1(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_bd where status='1'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getJumlahStatusbd2(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_bd where status='2'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		//simpan selesai
		public function getSelesaiBd($data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("status" =>  $data['status'],
									"waktu_selesai" => $data['waktu_selesai'],
									"waktu_total" => $data['waktu_total']
									);
				
				$where[] = " id_permintaan_bd = '".$data['id_permintaan_bd']."'";
				
				$db->update('permintaan_bd',$paramInput, $where);
				$db->commit();			
				return 'sukses';
				
			} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		
		
		//////////////////////DOMISILI YAYASAN
		//cetak surat domisiliyayasan
		public function getdomisiliyayasancetak($id_permintaan_domisili_yayasan){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*, k.alamat as alamat_kelurahan, b.alamat as alamat_warga
										FROM permintaan_domisili_yayasan a, data_penduduk b, pejabat_kelurahan c, kelurahan k
										WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
										AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_domisili_yayasan = $id_permintaan_domisili_yayasan");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		//proses simpan antrian -> status menjadi 1
		public function getsimpandomisiliyayasanantrian(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_pengguna" =>  	$data['id_pengguna'],
									"id_kelurahan" => $data['id_kelurahan'],
									"no_registrasi" => $data['no_registrasi'],
									"nik" => $data['nik'],
									"waktu_antrian" => $data['waktu_antrian'],
									"antrian_oleh" => $data['antrian_oleh'],
									"jam_masuk" => $data['jam_masuk'],
									"status" => $data['status'],
									"no_telp" => $data['no_telp']
									);
									
				$db->insert('permintaan_domisili_yayasan',$paramInput);
				$db->commit();
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		public function getProsesdomisiliyayasan($id_kelurahan,$offset,$dataPerPage){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("SELECT a.*, b.* 
											FROM permintaan_domisili_yayasan a, data_penduduk b 
											WHERE a.id_kelurahan = $id_kelurahan 
											AND a.nik = b.nik 
											ORDER BY a.no_registrasi desc
											LIMIT $offset , $dataPerPage");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getJumlahdomisiliyayasan($id_kelurahan){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_domisili_yayasan where id_kelurahan=$id_kelurahan");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getPencarianDomisiliYayasan($id_kelurahan,$pencarian,$id_pencarian){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 	
				
				if(!$pencarian){
					$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_domisili_yayasan a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
					}else{
					if($id_pencarian==1){
						$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_domisili_yayasan a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
						}else if($id_pencarian==2){
						$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_domisili_yayasan a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
					}
				}
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getsimpanprosesdomisiliyayasan(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_kelurahan" =>  	$data['id_kelurahan'],
									"nik" => $data['nik'],
									"id_pejabat" => $data['id_pejabat'],
									"id_jenis_surat" => $data['id_jenis_surat'],
									"id_surat" => $data['id_surat'],
									"no_surat" => $data['no_surat'],
									"tanggal_surat" => $data['tanggal_surat'],
									"no_surat_pengantar" => $data['no_surat_pengantar'],
									"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
									"keperluan" => $data['keperluan'],
									"masa_berlaku" => $data['masa_berlaku'],
									"nama_yayasan" => $data['nama_yayasan'],
									"bergerak_bidang" => $data['bergerak_bidang'],
									"jumlah_anggota" => $data['jumlah_anggota'],
									"jam_kerja" => $data['jam_kerja'],
									"alamat_usaha" => $data['alamat_usaha'],
									"status" => $data['status'],
									"waktu_proses" => $data['waktu_proses'],
									"proses_oleh" => $data['proses_oleh'],
				"ket" => $data['ket']);
				
				$where[] = " id_permintaan_domisili_yayasan = '".$data['id_permintaan_domisili_yayasan']."'";
				
				$db->update('permintaan_domisili_yayasan',$paramInput, $where);
				$db->commit();	
				return 'sukses';
			} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		public function gethapusdomisiliyayasan($id_permintaan_domisili_yayasan) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			
			try {
				$db->beginTransaction();
				$where[] = " id_permintaan_domisili_yayasan = '".$id_permintaan_domisili_yayasan."'";
				
				$db->delete('permintaan_domisili_yayasan', $where);
				$db->commit();
				
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		public function getdomisiliyayasan($id_permintaan_domisili_yayasan){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* 
												FROM permintaan_domisili_yayasan a, data_penduduk b, pejabat_kelurahan c 
												WHERE  a.nik = b.nik 
												AND a.id_permintaan_domisili_yayasan = $id_permintaan_domisili_yayasan");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getsimpanprosesdomisiliyayasanedit(array $data) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_kelurahan" =>  	$data['id_kelurahan'],
									"id_permintaan_domisili_yayasan" => $data['id_permintaan_domisili_yayasan'],
									"nik" => $data['nik'],
									"no_surat" => $data['no_surat'],
									"tanggal_surat" => $data['tanggal_surat'],
									"no_surat_pengantar" => $data['no_surat_pengantar'],
									"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
									"nama_yayasan" => $data['nama_yayasan'],
									"keperluan" => $data['keperluan'],
									"masa_berlaku" => $data['masa_berlaku'],
									"bergerak_bidang" => $data['bergerak_bidang'],
									"jumlah_anggota" => $data['jumlah_anggota'],
									"jam_kerja" => $data['jam_kerja'],
									"alamat_usaha" => $data['alamat_usaha']);
				
				$where[] = " id_permintaan_domisili_yayasan = '".$data['id_permintaan_domisili_yayasan']."'";
				
				$db->update('permintaan_domisili_yayasan',$paramInput, $where);
				$db->commit();			
				return 'sukses';
			} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		
		public function getJumlahStatusDomisiliyayasan1(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_domisili_yayasan where status='1'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getJumlahStatusDomisiliyayasan2(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_domisili_yayasan where status='2'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		//simpan selesai
		public function getSelesaiDomisiliyayasan($data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("status" =>  $data['status'],
				"waktu_selesai" => $data['waktu_selesai'],
				"waktu_total" => $data['waktu_total']
				);
				
				$where[] = " id_permintaan_domisili_yayasan = '".$data['id_permintaan_domisili_yayasan']."'";
				
				$db->update('permintaan_domisili_yayasan',$paramInput, $where);
				$db->commit();			
				return 'sukses';
			} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		//////////////////////DOMISILI PARPOL
		
		//cetak surat domisili parpol
		public function getdomisiliparpolcetak($id_permintaan_domisili_parpol){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* 
											FROM permintaan_domisili_parpol a, data_penduduk b, pejabat_kelurahan c 
											WHERE  a.nik = b.nik 
											AND a.id_permintaan_domisili_parpol = $id_permintaan_domisili_parpol");
				
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		//proses simpan antrian -> status menjadi 1
		public function getsimpandomisiliparpolantrian(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_pengguna" =>  	$data['id_pengguna'],
									"id_kelurahan" => $data['id_kelurahan'],
									"no_registrasi" => $data['no_registrasi'],
									"nik" => $data['nik'],
									"waktu_antrian" => $data['waktu_antrian'],
									"antrian_oleh" => $data['antrian_oleh'],
									"jam_masuk" => $data['jam_masuk'],
									"status" => $data['status'],
				"no_telp" => $data['no_telp']
									);
				
				$db->insert('permintaan_domisili_parpol',$paramInput);
				$db->commit();
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		public function getProsesdomisiliparpol($id_kelurahan,$offset , $dataPerPage){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("SELECT a.*, b.* 
											FROM permintaan_domisili_parpol a, data_penduduk b 
											WHERE a.id_kelurahan = $id_kelurahan 
											AND a.nik = b.nik 
											ORDER BY   a.no_registrasi DESC  LIMIT $offset , $dataPerPage");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getJumlahdomisiliparpol($id_kelurahan){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_domisili_parpol where id_kelurahan=$id_kelurahan");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getPencarianDomisiliParpol($id_kelurahan,$pencarian,$id_pencarian){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 	
				
				if(!$pencarian){
					$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_domisili_parpol a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
					}else{
					if($id_pencarian==1){
						$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_domisili_parpol a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
						}else if($id_pencarian==2){
						$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_domisili_parpol a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
					}
				}
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getsimpanprosesdomisiliparpol(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_kelurahan" =>  	$data['id_kelurahan'],
									"nik" => $data['nik'],
									"id_pejabat" => $data['id_pejabat'],
									"id_jenis_surat" => $data['id_jenis_surat'],
									"id_surat" => $data['id_surat'],
									"no_surat" => $data['no_surat'],
									"tanggal_surat" => $data['tanggal_surat'],
									"no_surat_pengantar" => $data['no_surat_pengantar'],
									"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
									"nama_parpol" => $data['nama_parpol'],
									"keperluan" => $data['keperluan'],
									"masa_berlaku" => $data['masa_berlaku'],
									"bergerak_bidang" => $data['bergerak_bidang'],
									"jumlah_anggota" => $data['jumlah_anggota'],
									"jam_kerja" => $data['jam_kerja'],
									"alamat_parpol" => $data['alamat_parpol'],
									"status" => $data['status'],
									"waktu_proses" => $data['waktu_proses'],
									"proses_oleh" => $data['proses_oleh'],
				"ket" => $data['ket']);
				
				
				$where[] = " id_permintaan_domisili_parpol = '".$data['id_permintaan_domisili_parpol']."'";
				
				$db->update('permintaan_domisili_parpol',$paramInput, $where);
				$db->commit();		
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		public function gethapusdomisiliparpol($id_permintaan_domisili_parpol) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$where[] = " id_permintaan_domisili_parpol = '".$id_permintaan_domisili_parpol."'";
				
				$db->delete('permintaan_domisili_parpol', $where);
				$db->commit();
				
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		public function getdomisiliparpol($id_permintaan_domisili_parpol){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* 
									FROM permintaan_domisili_parpol a, data_penduduk b, pejabat_kelurahan c 
									WHERE  a.nik = b.nik 
									AND a.id_permintaan_domisili_parpol = $id_permintaan_domisili_parpol");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getsimpanprosesdomisiliparpoledit(array $data) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_kelurahan" =>  	$data['id_kelurahan'],
								"id_permintaan_domisili_parpol" => $data['id_permintaan_domisili_parpol'],
								"nik" => $data['nik'],
								"no_surat" => $data['no_surat'],
								"tanggal_surat" => $data['tanggal_surat'],
								"no_surat_pengantar" => $data['no_surat_pengantar'],
								"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
								"nama_parpol" => $data['nama_parpol'],
								"keperluan" => $data['keperluan'],
								"masa_berlaku" => $data['masa_berlaku'],
								"bergerak_bidang" => $data['bergerak_bidang'],
								"jumlah_anggota" => $data['jumlah_anggota'],
								"jam_kerja" => $data['jam_kerja'],
								"alamat_parpol" => $data['alamat_parpol']);
				
				$where[] = " id_permintaan_domisili_parpol = '".$data['id_permintaan_domisili_parpol']."'";
				
				$db->update('permintaan_domisili_parpol',$paramInput, $where);
				$db->commit();			
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		
		public function getJumlahStatusDomisiliparpol1(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_domisili_parpol where status='1'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getJumlahStatusDomisiliparpol2(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_domisili_parpol where status='2'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		//simpan selesai
		public function getSelesaiDomisiliparpol($data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("status" =>  $data['status'],
						"waktu_selesai" => $data['waktu_selesai'],
						"waktu_total" => $data['waktu_total']
				);
				
				$where[] = " id_permintaan_domisili_parpol = '".$data['id_permintaan_domisili_parpol']."'";
				
				$db->update('permintaan_domisili_parpol',$paramInput, $where);
				$db->commit();			
				return 'sukses';
			} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		//////////////////////DOMISILI PERUSAHAAN
		//cetak surat domisili perusahaan
		public function getdomisiliperusahaancetak($id_permintaan_domisili_perusahaan){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*, k.alamat as alamat_kelurahan, b.alamat as alamat_warga
										FROM permintaan_domisili_perusahaan a, data_penduduk b, pejabat_kelurahan c, kelurahan k
										WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
										AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_domisili_perusahaan = $id_permintaan_domisili_perusahaan");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		//proses simpan antrian -> status menjadi 1
		public function getsimpandomisiliperusahaanantrian(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_pengguna" =>  	$data['id_pengguna'],
				"id_kelurahan" => $data['id_kelurahan'],
				"no_registrasi" => $data['no_registrasi'],
				"nik" => $data['nik'],
				"waktu_antrian" => $data['waktu_antrian'],
				"antrian_oleh" => $data['antrian_oleh'],
				"jam_masuk" => $data['jam_masuk'],
				"status" => $data['status'],
				"no_telp" => $data['no_telp']
				);
				
				$db->insert('permintaan_domisili_perusahaan',$paramInput);
				$db->commit();
				
				return 'sukses';
			} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		
		public function getProsesdomisiliperusahaan($id_kelurahan,$offset , $dataPerPage){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_domisili_perusahaan a, data_penduduk b 
											WHERE a.id_kelurahan = $id_kelurahan 
											AND a.nik = b.nik 
											order by  a.no_registrasi desc, a.tanggal_surat desc LIMIT $offset , $dataPerPage");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getJumlahdomisiliperusahaan($id_kelurahan){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_domisili_perusahaan where id_kelurahan=$id_kelurahan");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getPencarianDomisiliPerusahaan($id_kelurahan,$pencarian,$id_pencarian){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 	
				
				if(!$pencarian){
					$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_domisili_perusahaan a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
					}else{
					if($id_pencarian==1){
						$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_domisili_perusahaan a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
						}else if($id_pencarian==2){
						$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_domisili_perusahaan a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
					}
				}
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getsimpanprosesdomisiliperusahaan(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_kelurahan" =>  	$data['id_kelurahan'],
				"nik" => $data['nik'],
				"id_pejabat" => $data['id_pejabat'],
				"no_surat" => $data['no_surat'],
				"id_jenis_surat" => $data['id_jenis_surat'],
				"id_surat" => $data['id_surat'],
				"tanggal_surat" => $data['tanggal_surat'],
				"no_surat_pengantar" => $data['no_surat_pengantar'],
				"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
				
				"nama_perusahaan" => $data['nama_perusahaan'],
				"akta_pendirian_perusahaan" => $data['akta_pendirian_perusahaan'],
				"bergerak_bidang" => $data['bergerak_bidang'],
				"jumlah_pegawai" => $data['jumlah_pegawai'],
				"jam_kerja" => $data['jam_kerja'],
				"masa_berlaku" => $data['masa_berlaku'],
				"alamat_usaha" => $data['alamat_usaha'],
				
				"status" => $data['status'],
				"waktu_proses" => $data['waktu_proses'],
				"proses_oleh" => $data['proses_oleh'],
				"keperluan" => $data['keperluan'],
				"ket" => $data['ket']);
				
				$where[] = " id_permintaan_domisili_perusahaan = '".$data['id_permintaan_domisili_perusahaan']."'";
				
				$db->update('permintaan_domisili_perusahaan',$paramInput, $where);
				$db->commit();
				
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		public function gethapusdomisiliperusahaan($id_permintaan_domisili_perusahaan) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$where[] = " id_permintaan_domisili_perusahaan = '".$id_permintaan_domisili_perusahaan."'";
				
				$db->delete('permintaan_domisili_perusahaan', $where);
				$db->commit();
				
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		public function getdomisiliperusahaan($id_permintaan_domisili_perusahaan){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* 
									FROM permintaan_domisili_perusahaan a, data_penduduk b, pejabat_kelurahan c 
									WHERE  a.nik = b.nik  
									AND a.id_permintaan_domisili_perusahaan = $id_permintaan_domisili_perusahaan");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getsimpanprosesdomisiliperusahaanedit(array $data) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_kelurahan" =>  	$data['id_kelurahan'],
									"id_permintaan_domisili_perusahaan" => $data['id_permintaan_domisili_perusahaan'],
									"nik" => $data['nik'],
									"no_surat" => $data['no_surat'],
									"jenis_perusahaan" => $data['jenis_perusahaan'],
									"jumlah_pegawai" => $data['jumlah_pegawai'],
									"tanggal_surat" => $data['tanggal_surat'],
									"no_surat_pengantar" => $data['no_surat_pengantar'],
									"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
									"keperluan" => $data['keperluan'],
									"nama_perusahaan" => $data['nama_perusahaan'],
									"akta_pendirian_perusahaan" => $data['akta_pendirian_perusahaan'],
									"bergerak_bidang" => $data['bergerak_bidang'],
									"jumlah_pegawai" => $data['jumlah_pegawai'],
									"jam_kerja" => $data['jam_kerja'],
									"masa_berlaku" => $data['masa_berlaku'],
									"alamat_usaha" => $data['alamat_usaha']
									);
				
				$where[] = " id_permintaan_domisili_perusahaan = '".$data['id_permintaan_domisili_perusahaan']."'";
				
				$db->update('permintaan_domisili_perusahaan',$paramInput, $where);
				$db->commit();			
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		
		public function getJumlahStatusDomisiliperusahaan1(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_domisili_perusahaan where status='1'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getJumlahStatusDomisiliperusahaan2(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_domisili_perusahaan where status='2'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		//simpan selesai
		public function getSelesaiDomisiliperusahaan($data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("status" =>  $data['status'],
				"waktu_selesai" => $data['waktu_selesai'],
				"waktu_total" => $data['waktu_total']
				);
				
				$where[] = " id_permintaan_domisili_perusahaan = '".$data['id_permintaan_domisili_perusahaan']."'";
				
				$db->update('permintaan_domisili_perusahaan',$paramInput, $where);
				$db->commit();			
				return 'sukses';
			} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		
		
		//////////////////////KETERANGAN TEMPAT USAHA
		//cetak surat domisili perusahaan
		public function getketerangantempatusahacetak($id_permintaan_keterangan_tempat_usaha){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*, k.alamat as alamat_kelurahan, b.alamat as alamat_warga
										FROM permintaan_keterangan_tempat_usaha a, data_penduduk b, pejabat_kelurahan c, kelurahan k
										WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
										AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_keterangan_tempat_usaha = $id_permintaan_keterangan_tempat_usaha");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		//proses simpan antrian -> status menjadi 1
		public function getsimpanketerangantempatusahaantrian(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_pengguna" =>  	$data['id_pengguna'],
						"id_kelurahan" => $data['id_kelurahan'],
						"no_registrasi" => $data['no_registrasi'],
						"nik" => $data['nik'],
						"waktu_antrian" => $data['waktu_antrian'],
						"antrian_oleh" => $data['antrian_oleh'],
						"jam_masuk" => $data['jam_masuk'],
						"status" => $data['status'],
						"no_telp" => $data['no_telp']
				);
				
				$db->insert('permintaan_keterangan_tempat_usaha',$paramInput);
				$db->commit();
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		
		
		public function getProsesketerangantempatusaha($id_kelurahan,$offset , $dataPerPage){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_keterangan_tempat_usaha a, data_penduduk b 
											WHERE a.id_kelurahan = $id_kelurahan 
											AND a.nik = b.nik 
											order by  a.no_registrasi desc, a.tanggal_surat desc LIMIT $offset , $dataPerPage");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getJumlahketerangantempatusaha($id_kelurahan){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_keterangan_tempat_usaha where id_kelurahan=$id_kelurahan");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		
		
		public function getPencarianKeteranganTempatUsaha($id_kelurahan,$pencarian,$id_pencarian){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 	
				
				if(!$pencarian){
					$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_keterangan_tempat_usaha a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
					}else{
					if($id_pencarian==1){
						$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_keterangan_tempat_usaha a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
						}else if($id_pencarian==2){
						$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_keterangan_tempat_usaha a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
					}
				}
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getsimpanprosesketerangantempatusaha(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_kelurahan" =>  	$data['id_kelurahan'],
				"nik" => $data['nik'],
				"id_pejabat" => $data['id_pejabat'],
				"no_surat" => $data['no_surat'],
				"id_jenis_surat" => $data['id_jenis_surat'],
				"id_surat" => $data['id_surat'],
				"tanggal_surat" => $data['tanggal_surat'],
				"no_surat_pengantar" => $data['no_surat_pengantar'],
				"bidang_usaha" => $data['bidang_usaha'],
				"alamat_usaha" => $data['alamat_usaha'],						
				"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
				"masa_berlaku" => $data['masa_berlaku'],
				"status" => $data['status'],
				"waktu_proses" => $data['waktu_proses'],
				"proses_oleh" => $data['proses_oleh'],
				"ket" => $data['ket']);
				
				$where[] = " id_permintaan_keterangan_tempat_usaha = '".$data['id_permintaan_keterangan_tempat_usaha']."'";
				
				$db->update('permintaan_keterangan_tempat_usaha',$paramInput, $where);
				$db->commit();	
				return 'sukses';
			} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		public function gethapusketerangantempatusaha($id_permintaan_keterangan_tempat_usaha) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$where[] = " id_permintaan_keterangan_tempat_usaha = '".$id_permintaan_keterangan_tempat_usaha."'";
				
				$db->delete('permintaan_keterangan_tempat_usaha', $where);
				$db->commit();
				
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		public function getketerangantempatusaha($id_permintaan_keterangan_tempat_usaha){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* 
				FROM permintaan_keterangan_tempat_usaha a, data_penduduk b, pejabat_kelurahan c 
				WHERE  a.nik = b.nik AND a.id_permintaan_keterangan_tempat_usaha = $id_permintaan_keterangan_tempat_usaha");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getsimpanprosesketerangantempatusahaedit(array $data) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_kelurahan" =>  	$data['id_kelurahan'],
								"id_permintaan_keterangan_tempat_usaha" => $data['id_permintaan_keterangan_tempat_usaha'],
								"nik" => $data['nik'],
								"no_surat" => $data['no_surat'],
								"tanggal_surat" => $data['tanggal_surat'],
								"no_surat_pengantar" => $data['no_surat_pengantar'],
								"bidang_usaha" => $data['bidang_usaha'],
								"alamat_usaha" => $data['alamat_usaha'],						
								"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
								"masa_berlaku" => $data['masa_berlaku']);	
				
				$where[] = " id_permintaan_keterangan_tempat_usaha = '".$data['id_permintaan_keterangan_tempat_usaha']."'";
				
				$db->update('permintaan_keterangan_tempat_usaha',$paramInput, $where);
				$db->commit();			
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		
		public function getJumlahStatusKeterangantempatusaha1(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_keterangan_tempat_usaha where status='1'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getJumlahStatusKeterangantempatusaha2(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_keterangan_tempat_usaha where status='2'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		//simpan selesai
		public function getSelesaiKeterangantempatusaha($data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("status" =>  $data['status'],
				"waktu_selesai" => $data['waktu_selesai'],
				"waktu_total" => $data['waktu_total']
				);
				
				$where[] = " id_permintaan_keterangan_tempat_usaha = '".$data['id_permintaan_keterangan_tempat_usaha']."'";
				
				$db->update('permintaan_keterangan_tempat_usaha',$paramInput, $where);
				$db->commit();			
				return 'sukses';
			} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		
		////////////////////////////////////lahir lama
		//cetak surat keterangan kelahiran lama
		public function getlahircetak($id_permintaan_lahir){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*, k.alamat as alamat_kelurahan, b.alamat as alamat_warga
										FROM permintaan_lahir a, data_penduduk b, pejabat_kelurahan c, kelurahan k
										WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
										AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_lahir = $id_permintaan_lahir");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		//proses simpan antrian -> status menjadi 1
		public function getsimpanlahirantrian(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_pengguna" =>  	$data['id_pengguna'],
				"id_kelurahan" => $data['id_kelurahan'],
				"no_registrasi" => $data['no_registrasi'],
				"nik" => $data['nik'],
				"waktu_antrian" => $data['waktu_antrian'],
				"antrian_oleh" => $data['antrian_oleh'],
				"jam_masuk" => $data['jam_masuk'],
				"status" => $data['status'],
				"no_telp" => $data['no_telp']
				);
				
				$db->insert('permintaan_lahir',$paramInput);
				$db->commit();
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		public function getProseslahir($id_kelurahan,$offset , $dataPerPage){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("SELECT a.*, b.* 
				FROM permintaan_lahir a, data_penduduk b 
				WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  
				order by  a.no_registrasi desc, a.tanggal_surat desc 
				LIMIT $offset , $dataPerPage");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getJumlahlahir($id_kelurahan){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_lahir where id_kelurahan=$id_kelurahan");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getPencarianlahir($id_kelurahan,$pencarian,$id_pencarian){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 	
				
				if(!$pencarian){
					$result = $db->fetchAll("SELECT  id_permintaan_lahir, no_surat, tanggal_surat, nik, rt, status FROM permintaan_lahir WHERE id_kelurahan = $id_kelurahan  LIMIT 0 , 30");
					}else{
					if($id_pencarian==1){
						$result = $db->fetchAll("SELECT  id_permintaan_lahir, no_surat, tanggal_surat, nik, rt, status FROM permintaan_lahir WHERE id_kelurahan = $id_kelurahan && no_surat = '$pencarian'  LIMIT 0 , 30");
						}else if($id_pencarian==2){
						$result = $db->fetchAll("SELECT  id_permintaan_lahir, no_surat, tanggal_surat, nik, rt, status 
						FROM permintaan_lahir WHERE id_kelurahan = $id_kelurahan && nik = '$pencarian'  LIMIT 0 , 30");
					}
				}
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getsimpanproseslahir(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_kelurahan" =>  	$data['id_kelurahan'],
				"nik" => $data['nik'],
				"id_pejabat" => $data['id_pejabat'],
				"id_jenis_surat" => $data['id_jenis_surat'],
				"id_surat" => $data['id_surat'],
				"tanggal_surat" => $data['tanggal_surat'],
				"no_surat_pengantar" => $data['no_surat_pengantar'],
				"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
				"nama_anak" => $data['nama_anak'],
				"jenis_kelamin_anak" => $data['jenis_kelamin_anak'],
				"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
				"tempat_lahir_anak" => $data['tempat_lahir_anak'],
				"tgl_lahir_anak" => $data['tgl_lahir_anak'],
				"anak_ke" => $data['anak_ke'],
				"jam_lahir" => $data['jam_lahir'],
				"status" => $data['status'],
				"waktu_proses" => $data['waktu_proses'],
				"proses_oleh" => $data['proses_oleh'],
				"ket" => $data['ket']);
				
				$where[] = " id_permintaan_lahir = '".$data['id_permintaan_lahir']."'";
				
				$db->update('permintaan_lahir',$paramInput, $where);
				$db->commit();
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		public function gethapuslahir($id_permintaan_lahir) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			
			try {
				$db->beginTransaction();
				$where[] = " id_permintaan_lahir = '".$id_permintaan_lahir."'";
				
				$db->delete('permintaan_lahir', $where);
				$db->commit();
				
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		
		public function getlahir($id_permintaan_lahir){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*,pk.* 
				FROM permintaan_lahir a, data_penduduk b, pejabat_kelurahan pk 
				WHERE a.nik = b.nik 
				and a.id_permintaan_lahir = $id_permintaan_lahir");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getsimpanlahiredit(array $data) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_kelurahan" =>  	$data['id_kelurahan'],
				"id_permintaan_lahir" => $data['id_permintaan_lahir'],
				"nik" => $data['nik'],
				"no_surat" => $data['no_surat'],
				"tanggal_surat" => $data['tanggal_surat'],
				"no_surat_pengantar" => $data['no_surat_pengantar'],
				"rt" => $data['rt'],
				"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
				"nama_anak" => $data['nama_anak'],
				"jenis_kelamin_anak" => $data['jenis_kelamin_anak'],
				"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
				"tempat_lahir_anak" => $data['tempat_lahir_anak'],
				"tgl_lahir_anak" => $data['tgl_lahir_anak'],
				"anak_ke" => $data['anak_ke'],
				"jam_lahir" => $data['jam_lahir']
				);
				
				$where[] = " id_permintaan_lahir = '".$data['id_permintaan_lahir']."'";
				
				$db->update('permintaan_lahir',$paramInput, $where);
				$db->commit();			
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		
		public function getJumlahStatusLahir1(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_lahir where status='1'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getJumlahStatusLahir2(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_lahir where status='2'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		//simpan selesai
		public function getSelesaiLahir($data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("status" =>  $data['status'],
				"waktu_selesai" => $data['waktu_selesai'],
				"waktu_total" => $data['waktu_total']
				);
				
				$where[] = " id_permintaan_lahir = '".$data['id_permintaan_lahir']."'";
				
				$db->update('permintaan_lahir',$paramInput, $where);
				$db->commit();			
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		////////////////////////////////////mati lama
		//cetak surat keterangan kematian lama
		public function getmaticetak($id_permintaan_mati){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*, k.alamat as alamat_kelurahan, b.alamat as alamat_warga
										FROM permintaan_mati a, data_penduduk b, pejabat_kelurahan c, kelurahan k
										WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
										AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_mati = $id_permintaan_mati");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getProsesmati($id_kelurahan,$offset,$dataPerPage){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("SELECT a.*, b.* 
				FROM permintaan_mati a, data_penduduk b 
				WHERE a.id_kelurahan = $id_kelurahan 
				AND a.nik = b.nik  
				ORDER BY   a.no_registrasi DESC 
				LIMIT $offset , $dataPerPage");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getJumlahmati($id_kelurahan){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_mati where id_kelurahan=$id_kelurahan");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getPencarianmati($id_kelurahan,$pencarian,$id_pencarian){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 	
				
				if(!$pencarian){
					$result = $db->fetchAll("SELECT  id_permintaan_mati, no_surat, tanggal_surat, nik, rt, status FROM permintaan_mati WHERE id_kelurahan = $id_kelurahan  LIMIT 0 , 30");
					}else{
					if($id_pencarian==1){
						$result = $db->fetchAll("SELECT  id_permintaan_mati, no_surat, tanggal_surat, nik, rt, status FROM permintaan_mati WHERE id_kelurahan = $id_kelurahan && no_surat = '$pencarian'  LIMIT 0 , 30");
						}else if($id_pencarian==2){
						$result = $db->fetchAll("SELECT  id_permintaan_mati, no_surat, tanggal_surat, nik, rt, status 
						FROM permintaan_mati WHERE id_kelurahan = $id_kelurahan && nik = '$pencarian'  LIMIT 0 , 30");
					}
				}
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		//proses simpan antrian -> status menjadi 1
		public function getsimpanmatiantrian(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_pengguna" =>  	$data['id_pengguna'],
				"id_kelurahan" => $data['id_kelurahan'],
				"no_registrasi" => $data['no_registrasi'],
				"nik" => $data['nik'],
				"waktu_antrian" => $data['waktu_antrian'],
				"antrian_oleh" => $data['antrian_oleh'],
				"jam_masuk" => $data['jam_masuk'],
				"status" => $data['status'],
				"no_telp" => $data['no_telp']
				);
				
				$db->insert('permintaan_mati',$paramInput);
				$db->commit();
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		public function getsimpanprosesmati(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_kelurahan" =>  	$data['id_kelurahan'],
				"nik" => $data['nik'],
				"id_pejabat" => $data['id_pejabat'],
				"no_surat" => $data['no_surat'],
				"id_jenis_surat" => $data['id_jenis_surat'],
				"id_surat" => $data['id_surat'],
				"tanggal_surat" => $data['tanggal_surat'],
				"no_surat_pengantar" => $data['no_surat_pengantar'],
				"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
				"status" => $data['status'],								
				"tanggal_meninggal" =>  $data['tanggal_meninggal'],
				"jam_meninggal" =>  $data['jam_meninggal'],
				"lokasi_meninggal" => $data['lokasi_meninggal'],
				"penyebab_meninggal" =>  $data['penyebab_meninggal'],
				"usia_meninggal" =>  $data['usia_meninggal'],
				"keperluan" =>  $data['keperluan'],
				"waktu_proses" => $data['waktu_proses'],
				"proses_oleh" => $data['proses_oleh'],
				"ket" => $data['ket']
				);
				
				$where[] = " id_permintaan_mati = '".$data['id_permintaan_mati']."'";
				
				$db->update('permintaan_mati',$paramInput, $where);
				$db->commit();	
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		public function gethapusmati($id_permintaan_mati) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			
			try {
				$db->beginTransaction();
				$where[] = " id_permintaan_mati = '".$id_permintaan_mati."'";
				
				$db->delete('permintaan_mati', $where);
				$db->commit();
				
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		public function getmati($id_permintaan_mati){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.* ,pk.*
				FROM permintaan_mati a, data_penduduk b, pejabat_kelurahan pk 
				WHERE a.nik = b.nik  AND id_permintaan_mati = $id_permintaan_mati");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getsimpanmatiedit(array $data) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_kelurahan" =>  	$data['id_kelurahan'],
				"id_permintaan_mati" => $data['id_permintaan_mati'],
				"nik" => $data['nik'],
				"no_surat" => $data['no_surat'],
				"tanggal_surat" => $data['tanggal_surat'],
				"no_surat_pengantar" => $data['no_surat_pengantar'],
				"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
				"tanggal_meninggal" =>  $data['tanggal_meninggal'],
				"jam_meninggal" =>  $data['jam_meninggal'],
				"lokasi_meninggal" => $data['lokasi_meninggal'],
				"penyebab_meninggal" =>  $data['penyebab_meninggal'],
				"usia_meninggal" =>  $data['usia_meninggal'],
				"keperluan" =>  $data['keperluan']
				);
				
				$where[] = " id_permintaan_mati = '".$data['id_permintaan_mati']."'";
				
				$db->update('permintaan_mati',$paramInput, $where);
				$db->commit();			
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		
		public function getJumlahStatusMati1(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_mati where status='1'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getJumlahStatusMati2(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_mati where status='2'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		//simpan selesai
		public function getSelesaiMati($data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("status" =>  $data['status'],
				"waktu_selesai" => $data['waktu_selesai'],
				"waktu_total" => $data['waktu_total']
				);
				
				$where[] = " id_permintaan_mati = '".$data['id_permintaan_mati']."'";
				
				$db->update('permintaan_mati',$paramInput, $where);
				$db->commit();			
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		////////////////////////////////////waris
		//cetak surat WARIS	
		public function getahliwariscetak($id_permintaan_waris){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*, k.alamat as alamat_kelurahan, b.alamat as alamat_warga
										FROM permintaan_waris a, data_penduduk b, pejabat_kelurahan c, kelurahan k
										WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
										AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_waris = $id_permintaan_waris");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		//proses menampilkan untuk memproses antrian 
		public function getProsesahliwaris($id_kelurahan,$offset,$dataPerPage){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_waris a, data_penduduk b 
				WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik 
				ORDER BY  a.no_registrasi DESC 
				LIMIT $offset , $dataPerPage");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getJumlahahliwaris($id_kelurahan){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_waris where id_kelurahan=$id_kelurahan");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getJumlahStatusahliwaris1(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_waris where status='1'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getJumlahStatusahliwaris2(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_waris where status='2'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getPencarianahliwaris($id_kelurahan,$pencarian,$id_pencarian){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 	
				
				if(!$pencarian){
					$result = $db->fetchAll("SELECT  id_permintaan_waris, no_surat, tanggal_surat, nik, rt, status FROM permintaan_waris WHERE id_kelurahan = $id_kelurahan  LIMIT 0 , 30");
					}else{
					if($id_pencarian==1){
						$result = $db->fetchAll("SELECT  id_permintaan_waris, no_surat, tanggal_surat, nik, rt, status FROM permintaan_waris WHERE id_kelurahan = $id_kelurahan && no_surat = '$pencarian'  LIMIT 0 , 30");
						}else if($id_pencarian==2){
						$result = $db->fetchAll("SELECT  id_permintaan_waris, no_surat, tanggal_surat, nik, rt, status 
						FROM permintaan_waris WHERE id_kelurahan = $id_kelurahan && nik = '$pencarian'  LIMIT 0 , 30");
					}
				}
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		//proses simpan antrian -> status menjadi 1
		public function getsimpanahliwarisantrian(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_pengguna" =>  	$data['id_pengguna'],
				"id_kelurahan" => $data['id_kelurahan'],
				"no_registrasi" => $data['no_registrasi'],
				"nik" => $data['nik'],
				"waktu_antrian" => $data['waktu_antrian'],
				"antrian_oleh" => $data['antrian_oleh'],
				"jam_masuk" => $data['jam_masuk'],
				"status" => $data['status'],
				"no_telp" => $data['no_telp']
				);
				
				$db->insert('permintaan_waris',$paramInput);
				$db->commit();
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		public function getsimpanprosesahliwaris(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_kelurahan" =>  	$data['id_kelurahan'],
				"nik" => $data['nik'],
				"id_pejabat" => $data['id_pejabat'],
				"no_surat" => $data['no_surat'],
				"id_jenis_surat" => $data['id_jenis_surat'],
				"id_surat" => $data['id_surat'],
				"tanggal_surat" => $data['tanggal_surat'],
				"no_surat_pengantar" => $data['no_surat_pengantar'],
				"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
				"status" => $data['status'],								
				"berdasarkan" => $data['berdasarkan'],	
				"hari_meninggal" =>  $data['hari_meninggal'],
				"tanggal_meninggal" =>  $data['tanggal_meninggal'],
				"tempat_meninggal" =>  $data['tempat_meninggal'],
				"sebab_meninggal" => $data['sebab_meninggal'],
				"keperluan" =>  $data['keperluan'],
				"waktu_proses" => $data['waktu_proses'],
				"proses_oleh" => $data['proses_oleh'],
				"ket" => $data['ket']
				);
				
				$where[] = " id_permintaan_waris = '".$data['id_permintaan_waris']."'";
				
				$db->update('permintaan_waris',$paramInput, $where);
				$db->commit();	
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		public function gethapusahliwaris($id_permintaan_waris) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			
			try {
				$db->beginTransaction();
				$where[] = " id_permintaan_waris = '".$id_permintaan_waris."'";
				
				$db->delete('permintaan_waris', $where);
				$db->commit();
				
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		public function getahliwaris($id_permintaan_waris){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT  * FROM permintaan_waris WHERE id_permintaan_waris = $id_permintaan_waris");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getsimpanahliwarisedit(array $data) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_kelurahan" =>  	$data['id_kelurahan'],
				"id_permintaan_waris" => $data['id_permintaan_waris'],
				"nik" => $data['nik'],
				"no_surat" => $data['no_surat'],
				"tanggal_surat" => $data['tanggal_surat'],
				"no_surat_pengantar" => $data['no_surat_pengantar'],
				"rt" => $data['rt'],
				"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar']);
				
				$where[] = " id_permintaan_waris = '".$data['id_permintaan_waris']."'";
				
				$db->update('permintaan_waris',$paramInput, $where);
				$db->commit();			
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		
		
		//simpan selesai
		public function getSelesaiahliwaris($data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("status" =>  $data['status'],
				"waktu_selesai" => $data['waktu_selesai'],
				"waktu_total" => $data['waktu_total']
				);
				
				$where[] = " id_permintaan_waris = '".$data['id_permintaan_waris']."'";
				
				$db->update('permintaan_waris',$paramInput, $where);
				$db->commit();			
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		
		////////////////////////////////////Lain-lain
		//proses simpan antrian -> status menjadi 1
		public function getsimpanserbagunaantrian(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_pengguna" =>  	$data['id_pengguna'],
									"id_kelurahan" => $data['id_kelurahan'],
									"no_registrasi" => $data['no_registrasi'],
									"nik" => $data['nik'],
									"waktu_antrian" => $data['waktu_antrian'],
									"antrian_oleh" => $data['antrian_oleh'],
									"jam_masuk" => $data['jam_masuk'],
									"status" => $data['status'],
				"no_telp" => $data['no_telp']
				);
				
				$db->insert('permintaan_serbaguna',$paramInput);
				$db->commit();
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		public function getProsesserbaguna($id_kelurahan,$offset,$dataPerPage){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_serbaguna a, data_penduduk b 
											WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik 
											ORDER BY  a.no_registrasi DESC 
											LIMIT $offset , $dataPerPage");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getJumlahserbaguna($id_kelurahan){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_serbaguna where id_kelurahan=$id_kelurahan");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getPencarianserbaguna($id_kelurahan,$pencarian,$id_pencarian){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 	
				
				if(!$pencarian){
					$result = $db->fetchAll("SELECT  id_permintaan_serbaguna, no_surat, tanggal_surat, nik, rt, status FROM permintaan_serbaguna WHERE id_kelurahan = $id_kelurahan  LIMIT 0 , 30");
					}else{
					if($id_pencarian==1){
						$result = $db->fetchAll("SELECT  id_permintaan_serbaguna, no_surat, tanggal_surat, nik, rt, status FROM permintaan_serbaguna WHERE id_kelurahan = $id_kelurahan && no_surat = '$pencarian'  LIMIT 0 , 30");
						}else if($id_pencarian==2){
						$result = $db->fetchAll("SELECT  id_permintaan_serbaguna, no_surat, tanggal_surat, nik, rt, status 
						FROM permintaan_serbaguna WHERE id_kelurahan = $id_kelurahan && nik = '$pencarian'  LIMIT 0 , 30");
					}
				}
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getsimpanprosesserbaguna(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_kelurahan" =>  	$data['id_kelurahan'],									
									"keperluan" => $data['keperluan'],
									"nik" => $data['nik'],
									"id_pejabat" => $data['id_pejabat'],
									"id_jenis_surat" => $data['id_jenis_surat'],
									"id_surat" => $data['id_surat'],
									"no_surat" => $data['no_surat'],
									"tanggal_surat" => $data['tanggal_surat'],
									"no_surat_pengantar" => $data['no_surat_pengantar'],
									"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],									
									"status" => $data['status'],
									"waktu_proses" => $data['waktu_proses'],
									"proses_oleh" => $data['proses_oleh'],
				"ket" => $data['ket']);
				
				$where[] = " id_permintaan_serbaguna = '".$data['id_permintaan_serbaguna']."'";
				
				$db->update('permintaan_serbaguna',$paramInput, $where);
				$db->commit();	
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		public function gethapusserbaguna($id_permintaan_serbaguna) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			
			try {
				$db->beginTransaction();
				$where[] = " id_permintaan_serbaguna = '".$id_permintaan_serbaguna."'";
				
				$db->delete('permintaan_serbaguna', $where);
				$db->commit();
				
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		public function getserbaguna($id_permintaan_serbaguna){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* 
											FROM permintaan_serbaguna a, data_penduduk b, pejabat_kelurahan c 
											WHERE  a.nik = b.nik  
											AND a.id_permintaan_serbaguna = $id_permintaan_serbaguna");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getsimpanserbagunaedit(array $data) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_kelurahan" =>  	$data['id_kelurahan'],
									"id_permintaan_serbaguna" => $data['id_permintaan_serbaguna'],
									"keperluan" => $data['keperluan'],
									"nik" => $data['nik'],
									"no_surat" => $data['no_surat'],
									"tanggal_surat" => $data['tanggal_surat'],
									"no_surat_pengantar" => $data['no_surat_pengantar'],
									"rt" => $data['rt'],
									"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar']);
				
				$where[] = " id_permintaan_serbaguna = '".$data['id_permintaan_serbaguna']."'";
				
				$db->update('permintaan_serbaguna',$paramInput, $where);
				$db->commit();			
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		
		//simpan selesai
		public function getSelesaiSerbaguna($data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("status" =>  $data['status'],
				"waktu_selesai" => $data['waktu_selesai'],
				"waktu_total" => $data['waktu_total']
				);
				
				$where[] = " id_permintaan_serbaguna = '".$data['id_permintaan_serbaguna']."'";
				
				$db->update('permintaan_serbaguna',$paramInput, $where);
				$db->commit();			
				return 'sukses';
			} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		public function getJumlahStatusSerbaguna1(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_serbaguna where status='1'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getJumlahStatusSerbaguna2(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_serbaguna where status='2'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		//////////////////////DOMISILI YAYASAN PANITIA PEMBANGUNAN
		//cetak surat domisilipanitiapemb
		public function getdomisilipanitiapembcetak($id_permintaan_domisili_panitia_pembangunan){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*
										FROM permintaan_domisili_panitia_pembangunan a, data_penduduk b, pejabat_kelurahan c, kelurahan k
										WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
										AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_domisili_panitia_pembangunan = $id_permintaan_domisili_panitia_pembangunan");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		
		//proses simpan antrian -> status menjadi 1
		public function getsimpandomisilipanitiapembantrian(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_pengguna" =>  	$data['id_pengguna'],
				"id_kelurahan" => $data['id_kelurahan'],
				"no_registrasi" => $data['no_registrasi'],
				"nik" => $data['nik'],
				"waktu_antrian" => $data['waktu_antrian'],
				"antrian_oleh" => $data['antrian_oleh'],
				"jam_masuk" => $data['jam_masuk'],
				"status" => $data['status'],
				"no_telp" => $data['no_telp']
				);
				
				$db->insert('permintaan_domisili_panitia_pembangunan',$paramInput);
				$db->commit();
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		//proses menampilkan untuk memproses antrian 
		public function getProsesdomisilipanitiapemb($id_kelurahan,$offset,$dataPerPage){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_domisili_panitia_pembangunan a, data_penduduk b 
				WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik 
				ORDER BY  a.no_registrasi DESC 
				LIMIT $offset , $dataPerPage");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getJumlahdomisilipanitiapemb($id_kelurahan){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_domisili_panitia_pembangunan where id_kelurahan=$id_kelurahan");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getPencariandomisilipanitiapemb($id_kelurahan,$pencarian,$id_pencarian){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 	
				
				if(!$pencarian){
					$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_domisili_panitia_pembangunan a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
					}else{
					if($id_pencarian==1){
						$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_domisili_panitia_pembangunan a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
						}else if($id_pencarian==2){
						$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_domisili_panitia_pembangunan a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
					}
				}
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getsimpanprosesdomisilipanitiapemb(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
			$paramInput = array("id_kelurahan" =>  	$data['id_kelurahan'],
									"nik" => $data['nik'],
									"id_pejabat" => $data['id_pejabat'],
									"id_jenis_surat" => $data['id_jenis_surat'],
									"id_surat" => $data['id_surat'],
									"no_surat" => $data['no_surat'],
									"tanggal_surat" => $data['tanggal_surat'],
									"no_surat_pengantar" => $data['no_surat_pengantar'],
									"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
									"keperluan" => $data['keperluan'],
									"masa_berlaku" => $data['masa_berlaku'],
									"status" => $data['status'],
									"waktu_proses" => $data['waktu_proses'],
									"proses_oleh" => $data['proses_oleh'],
									"ket" => $data['ket']);
				
				$where[] = " id_permintaan_domisili_panitia_pembangunan = '".$data['id_permintaan_domisili_panitia_pembangunan']."'";
				
				$db->update('permintaan_domisili_panitia_pembangunan',$paramInput, $where);
				$db->commit();			
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		
		public function gethapusdomisilipanitiapemb($id_permintaan_domisili_panitia_pembangunan) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$where[] = " id_permintaan_domisili_panitia_pembangunan = '".$id_permintaan_domisili_panitia_pembangunan."'";
				
				$db->delete('permintaan_domisili_panitia_pembangunan', $where);
				$db->commit();
				
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		public function getdomisilipanitiapemb($id_permintaan_domisili_panitia_pembangunan){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* 
											FROM permintaan_domisili_panitia_pembangunan a, data_penduduk b, pejabat_kelurahan c 
											WHERE  a.nik = b.nik  
											AND a.id_permintaan_domisili_panitia_pembangunan = $id_permintaan_domisili_panitia_pembangunan");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getsimpanprosesdomisilipanitiapembedit(array $data) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
			$paramInput = array(
									"keperluan" => $data['keperluan'],
									"masa_berlaku" => $data['masa_berlaku'],
									"ket" => $data['ket']);
				
				$where[] = " id_permintaan_domisili_panitia_pembangunan = '".$data['id_permintaan_domisili_panitia_pembangunan']."'";
				
				$db->update('permintaan_domisili_panitia_pembangunan',$paramInput, $where);
				$db->commit();			
				return 'sukses';
			} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		
		//simpan selesai
		public function getSelesaidomisilipanitiapemb($data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("status" =>  $data['status'],
				"waktu_selesai" => $data['waktu_selesai'],
				"waktu_total" => $data['waktu_total']
				);
				
				$where[] = " id_permintaan_domisili_panitia_pembangunan = '".$data['id_permintaan_domisili_panitia_pembangunan']."'";
				
				$db->update('permintaan_domisili_panitia_pembangunan',$paramInput, $where);
				$db->commit();			
				return 'sukses';
			} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		public function getJumlahStatusdomisilipanitiapemb1(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_domisili_panitia_pembangunan where status='1'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		
		public function getJumlahStatusdomisilipanitiapemb2(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_domisili_panitia_pembangunan where status='2'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		//////////////////////BELUM PUNYA PEKERJAAN
		//cetak surat ket belum punya pekerjaan
		public function getbelumbekerjacetak($id_permintaan_belum_bekerja){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*, k.alamat as alamat_kelurahan, b.alamat as alamat_warga
										FROM permintaan_belum_bekerja a, data_penduduk b, pejabat_kelurahan c, kelurahan k
										WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
										AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_belum_bekerja = $id_permintaan_belum_bekerja");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		//////////////////////11. DOMISILI PENDUDUK
		//cetak surat ket domisili penduduk
		public function getdomisilipendudukcetak($id_permintaan_domisili_penduduk){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*, k.alamat as alamat_kelurahan, b.alamat as alamat_warga
										FROM permintaan_domisili_penduduk a, data_penduduk b, pejabat_kelurahan c, kelurahan k
										WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
										AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_domisili_penduduk = $id_permintaan_domisili_penduduk");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		
		//proses simpan antrian -> status menjadi 1
		public function getsimpandomisilipendudukantrian(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_pengguna" =>  	$data['id_pengguna'],
				"id_kelurahan" => $data['id_kelurahan'],
				"no_registrasi" => $data['no_registrasi'],
				"nik" => $data['nik'],
				"waktu_antrian" => $data['waktu_antrian'],
				"antrian_oleh" => $data['antrian_oleh'],
				"jam_masuk" => $data['jam_masuk'],
				"status" => $data['status'],
				"no_telp" => $data['no_telp']
				);
				
				$db->insert('permintaan_domisili_penduduk',$paramInput);
				$db->commit();
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		//proses menampilkan untuk memproses antrian 
		public function getProsesdomisilipenduduk($id_kelurahan,$offset,$dataPerPage){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_domisili_penduduk a, data_penduduk b 
				WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik 
				ORDER BY  a.no_registrasi DESC 
				LIMIT $offset , $dataPerPage");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getJumlahdomisilipenduduk($id_kelurahan){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_domisili_penduduk where id_kelurahan=$id_kelurahan");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getPencariandomisilipenduduk($id_kelurahan,$pencarian,$id_pencarian){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 	
				
				if(!$pencarian){
					$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_domisili_penduduk a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
					}else{
					if($id_pencarian==1){
						$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_domisili_penduduk a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
						}else if($id_pencarian==2){
						$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_domisili_penduduk a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
					}
				}
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getsimpanprosesdomisilipenduduk(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
			$paramInput = array("id_kelurahan" =>  	$data['id_kelurahan'],
									"nik" => $data['nik'],
									"id_pejabat" => $data['id_pejabat'],
									"id_jenis_surat" => $data['id_jenis_surat'],
									"id_surat" => $data['id_surat'],
									"no_surat" => $data['no_surat'],
									"tanggal_surat" => $data['tanggal_surat'],
									"no_surat_pengantar" => $data['no_surat_pengantar'],
									"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
									"keperluan" => $data['keperluan'],
									"masa_berlaku" => $data['masa_berlaku'],
									"status" => $data['status'],
									"waktu_proses" => $data['waktu_proses'],
									"proses_oleh" => $data['proses_oleh'],
									"ket" => $data['ket']);
				
				$where[] = " id_permintaan_domisili_penduduk = '".$data['id_permintaan_domisili_penduduk']."'";
				
				$db->update('permintaan_domisili_penduduk',$paramInput, $where);
				$db->commit();			
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		
		public function gethapusdomisilipenduduk($id_permintaan_domisili_penduduk) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$where[] = " id_permintaan_domisili_penduduk = '".$id_permintaan_domisili_penduduk."'";
				
				$db->delete('permintaan_domisili_penduduk', $where);
				$db->commit();
				
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		public function getdomisilipenduduk($id_permintaan_domisili_penduduk){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* 
											FROM permintaan_domisili_penduduk a, data_penduduk b, pejabat_kelurahan c 
											WHERE  a.nik = b.nik  
											AND a.id_permintaan_domisili_penduduk = $id_permintaan_domisili_penduduk");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getsimpanprosesdomisilipendudukedit(array $data) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
			$paramInput = array(
									"keperluan" => $data['keperluan'],
									"masa_berlaku" => $data['masa_berlaku'],
									"ket" => $data['ket']);
				
				$where[] = " id_permintaan_domisili_penduduk = '".$data['id_permintaan_domisili_penduduk']."'";
				
				$db->update('permintaan_domisili_penduduk',$paramInput, $where);
				$db->commit();			
				return 'sukses';
			} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		
		//simpan selesai
		public function getSelesaidomisilipenduduk($data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("status" =>  $data['status'],
				"waktu_selesai" => $data['waktu_selesai'],
				"waktu_total" => $data['waktu_total']
				);
				
				$where[] = " id_permintaan_domisili_penduduk = '".$data['id_permintaan_domisili_penduduk']."'";
				
				$db->update('permintaan_domisili_penduduk',$paramInput, $where);
				$db->commit();			
				return 'sukses';
			} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		public function getJumlahStatusdomisilipenduduk1(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_domisili_penduduk where status='1'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getJumlahStatusdomisilipenduduk2(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_domisili_penduduk where status='2'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		//////////////////////ORANG YANG SAMA
		//cetak surat ket domisili penduduk
		public function getorangyangsamacetak($id_permintaan_orang_yang_sama){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*, k.alamat as alamat_kelurahan, b.alamat as alamat_warga
										FROM permintaan_orang_yang_sama a, data_penduduk b, pejabat_kelurahan c, kelurahan k
										WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
										AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_orang_yang_sama = $id_permintaan_orang_yang_sama");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		////////////////////////////////////Ket. Tanah dan Bangunan AJB
	    //cetak ket ajb
		public function getktbajbcetak($id_permintaan_ajb){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*, k.alamat as alamat_kelurahan, b.alamat as alamat_warga
										FROM permintaan_ajb a, data_penduduk b, pejabat_kelurahan c, kelurahan k
										WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
										AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_ajb = $id_permintaan_ajb");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}

		//proses simpan antrian -> status menjadi 1
		public function getsimpanktbajbantrian(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_pengguna" =>  	$data['id_pengguna'],
				"id_kelurahan" => $data['id_kelurahan'],
				"no_registrasi" => $data['no_registrasi'],
				"nik" => $data['nik'],
				"waktu_antrian" => $data['waktu_antrian'],
				"antrian_oleh" => $data['antrian_oleh'],
				"jam_masuk" => $data['jam_masuk'],
				"status" => $data['status'],
				"no_telp" => $data['no_telp']
				);
				
				$db->insert('permintaan_ajb',$paramInput);
				$db->commit();
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		//proses menampilkan untuk memproses antrian  ktbajb
		public function getProsesktbajb($id_kelurahan,$offset,$dataPerPage){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_ajb a, data_penduduk b 
				WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik 
				ORDER BY  a.no_registrasi DESC 
				LIMIT $offset , $dataPerPage");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getJumlahktbajb($id_kelurahan){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_ajb where id_kelurahan=$id_kelurahan");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getPencarianktbajb($id_kelurahan,$pencarian,$id_pencarian){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 	
				
				if(!$pencarian){
					$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_ajb a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
					}else{
					if($id_pencarian==1){
						$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_ajb a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
						}else if($id_pencarian==2){
						$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_ajb a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
					}
				}
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getsimpanprosesktbajb(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
			$paramInput = array("id_kelurahan" =>  	$data['id_kelurahan'],
									"nik" => $data['nik'],
									"id_pejabat" => $data['id_pejabat'],
									"id_jenis_surat" => $data['id_jenis_surat'],
									"id_surat" => $data['id_surat'],
									"no_surat" => $data['no_surat'],
									"tanggal_surat" => $data['tanggal_surat'],
									"no_surat_pengantar" => $data['no_surat_pengantar'],
									"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
									"keperluan" => $data['keperluan'],
									"masa_berlaku" => $data['masa_berlaku'],
									"status" => $data['status'],
									"waktu_proses" => $data['waktu_proses'],
									"proses_oleh" => $data['proses_oleh'],
									"ket" => $data['ket']);
				
				$where[] = " id_permintaan_ajb = '".$data['id_permintaan_ajb']."'";
				
				$db->update('permintaan_ajb',$paramInput, $where);
				$db->commit();			
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		
		public function gethapusktbajb($id_permintaan_ajb) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$where[] = " id_permintaan_ajb = '".$id_permintaan_ajb."'";
				
				$db->delete('permintaan_ajb', $where);
				$db->commit();
				
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		public function getktbajb($id_permintaan_ajb){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* 
											FROM permintaan_ajb a, data_penduduk b, pejabat_kelurahan c 
											WHERE  a.nik = b.nik  
											AND a.id_permintaan_ajb = $id_permintaan_ajb");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getsimpanprosesktbajbedit(array $data) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
			$paramInput = array(
									"keperluan" => $data['keperluan'],
									"masa_berlaku" => $data['masa_berlaku'],
									"ket" => $data['ket']);
				
				$where[] = " id_permintaan_ajb = '".$data['id_permintaan_ajb']."'";
				
				$db->update('permintaan_ajb',$paramInput, $where);
				$db->commit();			
				return 'sukses';
			} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		
		//simpan selesai
		public function getSelesaiktbajb($data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("status" =>  $data['status'],
				"waktu_selesai" => $data['waktu_selesai'],
				"waktu_total" => $data['waktu_total']
				);
				
				$where[] = " id_permintaan_ajb = '".$data['id_permintaan_ajb']."'";
				
				$db->update('permintaan_ajb',$paramInput, $where);
				$db->commit();			
				return 'sukses';
			} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		public function getJumlahStatusktbajb1(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_ajb where status='1'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getJumlahStatusktbajb2(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_ajb where status='2'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		////////////////////////////////////Ket. Tanah dan Bangunan Sertifikat
	    //cetak ket sertifikat
		public function getktbsertifikatcetak($id_permintaan_sertifikat){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*, k.alamat as alamat_kelurahan, b.alamat as alamat_warga
										FROM permintaan_sertifikat a, data_penduduk b, pejabat_kelurahan c, kelurahan k
										WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
										AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_sertifikat = $id_permintaan_sertifikat");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		////////////////////////////////////Mutasi Balik Nama PBB
	    //cetak mutasi balik nama PBB
		public function getmutasipbbcetak($id_permintaan_mutasi_pbb){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*, k.alamat as alamat_kelurahan, b.alamat as alamat_warga
										FROM permintaan_mutasi_pbb a, data_penduduk b, pejabat_kelurahan c, kelurahan k
										WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
										AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_mutasi_pbb = $id_permintaan_mutasi_pbb");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}

			//proses simpan antrian -> status menjadi 1
		public function getsimpanmutasipbbantrian(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_pengguna" =>  	$data['id_pengguna'],
				"id_kelurahan" => $data['id_kelurahan'],
				"no_registrasi" => $data['no_registrasi'],
				"nik" => $data['nik'],
				"waktu_antrian" => $data['waktu_antrian'],
				"antrian_oleh" => $data['antrian_oleh'],
				"jam_masuk" => $data['jam_masuk'],
				"status" => $data['status'],
				"no_telp" => $data['no_telp']
				);
				
				$db->insert('permintaan_mutasi_pbb',$paramInput);
				$db->commit();
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		//proses menampilkan untuk memproses antrian  mutasipbb
		public function getProsesmutasipbb($id_kelurahan,$offset,$dataPerPage){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_mutasi_pbb a, data_penduduk b 
				WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik 
				ORDER BY  a.no_registrasi DESC 
				LIMIT $offset , $dataPerPage");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getJumlahmutasipbb($id_kelurahan){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_mutasi_pbb where id_kelurahan=$id_kelurahan");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getPencarianmutasipbb($id_kelurahan,$pencarian,$id_pencarian){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 	
				
				if(!$pencarian){
					$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_mutasi_pbb a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
					}else{
					if($id_pencarian==1){
						$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_mutasi_pbb a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
						}else if($id_pencarian==2){
						$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_mutasi_pbb a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
					}
				}
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getsimpanprosesmutasipbb(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
			$paramInput = array("id_kelurahan" =>  	$data['id_kelurahan'],
									"nik" => $data['nik'],
									"id_pejabat" => $data['id_pejabat'],
									"id_jenis_surat" => $data['id_jenis_surat'],
									"id_surat" => $data['id_surat'],
									"no_surat" => $data['no_surat'],
									"tanggal_surat" => $data['tanggal_surat'],
									"no_surat_pengantar" => $data['no_surat_pengantar'],
									"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
									"keperluan" => $data['keperluan'],
									"masa_berlaku" => $data['masa_berlaku'],
									"status" => $data['status'],
									"waktu_proses" => $data['waktu_proses'],
									"proses_oleh" => $data['proses_oleh'],
									"ket" => $data['ket']);
				
				$where[] = " id_permintaan_mutasi_pbb = '".$data['id_permintaan_mutasi_pbb']."'";
				
				$db->update('permintaan_mutasi_pbb',$paramInput, $where);
				$db->commit();			
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		
		public function gethapusmutasipbb($id_permintaan_mutasi_pbb) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$where[] = " id_permintaan_mutasi_pbb = '".$id_permintaan_mutasi_pbb."'";
				
				$db->delete('permintaan_mutasi_pbb', $where);
				$db->commit();
				
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		public function getmutasipbb($id_permintaan_mutasi_pbb){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* 
											FROM permintaan_mutasi_pbb a, data_penduduk b, pejabat_kelurahan c 
											WHERE  a.nik = b.nik  
											AND a.id_permintaan_mutasi_pbb = $id_permintaan_mutasi_pbb");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getsimpanprosesmutasipbbedit(array $data) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
			$paramInput = array(
									"keperluan" => $data['keperluan'],
									"masa_berlaku" => $data['masa_berlaku'],
									"ket" => $data['ket']);
				
				$where[] = " id_permintaan_mutasi_pbb = '".$data['id_permintaan_mutasi_pbb']."'";
				
				$db->update('permintaan_mutasi_pbb',$paramInput, $where);
				$db->commit();			
				return 'sukses';
			} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		
		//simpan selesai
		public function getSelesaimutasipbb($data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("status" =>  $data['status'],
				"waktu_selesai" => $data['waktu_selesai'],
				"waktu_total" => $data['waktu_total']
				);
				
				$where[] = " id_permintaan_mutasi_pbb = '".$data['id_permintaan_mutasi_pbb']."'";
				
				$db->update('permintaan_mutasi_pbb',$paramInput, $where);
				$db->commit();			
				return 'sukses';
			} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		public function getJumlahStatusmutasipbb1(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_mutasi_pbb where status='1'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getJumlahStatusmutasipbb2(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_mutasi_pbb where status='2'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		///////////////////////////////////Penerbitan PBB
	    //cetak penerbitan PBB
		public function getpenerbitanpbbcetak($id_permintaan_penerbitan_pbb){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*, k.alamat as alamat_kelurahan, b.alamat as alamat_warga
										FROM permintaan_penerbitan_pbb a, data_penduduk b, pejabat_kelurahan c, kelurahan k
										WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
										AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_penerbitan_pbb = $id_permintaan_penerbitan_pbb");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}

			//proses simpan antrian -> status menjadi 1
		public function getsimpanpenerbitanpbbantrian(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("id_pengguna" =>  	$data['id_pengguna'],
				"id_kelurahan" => $data['id_kelurahan'],
				"no_registrasi" => $data['no_registrasi'],
				"nik" => $data['nik'],
				"waktu_antrian" => $data['waktu_antrian'],
				"antrian_oleh" => $data['antrian_oleh'],
				"jam_masuk" => $data['jam_masuk'],
				"status" => $data['status'],
				"no_telp" => $data['no_telp']
				);
				
				$db->insert('permintaan_penerbitan_pbb',$paramInput);
				$db->commit();
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		//proses menampilkan untuk memproses antrian  penerbitanpbb
		public function getProsespenerbitanpbb($id_kelurahan,$offset,$dataPerPage){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_penerbitan_pbb a, data_penduduk b 
				WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik 
				ORDER BY  a.no_registrasi DESC 
				LIMIT $offset , $dataPerPage");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getJumlahpenerbitanpbb($id_kelurahan){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_penerbitan_pbb where id_kelurahan=$id_kelurahan");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getPencarianpenerbitanpbb($id_kelurahan,$pencarian,$id_pencarian){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 	
				
				if(!$pencarian){
					$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_penerbitan_pbb a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
					}else{
					if($id_pencarian==1){
						$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_penerbitan_pbb a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
						}else if($id_pencarian==2){
						$result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_penerbitan_pbb a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
					}
				}
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getsimpanprosespenerbitanpbb(Array $data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
			$paramInput = array("id_kelurahan" =>  	$data['id_kelurahan'],
									"nik" => $data['nik'],
									"id_pejabat" => $data['id_pejabat'],
									"id_jenis_surat" => $data['id_jenis_surat'],
									"id_surat" => $data['id_surat'],
									"no_surat" => $data['no_surat'],
									"tanggal_surat" => $data['tanggal_surat'],
									"no_surat_pengantar" => $data['no_surat_pengantar'],
									"tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
									"keperluan" => $data['keperluan'],
									"masa_berlaku" => $data['masa_berlaku'],
									"status" => $data['status'],
									"waktu_proses" => $data['waktu_proses'],
									"proses_oleh" => $data['proses_oleh'],
									"ket" => $data['ket']);
				
				$where[] = " id_permintaan_penerbitan_pbb = '".$data['id_permintaan_penerbitan_pbb']."'";
				
				$db->update('permintaan_penerbitan_pbb',$paramInput, $where);
				$db->commit();			
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		
		public function gethapuspenerbitanpbb($id_permintaan_penerbitan_pbb) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$where[] = " id_permintaan_penerbitan_pbb = '".$id_permintaan_penerbitan_pbb."'";
				
				$db->delete('permintaan_penerbitan_pbb', $where);
				$db->commit();
				
				return 'sukses';
				} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		public function getpenerbitanpbb($id_permintaan_penerbitan_pbb){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.* 
											FROM permintaan_penerbitan_pbb a, data_penduduk b, pejabat_kelurahan c 
											WHERE  a.nik = b.nik  
											AND a.id_permintaan_penerbitan_pbb = $id_permintaan_penerbitan_pbb");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		public function getsimpanprosespenerbitanpbbedit(array $data) {
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
			$paramInput = array(
									"keperluan" => $data['keperluan'],
									"masa_berlaku" => $data['masa_berlaku'],
									"ket" => $data['ket']);
				
				$where[] = " id_permintaan_penerbitan_pbb = '".$data['id_permintaan_penerbitan_pbb']."'";
				
				$db->update('permintaan_penerbitan_pbb',$paramInput, $where);
				$db->commit();			
				return 'sukses';
			} catch (Exception $e) {
				$db->rollBack();
				$errmsgArr = explode(":",$e->getMessage());
				
				$errMsg = $errmsgArr[0];
				
				if($errMsg == "SQLSTATE[23000]")
				{
					return "gagal.Data Sudah Ada.";
				}
				else
				{
					return "sukses";
				}
			}
		}
		
		//simpan selesai
		public function getSelesaipenerbitanpbb($data){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->beginTransaction();
				$paramInput = array("status" =>  $data['status'],
				"waktu_selesai" => $data['waktu_selesai'],
				"waktu_total" => $data['waktu_total']
				);
				
				$where[] = " id_permintaan_penerbitan_pbb = '".$data['id_permintaan_penerbitan_pbb']."'";
				
				$db->update('permintaan_penerbitan_pbb',$paramInput, $where);
				$db->commit();			
				return 'sukses';
			} catch (Exception $e) {
				$db->rollBack();
				echo $e->getMessage().'<br>';
				return 'gagal';
			}
		}
		
		public function getJumlahStatuspenerbitanpbb1(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_penerbitan_pbb where status='1'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		public function getJumlahStatuspenerbitanpbb2(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_penerbitan_pbb where status='2'");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
		
		
}
?>
