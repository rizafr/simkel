<?php
	require_once 'Zend/Controller/Action.php';
	require_once 'Zend/Session.php';
	require_once "service/pengguna/Pengguna_Service.php";
	require_once "service/pengguna/Surat_Service.php";
	require_once 'Zend/Session/Namespace.php';
	
	class Surat_IndexController extends Zend_Controller_Action {
		public function init() {
			// Local to this controller only; affects all actions, as loaded in init:
			//UNTUK SETTING GLOBAL BASE PATH
			$registry = Zend_Registry::getInstance();
			$this->auth = Zend_Auth::getInstance();	   
			$this->view->baseData = $registry->get('baseData');
			$this->view->basePath = $registry->get('basepath');
			$this->view->procPath = $registry->get('procpath');	 
			
			$this->pengguna = Pengguna_Service::getInstance();
			$this->kelurahan_serv = Pengguna_Service::getInstance();
			$this->data_serv = Pengguna_Service::getInstance();
			$this->surat_serv = Surat_Service::getInstance();
			
			$user = new Zend_Session_Namespace('user');
			$this->id_kelurahan = $user->id_kelurahan;
			$this->id_jenis_pengguna = $user->id_jenis_pengguna;
			$this->id_pengguna = $user->id_pengguna;
			$this->nama_pengguna = $user->nama_pengguna;
			
			$this->view->pemberdayaan = $this->data_serv->getPemberdayaan();
			$this->view->tantrib = $this->data_serv->getTantrib();
			$this->view->ekonomipembangunan = $this->data_serv->getEkonomiPembangunan();
			$this->view->pemerintahan = $this->data_serv->getPemerintahan();
			
			date_default_timezone_set("Asia/Jakarta"); 
		}
		public function indexAction() {
			
		}
		public function homeAction(){
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
		}
		
		//rumahsakit
		//cetak surat rumahsakit
		public function rumahsakitcetakAction(){
			$id_permintaan_rumahsakit = $this->_getParam("id_permintaan_rumahsakit");
			$this->view->hasil = $this->surat_serv->getrumahsakitcetak($id_permintaan_rumahsakit);
		}
		
		public function rumahsakitAction(){
			$this->view;
			$this->view->kelurahan = $this->id_kelurahan;
			
			$dataPerPage = 10;
			// apabila $_GET['page'] sudah didefinisikan, gunakan nomor halaman tersebut,
			// sedangkan apabila belum, nomor halamannya 1.
			$noPage = $this->_getParam("page");
			if(isset($noPage))
			{
				$noPage = $this->_getParam("page");
			}
			else{ 
				$noPage = 1;
			}
			
			$offset = ($noPage - 1) * $dataPerPage;
			$this->view->jumData = $this->surat_serv->getJumlahRumahSakit($this->id_kelurahan);
			$this->view->dataPerPage = $dataPerPage;
			$this->view->noPage = $noPage;
			$this->view->offset=$offset;
			
			$id_surat = $this->_getParam("id_surat");
			$this->view->surat = "Surat Keterangan Tidak Mampu untuk Rumah Sakit";
			$this->view->permintaan = $this->surat_serv->getProsesRumahSakit($this->id_kelurahan, $offset, $dataPerPage);
			
		}
		public function pencarianrsAction(){
			$this->view;
			$this->id_kelurahan;
			$this->view->kelurahan = $this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			$id_pencarian = $_POST['id_pencarian'];
			$pencarian = $_POST['pencarian'];
			if(!$pencarian){
				$this->rumahsakitAction();
				$this->render('rumahsakit');
				}else{
				$this->view->surat = "Surat Keterangan Tidak Mampu untuk Rumah Sakit";
				$this->view->cari = $pencarian;
				$this->view->permintaan = $this->surat_serv->getPencarianRumahSakit($this->id_kelurahan,$pencarian,$id_pencarian);
			}
			
		}
		
		//pencarian rumahsakit berdasarkan nik
		public function caripendudukrumahsakitAction() {
			$this->view;
			$this->view->surat = "Silakan cari data penduduk berdasarkan NIK";
			$this->view->judul = "Masukan NIK";
		}
		
		//antrian rumah sakit --> proses memasukan ke antrian rumahsakit, status = 1
		public function rumahsakitantrianAction(){
			$nik = $_POST['nik'];
			$this->view->surat = "Form Antrian Keterangan rumah sakit";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			
			//mengambil noregistrasi secara automatis
			$no_registrasi = $this->surat_serv->getNoRegistrasi(4,KRS); //4 adalah panjangnya, AN adalah kode huruf
			$this->view->no_registrasi=$no_registrasi;
			
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('rumahsakitantrian');
			
		}
		
		//menyimpan antrian rumahsakit
		public function simpanrumahsakitantrianAction(){
			if(isset($_POST['name'])){ 
				$id_kelurahan = $this->id_kelurahan;			
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->nama_pengguna;		
				
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$waktu_antrian = date('H:i:s');
				$antrian_oleh = $nama_pengguna;
				$jam_masuk = date('H:i:s');
				$status = 1;
				
				//simpan data ke tabel rumah sakit
				$data = array("id_pengguna" =>  	$id_pengguna,
				"id_kelurahan" => $id_kelurahan,
				"no_registrasi" => $no_registrasi,
				"nik" => $nik,
				"waktu_antrian" => $waktu_antrian,
				"antrian_oleh" => $antrian_oleh,
				"jam_masuk" => $jam_masuk,							
				"status" => $status
				);										 
				$hasil = $this->surat_serv->getsimpanrumahsakitantrian($data);
				//var_dump($data);
				//simpan data ke tabel no_registrasi
				$registrasi = array("no_registrasi" =>  	$no_registrasi,
				"nik" => $nik							
				);										 
				$hasil = $this->surat_serv->getSimpanNoRegistrasi($registrasi);
				
				
				//jika gagal
				if($hasil=="gagal"){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan</div>";
					$this->rumahsakitAction();
					$this->render('rumahsakit');					
				}
				//jika sukses
				if($hasil=="sukses"){
					$this->view->peringatan ="<div class='sukses'> Sukses, data berhasil ditambahkan ke antrian </div>";		
					$this->rumahsakitAction();
					$this->render('rumahsakit');
				}
				}else{
				$this->rumahsakitAction();
				$this->render('rumahsakit');
			}
			
		}
		public function rumahsakitprosesAction(){
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_rumahsakit= $this->_getParam("id_permintaan_rumahsakit");
			$no_registrasi= $this->_getParam(no_registrasi);
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;		
			
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->view->surat = "Form Isian Surat Keterangan Rumah Sakit";
			$this->render('rumahsakitproses');
		}
		
		public function simpanprosesrsAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->nama_pengguna;
				
				$waktu_proses = date("H:i:s");
				$proses_oleh= $nama_pengguna;
				
				$id_permintaan_rumahsakit = $_POST['id_permintaan_rumahsakit'];
				$id_jenis_surat = $_POST['id_jenis_surat'];
				$id_surat = $_POST['id_surat'];
				$id_pejabat = $_POST['id_pejabat'];		
				$id_kelurahan = $this->id_kelurahan;
				
				$nik = $_POST['nik'];
				$no_kip = $_POST['no_kip'];
				$no_jamkesmas = $_POST['no_jamkesmas'];
				$peruntukan = $_POST['peruntukan'];
				$no_surat = $_POST['no_surat'];
				$tanggal_surat = $_POST['tanggal_surat'];
				$no_surat_pengantar = $_POST['no_surat_pengantar'];
				$rt = $_POST['rt'];
				$rw = $_POST['rw'];
				$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
				$masa_berlaku = $_POST['masa_berlaku'];
				$nama_rumahsakit = $_POST['nama_rumahsakit'];
				$status = 2;
				
				$data = array("id_pengguna" =>  	$id_pengguna,
				"id_permintaan_rumahsakit" => $id_permintaan_rumahsakit,
				"id_kelurahan" =>  	$id_kelurahan,
				"id_jenis_surat" =>  	$id_jenis_surat,						
				"id_surat" =>  	$id_surat,						
				"id_pejabat" =>  	$id_pejabat,						
				"nik" => $nik,
				"no_kip" => $no_kip,
				"no_jamkesmas" => $no_jamkesmas,
				"peruntukan" => $peruntukan,
				"no_surat" => $no_surat,
				"tanggal_surat" => $tanggal_surat,
				"no_surat_pengantar" => $no_surat_pengantar,
				"rt" => $rt,
				"rw" => $rw,
				"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
				"masa_berlaku" => $masa_berlaku,
				"nama_rumahsakit" => $nama_rumahsakit,
				"status" => $status,
				"waktu_proses" => $waktu_proses,
				"proses_oleh" => $proses_oleh
				);
				
				$hasil = $this->surat_serv->getsimpanprosesrs($data);
				//var_dump($data);
				//var_dump($hasil);
				
				//jika gagal
				if($hasil=='gagal'){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
					$this->rumahsakitAction();
					$this->render('rumahsakit');			
				}
				//jika sukses
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diproses </div>";		
				$this->rumahsakitAction();
				$this->render('rumahsakit');
			}else{
				$this->rumahsakitAction();
				$this->render('rumahsakit');		
			}				
		}
		
		
		public function rumahsakithapusAction(){
			$id_permintaan_rumahsakit= $this->_getParam("id_permintaan_rumahsakit");
			$hasil = $this->surat_serv->gethapusrumahsakit($id_permintaan_rumahsakit);
			
			//jika gagal
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->rumahsakitAction();
				$this->render('rumahsakit');			
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
			$this->rumahsakitAction();
			$this->render('rumahsakit');	
			
		}
		public function rumahsakiteditAction(){
			$id_permintaan_rumahsakit = $this->_getParam("id_permintaan_rumahsakit");
			$this->view->surat = "Ubah Permintaan Surat Keterangan Tidak Mampu untuk Rumah Sakit";
			$this->view->hasil = $this->surat_serv->getrumahsakit($id_permintaan_rumahsakit);
		}
		public function simpanprosesrseditAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_kelurahan = $this->id_kelurahan;
				$id_permintaan_rumahsakit = $this->_getParam('id_permintaan_rumahsakit');
				$nik = $_POST['nik'];
				$no_kip = $_POST['no_kip'];
				$no_jamkesmas = $_POST['no_jamkesmas'];
				$peruntukan = $_POST['peruntukan'];
				$no_surat = $_POST['no_surat'];
				$tanggal_surat = $_POST['tanggal_surat'];
				$no_surat_pengantar = $_POST['no_surat_pengantar'];
				$rt = $_POST['rt'];
				$rw = $_POST['rw'];
				$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
				$masa_berlaku = $_POST['masa_berlaku'];
				$nama_rumahsakit = $_POST['nama_rumahsakit'];
				
				
				$data = array("id_kelurahan" =>  	$id_kelurahan,
				"id_permintaan_rumahsakit" => $id_permintaan_rumahsakit,
				"nik" => $nik,
				"no_kip" => $no_kip,
				"no_jamkesmas" => $no_jamkesmas,
				"peruntukan" => $peruntukan,
				"no_surat" => $no_surat,
				"tanggal_surat" => $tanggal_surat,
				"no_surat_pengantar" => $no_surat_pengantar,
				"rt" => $rt,
				"rw" => $rw,
				"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
				"masa_berlaku" => $masa_berlaku,
				"nama_rumahsakit" => $nama_rumahsakit
				);
				
				$hasil = $this->surat_serv->getsimpanprosesrsedit($data);
				//jika gagal
				if(!hasil){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
					$this->rumahsakitAction();
					$this->render('rumahsakit');			
				}
				//jika sukses
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
				$this->rumahsakitAction();
				$this->render('rumahsakit');
				}else{
				$this->rumahsakitAction();
				$this->render('rumahsakit');
			}
		}
		
		
		
		public function prosesrsAction(){
			$nik = $_POST['nik'];
			$this->view->surat = "Form Isian Surat Keterangan Tidak Mampu untuk Rumah Sakit";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
		}
		public function simpanpendudukAction(){
			//echo $id_kelurahan = $this->id_kelurahan;
			
			$no_kk = $_POST['no_kk'];
			$nama_kep = $_POST['nama_kep'];
			$alamat = $_POST['alamat'];
			$rt = $_POST['rt'];
			$rw = $_POST['rw'];
			$dusun = $_POST['dusun'];
			$kode_pos = $_POST['kode_pos'];
			$nik = $_POST['nik'];
			$nama = $_POST['nama_lengkap'];
			$jenis_kelamin = $_POST['jk'];
			$tempat_lahir = $_POST['tempat_lahir'];
			$tanggal_lahir = $_POST['tanggal_lahir'];
			$no_akta = $_POST['no_akta'];
			$gol_darah = $_POST['gol_darah'];
			$agama = $_POST['agama'];
			$pekerjaan = $_POST['pekerjaan'];
			$nama_ibu = $_POST['nama_ibu'];
			$nama_ayah = $_POST['nama_ayah'];
			$status_perkawinan = $_POST['status'];
			$id_kelurahan = $_POST['id_kelurahan'];
			
			
			$data = array("no_kk" =>  	$no_kk,
			"nama_kep" =>  	$nama_kep,
			"alamat" =>  	$alamat,
			"rt" =>  	$rt,
			"rw" =>  	$rw,
			"dusun" =>  	$dusun,
			"kode_pos" =>  	$kode_pos,
			"nik" =>  	$nik,
			"nama" =>  	$nama,
			"jenis_kelamin" =>  	$jenis_kelamin,
			"tempat_lahir" =>  	$tempat_lahir,
			"tanggal_lahir" =>  	$tanggal_lahir,
			"no_akta" =>  	$no_akta,
			"gol_darah" =>  	$gol_darah,
			"agama" =>  	$agama,
			"pekerjaan" =>  	$pekerjaan,
			"nama_ibu" =>  	$nama_ibu,
			"nama_ayah" =>  	$nama_ayah,
			"status_perkawinan" =>  	$status_perkawinan,
			"id_kelurahan" =>  	$id_kelurahan);
			
			$hasil = $this->surat_serv->getsimpanpenduduk($data);
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->homeAction();
				$this->render('home');				
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diproses </div>";		
			$this->homeAction();
			$this->render('home');	
		}
		
		public function rumahsakitselesaiAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->nama_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_rumahsakit= $this->_getParam("id_permintaan_rumahsakit");
			$nama= $this->_getParam("nama");
			$no_registrasi= $this->_getParam("no_registrasi");
			$status= 3;	
			
			//menghitung waktu total
			$waktu_antrian = $_POST['waktu_antrian'];
			$mulai_time = $waktu_antrian;
			$waktu_selesai=date("H:i:s"); //jam dalam format DATE real itme
			
			$mulai_time=(is_string($mulai)?strtotime($mulai):$mulai);// memaksa mebentuk format time untuk string
			$selesai_time=(is_string($waktu_selesai)?strtotime($waktu_selesai):$waktu_selesai);
			
			$selisih_waktu=$selesai_time-$mulai_time; //hitung selisih dalam detik
			
			//Untuk menghitung jumlah dalam satuan jam:
			$sisa = $selisih_waktu % 86400;
			$jumlah_jam = floor($sisa/3600);
			
			//Untuk menghitung jumlah dalam satuan menit:
			$sisa = $sisa % 3600;
			$jumlah_menit = floor($sisa/60);
			
			//Untuk menghitung jumlah dalam satuan detik:
			$sisa = $sisa % 60;
			$jumlah_detik = floor($sisa/1);
			
			$waktu_total = $jumlah_jam ." jam ". $jumlah_menit  ." menit ". $jumlah_detik  ." detik " ;
			
			
			$data = array("id_permintaan_rumahsakit" => $id_permintaan_rumahsakit,
			"status" => $status,
			"waktu_selesai" => $waktu_selesai,
			"waktu_total" => $waktu_total);
			
			$hasil = $this->surat_serv->getSelesaiRumahsakit($data);
			//var_dump($hasil);
			if(hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan var_dump($hasil) </div>";
				$this->rumahsakitAction();
				$this->render('rumahsakit');				
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> SELAMAT, proses permintaan rumah sakit untuk:Nama $nama,No Registrasi $no_registrasi SELESAI  </div>";		
			$this->rumahsakitAction();
			$this->render('rumahsakit');			
			
			
			
		}
		
		
		///////////////////////////////Sekolah
		//cetak surat sekolah
		public function sekolahcetakAction(){
			$id_permintaan_sekolah = $this->_getParam("id_permintaan_sekolah");
			$this->view->hasil = $this->surat_serv->getsekolahcetak($id_permintaan_sekolah);
		}
		
		public function sekolahAction(){
			$this->view;
			$this->view->kelurahan = $this->id_kelurahan;
			$this->id_kelurahan;
			
			$dataPerPage = 10;
			// apabila $_GET['page'] sudah didefinisikan, gunakan nomor halaman tersebut,
			// sedangkan apabila belum, nomor halamannya 1.
			$noPage = $this->_getParam("page");
			if(isset($noPage))
			{
				$noPage = $this->_getParam("page");
			}
			else{ 
				$noPage = 1;
			}
			
			$offset = ($noPage - 1) * $dataPerPage;
			$this->view->jumData = $this->surat_serv->getJumlahSekolah($this->id_kelurahan);
			$this->view->dataPerPage = $dataPerPage;
			$this->view->noPage = $noPage;
			$this->view->offset=$offset;
			
			$id_surat = $this->_getParam("id_surat");
			$this->view->surat = "Surat Keterangan Tidak Mampu untuk Sekolah";
			$this->view->permintaan = $this->surat_serv->getProsesSekolah($this->id_kelurahan,$offset,$dataPerPage);
		}
		public function pencariansekolahAction(){
			$this->view;
			$this->view->kelurahan = $this->id_kelurahan;
			$this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			$id_pencarian = $_POST['id_pencarian'];
			$pencarian = $_POST['pencarian'];
			if(!$pencarian){
				$this->sekolahAction();
				$this->render('sekolah');
				}else{
				$this->view->surat = "Surat Keterangan Tidak Mampu untuk Sekolah";
				$this->view->cari = $pencarian;
				$this->view->permintaan = $this->surat_serv->getPencarianSekolah($this->id_kelurahan,$pencarian,$id_pencarian);
			}
			
		}
		public function caripenduduksekolahAction() {
			$this->view;
			$this->view->surat = "Form Isian Surat Keterangan Tidak Mampu untuk Sekolah";
			$this->view->judul = "Masukan NIK";
		}
		
		//antrian sekolah --> proses memasukan ke antrian sekolah, status = 1
		public function sekolahantrianAction(){
			$nik = $_POST['nik'];
			$this->view->surat = "Form Antrian Keterangan SKTM sekolah";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			
			//mengambil noregistrasi secara automatis
			$no_registrasi = $this->surat_serv->getNoRegistrasi(4,SKL); //4 adalah panjangnya, AN adalah kode huruf
			$this->view->no_registrasi=$no_registrasi;
			
			$this->render('sekolahantrian');
			
		}
		
		//menyimpan antrian sekolah
		public function simpansekolahantrianAction(){
			if(isset($_POST['name'])){ 
				$id_kelurahan = $this->id_kelurahan;			
				$id_pengguna = $this->id_pengguna;		
				$nama_pengguna = $this->nama_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$waktu_antrian = date('H:i:s');
				$antrian_oleh = $nama_pengguna;
				$jam_masuk = date('H:i:s');
				$status = 1;
				
				//simpan data ke tabel sekolah
				$data = array("id_pengguna" =>  	$id_pengguna,
				"id_kelurahan" => $id_kelurahan,
				"no_registrasi" => $no_registrasi,
				"nik" => $nik,
				"waktu_antrian" => $waktu_antrian,
				"antrian_oleh" => $antrian_oleh,
				"jam_masuk" => $jam_masuk,							
				"status" => $status
				);										 
				$hasil = $this->surat_serv->getsimpansekolahantrian($data);
				
				//simpan data ke tabel no_registrasi
				$registrasi = array("no_registrasi" =>  	$no_registrasi,
				"nik" => $nik							
				);										 
				$hasil2 = $this->surat_serv->getSimpanNoRegistrasi($registrasi);
				
				
				//jika gagal
				if($hasil=="gagal"){
					$this->view->peringatan ="<div class='gagal'> $hasil. Maaf ada kesalahan</div>";
					$this->sekolahAction();
					$this->render('sekolah');					
				}
				//jika sukses
				$this->view->peringatan ="<div class='sukses'> Sukses, data berhasil ditambahkan ke antrian </div>";		
				$this->sekolahAction();
				$this->render('sekolah');	
				}else{
				$this->sekolahAction();
				$this->render('sekolah');
			}
			
		}
		
		
		public function sekolahprosesAction(){
			
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_sekolah= $this->_getParam("id_permintaan_sekolah");
			$no_registrasi= $this->_getParam(no_registrasi);
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;		
			
			
			$this->view->surat = "Form Isian Surat Keterangan Tidak Mampu untuk Sekolah";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('sekolahproses');
		}
		
		public function simpanprosessekolahAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->nama_pengguna;
				
				$waktu_proses = date("H:i:s");
				$proses_oleh= $nama_pengguna;
				
				$id_permintaan_sekolah = $_POST['id_permintaan_sekolah'];
				$id_jenis_surat = $_POST['id_jenis_surat'];
				$id_surat = $_POST['id_surat'];
				
				$id_kelurahan = $this->id_kelurahan;
				$id_pejabat = $_POST['id_pejabat'];
				$nik = $_POST['nik'];
				$no_kip = $_POST['no_kip'];
				$nama_siswa = $_POST['nama_siswa'];
				$tempat_lahir_siswa = $_POST['tempat_lahir_siswa'];
				$tanggal_lahir_siswa = $_POST['tanggal_lahir_siswa'];
				$no_surat = $_POST['no_surat'];
				$tanggal_surat = $_POST['tanggal_surat'];
				$no_surat_pengantar = $_POST['no_surat_pengantar'];
				$hub_keluarga = $_POST['hub_keluarga'];
				$nama_sekolah = $_POST['nama_sekolah'];
				$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
				$masa_berlaku = $_POST['masa_berlaku'];
				$keperluan = $_POST['keperluan'];
				$status = 2;
				
				$data = array("id_kelurahan" =>  	$id_kelurahan,
				"id_pengguna" =>  	$id_pengguna,
				"id_pejabat" =>  	$id_pejabat,
				"id_permintaan_sekolah" => $id_permintaan_sekolah,
				"id_jenis_surat" => $id_jenis_surat,
				"id_surat" => $id_surat,							
				"nik" => $nik,
				"no_kip" => $no_kip,
				"nama_siswa" => $nama_siswa,
				"tempat_lahir_siswa" => $tempat_lahir_siswa,
				"tanggal_lahir_siswa" => $tanggal_lahir_siswa,
				"no_surat" => $no_surat,
				"tanggal_surat" => $tanggal_surat,
				"no_surat_pengantar" => $no_surat_pengantar,
				"hub_keluarga" => $hub_keluarga,
				"nama_sekolah" => $nama_sekolah,
				"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
				"masa_berlaku" => $masa_berlaku,
				"keperluan" => $keperluan,
				"status" => $status,
				"waktu_proses" => $waktu_proses,
				"proses_oleh" => $proses_oleh
				);
				
				$hasil = $this->surat_serv->getsimpanprosessekolah($data);
				
				//jika gagal
				if($hasil=='gagal'){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan. $hasil </div>";
					$this->sekolahAction();
					$this->render('sekolah');				
					}if($hasil=='sukses'){
					//jika sukses
					$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diproses </div>";		
					$this->sekolahAction();
					$this->render('sekolah');
				}
				}else{
				$this->sekolahAction();
				$this->render('sekolah');
			}
			
		}
		
		public function sekolahhapusAction(){
			$id_permintaan_sekolah= $this->_getParam("id_permintaan_sekolah");
			$hasil = $this->surat_serv->gethapussekolah($id_permintaan_sekolah);
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->sekolahAction();
				$this->render('sekolah');				
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
			$this->sekolahAction();
			$this->render('sekolah');	
		}
		public function sekolaheditAction(){
			$id_permintaan_sekolah = $this->_getParam("id_permintaan_sekolah");
			$this->view->surat = "Ubah Permintaan Surat Keterangan Tidak Mampu untuk Sekolah";
			$this->view->hasil = $this->surat_serv->getsekolah($id_permintaan_sekolah);
		}
		
		public function simpanprosessekolaheditAction(){
			$id_permintaan_sekolah = $this->_getParam('id_permintaan_sekolah');
			$id_kelurahan = $this->id_kelurahan;
			$nik = $_POST['nik'];
			$no_kip = $_POST['no_kip'];
			$nama_siswa = $_POST['nama_siswa'];
			$tempat_lahir_siswa = $_POST['tempat_lahir_siswa'];
			$tanggal_lahir_siswa = $_POST['tanggal_lahir_siswa'];
			$no_surat = $_POST['no_surat'];
			$tanggal_surat = $_POST['tanggal_surat'];
			$no_surat_pengantar = $_POST['no_surat_pengantar'];
			$hub_keluarga = $_POST['hub_keluarga'];
			$nama_sekolah = $_POST['nama_sekolah'];
			$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
			$masa_berlaku = $_POST['masa_berlaku'];
			$keperluan = $_POST['keperluan'];
			
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
			"id_pengguna" => $id_pengguna,
			"id_permintaan_sekolah" => $id_permintaan_sekolah,
			"nik" => $nik,
			"no_kip" => $no_kip,
			"nama_siswa" => $nama_siswa,
			"tempat_lahir_siswa" => $tempat_lahir_siswa,
			"tanggal_lahir_siswa" => $tanggal_lahir_siswa,
			"no_surat" => $no_surat,
			"tanggal_surat" => $tanggal_surat,
			"no_surat_pengantar" => $no_surat_pengantar,
			"hub_keluarga" => $hub_keluarga,
			"nama_sekolah" => $nama_sekolah,
			"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
			"masa_berlaku" => $masa_berlaku,
			"keperluan" => $keperluan);
			
			$hasil = $this->surat_serv->getsimpanprosessekolahedit($data);
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->sekolahAction();
				$this->render('sekolah');				
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
			$this->sekolahAction();
			$this->render('sekolah');
		}
		
		public function sekolahselesaiAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->nama_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_sekolah= $this->_getParam("id_permintaan_sekolah");
			$nama= $this->_getParam("nama");
			$no_registrasi= $this->_getParam("no_registrasi");
			$status= 3;	
			
			//menghitung waktu total
			$waktu_antrian = $_POST['waktu_antrian'];
			$mulai_time = $waktu_antrian;
			$waktu_selesai=date("H:i:s"); //jam dalam format DATE real itme
			
			$mulai_time=(is_string($mulai)?strtotime($mulai):$mulai);// memaksa mebentuk format time untuk string
			$selesai_time=(is_string($waktu_selesai)?strtotime($waktu_selesai):$waktu_selesai);
			
			$selisih_waktu=$selesai_time-$mulai_time; //hitung selisih dalam detik
			
			//Untuk menghitung jumlah dalam satuan jam:
			$sisa = $selisih_waktu % 86400;
			$jumlah_jam = floor($sisa/3600);
			
			//Untuk menghitung jumlah dalam satuan menit:
			$sisa = $sisa % 3600;
			$jumlah_menit = floor($sisa/60);
			
			//Untuk menghitung jumlah dalam satuan detik:
			$sisa = $sisa % 60;
			$jumlah_detik = floor($sisa/1);
			
			$waktu_total = $jumlah_jam ." jam ". $jumlah_menit  ." menit ". $jumlah_detik  ." detik " ;
			
			
			$data = array("id_permintaan_sekolah" => $id_permintaan_sekolah,
			"status" => $status,
			"waktu_selesai" => $waktu_selesai,
			"waktu_total" => $waktu_total);
			
			$hasil = $this->surat_serv->getSelesaiSekolah($data);
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan. $hasil </div>";
				$this->sekolahAction();
				$this->render('sekolah');				
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> SELAMAT, proses permintaan sekolah untuk:Nama $nama,No Registrasi $no_registrasi SELESAI  </div>";		
			$this->sekolahAction();
			$this->render('sekolah');			
			
		}
		
		
		//--------------------------------------ANDON NIKAH
		//cetak surat andonnikah
		public function andonnikahcetakAction(){
			$id_permintaan_andonnikah = $this->_getParam("id_permintaan_andonnikah");
			$this->view->hasil = $this->surat_serv->getandonnikahcetak($id_permintaan_andonnikah);
		}
		
		public function andonnikahAction(){
			$this->view;
			$this->view->kelurahan = $this->id_kelurahan;
			$this->id_kelurahan;
			
			$dataPerPage = 10;
			$noPage = $this->_getParam("page");
			if(isset($noPage))
			{
				$noPage = $this->_getParam("page");
			}
			else{ 
				$noPage = 1;
			}
			
			$offset = ($noPage - 1) * $dataPerPage;
			$this->view->jumData = $this->surat_serv->getJumlahAndonNikah($this->id_kelurahan);
			$this->view->dataPerPage = $dataPerPage;
			$this->view->noPage = $noPage;
			$this->view->offset=$offset;
			
			$id_surat = $this->_getParam("id_surat");
			$this->view->surat = "Surat Andon Nikah";		
			$this->view->permintaan = $this->surat_serv->getProsesAndonNikah($this->id_kelurahan,$offset,$dataPerPage);
			
			//mendapatkan jumlah yang belum diproses dan selesai
			$jumlahstatus1 = $this->surat_serv->getJumlahStatus1();	
			if($jumlahstatus1>=1){		
				$peringatanstatus1 = "Ada $jumlahstatus1 surat yang belum diproses. Silakan tekan tombol proses";
			}
			$this->view->jumlahstatus1 = $jumlahstatus1;
			$this->view->peringatanstatus1 = $peringatanstatus1;
			
			$jumlahstatus2 = $this->surat_serv->getJumlahStatus2();
			if($jumlahstatus2>=1){
				$peringatanstatus2 = "Ada $jumlahstatus2 surat yang belum selesai. Silakan tekan tombol selesai";
			}
			$this->view->jumlahstatus2 = $jumlahstatus2;
			$this->view->peringatanstatus2 = $peringatanstatus2;
		}
		
		//fungsi searching di halaman andonnikah
		public function pencarianandonnikahAction(){
			$this->view;
			$this->view->kelurahan = $this->id_kelurahan;
			$this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			$id_pencarian = $_POST['id_pencarian'];
			$pencarian = $_POST['pencarian'];
			if(!$pencarian){
				$this->andonnikahAction();
				$this->render('andonnikah');
				}else{
				$this->view->surat = "Surat Andon Nikah";
				$this->view->cari = $pencarian;
				$this->view->permintaan = $this->surat_serv->getPencarianAndonNikah($this->id_kelurahan,$pencarian,$id_pencarian);
			}
			
		}
		
		//pencarian andonnikah berdasarkan nik
		public function caripendudukandonnikahAction() {
			$this->view;
			$this->view->surat = "Silakan cari data penduduk berdasarkan NIK";
			$this->view->judul = "Masukan NIK";
		}
		
		//antrian andonnikah --> proses memasukan ke antrian andonikah, status = 1
		public function andonnikahantrianAction(){
			$nik = $_POST['nik'];
			$this->view->surat = "Form Antrian Keterangan Andon Nikah";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			
			//mengambil noregistrasi secara automatis
			$no_registrasi = $this->surat_serv->getNoRegistrasi(4,400); //4 adalah panjangnya, AN adalah kode huruf
			$this->view->no_registrasi=$no_registrasi;
			
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('andonnikahantrian');
			
		}
		
		//menyimpan antrian andon nikah
		public function simpanandonnikahantrianAction(){
			if(isset($_POST['name'])){ 
				$id_kelurahan = $this->id_kelurahan;			
				$id_pengguna = $this->id_pengguna;		
				$nama_pengguna = $this->nama_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$waktu_antrian = date('H:i:s');
				$antrian_oleh = $nama_pengguna;
				$jam_masuk = date('H:i:s');
				$status = 1;
				
				//simpan data ke tabel andon nikah
				$data = array("id_pengguna" =>  	$id_pengguna,
								"id_kelurahan" => $id_kelurahan,
								"no_registrasi" => $no_registrasi,
								"nik" => $nik,
								"waktu_antrian" => $waktu_antrian,
								"antrian_oleh" => $antrian_oleh,
								"jam_masuk" => $jam_masuk,							
								"status" => $status
								);										 
				$hasil = $this->surat_serv->getsimpanandonnikahantrian($data);
				
				//simpan data ke tabel no_registrasi
				$registrasi = array("no_registrasi" =>  	$no_registrasi,
									"nik" => $nik							
									);										 
				$hasil = $this->surat_serv->getSimpanNoRegistrasi($registrasi);
				
				
				//jika gagal
				if($hasil=="gagal"){
					$this->view->peringatan ="<div class='gagal'>$hasil. Maaf ada kesalahan;</div>";
					$this->andonnikahAction();
					$this->render('andonnikah');					
				}
				//jika sukses
				if($hasil=="sukses"){
					$this->view->peringatan ="<div class='sukses'> Sukses, data berhasil ditambahkan ke antrian </div>";		
					$this->andonnikahAction();
					$this->render('andonnikah');
				}	
				}else{
				$this->andonnikahAction();
				$this->render('andonnikah');
			}
			
		}
		
		public function permintaancariandonnikahAction(){
			$nik = $_POST['nik'];
			$hasil = $this->surat_serv->getCariPenduduk($nik);
			echo json_encode ($hasil);
		}
		
		public function andonnikahprosesAction(){
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_andonnikah= $this->_getParam("id_permintaan_andonnikah");
			$no_registrasi= $this->_getParam(no_registrasi);
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;		
			
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->view->surat = "Form Isian Surat Keterangan Andon Nikah";
			$this->render('andonnikahproses');
		}
		
		public function simpanprosesandonnikahAction(){
			if(isset($_POST['name'])){ 
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->nama_pengguna;
				
				$waktu_proses = date("H:i:s");
				$proses_oleh= $nama_pengguna;
				
				$id_kelurahan = $this->id_kelurahan;
				$id_permintaan_andonnikah = $_POST['id_permintaan_andonnikah'];
				$id_jenis_surat = $_POST['id_jenis_surat'];
				$id_surat = $_POST['id_surat'];
				$nik = $_POST['nik'];
				$id_pejabat = $_POST['id_pejabat'];
				$no_surat = $_POST['no_surat'];
				$tanggal_surat = $_POST['tanggal_surat'];
				$no_surat_pengantar = $_POST['no_surat_pengantar'];
				$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
				$nama_pasangan = $_POST['nama_pasangan'];
				$alamat_pasangan = $_POST['alamat_pasangan'];
				$status = 2;
				
				$data = array("id_kelurahan" =>  $id_kelurahan,
								"id_permintaan_andonnikah" => $id_permintaan_andonnikah,
								"nik" => $nik,
								"id_pejabat" => $id_pejabat,
								"id_jenis_surat" => $id_jenis_surat,
								"id_surat" => $id_surat,
								"no_surat" => $no_surat,
								"tanggal_surat" => $tanggal_surat,
								"no_surat_pengantar" => $no_surat_pengantar,
								"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
								"nama_pasangan" => $nama_pasangan,
								"alamat_pasangan" => $alamat_pasangan,
								"status" => $status,
								"waktu_proses" => $waktu_proses,
								"proses_oleh" => $proses_oleh
								);
				
				$hasil = $this->surat_serv->getsimpanprosesandonnikah($data);
				// var_dump($hasil);
				// var_dump($data);
				//jika gagal
				if($hasil=='gagal'){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
					$this->andonnikahAction();
					$this->render('andonnikah');					
				}
				//jika sukses
				if($hasil=='sukses'){
					$this->view->peringatan ="<div class='sukses'> $hasil </div>";		
					$this->andonnikahAction();
					$this->render('andonnikah');	
				}
				}else{
				$this->andonnikahAction();
				$this->render('andonnikah');
			}
			
		}
		
		
		public function andonnikahhapusAction(){
			$id_permintaan_andonnikah= $this->_getParam("id_permintaan_andonnikah");
			$hasil = $this->surat_serv->gethapusandonnikah($id_permintaan_andonnikah);
			//jika gagal
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->andonnikahAction();
				$this->render('andonnikah');					
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
				$this->andonnikahAction();
				$this->render('andonnikah');	
			}
		}
		public function andonnikaheditAction(){
			$id_permintaan_andonnikah = $this->_getParam("id_permintaan_andonnikah");
			$this->view->surat = "Ubah Permintaan Surat Keterangan Andon Nikah";
			$this->view->hasil = $this->surat_serv->getandonnikah($id_permintaan_andonnikah);
		}
		
		public function simpanprosesandonnikaheditAction(){
			$id_permintaan_andonnikah = $this->_getParam('id_permintaan_andonnikah');
			$id_kelurahan = $this->id_kelurahan;
			$nik = $_POST['nik'];
			$no_surat = $_POST['no_surat'];
			$tanggal_surat = $_POST['tanggal_surat'];
			$no_surat_pengantar = $_POST['no_surat_pengantar'];
			$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
			$nama_pasangan = $_POST['nama_pasangan'];
			$alamat_pasangan = $_POST['alamat_pasangan'];
			
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
							"id_permintaan_andonnikah" => $id_permintaan_andonnikah,
							"nik" => $nik,
							"no_surat" => $no_surat,
							"tanggal_surat" => $tanggal_surat,
							"no_surat_pengantar" => $no_surat_pengantar,
							"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
							"nama_pasangan" => $nama_pasangan,
							"alamat_pasangan" => $alamat_pasangan,
						);
			
			$hasil = $this->surat_serv->getsimpanprosesandonnikahedit($data);
			//jika gagal
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->andonnikahAction();
				$this->render('andonnikah');				
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
				$this->andonnikahAction();
				$this->render('andonnikah');
			}
		}
		
		//proses selesai
		public function andonnikahselesaiAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->nama_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_andonnikah= $this->_getParam("id_permintaan_andonnikah");
			$nama= $this->_getParam("nama");
			$no_registrasi= $this->_getParam("no_registrasi");
			$status= 3;	
			
			//menghitung waktu total
			$waktu_antrian = $_POST['waktu_antrian'];
			$mulai_time = $waktu_antrian;
			$waktu_selesai=date("H:i:s"); //jam dalam format DATE real itme
			
			$mulai_time=(is_string($mulai)?strtotime($mulai):$mulai);// memaksa mebentuk format time untuk string
			$selesai_time=(is_string($waktu_selesai)?strtotime($waktu_selesai):$waktu_selesai);
			
			$selisih_waktu=$selesai_time-$mulai_time; //hitung selisih dalam detik
			
			//Untuk menghitung jumlah dalam satuan jam:
			$sisa = $selisih_waktu % 86400;
			$jumlah_jam = floor($sisa/3600);
			
			//Untuk menghitung jumlah dalam satuan menit:
			$sisa = $sisa % 3600;
			$jumlah_menit = floor($sisa/60);
			
			//Untuk menghitung jumlah dalam satuan detik:
			$sisa = $sisa % 60;
			$jumlah_detik = floor($sisa/1);
			
			$waktu_total = $jumlah_jam ." jam ". $jumlah_menit  ." menit ". $jumlah_detik  ." detik " ;
			
			
			$data = array("id_permintaan_andonnikah" => $id_permintaan_andonnikah,
							"status" => $status,
							"waktu_selesai" => $waktu_selesai,
							"waktu_total" => $waktu_total
						);
			
			$hasil = $this->surat_serv->getSelesaiAndonnikah($data);
			//var_dump($hasil);
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'>$hasil. Maaf ada kesalahan </div>";
				$this->andonnikahAction();
				$this->render('andonnikah');				
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> SELAMAT, proses permintaan andonnikah atas Nama $nama, No Registrasi $no_registrasi SELESAI  </div>";		
				$this->andonnikahAction();
				$this->render('andonnikah');
			}			
		}
		
		
		
		//-------------------------------BELUM MENIKAH
		//cetak surat belummenikah
		public function belummenikahcetakAction(){
			$id_permintaan_belummenikah = $this->_getParam("id_permintaan_belummenikah");
			$this->view->hasil = $this->surat_serv->getbelummenikahcetak($id_permintaan_belummenikah);
		}
		
		public function belummenikahAction(){
			$this->view;
			$this->view->kelurahan = $this->id_kelurahan;
			$this->id_kelurahan;
			
			
			$dataPerPage = 10;
			$noPage = $this->_getParam("page");
			if(isset($noPage))
			{
				$noPage = $this->_getParam("page");
			}
			else{ 
				$noPage = 1;
			}
			
			$offset = ($noPage - 1) * $dataPerPage;
			$this->view->jumData = $this->surat_serv->getJumlahbm($this->id_kelurahan);
			$this->view->dataPerPage = $dataPerPage;
			$this->view->noPage = $noPage;
			$this->view->offset=$offset;
			
			$id_surat = $this->_getParam("id_surat");
			$this->view->surat = "Surat Keterangan Belum Menikah";
			$this->view->permintaan = $this->surat_serv->getProsesBelumMenikah($this->id_kelurahan,$offset,$dataPerPage);
		}
		public function pencarianbelummenikahAction(){
			$this->view;
			$this->view->kelurahan = $this->id_kelurahan;
			$this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			$id_pencarian = $_POST['id_pencarian'];
			$pencarian = $_POST['pencarian'];
			if(!$pencarian){
				$this->belummenikahAction();
				$this->render('belummenikah');
				}else{
				$this->view->surat = "Surat Keterangan Belum Menikah";
				$this->view->cari = $pencarian;
				$this->view->permintaan = $this->surat_serv->getPencarianBelumMenikah($this->id_kelurahan,$pencarian,$id_pencarian);
			}
			
		}
		public function caripendudukbelummenikahAction() {
			$this->view;
			$this->view->surat = "Form Isian Surat Keterangan Belum Menikah";
			$this->view->judul = "Masukan NIK";
		}
		
		//antrian andonnikah --> proses memasukan ke antrian andonikah, status = 1
		public function belummenikahantrianAction(){
			$nik = $_POST['nik'];
			$this->view->surat = "Form Antrian Keterangan Belum Menikah";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			
			//mengambil noregistrasi secara automatis
			$no_registrasi = $this->surat_serv->getNoRegistrasi(4,BMK); //4 adalah panjangnya, AN adalah kode huruf
			$this->view->no_registrasi=$no_registrasi;
			
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('belummenikahantrian');
			
		}
		
		//menyimpan antrian belummenikah
		public function simpanbelummenikahantrianAction(){
			if(isset($_POST['name'])){ 
				$id_kelurahan = $this->id_kelurahan;			
				$id_pengguna = $this->id_pengguna;		
				$nama_pengguna = $this->nama_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$waktu_antrian = date('H:i:s');
				$antrian_oleh = $nama_pengguna;
				$jam_masuk = date('H:i:s');
				$status = 1;
				
				//simpan data ke tabel andon nikah
				$data = array("id_pengguna" =>  	$id_pengguna,
				"id_kelurahan" => $id_kelurahan,
				"no_registrasi" => $no_registrasi,
				"nik" => $nik,
				"waktu_antrian" => $waktu_antrian,
				"antrian_oleh" => $antrian_oleh,
				"jam_masuk" => $jam_masuk,							
				"status" => $status
				);										 
				$hasil = $this->surat_serv->getsimpanbelummenikahantrian($data);
				
				//simpan data ke tabel no_registrasi
				$registrasi = array("no_registrasi" =>  	$no_registrasi,
				"nik" => $nik							
				);										 
				$hasil2 = $this->surat_serv->getSimpanNoRegistrasi($registrasi);
				
				var_dump($registrasi);
				var_dump($hasil2);
				
				//jika gagal
				if($hasil=="gagal"){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan;</div>";
					$this->belummenikahAction();
					$this->render('belummenikah');					
				}
				//jika sukses
				if($hasil=="sukses"){
					$this->view->peringatan ="<div class='sukses'> Sukses, data berhasil ditambahkan ke antrian </div>";		
					$this->belummenikahAction();
					$this->render('belummenikah');	
				}
				}else{
				$this->belummenikahAction();
				$this->render('belummenikah');
			}
			
		}
		
		public function belummenikahprosesAction(){
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_belummenikah= $this->_getParam("id_permintaan_belummenikah");
			$no_registrasi= $this->_getParam(no_registrasi);
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;
			
			
			
			$this->view->surat = "Form Isian Surat Keterangan Belum Menikah";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
		}
		public function simpanprosesbelummenikahAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->nama_pengguna;
				
				$waktu_proses = date("H:i:s");
				$proses_oleh= $nama_pengguna;
				
				$id_kelurahan = $this->id_kelurahan;
				$id_permintaan_belummenikah = $_POST['id_permintaan_belummenikah'];
				$id_jenis_surat = $_POST['id_jenis_surat'];
				$id_surat = $_POST['id_surat'];
				
				$nik = $_POST['nik'];
				$id_pejabat = $_POST['id_pejabat'];
				$no_surat = $_POST['no_surat'];
				$tanggal_surat = $_POST['tanggal_surat'];
				$no_surat_pengantar = $_POST['no_surat_pengantar'];
				$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
				$keperluan = $_POST['keperluan'];
				$status = 2;
				
				$data = array("id_kelurahan" =>  	$id_kelurahan,
				"id_permintaan_belummenikah" => $id_permintaan_belummenikah,
				"nik" => $nik,
				"id_pejabat" => $id_pejabat,
				"id_jenis_surat" => $id_jenis_surat,
				"id_surat" => $id_surat,							
				"no_surat_pengantar" => $no_surat_pengantar,
				"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
				"keperluan" => $keperluan,
				"status" => $status,
				"waktu_proses" => $waktu_proses,
				"proses_oleh" => $proses_oleh
				);
				
				$hasil = $this->surat_serv->getsimpanprosesbelummenikah($data);
				//var_dump($data);
				//var_dump($hasil);
				//jika gagal
				if($hasil=='gagal'){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
					$this->belummenikahAction();
					$this->render('belummenikah');				
				}
				//jika sukses
				if($hasil=='sukses'){
					$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diproses </div>";		
					$this->belummenikahAction();
					$this->render('belummenikah');
				}
				}else{
				$this->belummenikahAction();
				$this->render('belummenikah');			
			}
			
		}
		public function belummenikahhapusAction(){
			$id_permintaan_belummenikah= $this->_getParam("id_permintaan_belummenikah");
			$hasil = $this->surat_serv->gethapusbelummenikah($id_permintaan_belummenikah);
			
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->belummenikahAction();
				$this->render('belummenikah');				
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
			$this->belummenikahAction();
			$this->render('belummenikah');	
		}
		public function belummenikaheditAction(){
			$id_permintaan_belummenikah = $this->_getParam("id_permintaan_belummenikah");
			$this->view->surat = "Ubah Permintaan Surat Keterangan Belum Menikah";
			$this->view->hasil = $this->surat_serv->getbelummenikah($id_permintaan_belummenikah);
		}
		
		public function simpanprosesbelummenikaheditAction(){
			$id_permintaan_belummenikah = $this->_getParam('id_permintaan_belummenikah');
			$id_kelurahan = $this->id_kelurahan;
			$nik = $_POST['nik'];
			$no_surat = $_POST['no_surat'];
			$tanggal_surat = $_POST['tanggal_surat'];
			$no_surat_pengantar = $_POST['no_surat_pengantar'];
			$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
			$keperluan = $_POST['keperluan'];
			
			
			$data = array("	id_kelurahan" =>  	$id_kelurahan,
			"id_permintaan_belummenikah" => $id_permintaan_belummenikah,
			"nik" => $nik,
			"no_surat" => $no_surat,
			"tanggal_surat" => $tanggal_surat,
			"no_surat_pengantar" => $no_surat_pengantar,
			"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
			"keperluan" => $keperluan
			);
			
			$hasil = $this->surat_serv->getsimpanprosesbelummenikahedit($data);
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->belummenikahAction();
				$this->render('belummenikah');				
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
			$this->belummenikahAction();
			$this->render('belummenikah');
		}
		
		//proses selesai
		public function belummenikahselesaiAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->nama_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_belummenikah= $this->_getParam("id_permintaan_belummenikah");
			$nama= $this->_getParam("nama");
			$no_registrasi= $this->_getParam("no_registrasi");
			$status= 3;	
			
			//menghitung waktu total
			$waktu_antrian = $_POST['waktu_antrian'];
			$mulai_time = $waktu_antrian;
			$waktu_selesai=date("H:i:s"); //jam dalam format DATE real itme
			
			$mulai_time=(is_string($mulai)?strtotime($mulai):$mulai);// memaksa mebentuk format time untuk string
			$selesai_time=(is_string($waktu_selesai)?strtotime($waktu_selesai):$waktu_selesai);
			
			$selisih_waktu=$selesai_time-$mulai_time; //hitung selisih dalam detik
			
			//Untuk menghitung jumlah dalam satuan jam:
			$sisa = $selisih_waktu % 86400;
			$jumlah_jam = floor($sisa/3600);
			
			//Untuk menghitung jumlah dalam satuan menit:
			$sisa = $sisa % 3600;
			$jumlah_menit = floor($sisa/60);
			
			//Untuk menghitung jumlah dalam satuan detik:
			$sisa = $sisa % 60;
			$jumlah_detik = floor($sisa/1);
			
			$waktu_total = $jumlah_jam ." jam ". $jumlah_menit  ." menit ". $jumlah_detik  ." detik " ;
			
			
			$data = array("id_permintaan_belummenikah" => $id_permintaan_belummenikah,
			"status" => $status,
			"waktu_selesai" => $waktu_selesai,
			"waktu_total" => $waktu_total);
			
			$hasil = $this->surat_serv->getSelesaiBelummenikah($data);
			//var_dump($hasil);
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->belummenikahhAction();
				$this->render('belummenikah');				
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> SELAMAT, proses permintaan belummenikah untuk:Nama $nama,No Registrasi $no_registrasi SELESAI  </div>";		
				$this->belummenikahAction();
				$this->render('belummenikah');	
			}
		}
		
		
		
		//----------------------------------------BELUM PUNYA RUMAH
		//cetak surat bpr
		public function bprcetakAction(){
			$id_permintaan_bpr = $this->_getParam("id_permintaan_bpr");
			$this->view->hasil = $this->surat_serv->getbprcetak($id_permintaan_bpr);
		}
		
		public function bprAction(){
			$this->view;
			$this->view->kelurahan = $this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			
			$dataPerPage = 10;
			// apabila $_GET['page'] sudah didefinisikan, gunakan nomor halaman tersebut,
			// sedangkan apabila belum, nomor halamannya 1.
			$noPage = $this->_getParam("page");
			if(isset($noPage))
			{
				$noPage = $this->_getParam("page");
			}
			else{ 
				$noPage = 1;
			}
			
			$offset = ($noPage - 1) * $dataPerPage;
			$this->view->jumData = $this->surat_serv->getJumlahbpr($this->id_kelurahan);
			$this->view->dataPerPage = $dataPerPage;
			$this->view->noPage = $noPage;
			$this->view->offset=$offset;
			
			$this->view->surat = "Surat Keterangan Belum Mempunyai Rumah";
			$this->view->permintaan = $this->surat_serv->getProsesbpr($this->id_kelurahan,$offset,$dataPerPage);
		}
		public function pencarianbprAction(){
			$this->view;
			$this->view->kelurahan = $this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			$id_pencarian = $_POST['id_pencarian'];
			$pencarian = $_POST['pencarian'];
			if(!$pencarian){
				$this->bprAction();
				$this->render('bpr');
				}else{
				$this->view->surat = "Surat Keterangan Belum Mempunyai Rumah";
				$this->view->cari = $pencarian;
				$this->view->permintaan = $this->surat_serv->getPencarianbpr($this->id_kelurahan,$pencarian,$id_pencarian);
			}
			
		}
		
		public function caripendudukbprAction() {
			$this->view;
			$this->view->surat = "Form Isian Surat Keterangan Belum Mempunyai Rumah";
			$this->view->judul = "Masukan NIK";
		}
		
		
		//antrian bpr --> proses memasukan ke antrian bpr, status = 1
		public function bprantrianAction(){
			$nik = $_POST['nik'];
			$this->view->surat = "Form Antrian Keterangan Belum Punya Rumah";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			
			//mengambil noregistrasi secara automatis
			$no_registrasi = $this->surat_serv->getNoRegistrasi(4,BPR); //4 adalah panjangnya, AN adalah kode huruf
			$this->view->no_registrasi=$no_registrasi;
			
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('bprantrian');
			
		}
		
		//menyimpan antrian bpr
		public function simpanbprantrianAction(){
			if(isset($_POST['name'])){ 
				$id_kelurahan = $this->id_kelurahan;			
				$id_pengguna = $this->id_pengguna;		
				$nama_pengguna = $this->nama_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$waktu_antrian = date('H:i:s');
				$antrian_oleh = $nama_pengguna;
				$jam_masuk = date('H:i:s');
				$status = 1;
				
				//simpan data ke tabel bpr
				$data = array("id_pengguna" =>  	$id_pengguna,
				"id_kelurahan" => $id_kelurahan,
				"no_registrasi" => $no_registrasi,
				"nik" => $nik,
				"waktu_antrian" => $waktu_antrian,
				"antrian_oleh" => $antrian_oleh,
				"jam_masuk" => $jam_masuk,							
				"status" => $status
				);										 
				$hasil = $this->surat_serv->getsimpanbprantrian($data);
				
				//simpan data ke tabel no_registrasi
				$registrasi = array("no_registrasi" =>  	$no_registrasi,
				"nik" => $nik							
				);										 
				$hasil = $this->surat_serv->getSimpanNoRegistrasi($registrasi);
				var_dump($data);
				var_dump($hasil);
				
				//jika gagal
				if($hasil=="gagal"){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
					$this->bprAction();
					$this->render('bpr');					
				}
				//jika sukses
				if($hasil=="sukses"){
					$this->view->peringatan ="<div class='sukses'> Sukses, data berhasil ditambahkan ke antrian </div>";		
					$this->bprAction();
					$this->render('bpr');	
				}
				}else{
				$this->bprAction();
				$this->render('bpr');
			}
			
		}
		
		public function bprprosesAction(){
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_andonnikah= $this->_getParam("id_permintaan_andonnikah");
			$no_registrasi= $this->_getParam(no_registrasi);
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;
			
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;		
			$this->view->surat = "Form Isian Surat Keterangan Belum Mempunyai Rumah";
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			
		}
		
		
		public function simpanprosesbprAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->nama_pengguna;
				
				$waktu_proses = date("H:i:s");
				$proses_oleh= $nama_pengguna;
				
				$id_kelurahan = $this->id_kelurahan;
				$id_permintaan_bpr = $_POST['id_permintaan_bpr'];
				$id_jenis_surat = $_POST['id_jenis_surat'];
				$id_surat = $_POST['id_surat'];
				
				$nik = $_POST['nik'];
				$id_pejabat = $_POST['id_pejabat'];
				$no_surat = $_POST['no_surat'];
				$tanggal_surat = $_POST['tanggal_surat'];
				$no_surat_pengantar = $_POST['no_surat_pengantar'];
				$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
				$keperluan = $_POST['keperluan'];
				$stl = $_POST['stl'];
				$status = 2;
				
				$data = array("id_kelurahan" =>  	$id_kelurahan,
				"id_permintaan_bpr" => $id_permintaan_bpr,
				"nik" => $nik,
				"id_pejabat" => $id_pejabat,
				"id_jenis_surat" => $id_jenis_surat,
				"id_surat" => $id_surat,
				"no_surat" => $no_surat,
				"tanggal_surat" => $tanggal_surat,
				"no_surat_pengantar" => $no_surat_pengantar,
				"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
				"keperluan" => $keperluan,
				"stl" => $stl,
				"status" => $status,
				"waktu_proses"  => $waktu_proses,
				"proses_oleh" => $proses_oleh
				);
				
				$hasil = $this->surat_serv->getsimpanprosesbpr($data);
				// var_dump($data);
				// var_dump($hasil);
				
				//jika gagal
				if($hasil=='gagal'){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
					$this->bprAction();
					$this->render('bpr');			
				}
				//jika sukses
				if($hasil=='sukses'){
					$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diproses </div>";		
					$this->bprAction();
					$this->render('bpr');
				}
				}else{
				$this->bprAction();
				$this->render('bpr');
			}
			
		}
		public function bprhapusAction(){
			$id_permintaan_bpr= $this->_getParam("id_permintaan_bpr");
			$hasil = $this->surat_serv->gethapusbpr($id_permintaan_bpr);
			
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->bprAction();
				$this->render('bpr');			
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
			$this->bprAction();
			$this->render('bpr');	
		}
		public function bpreditAction(){
			$id_permintaan_bpr = $this->_getParam("id_permintaan_bpr");
			$this->view->surat = "Ubah Permintaan Surat Keterangan Belum Mempunyai Rumah";
			$this->view->hasil = $this->surat_serv->getbpr($id_permintaan_bpr);
		}
		
		public function simpanprosesbpreditAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->nama_pengguna;
			
			$tgl_dibuat = date("Y-m-d H:i:s");
			$dibuat_oleh= $nama_pengguna;
			
			$id_permintaan_bpr = $this->_getParam('id_permintaan_bpr');
			$id_kelurahan = $this->id_kelurahan;
			$nik = $_POST['nik'];
			$no_surat = $_POST['no_surat'];
			$tanggal_surat = $_POST['tanggal_surat'];
			$no_surat_pengantar = $_POST['no_surat_pengantar'];
			$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
			$keperluan = $_POST['keperluan'];
			$stl = $_POST['stl'];
			
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
			"id_permintaan_bpr" => $id_permintaan_bpr,
			"nik" => $nik,
			"no_surat" => $no_surat,
			"tanggal_surat" => $tanggal_surat,
			"no_surat_pengantar" => $no_surat_pengantar,
			"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
			"keperluan" => $keperluan,
			"stl" => $stl,
			"tgl_dibuat" => $tgl_dibuat,
			"dibuat_oleh" => $dibuat_oleh
			);
			
			$hasil = $this->surat_serv->getsimpanprosesbpredit($data);
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->bprAction();
				$this->render('bpr');			
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
			$this->bprAction();
			$this->render('bpr');	
		}
		
		//proses selesai
		public function bprselesaiAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->nama_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_bpr= $this->_getParam("id_permintaan_bpr");
			$nama= $this->_getParam("nama");
			$no_registrasi= $this->_getParam("no_registrasi");
			$status= 3;	
			
			//menghitung waktu total
			$waktu_antrian = $_POST['waktu_antrian'];
			$mulai_time = $waktu_antrian;
			$waktu_selesai=date("H:i:s"); //jam dalam format DATE real itme
			
			$mulai_time=(is_string($mulai)?strtotime($mulai):$mulai);// memaksa mebentuk format time untuk string
			$selesai_time=(is_string($waktu_selesai)?strtotime($waktu_selesai):$waktu_selesai);
			
			$selisih_waktu=$selesai_time-$mulai_time; //hitung selisih dalam detik
			
			//Untuk menghitung jumlah dalam satuan jam:
			$sisa = $selisih_waktu % 86400;
			$jumlah_jam = floor($sisa/3600);
			
			//Untuk menghitung jumlah dalam satuan menit:
			$sisa = $sisa % 3600;
			$jumlah_menit = floor($sisa/60);
			
			//Untuk menghitung jumlah dalam satuan detik:
			$sisa = $sisa % 60;
			$jumlah_detik = floor($sisa/1);
			
			$waktu_total = $jumlah_jam ." jam ". $jumlah_menit  ." menit ". $jumlah_detik  ." detik " ;
			
			
			$data = array("id_permintaan_bpr" => $id_permintaan_bpr,
			"status" => $status,
			"waktu_selesai" => $waktu_selesai,
			"waktu_total" => $waktu_total);
			
			$hasil = $this->surat_serv->getSelesaiBpr($data);
			//var_dump($hasil);
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->bprAction();
				$this->render('bpr');				
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> SELAMAT, proses permintaan BPR untuk : Nama $nama,No Registrasi $no_registrasi SELESAI  </div>";		
				$this->bprAction();
				$this->render('bpr');	
			}
		}
		
		//--------------------------------------IBADAH HAJI
		//cetak surat ibadahhaji
		public function ibadahhajicetakAction(){
			$id_permintaan_ibadahhaji = $this->_getParam("id_permintaan_ibadahhaji");
			$this->view->hasil = $this->surat_serv->getibadahhajicetak($id_permintaan_ibadahhaji);
		}
		
		public function ibadahhajiAction(){
			$this->view;
			$this->view->kelurahan = $this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			
			
			$dataPerPage = 10;
			// apabila $_GET['page'] sudah didefinisikan, gunakan nomor halaman tersebut,
			// sedangkan apabila belum, nomor halamannya 1.
			$noPage = $this->_getParam("page");
			if(isset($noPage))
			{
				$noPage = $this->_getParam("page");
			}
			else{ 
				$noPage = 1;
			}
			
			$offset = ($noPage - 1) * $dataPerPage;
			$this->view->jumData = $this->surat_serv->getJumlahih($this->id_kelurahan);
			$this->view->dataPerPage = $dataPerPage;
			$this->view->noPage = $noPage;
			$this->view->offset=$offset;
			
			$this->view->surat = "Surat Keterangan Menunaikan Ibadah Haji";
			$this->view->permintaan = $this->surat_serv->getProsesIbadahHaji($this->id_kelurahan,$offset,$dataPerPage);
		}
		public function pencarianibAction(){
			$this->view;
			$this->view->kelurahan = $this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			$id_pencarian = $_POST['id_pencarian'];
			$pencarian = $_POST['pencarian'];
			if(!$pencarian){
				$this->ibadahhajiAction();
				$this->render('ibadahhaji');
				}else{
				$this->view->surat = "Surat Keterangan Menunaikan Ibadah Haji";
				$this->view->cari = $pencarian;
				$this->view->permintaan = $this->surat_serv->getPencarianib($this->id_kelurahan,$pencarian,$id_pencarian);
			}
			
		}
		public function caripendudukibadahhajiAction() {
			$this->view;
			$this->view->surat = "Form Isian Surat Keterangan Menunaikan Ibadah Haji";
			$this->view->judul = "Masukan NIK";
		}
		
		//antrian andonnikah --> proses memasukan ke antrian andonikah, status = 1
		public function ibadahhajiantrianAction(){
			$nik = $_POST['nik'];
			$this->view->surat = "Form Antrian Keterangan Ibadah Haji";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			
			//mengambil noregistrasi secara automatis
			$no_registrasi = $this->surat_serv->getNoRegistrasi(4,IHJ); //4 adalah panjangnya, AN adalah kode huruf
			$this->view->no_registrasi=$no_registrasi;
			
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('ibadahhajiantrian');
			
		}
		
		//menyimpan antrian andon nikah
		public function simpanibadahhajiantrianAction(){
			if(isset($_POST['name'])){ 
				$id_kelurahan = $this->id_kelurahan;			
				$id_pengguna = $this->id_pengguna;		
				$nama_pengguna = $this->nama_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$waktu_antrian = date('H:i:s');
				$antrian_oleh = $nama_pengguna;
				$jam_masuk = date('H:i:s');
				$status = 1;
				
				//simpan data ke tabel andon nikah
				$data = array("id_pengguna" =>  	$id_pengguna,
				"id_kelurahan" => $id_kelurahan,
				"no_registrasi" => $no_registrasi,
				"nik" => $nik,
				"waktu_antrian" => $waktu_antrian,
				"antrian_oleh" => $antrian_oleh,
				"jam_masuk" => $jam_masuk,							
				"status" => $status
				);										 
				$hasil = $this->surat_serv->getsimpanibadahhajiantrian($data);
				
				//simpan data ke tabel no_registrasi
				$registrasi = array("no_registrasi" =>  	$no_registrasi,
				"nik" => $nik							
				);										 
				$hasil = $this->surat_serv->getSimpanNoRegistrasi($registrasi);
				
				
				//jika gagal
				if($hasil=="gagal"){
					$this->view->peringatan ="<div class='gagal'> $hasil. Maaf ada kesalahan</div>";
					$this->ibadahhajiAction();
					$this->render('ibadahhaji');					
				}
				//jika sukses
				if($hasil=="sukses"){
					$this->view->peringatan ="<div class='sukses'> Sukses, data berhasil ditambahkan ke antrian </div>";		
					$this->ibadahhajiAction();
					$this->render('ibadahhaji');	
				}
				}else{
				$this->ibadahhajiAction();
				$this->render('ibadahhaji');
			}
			
		}
		
		public function ibadahhajiprosesAction(){
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_ibadahhaji= $this->_getParam("id_permintaan_ibadahhaji");
			$no_registrasi= $this->_getParam(no_registrasi);
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;	
			
			
			$this->view->surat = "Form Isian Surat Keterangan Menunaikan Ibadah Haji";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
		}
		
		public function simpanprosesibadahhajiAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->nama_pengguna;
				
				$waktu_proses = date("H:i:s");
				$proses_oleh= $nama_pengguna;
				
				$id_kelurahan = $this->id_kelurahan;
				$id_permintaan_ibadahhaji = $_POST['id_permintaan_ibadahhaji'];
				$id_jenis_surat = $_POST['id_jenis_surat'];
				$id_surat = $_POST['id_surat'];
				
				
				$nik = $_POST['nik'];
				$id_pejabat = $_POST['id_pejabat'];
				$no_surat = $_POST['no_surat'];
				$tanggal_surat = $_POST['tanggal_surat'];
				$no_surat_pengantar = $_POST['no_surat_pengantar'];
				$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
				$status = 2;
				
				$data = array("id_kelurahan" =>  	$id_kelurahan,
				"id_permintaan_ibadahhaji" => $id_permintaan_ibadahhaji,
				"nik" => $nik,
				"id_pejabat" => $id_pejabat,
				"id_jenis_surat" => $id_jenis_surat,
				"id_surat" => $id_surat,							
				"no_surat" => $no_surat,
				"tanggal_surat" => $tanggal_surat,
				"no_surat_pengantar" => $no_surat_pengantar,
				"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
				"status" => $status,
				"waktu_proses," => $waktu_proses,
				"proses_oleh" => $proses_oleh);
				
				$hasil = $this->surat_serv->getsimpanprosesibadahhaji($data);
				// var_dump($hasil);
				// var_dump($data);
				//jika gagal
				if($hasil=='gagal'){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
					$this->ibadahhajiAction();
					$this->render('ibadahhaji');		
				}
				//jika sukses
				if($hasil=='sukses'){
					$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diproses </div>";		
					$this->ibadahhajiAction();
					$this->render('ibadahhaji');
				}
				}else{
				$this->ibadahhajiAction();
				$this->render('ibadahhaji');
			}		
			
		}
		public function ibadahhajihapusAction(){
			$id_permintaan_ibadahhaji= $this->_getParam("id_permintaan_ibadahhaji");
			$hasil = $this->surat_serv->gethapusibadahhaji($id_permintaan_ibadahhaji);
			
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->ibadahhajiAction();
				$this->render('ibadahhaji');		
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
			$this->ibadahhajiAction();
			$this->render('ibadahhaji');	
		}
		public function ibadahhajieditAction(){
			$id_permintaan_ibadahhaji = $this->_getParam("id_permintaan_ibadahhaji");
			$this->view->surat = "Ubah Permintaan Surat Keterangan Menunaikan Ibadah Haji";
			$this->view->hasil = $this->surat_serv->getibadahhaji($id_permintaan_ibadahhaji);
		}
		
		public function simpanprosesibadahhajieditAction(){
			$id_permintaan_ibadahhaji = $this->_getParam('id_permintaan_ibadahhaji');
			$id_kelurahan = $this->id_kelurahan;
			$nik = $_POST['nik'];
			$no_surat = $_POST['no_surat'];
			$tanggal_surat = $_POST['tanggal_surat'];
			$no_surat_pengantar = $_POST['no_surat_pengantar'];
			$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
			
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
			"id_permintaan_ibadahhaji" => $id_permintaan_ibadahhaji,
			"nik" => $nik,
			"no_surat" => $no_surat,
			"tanggal_surat" => $tanggal_surat,
			"no_surat_pengantar" => $no_surat_pengantar,
			"tanggal_surat_pengantar" => $tanggal_surat_pengantar);
			
			$hasil = $this->surat_serv->getsimpanprosesibadahhajiedit($data);
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->ibadahhajiAction();
				$this->render('ibadahhaji');		
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
			$this->ibadahhajiAction();
			$this->render('ibadahhaji');	
		}
		
		public function ibadahhajiselesaiAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->nama_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_ibadahhaji= $this->_getParam("id_permintaan_ibadahhaji");
			$nama= $this->_getParam("nama");
			$no_registrasi= $this->_getParam("no_registrasi");
			$status= 3;	
			
			//menghitung waktu total
			$waktu_antrian = $_POST['waktu_antrian'];
			$mulai_time = $waktu_antrian;
			$waktu_selesai=date("H:i:s"); //jam dalam format DATE real itme
			
			$mulai_time=(is_string($mulai)?strtotime($mulai):$mulai);// memaksa mebentuk format time untuk string
			$selesai_time=(is_string($waktu_selesai)?strtotime($waktu_selesai):$waktu_selesai);
			
			$selisih_waktu=$selesai_time-$mulai_time; //hitung selisih dalam detik
			
			//Untuk menghitung jumlah dalam satuan jam:
			$sisa = $selisih_waktu % 86400;
			$jumlah_jam = floor($sisa/3600);
			
			//Untuk menghitung jumlah dalam satuan menit:
			$sisa = $sisa % 3600;
			$jumlah_menit = floor($sisa/60);
			
			//Untuk menghitung jumlah dalam satuan detik:
			$sisa = $sisa % 60;
			$jumlah_detik = floor($sisa/1);
			
			$waktu_total = $jumlah_jam ." jam ". $jumlah_menit  ." menit ". $jumlah_detik  ." detik " ;
			
			
			$data = array("id_permintaan_ibadahhaji" => $id_permintaan_ibadahhaji,
			"status" => $status,
			"waktu_selesai" => $waktu_selesai,
			"waktu_total" => $waktu_total);
			
			$hasil = $this->surat_serv->getSelesaiIbadahhaji($data);
			//var_dump($hasil);
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan var_dump($hasil) </div>";
				$this->ibadahhajiAction();
				$this->render('ibadahhaji');				
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> SELAMAT, proses permintaan ibadah haji atas Nama $nama,No Registrasi $no_registrasi SELESAI  </div>";		
				$this->ibadahhajiAction();
				$this->render('ibadahhaji');
			}
			
		}
		
		//--------------------------------------JANDA
		//cetak surat janda
		public function jandacetakAction(){
			$id_permintaan_janda = $this->_getParam("id_permintaan_janda");
			$this->view->hasil = $this->surat_serv->getjandacetak($id_permintaan_janda);
		}
		
		
		public function jandaAction(){
			$this->view;
			$this->view->kelurahan = $this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			
			$dataPerPage = 10;
			// apabila $_GET['page'] sudah didefinisikan, gunakan nomor halaman tersebut,
			// sedangkan apabila belum, nomor halamannya 1.
			$noPage = $this->_getParam("page");
			if(isset($noPage))
			{
				$noPage = $this->_getParam("page");
			}
			else{ 
				$noPage = 1;
			}
			
			$offset = ($noPage - 1) * $dataPerPage;
			$this->view->jumData = $this->surat_serv->getJumlahJanda($this->id_kelurahan);
			$this->view->dataPerPage = $dataPerPage;
			$this->view->noPage = $noPage;
			$this->view->offset=$offset;
			
			$this->view->surat = "Surat Keterangan Berstatus Janda";
			$this->view->permintaan = $this->surat_serv->getProsesjanda($this->id_kelurahan,$offset,$dataPerPage);
		}
		public function pencarianjandaAction(){
			$this->view;
			$this->view->kelurahan = $this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			$id_pencarian = $_POST['id_pencarian'];
			$pencarian = $_POST['pencarian'];
			if(!$pencarian){
				$this->jandaAction();
				$this->render('janda');
				}else{
				$this->view->surat = "Surat Keterangan Berstatus Janda";
				$this->view->cari = $pencarian;
				$this->view->permintaan = $this->surat_serv->getPencarianjanda($this->id_kelurahan,$pencarian,$id_pencarian);
			}
			
		}
		public function caripendudukjandaAction() {
			$this->view;
			$this->view->surat = "Form Isian Surat Keterangan Berstatus Janda";
			$this->view->judul = "Masukan NIK";
		}
		
		//antrian janda --> proses memasukan ke antrian janda, status = 1
		public function jandaantrianAction(){
			$nik = $_POST['nik'];
			$this->view->surat = "Form Antrian Keterangan janda";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			
			//mengambil noregistrasi secara automatis
			$no_registrasi = $this->surat_serv->getNoRegistrasi(4,JND); //4 adalah panjangnya, AN adalah kode huruf
			$this->view->no_registrasi=$no_registrasi;
			
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('jandaantrian');
			
		}
		
		//menyimpan antrian janda
		public function simpanjandaantrianAction(){
			if(isset($_POST['name'])){ 
				$id_kelurahan = $this->id_kelurahan;			
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->nama_pengguna;		
				
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$waktu_antrian = date('H:i:s');
				$antrian_oleh = $nama_pengguna;
				$jam_masuk = date('H:i:s');
				$status = 1;
				
				//simpan data ke tabel andon nikah
				$data = array("id_pengguna" =>  	$id_pengguna,
				"id_kelurahan" => $id_kelurahan,
				"no_registrasi" => $no_registrasi,
				"nik" => $nik,
				"waktu_antrian" => $waktu_antrian,
				"antrian_oleh" => $antrian_oleh,
				"jam_masuk" => $jam_masuk,							
				"status" => $status
				);										 
				$hasil = $this->surat_serv->getsimpanjandaantrian($data);
				var_dump($data);
				//simpan data ke tabel no_registrasi
				$registrasi = array("no_registrasi" =>  	$no_registrasi,
				"nik" => $nik							
				);										 
				$hasil = $this->surat_serv->getSimpanNoRegistrasi($registrasi);
				
				
				//jika gagal
				if($hasil=="gagal"){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan ;</div>";
					$this->jandaAction();
					$this->render('janda');					
				}
				//jika sukses
				if($hasil=="sukses"){
					$this->view->peringatan ="<div class='sukses'> Sukses, data berhasil ditambahkan ke antrian </div>";		
					$this->jandaAction();
					$this->render('janda');
				}
				}else{
				$this->jandaAction();
				$this->render('janda');
			}
			
		}
		
		public function jandaprosesAction(){	
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_andonnikah= $this->_getParam("id_permintaan_andonnikah");
			$no_registrasi= $this->_getParam(no_registrasi);
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;	
			
			
			$this->view->surat = "Form Proses Surat Keterangan Berstatus Janda";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
		}
		public function simpanprosesjandaAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->nama_pengguna;
				
				$waktu_proses = date("H:i:s");
				$proses_oleh= $nama_pengguna;
				
				$id_kelurahan = $this->id_kelurahan;
				$id_permintaan_janda = $_POST['id_permintaan_janda'];
				$id_jenis_surat = $_POST['id_jenis_surat'];
				$id_surat = $_POST['id_surat'];
				
				$id_pejabat = $_POST['id_pejabat'];
				$nik = $_POST['nik'];
				$no_surat = $_POST['no_surat'];
				$tanggal_surat = $_POST['tanggal_surat'];
				$no_surat_pengantar = $_POST['no_surat_pengantar'];
				$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
				$sebab_janda = $_POST['sebab_janda'];
				$keperluan = $_POST['keperluan'];
				$status = 2;
				
				$data = array("id_kelurahan" =>  	$id_kelurahan,
				"id_permintaan_janda" => $id_permintaan_janda,
				"nik" => $nik,
				"id_pejabat" => $id_pejabat,
				"id_jenis_surat" => $id_jenis_surat,
				"id_surat" => $id_surat,
				"no_surat" => $no_surat,
				"tanggal_surat" => $tanggal_surat,
				"no_surat_pengantar" => $no_surat_pengantar,
				"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
				"sebab_janda" => $sebab_janda,
				"keperluan" => $keperluan,
				"status" => $status,
				"waktu_proses" => $waktu_proses,
				"proses_oleh" => $proses_oleh
				);
				
				$hasil = $this->surat_serv->getsimpanprosesjanda($data);
				//jika gagal
				var_dump($hasil);
				var_dump($data);
				//jika gagal
				if($hasil=='gagal'){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
					$this->jandaAction();
					$this->render('janda');			
				}
				//jika sukses
				if($hasil=='sukses'){
					$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diproses </div>";		
					$this->jandaAction();
					$this->render('janda');	
				}
				}else{
				$this->jandaAction();
				$this->render('janda');
			}
			
		}
		public function jandahapusAction(){
			$id_permintaan_janda= $this->_getParam("id_permintaan_janda");
			$hasil = $this->surat_serv->gethapusjanda($id_permintaan_janda);
			
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->jandaAction();
				$this->render('janda');			
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
			$this->jandaAction();
			$this->render('janda');	
		}
		public function jandaeditAction(){
			$id_permintaan_janda = $this->_getParam("id_permintaan_janda");
			$this->view->surat = "Ubah Permintaan Surat Keterangan Berstatus Janda";
			$this->view->hasil = $this->surat_serv->getjanda($id_permintaan_janda);
		}
		
		public function simpanprosesjandaeditAction(){
			$id_permintaan_janda = $this->_getParam('id_permintaan_janda');
			$id_kelurahan = $this->id_kelurahan;
			$nik = $_POST['nik'];
			$no_surat = $_POST['no_surat'];
			$tanggal_surat = $_POST['tanggal_surat'];
			$no_surat_pengantar = $_POST['no_surat_pengantar'];
			$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
			$sebab_janda = $_POST['sebab_janda'];
			$keperluan = $_POST['keperluan'];
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
			"id_permintaan_janda" => $id_permintaan_janda,
			"nik" => $nik,
			"no_surat" => $no_surat,
			"tanggal_surat" => $tanggal_surat,
			"no_surat_pengantar" => $no_surat_pengantar,
			"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
			"sebab_janda" => $sebab_janda,
			"keperluan" => $keperluan);
			
			$hasil = $this->surat_serv->getsimpanprosesjandaedit($data);
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->jandaAction();
				$this->render('janda');			
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
			$this->jandaAction();
			$this->render('janda');	
		}
		
		//proses selesai
		public function jandaselesaiAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->nama_pengguna;
			
			$selesai_oleh= $nama_pengguna;
			
			$id_permintaan_janda= $this->_getParam("id_permintaan_janda");
			$nama= $this->_getParam("nama");
			$no_registrasi= $this->_getParam("no_registrasi");
			$status= 3;	
			
			//menghitung waktu total
			$waktu_antrian = $_POST['waktu_antrian'];
			$mulai_time = $waktu_antrian;
			$waktu_selesai=date("H:i:s"); //jam dalam format DATE real itme
			
			$mulai_time=(is_string($mulai)?strtotime($mulai):$mulai);// memaksa mebentuk format time untuk string
			$selesai_time=(is_string($waktu_selesai)?strtotime($waktu_selesai):$waktu_selesai);
			
			$selisih_waktu=$selesai_time-$mulai_time; //hitung selisih dalam detik
			
			//Untuk menghitung jumlah dalam satuan jam:
			$sisa = $selisih_waktu % 86400;
			$jumlah_jam = floor($sisa/3600);
			
			//Untuk menghitung jumlah dalam satuan menit:
			$sisa = $sisa % 3600;
			$jumlah_menit = floor($sisa/60);
			
			//Untuk menghitung jumlah dalam satuan detik:
			$sisa = $sisa % 60;
			$jumlah_detik = floor($sisa/1);
			
			$waktu_total = $jumlah_jam ." jam ". $jumlah_menit  ." menit ". $jumlah_detik  ." detik " ;
			
			
			$data = array("id_permintaan_janda" => $id_permintaan_janda,
			"status" => $status,
			"waktu_selesai" => $waktu_selesai,
			"waktu_total" => $waktu_total);
			
			$hasil = $this->surat_serv->getSelesaiJanda($data);
			//var_dump($hasil);
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->jandaAction();
				$this->render('janda');				
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> SELAMAT, proses permintaan keterangan janda atas Nama $nama,No Registrasi $no_registrasi SELESAI  </div>";		
				$this->jandaAction();
				$this->render('janda');
			}			
		}
		
		
		
		//--------------------------------------IJIN KERAMAIAN
		//cetak surat ik
		public function ikcetakAction(){
			$id_permintaan_ik = $this->_getParam("id_permintaan_ik");
			$this->view->hasil = $this->surat_serv->getikcetak($id_permintaan_ik);
		}
		
		public function ikAction(){
			$this->view;
			$this->view->kelurahan = $this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			
			
			$dataPerPage = 10;
			// apabila $_GET['page'] sudah didefinisikan, gunakan nomor halaman tersebut,
			// sedangkan apabila belum, nomor halamannya 1.
			$noPage = $this->_getParam("page");
			if(isset($noPage))
			{
				$noPage = $this->_getParam("page");
			}
			else{ 
				$noPage = 1;
			}
			
			$offset = ($noPage - 1) * $dataPerPage;
			$this->view->jumData = $this->surat_serv->getJumlahik($this->id_kelurahan);
			$this->view->dataPerPage = $dataPerPage;
			$this->view->noPage = $noPage;
			$this->view->offset=$offset;
			
			$this->view->surat = "Surat Keterangan Ijin Keramaian";
			$this->view->permintaan = $this->surat_serv->getProsesik($this->id_kelurahan,$offset,$dataPerPage);
		}
		public function pencarianikAction(){
			$this->view;
			$this->view->kelurahan = $this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			$id_pencarian = $_POST['id_pencarian'];
			$pencarian = $_POST['pencarian'];
			if(!$pencarian){
				$this->ikAction();
				$this->render('ik');
				}else{
				$this->view->surat = "Surat Keterangan Ijin Keramaian";
				$this->view->cari = $pencarian;
				$this->view->permintaan = $this->surat_serv->getPencarianik($this->id_kelurahan,$pencarian,$id_pencarian);
			}
			
		}
		public function caripendudukikAction() {
			$this->view;
			$this->view->surat = "Form Isian Surat Keterangan Ijin Keramaian";
			$this->view->judul = "Masukan NIK";
		}
		
		//antrian andonnikah --> proses memasukan ke antrian andonikah, status = 1
		public function ikantrianAction(){
			$nik = $_POST['nik'];
			$this->view->surat = "Form Antrian Keterangan Ijin Keramaian";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			
			//mengambil noregistrasi secara automatis
			$no_registrasi = $this->surat_serv->getNoRegistrasi(4,IKR); //4 adalah panjangnya, AN adalah kode huruf
			$this->view->no_registrasi=$no_registrasi;
			
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('ikantrian');
			
		}
		
		//menyimpan antrian ijin keramaian
		public function simpanikantrianAction(){
			if(isset($_POST['name'])){ 
				$id_kelurahan = $this->id_kelurahan;			
				$id_pengguna = $this->id_pengguna;		
				$nama_pengguna = $this->nama_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$waktu_antrian = date('H:i:s');
				$antrian_oleh = $nama_pengguna;
				$jam_masuk = date('H:i:s');
				$status = 1;
				
				//simpan data ke tabel andon nikah
				$data = array("id_pengguna" =>  	$id_pengguna,
				"id_kelurahan" => $id_kelurahan,
				"no_registrasi" => $no_registrasi,
				"nik" => $nik,
				"waktu_antrian" => $waktu_antrian,
				"antrian_oleh" => $antrian_oleh,
				"jam_masuk" => $jam_masuk,							
				"status" => $status
				);										 
				$hasil = $this->surat_serv->getsimpanikantrian($data);
				
				//simpan data ke tabel no_registrasi
				$registrasi = array("no_registrasi" =>  	$no_registrasi,
				"nik" => $nik							
				);										 
				$hasil = $this->surat_serv->getSimpanNoRegistrasi($registrasi);
				
				
				//jika gagal
				if($hasil=="gagal"){
					$this->view->peringatan ="<div class='gagal'> $hasil. Maaf ada kesalahan </div>";
					$this->ikAction();
					$this->render('ik');					
				}
				//jika sukses
				if($hasil=="sukses"){
					$this->view->peringatan ="<div class='sukses'> Sukses, data berhasil ditambahkan ke antrian </div>";		
					$this->ikAction();
					$this->render('ik');
				}	
				}else{
				$this->ikAction();
				$this->render('ik');
			}
			
		}
		
		
		public function ikprosesAction(){
			
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_ik= $this->_getParam("id_permintaan_ik");
			$no_registrasi= $this->_getParam(no_registrasi);
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;
			
			
			$this->view->surat = "Form Isian Surat Ketrangan Ijin Keramaian";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
		}
		public function simpanprosesikAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->nama_pengguna;
				
				$waktu_proses = date("H:i:s");
				$proses_oleh= $nama_pengguna;
				
				$id_kelurahan = $this->id_kelurahan;
				$id_pejabat = $_POST['id_pejabat'];
				
				$id_permintaan_ik = $_POST['id_permintaan_ik'];
				$id_jenis_surat = $_POST['id_jenis_surat'];
				$id_surat = $_POST['id_surat'];
				
				$nik = $_POST['nik'];
				$no_surat = $_POST['no_surat'];
				$tanggal_surat = $_POST['tanggal_surat'];
				$no_surat_pengantar = $_POST['no_surat_pengantar'];
				$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
				$hari_kegiatan = $_POST['hari_kegiatan'];
				$tanggal_kegiatan = $_POST['tanggal_kegiatan'];
				$waktu = $_POST['waktu'];
				$nama_kegiatan = $_POST['nama_kegiatan'];
				$status = 2;
				
				$data = array("id_kelurahan" =>  	$id_kelurahan,
				"id_permintaan_ik" => $id_permintaan_ik,
				"nik" => $nik,
				"id_pejabat" => $id_pejabat,
				"id_jenis_surat" => $id_jenis_surat,
				"id_surat" => $id_surat,
				"no_surat" => $no_surat,
				"tanggal_surat" => $tanggal_surat,
				"no_surat_pengantar" => $no_surat_pengantar,
				"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
				"hari_kegiatan" => $hari_kegiatan,
				"tanggal_kegiatan" => $tanggal_kegiatan,
				"waktu" => $waktu,
				"nama_kegiatan" => $nama_kegiatan,
				"status" => $status,
				"waktu_proses" => $waktu_proses,
				"proses_oleh" => $proses_oleh);
				
				$hasil = $this->surat_serv->getsimpanprosesik($data);
				var_dump($hasil);
				var_dump($data);
				//jika gagal
				if($hasil=='gagal'){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
					$this->ikAction();
					$this->render('ik');			
				}
				//jika sukses
				if($hasil=='sukses'){
					$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diproses </div>";		
					$this->ikAction();
					$this->render('ik');
				}
				}else{
				$this->ikAction();
				$this->render('ik');		
			}
			
		}
		public function ikhapusAction(){
			$id_permintaan_ik= $this->_getParam("id_permintaan_ik");
			$hasil = $this->surat_serv->gethapusik($id_permintaan_ik);
			
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->ikAction();
				$this->render('ik');			
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
			$this->ikAction();
			$this->render('ik');	
		}
		public function ikeditAction(){
			$id_permintaan_ik = $this->_getParam("id_permintaan_ik");
			$this->view->surat = "Ubah Permintaan Surat Ketrangan Ijin Keramaian";
			$this->view->hasil = $this->surat_serv->getik($id_permintaan_ik);
		}
		
		public function simpanprosesikeditAction(){
			$id_permintaan_ik = $this->_getParam('id_permintaan_ik');
			$id_kelurahan = $this->id_kelurahan;
			$nik = $_POST['nik'];
			$no_surat = $_POST['no_surat'];
			$tanggal_surat = $_POST['tanggal_surat'];
			$no_surat_pengantar = $_POST['no_surat_pengantar'];
			$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
			$hari_kegiatan = $_POST['hari_kegiatan'];
			$tanggal_kegiatan = $_POST['tanggal_kegiatan'];
			$waktu = $_POST['waktu'];
			$nama_kegiatan = $_POST['nama_kegiatan'];
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
			"id_permintaan_ik" => $id_permintaan_ik,
			"nik" => $nik,
			"no_surat" => $no_surat,
			"tanggal_surat" => $tanggal_surat,
			"no_surat_pengantar" => $no_surat_pengantar,
			"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
			"hari_kegiatan" => $hari_kegiatan,
			"tanggal_kegiatan" => $tanggal_kegiatan,
			"waktu" => $waktu,
			"nama_kegiatan" => $nama_kegiatan);
			
			$hasil = $this->surat_serv->getsimpanprosesikedit($data);
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->ikAction();
				$this->render('ik');			
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
			$this->ikAction();
			$this->render('ik');	
		}
		
		//proses selesai
		public function ikselesaiAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->nama_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_ik= $this->_getParam("id_permintaan_ik");
			$nama= $this->_getParam("nama");
			$no_registrasi= $this->_getParam("no_registrasi");
			$status= 3;	
			
			//menghitung waktu total
			$waktu_antrian = $_POST['waktu_antrian'];
			$mulai_time = $waktu_antrian;
			$waktu_selesai=date("H:i:s"); //jam dalam format DATE real itme
			
			$mulai_time=(is_string($mulai)?strtotime($mulai):$mulai);// memaksa mebentuk format time untuk string
			$selesai_time=(is_string($waktu_selesai)?strtotime($waktu_selesai):$waktu_selesai);
			
			$selisih_waktu=$selesai_time-$mulai_time; //hitung selisih dalam detik
			
			//Untuk menghitung jumlah dalam satuan jam:
			$sisa = $selisih_waktu % 86400;
			$jumlah_jam = floor($sisa/3600);
			
			//Untuk menghitung jumlah dalam satuan menit:
			$sisa = $sisa % 3600;
			$jumlah_menit = floor($sisa/60);
			
			//Untuk menghitung jumlah dalam satuan detik:
			$sisa = $sisa % 60;
			$jumlah_detik = floor($sisa/1);
			
			$waktu_total = $jumlah_jam ." jam ". $jumlah_menit  ." menit ". $jumlah_detik  ." detik " ;
			
			
			$data = array("id_permintaan_ik" => $id_permintaan_ik,
			"status" => $status,
			"waktu_selesai" => $waktu_selesai,
			"waktu_total" => $waktu_total);
			
			$hasil = $this->surat_serv->getSelesaiIk($data);
			//var_dump($hasil);
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->ikAction();
				$this->render('ik');				
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> SELAMAT, proses permintaan Ijin Keramaian atas Nama $nama, No Registrasi $no_registrasi SELESAI  </div>";		
				$this->ikAction();
				$this->render('ik');
			}			
		}
		
		//--------------------------------------BELUM PENGANTAR SKCK
		
		//cetak surat ps
		public function pscetakAction(){
			$id_permintaan_ps = $this->_getParam("id_permintaan_ps");
			$this->view->hasil = $this->surat_serv->getpscetak($id_permintaan_ps);
		}
		
		
		public function psAction(){
			$this->view;
			$this->view->kelurahan = $this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			
			$dataPerPage = 10;
			// apabila $_GET['page'] sudah didefinisikan, gunakan nomor halaman tersebut,
			// sedangkan apabila belum, nomor halamannya 1.
			$noPage = $this->_getParam("page");
			if(isset($noPage))
			{
				$noPage = $this->_getParam("page");
			}
			else{ 
				$noPage = 1;
			}
			
			$offset = ($noPage - 1) * $dataPerPage;
			$this->view->jumData = $this->surat_serv->getJumlahps($this->id_kelurahan);
			$this->view->dataPerPage = $dataPerPage;
			$this->view->noPage = $noPage;
			$this->view->offset=$offset;
			
			$this->view->surat = "Surat Pengantar SKCK";
			$this->view->permintaan = $this->surat_serv->getProsesps($this->id_kelurahan,$offset,$dataPerPage);
		}
		public function pencarianpsAction(){
			$this->view;
			$this->view->kelurahan = $this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			$id_pencarian = $_POST['id_pencarian'];
			$pencarian = $_POST['pencarian'];
			if(!$pencarian){
				$this->psAction();
				$this->render('ps');
				}else{
				$this->view->surat = "Surat Pengantar SKCK";
				$this->view->cari = $pencarian;
				$this->view->permintaan = $this->surat_serv->getPencarianps($this->id_kelurahan,$pencarian,$id_pencarian);
			}
			
		}
		public function caripendudukpsAction() {
			$this->view;
			$this->view->surat = "Form Isian Surat Pengantar SKCK";
			$this->view->judul = "Masukan NIK";
		}
		
		//antrian ps --> proses memasukan ke antrian ps, status = 1
		public function psantrianAction(){
			$nik = $_POST['nik'];
			$this->view->surat = "Form Antrian Keterangan Pengatar SKCK";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			
			//mengambil noregistrasi secara automatis
			$no_registrasi = $this->surat_serv->getNoRegistrasi(4,SKC); //4 adalah panjangnya, AN adalah kode huruf
			$this->view->no_registrasi=$no_registrasi;
			
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('psantrian');
			
		}
		
		//menyimpan antrian pengantar skck
		public function simpanpsantrianAction(){
			if(isset($_POST['name'])){ 
				$id_kelurahan = $this->id_kelurahan;			
				$id_pengguna = $this->id_pengguna;		
				$nama_pengguna = $this->nama_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$waktu_antrian = date('H:i:s');
				$antrian_oleh = $nama_pengguna;
				$jam_masuk = date('H:i:s');
				$status = 1;
				
				//simpan data ke tabel andon nikah
				$data = array("id_pengguna" =>  	$id_pengguna,
								"id_kelurahan" => $id_kelurahan,
								"no_registrasi" => $no_registrasi,
								"nik" => $nik,
								"waktu_antrian" => $waktu_antrian,
								"antrian_oleh" => $antrian_oleh,
								"jam_masuk" => $jam_masuk,							
								"status" => $status
								);										 
				$hasil = $this->surat_serv->getsimpanpsantrian($data);
				
				//simpan data ke tabel no_registrasi
				$registrasi = array("no_registrasi" =>  	$no_registrasi,
									"nik" => $nik							
									);										 
				$hasil = $this->surat_serv->getSimpanNoRegistrasi($registrasi);
				
				
				//jika gagal
				if($hasil=="gagal"){
					$this->view->peringatan ="<div class='gagal'> $hasil. Maaf ada kesalahan;</div>";
					$this->psAction();
					$this->render('ps');					
				}
				//jika sukses
				if($hasil=="sukses"){
					$this->view->peringatan ="<div class='sukses'> Sukses, data berhasil ditambahkan ke antrian </div>";		
					$this->psAction();
					$this->render('ps');
				}	
				}else{
				$this->psAction();
				$this->render('ps');
			}
			
		}
		
		public function psprosesAction(){
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_ps= $this->_getParam("id_permintaan_ps");
			$no_registrasi= $this->_getParam(no_registrasi);
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;
			
			$this->view->surat = "Form Isian Surat Pengantar SKCK";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
		}
		public function simpanprosespsAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->nama_pengguna;
				
				$waktu_proses = date("H:i:s");
				$proses_oleh= $nama_pengguna;
				
				$id_kelurahan = $this->id_kelurahan;
				$id_permintaan_ps = $_POST['id_permintaan_ps'];
				$id_jenis_surat = $_POST['id_jenis_surat'];
				$id_surat = $_POST['id_surat'];
				
				$id_pejabat = $_POST['id_pejabat'];
				$nik = $_POST['nik'];
				$no_surat = $_POST['no_surat'];
				$tanggal_surat = $_POST['tanggal_surat'];
				$no_surat_pengantar = $_POST['no_surat_pengantar'];
				$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
				$keperluan = $_POST['keperluan'];
				$status = 2;
				
				$data = array("id_kelurahan" =>  	$id_kelurahan,
								"id_permintaan_ps" => $id_permintaan_ps,
								"nik" => $nik,
								"id_pejabat" => $id_pejabat,
								"id_jenis_surat" => $id_jenis_surat,
								"id_surat" => $id_surat,
								"no_surat" => $no_surat,
								"tanggal_surat" => $tanggal_surat,
								"no_surat_pengantar" => $no_surat_pengantar,
								"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
								"keperluan" => $keperluan,
								"status" => $status,
								"waktu_proses" => $waktu_proses,
								"proses_oleh" => $proses_oleh
								);
				
				$hasil = $this->surat_serv->getsimpanprosesps($data);
				var_dump($hasil);
				var_dump($data);
				//jika gagal
				if($hasil=='gagal'){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
					$this->psAction();
					$this->render('ps');			
				}
				//jika sukses
				if($hasil=='sukses'){
					$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diproses </div>";		
					$this->psAction();
					$this->render('ps');
				}
			}else{
				$this->psAction();
				$this->render('ps');
			}
			
		}
		
		public function pshapusAction(){
			$id_permintaan_ps= $this->_getParam("id_permintaan_ps");
			$hasil = $this->surat_serv->gethapusps($id_permintaan_ps);
			
			//jika gagal
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->psAction();
				$this->render('ps');			
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
				$this->psAction();
				$this->render('ps');	
			}
		}
		
		public function pseditAction(){
			$id_permintaan_ps = $this->_getParam("id_permintaan_ps");
			$this->view->surat = "Ubah Permintaan Surat Pengantar SKCK";
			$this->view->hasil = $this->surat_serv->getps($id_permintaan_ps);
		}
		
		public function simpanprosespseditAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->nama_pengguna;
			
		
			
			$id_permintaan_ps = $this->_getParam('id_permintaan_ps');
			$id_kelurahan = $this->id_kelurahan;
			$nik = $_POST['nik'];
			$no_surat = $_POST['no_surat'];
			$tanggal_surat = $_POST['tanggal_surat'];
			$no_surat_pengantar = $_POST['no_surat_pengantar'];
			$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
			$keperluan = $_POST['keperluan'];
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
						"id_permintaan_ps" => $id_permintaan_ps,
						"nik" => $nik,
						"no_surat" => $no_surat,
						"tanggal_surat" => $tanggal_surat,
						"no_surat_pengantar" => $no_surat_pengantar,
						"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
						"keperluan" => $keperluan
					);
			
			$hasil = $this->surat_serv->getsimpanprosespsedit($data);
			//jika gagal
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->psAction();
				$this->render('ps');			
			}
			//jika gagal
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
				$this->psAction();
				$this->render('ps');	
			}
		}
		
		//proses selesai
		public function psselesaiAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->nama_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_ps= $this->_getParam("id_permintaan_ps");
			$nama= $this->_getParam("nama");
			$no_registrasi= $this->_getParam("no_registrasi");
			$status= 3;	
			
			//menghitung waktu total
			$waktu_antrian = $_POST['waktu_antrian'];
			$mulai_time = $waktu_antrian;
			$waktu_selesai=date("H:i:s"); //jam dalam format DATE real itme
			
			$mulai_time=(is_string($mulai)?strtotime($mulai):$mulai);// memaksa mebentuk format time untuk string
			$selesai_time=(is_string($waktu_selesai)?strtotime($waktu_selesai):$waktu_selesai);
			
			$selisih_waktu=$selesai_time-$mulai_time; //hitung selisih dalam detik
			
			//Untuk menghitung jumlah dalam satuan jam:
			$sisa = $selisih_waktu % 86400;
			$jumlah_jam = floor($sisa/3600);
			
			//Untuk menghitung jumlah dalam satuan menit:
			$sisa = $sisa % 3600;
			$jumlah_menit = floor($sisa/60);
			
			//Untuk menghitung jumlah dalam satuan detik:
			$sisa = $sisa % 60;
			$jumlah_detik = floor($sisa/1);
			
			$waktu_total = $jumlah_jam ." jam ". $jumlah_menit  ." menit ". $jumlah_detik  ." detik " ;
			
			
			$data = array("id_permintaan_ps" => $id_permintaan_ps,
							"status" => $status,
							"waktu_selesai" => $waktu_selesai,
							"waktu_total" => $waktu_total
						);
			
			$hasil = $this->surat_serv->getSelesaiPs($data);
			//var_dump($hasil);
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'>$hasil. Maaf ada kesalahan </div>";
				$this->psAction();
				$this->render('ps');				
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> SELAMAT, proses permintaan andonnikah atas Nama $nama, No Registrasi $no_registrasi SELESAI  </div>";		
				$this->psAction();
				$this->render('ps');
			}			
		}
		
		//--------------------------------------BERSIH DIRI
		//cetak surat bd
		public function bdcetakAction(){
			$id_permintaan_bd = $this->_getParam("id_permintaan_bd");
			$this->view->hasil = $this->surat_serv->getbdcetak($id_permintaan_bd);
		}
		
		public function bdAction(){
			$this->view;
			$this->view->kelurahan = $this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			
			$dataPerPage = 10;
			// apabila $_GET['page'] sudah didefinisikan, gunakan nomor halaman tersebut,
			// sedangkan apabila belum, nomor halamannya 1.
			$noPage = $this->_getParam("page");
			if(isset($noPage))
			{
				$noPage = $this->_getParam("page");
			}
			else{ 
				$noPage = 1;
			}
			
			$offset = ($noPage - 1) * $dataPerPage;
			$this->view->jumData = $this->surat_serv->getJumlahbd($this->id_kelurahan);
			$this->view->dataPerPage = $dataPerPage;
			$this->view->noPage = $noPage;
			$this->view->offset=$offset;
			
			$this->view->surat = "Surat Keterangan Bersih Diri";
			$this->view->permintaan = $this->surat_serv->getProsesbd($this->id_kelurahan,$offset,$dataPerPage);
		}
		public function pencarianbdAction(){
			$this->view;
			$this->view->kelurahan = $this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			$id_pencarian = $_POST['id_pencarian'];
			$pencarian = $_POST['pencarian'];
			if(!$pencarian){
				$this->bdAction();
				$this->render('bd');
				}else{
				$this->view->surat = "Surat Keterangan Bersih Diri";
				$this->view->cari = $pencarian;
				$this->view->permintaan = $this->surat_serv->getPencarianbd($this->id_kelurahan,$pencarian,$id_pencarian);
			}
			
		}
		public function caripendudukbdAction() {
			$this->view;
			$this->view->surat = "Form Isian Surat Keterangan Bersih Diri";
			$this->view->judul = "Masukan NIK";
		}
		
		//antrian bd --> proses memasukan ke antrian bd, status = 1
		public function bdantrianAction(){
			$nik = $_POST['nik'];
			$this->view->surat = "Form Antrian Keterangan Bersih Diri";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			
			//mengambil noregistrasi secara automatis
			$no_registrasi = $this->surat_serv->getNoRegistrasi(4,BDR); //4 adalah panjangnya, AN adalah kode huruf
			$this->view->no_registrasi=$no_registrasi;
			
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('bdantrian');
			
		}
		
		//menyimpan antrian andon nikah
		public function simpanabdantrianAction(){
			if(isset($_POST['name'])){ 
				$id_kelurahan = $this->id_kelurahan;			
				$id_pengguna = $this->id_pengguna;		
				$nama_pengguna = $this->nama_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$waktu_antrian = date('H:i:s');
				$antrian_oleh = $nama_pengguna;
				$jam_masuk = date('H:i:s');
				$status = 1;
				
				//simpan data ke tabel andon nikah
				$data = array("id_pengguna" =>  	$id_pengguna,
								"id_kelurahan" => $id_kelurahan,
								"no_registrasi" => $no_registrasi,
								"nik" => $nik,
								"waktu_antrian" => $waktu_antrian,
								"antrian_oleh" => $antrian_oleh,
								"jam_masuk" => $jam_masuk,							
								"status" => $status
				);	
				
				$hasil = $this->surat_serv->getsimpanbdantrian($data);
				
				//simpan data ke tabel no_registrasi
				$registrasi = array("no_registrasi" =>  	$no_registrasi,
				"nik" => $nik							
				);										 
				$hasil = $this->surat_serv->getSimpanNoRegistrasi($registrasi);
				
				var_dump($hasil);
				var_dump($data);
				//jika gagal
				if($hasil=="gagal"){
					$this->view->peringatan ="<div class='gagal'> $hasil. Maaf ada kesalahan</div>";
					$this->bdAction();
					$this->render('bd');					
				}
				//jika sukses
				if($hasil=="sukses"){
					$this->view->peringatan ="<div class='sukses'> Sukses, data berhasil ditambahkan ke antrian </div>";		
					$this->bdAction();
					$this->render('bd');
				}	
				}else{
				$this->bdAction();
				$this->render('bd');
			}
			
		}
		
		public function bdprosesAction(){
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_bd= $this->_getParam("id_permintaan_bd");
			$no_registrasi= $this->_getParam(no_registrasi);
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;	
			
			$this->view->surat = "Form Isian Surat Keterangan Bersih Diri";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
		}
		public function simpanprosesbdAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->nama_pengguna;
				
				$waktu_proses = date("H:i:s");
				$proses_oleh= $nama_pengguna;
				
				$id_kelurahan = $this->id_kelurahan;
				$id_permintaan_bd = $_POST['id_permintaan_bd'];
				$id_jenis_surat = $_POST['id_jenis_surat'];
				$id_surat = $_POST['id_surat'];
				
				$id_kelurahan = $this->id_kelurahan;
				$nik = $_POST['nik'];
				$id_pejabat = $_POST['id_pejabat'];
				$alamat_ayah = $_POST['alamat_ayah'];
				$pekerjaan_ayah = $_POST['pekerjaan_ayah'];
				$agama_ayah = $_POST['agama_ayah'];
				$alamat_ibu = $alamat_ayah;
				$pekerjaan_ibu = $_POST['pekerjaan_ibu'];
				$agama_ibu = $_POST['agama_ibu'];
				$no_surat = $_POST['no_surat'];
				$tanggal_surat = $_POST['tanggal_surat'];
				$no_surat_pengantar = $_POST['no_surat_pengantar'];
				$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
				$keperluan = $_POST['keperluan'];
				$status = 2;
				
				$data = array("id_kelurahan" =>  	$id_kelurahan,
								"id_permintaan_bd" => $id_permintaan_bd,
								"nik" => $nik,
								"id_pejabat" => $id_pejabat,
								"id_jenis_surat" => $id_jenis_surat,
								"id_surat" => $id_surat,
								"alamat_ayah" => $alamat_ayah,
								"pekerjaan_ayah" => $pekerjaan_ayah,
								"agama_ayah" => $agama_ayah,
								"alamat_ibu" => $alamat_ibu,
								"pekerjaan_ibu" => $pekerjaan_ibu,
								"agama_ibu" => $agama_ibu,
								"no_surat" => $no_surat,
								"tanggal_surat" => $tanggal_surat,
								"no_surat_pengantar" => $no_surat_pengantar,
								"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
								"keperluan" => $keperluan,
								"status" => $status,
								"waktu_proses" => $waktu_proses,
								"proses_oleh" => $proses_oleh
							);
				
				$hasil = $this->surat_serv->getsimpanprosesbd($data);
				var_dump($hasil);
				var_dump($data);
				//jika gagal
				if($hasil=='gagal'){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
					$this->bdAction();
					$this->render('bd');			
				}
				//jika sukses
				if($hasil=='sukses'){
					$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diproses </div>";		
					$this->bdAction();
					$this->render('bd');
				}
			}else{
				$this->bdAction();
				$this->render('bd');
			}
			
		}
		public function bdhapusAction(){
			$id_permintaan_bd= $this->_getParam("id_permintaan_bd");
			$hasil = $this->surat_serv->gethapusbd($id_permintaan_bd);
			
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->bdAction();
				$this->render('bd');			
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
			$this->bdAction();
			$this->render('bd');	
		}
		public function bdeditAction(){
			$id_permintaan_bd = $this->_getParam("id_permintaan_bd");
			$this->view->surat = "Ubah Permintaan Surat Keterangan Bersih Diri";
			$this->view->hasil = $this->surat_serv->getbd($id_permintaan_bd);
		}
		
		public function simpanprosesbdeditAction(){
			$id_permintaan_bd = $this->_getParam('id_permintaan_bd');
			$id_kelurahan = $this->id_kelurahan;
			$nik = $_POST['nik'];
			$alamat_ayah = $_POST['alamat_ayah'];
			$pekerjaan_ayah = $_POST['pekerjaan_ayah'];
			$agama_ayah = $_POST['agama_ayah'];
			$alamat_ibu = $_POST['alamat_ibu'];
			$pekerjaan_ibu = $_POST['pekerjaan_ibu'];
			$agama_ibu = $_POST['agama_ibu'];
			$no_surat = $_POST['no_surat'];
			$tanggal_surat = $_POST['tanggal_surat'];
			$no_surat_pengantar = $_POST['no_surat_pengantar'];
			$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
			$keperluan = $_POST['keperluan'];
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
							"id_permintaan_bd" => $id_permintaan_bd,
							"nik" => $nik,
							"alamat_ayah" => $alamat_ayah,
							"pekerjaan_ayah" => $pekerjaan_ayah,
							"agama_ayah" => $agama_ayah,
							"alamat_ibu" => $alamat_ibu,
							"pekerjaan_ibu" => $pekerjaan_ibu,
							"agama_ibu" => $agama_ibu,
							"no_surat" => $no_surat,
							"tanggal_surat" => $tanggal_surat,
							"no_surat_pengantar" => $no_surat_pengantar,
							"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
							"keperluan" => $keperluan);
			
			$hasil = $this->surat_serv->getsimpanprosesbdedit($data);
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->bdAction();
				$this->render('bd');			
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
			$this->bdAction();
			$this->render('bd');
		}
		
		//proses selesai
		public function bdselesaiAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->nama_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_bd= $this->_getParam("id_permintaan_bd");
			$nama= $this->_getParam("nama");
			$no_registrasi= $this->_getParam("no_registrasi");
			$status= 3;	
			
			//menghitung waktu total
			$waktu_antrian = $_POST['waktu_antrian'];
			$mulai_time = $waktu_antrian;
			$waktu_selesai=date("H:i:s"); //jam dalam format DATE real itme
			
			$mulai_time=(is_string($mulai)?strtotime($mulai):$mulai);// memaksa mebentuk format time untuk string
			$selesai_time=(is_string($waktu_selesai)?strtotime($waktu_selesai):$waktu_selesai);
			
			$selisih_waktu=$selesai_time-$mulai_time; //hitung selisih dalam detik
			
			//Untuk menghitung jumlah dalam satuan jam:
			$sisa = $selisih_waktu % 86400;
			$jumlah_jam = floor($sisa/3600);
			
			//Untuk menghitung jumlah dalam satuan menit:
			$sisa = $sisa % 3600;
			$jumlah_menit = floor($sisa/60);
			
			//Untuk menghitung jumlah dalam satuan detik:
			$sisa = $sisa % 60;
			$jumlah_detik = floor($sisa/1);
			
			$waktu_total = $jumlah_jam ." jam ". $jumlah_menit  ." menit ". $jumlah_detik  ." detik " ;
			
			
			$data = array("id_permintaan_bd" => $id_permintaan_bd,
			"status" => $status,
			"waktu_selesai" => $waktu_selesai,
			"waktu_total" => $waktu_total);
			
			$hasil = $this->surat_serv->getSelesaiBd($data);
			//var_dump($hasil);
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->bdAction();
				$this->render('bd');				
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> SELAMAT, proses permintaan bersih diri atas Nama $nama,No Registrasi $no_registrasi SELESAI  </div>";		
				$this->bdAction();
				$this->render('bd');
			}			
		}
		
		
		//--------------------------------------domisili yayasan
		//cetak surat domisiliyayasan
		public function domisiliyayasancetakAction(){
			$id_permintaan_domisiliyayasan = $this->_getParam("id_permintaan_domisiliyayasan");
			$this->view->hasil = $this->surat_serv->getdomisiliyayasancetak($id_permintaan_domisiliyayasan);
		}
		
		public function domisiliyayasanAction(){
			$this->view;
			$this->id_kelurahan;
			$this->view->kelurahan = $this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			
			$dataPerPage = 10;
			// apabila $_GET['page'] sudah didefinisikan, gunakan nomor halaman tersebut,
			// sedangkan apabila belum, nomor halamannya 1.
			$noPage = $this->_getParam("page");
			if(isset($noPage))
			{
				$noPage = $this->_getParam("page");
			}
			else{ 
				$noPage = 1;
			}
			
			$offset = ($noPage - 1) * $dataPerPage;
			$this->view->jumData = $this->surat_serv->getJumlahdomisiliyayasan($this->id_kelurahan);
			$this->view->dataPerPage = $dataPerPage;
			$this->view->noPage = $noPage;
			$this->view->offset=$offset;
			
			$this->view->surat = "Surat Domisili Yayasan";
			$this->view->permintaan = $this->surat_serv->getProsesDomisiliyayasan($this->id_kelurahan,$offset,$dataPerPage);
		}
		
		public function pencariandomisiliyayasanAction(){
			$this->view;
			$this->view->kelurahan = $this->id_kelurahan;
			$this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			$id_pencarian = $_POST['id_pencarian'];
			$pencarian = $_POST['pencarian'];
			if(!$pencarian){
				$this->domisiliyayasanAction();
				$this->render('domisiliyayasan');
				}else{
				$this->view->surat = "Surat Keterangan Domisili Yayasan";
				$this->view->cari = $pencarian;
				$this->view->permintaan = $this->surat_serv->getPencarianDomisiliYayasan($this->id_kelurahan,$pencarian,$id_pencarian);
			}
			
		}
		
		public function caripendudukdomisiliyayasanAction() {
			$this->view;
			$this->view->surat = "Form Isian Surat Domisili Yayasan";
			$this->view->judul = "Masukan NIK";
		}
		
		//antrian domisiliyayasan --> proses memasukan ke antrian domisiliyayasan, status = 1
		public function domisiliyayasanantrianAction(){
			$nik = $_POST['nik'];
			$this->view->surat = "Form Antrian Keterangan domisili yayasan";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			
			//mengambil noregistrasi secara automatis
			$no_registrasi = $this->surat_serv->getNoRegistrasi(4,DMY); //4 adalah panjangnya, AN adalah kode huruf
			$this->view->no_registrasi=$no_registrasi;
			
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('domisiliyayasanantrian');
			
		}
		
		//menyimpan antrian andon nikah
		public function simpandomisiliyayasanantrianAction(){
			if(isset($_POST['name'])){ 
				$id_kelurahan = $this->id_kelurahan;			
				$id_pengguna = $this->id_pengguna;		
				$nama_pengguna = $this->nama_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$waktu_antrian = date('H:i:s');
				$antrian_oleh = $nama_pengguna;
				$jam_masuk = date('H:i:s');
				$status = 1;
				
				//simpan data ke tabel andon nikah
				$data = array("id_pengguna" =>  	$id_pengguna,
								"id_kelurahan" => $id_kelurahan,
								"no_registrasi" => $no_registrasi,
								"nik" => $nik,
								"waktu_antrian" => $waktu_antrian,
								"antrian_oleh" => $antrian_oleh,
								"jam_masuk" => $jam_masuk,							
								"status" => $status
								);										 
				$hasil = $this->surat_serv->getsimpandomisiliyayasanantrian($data);
				
				//simpan data ke tabel no_registrasi
				$registrasi = array("no_registrasi" =>  	$no_registrasi,
									"nik" => $nik							
									);										 
				$hasil = $this->surat_serv->getSimpanNoRegistrasi($registrasi);
				
				
				//jika gagal
				if($hasil=="gagal"){
					$this->view->peringatan ="<div class='gagal'>$hasil. Maaf ada kesalahan ;</div>";
					$this->domisiliyayasanAction();
					$this->render('domisiliyayasan');					
				}
				//jika sukses
				if($hasil=="sukses"){
					$this->view->peringatan ="<div class='sukses'> Sukses, data berhasil ditambahkan ke antrian </div>";		
					$this->domisiliyayasanAction();
					$this->render('domisiliyayasan');
				}	
				}else{
				$this->domisiliyayasanAction();
				$this->render('domisiliyayasan');
			}
			
		}
		
		public function domisiliyayasanprosesAction(){
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_domisili_yayasan= $this->_getParam("id_permintaan_domisili_yayasan");
			$no_registrasi= $this->_getParam(no_registrasi);
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;
			
			$this->view->surat = "Form Isian Surat Domisili Yayasan";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
		}
		
		public function simpanprosesdomisiliyayasanAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->nama_pengguna;
				
				$waktu_proses = date("H:i:s");
				$proses_oleh= $nama_pengguna;
				
				$id_kelurahan = $this->id_kelurahan;
				$id_permintaan_domisili_yayasan = $_POST['id_permintaan_domisili_yayasan'];
				$id_jenis_surat = $_POST['id_jenis_surat'];
				$id_surat = $_POST['id_surat'];
				
				$nik = $_POST['nik'];
				$id_pejabat = $_POST['id_pejabat'];
				$no_surat = $_POST['no_surat'];
				$tanggal_surat = $_POST['tanggal_surat'];
				$no_surat_pengantar = $_POST['no_surat_pengantar'];
				$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
				$keperluan = $_POST['keperluan'];
				$masa_berlaku = $_POST['masa_berlaku'];
				$nama_yayasan = $_POST['nama_yayasan'];
				$bergerak_bidang = $_POST['bergerak_bidang'];
				$jumlah_anggota = $_POST['jumlah_anggota'];
				$jam_kerja = $_POST['jam_kerja'];
				$alamat_usaha = $_POST['alamat_usaha'];
				$status = 2;
				
				$data = array("id_kelurahan" =>  $id_kelurahan,
								"id_permintaan_domisili_yayasan" => $id_permintaan_domisili_yayasan,
								"nik" => $nik,
								"id_pejabat" => $id_pejabat,
								"id_jenis_surat" => $id_jenis_surat,
								"id_surat" => $id_surat,
								"no_surat" => $no_surat,
								"tanggal_surat" => $tanggal_surat,
								"no_surat_pengantar" => $no_surat_pengantar,
								"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
								"keperluan" => $keperluan,
								"masa_berlaku" => $masa_berlaku,
								"nama_yayasan" => $nama_yayasan,
								"bergerak_bidang" => $bergerak_bidang,
								"jumlah_anggota" => $jumlah_anggota,
								"jam_kerja" => $jam_kerja,
								"alamat_usaha" => $alamat_usaha,
								"status" => $status,
								"waktu_proses" => $waktu_proses,
								"proses_oleh" => $proses_oleh);
				
				$hasil = $this->surat_serv->getsimpanprosesdomisiliyayasan($data);
				var_dump($hasil);
				var_dump($data);
				//jika gagal
				if($hasil=='gagal'){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
					$this->domisiliyayasanAction();
					$this->render('domisiliyayasan');		
				}
				//jika sukses
				if($hasil=='sukses'){
						$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diproses </div>";		
						$this->domisiliyayasanAction();
						$this->render('domisiliyayasan');
				}
				}else{
				$this->domisiliyayasanAction();
				$this->render('domisiliyayasan');
			}
			
		}
		public function domisiliyayasanhapusAction(){
			$id_permintaan_domisili_yayasan= $this->_getParam("id_permintaan_domisili_yayasan");
			$hasil = $this->surat_serv->gethapusdomisiliyayasan($id_permintaan_domisili_yayasan);
			
			//jika gagal
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->domisiliyayasanAction();
				$this->render('domisiliyayasan');		
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
				$this->domisiliyayasanAction();
				$this->render('domisiliyayasan');
			}
		}
		
		public function domisiliyayasaneditAction(){
			$id_permintaan_domisili_yayasan = $this->_getParam("id_permintaan_domisili_yayasan");
			$this->view->hasil = $this->surat_serv->getdomisiliyayasan($id_permintaan_domisili_yayasan);
		}
		
		public function simpanprosesdomisiliyayasaneditAction(){
			$id_permintaan_domisili_yayasan = $this->_getParam('id_permintaan_domisili_yayasan');
			$id_kelurahan = $this->id_kelurahan;
			$nik = $_POST['nik'];
			$no_surat = $_POST['no_surat'];
			$tanggal_surat = $_POST['tanggal_surat'];
			$no_surat_pengantar = $_POST['no_surat_pengantar'];
			$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
			$nama_yayasan = $_POST['nama_yayasan'];
			$keperluan = $_POST['keperluan'];
			$masa_berlaku = $_POST['masa_berlaku'];
			$bergerak_bidang = $_POST['bergerak_bidang'];
			$jumlah_anggota = $_POST['jumlah_anggota'];
			$jam_kerja = $_POST['jam_kerja'];
			$alamat_usaha = $_POST['alamat_usaha'];
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
							"id_permintaan_domisili_yayasan" => $id_permintaan_domisili_yayasan,
							"nik" => $nik,
							"no_surat" => $no_surat,
							"tanggal_surat" => $tanggal_surat,
							"no_surat_pengantar" => $no_surat_pengantar,
							"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
							"keperluan" => $keperluan,
							"masa_berlaku" => $masa_berlaku,
							"nama_yayasan" => $nama_yayasan,
							"bergerak_bidang" => $bergerak_bidang,
							"jumlah_anggota" => $jumlah_anggota,
							"jam_kerja" => $jam_kerja,
							"alamat_usaha" => $alamat_usaha);
			
			$hasil = $this->surat_serv->getsimpanprosesdomisiliyayasanedit($data);
			//jika gagal
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->domisiliyayasanAction();
				$this->render('domisiliyayasan');		
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
				$this->domisiliyayasanAction();
				$this->render('domisiliyayasan');
			}
		}
		
		//proses selesai
		public function domisiliyayasanselesaiAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->nama_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_domisili_yayasan= $this->_getParam("id_permintaan_domisili_yayasan");
			$nama= $this->_getParam("nama");
			$no_registrasi= $this->_getParam("no_registrasi");
			$status= 3;	
			
			//menghitung waktu total
			$waktu_antrian = $_POST['waktu_antrian'];
			$mulai_time = $waktu_antrian;
			$waktu_selesai=date("H:i:s"); //jam dalam format DATE real itme
			
			$mulai_time=(is_string($mulai)?strtotime($mulai):$mulai);// memaksa mebentuk format time untuk string
			$selesai_time=(is_string($waktu_selesai)?strtotime($waktu_selesai):$waktu_selesai);
			
			$selisih_waktu=$selesai_time-$mulai_time; //hitung selisih dalam detik
			
			//Untuk menghitung jumlah dalam satuan jam:
			$sisa = $selisih_waktu % 86400;
			$jumlah_jam = floor($sisa/3600);
			
			//Untuk menghitung jumlah dalam satuan menit:
			$sisa = $sisa % 3600;
			$jumlah_menit = floor($sisa/60);
			
			//Untuk menghitung jumlah dalam satuan detik:
			$sisa = $sisa % 60;
			$jumlah_detik = floor($sisa/1);
			
			$waktu_total = $jumlah_jam ." jam ". $jumlah_menit  ." menit ". $jumlah_detik  ." detik " ;
			
			
			$data = array("id_permintaan_domisili_yayasan" => $id_permintaan_domisili_yayasan,
							"status" => $status,
							"waktu_selesai" => $waktu_selesai,
							"waktu_total" => $waktu_total
						);
			
			$hasil = $this->surat_serv->getSelesaiDomisiliyayasan($data);
			//var_dump($hasil);
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'>$hasil. Maaf ada kesalahan </div>";
				$this->domisiliyayasanAction();
				$this->render('domisiliyayasan');				
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> SELAMAT, proses permintaan domisili yayasan atas Nama $nama, No Registrasi $no_registrasi SELESAI  </div>";		
				$this->domisiliyayasanAction();
				$this->render('domisiliyayasan');
			}			
		}
		
		//--------------------------------------domisili parpol
		//cetak surat domisiliparpol
		public function domisiliparpolcetakAction(){
			$id_permintaan_domisiliparpol = $this->_getParam("id_permintaan_domisiliparpol");
			$this->view->hasil = $this->surat_serv->getdomisiliparpolcetak($id_permintaan_domisiliparpol);
		}
		
		public function domisiliparpolAction(){
			$this->view;
			$this->id_kelurahan;
			$this->view->kelurahan = $this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			
			$dataPerPage = 10;
			// apabila $_GET['page'] sudah didefinisikan, gunakan nomor halaman tersebut,
			// sedangkan apabila belum, nomor halamannya 1.
			$noPage = $this->_getParam("page");
			if(isset($noPage))
			{
				$noPage = $this->_getParam("page");
			}
			else{ 
				$noPage = 1;
			}
			
			$offset = ($noPage - 1) * $dataPerPage;
			$this->view->jumData = $this->surat_serv->getJumlahdomisiliparpol($this->id_kelurahan);
			$this->view->dataPerPage = $dataPerPage;
			$this->view->noPage = $noPage;
			$this->view->offset=$offset;
			
			$this->view->surat = "Surat Domisili Parpol";
			$this->view->permintaan = $this->surat_serv->getProsesDomisiliParpol($this->id_kelurahan,$offset , $dataPerPage);
		}
		
		public function pencariandomisiliparpolAction(){
			$this->view;
			$this->view->kelurahan = $this->id_kelurahan;
			$this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			$id_pencarian = $_POST['id_pencarian'];
			$pencarian = $_POST['pencarian'];
			if(!$pencarian){
				$this->domisiliparpolAction();
				$this->render('domisiliparpol');
				}else{
				$this->view->surat = "Surat Keterangan Domisili Parpol";
				$this->view->cari = $pencarian;
				$this->view->permintaan = $this->surat_serv->getPencarianDomisiliParpol($this->id_kelurahan,$pencarian,$id_pencarian);
			}
			
		}
		
		public function caripendudukdomisiliparpolAction() {
			$this->view;
			$this->view->surat = "Form Isian Surat Domisili Parpol";
			$this->view->judul = "Masukan NIK";
		}
		
		//antrian domisiliparpol --> proses memasukan ke antrian domisiliparpol, status = 1
		public function domisiliparpolantrianAction(){
			$nik = $_POST['nik'];
			$this->view->surat = "Form Antrian Keterangan domisili parpol";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			
			//mengambil noregistrasi secara automatis
			$no_registrasi = $this->surat_serv->getNoRegistrasi(4,DMP); //4 adalah panjangnya, AN adalah kode huruf
			$this->view->no_registrasi=$no_registrasi;
			
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('domisiliparpolantrian');
			
		}
		
		//menyimpan antrian domisiliparpol
		public function simpandomisiliparpolantrianAction(){
			if(isset($_POST['name'])){ 
				$id_kelurahan = $this->id_kelurahan;			
				$id_pengguna = $this->id_pengguna;		
				$nama_pengguna = $this->nama_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$waktu_antrian = date('H:i:s');
				$antrian_oleh = $nama_pengguna;
				$jam_masuk = date('H:i:s');
				$status = 1;
				
				//simpan data ke tabel andon nikah
				$data = array("id_pengguna" =>  	$id_pengguna,
								"id_kelurahan" => $id_kelurahan,
								"no_registrasi" => $no_registrasi,
								"nik" => $nik,
								"waktu_antrian" => $waktu_antrian,
								"antrian_oleh" => $antrian_oleh,
								"jam_masuk" => $jam_masuk,							
								"status" => $status
								);										 
				$hasil = $this->surat_serv->getsimpandomisiliparpolantrian($data);
				
				//simpan data ke tabel no_registrasi
				$registrasi = array("no_registrasi" =>  	$no_registrasi,
									"nik" => $nik							
									);										 
				$hasil = $this->surat_serv->getSimpanNoRegistrasi($registrasi);
				
				
				//jika gagal
				if($hasil=="gagal"){
					$this->view->peringatan ="<div class='gagal'>$hasil. Maaf ada kesalahan</div>";
					$this->domisiliparpolAction();
					$this->render('domisiliparpol');					
				}
				//jika sukses
				if($hasil=="sukses"){
					$this->view->peringatan ="<div class='sukses'> Sukses, data berhasil ditambahkan ke antrian </div>";		
					$this->domisiliparpolAction();
					$this->render('domisiliparpol');
				}	
				}else{
				$this->domisiliparpolAction();
				$this->render('domisiliparpol');
			}
			
		}
		
		
		public function domisiliparpolprosesAction(){
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_domisili_parpol= $this->_getParam("id_permintaan_domisili_parpol");
			$no_registrasi= $this->_getParam(no_registrasi);
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;
			
			$this->view->surat = "Form Isian Surat Domisili Parpol";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
		}
		
		public function simpanprosesdomisiliparpolAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->nama_pengguna;
				
				$waktu_proses = date("H:i:s");
				$proses_oleh= $nama_pengguna;
				
				$id_kelurahan = $this->id_kelurahan;
				$id_permintaan_domisili_parpol = $_POST['id_permintaan_domisili_parpol'];
				$id_jenis_surat = $_POST['id_jenis_surat'];
				$id_surat = $_POST['id_surat'];
				
				$nik = $_POST['nik'];
				$id_pejabat = $_POST['id_pejabat'];
				$no_surat = $_POST['no_surat'];
				$tanggal_surat = $_POST['tanggal_surat'];
				$no_surat_pengantar = $_POST['no_surat_pengantar'];
				$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
				$nama_parpol = $_POST['nama_parpol'];
				$keperluan = $_POST['keperluan'];
				$masa_berlaku = $_POST['masa_berlaku'];
				$bergerak_bidang = $_POST['bergerak_bidang'];
				$jumlah_anggota = $_POST['jumlah_anggota'];
				$jam_kerja = $_POST['jam_kerja'];
				$alamat_parpol = $_POST['alamat_parpol'];
				$status = 2;
				
				$data = array("id_kelurahan" =>  	$id_kelurahan,
								"id_permintaan_domisili_parpol" => $id_permintaan_domisili_parpol,
								"nik" => $nik,
								"id_pejabat" => $id_pejabat,
								"id_jenis_surat" => $id_jenis_surat,
								"id_surat" => $id_surat,
								"no_surat" => $no_surat,
								"tanggal_surat" => $tanggal_surat,
								"no_surat_pengantar" => $no_surat_pengantar,
								"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
								"keperluan" => $keperluan,
								"masa_berlaku" => $masa_berlaku,
								"nama_parpol" => $nama_parpol,
								"bergerak_bidang" => $bergerak_bidang,
								"jumlah_anggota" => $jumlah_anggota,
								"jam_kerja" => $jam_kerja,
								"alamat_parpol" => $alamat_parpol,
								"status" => $status,
								"waktu_proses" => $waktu_proses,
								"proses_oleh" => $proses_oleh);
				
				$hasil = $this->surat_serv->getsimpanprosesdomisiliparpol($data);
				var_dump($hasil);
				var_dump($data);
				//jika gagal
				if($hasil=='gagal'){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
					$this->domisiliparpolAction();
					$this->render('domisiliparpol');	
				}
				//jika sukses
				//jika sukses
				if($hasil=='sukses'){
					$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diproses </div>";		
					$this->domisiliparpolAction();
					$this->render('domisiliparpol');
				}
			}else{
				$this->domisiliparpolAction();
				$this->render('domisiliparpol');
			}
			
		}
		public function domisiliparpolhapusAction(){
			$id_permintaan_domisili_parpol= $this->_getParam("id_permintaan_domisili_parpol");
			$hasil = $this->surat_serv->gethapusdomisiliparpol($id_permintaan_domisili_parpol);
			
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->domisiliparpolAction();
				$this->render('domisiliparpol');	
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
			$this->domisiliparpolAction();
			$this->render('domisiliparpol');	
		}
		public function domisiliparpoleditAction(){
			$id_permintaan_domisili_parpol = $this->_getParam("id_permintaan_domisili_parpol");
			$this->view->hasil = $this->surat_serv->getdomisiliparpol($id_permintaan_domisili_parpol);
		}
		
		public function simpanprosesdomisiliparpoleditAction(){
			
			$id_permintaan_domisili_parpol = $this->_getParam('id_permintaan_domisili_parpol');
			$id_kelurahan = $this->id_kelurahan;
			$nik = $_POST['nik'];
			$no_surat = $_POST['no_surat'];
			$tanggal_surat = $_POST['tanggal_surat'];
			$no_surat_pengantar = $_POST['no_surat_pengantar'];
			$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
			$nama_parpol = $_POST['nama_parpol'];
			$keperluan = $_POST['keperluan'];
			$masa_berlaku = $_POST['masa_berlaku'];
			$bergerak_bidang = $_POST['bergerak_bidang'];
			$jumlah_anggota = $_POST['jumlah_anggota'];
			$jam_kerja = $_POST['jam_kerja'];
			$alamat_parpol = $_POST['alamat_parpol'];
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
					"id_permintaan_domisili_parpol" => $id_permintaan_domisili_parpol,
					"nik" => $nik,
					"no_surat" => $no_surat,
					"tanggal_surat" => $tanggal_surat,
					"no_surat_pengantar" => $no_surat_pengantar,
					"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
					"keperluan" => $keperluan,
					"masa_berlaku" => $masa_berlaku,
					"nama_parpol" => $nama_parpol,
					"bergerak_bidang" => $bergerak_bidang,
					"jumlah_anggota" => $jumlah_anggota,
					"jam_kerja" => $jam_kerja,
					"alamat_parpol" => $alamat_parpol);
			
			$hasil = $this->surat_serv->getsimpanprosesdomisiliparpoledit($data);
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->domisiliparpolAction();
				$this->render('domisiliparpol');	
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
			$this->domisiliparpolAction();
			$this->render('domisiliparpol');		
		}
		
		//proses selesai
		public function domisiliparpolselesaiAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->nama_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_domisili_parpol= $this->_getParam("id_permintaan_domisili_parpol");
			$nama= $this->_getParam("nama");
			$no_registrasi= $this->_getParam("no_registrasi");
			$status= 3;	
			
			//menghitung waktu total
			$waktu_antrian = $_POST['waktu_antrian'];
			$mulai_time = $waktu_antrian;
			$waktu_selesai=date("H:i:s"); //jam dalam format DATE real itme
			
			$mulai_time=(is_string($mulai)?strtotime($mulai):$mulai);// memaksa mebentuk format time untuk string
			$selesai_time=(is_string($waktu_selesai)?strtotime($waktu_selesai):$waktu_selesai);
			
			$selisih_waktu=$selesai_time-$mulai_time; //hitung selisih dalam detik
			
			//Untuk menghitung jumlah dalam satuan jam:
			$sisa = $selisih_waktu % 86400;
			$jumlah_jam = floor($sisa/3600);
			
			//Untuk menghitung jumlah dalam satuan menit:
			$sisa = $sisa % 3600;
			$jumlah_menit = floor($sisa/60);
			
			//Untuk menghitung jumlah dalam satuan detik:
			$sisa = $sisa % 60;
			$jumlah_detik = floor($sisa/1);
			
			$waktu_total = $jumlah_jam ." jam ". $jumlah_menit  ." menit ". $jumlah_detik  ." detik " ;
			
			
			$data = array("id_permintaan_domisili_parpol" => $id_permintaan_domisili_parpol,
							"status" => $status,
							"waktu_selesai" => $waktu_selesai,
							"waktu_total" => $waktu_total
						);
			
			$hasil = $this->surat_serv->getSelesaiDomisiliparpol($data);
			//var_dump($hasil);
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'>$hasil. Maaf ada kesalahan </div>";
				$this->domisiliparpolAction();
				$this->render('domisiliparpol');				
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> SELAMAT, proses permintaan domisili parpol atas Nama $nama, No Registrasi $no_registrasi SELESAI  </div>";		
				$this->domisiliparpolAction();
				$this->render('domisiliparpol');
			}			
		}
		
		//--------------------------------------domisili perusahaan
		//cetak surat domisiliperusahaan
		public function domisiliperusahaancetakAction(){
			$id_permintaan_domisili_perusahaan = $this->_getParam("id_permintaan_domisili_perusahaan");
			$this->view->hasil = $this->surat_serv->getdomisiliperusahaancetak($id_permintaan_domisili_perusahaan);
		}
		
		public function domisiliperusahaanAction(){
			$this->view;
			$this->id_kelurahan;
			$this->view->kelurahan = $this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			
			$dataPerPage = 10;
			// apabila $_GET['page'] sudah didefinisikan, gunakan nomor halaman tersebut,
			// sedangkan apabila belum, nomor halamannya 1.
			$noPage = $this->_getParam("page");
			if(isset($noPage))
			{
				$noPage = $this->_getParam("page");
			}
			else{ 
				$noPage = 1;
			}
			
			$offset = ($noPage - 1) * $dataPerPage;
			$this->view->jumData = $this->surat_serv->getJumlahdomisiliperusahaan($this->id_kelurahan);
			$this->view->dataPerPage = $dataPerPage;
			$this->view->noPage = $noPage;
			$this->view->offset=$offset;
			
			$this->view->surat = "Surat Domisili Perusahaan";
			$this->view->permintaan = $this->surat_serv->getProsesDomisiliperusahaan($this->id_kelurahan,$offset , $dataPerPage);
		}
		
		public function pencariandomisiliperusahaanAction(){
			$this->view;
			$this->view->kelurahan = $this->id_kelurahan;
			$this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			$id_pencarian = $_POST['id_pencarian'];
			$pencarian = $_POST['pencarian'];
			if(!$pencarian){
				$this->domisiliperusahaanAction();
				$this->render('domisiliperusahaan');
				}else{
				$this->view->surat = "Surat Keterangan Domisili Perusahaan";
				$this->view->cari = $pencarian;
				$this->view->permintaan = $this->surat_serv->getPencarianDomisiliPerusahaan($this->id_kelurahan,$pencarian,$id_pencarian);
			}
		}
		
		public function caripendudukdomisiliperusahaanAction() {
			$this->view;
			$this->view->surat = "Form Isian Surat Domisili Perusahaan";
			$this->view->judul = "Masukan NIK";
		}
		
		//antrian domisiliperusahaan --> proses memasukan ke antrian domisiliperusahaan, status = 1
		public function domisiliperusahaanantrianAction(){
			$nik = $_POST['nik'];
			$this->view->surat = "Form Antrian Keterangan domisili perusahaan";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			
			//mengambil noregistrasi secara automatis
			$no_registrasi = $this->surat_serv->getNoRegistrasi(4,DMP); //4 adalah panjangnya, AN adalah kode huruf
			$this->view->no_registrasi=$no_registrasi;
			
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('domisiliperusahaanantrian');
			
		}
		
		//menyimpan antrian andon nikah
		public function simpandomisiliperusahaanantrianAction(){
			if(isset($_POST['name'])){ 
				$id_kelurahan = $this->id_kelurahan;			
				$id_pengguna = $this->id_pengguna;		
				$nama_pengguna = $this->nama_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$waktu_antrian = date('H:i:s');
				$antrian_oleh = $nama_pengguna;
				$jam_masuk = date('H:i:s');
				$status = 1;
				
				//simpan data ke tabel andon nikah
				$data = array("id_pengguna" =>  	$id_pengguna,
								"id_kelurahan" => $id_kelurahan,
								"no_registrasi" => $no_registrasi,
								"nik" => $nik,
								"waktu_antrian" => $waktu_antrian,
								"antrian_oleh" => $antrian_oleh,
								"jam_masuk" => $jam_masuk,							
								"status" => $status
								);										 
				$hasil = $this->surat_serv->getsimpandomisiliperusahaanantrian($data);
				
				//simpan data ke tabel no_registrasi
				$registrasi = array("no_registrasi" =>  	$no_registrasi,
									"nik" => $nik							
									);										 
				$hasil = $this->surat_serv->getSimpanNoRegistrasi($registrasi);
				
				var_dump($hasil);
				var_dump($data);
				//jika gagal
				if($hasil=="gagal"){
					$this->view->peringatan ="<div class='gagal'>$hasil. Maaf ada kesalahan;</div>";
					$this->domisiliperusahaanAction();
					$this->render('domisiliperusahaan');					
				}
				//jika sukses
				if($hasil=="sukses"){
					$this->view->peringatan ="<div class='sukses'> Sukses, data berhasil ditambahkan ke antrian </div>";		
					$this->domisiliperusahaanAction();
					$this->render('domisiliperusahaan');
				}	
				}else{
				$this->domisiliperusahaanAction();
				$this->render('domisiliperusahaan');
			}
			
		}
		
		
		public function domisiliperusahaanprosesAction(){
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_domisiliperusahaan= $this->_getParam("id_permintaan_domisiliperusahaan");
			$no_registrasi= $this->_getParam(no_registrasi);
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;
			
			$this->view->surat = "Form Isian Surat Domisili Perusahaan";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
		}
		
		public function simpanprosesdomisiliperusahaanAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->nama_pengguna;
				
				$tgl_dibuat = date("Y-m-d H:i:s");
				$dibuat_oleh= $nama_pengguna;
				
				$waktu_proses = date("H:i:s");
				$proses_oleh= $nama_pengguna;
				
				$id_kelurahan = $this->id_kelurahan;
				$id_permintaan_domisili_perusahaan = $_POST['id_permintaan_domisili_perusahaan'];
				$id_jenis_surat = $_POST['id_jenis_surat'];
				$id_surat = $_POST['id_surat'];
				
				$nik = $_POST['nik'];
				$id_pejabat = $_POST['id_pejabat'];
				$no_surat = $_POST['no_surat'];
				$tanggal_surat = $_POST['tanggal_surat'];
				$no_surat_pengantar = $_POST['no_surat_pengantar'];
				$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
				$jumlah_pegawai = $_POST['jumlah_pegawai'];
				$nama_perusahaan = $_POST['nama_perusahaan'];
				$jenis_perusahaan = $_POST['jenis_perusahaan'];
				$bergerak_bidang = $_POST['bergerak_bidang'];
				$notaris = $_POST['notaris'];
				$keperluan = $_POST['keperluan'];
				$masa_berlaku = $_POST['masa_berlaku'];
				$no_notaris = $_POST['no_notaris'];
				$tanggal_notaris = $_POST['tanggal_notaris'];
				$jam_kerja = $_POST['jam_kerja'];
				$alamat_usaha = $_POST['alamat_usaha'];
				$status = 2;
				
				$data = array("id_kelurahan" =>  	$id_kelurahan,
								"nik" => $nik,
								"id_permintaan_domisili_perusahaan" => $id_permintaan_domisili_perusahaan,
								"id_pejabat" => $id_pejabat,
								"id_jenis_surat" => $id_jenis_surat,
								"id_surat" => $id_surat,
								"no_surat" => $no_surat,
								"tanggal_surat" => $tanggal_surat,
								"no_surat_pengantar" => $no_surat_pengantar,
								"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
								"keperluan" => $keperluan,
								"masa_berlaku" => $masa_berlaku,
								"nama_perusahaan" => $nama_perusahaan,
								"bergerak_bidang" => $bergerak_bidang,
								"notaris" => $notaris,
								"no_notaris" => $no_notaris,
								"tanggal_notaris" => $tanggal_notaris,
								"jam_kerja" => $jam_kerja,
								"alamat_usaha" => $alamat_usaha,
								"jenis_perusahaan" => $jenis_perusahaan,
								"jumlah_pegawai" => $jumlah_pegawai,
								"status" => $status,
								"waktu_proses" => $waktu_proses,
								"proses_oleh" => $proses_oleh);
				
				$hasil = $this->surat_serv->getsimpanprosesdomisiliperusahaan($data);
				var_dump($hasil);
				var_dump($data);
				//jika gagal
				if($hasil=='gagal'){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
					$this->domisiliperusahaanAction();
					$this->render('domisiliperusahaan');
				}
				//jika sukses
				if($hasil=='sukses'){
					$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diproses </div>";		
					$this->domisiliperusahaanAction();
					$this->render('domisiliperusahaan');
				}
			}else{
				$this->domisiliperusahaanAction();
				$this->render('domisiliperusahaan');
			}
			
		}
		public function domisiliperusahaanhapusAction(){
			$id_permintaan_domisili_perusahaan= $this->_getParam("id_permintaan_domisili_perusahaan");
			$hasil = $this->surat_serv->gethapusdomisiliperusahaan($id_permintaan_domisili_perusahaan);
			
			//jika gagal
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->domisiliperusahaanAction();
				$this->render('domisiliperusahaan');
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
				$this->domisiliperusahaanAction();
				$this->render('domisiliperusahaan');	
			}
		}
		public function domisiliperusahaaneditAction(){
			$id_permintaan_domisili_perusahaan = $this->_getParam("id_permintaan_domisili_perusahaan");
			$this->view->hasil = $this->surat_serv->getdomisiliperusahaan($id_permintaan_domisili_perusahaan);
		}
		
		public function simpanprosesdomisiliperusahaaneditAction(){
			$id_permintaan_domisili_perusahaan = $this->_getParam('id_permintaan_domisili_perusahaan');
			$id_kelurahan = $this->id_kelurahan;
			$nik = $_POST['nik'];
			$keperluan = $_POST['keperluan'];
			$masa_berlaku = $_POST['masa_berlaku'];
			$no_surat = $_POST['no_surat'];
			$tanggal_surat = $_POST['tanggal_surat'];
			$no_surat_pengantar = $_POST['no_surat_pengantar'];
			$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
			$nama_perusahaan = $_POST['nama_perusahaan'];
			$jenis_perusahaan = $_POST['jenis_perusahaan'];
			$jumlah_pegawai = $_POST['jumlah_pegawai'];
			$bergerak_bidang = $_POST['bergerak_bidang'];
			$notaris = $_POST['notaris'];
			$no_notaris = $_POST['no_notaris'];
			$tanggal_notaris = $_POST['tanggal_notaris'];
			$jam_kerja = $_POST['jam_kerja'];
			$alamat_usaha = $_POST['alamat_usaha'];
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
							"id_permintaan_domisili_perusahaan" => $id_permintaan_domisili_perusahaan,
							"nik" => $nik,
							"no_surat" => $no_surat,
							"tanggal_surat" => $tanggal_surat,
							"no_surat_pengantar" => $no_surat_pengantar,
							"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
							"nama_perusahaan" => $nama_perusahaan,
							"bergerak_bidang" => $bergerak_bidang,
							"notaris" => $notaris,
							"no_notaris" => $no_notaris,
							"tanggal_notaris" => $tanggal_notaris,
							"jenis_perusahaan" => $jenis_perusahaan,
							"jumlah_pegawai" => $jumlah_pegawai,
							"keperluan" => $keperluan,
							"masa_berlaku" => $masa_berlaku,
							"jam_kerja" => $jam_kerja,
							"alamat_usaha" => $alamat_usaha);
			
			$hasil = $this->surat_serv->getsimpanprosesdomisiliperusahaanedit($data);
			//jika gagal
				if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->domisiliperusahaanAction();
				$this->render('domisiliperusahaan');
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
				$this->domisiliperusahaanAction();
				$this->render('domisiliperusahaan');	
			}
		}
		
		//proses selesai
		public function domisiliperusahaanselesaiAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->nama_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_domisili_perusahaan= $this->_getParam("id_permintaan_domisili_perusahaan");
			$nama= $this->_getParam("nama");
			$no_registrasi= $this->_getParam("no_registrasi");
			$status= 3;	
			
			//menghitung waktu total
			$waktu_antrian = $_POST['waktu_antrian'];
			$mulai_time = $waktu_antrian;
			$waktu_selesai=date("H:i:s"); //jam dalam format DATE real itme
			
			$mulai_time=(is_string($mulai)?strtotime($mulai):$mulai);// memaksa mebentuk format time untuk string
			$selesai_time=(is_string($waktu_selesai)?strtotime($waktu_selesai):$waktu_selesai);
			
			$selisih_waktu=$selesai_time-$mulai_time; //hitung selisih dalam detik
			
			//Untuk menghitung jumlah dalam satuan jam:
			$sisa = $selisih_waktu % 86400;
			$jumlah_jam = floor($sisa/3600);
			
			//Untuk menghitung jumlah dalam satuan menit:
			$sisa = $sisa % 3600;
			$jumlah_menit = floor($sisa/60);
			
			//Untuk menghitung jumlah dalam satuan detik:
			$sisa = $sisa % 60;
			$jumlah_detik = floor($sisa/1);
			
			$waktu_total = $jumlah_jam ." jam ". $jumlah_menit  ." menit ". $jumlah_detik  ." detik " ;
			
			
			$data = array("id_permintaan_domisili_perusahaan" => $id_permintaan_domisili_perusahaan,
							"status" => $status,
							"waktu_selesai" => $waktu_selesai,
							"waktu_total" => $waktu_total
						);
			
			$hasil = $this->surat_serv->getSelesaiDomisiliperusahaan($data);
			//var_dump($hasil);
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'>$hasil. Maaf ada kesalahan </div>";
				$this->domisiliperusahaanAction();
				$this->render('domisiliperusahaan');				
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> SELAMAT, proses permintaan Domisili perusahaan atas Nama $nama, No Registrasi $no_registrasi SELESAI  </div>";		
				$this->domisiliperusahaanAction();
				$this->render('domisiliperusahaan');
			}			
		}
		
		
		//--------------------------------------keterangan tempat usaha	
		//cetak surat keterangantempatusaha
		public function keterangantempatusahacetakAction(){
			$id_permintaan_keterangan_tempat_usaha = $this->_getParam("id_permintaan_keterangan_tempat_usaha");
			$this->view->hasil = $this->surat_serv->getketerangantempatusahacetak($id_permintaan_keterangan_tempat_usaha);
		}
		
		public function keterangantempatusahaAction(){
			$this->view;
			$this->id_kelurahan;
			$this->view->kelurahan = $this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			
			$dataPerPage = 10;
			// apabila $_GET['page'] sudah didefinisikan, gunakan nomor halaman tersebut,
			// sedangkan apabila belum, nomor halamannya 1.
			$noPage = $this->_getParam("page");
			if(isset($noPage))
			{
				$noPage = $this->_getParam("page");
			}
			else{ 
				$noPage = 1;
			}
			
			$offset = ($noPage - 1) * $dataPerPage;
			$this->view->jumData = $this->surat_serv->getJumlahketerangantempatusaha($this->id_kelurahan);
			$this->view->dataPerPage = $dataPerPage;
			$this->view->noPage = $noPage;
			$this->view->offset=$offset;
			
			$this->view->surat = "Surat Keterangan Tempat Usaha";
			$this->view->permintaan = $this->surat_serv->getProsesketerangantempatusaha($this->id_kelurahan,$offset , $dataPerPage);
		}
		
		public function pencarianketerangantempatusahaAction(){
			$this->view;
			$this->view->kelurahan = $this->id_kelurahan;
			$this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			$id_pencarian = $_POST['id_pencarian'];
			$pencarian = $_POST['pencarian'];
			if(!$pencarian){
				$this->keterangantempatusahaAction();
				$this->render('keterangantempatusaha');
				}else{
				$this->view->surat = "Surat Keterangan Tempat Usaha";
				$this->view->cari = $pencarian;
				$this->view->permintaan = $this->surat_serv->getPencarianKeteranganTempatUsaha($this->id_kelurahan,$pencarian,$id_pencarian);
			}
		}
		
		public function caripendudukketerangantempatusahaAction() {
			$this->view;
			$this->view->surat = "Form Isian Surat Keterangan Tempat Usaha";
			$this->view->judul = "Masukan NIK";
		}
		
		//antrian keterangantempatusaha --> proses memasukan ke antrian andonikah, status = 1
		public function keterangantempatusahaantrianAction(){
			$nik = $_POST['nik'];
			$this->view->surat = "Form Antrian Keterangan Andon Nikah";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			
			//mengambil noregistrasi secara automatis
			$no_registrasi = $this->surat_serv->getNoRegistrasi(4,KTU); //4 adalah panjangnya, AN adalah kode huruf
			$this->view->no_registrasi=$no_registrasi;
			
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('keterangantempatusahaantrian');
			
		}
		
		//menyimpan antrian keterangan tempat usaha
		public function simpanketerangantempatusahaantrianAction(){
			if(isset($_POST['name'])){ 
				$id_kelurahan = $this->id_kelurahan;			
				$id_pengguna = $this->id_pengguna;		
				$nama_pengguna = $this->nama_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$waktu_antrian = date('H:i:s');
				$antrian_oleh = $nama_pengguna;
				$jam_masuk = date('H:i:s');
				$status = 1;
				
				//simpan data ke tabel andon nikah
				$data = array("id_pengguna" =>  	$id_pengguna,
								"id_kelurahan" => $id_kelurahan,
								"no_registrasi" => $no_registrasi,
								"nik" => $nik,
								"waktu_antrian" => $waktu_antrian,
								"antrian_oleh" => $antrian_oleh,
								"jam_masuk" => $jam_masuk,							
								"status" => $status
								);										 
				$hasil = $this->surat_serv->getsimpanketerangantempatusahaantrian($data);
				
				//simpan data ke tabel no_registrasi
				$registrasi = array("no_registrasi" =>  	$no_registrasi,
									"nik" => $nik							
									);										 
				$hasil = $this->surat_serv->getSimpanNoRegistrasi($registrasi);
				
				
				//jika gagal
				if($hasil=="gagal"){
					$this->view->peringatan ="<div class='gagal'>$hasil. Maaf ada kesalahan;</div>";
					$this->keterangantempatusahaAction();
					$this->render('keterangantempatusaha');					
				}
				//jika sukses
				if($hasil=="sukses"){
					$this->view->peringatan ="<div class='sukses'> Sukses, data berhasil ditambahkan ke antrian </div>";		
					$this->keterangantempatusahaAction();
					$this->render('keterangantempatusaha');
				}	
				}else{
				$this->keterangantempatusahaAction();
				$this->render('keterangantempatusaha');
			}
			
		}
		
		public function keterangantempatusahaprosesAction(){
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_andonnikah= $this->_getParam("id_permintaan_andonnikah");
			$no_registrasi= $this->_getParam(no_registrasi);
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			
			$this->view->KodeKelurahan= $KodeKelurahan;	
			
			$this->view->surat = "Form Isian Surat Keterangan Tempat Usaha";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
		}
		
		public function simpanprosesketerangantempatusahaAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->nama_pengguna;
				
				$waktu_proses = date("H:i:s");
				$proses_oleh= $nama_pengguna;
				
				$id_kelurahan = $this->id_kelurahan;
				$id_permintaan_keterangan_tempat_usaha = $_POST['id_permintaan_keterangan_tempat_usaha'];
				$id_jenis_surat = $_POST['id_jenis_surat'];
				$id_surat = $_POST['id_surat'];
				
				$nik = $_POST['nik'];
				$id_pejabat = $_POST['id_pejabat'];
				$no_surat = $_POST['no_surat'];
				$tanggal_surat = $_POST['tanggal_surat'];
				$no_surat_pengantar = $_POST['no_surat_pengantar'];
				$bidang_usaha = $_POST['bidang_usaha'];
				$alamat_usaha = $_POST['alamat_usaha'];		 
				$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
				$masa_berlaku = $_POST['masa_berlaku'];
				$status = 2;
				
				$data = array("id_kelurahan" =>  	$id_kelurahan,
								"id_permintaan_keterangan_tempat_usaha" => $id_permintaan_keterangan_tempat_usaha,
								"nik" => $nik,
								"id_pejabat" => $id_pejabat,
								"id_jenis_surat" => $id_jenis_surat,
								"id_surat" => $id_surat,
								"no_surat" => $no_surat,
								"tanggal_surat" => $tanggal_surat,
								"no_surat_pengantar" => $no_surat_pengantar,
								"bidang_usaha" => $bidang_usaha,
								"alamat_usaha" => $alamat_usaha,
								"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
								"masa_berlaku" => $masa_berlaku,
								"status" => $status,
								"waktu_proses" => $waktu_proses,
								"proses_oleh" => $proses_oleh);
				
				$hasil = $this->surat_serv->getsimpanprosesketerangantempatusaha($data);
				var_dump($hasil);
				var_dump($data);
				//jika gagal
				if($hasil=='gagal'){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
					$this->keterangantempatusahaAction();
					$this->render('keterangantempatusaha');	
				}
				//jika sukses
				if($hasil=='sukses'){
					$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diproses </div>";		
					$this->keterangantempatusahaAction();
					$this->render('keterangantempatusaha');	
				}
			}else{
				$this->keterangantempatusahaAction();
				$this->render('keterangantempatusaha');	
			}	
			
		}
		public function keterangantempatusahahapusAction(){
			$id_permintaan_keterangan_tempat_usaha= $this->_getParam("id_permintaan_keterangan_tempat_usaha");
			$hasil = $this->surat_serv->gethapusketerangantempatusaha($id_permintaan_keterangan_tempat_usaha);
			
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->keterangantempatusahaAction();
				$this->render('keterangantempatusaha');	
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
			$this->keterangantempatusahaAction();
			$this->render('keterangantempatusaha');		
		}
		public function keterangantempatusahaeditAction(){
			$id_permintaan_keterangan_tempat_usaha = $this->_getParam("id_permintaan_keterangan_tempat_usaha");
			$this->view->hasil = $this->surat_serv->getketerangantempatusaha($id_permintaan_keterangan_tempat_usaha);
		}
		
		public function simpanprosesketerangantempatusahaeditAction(){
			$id_permintaan_keterangan_tempat_usaha = $this->_getParam('id_permintaan_keterangan_tempat_usaha');
			$id_kelurahan = $this->id_kelurahan;
			$nik = $_POST['nik'];
			$no_surat = $_POST['no_surat'];
			$tanggal_surat = $_POST['tanggal_surat'];
			$no_surat_pengantar = $_POST['no_surat_pengantar'];
			$bidang_usaha = $_POST['bidang_usaha'];
			$alamat_usaha = $_POST['alamat_usaha'];
			$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
			$masa_berlaku = $_POST['masa_berlaku'];
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
			"id_permintaan_keterangan_tempat_usaha" => $id_permintaan_keterangan_tempat_usaha,
			"nik" => $nik,
			"no_surat" => $no_surat,
			"tanggal_surat" => $tanggal_surat,
			"no_surat_pengantar" => $no_surat_pengantar,
			"bidang_usaha" => $bidang_usaha,
			"alamat_usaha" => $alamat_usaha,
			"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
			"masa_berlaku" => $masa_berlaku);
			
			$hasil = $this->surat_serv->getsimpanprosesketerangantempatusahaedit($data);
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->keterangantempatusahaAction();
				$this->render('keterangantempatusaha');	
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
			$this->keterangantempatusahaAction();
			$this->render('keterangantempatusaha');	
		}
		
		//proses selesai
		public function keterangantempatusahaselesaiAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->nama_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_keterangan_tempat_usaha= $this->_getParam("id_permintaan_keterangan_tempat_usaha");
			$nama= $this->_getParam("nama");
			$no_registrasi= $this->_getParam("no_registrasi");
			$status= 3;	
			
			//menghitung waktu total
			$waktu_antrian = $_POST['waktu_antrian'];
			$mulai_time = $waktu_antrian;
			$waktu_selesai=date("H:i:s"); //jam dalam format DATE real itme
			
			$mulai_time=(is_string($mulai)?strtotime($mulai):$mulai);// memaksa mebentuk format time untuk string
			$selesai_time=(is_string($waktu_selesai)?strtotime($waktu_selesai):$waktu_selesai);
			
			$selisih_waktu=$selesai_time-$mulai_time; //hitung selisih dalam detik
			
			//Untuk menghitung jumlah dalam satuan jam:
			$sisa = $selisih_waktu % 86400;
			$jumlah_jam = floor($sisa/3600);
			
			//Untuk menghitung jumlah dalam satuan menit:
			$sisa = $sisa % 3600;
			$jumlah_menit = floor($sisa/60);
			
			//Untuk menghitung jumlah dalam satuan detik:
			$sisa = $sisa % 60;
			$jumlah_detik = floor($sisa/1);
			
			$waktu_total = $jumlah_jam ." jam ". $jumlah_menit  ." menit ". $jumlah_detik  ." detik " ;
			
			
			$data = array("id_permintaan_keterangan_tempat_usaha" => $id_permintaan_keterangan_tempat_usaha,
							"status" => $status,
							"waktu_selesai" => $waktu_selesai,
							"waktu_total" => $waktu_total
						);
			
			$hasil = $this->surat_serv->getSelesaiKeterangantempatusaha($data);
			//var_dump($hasil);
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'>$hasil. Maaf ada kesalahan </div>";
				$this->keterangantempatusahaAction();
				$this->render('keterangantempatusaha');				
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> SELAMAT, proses permintaan keterangan tempat usaha atas Nama $nama, No Registrasi $no_registrasi SELESAI  </div>";		
				$this->keterangantempatusahaAction();
				$this->render('keterangantempatusaha');
			}			
		}
		
		//--------------------------------------lahir	
		//cetak surat lahir
		public function lahircetakAction(){
			$id_permintaan_lahir = $this->_getParam("id_permintaan_lahir");
			$this->view->hasil = $this->surat_serv->getlahircetak($id_permintaan_lahir);
		}
		
		public function lahirAction(){
			$this->view;
			$this->id_kelurahan;
			$this->view->kelurahan = $this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			
			$dataPerPage = 10;
			// apabila $_GET['page'] sudah didefinisikan, gunakan nomor halaman tersebut,
			// sedangkan apabila belum, nomor halamannya 1.
			$noPage = $this->_getParam("page");
			if(isset($noPage))
			{
				$noPage = $this->_getParam("page");
			}
			else{ 
				$noPage = 1;
			}
			
			$offset = ($noPage - 1) * $dataPerPage;
			$this->view->jumData = $this->surat_serv->getJumlahlahir($this->id_kelurahan);
			$this->view->dataPerPage = $dataPerPage;
			$this->view->noPage = $noPage;
			$this->view->offset=$offset;
			
			$this->view->surat = "Surat Permintaan Keterangan Lahir";
			$this->view->permintaan = $this->surat_serv->getProseslahir($this->id_kelurahan,$offset ,$dataPerPage);
		}
		
		public function pencarianlahirAction(){
			$this->view;
			$this->view->kelurahan = $this->id_kelurahan;
			$this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			$id_pencarian = $_POST['id_pencarian'];
			$pencarian = $_POST['pencarian'];
			if(!$pencarian){
				$this->lahirAction();
				$this->render('lahir');
				}else{
				$this->view->surat = "Surat Keterangan Lahir";
				$this->view->cari = $pencarian;
				$this->view->permintaan = $this->surat_serv->getPencarianLahir($this->id_kelurahan,$pencarian,$id_pencarian);
			}
		}
		
		public function caripenduduklahirAction() {
			$this->view;
			$this->view->surat = "Form Isian Surat Keterangan Lahir";
			$this->view->judul = "Masukan NIK";
		}
		
		//antrian lahir --> proses memasukan ke antrian lahir, status = 1
		public function lahirantrianAction(){
			$nik = $_POST['nik'];
			$this->view->surat = "Form Antrian Keterangan Kelahiran";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			
			//mengambil noregistrasi secara automatis
			$no_registrasi = $this->surat_serv->getNoRegistrasi(4,LHR); //4 adalah panjangnya, AN adalah kode huruf
			$this->view->no_registrasi=$no_registrasi;
			
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('lahirantrian');
			
		}
		
		//menyimpan antrian andon nikah
		public function simpanlahirantrianAction(){
			if(isset($_POST['name'])){ 
				$id_kelurahan = $this->id_kelurahan;			
				$id_pengguna = $this->id_pengguna;		
				$nama_pengguna = $this->nama_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$waktu_antrian = date('H:i:s');
				$antrian_oleh = $nama_pengguna;
				$jam_masuk = date('H:i:s');
				$status = 1;
				
				//simpan data ke tabel andon nikah
				$data = array("id_pengguna" =>  	$id_pengguna,
				"id_kelurahan" => $id_kelurahan,
				"no_registrasi" => $no_registrasi,
				"nik" => $nik,
				"waktu_antrian" => $waktu_antrian,
				"antrian_oleh" => $antrian_oleh,
				"jam_masuk" => $jam_masuk,							
				"status" => $status
				);										 
				$hasil = $this->surat_serv->getsimpanlahirantrian($data);
				
				//simpan data ke tabel no_registrasi
				$registrasi = array("no_registrasi" =>  	$no_registrasi,
				"nik" => $nik							
				);										 
				$hasil2 = $this->surat_serv->getSimpanNoRegistrasi($registrasi);
				
				var_dump($data);
				var_dump($hasil);
				var_dump($hasil2);
				
				//jika gagal
				if($hasil=="gagal"){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan</div>";
					$this->lahirAction();
					$this->render('lahir');					
				}
				//jika sukses
				if($hasil=="sukses"){
					$this->view->peringatan ="<div class='sukses'> Sukses, data berhasil ditambahkan ke antrian </div>";		
					$this->lahirAction();
					$this->render('lahir');
				}	
				}else{
				$this->lahirAction();
				$this->render('lahir');
			}
			
		}
		
		public function lahirprosesAction(){
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_lahir= $this->_getParam("id_permintaan_lahir");
			$no_registrasi= $this->_getParam(no_registrasi);
			
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;
			
			$this->view->surat = "Form Isian Surat Keterangan Lahir";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
		}
		public function simpanproseslahirAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->nama_pengguna;
				
				$waktu_proses = date("H:i:s");
				$proses_oleh= $nama_pengguna;
				
				$id_kelurahan = $this->id_kelurahan;
				$id_permintaan_lahir = $_POST['id_permintaan_lahir'];
				$id_jenis_surat = $_POST['id_jenis_surat'];
				$id_surat = $_POST['id_surat'];
				
				$nik = $_POST['nik'];
				$id_pejabat = $_POST['id_pejabat'];
				$no_surat = $_POST['no_surat'];
				$tanggal_surat = $_POST['tanggal_surat'];
				$no_surat_pengantar = $_POST['no_surat_pengantar'];
				$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar']; 
				$nama_anak = $_POST['nama_anak'];
				$jenis_kelamin_anak = $_POST['jenis_kelamin_anak'];
				$tempat_lahir_anak = $_POST['tempat_lahir_anak'];
				$tanggal_lahir_anak = $_POST['tanggal_lahir_anak'];
				$anak_ke = $_POST['anak_ke'];
				$jam_lahir = $_POST['jam_lahir'];
				
				$status = 2;
				
				$data = array("id_kelurahan" =>  	$id_kelurahan,
								"id_permintaan_lahir" => $id_permintaan_lahir,
								"nik" => $nik,
								"id_pejabat" => $id_pejabat,
								"id_jenis_surat" => $id_jenis_surat,
								"id_surat" => $id_surat,							
								"no_surat" => $no_surat,
								"tanggal_surat" => $tanggal_surat,
								"no_surat_pengantar" => $no_surat_pengantar,
								"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
								"nama_anak" => $nama_anak,
								"jenis_kelamin_anak" => $jenis_kelamin_anak,
								"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
								"tempat_lahir_anak" => $tempat_lahir_anak,
								"tanggal_lahir_anak" => $tanggal_lahir_anak,
								"anak_ke" => $anak_ke,
								"jam_lahir" => $jam_lahir,
								"status" => $status,
								"waktu_proses" => $waktu_proses,
								"proses_oleh" => $proses_oleh
								);
				
				$hasil = $this->surat_serv->getsimpanproseslahir($data);
				
				//var_dump($hasil);
				//var_dump($data);
				
				//jika gagal
				if($hasil=='gagal'){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
					$this->lahirAction();
					$this->render('lahir');
				}
				//jika sukses
				if($hasil=='sukses'){
					$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diproses </div>";		
					$this->lahirAction();
					$this->render('lahir');
				}
				}else{
				$this->lahirAction();
				$this->render('lahir');
			}
			
		}
		public function lahirhapusAction(){
			$id_permintaan_lahir= $this->_getParam("id_permintaan_lahir");
			$hasil = $this->surat_serv->gethapuslahir($id_permintaan_lahir);
			
			//jika gagal
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->lahirAction();
				$this->render('lahir');
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
				$this->lahirAction();
				$this->render('lahir');
			}
		}
		public function lahireditAction(){
			$id_permintaan_lahir = $this->_getParam("id_permintaan_lahir");
			$this->view->hasil = $this->surat_serv->getlahir($id_permintaan_lahir);
		}
		
		public function simpanproseslahireditAction(){
			$id_permintaan_lahir = $this->_getParam('id_permintaan_lahir');
			$id_kelurahan = $this->id_kelurahan;
			$nik = $_POST['nik'];
			$no_surat = $_POST['no_surat'];
			$tanggal_surat = $_POST['tanggal_surat'];
			$no_surat_pengantar = $_POST['no_surat_pengantar'];
			$rt = $_POST['rt'];
			$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
			$nama_anak = $_POST['nama_anak'];
			$jenis_kelamin_anak = $_POST['jenis_kelamin_anak'];
			$tempat_lahir_anak = $_POST['tempat_lahir_anak'];
			$tanggal_lahir_anak = $_POST['tanggal_lahir_anak'];
			$anak_ke = $_POST['anak_ke'];
			$jam_lahir = $_POST['jam_lahir'];
			
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
			"id_permintaan_lahir" => $id_permintaan_lahir,
			"nik" => $nik,
			"no_surat" => $no_surat,
			"tanggal_surat" => $tanggal_surat,
			"no_surat_pengantar" => $no_surat_pengantar,
			"rt" => $rt,
			"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
			"nama_anak" => $nama_anak,
			"jenis_kelamin_anak" => $jenis_kelamin_anak,
			"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
			"tempat_lahir_anak" => $tempat_lahir_anak,
			"tanggal_lahir_anak" => $tanggal_lahir_anak,
			"anak_ke" => $anak_ke,
			"jam_lahir" => $jam_lahir							
			);
			
			$hasil = $this->surat_serv->getsimpanlahiredit($data);
			//jika gagal
			if(!hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->lahirAction();
				$this->render('lahir');
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
			$this->lahirAction();
			$this->render('lahir');
		}
		
		public function lahirselesaiAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->nama_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_lahir= $this->_getParam("id_permintaan_lahir");
			$nama= $this->_getParam("nama");
			$no_registrasi= $this->_getParam("no_registrasi");
			$status= 3;	
			
			//menghitung waktu total
			$waktu_antrian = $_POST['waktu_antrian'];
			$mulai_time = $waktu_antrian;
			$waktu_selesai=date("H:i:s"); //jam dalam format DATE real itme
			
			$mulai_time=(is_string($mulai)?strtotime($mulai):$mulai);// memaksa mebentuk format time untuk string
			$selesai_time=(is_string($waktu_selesai)?strtotime($waktu_selesai):$waktu_selesai);
			
			$selisih_waktu=$selesai_time-$mulai_time; //hitung selisih dalam detik
			
			//Untuk menghitung jumlah dalam satuan jam:
			$sisa = $selisih_waktu % 86400;
			$jumlah_jam = floor($sisa/3600);
			
			//Untuk menghitung jumlah dalam satuan menit:
			$sisa = $sisa % 3600;
			$jumlah_menit = floor($sisa/60);
			
			//Untuk menghitung jumlah dalam satuan detik:
			$sisa = $sisa % 60;
			$jumlah_detik = floor($sisa/1);
			
			$waktu_total = $jumlah_jam ." jam ". $jumlah_menit  ." menit ". $jumlah_detik  ." detik " ;
			
			
			$data = array("id_permintaan_lahir" => $id_permintaan_lahir,
			"status" => $status,
			"waktu_selesai" => $waktu_selesai,
			"waktu_total" => $waktu_total);
			
			$hasil = $this->surat_serv->getSelesaiLahir($data);
			//var_dump($hasil);
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->lahirAction();
				$this->render('lahir');				
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> SELAMAT, proses permintaan kelahiran atas Nama $nama,No Registrasi $no_registrasi SELESAI  </div>";		
				$this->lahirAction();
				$this->render('lahir');
			}
			
		}
		
		//--------------------------------------mati	
		//cetak surat mati
		public function maticetakAction(){
			$id_permintaan_mati = $this->_getParam("id_permintaan_mati");
			$this->view->hasil = $this->surat_serv->getmaticetak($id_permintaan_mati);
		}
		
		public function matiAction(){
			$this->view;
			$this->id_kelurahan;
			$this->view->kelurahan = $this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			
			$dataPerPage = 10;
			// apabila $_GET['page'] sudah didefinisikan, gunakan nomor halaman tersebut,
			// sedangkan apabila belum, nomor halamannya 1.
			$noPage = $this->_getParam("page");
			if(isset($noPage))
			{
				$noPage = $this->_getParam("page");
			}
			else{ 
				$noPage = 1;
			}
			
			$offset = ($noPage - 1) * $dataPerPage;
			$this->view->jumData = $this->surat_serv->getJumlahmati($this->id_kelurahan);
			$this->view->dataPerPage = $dataPerPage;
			$this->view->noPage = $noPage;
			$this->view->offset=$offset;
			
			$this->view->surat = "Surat Keterangan mati";
			$this->view->permintaan = $this->surat_serv->getProsesmati($this->id_kelurahan,$offset ,$dataPerPage);
		}
		
		public function pencarianmatiAction(){
			$this->view;
			$this->view->kelurahan = $this->id_kelurahan;
			$this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			$id_pencarian = $_POST['id_pencarian'];
			$pencarian = $_POST['pencarian'];
			if(!$pencarian){
				$this->matiAction();
				$this->render('mati');
				}else{
				$this->view->surat = "Surat Keterangan mati";
				$this->view->cari = $pencarian;
				$this->view->permintaan = $this->surat_serv->getPencarianmati($this->id_kelurahan,$pencarian,$id_pencarian);
			}
		}
		
		public function caripendudukmatiAction() {
			$this->view;
			$this->view->surat = "Form Isian Surat Keterangan mati";
			$this->view->judul = "Masukan NIK";
		}
		
		//antrian mati --> proses memasukan ke antrian mati, status = 1
		public function matiantrianAction(){
			$nik = $_POST['nik'];
			$this->view->surat = "Form Antrian Keterangan Mati";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			
			//mengambil noregistrasi secara automatis
			$no_registrasi = $this->surat_serv->getNoRegistrasi(4,MTI); //4 adalah panjangnya, AN adalah kode huruf
			$this->view->no_registrasi=$no_registrasi;
			
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('matiantrian');
			
		}
		
		//menyimpan antrian mati
		public function simpanmatiantrianAction(){
			if(isset($_POST['name'])){ 
				$id_kelurahan = $this->id_kelurahan;			
				$id_pengguna = $this->id_pengguna;		
				$nama_pengguna = $this->nama_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$waktu_antrian = date('H:i:s');
				$antrian_oleh = $nama_pengguna;
				$jam_masuk = date('H:i:s');
				$status = 1;
				
				//simpan data ke tabel andon nikah
				$data = array("id_pengguna" =>  	$id_pengguna,
				"id_kelurahan" => $id_kelurahan,
				"no_registrasi" => $no_registrasi,
				"nik" => $nik,
				"waktu_antrian" => $waktu_antrian,
				"antrian_oleh" => $antrian_oleh,
				"jam_masuk" => $jam_masuk,							
				"status" => $status
				);										 
				$hasil = $this->surat_serv->getsimpanmatiantrian($data);
				
				//simpan data ke tabel no_registrasi
				$registrasi = array("no_registrasi" =>  	$no_registrasi,
				"nik" => $nik							
				);										 
				$hasil = $this->surat_serv->getSimpanNoRegistrasi($registrasi);
				
				
				//jika gagal
				if($hasil=="gagal"){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
					$this->matiAction();
					$this->render('mati');					
				}
				//jika sukses
				if($hasil=="sukses"){
					$this->view->peringatan ="<div class='sukses'> Sukses, data berhasil ditambahkan ke antrian </div>";		
					$this->matiAction();
					$this->render('mati');
				}	
				}else{
				$this->matiAction();
				$this->render('mati');
			}
			
		}
		
		
		public function matiprosesAction(){
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_mati= $this->_getParam("id_permintaan_mati");
			$no_registrasi= $this->_getParam(no_registrasi);
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;
			
			$this->view->surat = "Form Isian Surat Keterangan mati";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
		}
		public function simpanprosesmatiAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->nama_pengguna;
				
				$waktu_proses = date("H:i:s");
				$proses_oleh= $nama_pengguna;
				
				$id_kelurahan = $this->id_kelurahan;
				$id_permintaan_mati = $_POST['id_permintaan_mati'];
				$id_jenis_surat = $_POST['id_jenis_surat'];
				$id_surat = $_POST['id_surat'];
				$nik = $_POST['nik'];
				$id_pejabat = $_POST['id_pejabat'];
				$no_surat = $_POST['no_surat'];
				$tanggal_surat = $_POST['tanggal_surat'];
				$no_surat_pengantar = $_POST['no_surat_pengantar'];
				$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
				
				$tanggal_meninggal= $_POST['tanggal_meninggal'];
				$jam_meninggal =$_POST['jam_meninggal'];
				$lokasi_meninggal =$_POST['tanggal_meninggal'];
				$penyebab_meninggal =$_POST['penyebab_meninggal'];
				$usia_meninggal =$_POST['usia_meninggal'];
				$keperluan =$_POST['keperluan'];
				
				$status = 2;
				
				$data = array("id_kelurahan" =>  	$id_kelurahan,
				"id_permintaan_mati" => $id_permintaan_mati,
				"nik" => $nik,
				"id_pejabat" => $id_pejabat,
				"id_jenis_surat" => $id_jenis_surat,
				"id_surat" => $id_surat,
				"no_surat" => $no_surat,
				"tanggal_surat" => $tanggal_surat,
				"no_surat_pengantar" => $no_surat_pengantar,
				"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
				"status" => $status,
				"tgl_dibuat" => $tgl_dibuat,
				"dibuat_oleh" => $dibuat_oleh,
				"tanggal_meninggal" => $tanggal_meninggal,
				"jam_meninggal" => $jam_meninggal,
				"lokasi_meninggal" => $lokasi_meninggal,
				"penyebab_meninggal" => $penyebab_meninggal,
				"usia_meninggal" => $usia_meninggal,
				"keperluan" => $keperluan,
				"waktu_proses" => $waktu_proses,
				"proses_oleh" => $proses_oleh,
				);
				
				$hasil = $this->surat_serv->getsimpanprosesmati($data);
				//jika gagal
				if(!hasil){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
					$this->matiAction();
					$this->render('mati');	
				}
				//jika sukses
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diproses </div>";		
				$this->matiAction();
				$this->render('mati');
				}else{
				$this->matiAction();
				$this->render('mati');
			}
			
		}
		public function matihapusAction(){
			$id_permintaan_mati= $this->_getParam("id_permintaan_mati");
			$hasil = $this->surat_serv->gethapusmati($id_permintaan_mati);
			
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->matiAction();
				$this->render('mati');	
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
			$this->matiAction();
			$this->render('mati');	
		}
		public function matieditAction(){
			$id_permintaan_mati = $this->_getParam("id_permintaan_mati");
			$this->view->hasil = $this->surat_serv->getmati($id_permintaan_mati);
		}
		
		public function simpanprosesmatieditAction(){
			$id_permintaan_mati = $this->_getParam('id_permintaan_mati');
			$id_kelurahan = $this->id_kelurahan;
			$nik = $_POST['nik'];
			$no_surat = $_POST['no_surat'];
			$tanggal_surat = $_POST['tanggal_surat'];
			$no_surat_pengantar = $_POST['no_surat_pengantar'];
			$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
			$tanggal_meninggal= $_POST['tanggal_meninggal'];
			$jam_meninggal =$_POST['jam_meninggal'];
			$lokasi_meninggal =$_POST['tanggal_meninggal'];
			$penyebab_meninggal =$_POST['penyebab_meninggal'];
			$usia_meninggal =$_POST['usia_meninggal'];
			$keperluan =$_POST['keperluan'];
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
			"id_permintaan_mati" => $id_permintaan_mati,
			"nik" => $nik,
			"no_surat" => $no_surat,
			"tanggal_surat" => $tanggal_surat,
			"no_surat_pengantar" => $no_surat_pengantar,
			"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
			"tanggal_meninggal" => $tanggal_meninggal,
			"jam_meninggal" => $jam_meninggal,
			"lokasi_meninggal" => $lokasi_meninggal,
			"penyebab_meninggal" => $penyebab_meninggal,
			"usia_meninggal" => $usia_meninggal,
			"keperluan" => $keperluan
			);
			
			$hasil = $this->surat_serv->getsimpanmatiedit($data);
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->matiAction();
				$this->render('mati');	
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
			$this->matiAction();
			$this->render('mati');
		}
		
		//proses selesai
		public function matiselesaiAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->nama_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_mati= $this->_getParam("id_permintaan_mati");
			$nama= $this->_getParam("nama");
			$no_registrasi= $this->_getParam("no_registrasi");
			$status= 3;	
			
			//menghitung waktu total
			$waktu_antrian = $_POST['waktu_antrian'];
			$mulai_time = $waktu_antrian;
			$waktu_selesai=date("H:i:s"); //jam dalam format DATE real itme
			
			$mulai_time=(is_string($mulai)?strtotime($mulai):$mulai);// memaksa mebentuk format time untuk string
			$selesai_time=(is_string($waktu_selesai)?strtotime($waktu_selesai):$waktu_selesai);
			
			$selisih_waktu=$selesai_time-$mulai_time; //hitung selisih dalam detik
			
			//Untuk menghitung jumlah dalam satuan jam:
			$sisa = $selisih_waktu % 86400;
			$jumlah_jam = floor($sisa/3600);
			
			//Untuk menghitung jumlah dalam satuan menit:
			$sisa = $sisa % 3600;
			$jumlah_menit = floor($sisa/60);
			
			//Untuk menghitung jumlah dalam satuan detik:
			$sisa = $sisa % 60;
			$jumlah_detik = floor($sisa/1);
			
			$waktu_total = $jumlah_jam ." jam ". $jumlah_menit  ." menit ". $jumlah_detik  ." detik " ;
			
			
			$data = array("id_permintaan_mati" => $id_permintaan_mati,
			"status" => $status,
			"waktu_selesai" => $waktu_selesai,
			"waktu_total" => $waktu_total);
			
			$hasil = $this->surat_serv->getSelesaiMati($data);
			//var_dump($hasil);
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->matiAction();
				$this->render('mati');				
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> SELAMAT, proses permintaan mati atas Nama $nama, No Registrasi $no_registrasi SELESAI  </div>";		
				$this->matiAction();
				$this->render('mati');
			}			
		}
		
		
		//--------------------------------------waris	
		public function warisAction(){
			$this->view;
			$this->id_kelurahan;
			$this->view->kelurahan = $this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			
			$dataPerPage = 10;
			// apabila $_GET['page'] sudah didefinisikan, gunakan nomor halaman tersebut,
			// sedangkan apabila belum, nomor halamannya 1.
			$noPage = $this->_getParam("page");
			if(isset($noPage))
			{
				$noPage = $this->_getParam("page");
			}
			else{ 
				$noPage = 1;
			}
			
			$offset = ($noPage - 1) * $dataPerPage;
			$this->view->jumData = $this->surat_serv->getJumlahwaris($this->id_kelurahan);
			$this->view->dataPerPage = $dataPerPage;
			$this->view->noPage = $noPage;
			$this->view->offset=$offset;
			
			$this->view->surat = "Surat Keterangan waris";
			$this->view->permintaan = $this->surat_serv->getProseswaris($this->id_kelurahan);
		}
		
		public function pencarianwarisAction(){
			$this->view;
			$this->view->kelurahan = $this->id_kelurahan;
			$this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			$id_pencarian = $_POST['id_pencarian'];
			$pencarian = $_POST['pencarian'];
			if(!$pencarian){
				$this->warisAction();
				$this->render('waris');
				}else{
				$this->view->surat = "Surat Keterangan waris";
				$this->view->cari = $pencarian;
				$this->view->permintaan = $this->surat_serv->getPencarianwaris($this->id_kelurahan,$pencarian,$id_pencarian);
			}
		}
		
		public function caripendudukwarisAction() {
			$this->view;
			$this->view->surat = "Form Isian Surat Keterangan waris";
			$this->view->judul = "Masukan NIK";
		}
		public function permintaanwarisAction(){
			$nik = $_POST['nik'];
			$this->view->surat = "Form Isian Surat Keterangan waris";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatpemerintahan($this->id_kelurahan);
		}
		public function simpanproseswarisAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->nama_pengguna;
				
				$tgl_dibuat = date("Y-m-d H:i:s");
				$dibuat_oleh= $nama_pengguna;
				
				$id_kelurahan = $this->id_kelurahan;
				$nik = $_POST['nik'];
				$id_pejabat = $_POST['id_pejabat'];
				$no_surat = $_POST['no_surat'];
				$tanggal_surat = $_POST['tanggal_surat'];
				$no_surat_pengantar = $_POST['no_surat_pengantar'];
				$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
				$status = 0;
				
				$data = array("id_kelurahan" =>  	$id_kelurahan,
				"nik" => $nik,
				"id_pejabat" => $id_pejabat,
				"no_surat" => $no_surat,
				"tanggal_surat" => $tanggal_surat,
				"no_surat_pengantar" => $no_surat_pengantar,
				"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
				"status" => $status,
				"tgl_dibuat" => $tgl_dibuat,
				"dibuat_oleh" => $dibuat_oleh);
				
				$hasil = $this->surat_serv->getsimpanproseswaris($data);
				//jika gagal
				if(!hasil){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
					$this->warisAction();
					$this->render('waris');	
				}
				//jika sukses
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diproses </div>";		
				$this->warisAction();
				$this->render('waris');
				}else{
				$this->warisAction();
				$this->render('waris');
			}
			
		}
		public function warishapusAction(){
			$id_permintaan_waris= $this->_getParam("id_permintaan_waris");
			$hasil = $this->surat_serv->gethapuswaris($id_permintaan_waris);
			
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->warisAction();
				$this->render('waris');	
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
			$this->warisAction();
			$this->render('waris');
		}
		public function wariseditAction(){
			$id_permintaan_waris = $this->_getParam("id_permintaan_waris");
			$this->view->hasil = $this->surat_serv->getwaris($id_permintaan_waris);
		}
		
		public function simpanproseswariseditAction(){
			$id_permintaan_waris = $this->_getParam('id_permintaan_waris');
			$id_kelurahan = $this->id_kelurahan;
			$nik = $_POST['nik'];
			$no_surat = $_POST['no_surat'];
			$tanggal_surat = $_POST['tanggal_surat'];
			$no_surat_pengantar = $_POST['no_surat_pengantar'];
			$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
			"id_permintaan_waris" => $id_permintaan_waris,
			"nik" => $nik,
			"no_surat" => $no_surat,
			"tanggal_surat" => $tanggal_surat,
			"no_surat_pengantar" => $no_surat_pengantar,
			"rt" => $rt,
			"tanggal_surat_pengantar" => $tanggal_surat_pengantar);
			
			$hasil = $this->surat_serv->getsimpanwarisedit($data);
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->warisAction();
				$this->render('waris');	
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
			$this->warisAction();
			$this->render('waris');
		}
		
		//--------------------------------------surat serbaguna	
		public function serbagunaAction(){
			$this->view;
			$this->id_kelurahan;
			$this->view->kelurahan = $this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			
			$dataPerPage = 10;
			// apabila $_GET['page'] sudah didefinisikan, gunakan nomor halaman tersebut,
			// sedangkan apabila belum, nomor halamannya 1.
			$noPage = $this->_getParam("page");
			if(isset($noPage))
			{
				$noPage = $this->_getParam("page");
			}
			else{ 
				$noPage = 1;
			}
			
			$offset = ($noPage - 1) * $dataPerPage;
			$this->view->jumData = $this->surat_serv->getJumlahserbaguna($this->id_kelurahan);
			$this->view->dataPerPage = $dataPerPage;
			$this->view->noPage = $noPage;
			$this->view->offset=$offset;
			
			$this->view->surat = "Surat Keterangan serbaguna";
			$this->view->permintaan = $this->surat_serv->getProsesserbaguna($this->id_kelurahan);
		}
		
		public function pencarianserbagunaAction(){
			$this->view;
			$this->view->kelurahan = $this->id_kelurahan;
			$this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			$id_pencarian = $_POST['id_pencarian'];
			$pencarian = $_POST['pencarian'];
			if(!$pencarian){
				$this->serbagunaAction();
				$this->render('serbaguna');
				}else{
				$this->view->surat = "Surat Keterangan serbaguna";
				$this->view->cari = $pencarian;
				$this->view->permintaan = $this->surat_serv->getPencarianserbaguna($this->id_kelurahan,$pencarian,$id_pencarian);
			}
		}
		
		public function caripendudukserbagunaAction() {
			$this->view;
			$this->view->surat = "Form Isian Surat Keterangan serbaguna";
			$this->view->judul = "Masukan NIK";
		}
		public function permintaanserbagunaAction(){
			$nik = $_POST['nik'];
			$this->view->surat = "Form Isian Surat Keterangan serbaguna";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatpemerintahan($this->id_kelurahan);
		}
		public function simpanprosesserbagunaAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->nama_pengguna;
				
				$tgl_dibuat = date("Y-m-d H:i:s");
				$dibuat_oleh= $nama_pengguna;
				
				$id_kelurahan = $this->id_kelurahan;
				$nik = $_POST['nik'];
				$id_pejabat = $_POST['id_pejabat'];
				$no_surat = $_POST['no_surat'];
				$tanggal_surat = $_POST['tanggal_surat'];
				$no_surat_pengantar = $_POST['no_surat_pengantar'];
				$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
				$status = 0;
				
				$data = array("id_kelurahan" =>  	$id_kelurahan,
				"nik" => $nik,
				"id_pejabat" => $id_pejabat,
				"no_surat" => $no_surat,
				"tanggal_surat" => $tanggal_surat,
				"no_surat_pengantar" => $no_surat_pengantar,
				"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
				"status" => $status,
				"tgl_dibuat" => $tgl_dibuat,
				"dibuat_oleh" => $dibuat_oleh);
				
				$hasil = $this->surat_serv->getsimpanprosesserbaguna($data);
				//jika gagal
				if(!hasil){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
					$this->serbagunaAction();
					$this->render('serbaguna');
				}
				//jika sukses
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diproses </div>";		
				$this->serbagunaAction();
				$this->render('serbaguna');
				}else{
				$this->serbagunaAction();
				$this->render('serbaguna');
			}
			
		}
		public function serbagunahapusAction(){
			$id_permintaan_serbaguna= $this->_getParam("id_permintaan_serbaguna");
			$hasil = $this->surat_serv->gethapusserbaguna($id_permintaan_serbaguna);
			
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->serbagunaAction();
				$this->render('serbaguna');
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
			$this->serbagunaAction();
			$this->render('serbaguna');	
		}
		public function serbagunaeditAction(){
			$id_permintaan_serbaguna = $this->_getParam("id_permintaan_serbaguna");
			$this->view->hasil = $this->surat_serv->getserbaguna($id_permintaan_serbaguna);
		}
		
		public function simpanprosesserbagunaeditAction(){
			$id_permintaan_serbaguna = $this->_getParam('id_permintaan_serbaguna');
			$id_kelurahan = $this->id_kelurahan;
			$nik = $_POST['nik'];
			$no_surat = $_POST['no_surat'];
			$tanggal_surat = $_POST['tanggal_surat'];
			$no_surat_pengantar = $_POST['no_surat_pengantar'];
			$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
			"id_permintaan_serbaguna" => $id_permintaan_serbaguna,
			"nik" => $nik,
			"no_surat" => $no_surat,
			"tanggal_surat" => $tanggal_surat,
			"no_surat_pengantar" => $no_surat_pengantar,
			"rt" => $rt,
			"tanggal_surat_pengantar" => $tanggal_surat_pengantar);
			
			$hasil = $this->surat_serv->getsimpanserbagunaedit($data);
			//jika gagal 
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->serbagunaAction();
				$this->render('serbaguna');
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
			$this->serbagunaAction();
			$this->render('serbaguna');
		}
		
		//penduduk
		public function tambahpendudukAction(){
			
			$this->view;
			$this->view->surat = "Tambah Penduduk";
			$this->view->kelurahan = $this->pengguna->getKelurahan();
			
		}
		
		public function caripendudukAction() {
			$this->view;
			$this->view->surat = "Form Isian Surat Keterangan Tidak Mampu untuk Rumah Sakit";
			$this->view->judul = "Masukan NIK";
		}
		
	}
?>																