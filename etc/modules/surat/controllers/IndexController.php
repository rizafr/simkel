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
			
			
			//1. SURAT PEMBERDDAYAAN
			$this->view->pemberdayaan = $this->data_serv->getPemberdayaan();
			
			//jumlah yang belum diproses
			$jumlahstatusrs = $this->surat_serv->getJumlahStatusRumahsakit1();
			$jumlahstatussekolah = $this->surat_serv->getJumlahStatusSekolah1();	
			$jumlahstatusAndonnikah = $this->surat_serv->getJumlahStatusAndonnikah1();
			$jumlahstatusbelummenikah = $this->surat_serv->getJumlahStatusbelummenikah1();	
			$jumlahstatusjanda = $this->surat_serv->getJumlahStatusjanda1();
			$jumlahstatusna = $this->surat_serv->getJumlahStatusna1();	
			
			//masuk ke array pemberdayaan
			$this->view->statusPemberdayaan = array(
					1 => $jumlahstatusrs,
					2 => $jumlahstatussekolah,
					3 => $jumlahstatusAndonnikah,
					4 => $jumlahstatusbelummenikah,
					19 => $jumlahstatusjanda,
					47 => $jumlahstatusna
			);
			
			//2. SURAT TRANTIB
			$this->view->tantrib = $this->data_serv->getTantrib();
			
			//jumlah yang belum diproses
			$jumlahstatusik = $this->surat_serv->getJumlahStatusik1();
			$jumlahstatusps = $this->surat_serv->getJumlahStatusps1();
			$jumlahstatusbd = $this->surat_serv->getJumlahStatusbd1();
			$jumlahstatusDomisiliyayasan = $this->surat_serv->getJumlahStatusDomisiliyayasan1();
			
			//masuk ke array statusTantrib
			$this->view->statusTantrib = array(
					7 => $jumlahstatusik,
					8 => $jumlahstatusps,
					9 => $jumlahstatusbd,
					20 => $jumlahstatusDomisiliyayasan
			);
			
			//3. SURAT EKBANG
			$this->view->ekonomipembangunan = $this->data_serv->getEkonomiPembangunan();
			
			//jumlah yang belum diproses
			$jumlahstatusbpr = $this->surat_serv->getJumlahStatusbpr1();
			$jumlahstatusdomisiliparpol = $this->surat_serv->getJumlahStatusDomisiliparpol1();
			$jumlahstatusdomisiliperusahaan = $this->surat_serv->getJumlahStatusDomisiliperusahaan1();
			$jumlahstatusKeterangantempatusaha = $this->surat_serv->getJumlahStatusKeterangantempatusaha1();
			$jumlahstatusdomisilipanitiapemb1 = $this->surat_serv->getJumlahStatusdomisilipanitiapemb1();
			
			
			//masuk ke array statusTantrib
			$this->view->statusEkbang = array(
					5 => $jumlahstatusbpr,
					21 => $jumlahstatusdomisiliparpol,
					22 => $jumlahstatusdomisiliperusahaan,
					23 => $jumlahstatusKeterangantempatusaha,
					42 => $jumlahstatusdomisilipanitiapemb1,
			);
			
			//3. SURAT PEMERINTAHAN
			$this->view->pemerintahan = $this->data_serv->getPemerintahan();

			//jumlah yang belum diproses
			$jumlahstatusibadahhaji = $this->surat_serv->getJumlahStatusibadahhaji1();
			$jumlahstatusLahir = $this->surat_serv->getJumlahStatusLahir1();
			$jumlahstatusMati = $this->surat_serv->getJumlahStatusMati1();
			$jumlahstatusorangyangsama = $this->surat_serv->getJumlahStatusorangyangsama1();
			$JumlahStatusahliwaris = $this->surat_serv->getJumlahStatusahliwaris1();
			$JumlahStatusdomisilipenduduk = $this->surat_serv->getJumlahStatusdomisilipenduduk1();
			$JumlahStatusktbajb = $this->surat_serv->getJumlahStatusktbajb1();
			$JumlahStatusmutasipbb = $this->surat_serv->getJumlahStatusmutasipbb1();
			$JumlahStatuspenerbitanpbb = $this->surat_serv->getJumlahStatuspenerbitanpbb1();
			$JumlahStatuskipem = $this->surat_serv->getJumlahStatuskipem1();
			$JumlahStatusktp = $this->surat_serv->getJumlahStatusktp1();
			$JumlahStatuskk = $this->surat_serv->getJumlahStatuskk1();
			
			//masuk ke array statusTantrib
			$this->view->statusPemerintahan = array(
					6 => $jumlahstatusibadahhaji,
					24 => $jumlahstatusLahir,
					25 => $jumlahstatusMati,
					26 => $JumlahStatusktp,
					27 => $JumlahStatuskk,
					28 => $JumlahStatuskipem,
					30 => $jumlahstatusorangyangsama,
					32 => $JumlahStatusahliwaris,
					34 => $JumlahStatusdomisilipenduduk,
					35 => $JumlahStatusktbajb,
					36 => $JumlahStatusJumlahStatusktbsertifikat,
					39 => $JumlahStatusmutasipbb,
					40 => $JumlahStatuspenerbitanpbb,
					
			);

			date_default_timezone_set("Asia/Jakarta"); 
		}
		public function indexAction() {
			
		}
		public function homeAction(){
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			
		}
		
		public function infoAction(){
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
		}
		
		public function penggunaeditAction(){
		
			$id_pengguna = $this->_getParam('id_pengguna');
			$this->view->jenis_pengguna = $this->pengguna->getJenisPengguna();
			$hasil = $this->data_serv->getPilihPengguna($id_pengguna);		
			$this->view->pengguna = $hasil; 
		}
	public function simpanpenggunaeditAction(){
	
		$id_pengguna = $this->_getParam('id_pengguna');
		$id_data_pegawai = $this->_getParam('id_data_pegawai');
		$id_jenis_pengguna = $_POST['id_jenis_pengguna'];
		$id_kelurahan = $_POST['id_kelurahan'];
		$nama_pengguna = $_POST['nama_pengguna'];
		$nip_pengguna = $_POST['nip_pengguna'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		$jabatan = $_POST['jabatan'];
		$alamat = $_POST['alamat'];
		$no_telp = $_POST['no_telp'];
		
		$data = array("id_pengguna" => $id_pengguna,
							"id_jenis_pengguna" => $id_jenis_pengguna,
							"id_kelurahan" => $id_kelurahan,
							"nama_pengguna" => $nama_pengguna,
							"nip_pengguna" => $nip_pengguna,
							"username" => $username,
							"password" => $password
							
							);
		
		$data2 = array("id_data_pegawai" => $id_data_pegawai,							
							"nama_pengguna" => $nama_pengguna,
							"nip_pengguna" => $nip_pengguna,
							"jabatan" => $jabatan,
							"alamat" => $alamat,
							"no_telp" => $no_telp);
		// var_dump($data);					 
		// var_dump($data2);					 
		$hasil = $this->pengguna->getsimpanpenggunaedit($data);
		$hasil2 = $this->pengguna->getsimpanpegawaiedit($data2);
		$this->view->pengguna = $this->data_serv->getPilihPengguna($id_pengguna);
		//jika gagal
		if(($hasil=="gagal")||($hasil2=="gagal")){
			$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
			$this->render('home');			
		}
		//jika sukses
		if(($hasil=="sukses")||($hasil2=="sukses")){
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";
			$this->render('home');
		}
	}
		
		/////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////    PEMBERDAYAAN      /////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		//////////////////////////       1. SKTM RUMAH SAKIT
		
		/////// START RUMAH SAKIT
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
			
			
			//mendapatkan jumlah yang belum diproses dan selesai
			$jumlahstatus1 = $this->surat_serv->getJumlahStatusRumahsakit1();	
			if($jumlahstatus1>=1){		
				$peringatanstatus1 = "Ada $jumlahstatus1 surat yang belum diproses. Silakan tekan tombol proses";
			}
			$this->view->jumlahstatus1 = $jumlahstatus1;
			$this->view->peringatanstatus1 = $peringatanstatus1;
			
			$jumlahstatus2 = $this->surat_serv->getJumlahStatusRumahsakit2();
			if($jumlahstatus2>=1){
				$peringatanstatus2 = "Ada $jumlahstatus2 surat yang belum selesai. Silakan tekan tombol selesai";
			}
			$this->view->jumlahstatus2 = $jumlahstatus2;
			$this->view->peringatanstatus2 = $peringatanstatus2;
			
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
			$no_registrasi = $this->surat_serv->getNoRegistrasi(4,401); //4 adalah panjangnya, AN adalah kode huruf
			$this->view->no_registrasi=$no_registrasi;
			
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('rumahsakitantrian');
			
		}
		
		//menyimpan antrian rumahsakit
		public function simpanrumahsakitantrianAction(){
			if(isset($_POST['name'])){ 
				$id_kelurahan = $this->id_kelurahan;			
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->id_pengguna;		
				
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$waktu_antrian = date('H:i:s');
				$antrian_oleh = $nama_pengguna;
				$jam_masuk = date('H:i:s');
				$status = 1;
				$no_telp=$_POST['no_telp'];
				
				//simpan data ke tabel rumah sakit
				$data = array("id_pengguna" =>  	$id_pengguna,
				"id_kelurahan" => $id_kelurahan,
				"no_registrasi" => $no_registrasi,
				"nik" => $nik,
				"waktu_antrian" => $waktu_antrian,
				"antrian_oleh" => $antrian_oleh,
				"jam_masuk" => $jam_masuk,							
				"status" => $status,
				"no_telp"=> $no_telp
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
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_rumahsakit= $this->_getParam("id_permintaan_rumahsakit");
			$no_registrasi= $this->_getParam(no_registrasi);
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;		
			
			$waktu_antrian= $this->_getParam(waktu_antrian);
			//var_dump($waktu_antrian);
			$waktu_sekarang = date("H:i:s");
			$lama = $this->surat_serv->selisih($waktu_antrian,$waktu_sekarang);	
			$this->view->lama= $lama;
			
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->view->surat = "Form Isian Surat Keterangan Rumah Sakit";
			$this->render('rumahsakitproses');
		}
		
		public function simpanprosesrsAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->id_pengguna;
				
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
				$ket=$_POST['ket'];
				
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
				"proses_oleh" => $proses_oleh,
				"ket" => $ket
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
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
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
				if(!$hasil){
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
			if($hasil=='gagal'){
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
			$nama_pengguna = $this->id_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_rumahsakit= $this->_getParam("id_permintaan_rumahsakit");
			$nama= $this->_getParam("nama");
			$nik= $this->_getParam("nik");
			$no_surat= $this->_getParam("no_surat");
			$tanggal_surat= $this->_getParam("tanggal_surat");
			$nama_surat= "SKTM rumah sakit";
			$asal_controller= "rumahsakit";
			$no_registrasi= $this->_getParam("no_registrasi");
			$waktu_antrian= $this->_getParam("waktu_antrian");
			$status= 3;	
			
			//menghitung lama
			
			$waktu_selesai = date("H:i:s");
			$waktu_total = $this->surat_serv->selisih($waktu_antrian,$waktu_selesai);	
			
			
			$data = array("id_permintaan_rumahsakit" => $id_permintaan_rumahsakit,
			"status" => $status,
			"waktu_selesai" => $waktu_selesai,
			"waktu_total" => $waktu_total);
			
			$hasil = $this->surat_serv->getSelesaiRumahsakit($data);
			//var_dump($hasil);
			$this->view->asal_controller = $asal_controller;
			$this->view->render = $render;
			$this->view->nik = $nik;
			$this->view->nama = $nama;
			$this->view->no_surat = $no_surat;
			$this->view->tanggal_surat = $tanggal_surat;
			$this->view->nama_surat = $nama_surat;
			$this->view->surat = "Form Tambah Surat";
			$this->render('arsiptambah');			
			
			
			
		}
		///////////////// END 1. RUMAH SAKIT
		
		/////////////////////////////// 2. SKTM PENDIDIKAN
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
			$this->view->surat = "Surat Keterangan SKTM Pendidikan";
			$this->view->permintaan = $this->surat_serv->getProsesSekolah($this->id_kelurahan,$offset,$dataPerPage);
			
			//mendapatkan jumlah yang belum diproses dan selesai
			$jumlahstatus1 = $this->surat_serv->getJumlahStatusSekolah1();	
			if($jumlahstatus1>=1){		
				$peringatanstatus1 = "Ada $jumlahstatus1 surat yang belum diproses. Silakan tekan tombol proses";
			}
			$this->view->jumlahstatus1 = $jumlahstatus1;
			$this->view->peringatanstatus1 = $peringatanstatus1;
			
			$jumlahstatus2 = $this->surat_serv->getJumlahStatusSekolah2();
			if($jumlahstatus2>=1){
				$peringatanstatus2 = "Ada $jumlahstatus2 surat yang belum selesai. Silakan tekan tombol selesai";
			}
			$this->view->jumlahstatus2 = $jumlahstatus2;
			$this->view->peringatanstatus2 = $peringatanstatus2;		
			
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
				$this->view->surat = "Surat Keterangan SKTM Pendidikan";
				$this->view->cari = $pencarian;
				$this->view->permintaan = $this->surat_serv->getPencarianSekolah($this->id_kelurahan,$pencarian,$id_pencarian);
			}
			
		}
		public function caripenduduksekolahAction() {
			$this->view;
			$this->view->surat = "Form Isian Surat Keterangan SKTM Pendidikan";
			$this->view->judul = "Masukan NIK";
		}
		
		//antrian sekolah --> proses memasukan ke antrian sekolah, status = 1
		public function sekolahantrianAction(){
			$nik = $_POST['nik'];
			$this->view->surat = "Form Antrian Keterangan SKTM sekolah";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			
			//mengambil noregistrasi secara automatis
			$no_registrasi = $this->surat_serv->getNoRegistrasi(4,401); //4 adalah panjangnya, AN adalah kode huruf
			$this->view->no_registrasi=$no_registrasi;
			
			$this->render('sekolahantrian');
			
		}
		
		//menyimpan antrian sekolah
		public function simpansekolahantrianAction(){
			if(isset($_POST['name'])){ 
				$id_kelurahan = $this->id_kelurahan;			
				$id_pengguna = $this->id_pengguna;		
				$nama_pengguna = $this->id_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$waktu_antrian = date('H:i:s');
				$antrian_oleh = $nama_pengguna;
				$jam_masuk = date('H:i:s');
				$status = 1;
				$ket=$_POST['ket'];
				
				//simpan data ke tabel sekolah
				$data = array("id_pengguna" =>  	$id_pengguna,
				"id_kelurahan" => $id_kelurahan,
				"no_registrasi" => $no_registrasi,
				"nik" => $nik,
				"waktu_antrian" => $waktu_antrian,
				"antrian_oleh" => $antrian_oleh,
				"jam_masuk" => $jam_masuk,							
				"status" => $status,
				"no_telp" => $no_telp
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
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_sekolah= $this->_getParam("id_permintaan_sekolah");
			$no_registrasi= $this->_getParam(no_registrasi);
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;		
			
			$waktu_antrian= $this->_getParam(waktu_antrian);
			$waktu_sekarang = date("H:i:s");
			$lama = $this->surat_serv->selisih($waktu_antrian,$waktu_sekarang);	
			$this->view->lama= $lama;
			
			$this->view->surat = "Form Isian Surat Keterangan SKTM Pendidikan";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('sekolahproses');
		}
		
		public function simpanprosessekolahAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->id_pengguna;
				
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
				$ket = $_POST['ket'];
				
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
				"proses_oleh" => $proses_oleh,
				"ket" => $ket
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
			if($hasil=='gagal'){
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
			$this->view->surat = "Ubah Permintaan Surat Keterangan SKTM Pendidikan";
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
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
			if($hasil=='gagal'){
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
			$nama_pengguna = $this->id_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_sekolah= $this->_getParam("id_permintaan_sekolah");
			$nama= $this->_getParam("nama");
			$nik= $this->_getParam("nik");
			$no_surat= $this->_getParam("no_surat");
			$tanggal_surat= $this->_getParam("tanggal_surat");
			$nama_surat= "SKTM Sekolah";
			$asal_controller= "sekolah";
			$no_registrasi= $this->_getParam("no_registrasi");
			$waktu_antrian= $this->_getParam("waktu_antrian");
			$status= 3;
			
			//menghitung lama
			
			$waktu_selesai = date("H:i:s");
			$waktu_total = $this->surat_serv->selisih($waktu_antrian,$waktu_selesai);	
			
			
			
			$data = array("id_permintaan_sekolah" => $id_permintaan_sekolah,
			"status" => $status,
			"waktu_selesai" => $waktu_selesai,
			"waktu_total" => $waktu_total);
			
			$hasil = $this->surat_serv->getSelesaiSekolah($data);
			$this->view->asal_controller = $asal_controller;
			$this->view->render = $render;
			$this->view->nik = $nik;
			$this->view->nama = $nama;
			$this->view->no_surat = $no_surat;
			$this->view->tanggal_surat = $tanggal_surat;
			$this->view->nama_surat = $nama_surat;
			$this->view->surat = "Form Tambah Surat";
			$this->render('arsiptambah');		
			
		}
		////////////////////////////END 2. SKTM PENDIDIKAN
		
		
		////////////////////////////////////////// 3. ANDON NIKAH
		//cetak surat andonnikah
		public function andonnikahcetakAction(){
			$id_permintaan_andonnikah = $this->_getParam("id_permintaan_andonnikah");
			$this->view->hasil = $this->surat_serv->getandonnikahcetak($id_permintaan_andonnikah);
		}
		
		public function andonnikahAction(){
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			
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
			$jumlahstatus1 = $this->surat_serv->getJumlahStatusAndonnikah1();	
			if($jumlahstatus1>=1){		
				$peringatanstatus1 = "Ada $jumlahstatus1 surat yang belum diproses. Silakan tekan tombol proses";
			}
			$this->view->jumlahstatus1 = $jumlahstatus1;
			$this->view->peringatanstatus1 = $peringatanstatus1;
			
			$jumlahstatus2 = $this->surat_serv->getJumlahStatusAndonnikah2();
			if($jumlahstatus2>=1){
				$peringatanstatus2 = "Ada $jumlahstatus2 surat yang belum selesai. Silakan tekan tombol selesai";
			}
			$this->view->jumlahstatus2 = $jumlahstatus2;
			$this->view->peringatanstatus2 = $peringatanstatus2;
		}
		
		//fungsi searching di halaman andonnikah
		public function pencarianandonnikahAction(){
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			
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
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			
			$nik = $_POST['nik'];
			$this->view->surat = "Form Antrian Keterangan Andon Nikah";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			
			//mengambil noregistrasi secara automatis
			$no_registrasi = $this->surat_serv->getNoRegistrasi(4,474); //4 adalah panjangnya, AN adalah kode huruf
			$this->view->no_registrasi=$no_registrasi;
			
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('andonnikahantrian');
			
		}
		
		//menyimpan antrian andon nikah
		public function simpanandonnikahantrianAction(){
			if(isset($_POST['name'])){ 
				$id_kelurahan = $this->id_kelurahan;			
				$id_pengguna = $this->id_pengguna;		
				$nama_pengguna = $this->id_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$waktu_antrian = date('H:i:s');
				$antrian_oleh = $nama_pengguna;
				$jam_masuk = date('H:i:s');
				$status = 1;
				$no_telp=$_POST['no_telp'];
				//simpan data ke tabel andon nikah
				$data = array("id_pengguna" =>  	$id_pengguna,
								"id_kelurahan" => $id_kelurahan,
								"no_registrasi" => $no_registrasi,
								"nik" => $nik,
								"waktu_antrian" => $waktu_antrian,
								"antrian_oleh" => $antrian_oleh,
								"jam_masuk" => $jam_masuk,							
								"status" => $status,
								"no_telp" => $no_telp
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
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			$nik = $_POST['nik'];
			$hasil = $this->surat_serv->getCariPenduduk($nik);
			echo json_encode ($hasil);
		}
		
		public function andonnikahprosesAction(){
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->id_pengguna;
			
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_andonnikah= $this->_getParam("id_permintaan_andonnikah");
			$no_registrasi= $this->_getParam(no_registrasi);
			
			$waktu_antrian= $this->_getParam(waktu_antrian);
			$waktu_sekarang = date("H:i:s");
			$lama = $this->surat_serv->selisih($waktu_antrian,$waktu_sekarang);	
			
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;		
			$this->view->lama= $lama;		
			
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->nama_pengguna = $nama_pengguna;
			$this->view->hasil = $hasil;
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->view->surat = "Form Isian Surat Keterangan Andon Nikah";
			$this->render('andonnikahproses');
		}
		
		public function simpanprosesandonnikahAction(){
			if(isset($_POST['name'])){ 
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->id_pengguna;
				
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
				$no_surat_pengantar = strip_tags($_POST['no_surat_pengantar']);
				$tanggal_surat_pengantar = strip_tags($_POST['tanggal_surat_pengantar']);
				$nama_pasangan = strip_tags($_POST['nama_pasangan']);
				$alamat_pasangan = strip_tags($_POST['alamat_pasangan']);
				$status = 2;
				$ket = $_POST['ket'];
				
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
								"proses_oleh" => $proses_oleh,
								"ket" => $ket
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
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			
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
			$nama_pengguna = $this->id_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_andonnikah= $this->_getParam("id_permintaan_andonnikah");
			$nama= $this->_getParam("nama");
			$nik= $this->_getParam("nik");
			$no_surat= $this->_getParam("no_surat");
			$tanggal_surat= $this->_getParam("tanggal_surat");
			$nama_surat= "Keterangan Andonnikah";
			$asal_controller= "andonnikah";
			$no_registrasi= $this->_getParam("no_registrasi");
			$waktu_antrian= $this->_getParam("waktu_antrian");
			$status= 3;	
			
			//menghitung lama
			
			$waktu_selesai = date("H:i:s");
			$waktu_total = $this->surat_serv->selisih($waktu_antrian,$waktu_selesai);	
			
			$data = array("id_permintaan_andonnikah" => $id_permintaan_andonnikah,
							"status" => $status,
							"waktu_selesai" => $waktu_selesai,
							"waktu_total" => $waktu_total
						);
			
			$hasil = $this->surat_serv->getSelesaiAndonnikah($data);
			
			$this->view->asal_controller = $asal_controller;
			$this->view->render = $render;
			$this->view->nik = $nik;
			$this->view->nama = $nama;
			$this->view->no_surat = $no_surat;
			$this->view->tanggal_surat = $tanggal_surat;
			$this->view->nama_surat = $nama_surat;
			$this->view->surat = "Form Tambah Surat";
			$this->render('arsiptambah');
			
		}
		////// END 3. ANDON NIKAH
		
		////////////////////////////////////////// 4. KETERANGAN NIKAH
		//cetak surat na
		public function nacetakAction(){
			$id_permintaan_na = $this->_getParam("id_permintaan_na");
			$this->view->hasil = $this->surat_serv->getnacetak($id_permintaan_na);
		}
		
		public function naAction(){
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			
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
			$this->view->jumData = $this->surat_serv->getJumlahna($this->id_kelurahan);
			$this->view->dataPerPage = $dataPerPage;
			$this->view->noPage = $noPage;
			$this->view->offset=$offset;
			
			$id_surat = $this->_getParam("id_surat");
			$this->view->surat = "Surat Keterangan Nikah (NA)";		
			$this->view->permintaan = $this->surat_serv->getProsesna($this->id_kelurahan,$offset,$dataPerPage);
			
			//mendapatkan jumlah yang belum diproses dan selesai
			$jumlahstatus1 = $this->surat_serv->getJumlahStatusna1();	
			if($jumlahstatus1>=1){		
				$peringatanstatus1 = "Ada $jumlahstatus1 surat yang belum diproses. Silakan tekan tombol proses";
			}
			$this->view->jumlahstatus1 = $jumlahstatus1;
			$this->view->peringatanstatus1 = $peringatanstatus1;
			
			$jumlahstatus2 = $this->surat_serv->getJumlahStatusna2();
			if($jumlahstatus2>=1){
				$peringatanstatus2 = "Ada $jumlahstatus2 surat yang belum selesai. Silakan tekan tombol selesai";
			}
			$this->view->jumlahstatus2 = $jumlahstatus2;
			$this->view->peringatanstatus2 = $peringatanstatus2;
		}
		
		//fungsi searching di halaman na
		public function pencariannaAction(){
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			
			$this->view;
			$this->view->kelurahan = $this->id_kelurahan;
			$this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			$id_pencarian = $_POST['id_pencarian'];
			$pencarian = $_POST['pencarian'];
			if(!$pencarian){
				$this->naAction();
				$this->render('na');
				}else{
				$this->view->surat = "Surat Andon Nikah";
				$this->view->cari = $pencarian;
				$this->view->permintaan = $this->surat_serv->getPencarianna($this->id_kelurahan,$pencarian,$id_pencarian);
			}
			
		}
		
		//pencarian na berdasarkan nik
		public function caripenduduknaAction() {
			$this->view;
			$this->view->surat = "Silakan cari data penduduk berdasarkan NIK";
			$this->view->judul = "Masukan NIK";
		}
		
		//antrian na --> proses memasukan ke antrian andonikah, status = 1
		public function naantrianAction(){
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			
			$nik = $_POST['nik'];
			$this->view->surat = "Form Antrian Keterangan Andon Nikah";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			
			//mengambil noregistrasi secara automatis
			$no_registrasi = $this->surat_serv->getNoRegistrasi(4,"474.2"); //4 adalah panjangnya, AN adalah kode huruf
			$this->view->no_registrasi=$no_registrasi;
			
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('naantrian');
			
		}
		
		//menyimpan antrian andon nikah
		public function simpannaantrianAction(){
			if(isset($_POST['name'])){ 
				$id_kelurahan = $this->id_kelurahan;			
				$id_pengguna = $this->id_pengguna;		
				$nama_pengguna = $this->id_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$waktu_antrian = date('H:i:s');
				$antrian_oleh = $nama_pengguna;
				$jam_masuk = date('H:i:s');
				$status = 1;
				$no_telp=$_POST['no_telp'];
				//simpan data ke tabel andon nikah
				$data = array("id_pengguna" =>  	$id_pengguna,
								"id_kelurahan" => $id_kelurahan,
								"no_registrasi" => $no_registrasi,
								"nik" => $nik,
								"waktu_antrian" => $waktu_antrian,
								"antrian_oleh" => $antrian_oleh,
								"jam_masuk" => $jam_masuk,							
								"status" => $status,
								"no_telp" => $no_telp
								);										 
				$hasil = $this->surat_serv->getsimpannaantrian($data);
				
				//simpan data ke tabel no_registrasi
				$registrasi = array("no_registrasi" =>  	$no_registrasi,
									"nik" => $nik							
									);										 
				$hasil = $this->surat_serv->getSimpanNoRegistrasi($registrasi);
				
				
				//jika gagal
				if($hasil=="gagal"){
					$this->view->peringatan ="<div class='gagal'>$hasil. Maaf ada kesalahan;</div>";
					$this->naAction();
					$this->render('na');					
				}
				//jika sukses
				if($hasil=="sukses"){
					$this->view->peringatan ="<div class='sukses'> Sukses, data berhasil ditambahkan ke antrian </div>";		
					$this->naAction();
					$this->render('na');
				}	
				}else{
				$this->naAction();
				$this->render('na');
			}
			
		}
		
		public function permintaancarinaAction(){
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			$nik = $_POST['nik'];
			$hasil = $this->surat_serv->getCariPenduduk($nik);
			echo json_encode ($hasil);
		}
		
		public function naprosesAction(){
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->id_pengguna;
			
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_na= $this->_getParam("id_permintaan_na");
			$no_registrasi= $this->_getParam(no_registrasi);
			
			$waktu_antrian= $this->_getParam(waktu_antrian);
			$waktu_sekarang = date("H:i:s");
			$lama = $this->surat_serv->selisih($waktu_antrian,$waktu_sekarang);	
			
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;		
			$this->view->lama= $lama;		
			
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->nama_pengguna = $nama_pengguna;
			$this->view->hasil = $hasil;
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->view->surat = "Form Isian Surat Keterangan Andon Nikah";
			$this->render('naproses');
		}
		
		public function simpanprosesnaAction(){
			if(isset($_POST['name'])){ 
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->id_pengguna;
				
				$waktu_proses = date("H:i:s");
				$proses_oleh= $nama_pengguna;
				
				$id_kelurahan = $this->id_kelurahan;
				$id_permintaan_na = $_POST['id_permintaan_na'];
				$id_jenis_surat = $_POST['id_jenis_surat'];
				$id_surat = $_POST['id_surat'];
				$nik = $_POST['nik'];
				$id_pejabat = $_POST['id_pejabat'];
				$no_surat = $_POST['no_surat'];
				$tanggal_surat = $_POST['tanggal_surat'];
				$no_surat_pengantar = strip_tags($_POST['no_surat_pengantar']);
				$tanggal_surat_pengantar = strip_tags($_POST['tanggal_surat_pengantar']);
				$nama_pasangan = strip_tags($_POST['nama_pasangan']);
				$alamat_pasangan = strip_tags($_POST['alamat_pasangan']);
				$status = 2;
				$ket = $_POST['ket'];
				
				$data = array("id_kelurahan" =>  $id_kelurahan,
								"id_permintaan_na" => $id_permintaan_na,
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
								"proses_oleh" => $proses_oleh,
								"ket" => $ket
								);
				
				$hasil = $this->surat_serv->getsimpanprosesna($data);
				// var_dump($hasil);
				// var_dump($data);
				//jika gagal
				if($hasil=='gagal'){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
					$this->naAction();
					$this->render('na');					
				}
				//jika sukses
				if($hasil=='sukses'){
					$this->view->peringatan ="<div class='sukses'> $hasil </div>";		
					$this->naAction();
					$this->render('na');	
				}
				}else{
				$this->naAction();
				$this->render('na');
			}
			
		}
		
		
		public function nahapusAction(){
			$id_permintaan_na= $this->_getParam("id_permintaan_na");
			$hasil = $this->surat_serv->gethapusna($id_permintaan_na);
			//jika gagal
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->naAction();
				$this->render('na');					
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
				$this->naAction();
				$this->render('na');	
			}
		}
		public function naeditAction(){
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			
			$id_permintaan_na = $this->_getParam("id_permintaan_na");
			$this->view->surat = "Ubah Permintaan Surat Keterangan Andon Nikah";
			$this->view->hasil = $this->surat_serv->getna($id_permintaan_na);
		}
		
		public function simpanprosesnaeditAction(){
			$id_permintaan_na = $this->_getParam('id_permintaan_na');
			$id_kelurahan = $this->id_kelurahan;
			$nik = $_POST['nik'];
			$no_surat = $_POST['no_surat'];
			$tanggal_surat = $_POST['tanggal_surat'];
			$no_surat_pengantar = $_POST['no_surat_pengantar'];
			$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
			$nama_pasangan = $_POST['nama_pasangan'];
			$alamat_pasangan = $_POST['alamat_pasangan'];
			
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
							"id_permintaan_na" => $id_permintaan_na,
							"nik" => $nik,
							"no_surat" => $no_surat,
							"tanggal_surat" => $tanggal_surat,
							"no_surat_pengantar" => $no_surat_pengantar,
							"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
							"nama_pasangan" => $nama_pasangan,
							"alamat_pasangan" => $alamat_pasangan,
						);
			
			$hasil = $this->surat_serv->getsimpanprosesnaedit($data);
			//jika gagal
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->naAction();
				$this->render('na');				
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
				$this->naAction();
				$this->render('na');
			}
		}
		
		//proses selesai
		public function naselesaiAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->id_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_na= $this->_getParam("id_permintaan_na");
			$nama= $this->_getParam("nama");
			$nik= $this->_getParam("nik");
			$no_surat= $this->_getParam("no_surat");
			$tanggal_surat= $this->_getParam("tanggal_surat");
			$nama_surat= "Keterangan na";
			$asal_controller= "na";
			$no_registrasi= $this->_getParam("no_registrasi");
			$waktu_antrian= $this->_getParam("waktu_antrian");
			$status= 3;	
			
			//menghitung lama
			
			$waktu_selesai = date("H:i:s");
			$waktu_total = $this->surat_serv->selisih($waktu_antrian,$waktu_selesai);	
			
			$data = array("id_permintaan_na" => $id_permintaan_na,
							"status" => $status,
							"waktu_selesai" => $waktu_selesai,
							"waktu_total" => $waktu_total
						);
			
			$hasil = $this->surat_serv->getSelesaina($data);
			
			$this->view->asal_controller = $asal_controller;
			$this->view->render = $render;
			$this->view->nik = $nik;
			$this->view->nama = $nama;
			$this->view->no_surat = $no_surat;
			$this->view->tanggal_surat = $tanggal_surat;
			$this->view->nama_surat = $nama_surat;
			$this->view->surat = "Form Tambah Surat";
			$this->render('arsiptambah');
			
		}
		/////////////////END 4. KETERANGAN NIKAH 
		
		
		
		////////////////////////////////// ARSIP
		public function simpanarsipAction(){
	
			 $asal_controller = $_POST['asal_controller'];
			 $render = $_POST['render'];
			 $nik = $_POST['nik'];
			 $nama_surat = $_POST['nama_surat'];
			 $no_surat = $_POST['no_surat'];
			 $tanggal_surat = $_POST['tanggal_surat'];
			 $ruangan = $_POST['ruangan'];
			 $lemari = $_POST['lemari'];
			 $rak = $_POST['rak'];
			 $kotak = $_POST['kotak'];
				 
			
			 
			$allowed_ext    = array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf', 'rar', 'zip','png','jpg','jpeg');
			$file_name        = $_FILES['data_file']['name'];
			$value = explode(".", $file_name);
			$file_ext = strtolower(array_pop($value));			
		//	$file_ext        = strtolower(end(explode('.', $file_name)));
			$pecah        	=  explode('.', $file_name);
			$nama_file        =  $pecah[0];
			$file_size        = $_FILES['data_file']['size'];
			$file_tmp        = $_FILES['data_file']['tmp_name'];

			$nama            = $nama_surat;
			$tgl            = date("Y-m-d");
			
			if(in_array($file_ext, $allowed_ext) === true){
                    if($file_size < 2044070){
                        $lokasi = '../etc/data/upload/'.$nama_file.'.'.$file_ext;
                        move_uploaded_file($file_tmp, $lokasi);
						$lokasi2='etc/data/upload/'.$nama_file.'.'.$file_ext;
						$data = array("nik" => $nik,
							"nama_surat" => $nama_surat,
							"no_surat" => $no_surat,
							"tanggal_surat" => $tanggal_surat,
							"ruangan" => $ruangan,
							"lemari" => $lemari,
							"rak" => $rak,
							"kotak" => $kotak,
							"data_file" => $file_name,
							"path_file" => $lokasi2
						);
						
				 
						$hasil = $this->surat_serv->getsimpanarsip($data);
						// var_dump ($hasil);
					
						//jika berasal dari andonnikah
						if( $asal_controller=='andonnikah'){
						//jika gagal
							if($hasil == 'gagal'){
								$this->view->peringatan ="<div class='gagal'> $hasil. Maaf ada kesalahan </div>";
								$this->andonnikahAction();
								$this->render('andonnikah');	
							}
								//jika sukses
							if($hasil == 'sukses'){
								$this->view->peringatan ="<div class='sukses'> Sukses! $nama_surat. data berhasil ditambahkan </div>";		
								$this->andonnikahAction();
								$this->render('andonnikah');
							}
						}
						
						//jika berasal dari sekolah
						if( $asal_controller=='sekolah'){
							if($hasil == 'gagal'){
								$this->view->peringatan ="<div class='gagal'> $hasil. Maaf ada kesalahan </div>";
								$this->sekolahAction();
								$this->render('sekolah');	
							}
								//jika sukses
							if($hasil == 'sukses'){
								$this->view->peringatan ="<div class='sukses'> Sukses! $nama_surat. data berhasil ditambahkan </div>";		
								$this->sekolahAction();
								$this->render('sekolah');
							}
						}
						
						//jika berasal dari rumahsakit
						if( $asal_controller=='rumahsakit'){
							if($hasil == 'gagal'){
								$this->view->peringatan ="<div class='gagal'> $hasil. Maaf ada kesalahan </div>";
								$this->rumahsakitAction();
								$this->render('rumahsakit');	
							}
								//jika sukses
							if($hasil == 'sukses'){
								$this->view->peringatan ="<div class='sukses'> Sukses! $nama_surat. data berhasil ditambahkan </div>";		
								$this->rumahsakitAction();
								$this->render('rumahsakit');
							}
						}
						
						//jika berasal dari belummenikah
						if( $asal_controller=='belummenikah'){
							if($hasil == 'gagal'){
								$this->view->peringatan ="<div class='gagal'> $hasil. Maaf ada kesalahan </div>";
								$this->belummenikahAction();
								$this->render('belummenikah');	
							}
								//jika sukses
							if($hasil == 'sukses'){
								$this->view->peringatan ="<div class='sukses'> Sukses! $nama_surat. data berhasil ditambahkan </div>";		
								$this->belummenikahAction();
								$this->render('belummenikah');
							}
						}
						
						//jika berasal dari bpr
						if( $asal_controller=='bpr'){
							if($hasil == 'gagal'){
								$this->view->peringatan ="<div class='gagal'> $hasil. Maaf ada kesalahan </div>";
								$this->bprAction();
								$this->render('bpr');	
							}
								//jika sukses
							if($hasil == 'sukses'){
								$this->view->peringatan ="<div class='sukses'> Sukses! $nama_surat. data berhasil ditambahkan </div>";		
								$this->bprAction();
								$this->render('bpr');
							}
						}
						
						//jika berasal dari ibadahhaji
						if( $asal_controller=='ibadahhaji'){
							if($hasil == 'gagal'){
								$this->view->peringatan ="<div class='gagal'> $hasil. Maaf ada kesalahan </div>";
								$this->ibadahhajiAction();
								$this->render('ibadahhaji');	
							}
								//jika sukses
							if($hasil == 'sukses'){
								$this->view->peringatan ="<div class='sukses'> Sukses! $nama_surat. data berhasil ditambahkan </div>";		
								$this->ibadahhajiAction();
								$this->render('ibadahhaji');
							}
						}
						
						//jika berasal dari janda
						if( $asal_controller=='janda'){
							if($hasil == 'gagal'){
								$this->view->peringatan ="<div class='gagal'> $hasil. Maaf ada kesalahan </div>";
								$this->jandaAction();
								$this->render('janda');	
							}
								//jika sukses
							if($hasil == 'sukses'){
								$this->view->peringatan ="<div class='sukses'> Sukses! $nama_surat. data berhasil ditambahkan </div>";		
								$this->jandaAction();
								$this->render('janda');
							}
						}
						
						//jika berasal dari ik
						if( $asal_controller=='ik'){
							if($hasil == 'gagal'){
								$this->view->peringatan ="<div class='gagal'> $hasil. Maaf ada kesalahan </div>";
								$this->ikAction();
								$this->render('ik');	
							}
								//jika sukses
							if($hasil == 'sukses'){
								$this->view->peringatan ="<div class='sukses'> Sukses! $nama_surat. data berhasil ditambahkan </div>";		
								$this->ikAction();
								$this->render('ik');
							}
						}
						
						//jika berasal dari ps
						if( $asal_controller=='ps'){
							if($hasil == 'gagal'){
								$this->view->peringatan ="<div class='gagal'> $hasil. Maaf ada kesalahan </div>";
								$this->psAction();
								$this->render('ps');	
							}
								//jika sukses
							if($hasil == 'sukses'){
								$this->view->peringatan ="<div class='sukses'> Sukses! $nama_surat. data berhasil ditambahkan </div>";		
								$this->psAction();
								$this->render('ps');
							}
						}
						
						//jika berasal dari bd
						if( $asal_controller=='bd'){
							if($hasil == 'gagal'){
								$this->view->peringatan ="<div class='gagal'> $hasil. Maaf ada kesalahan </div>";
								$this->bdAction();
								$this->render('bd');	
							}
								//jika sukses
							if($hasil == 'sukses'){
								$this->view->peringatan ="<div class='sukses'> Sukses! $nama_surat. data berhasil ditambahkan </div>";		
								$this->bdAction();
								$this->render('bd');
							}
						}
						
						//jika berasal dari domisiliyayasan
						if( $asal_controller=='domisiliyayasan'){
							if($hasil == 'gagal'){
								$this->view->peringatan ="<div class='gagal'> $hasil. Maaf ada kesalahan </div>";
								$this->domisiliyayasanAction();
								$this->render('domisiliyayasan');	
							}
								//jika sukses
							if($hasil == 'sukses'){
								$this->view->peringatan ="<div class='sukses'> Sukses! $nama_surat. data berhasil ditambahkan </div>";		
								$this->domisiliyayasanAction();
								$this->render('domisiliyayasan');
							}
						}
						
						//jika berasal dari domisiliparpol
						if( $asal_controller=='domisiliparpol'){
							if($hasil == 'gagal'){
								$this->view->peringatan ="<div class='gagal'> $hasil. Maaf ada kesalahan </div>";
								$this->domisiliparpolAction();
								$this->render('domisiliparpol');	
							}
								//jika sukses
							if($hasil == 'sukses'){
								$this->view->peringatan ="<div class='sukses'> Sukses! $nama_surat. data berhasil ditambahkan </div>";		
								$this->domisiliparpolAction();
								$this->render('domisiliparpol');
							}
						}
						
						//jika berasal dari domisiliperusahaan
						if( $asal_controller=='domisiliperusahaan'){
							if($hasil == 'gagal'){
								$this->view->peringatan ="<div class='gagal'> $hasil. Maaf ada kesalahan </div>";
								$this->domisiliperusahaanAction();
								$this->render('domisiliperusahaan');	
							}
								//jika sukses
							if($hasil == 'sukses'){
								$this->view->peringatan ="<div class='sukses'> Sukses! $nama_surat. data berhasil ditambahkan </div>";		
								$this->domisiliperusahaanAction();
								$this->render('domisiliperusahaan');
							}
						}
						
						//jika berasal dari keterangantempatusaha
						if( $asal_controller=='keterangantempatusaha'){
							if($hasil == 'gagal'){
								$this->view->peringatan ="<div class='gagal'> $hasil. Maaf ada kesalahan </div>";
								$this->keterangantempatusahaAction();
								$this->render('keterangantempatusaha');	
							}
								//jika sukses
							if($hasil == 'sukses'){
								$this->view->peringatan ="<div class='sukses'> Sukses! $nama_surat. data berhasil ditambahkan </div>";		
								$this->keterangantempatusahaAction();
								$this->render('keterangantempatusaha');
							}
						}
						
						//jika berasal dari mati
						if( $asal_controller=='mati'){
							if($hasil == 'gagal'){
								$this->view->peringatan ="<div class='gagal'> $hasil. Maaf ada kesalahan </div>";
								$this->matiAction();
								$this->render('mati');	
							}
								//jika sukses
							if($hasil == 'sukses'){
								$this->view->peringatan ="<div class='sukses'> Sukses! $nama_surat. data berhasil ditambahkan </div>";		
								$this->matiAction();
								$this->render('mati');
							}
						}
						
						//jika berasal dari lahir
						if( $asal_controller=='lahir'){
							if($hasil == 'gagal'){
								$this->view->peringatan ="<div class='gagal'> $hasil. Maaf ada kesalahan </div>";
								$this->lahirAction();
								$this->render('lahir');	
							}
								//jika sukses
							if($hasil == 'sukses'){
								$this->view->peringatan ="<div class='sukses'> Sukses! $nama_surat. data berhasil ditambahkan </div>";		
								$this->lahirAction();
								$this->render('lahir');
							}
						}
                    }else{ // maksimal file tidak diijinkan
                       //jika berasal dari andonnikah
						if( $asal_controller=='andonnikah'){
							$this->view->peringatan ="<div class='gagal'> ERROR: Besar ukuran file (file size) maksimal 2 Mb! </div>";
							$this->andonnikahAction();
							$this->render('andonnikah');	
						}
						
						//jika berasal dari sekolah
						if( $asal_controller=='sekolah'){
							$this->view->peringatan ="<div class='gagal'> ERROR: Besar ukuran file (file size) maksimal 2 Mb! </div>";
							$this->sekolahAction();
							$this->render('sekolah');
						}
						
						//jika berasal dari rumahsakit
						if( $asal_controller=='rumahsakit'){
							$this->view->peringatan ="<div class='gagal'> ERROR: Besar ukuran file (file size) maksimal 2 Mb! </div>";
							$this->rumahsakitAction();
							$this->render('rumahsakit');
						}
						
						//jika berasal dari belummenikah
						if( $asal_controller=='belummenikah'){
							$this->view->peringatan ="<div class='gagal'> ERROR: Besar ukuran file (file size) maksimal 2 Mb! </div>";
							$this->belummenikahAction();
							$this->render('belummenikah');	
						}
						
						//jika berasal dari bpr
						if( $asal_controller=='bpr'){
							$this->view->peringatan ="<div class='gagal'> ERROR: Besar ukuran file (file size) maksimal 2 Mb! </div>";
							$this->bprAction();
							$this->render('bpr');	
						}
						
						//jika berasal dari ibadahhaji
						if( $asal_controller=='ibadahhaji'){
							$this->view->peringatan ="<div class='gagal'> ERROR: Besar ukuran file (file size) maksimal 2 Mb! </div>";
							$this->ibadahhajiAction();
							$this->render('ibadahhaji');
						}
						
						//jika berasal dari janda
						if( $asal_controller=='janda'){
							$this->view->peringatan ="<div class='gagal'> ERROR: Besar ukuran file (file size) maksimal 2 Mb! </div>";
							$this->jandaAction();
							$this->render('janda');	
						}
						
						//jika berasal dari ik
						if( $asal_controller=='ik'){
							$this->view->peringatan ="<div class='gagal'> ERROR: Besar ukuran file (file size) maksimal 2 Mb! </div>";
							$this->ikAction();
							$this->render('ik');	
						}
						
						//jika berasal dari ps
						if( $asal_controller=='ps'){
							$this->view->peringatan ="<div class='gagal'> ERROR: Besar ukuran file (file size) maksimal 2 Mb! </div>";
							$this->psAction();
							$this->render('ps');	
						}
						
						//jika berasal dari bd
						if( $asal_controller=='bd'){
							$this->view->peringatan ="<div class='gagal'> ERROR: Besar ukuran file (file size) maksimal 2 Mb! </div>";
							$this->bdAction();
							$this->render('bd');
						}
						
						//jika berasal dari domisiliyayasan
						if( $asal_controller=='domisiliyayasan'){
							$this->view->peringatan ="<div class='gagal'> ERROR: Besar ukuran file (file size) maksimal 2 Mb! </div>";
							$this->domisiliyayasanAction();
							$this->render('domisiliyayasan');	
						}
						
						//jika berasal dari domisiliparpol
						if( $asal_controller=='domisiliparpol'){
							$this->view->peringatan ="<div class='gagal'> ERROR: Besar ukuran file (file size) maksimal 2 Mb! </div>";
							$this->domisiliparpolAction();
							$this->render('domisiliparpol');						
						}
						
						
						//jika berasal dari domisiliperusahaan
						if( $asal_controller=='domisiliperusahaan'){
							$this->view->peringatan ="<div class='gagal'> ERROR: Besar ukuran file (file size) maksimal 2 Mb! </div>";
							$this->domisiliperusahaanAction();
							$this->render('domisiliperusahaan');	
							}
							
						//jika berasal dari keterangantempatusaha
						if( $asal_controller=='keterangantempatusaha'){
							$this->view->peringatan ="<div class='gagal'> ERROR: Besar ukuran file (file size) maksimal 2 Mb! </div>";
							$this->keterangantempatusahaAction();
							$this->render('keterangantempatusaha');	
						}
						
						//jika berasal dari mati
						if( $asal_controller=='mati'){
							$this->view->peringatan ="<div class='gagal'> ERROR: Besar ukuran file (file size) maksimal 2 Mb! </div>";
							$this->matiAction();
							$this->render('mati');					
						}
						
						//jika berasal dari lahir
						if( $asal_controller=='lahir'){
							$this->view->peringatan ="<div class='gagal'> ERROR: Besar ukuran file (file size) maksimal 2 Mb! </div>";
							$this->lahirAction();
							$this->render('lahir');							
						}
						
						//jika berasal dari serbaguna
						if( $asal_controller=='serbaguna'){
							$this->view->peringatan ="<div class='gagal'> ERROR: Besar ukuran file (file size) maksimal 2 Mb! </div>";
							$this->serbagunaAction();
							$this->render('serbaguna');							
						}
						
					
					
					}//end maksimal file tidak dizinkan
                }else{// extensi file tidak diijinkan
                     //jika berasal dari andonnikah
						if( $asal_controller=='andonnikah'){
							$this->view->peringatan ="<div class='gagal'> ERROR: Ekstensi file tidak di izinkan! </div>";
							$this->andonnikahAction();
							$this->render('andonnikah');	
						}
						
						//jika berasal dari sekolah
						if( $asal_controller=='sekolah'){
							$this->view->peringatan ="<div class='gagal'> ERROR: Ekstensi file tidak di izinkan! </div>";
							$this->sekolahAction();
							$this->render('sekolah');
						}
						
						//jika berasal dari rumahsakit
						if( $asal_controller=='rumahsakit'){
							$this->view->peringatan ="<div class='gagal'> ERROR: Ekstensi file tidak di izinkan! </div>";
							$this->rumahsakitAction();
							$this->render('rumahsakit');
						}
						
						//jika berasal dari belummenikah
						if( $asal_controller=='belummenikah'){
							$this->view->peringatan ="<div class='gagal'> ERROR: Ekstensi file tidak di izinkan! </div>";
							$this->belummenikahAction();
							$this->render('belummenikah');	
						}
						
						//jika berasal dari bpr
						if( $asal_controller=='bpr'){
							$this->view->peringatan ="<div class='gagal'> ERROR: Ekstensi file tidak di izinkan! </div>";
							$this->bprAction();
							$this->render('bpr');	
						}
						
						//jika berasal dari ibadahhaji
						if( $asal_controller=='ibadahhaji'){
							$this->view->peringatan ="<div class='gagal'> ERROR: Ekstensi file tidak di izinkan! </div>";
							$this->ibadahhajiAction();
							$this->render('ibadahhaji');
						}
						
						//jika berasal dari janda
						if( $asal_controller=='janda'){
						$this->view->peringatan ="<div class='gagal'> ERROR: Ekstensi file tidak di izinkan! </div>";
							$this->jandaAction();
							$this->render('janda');	
						}
						
						//jika berasal dari ik
						if( $asal_controller=='ik'){
							$this->view->peringatan ="<div class='gagal'> ERROR: Ekstensi file tidak di izinkan! </div>";
							$this->ikAction();
							$this->render('ik');	
						}
						
						//jika berasal dari ps
						if( $asal_controller=='ps'){
							$this->view->peringatan ="<div class='gagal'> ERROR: Ekstensi file tidak di izinkan! </div>";
							$this->psAction();
							$this->render('ps');	
						}
						
						//jika berasal dari bd
						if( $asal_controller=='bd'){
							$this->view->peringatan ="<div class='gagal'> ERROR: Ekstensi file tidak di izinkan! </div>";
							$this->bdAction();
							$this->render('bd');
						}
						
						//jika berasal dari domisiliyayasan
						if( $asal_controller=='domisiliyayasan'){
							$this->view->peringatan ="<div class='gagal'> ERROR: Ekstensi file tidak di izinkan! </div>";
							$this->domisiliyayasanAction();
							$this->render('domisiliyayasan');	
						}
						
						//jika berasal dari domisiliparpol
						if( $asal_controller=='domisiliparpol'){
							$this->view->peringatan ="<div class='gagal'> ERROR: Ekstensi file tidak di izinkan! </div>";
							$this->domisiliparpolAction();
							$this->render('domisiliparpol');						
						}
						
						
						//jika berasal dari domisiliperusahaan
						if( $asal_controller=='domisiliperusahaan'){
							$this->view->peringatan ="<div class='gagal'> ERROR: Ekstensi file tidak di izinkan! </div>";
							$this->domisiliperusahaanAction();
							$this->render('domisiliperusahaan');	
							}
							
						//jika berasal dari keterangantempatusaha
						if( $asal_controller=='keterangantempatusaha'){
							$this->view->peringatan ="<div class='gagal'> ERROR: Ekstensi file tidak di izinkan! </div>";
							$this->keterangantempatusahaAction();
							$this->render('keterangantempatusaha');	
						}
						
						//jika berasal dari mati
						if( $asal_controller=='mati'){
							$this->view->peringatan ="<div class='gagal'> ERROR: Ekstensi file tidak di izinkan! </div>";
							$this->matiAction();
							$this->render('mati');					
						}
						
						//jika berasal dari lahir
						if( $asal_controller=='lahir'){
							$this->view->peringatan ="<div class='gagal'> ERROR: Ekstensi file tidak di izinkan! </div>";
							$this->lahirAction();
							$this->render('lahir');							
						}
						
						//jika berasal dari serbaguna
						if( $asal_controller=='serbaguna'){
							$this->view->peringatan ="<div class='gagal'> ERROR: Ekstensi file tidak di izinkan! </div>";
							$this->serbagunaAction();
							$this->render('serbaguna');							
						}
						
						
                } //end extensi
            
			
		
				
	}	
	//// END  ARSIP
		
		
		///////////////////////////////// 5. Belum Pernah Menikah
		//cetak surat belummenikah
		public function belummenikahcetakAction(){
			$id_permintaan_belummenikah = $this->_getParam("id_permintaan_belummenikah");
			$this->view->hasil = $this->surat_serv->getbelummenikahcetak($id_permintaan_belummenikah);
		}
		
		public function belummenikahAction(){
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			
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
			$this->view->surat = "Surat Keterangan Belum Pernah Menikah";
			$this->view->permintaan = $this->surat_serv->getProsesBelumMenikah($this->id_kelurahan,$offset,$dataPerPage);
			
			//mendapatkan jumlah yang belum diproses dan selesai
			$jumlahstatus1 = $this->surat_serv->getJumlahStatusbelummenikah1();	
			if($jumlahstatus1>=1){		
				$peringatanstatus1 = "Ada $jumlahstatus1 surat yang belum diproses. Silakan tekan tombol proses";
			}
			$this->view->jumlahstatus1 = $jumlahstatus1;
			$this->view->peringatanstatus1 = $peringatanstatus1;
			
			$jumlahstatus2 = $this->surat_serv->getJumlahStatusbelummenikah2();
			if($jumlahstatus2>=1){
				$peringatanstatus2 = "Ada $jumlahstatus2 surat yang belum selesai. Silakan tekan tombol selesai";
			}
			$this->view->jumlahstatus2 = $jumlahstatus2;
			$this->view->peringatanstatus2 = $peringatanstatus2;
		}
		public function pencarianbelummenikahAction(){
				$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
				
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
				$this->view->surat = "Surat Keterangan Belum Pernah Menikah";
				$this->view->cari = $pencarian;
				$this->view->permintaan = $this->surat_serv->getPencarianBelumMenikah($this->id_kelurahan,$pencarian,$id_pencarian);
			}
			
		}
		public function caripendudukbelummenikahAction() {
			$this->view;
			$this->view->surat = "Form Isian Surat Keterangan Belum Pernah Menikah";
			$this->view->judul = "Masukan NIK";
		}
		
		//antrian Belum Pernah Menikah --> proses memasukan ke antrian Belum Pernah Menikah, status = 1
		public function belummenikahantrianAction(){
			
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			$nik = $_POST['nik'];
			$this->view->surat = "Form Antrian Keterangan Belum Pernah Menikah";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			
			//mengambil noregistrasi secara automatis
			$no_registrasi = $this->surat_serv->getNoRegistrasi(4,470); //4 adalah panjangnya, AN adalah kode huruf
			$this->view->no_registrasi=$no_registrasi;
			
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('belummenikahantrian');
			
		}
		
		//menyimpan antrian belummenikah
		public function simpanbelummenikahantrianAction(){
			if(isset($_POST['name'])){ 
				$id_kelurahan = $this->id_kelurahan;			
				$id_pengguna = $this->id_pengguna;		
				$nama_pengguna = $this->id_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$waktu_antrian = date('H:i:s');
				$antrian_oleh = $nama_pengguna;
				$jam_masuk = date('H:i:s');
				$status = 1;
				$no_telp=$_POST['no_telp'];
				
				//simpan data ke tabel andon nikah
				$data = array("id_pengguna" =>  	$id_pengguna,
					"id_kelurahan" => $id_kelurahan,
					"no_registrasi" => $no_registrasi,
					"nik" => $nik,
					"waktu_antrian" => $waktu_antrian,
					"antrian_oleh" => $antrian_oleh,
					"jam_masuk" => $jam_masuk,							
					"status" => $status,
					"no_telp" => $no_telp
				);										 
				$hasil = $this->surat_serv->getsimpanbelummenikahantrian($data);
				
				//simpan data ke tabel no_registrasi
				$registrasi = array("no_registrasi" =>  	$no_registrasi,
				"nik" => $nik							
				);										 
				$hasil2 = $this->surat_serv->getSimpanNoRegistrasi($registrasi);
				
				// var_dump($registrasi);
				// var_dump($hasil2);
				
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
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
		
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_belummenikah= $this->_getParam("id_permintaan_belummenikah");
			$no_registrasi= $this->_getParam(no_registrasi);
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;
			
			$waktu_antrian= $this->_getParam(waktu_antrian);
			$waktu_sekarang = date("H:i:s");
			$lama = $this->surat_serv->selisih($waktu_antrian,$waktu_sekarang);	
			$this->view->lama= $lama;
			
			
			$this->view->surat = "Form Isian Surat Keterangan Belum Pernah Menikah";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
		}
		public function simpanprosesbelummenikahAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->id_pengguna;
				
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
				$ket = $_POST['ket'];
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
							"proses_oleh" => $proses_oleh,
							"ket" => $ket
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
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->belummenikahAction();
				$this->render('belummenikah');				
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
				$this->belummenikahAction();
				$this->render('belummenikah');	
			}
		}
		public function belummenikaheditAction(){
			$id_permintaan_belummenikah = $this->_getParam("id_permintaan_belummenikah");
			$this->view->surat = "Ubah Permintaan Surat Keterangan Belum Pernah Menikah";
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
			
			
			$data = array("	id_kelurahan" 					=> $id_kelurahan,
							"id_permintaan_belummenikah" 	=> $id_permintaan_belummenikah,
							"nik" 							=> $nik,
							"no_surat" 						=> $no_surat,
							"tanggal_surat" 				=> $tanggal_surat,
							"no_surat_pengantar" 			=> $no_surat_pengantar,
							"tanggal_surat_pengantar" 		=> $tanggal_surat_pengantar,
							"keperluan"						=> $keperluan
						);
			
			$hasil = $this->surat_serv->getsimpanprosesbelummenikahedit($data);
			//jika gagal
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->belummenikahAction();
				$this->render('belummenikah');				
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
				$this->belummenikahAction();
				$this->render('belummenikah');
			}
		}
		
		//proses selesai
		public function belummenikahselesaiAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->id_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_belummenikah= $this->_getParam("id_permintaan_belummenikah");
			$nama= $this->_getParam("nama");
			$nik= $this->_getParam("nik");
			$no_surat= $this->_getParam("no_surat");
			$tanggal_surat= $this->_getParam("tanggal_surat");
			$nama_surat= "Keterangan Belum Pernah Menikah";
			$asal_controller= "belummenikah";
			$no_registrasi= $this->_getParam("no_registrasi");
			$waktu_antrian= $this->_getParam("waktu_antrian");
			$status= 3;	
			
			//menghitung lama
			
			$waktu_selesai = date("H:i:s");
			$waktu_total = $this->surat_serv->selisih($waktu_antrian,$waktu_selesai);				
			
			
			$data = array("id_permintaan_belummenikah" => $id_permintaan_belummenikah,
							"status" => $status,
							"waktu_selesai" => $waktu_selesai,
							"waktu_total" => $waktu_total);
			
			$hasil = $this->surat_serv->getSelesaiBelummenikah($data);
			
			$this->view->asal_controller = $asal_controller;
			$this->view->render = $render;
			$this->view->nik = $nik;
			$this->view->nama = $nama;
			$this->view->no_surat = $no_surat;
			$this->view->tanggal_surat = $tanggal_surat;
			$this->view->nama_surat = $nama_surat;
			$this->view->surat = "Form Tambah Surat";
			$this->render('arsiptambah');
		}
		//////////////////////END Belum Pernah Menikah
		
		//////////////////////////////////// 6. KETERANGAN JANDA/DUDA
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
			
			$this->view->surat = "Surat Keterangan Keterangan Janda / Duda ";
			$this->view->permintaan = $this->surat_serv->getProsesjanda($this->id_kelurahan,$offset,$dataPerPage);
			
			
			//mendapatkan jumlah yang belum diproses dan selesai
			$jumlahstatus1 = $this->surat_serv->getJumlahStatusjanda1();	
			if($jumlahstatus1>=1){		
				$peringatanstatus1 = "Ada $jumlahstatus1 surat yang belum diproses. Silakan tekan tombol proses";
			}
			$this->view->jumlahstatus1 = $jumlahstatus1;
			$this->view->peringatanstatus1 = $peringatanstatus1;
			
			$jumlahstatus2 = $this->surat_serv->getJumlahStatusjanda2();
			if($jumlahstatus2>=1){
				$peringatanstatus2 = "Ada $jumlahstatus2 surat yang belum selesai. Silakan tekan tombol selesai";
			}
			$this->view->jumlahstatus2 = $jumlahstatus2;
			$this->view->peringatanstatus2 = $peringatanstatus2;
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
				$this->view->surat = "Surat Keterangan Keterangan Janda / Duda";
				$this->view->cari = $pencarian;
				$this->view->permintaan = $this->surat_serv->getPencarianjanda($this->id_kelurahan,$pencarian,$id_pencarian);
			}
			
		}
		public function caripendudukjandaAction() {
			$this->view;
			$this->view->surat = "Form Isian Surat Keterangan Keterangan Janda / Duda";
			$this->view->judul = "Masukan NIK";
		}
		
		//antrian janda --> proses memasukan ke antrian janda, status = 1
		public function jandaantrianAction(){
			$nik = $_POST['nik'];
			$this->view->surat = "Form Antrian Keterangan janda";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			
			//mengambil noregistrasi secara automatis
			$no_registrasi = $this->surat_serv->getNoRegistrasi(4,470); //4 adalah panjangnya, AN adalah kode huruf
			$this->view->no_registrasi=$no_registrasi;
			
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('jandaantrian');
			
		}
		
		//menyimpan antrian janda
		public function simpanjandaantrianAction(){
			if(isset($_POST['name'])){ 
				$id_kelurahan = $this->id_kelurahan;			
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->id_pengguna;		
				
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$no_telp = $_POST['no_telp'];
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
								"status" => $status,
								"no_telp" => $no_telp
							);										 
				$hasil = $this->surat_serv->getsimpanjandaantrian($data);
				// var_dump($data);
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
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
		
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_janda= $this->_getParam("id_permintaan_janda");
			$no_registrasi= $this->_getParam(no_registrasi);
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;	
			
			$waktu_antrian= $this->_getParam(waktu_antrian);
			$waktu_sekarang = date("H:i:s");
			$lama = $this->surat_serv->selisih($waktu_antrian,$waktu_sekarang);	
			$this->view->lama= $lama;
			
			$this->view->surat = "Form Proses Surat Keterangan Keterangan Janda / Duda";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
		}
		public function simpanprosesjandaAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->id_pengguna;
				
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
				$ket = $_POST['ket'];
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
							"proses_oleh" => $proses_oleh,
							"ket" => $ket
						);
					
				$hasil = $this->surat_serv->getsimpanprosesjanda($data);
				//jika gagal
				// var_dump($hasil);
				// var_dump($data);
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
			if($hasil=='gagal'){
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
			$this->view->surat = "Ubah Permintaan Surat Keterangan Keterangan Janda / Duda";
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
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->jandaAction();
				$this->render('janda');			
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
				$this->jandaAction();
				$this->render('janda');
			}			
		}
		
		//proses selesai
		public function jandaselesaiAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->id_pengguna;
			
			$selesai_oleh= $nama_pengguna;
			
			$id_permintaan_janda= $this->_getParam("id_permintaan_janda");
			$nama= $this->_getParam("nama");
			$nik= $this->_getParam("nik");
			$no_surat= $this->_getParam("no_surat");
			$tanggal_surat= $this->_getParam("tanggal_surat");
			$nama_surat= "Keterangan janda";
			$asal_controller= "janda";
			$no_registrasi= $this->_getParam("no_registrasi");
			$waktu_antrian= $this->_getParam("waktu_antrian");
			$status= 3;	
			
			//menghitung lama
			
			$waktu_selesai = date("H:i:s");
			$waktu_total = $this->surat_serv->selisih($waktu_antrian,$waktu_selesai);	
			
			
			
			$data = array("id_permintaan_janda" => $id_permintaan_janda,
							"status" => $status,
							"waktu_selesai" => $waktu_selesai,
							"waktu_total" => $waktu_total);
			
			$hasil = $this->surat_serv->getSelesaiJanda($data);
			//var_dump($hasil);
			$this->view->asal_controller = $asal_controller;
			$this->view->render = $render;
			$this->view->nik = $nik;
			$this->view->nama = $nama;
			$this->view->no_surat = $no_surat;
			$this->view->tanggal_surat = $tanggal_surat;
			$this->view->nama_surat = $nama_surat;
			$this->view->surat = "Form Tambah Surat";
			$this->render('arsiptambah');
		}
		/////////////// END 6. KETERANGAN JANDA/DUDA
		
		
		
		
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////    EKBANG      /////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		
		/////////////////////////////// 1. DOMISILI PERUSAHAN
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
			
			//mendapatkan jumlah yang belum diproses dan selesai
			$jumlahstatus1 = $this->surat_serv->getJumlahStatusDomisiliperusahaan1();	
			if($jumlahstatus1>=1){		
				$peringatanstatus1 = "Ada $jumlahstatus1 surat yang belum diproses. Silakan tekan tombol proses";
			}
			$this->view->jumlahstatus1 = $jumlahstatus1;
			$this->view->peringatanstatus1 = $peringatanstatus1;
			
			$jumlahstatus2 = $this->surat_serv->getJumlahStatusDomisiliperusahaan2();
			if($jumlahstatus2>=1){
				$peringatanstatus2 = "Ada $jumlahstatus2 surat yang belum selesai. Silakan tekan tombol selesai";
			}
			$this->view->jumlahstatus2 = $jumlahstatus2;
			$this->view->peringatanstatus2 = $peringatanstatus2;
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
			$no_registrasi = $this->surat_serv->getNoRegistrasi(4,500); //4 adalah panjangnya, AN adalah kode huruf
			$this->view->no_registrasi=$no_registrasi;
			
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('domisiliperusahaanantrian');
			
		}
		
		//menyimpan antrian andon nikah
		public function simpandomisiliperusahaanantrianAction(){
			if(isset($_POST['name'])){ 
				$id_kelurahan = $this->id_kelurahan;			
				$id_pengguna = $this->id_pengguna;		
				$nama_pengguna = $this->id_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$no_telp = $_POST['no_telp'];
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
								"status" => $status,
								"no_telp" => $no_telp
								);										 
				$hasil = $this->surat_serv->getsimpandomisiliperusahaanantrian($data);
				
				//simpan data ke tabel no_registrasi
				$registrasi = array("no_registrasi" =>  	$no_registrasi,
									"nik" => $nik							
									);										 
				$hasil = $this->surat_serv->getSimpanNoRegistrasi($registrasi);
				
				// var_dump($hasil);
				// var_dump($data);
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
			
			$waktu_antrian= $this->_getParam(waktu_antrian);
			$waktu_sekarang = date("H:i:s");
			$lama = $this->surat_serv->selisih($waktu_antrian,$waktu_sekarang);	
			$this->view->lama= $lama;
			
			$this->view->surat = "Form Isian Surat Domisili Perusahaan";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
		}
		
		public function simpanprosesdomisiliperusahaanAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->id_pengguna;
				
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
			
				
				$nama_perusahaan = $_POST['nama_perusahaan'];
				$akta_pendirian_perusahaan = $_POST['akta_pendirian_perusahaan'];
				$bergerak_bidang = $_POST['bergerak_bidang'];
				$jumlah_pegawai = $_POST['jumlah_pegawai'];
				$jam_kerja = $_POST['jam_kerja'];
				$masa_berlaku = $_POST['masa_berlaku'];
				$alamat_usaha = $_POST['alamat_usaha'];
				
				
				$ket = $_POST['ket'];
				$keperluan = $_POST['keperluan'];
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
								
								"nama_perusahaan" => $nama_perusahaan,
								"akta_pendirian_perusahaan" => $akta_pendirian_perusahaan,
								"bergerak_bidang" => $bergerak_bidang,
								"jumlah_pegawai" => $jumlah_pegawai,
								"jam_kerja" => $jam_kerja,
								"masa_berlaku" => $masa_berlaku,
								"alamat_usaha" => $alamat_usaha,
								
								"keperluan" => $keperluan,
								"status" => $status,
								"waktu_proses" => $waktu_proses,
								"proses_oleh" => $proses_oleh,
								"ket" => $ket
							);
				
				$hasil = $this->surat_serv->getsimpanprosesdomisiliperusahaan($data);
				// var_dump($hasil);
				// var_dump($data);
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
			$akta_pendirian_perusahaan = $_POST['akta_pendirian_perusahaan'];
			$bergerak_bidang = $_POST['bergerak_bidang'];
			$jumlah_pegawai = $_POST['jumlah_pegawai'];
			$jam_kerja = $_POST['jam_kerja'];
			$masa_berlaku = $_POST['masa_berlaku'];
			$alamat_usaha = $_POST['alamat_usaha'];
			$keperluan = $_POST['keperluan'];
			
			$data = array("	id_kelurahan" =>  	$id_kelurahan,
							"id_permintaan_domisili_perusahaan" => $id_permintaan_domisili_perusahaan,
							"nik" => $nik,
							"no_surat" => $no_surat,
							"tanggal_surat" => $tanggal_surat,
							"no_surat_pengantar" => $no_surat_pengantar,
							"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
							"nama_perusahaan" => $nama_perusahaan,
							"akta_pendirian_perusahaan" => $akta_pendirian_perusahaan,
							"bergerak_bidang" => $bergerak_bidang,
							"jumlah_pegawai" => $jumlah_pegawai,
							"jam_kerja" => $jam_kerja,
							"masa_berlaku" => $masa_berlaku,
							"alamat_usaha" => $alamat_usaha,
							"keperluan" => $keperluan
						);
			
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
			$nama_pengguna = $this->id_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_domisili_perusahaan= $this->_getParam("id_permintaan_domisili_perusahaan");
			$nama= $this->_getParam("nama");
			$nik= $this->_getParam("nik");
			$no_surat= $this->_getParam("no_surat");
			$tanggal_surat= $this->_getParam("tanggal_surat");
			$nama_surat= "Keterangan domisili perusahaan";
			$asal_controller= "domisiliperusahaan";
			$no_registrasi= $this->_getParam("no_registrasi");
			$waktu_antrian= $this->_getParam("waktu_antrian");
			$status= 3;	
			
			//menghitung lama
			
			$waktu_selesai = date("H:i:s");
			$waktu_total = $this->surat_serv->selisih($waktu_antrian,$waktu_selesai);	
			
			
			
			$data = array("id_permintaan_domisili_perusahaan" => $id_permintaan_domisili_perusahaan,
							"status" => $status,
							"waktu_selesai" => $waktu_selesai,
							"waktu_total" => $waktu_total
						);
			
			$hasil = $this->surat_serv->getSelesaiDomisiliperusahaan($data);
			//var_dump($hasil);
			$this->view->asal_controller = $asal_controller;
			$this->view->render = $render;
			$this->view->nik = $nik;
			$this->view->nama = $nama;
			$this->view->no_surat = $no_surat;
			$this->view->tanggal_surat = $tanggal_surat;
			$this->view->nama_surat = $nama_surat;
			$this->view->surat = "Form Tambah Surat";
			$this->render('arsiptambah');		
		}
		
		
		/////////////////////////////////////////------- 2. DOMISILI PANITIA PEMBANGUNAN
		//cetak surat domisilipanitiapemb
		public function domisilipanitiapembcetakAction(){
			$id_permintaan_domisili_panitia_pembangunan = $this->_getParam("id_permintaan_domisili_panitia_pembangunan");
			$this->view->hasil = $this->surat_serv->getdomisilipanitiapembcetak($id_permintaan_domisili_panitia_pembangunan);
		}
		
		public function domisilipanitiapembAction(){
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
			$this->view->jumData = $this->surat_serv->getJumlahdomisilipanitiapemb($this->id_kelurahan);
			$this->view->dataPerPage = $dataPerPage;
			$this->view->noPage = $noPage;
			$this->view->offset=$offset;
			
			$this->view->surat = "Surat Domisili PANITIA";
			$this->view->permintaan = $this->surat_serv->getProsesdomisilipanitiapemb($this->id_kelurahan,$offset , $dataPerPage);
			
			//mendapatkan jumlah yang belum diproses dan selesai
			$jumlahstatus1 = $this->surat_serv->getJumlahStatusdomisilipanitiapemb1();	
			if($jumlahstatus1>=1){		
				$peringatanstatus1 = "Ada $jumlahstatus1 surat yang belum diproses. Silakan tekan tombol proses";
			}
			$this->view->jumlahstatus1 = $jumlahstatus1;
			$this->view->peringatanstatus1 = $peringatanstatus1;
			
			$jumlahstatus2 = $this->surat_serv->getJumlahStatusdomisilipanitiapemb2();
			if($jumlahstatus2>=1){
				$peringatanstatus2 = "Ada $jumlahstatus2 surat yang belum selesai. Silakan tekan tombol selesai";
			}
			$this->view->jumlahstatus2 = $jumlahstatus2;
			$this->view->peringatanstatus2 = $peringatanstatus2;
		}
		
		public function pencariandomisilipanitiapembAction(){
			$this->view;
			$this->view->kelurahan = $this->id_kelurahan;
			$this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			$id_pencarian = $_POST['id_pencarian'];
			$pencarian = $_POST['pencarian'];
			if(!$pencarian){
				$this->domisilipanitiapembAction();
				$this->render('domisilipanitiapemb');
				}else{
				$this->view->surat = "Surat Keterangan Domisili PANITIA PEMBANGUNAN";
				$this->view->cari = $pencarian;
				$this->view->permintaan = $this->surat_serv->getPencariandomisilipanitiapemb($this->id_kelurahan,$pencarian,$id_pencarian);
			}
			
		}
		
		public function caripendudukdomisilipanitiapembAction() {
			$this->view;
			$this->view->surat = "Form Isian Surat Domisili PANITIA PEMBANGUNAN";
			$this->view->judul = "Masukan NIK";
		}
		
		//antrian domisilipanitiapemb --> proses memasukan ke antrian domisilipanitiapemb, status = 1
		public function domisilipanitiapembantrianAction(){
			$nik = $_POST['nik'];
			$this->view->surat = "Form Antrian Keterangan domisili PANITIA PEMBANGUNAN";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			
			//mengambil noregistrasi secara automatis
			$no_registrasi = $this->surat_serv->getNoRegistrasi(4,DMP); //4 adalah panjangnya, AN adalah kode huruf
			$this->view->no_registrasi=$no_registrasi;
			
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('domisilipanitiapembantrian');
			
		}
		
		//menyimpan antrian domisilipanitiapemb
		public function simpandomisilipanitiapembantrianAction(){
			if(isset($_POST['name'])){ 
				$id_kelurahan = $this->id_kelurahan;			
				$id_pengguna = $this->id_pengguna;		
				$nama_pengguna = $this->id_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$no_telp = $_POST['no_telp'];
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
								"status" => $status,
								"no_telp" => $no_telp
								);										 
				$hasil = $this->surat_serv->getsimpandomisilipanitiapembantrian($data);
				
				//simpan data ke tabel no_registrasi
				$registrasi = array("no_registrasi" =>  	$no_registrasi,
									"nik" => $nik							
									);										 
				$hasil = $this->surat_serv->getSimpanNoRegistrasi($registrasi);
				
				
				//jika gagal
				if($hasil=="gagal"){
					$this->view->peringatan ="<div class='gagal'>$hasil. Maaf ada kesalahan</div>";
					$this->domisilipanitiapembAction();
					$this->render('domisilipanitiapemb');					
				}
				//jika sukses
				if($hasil=="sukses"){
					$this->view->peringatan ="<div class='sukses'> Sukses, data berhasil ditambahkan ke antrian </div>";		
					$this->domisilipanitiapembAction();
					$this->render('domisilipanitiapemb');
				}	
				}else{
				$this->domisilipanitiapembAction();
				$this->render('domisilipanitiapemb');
			}
			
		}
		
		
		public function domisilipanitiapembprosesAction(){
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_domisili_panitia_pembangunan= $this->_getParam("id_permintaan_domisili_panitia_pembangunan");
			$no_registrasi= $this->_getParam(no_registrasi);
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;
			
			$waktu_antrian= $this->_getParam(waktu_antrian);
			$waktu_sekarang = date("H:i:s");
			$lama = $this->surat_serv->selisih($waktu_antrian,$waktu_sekarang);	
			$this->view->lama= $lama;
			
			$this->view->surat = "Form Isian Surat Domisili PANITIA PEMBANGUNAN";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
		}
		
		public function simpanprosesdomisilipanitiapembAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->id_pengguna;
				
				$waktu_proses = date("H:i:s");
				$proses_oleh= $nama_pengguna;
				
				$id_kelurahan = $this->id_kelurahan;
				$id_permintaan_domisili_panitia_pembangunan = $_POST['id_permintaan_domisili_panitia_pembangunan'];
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
				$ket = $_POST['ket'];
				$status = 2;
				
				$data = array("id_kelurahan" =>  	$id_kelurahan,
								"id_permintaan_domisili_panitia_pembangunan" => $id_permintaan_domisili_panitia_pembangunan,
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
								"status" => $status,
								"waktu_proses" => $waktu_proses,
								"proses_oleh" => $proses_oleh,
								"ket" => $ket
							);
				
				$hasil = $this->surat_serv->getsimpanprosesdomisilipanitiapemb($data);
				// var_dump($hasil);
				// var_dump($data);
				//jika gagal
				if($hasil=='gagal'){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
					$this->domisilipanitiapembAction();
					$this->render('domisilipanitiapemb');	
				}
				//jika sukses
				//jika sukses
				if($hasil=='sukses'){
					$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diproses </div>";		
					$this->domisilipanitiapembAction();
					$this->render('domisilipanitiapemb');
				}
			}else{
				$this->domisilipanitiapembAction();
				$this->render('domisilipanitiapemb');
			}
			
		}
		public function domisilipanitiapembhapusAction(){
			$id_permintaan_domisili_panitia_pembangunan= $this->_getParam("id_permintaan_domisili_panitia_pembangunan");
			$hasil = $this->surat_serv->gethapusdomisilipanitiapemb($id_permintaan_domisili_panitia_pembangunan);
			
			//jika gagal
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->domisilipanitiapembAction();
				$this->render('domisilipanitiapemb');	
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
			$this->domisilipanitiapembAction();
			$this->render('domisilipanitiapemb');	
		}
		public function domisilipanitiapembeditAction(){
			$id_permintaan_domisili_panitia_pembangunan = $this->_getParam("id_permintaan_domisili_panitia_pembangunan");
			$this->view->hasil = $this->surat_serv->getdomisilipanitiapemb($id_permintaan_domisili_panitia_pembangunan);
		}
		
		public function simpanprosesdomisilipanitiapembeditAction(){
			
			$id_permintaan_domisili_panitia_pembangunan = $this->_getParam('id_permintaan_domisili_panitia_pembangunan');
			$id_kelurahan = $this->id_kelurahan;
			$nik = $_POST['nik'];
			$no_surat = $_POST['no_surat'];
			$tanggal_surat = $_POST['tanggal_surat'];
			$no_surat_pengantar = $_POST['no_surat_pengantar'];
			$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];			
			$keperluan = $_POST['keperluan'];
			$masa_berlaku = $_POST['masa_berlaku'];
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
					"id_permintaan_domisili_panitia_pembangunan" => $id_permintaan_domisili_panitia_pembangunan,
					"nik" => $nik,
					"no_surat" => $no_surat,
					"tanggal_surat" => $tanggal_surat,
					"no_surat_pengantar" => $no_surat_pengantar,
					"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
					"keperluan" => $keperluan,
					"masa_berlaku" => $masa_berlaku
					);
			
			$hasil = $this->surat_serv->getsimpanprosesdomisilipanitiapembedit($data);
			//jika gagal
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->domisilipanitiapembAction();
				$this->render('domisilipanitiapemb');	
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
				$this->domisilipanitiapembAction();
				$this->render('domisilipanitiapemb');		
			}
		}
		
		//proses selesai
		public function domisilipanitiapembselesaiAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->id_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_domisili_panitia_pembangunan= $this->_getParam("id_permintaan_domisili_panitia_pembangunan");
			$nama= $this->_getParam("nama");
			$nik= $this->_getParam("nik");
			$no_surat= $this->_getParam("no_surat");
			$tanggal_surat= $this->_getParam("tanggal_surat");
			$nama_surat= "Keterangan domisili panitia PEMBANGUNAN";
			$asal_controller= "domisilipanitiapemb";
			$no_registrasi= $this->_getParam("no_registrasi");
			$waktu_antrian= $this->_getParam("waktu_antrian");
			$status= 3;	
			
			//menghitung lama
			
			$waktu_selesai = date("H:i:s");
			$waktu_total = $this->surat_serv->selisih($waktu_antrian,$waktu_selesai);				
			
			$data = array("id_permintaan_domisili_panitia_pembangunan" => $id_permintaan_domisili_panitia_pembangunan,
							"status" => $status,
							"waktu_selesai" => $waktu_selesai,
							"waktu_total" => $waktu_total
						);
			
			$hasil = $this->surat_serv->getSelesaidomisilipanitiapemb($data);
			//var_dump($hasil);
			$this->view->asal_controller = $asal_controller;
			$this->view->render = $render;
			$this->view->nik = $nik;
			$this->view->nama = $nama;
			$this->view->no_surat = $no_surat;
			$this->view->tanggal_surat = $tanggal_surat;
			$this->view->nama_surat = $nama_surat;
			$this->view->surat = "Form Tambah Surat";
			$this->render('arsiptambah');	
		} //////////// END 11. DOMISILI PANITIA PEMBANGUNAN
		
		
		///////////////////BELUM PUNYA RUMAH
		//cetak surat bpr
		public function bprcetakAction(){
			$id_permintaan_bpr = $this->_getParam("id_permintaan_bpr");
			$this->view->hasil = $this->surat_serv->getbprcetak($id_permintaan_bpr);
		}
		
		public function bprAction(){
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			
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
			
			//mendapatkan jumlah yang belum diproses dan selesai
			$jumlahstatus1 = $this->surat_serv->getJumlahStatusbpr1();	
			if($jumlahstatus1>=1){		
				$peringatanstatus1 = "Ada $jumlahstatus1 surat yang belum diproses. Silakan tekan tombol proses";
			}
			$this->view->jumlahstatus1 = $jumlahstatus1;
			$this->view->peringatanstatus1 = $peringatanstatus1;
			
			$jumlahstatus2 = $this->surat_serv->getJumlahStatusbpr2();
			if($jumlahstatus2>=1){
				$peringatanstatus2 = "Ada $jumlahstatus2 surat yang belum selesai. Silakan tekan tombol selesai";
			}
			$this->view->jumlahstatus2 = $jumlahstatus2;
			$this->view->peringatanstatus2 = $peringatanstatus2;
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
				$nama_pengguna = $this->id_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$no_telp = $_POST['no_telp'];
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
							"status" => $status,
							"no_telp" => $no_telp
							
				);										 
				$hasil = $this->surat_serv->getsimpanbprantrian($data);
				
				//simpan data ke tabel no_registrasi
				$registrasi = array("no_registrasi" =>  	$no_registrasi,
									"nik" => $nik							
									);										 
				$hasil = $this->surat_serv->getSimpanNoRegistrasi($registrasi);
				// var_dump($data);
				// var_dump($hasil);
				
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
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
		
			
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_bpr= $this->_getParam("id_permintaan_bpr");
			$no_registrasi= $this->_getParam(no_registrasi);
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;
			
			$waktu_antrian= $this->_getParam(waktu_antrian);
			$waktu_sekarang = date("H:i:s");
			$lama = $this->surat_serv->selisih($waktu_antrian,$waktu_sekarang);	
			$this->view->lama= $lama;
			
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;		
			$this->view->surat = "Form Isian Surat Keterangan Belum Mempunyai Rumah";
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			
		}
		
		
		public function simpanprosesbprAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->id_pengguna;
				
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
				$ket = $_POST['ket'];
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
								"proses_oleh" => $proses_oleh,
								"ket" => $ket
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
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->bprAction();
				$this->render('bpr');			
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
				$this->bprAction();
				$this->render('bpr');	
			}
		}
		public function bpreditAction(){
			$id_permintaan_bpr = $this->_getParam("id_permintaan_bpr");
			$this->view->surat = "Ubah Permintaan Surat Keterangan Belum Mempunyai Rumah";
			$this->view->hasil = $this->surat_serv->getbpr($id_permintaan_bpr);
		}
		
		public function simpanprosesbpreditAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->id_pengguna;
			
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
			
			
			$data = array(	"id_kelurahan" =>  	$id_kelurahan,
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
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->bprAction();
				$this->render('bpr');			
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
				$this->bprAction();
				$this->render('bpr');
			}			
		}
		
		//proses selesai
		public function bprselesaiAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->id_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_bpr= $this->_getParam("id_permintaan_bpr");
			$nama= $this->_getParam("nama");
			$nik= $this->_getParam("nik");
			$no_surat= $this->_getParam("no_surat");
			$tanggal_surat= $this->_getParam("tanggal_surat");
			$nama_surat= "Keterangan Belum Punya Rumah";
			$asal_controller= "bpr";
			$no_registrasi= $this->_getParam("no_registrasi");
			$waktu_antrian= $this->_getParam("waktu_antrian");
			$status= 3;	
			
			//menghitung lama
			
			$waktu_selesai = date("H:i:s");
			$waktu_total = $this->surat_serv->selisih($waktu_antrian,$waktu_selesai);	
			
			
			
			$data = array("id_permintaan_bpr" => $id_permintaan_bpr,
							"status" => $status,
							"waktu_selesai" => $waktu_selesai,
							"waktu_total" => $waktu_total);
			
			$hasil = $this->surat_serv->getSelesaiBpr($data);
			//var_dump($hasil);
			$this->view->asal_controller = $asal_controller;
			$this->view->render = $render;
			$this->view->nik = $nik;
			$this->view->nama = $nama;
			$this->view->no_surat = $no_surat;
			$this->view->tanggal_surat = $tanggal_surat;
			$this->view->nama_surat = $nama_surat;
			$this->view->surat = "Form Tambah Surat";
			$this->render('arsiptambah');
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
			
			$this->view->surat = "Surat Keterangan Domisili Khusus Haji";
			$this->view->permintaan = $this->surat_serv->getProsesIbadahHaji($this->id_kelurahan,$offset,$dataPerPage);
			
				//mendapatkan jumlah yang belum diproses dan selesai
			$jumlahstatus1 = $this->surat_serv->getJumlahStatusibadahhaji1();	
			if($jumlahstatus1>=1){		
				$peringatanstatus1 = "Ada $jumlahstatus1 surat yang belum diproses. Silakan tekan tombol proses";
			}
			$this->view->jumlahstatus1 = $jumlahstatus1;
			$this->view->peringatanstatus1 = $peringatanstatus1;
			
			$jumlahstatus2 = $this->surat_serv->getJumlahStatusibadahhaji2();
			if($jumlahstatus2>=1){
				$peringatanstatus2 = "Ada $jumlahstatus2 surat yang belum selesai. Silakan tekan tombol selesai";
			}
			$this->view->jumlahstatus2 = $jumlahstatus2;
			$this->view->peringatanstatus2 = $peringatanstatus2;
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
				$this->view->surat = "Surat Keterangan Domisili Khusus Haji";
				$this->view->cari = $pencarian;
				$this->view->permintaan = $this->surat_serv->getPencarianib($this->id_kelurahan,$pencarian,$id_pencarian);
			}
			
		}
		public function caripendudukibadahhajiAction() {
			$this->view;
			$this->view->surat = "Form Isian Surat Keterangan Domisili Khusus Haji";
			$this->view->judul = "Masukan NIK";
		}
		
		//antrian ibadah haji --> proses memasukan ke antrian ibadah haji, status = 1
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
				$nama_pengguna = $this->id_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$no_telp = $_POST['no_telp'];
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
				"status" => $status,
				"no_telp" => $no_telp
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
				$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
		
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_ibadahhaji= $this->_getParam("id_permintaan_ibadahhaji");
			$no_registrasi= $this->_getParam(no_registrasi);
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;	
			
			$waktu_antrian= $this->_getParam(waktu_antrian);
			$waktu_sekarang = date("H:i:s");
			$lama = $this->surat_serv->selisih($waktu_antrian,$waktu_sekarang);	
			$this->view->lama= $lama;
			
			$this->view->surat = "Form Isian Surat Keterangan Domisili Khusus Haji";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
		}
		
		public function simpanprosesibadahhajiAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->id_pengguna;
				
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
				$ket = $_POST['ket'];
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
								"proses_oleh" => $proses_oleh,
								"ket" => $ket
							);
				
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
			if($hasil=='gagal'){
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
			$this->view->surat = "Ubah Permintaan Surat Keterangan Domisili Khusus Haji";
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
							"tanggal_surat_pengantar" => $tanggal_surat_pengantar
						);
			
			$hasil = $this->surat_serv->getsimpanprosesibadahhajiedit($data);
			//jika gagal
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->ibadahhajiAction();
				$this->render('ibadahhaji');		
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
				$this->ibadahhajiAction();
				$this->render('ibadahhaji');	
			}
		}
		
		public function ibadahhajiselesaiAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->id_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_ibadahhaji= $this->_getParam("id_permintaan_ibadahhaji");
			$nama= $this->_getParam("nama");
			$nik= $this->_getParam("nik");
			$no_surat= $this->_getParam("no_surat");
			$tanggal_surat= $this->_getParam("tanggal_surat");
			$nama_surat= "Keterangan ibadah haji";
			$asal_controller= "ibadahhaji";
			$no_registrasi= $this->_getParam("no_registrasi");
			$waktu_antrian= $this->_getParam("waktu_antrian");
			$status= 3;	
			
			//menghitung lama
			
			$waktu_selesai = date("H:i:s");
			$waktu_total = $this->surat_serv->selisih($waktu_antrian,$waktu_selesai);	
			
			
			
			$data = array("id_permintaan_ibadahhaji" => $id_permintaan_ibadahhaji,
							"status" => $status,
							"waktu_selesai" => $waktu_selesai,
							"waktu_total" => $waktu_total);
			
			$hasil = $this->surat_serv->getSelesaiIbadahhaji($data);
			//var_dump($hasil);
			$this->view->asal_controller = $asal_controller;
			$this->view->render = $render;
			$this->view->nik = $nik;
			$this->view->nama = $nama;
			$this->view->no_surat = $no_surat;
			$this->view->tanggal_surat = $tanggal_surat;
			$this->view->nama_surat = $nama_surat;
			$this->view->surat = "Form Tambah Surat";
			$this->render('arsiptambah');
			
		}
		
		
		
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////    TRANTIB      /////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		
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
			
			//mendapatkan jumlah yang belum diproses dan selesai
			$jumlahstatus1 = $this->surat_serv->getJumlahStatusik1();	
			if($jumlahstatus1>=1){		
				$peringatanstatus1 = "Ada $jumlahstatus1 surat yang belum diproses. Silakan tekan tombol proses";
			}
			$this->view->jumlahstatus1 = $jumlahstatus1;
			$this->view->peringatanstatus1 = $peringatanstatus1;
			
			$jumlahstatus2 = $this->surat_serv->getJumlahStatusik2();
			if($jumlahstatus2>=1){
				$peringatanstatus2 = "Ada $jumlahstatus2 surat yang belum selesai. Silakan tekan tombol selesai";
			}
			$this->view->jumlahstatus2 = $jumlahstatus2;
			$this->view->peringatanstatus2 = $peringatanstatus2;
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
		
		//antrian ik --> proses memasukan ke antrian ik, status = 1
		public function ikantrianAction(){
			$nik = $_POST['nik'];
			$this->view->surat = "Form Antrian Keterangan Ijin Keramaian";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			
			//mengambil noregistrasi secara automatis
			$no_registrasi = $this->surat_serv->getNoRegistrasi(4,330); //4 adalah panjangnya, AN adalah kode huruf
			$this->view->no_registrasi=$no_registrasi;
			
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('ikantrian');
			
		}
		
		//menyimpan antrian ijin keramaian
		public function simpanikantrianAction(){
			if(isset($_POST['name'])){ 
				$id_kelurahan = $this->id_kelurahan;			
				$id_pengguna = $this->id_pengguna;		
				$nama_pengguna = $this->id_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$no_telp = $_POST['no_telp'];
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
							"status" => $status,
							"no_telp" => $no_telp
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
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_ik= $this->_getParam("id_permintaan_ik");
			$no_registrasi= $this->_getParam(no_registrasi);
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;
			
			$waktu_antrian= $this->_getParam(waktu_antrian);
			$waktu_sekarang = date("H:i:s");
			$lama = $this->surat_serv->selisih($waktu_antrian,$waktu_sekarang);	
			$this->view->lama= $lama;
			
			$this->view->surat = "Form Isian Surat Ketrangan Ijin Keramaian";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
		}
		public function simpanprosesikAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->id_pengguna;
				
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
				
				$nama_kegiatan = $_POST['nama_kegiatan'];
				$tempat_kegiatan = $_POST['tempat_kegiatan'];
				$hiburan = $_POST['hiburan'];
				$hari_kegiatan = $_POST['hari_kegiatan'];
				$tanggal_kegiatan = $_POST['tanggal_kegiatan'];
				$waktu = $_POST['waktu'];
				
				$ket = $_POST['ket'];
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

								"nama_kegiatan" => $nama_kegiatan,
								"tempat_kegiatan" => $tempat_kegiatan,
								"hiburan" => $hiburan,
								"nama_kegiatan" => $nama_kegiatan,
								"hari_kegiatan" => $hari_kegiatan,
								"tanggal_kegiatan" => $tanggal_kegiatan,
								"waktu" => $waktu,
								
								"status" => $status,
								"waktu_proses" => $waktu_proses,
								"proses_oleh" => $proses_oleh,
								"ket" => $ket
								);
				
				$hasil = $this->surat_serv->getsimpanprosesik($data);
				// var_dump($hasil);
				// var_dump($data);
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
			if($hasil=='gagal'){
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
				
				$nama_kegiatan = $_POST['nama_kegiatan'];
				$tempat_kegiatan = $_POST['tempat_kegiatan'];
				$hiburan = $_POST['hiburan'];
				$hari_kegiatan = $_POST['hari_kegiatan'];
				$tanggal_kegiatan = $_POST['tanggal_kegiatan'];
				$waktu = $_POST['waktu'];
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
							"id_permintaan_ik" => $id_permintaan_ik,
							"nik" => $nik,
							"no_surat" => $no_surat,
							"tanggal_surat" => $tanggal_surat,
							"no_surat_pengantar" => $no_surat_pengantar,
							"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
							"nama_kegiatan" => $nama_kegiatan,
							"tempat_kegiatan" => $tempat_kegiatan,
							"hiburan" => $hiburan,
							"nama_kegiatan" => $nama_kegiatan,
							"hari_kegiatan" => $hari_kegiatan,
							"tanggal_kegiatan" => $tanggal_kegiatan,
							"waktu" => $waktu
						);
			
			$hasil = $this->surat_serv->getsimpanprosesikedit($data);
			//jika gagal
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->ikAction();
				$this->render('ik');			
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
				$this->ikAction();
				$this->render('ik');
			}			
		}
		
		//proses selesai
		public function ikselesaiAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->id_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_ik= $this->_getParam("id_permintaan_ik");
			$nama= $this->_getParam("nama");
			$nik= $this->_getParam("nik");
			$no_surat= $this->_getParam("no_surat");
			$tanggal_surat= $this->_getParam("tanggal_surat");
			$nama_surat= "Keterangan Andonnikah";
			$asal_controller= "ik";
			$no_registrasi= $this->_getParam("no_registrasi");
			$waktu_antrian= $this->_getParam("waktu_antrian");
			$status= 3;	
			
			//menghitung lama
			
			$waktu_selesai = date("H:i:s");
			$waktu_total = $this->surat_serv->selisih($waktu_antrian,$waktu_selesai);	
			
			
			
			$data = array("id_permintaan_ik" => $id_permintaan_ik,
						"status" => $status,
						"waktu_selesai" => $waktu_selesai,
						"waktu_total" => $waktu_total);
			
			$hasil = $this->surat_serv->getSelesaiIk($data);
			//var_dump($hasil);
			$this->view->asal_controller = $asal_controller;
			$this->view->render = $render;
			$this->view->nik = $nik;
			$this->view->nama = $nama;
			$this->view->no_surat = $no_surat;
			$this->view->tanggal_surat = $tanggal_surat;
			$this->view->nama_surat = $nama_surat;
			$this->view->surat = "Form Tambah Surat";
			$this->render('arsiptambah');		
		}
		
		//-------------------------------------- PENGANTAR SKCK
		
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
			
			//mendapatkan jumlah yang belum diproses dan selesai
			$jumlahstatus1 = $this->surat_serv->getJumlahStatusps1();	
			if($jumlahstatus1>=1){		
				$peringatanstatus1 = "Ada $jumlahstatus1 surat yang belum diproses. Silakan tekan tombol proses";
			}
			$this->view->jumlahstatus1 = $jumlahstatus1;
			$this->view->peringatanstatus1 = $peringatanstatus1;
			
			$jumlahstatus2 = $this->surat_serv->getJumlahStatusps2();
			if($jumlahstatus2>=1){
				$peringatanstatus2 = "Ada $jumlahstatus2 surat yang belum selesai. Silakan tekan tombol selesai";
			}
			$this->view->jumlahstatus2 = $jumlahstatus2;
			$this->view->peringatanstatus2 = $peringatanstatus2;
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
			$this->view->surat = "Form Antrian Keterangan Pengantar SKCK";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			
			//mengambil noregistrasi secara automatis
			$no_registrasi = $this->surat_serv->getNoRegistrasi(4,"148"); //4 adalah panjangnya, AN adalah kode huruf
			$this->view->no_registrasi=$no_registrasi;
			
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('psantrian');
			
		}
		
		//menyimpan antrian pengantar skck
		public function simpanpsantrianAction(){
			if(isset($_POST['name'])){ 
				$id_kelurahan = $this->id_kelurahan;			
				$id_pengguna = $this->id_pengguna;		
				$nama_pengguna = $this->id_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$no_telp = $_POST['no_telp'];
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
								"status" => $status,
								"no_telp" => $no_telp
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
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_ps= $this->_getParam("id_permintaan_ps");
			$no_registrasi= $this->_getParam(no_registrasi);
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;
			
			$waktu_antrian= $this->_getParam(waktu_antrian);
			$waktu_sekarang = date("H:i:s");
			$lama = $this->surat_serv->selisih($waktu_antrian,$waktu_sekarang);	
			$this->view->lama= $lama;
			
			$this->view->surat = "Form Isian Surat Pengantar SKCK";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
		}
		public function simpanprosespsAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->id_pengguna;
				
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
				$ket = $_POST['ket'];
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
								"proses_oleh" => $proses_oleh,
								"ket" => $ket
								);
				
				$hasil = $this->surat_serv->getsimpanprosesps($data);
				// var_dump($hasil);
				// var_dump($data);
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
			$nama_pengguna = $this->id_pengguna;
			
		
			
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
			$nama_pengguna = $this->id_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_ps= $this->_getParam("id_permintaan_ps");
			$nama= $this->_getParam("nama");
			$nik= $this->_getParam("nik");
			$no_surat= $this->_getParam("no_surat");
			$tanggal_surat= $this->_getParam("tanggal_surat");
			$nama_surat= "Keterangan Permintaan SKCK";
			$asal_controller= "ps";
			$no_registrasi= $this->_getParam("no_registrasi");
			$waktu_antrian= $this->_getParam("waktu_antrian");
			$status= 3;	
			
			//menghitung lama
			
			$waktu_selesai = date("H:i:s");
			$waktu_total = $this->surat_serv->selisih($waktu_antrian,$waktu_selesai);	
			
			
			$data = array("id_permintaan_ps" => $id_permintaan_ps,
							"status" => $status,
							"waktu_selesai" => $waktu_selesai,
							"waktu_total" => $waktu_total
						);
			
			$hasil = $this->surat_serv->getSelesaiPs($data);
			//var_dump($hasil);
			$this->view->asal_controller = $asal_controller;
			$this->view->render = $render;
			$this->view->nik = $nik;
			$this->view->nama = $nama;
			$this->view->no_surat = $no_surat;
			$this->view->tanggal_surat = $tanggal_surat;
			$this->view->nama_surat = $nama_surat;
			$this->view->surat = "Form Tambah Surat";
			$this->render('arsiptambah');		
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
			
			//mendapatkan jumlah yang belum diproses dan selesai
			$jumlahstatus1 = $this->surat_serv->getJumlahStatusbd1();	
			if($jumlahstatus1>=1){		
				$peringatanstatus1 = "Ada $jumlahstatus1 surat yang belum diproses. Silakan tekan tombol proses";
			}
			$this->view->jumlahstatus1 = $jumlahstatus1;
			$this->view->peringatanstatus1 = $peringatanstatus1;
			
			$jumlahstatus2 = $this->surat_serv->getJumlahStatusbd2();
			if($jumlahstatus2>=1){
				$peringatanstatus2 = "Ada $jumlahstatus2 surat yang belum selesai. Silakan tekan tombol selesai";
			}
			$this->view->jumlahstatus2 = $jumlahstatus2;
			$this->view->peringatanstatus2 = $peringatanstatus2;
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
			$no_registrasi = $this->surat_serv->getNoRegistrasi(4,730); //4 adalah panjangnya, AN adalah kode huruf
			$this->view->no_registrasi=$no_registrasi;
			
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('bdantrian');
			
		}
		
		//menyimpan antrian andon nikah
		public function simpanabdantrianAction(){
			if(isset($_POST['name'])){ 
				$id_kelurahan = $this->id_kelurahan;			
				$id_pengguna = $this->id_pengguna;		
				$nama_pengguna = $this->id_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$no_telp = $_POST['no_telp'];
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
								"status" => $status,
								"no_telp" => $no_telp
							);	
				
				$hasil = $this->surat_serv->getsimpanbdantrian($data);
				
				//simpan data ke tabel no_registrasi
				$registrasi = array("no_registrasi" =>  	$no_registrasi,
				"nik" => $nik							
				);										 
				$hasil = $this->surat_serv->getSimpanNoRegistrasi($registrasi);
				
				// var_dump($hasil);
				// var_dump($data);
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
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_bd= $this->_getParam("id_permintaan_bd");
			$no_registrasi= $this->_getParam(no_registrasi);
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;	
			
			$waktu_antrian= $this->_getParam(waktu_antrian);
			$waktu_sekarang = date("H:i:s");
			$lama = $this->surat_serv->selisih($waktu_antrian,$waktu_sekarang);	
			$this->view->lama= $lama;
			
			$this->view->surat = "Form Isian Surat Keterangan Bersih Diri";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
		}
		public function simpanprosesbdAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->id_pengguna;
				
				$waktu_proses = date("H:i:s");
				$proses_oleh= $nama_pengguna;
				
				$id_kelurahan = $this->id_kelurahan;
				$id_permintaan_bd = $_POST['id_permintaan_bd'];
				$id_jenis_surat = $_POST['id_jenis_surat'];
				$id_surat = $_POST['id_surat'];
				
				$id_kelurahan = $this->id_kelurahan;
				$nik = $_POST['nik'];
				$id_pejabat = $_POST['id_pejabat'];
				
				$nama_ayah = $_POST['nama_ayah'];
				$tempat_lahir_ayah = $_POST['tempat_lahir_ayah'];
				$tanggal_lahir_ayah = $_POST['tanggal_lahir_ayah'];
				$alamat_ayah = $_POST['alamat_ayah'];
				$pekerjaan_ayah = $_POST['pekerjaan_ayah'];
				$agama_ayah = $_POST['agama_ayah'];
				
				$nama_ibu = $_POST['nama_ibu'];
				$tempat_lahir_ibu = $_POST['tempat_lahir_ibu'];
				$tanggal_lahir_ibu = $_POST['tanggal_lahir_ibu'];
				$alamat_ibu = $_POST['alamat_ibu'];
				$pekerjaan_ibu = $_POST['pekerjaan_ibu'];
				$agama_ibu = $_POST['agama_ibu'];
				
				$no_surat = $_POST['no_surat'];
				$tanggal_surat = $_POST['tanggal_surat'];
				$no_surat_pengantar = $_POST['no_surat_pengantar'];
				$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
				$keperluan = $_POST['keperluan'];
				$ket = $_POST['ket'];
				$status = 2;
				
				$data = array("id_kelurahan" =>  	$id_kelurahan,
								"id_permintaan_bd" => $id_permintaan_bd,
								"nik" => $nik,
								"id_pejabat" => $id_pejabat,
								"id_jenis_surat" => $id_jenis_surat,
								"id_surat" => $id_surat,
								"nama_ayah" => $nama_ayah,
								"tempat_lahir_ayah" => $tempat_lahir_ayah,
								"tanggal_lahir_ayah" => $tanggal_lahir_ayah,
								"alamat_ayah" => $alamat_ayah,
								"pekerjaan_ayah" => $pekerjaan_ayah,
								"agama_ayah" => $agama_ayah,
								"nama_ibu" => $nama_ibu,
								"tempat_lahir_ibu" => $tempat_lahir_ibu,
								"tanggal_lahir_ibu" => $tanggal_lahir_ibu,
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
								"proses_oleh" => $proses_oleh,
								"ket" => $ket
							);
				
				$hasil = $this->surat_serv->getsimpanprosesbd($data);
				// var_dump($hasil);
				// var_dump($data);
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
			if($hasil=='gagal'){
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
			if($hasil=='gagal'){
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
			$nama_pengguna = $this->id_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_bd= $this->_getParam("id_permintaan_bd");
			$nama= $this->_getParam("nama");
			$nik= $this->_getParam("nik");
			$no_surat= $this->_getParam("no_surat");
			$tanggal_surat= $this->_getParam("tanggal_surat");
			$nama_surat= "Keterangan Bersih Diri";
			$asal_controller= "bd";
			$no_registrasi= $this->_getParam("no_registrasi");
			$waktu_antrian= $this->_getParam("waktu_antrian");
			$status= 3;	
			
			//menghitung lama
			
			$waktu_selesai = date("H:i:s");
			$waktu_total = $this->surat_serv->selisih($waktu_antrian,$waktu_selesai);	
			
			
			$data = array("id_permintaan_bd" => $id_permintaan_bd,
			"status" => $status,
			"waktu_selesai" => $waktu_selesai,
			"waktu_total" => $waktu_total);
			
			$hasil = $this->surat_serv->getSelesaiBd($data);
			//var_dump($hasil);
			$this->view->asal_controller = $asal_controller;
			$this->view->render = $render;
			$this->view->nik = $nik;
			$this->view->nama = $nama;
			$this->view->no_surat = $no_surat;
			$this->view->tanggal_surat = $tanggal_surat;
			$this->view->nama_surat = $nama_surat;
			$this->view->surat = "Form Tambah Surat";
			$this->render('arsiptambah');	
		}
		
		
		//////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////    EKBANG      /////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		
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
			
			//mendapatkan jumlah yang belum diproses dan selesai
			$jumlahstatus1 = $this->surat_serv->getJumlahStatusDomisiliyayasan1();	
			if($jumlahstatus1>=1){		
				$peringatanstatus1 = "Ada $jumlahstatus1 surat yang belum diproses. Silakan tekan tombol proses";
			}
			$this->view->jumlahstatus1 = $jumlahstatus1;
			$this->view->peringatanstatus1 = $peringatanstatus1;
			
			$jumlahstatus2 = $this->surat_serv->getJumlahStatusDomisiliyayasan2();
			if($jumlahstatus2>=1){
				$peringatanstatus2 = "Ada $jumlahstatus2 surat yang belum selesai. Silakan tekan tombol selesai";
			}
			$this->view->jumlahstatus2 = $jumlahstatus2;
			$this->view->peringatanstatus2 = $peringatanstatus2;
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
		
		//menyimpan antrian domisili yayasan
		public function simpandomisiliyayasanantrianAction(){
			if(isset($_POST['name'])){ 
				$id_kelurahan = $this->id_kelurahan;			
				$id_pengguna = $this->id_pengguna;		
				$nama_pengguna = $this->id_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$no_telp = $_POST['no_telp'];
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
								"status" => $status,
								"no_telp" => $no_telp
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
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_domisili_yayasan= $this->_getParam("id_permintaan_domisili_yayasan");
			$no_registrasi= $this->_getParam(no_registrasi);
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;
			
			$waktu_antrian= $this->_getParam(waktu_antrian);
			$waktu_sekarang = date("H:i:s");
			$lama = $this->surat_serv->selisih($waktu_antrian,$waktu_sekarang);	
			$this->view->lama= $lama;
			
			$this->view->surat = "Form Isian Surat Domisili Yayasan";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
		}
		
		public function simpanprosesdomisiliyayasanAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->id_pengguna;
				
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
				$nama_yayasan = $_POST['nama_yayasan'];
				$bergerak_bidang = $_POST['bergerak_bidang'];
				$jumlah_anggota = $_POST['jumlah_anggota'];
				$jam_kerja = $_POST['jam_kerja'];
				$alamat_usaha = $_POST['alamat_usaha'];
				$ket = $_POST['ket'];
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
								"nama_yayasan" => $nama_yayasan,
								"bergerak_bidang" => $bergerak_bidang,
								"jumlah_anggota" => $jumlah_anggota,
								"jam_kerja" => $jam_kerja,
								"alamat_usaha" => $alamat_usaha,
								"status" => $status,
								"waktu_proses" => $waktu_proses,
								"proses_oleh" => $proses_oleh,
								"ket" => $ket
							);
				
				$hasil = $this->surat_serv->getsimpanprosesdomisiliyayasan($data);
				// var_dump($hasil);
				// var_dump($data);
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
			$nama_pengguna = $this->id_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_domisili_yayasan= $this->_getParam("id_permintaan_domisili_yayasan");
			$nama= $this->_getParam("nama");
			$nik= $this->_getParam("nik");
			$no_surat= $this->_getParam("no_surat");
			$tanggal_surat= $this->_getParam("tanggal_surat");
			$nama_surat= "Keterangan domisili yayasan";
			$asal_controller= "domisiliyayasan";
			$no_registrasi= $this->_getParam("no_registrasi");
			$waktu_antrian= $this->_getParam("waktu_antrian");
			$status= 3;	
			//menghitung lama
			
			$waktu_selesai = date("H:i:s");
			$waktu_total = $this->surat_serv->selisih($waktu_antrian,$waktu_selesai);	
			
			
			$data = array("id_permintaan_domisili_yayasan" => $id_permintaan_domisili_yayasan,
							"status" => $status,
							"waktu_selesai" => $waktu_selesai,
							"waktu_total" => $waktu_total
						);
			
			$hasil = $this->surat_serv->getSelesaiDomisiliyayasan($data);
			//var_dump($hasil);
			$this->view->asal_controller = $asal_controller;
			$this->view->render = $render;
			$this->view->nik = $nik;
			$this->view->nama = $nama;
			$this->view->no_surat = $no_surat;
			$this->view->tanggal_surat = $tanggal_surat;
			$this->view->nama_surat = $nama_surat;
			$this->view->surat = "Form Tambah Surat";
			$this->render('arsiptambah');		
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
			
			//mendapatkan jumlah yang belum diproses dan selesai
			$jumlahstatus1 = $this->surat_serv->getJumlahStatusDomisiliparpol1();	
			if($jumlahstatus1>=1){		
				$peringatanstatus1 = "Ada $jumlahstatus1 surat yang belum diproses. Silakan tekan tombol proses";
			}
			$this->view->jumlahstatus1 = $jumlahstatus1;
			$this->view->peringatanstatus1 = $peringatanstatus1;
			
			$jumlahstatus2 = $this->surat_serv->getJumlahStatusDomisiliparpol2();
			if($jumlahstatus2>=1){
				$peringatanstatus2 = "Ada $jumlahstatus2 surat yang belum selesai. Silakan tekan tombol selesai";
			}
			$this->view->jumlahstatus2 = $jumlahstatus2;
			$this->view->peringatanstatus2 = $peringatanstatus2;
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
				$nama_pengguna = $this->id_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$no_telp = $_POST['no_telp'];
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
								"status" => $status,
								"no_telp" => $no_telp
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
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_domisili_parpol= $this->_getParam("id_permintaan_domisili_parpol");
			$no_registrasi= $this->_getParam(no_registrasi);
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;
			
			$waktu_antrian= $this->_getParam(waktu_antrian);
			$waktu_sekarang = date("H:i:s");
			$lama = $this->surat_serv->selisih($waktu_antrian,$waktu_sekarang);	
			$this->view->lama= $lama;
			
			$this->view->surat = "Form Isian Surat Domisili Parpol";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
		}
		
		public function simpanprosesdomisiliparpolAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->id_pengguna;
				
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
				$ket = $_POST['ket'];
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
								"proses_oleh" => $proses_oleh,
								"ket" => $ket
							);
				
				$hasil = $this->surat_serv->getsimpanprosesdomisiliparpol($data);
				// var_dump($hasil);
				// var_dump($data);
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
			if($hasil=='gagal'){
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
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->domisiliparpolAction();
				$this->render('domisiliparpol');	
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
				$this->domisiliparpolAction();
				$this->render('domisiliparpol');		
			}
		}
		
		//proses selesai
		public function domisiliparpolselesaiAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->id_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_domisili_parpol= $this->_getParam("id_permintaan_domisili_parpol");
			$nama= $this->_getParam("nama");
			$nik= $this->_getParam("nik");
			$no_surat= $this->_getParam("no_surat");
			$tanggal_surat= $this->_getParam("tanggal_surat");
			$nama_surat= "Keterangan domisili parpol";
			$asal_controller= "domisiliparpol";
			$no_registrasi= $this->_getParam("no_registrasi");
			$waktu_antrian= $this->_getParam("waktu_antrian");
			$status= 3;	
			
			//menghitung lama
			
			$waktu_selesai = date("H:i:s");
			$waktu_total = $this->surat_serv->selisih($waktu_antrian,$waktu_selesai);	
			
			
			
			$data = array("id_permintaan_domisili_parpol" => $id_permintaan_domisili_parpol,
							"status" => $status,
							"waktu_selesai" => $waktu_selesai,
							"waktu_total" => $waktu_total
						);
			
			$hasil = $this->surat_serv->getSelesaiDomisiliparpol($data);
			//var_dump($hasil);
			$this->view->asal_controller = $asal_controller;
			$this->view->render = $render;
			$this->view->nik = $nik;
			$this->view->nama = $nama;
			$this->view->no_surat = $no_surat;
			$this->view->tanggal_surat = $tanggal_surat;
			$this->view->nama_surat = $nama_surat;
			$this->view->surat = "Form Tambah Surat";
			$this->render('arsiptambah');	
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
			
			//mendapatkan jumlah yang belum diproses dan selesai
			$jumlahstatus1 = $this->surat_serv->getJumlahStatusKeterangantempatusaha1();	
			if($jumlahstatus1>=1){		
				$peringatanstatus1 = "Ada $jumlahstatus1 surat yang belum diproses. Silakan tekan tombol proses";
			}
			$this->view->jumlahstatus1 = $jumlahstatus1;
			$this->view->peringatanstatus1 = $peringatanstatus1;
			
			$jumlahstatus2 = $this->surat_serv->getJumlahStatusKeterangantempatusaha2();
			if($jumlahstatus2>=1){
				$peringatanstatus2 = "Ada $jumlahstatus2 surat yang belum selesai. Silakan tekan tombol selesai";
			}
			$this->view->jumlahstatus2 = $jumlahstatus2;
			$this->view->peringatanstatus2 = $peringatanstatus2;
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
			$this->view->surat = "Form Antrian Surat Keterangan Tempat Usaha";
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
				$nama_pengguna = $this->id_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$no_telp = $_POST['no_telp'];
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
								"status" => $status,
								"no_telp" => $no_telp
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
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_keterangan_tempat_usaha= $this->_getParam("id_permintaan_keterangan_tempat_usaha");
			$no_registrasi= $this->_getParam(no_registrasi);
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			
			$waktu_antrian= $this->_getParam(waktu_antrian);
			$waktu_sekarang = date("H:i:s");
			$lama = $this->surat_serv->selisih($waktu_antrian,$waktu_sekarang);	
			$this->view->lama= $lama;
			$this->view->KodeKelurahan= $KodeKelurahan;	
			
			$this->view->surat = "Form Isian Surat Keterangan Tempat Usaha";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
		}
		
		public function simpanprosesketerangantempatusahaAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->id_pengguna;
				
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
				$ket = $_POST['ket'];
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
								"status" => $status,
								"waktu_proses" => $waktu_proses,
								"proses_oleh" => $proses_oleh,
								"ket" => $ket
							);
				
				$hasil = $this->surat_serv->getsimpanprosesketerangantempatusaha($data);
				// var_dump($hasil);
				// var_dump($data);
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
			if($hasil=='gagal'){
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
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
							"id_permintaan_keterangan_tempat_usaha" => $id_permintaan_keterangan_tempat_usaha,
							"nik" => $nik,
							"no_surat" => $no_surat,
							"tanggal_surat" => $tanggal_surat,
							"no_surat_pengantar" => $no_surat_pengantar,
							"bidang_usaha" => $bidang_usaha,
							"alamat_usaha" => $alamat_usaha,
							"tanggal_surat_pengantar" => $tanggal_surat_pengantar);
			
			$hasil = $this->surat_serv->getsimpanprosesketerangantempatusahaedit($data);
			//jika gagal
			if($hasil=='gagal'){
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
			$nama_pengguna = $this->id_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_keterangan_tempat_usaha= $this->_getParam("id_permintaan_keterangan_tempat_usaha");
			$nama= $this->_getParam("nama");
			$nik= $this->_getParam("nik");
			$no_surat= $this->_getParam("no_surat");
			$tanggal_surat= $this->_getParam("tanggal_surat");
			$nama_surat= "Keterangan keterangan tempat usaha";
			$asal_controller= "keterangantempatusaha";
			$no_registrasi= $this->_getParam("no_registrasi");
			$waktu_antrian= $this->_getParam("waktu_antrian");
			$status= 3;	
			
			//menghitung lama
			
			$waktu_selesai = date("H:i:s");
			$waktu_total = $this->surat_serv->selisih($waktu_antrian,$waktu_selesai);	
			
			
			
			$data = array("id_permintaan_keterangan_tempat_usaha" => $id_permintaan_keterangan_tempat_usaha,
							"status" => $status,
							"waktu_selesai" => $waktu_selesai,
							"waktu_total" => $waktu_total
						);
			
			$hasil = $this->surat_serv->getSelesaiKeterangantempatusaha($data);
			//var_dump($hasil);
			$this->view->asal_controller = $asal_controller;
			$this->view->render = $render;
			$this->view->nik = $nik;
			$this->view->nama = $nama;
			$this->view->no_surat = $no_surat;
			$this->view->tanggal_surat = $tanggal_surat;
			$this->view->nama_surat = $nama_surat;
			$this->view->surat = "Form Tambah Surat";
			$this->render('arsiptambah');			
		}
		
		
			///////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////    PEMERINTAHAN      /////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		
		
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
			
			//mendapatkan jumlah yang belum diproses dan selesai
			$jumlahstatus1 = $this->surat_serv->getJumlahStatusLahir1();	
			if($jumlahstatus1>=1){		
				$peringatanstatus1 = "Ada $jumlahstatus1 surat yang belum diproses. Silakan tekan tombol proses";
			}
			$this->view->jumlahstatus1 = $jumlahstatus1;
			$this->view->peringatanstatus1 = $peringatanstatus1;
			
			$jumlahstatus2 = $this->surat_serv->getJumlahStatusLahir2();
			if($jumlahstatus2>=1){
				$peringatanstatus2 = "Ada $jumlahstatus2 surat yang belum selesai. Silakan tekan tombol selesai";
			}
			$this->view->jumlahstatus2 = $jumlahstatus2;
			$this->view->peringatanstatus2 = $peringatanstatus2;
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
				$nama_pengguna = $this->id_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$no_telp = $_POST['no_telp'];
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
								"status" => $status,
								"no_telp" => $no_telp
								);										 
				$hasil = $this->surat_serv->getsimpanlahirantrian($data);
				
				//simpan data ke tabel no_registrasi
				$registrasi = array("no_registrasi" =>  	$no_registrasi,
				"nik" => $nik							
				);										 
				$hasil2 = $this->surat_serv->getSimpanNoRegistrasi($registrasi);
				
				// var_dump($data);
				// var_dump($hasil);
				// var_dump($hasil2);
				
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
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_lahir= $this->_getParam("id_permintaan_lahir");
			$no_registrasi= $this->_getParam(no_registrasi);
			
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;
			$waktu_antrian= $this->_getParam(waktu_antrian);
			$waktu_sekarang = date("H:i:s");
			$lama = $this->surat_serv->selisih($waktu_antrian,$waktu_sekarang);	
			$this->view->lama= $lama;
			
			$this->view->surat = "Form Isian Surat Keterangan Lahir";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
		}
		public function simpanproseslahirAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->id_pengguna;
				
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
				
				// DATA ANAK
				$nama_anak = $_POST['nama_anak'];
				$jenis_kelamin_anak = $_POST['jenis_kelamin_anak'];
				$tempat_lahir_anak = $_POST['tempat_lahir_anak'];
				$tanggal_lahir_anak = $_POST['tanggal_lahir_anak'];
				$anak_ke = $_POST['anak_ke'];
				$jam_lahir = $_POST['jam_lahir'];
				$hari_lahir = $_POST['hari_lahir'];
				
				//DATA ORANG TUA
				//ayah
				$nama_ayah = $_POST['nama_ayah'];
				$agama_ayah = $_POST['agama_ayah'];
				$pekerjaan_ayah = $_POST['pekerjaan_ayah'];
				$alamat_ayah = $_POST['alamat_ayah'];
				$umur_ayah = $_POST['umur_ayah'];
				
				//ibu
				$nama_ibu = $_POST['nama_ibu'];
				$agama_ibu = $_POST['agama_ibu'];
				$pekerjaan_ibu = $_POST['pekerjaan_ibu'];
				$alamat_ibu = $_POST['alamat_ibu'];
				$umur_ibu= $_POST['umur_ibu'];
				
				$ket = $_POST['ket'];				
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
								
								//data anak
								"nama_anak" => $nama_anak,
								"jenis_kelamin_anak" => $jenis_kelamin_anak,
								"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
								"tempat_lahir_anak" => $tempat_lahir_anak,
								"tanggal_lahir_anak" => $tanggal_lahir_anak,
								"anak_ke" => $anak_ke,
								"jam_lahir" => $jam_lahir,
								
								//data orang tua
								"nama_ayah" => $nama_ayah,
								"agama_ayah" => $agama_ayah,
								"pekerjaan_ayah" => $pekerjaan_ayah,
								"alamat_ayah" => $alamat_ayah,
								"umur_ayah" => $umur_ayah,
								
								"nama_ibu" => $nama_ibu,
								"agama_ibu" => $agama_ibu,
								"pekerjaan_ibu" => $pekerjaan_ibu,
								"alamat_ibu" => $alamat_ibu,
								"umur_ibu" => $umur_ibu,
				
								"status" => $status,
								"waktu_proses" => $waktu_proses,
								"proses_oleh" => $proses_oleh,
								"ket" => $ket
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
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->lahirAction();
				$this->render('lahir');
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
				$this->lahirAction();
				$this->render('lahir');
			}
		}
		
		public function lahirselesaiAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->id_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_lahir= $this->_getParam("id_permintaan_lahir");
			$nama= $this->_getParam("nama");
			$nik= $this->_getParam("nik");
			$no_surat= $this->_getParam("no_surat");
			$tanggal_surat= $this->_getParam("tanggal_surat");
			$nama_surat= "Keterangan lahir";
			$asal_controller= "lahir";
			$no_registrasi= $this->_getParam("no_registrasi");
			$waktu_antrian= $this->_getParam("waktu_antrian");
			$status= 3;	
			
			//menghitung lama
			
			$waktu_selesai = date("H:i:s");
			$waktu_total = $this->surat_serv->selisih($waktu_antrian,$waktu_selesai);	
			
			
			$data = array("id_permintaan_lahir" => $id_permintaan_lahir,
			"status" => $status,
			"waktu_selesai" => $waktu_selesai,
			"waktu_total" => $waktu_total);
			
			$hasil = $this->surat_serv->getSelesaiLahir($data);
			//var_dump($hasil);
			$this->view->asal_controller = $asal_controller;
			$this->view->render = $render;
			$this->view->nik = $nik;
			$this->view->nama = $nama;
			$this->view->no_surat = $no_surat;
			$this->view->tanggal_surat = $tanggal_surat;
			$this->view->nama_surat = $nama_surat;
			$this->view->surat = "Form Tambah Surat";
			$this->render('arsiptambah');
			
			
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
			
			
			//mendapatkan jumlah yang belum diproses dan selesai
			$jumlahstatus1 = $this->surat_serv->getJumlahStatusMati1();	
			if($jumlahstatus1>=1){		
				$peringatanstatus1 = "Ada $jumlahstatus1 surat yang belum diproses. Silakan tekan tombol proses";
			}
			$this->view->jumlahstatus1 = $jumlahstatus1;
			$this->view->peringatanstatus1 = $peringatanstatus1;
			
			$jumlahstatus2 = $this->surat_serv->getJumlahStatusMati2();
			if($jumlahstatus2>=1){
				$peringatanstatus2 = "Ada $jumlahstatus2 surat yang belum selesai. Silakan tekan tombol selesai";
			}
			$this->view->jumlahstatus2 = $jumlahstatus2;
			$this->view->peringatanstatus2 = $peringatanstatus2;
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
				$nama_pengguna = $this->id_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$no_telp = $_POST['no_telp'];
				$waktu_antrian = date('H:i:s');
				$antrian_oleh = $nama_pengguna;
				$jam_masuk = date('H:i:s');
				$status = 1;
				
				
				//simpan data ke tabel mati
				$data = array("id_pengguna" =>  	$id_pengguna,
							"id_kelurahan" => $id_kelurahan,
							"no_registrasi" => $no_registrasi,
							"nik" => $nik,
							"waktu_antrian" => $waktu_antrian,
							"antrian_oleh" => $antrian_oleh,
							"jam_masuk" => $jam_masuk,							
							"status" => $status,
							"no_telp" => $no_telp
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
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_mati= $this->_getParam("id_permintaan_mati");
			$no_registrasi= $this->_getParam(no_registrasi);
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;
			
			$waktu_antrian= $this->_getParam(waktu_antrian);
			$waktu_sekarang = date("H:i:s");
			$lama = $this->surat_serv->selisih($waktu_antrian,$waktu_sekarang);	
			$this->view->lama= $lama;
			
			$this->view->surat = "Form Isian Surat Keterangan mati";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
		}
		public function simpanprosesmatiAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->id_pengguna;
				
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
				$ket =$_POST['ket'];
				
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
							"ket" => $ket
						);
				
				$hasil = $this->surat_serv->getsimpanprosesmati($data);
				//jika gagal
				if($hasil=='gagal'){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
					$this->matiAction();
					$this->render('mati');	
				}
				//jika sukses
				if($hasil=='sukses'){
					$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diproses </div>";		
					$this->matiAction();
					$this->render('mati');
				}
			}else{
				$this->matiAction();
				$this->render('mati');
			}
			
		}
		public function matihapusAction(){
			$id_permintaan_mati= $this->_getParam("id_permintaan_mati");
			$hasil = $this->surat_serv->gethapusmati($id_permintaan_mati);
			
			//jika gagal
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->matiAction();
				$this->render('mati');	
			}
			//jika sukses
			if($hasil=='sukses'){
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
				$this->matiAction();
				$this->render('mati');
			}			
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
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->matiAction();
				$this->render('mati');	
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
				$this->matiAction();
				$this->render('mati');
			}
		}
		
		//proses selesai
		public function matiselesaiAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->id_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_mati= $this->_getParam("id_permintaan_mati");
			$nama= $this->_getParam("nama");
			$nik= $this->_getParam("nik");
			$no_surat= $this->_getParam("no_surat");
			$tanggal_surat= $this->_getParam("tanggal_surat");
			$nama_surat= "Keterangan Kematian";
			$asal_controller= "mati";
			$no_registrasi= $this->_getParam("no_registrasi");
			$waktu_antrian= $this->_getParam("waktu_antrian");
			$status= 3;	
			
			//menghitung lama
			
			$waktu_selesai = date("H:i:s");
			$waktu_total = $this->surat_serv->selisih($waktu_antrian,$waktu_selesai);	
			
			
			
			$data = array("id_permintaan_mati" => $id_permintaan_mati,
			"status" => $status,
			"waktu_selesai" => $waktu_selesai,
			"waktu_total" => $waktu_total);
			
			$hasil = $this->surat_serv->getSelesaiMati($data);
			//var_dump($hasil);
			$this->view->asal_controller = $asal_controller;
			$this->view->render = $render;
			$this->view->nik = $nik;
			$this->view->nama = $nama;
			$this->view->no_surat = $no_surat;
			$this->view->tanggal_surat = $tanggal_surat;
			$this->view->nama_surat = $nama_surat;
			$this->view->surat = "Form Tambah Surat";
			$this->render('arsiptambah');	
		}
		
		
		////////////////////-------------------- 9. Ahli waris
		
		//cetak surat mati
		public function ahliwariscetakAction(){
			$id_permintaan_waris = $this->_getParam("id_permintaan_waris");
			$this->view->hasil = $this->surat_serv->getahliwariscetak($id_permintaan_waris);
			
		}
		
		public function ahliwarisAction(){
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
			$this->view->jumData = $this->surat_serv->getJumlahahliwaris($this->id_kelurahan);
			$this->view->dataPerPage = $dataPerPage;
			$this->view->noPage = $noPage;
			$this->view->offset=$offset;
			
			$this->view->surat = "Surat Keterangan ahli waris";
			$this->view->permintaan = $this->surat_serv->getProsesahliwaris($this->id_kelurahan,$offset ,$dataPerPage);
			
			
			//mendapatkan jumlah yang belum diproses dan selesai
			$jumlahstatus1 = $this->surat_serv->getJumlahStatusahliwaris1();	
			if($jumlahstatus1>=1){		
				$peringatanstatus1 = "Ada $jumlahstatus1 surat yang belum diproses. Silakan tekan tombol proses";
			}
			$this->view->jumlahstatus1 = $jumlahstatus1;
			$this->view->peringatanstatus1 = $peringatanstatus1;
			
			$jumlahstatus2 = $this->surat_serv->getJumlahStatusahliwaris2();
			if($jumlahstatus2>=1){
				$peringatanstatus2 = "Ada $jumlahstatus2 surat yang belum selesai. Silakan tekan tombol selesai";
			}
			$this->view->jumlahstatus2 = $jumlahstatus2;
			$this->view->peringatanstatus2 = $peringatanstatus2;
		}
		
		public function pencarianahliwarisAction(){
			$this->view;
			$this->view->kelurahan = $this->id_kelurahan;
			$this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			$id_pencarian = $_POST['id_pencarian'];
			$pencarian = $_POST['pencarian'];
			if(!$pencarian){
				$this->ahliwarisAction();
				$this->render('ahliwaris');
				}else{
				$this->view->surat = "Surat Keterangan Ahli Waris";
				$this->view->cari = $pencarian;
				$this->view->permintaan = $this->surat_serv->getPencarianahliwaris($this->id_kelurahan,$pencarian,$id_pencarian);
			}
		}
		
		public function caripendudukahliwarisAction() {
			$this->view;
			$this->view->surat = "Form Isian Surat Keterangan Ahli Waris";
			$this->view->judul = "Masukan NIK";
		}
		//antrian mati --> proses memasukan ke antrian mati, status = 1
		public function ahliwarisantrianAction(){
			$nik = $_POST['nik'];
			$this->view->surat = "Surat Keterangan Ahli Waris";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			
			//mengambil noregistrasi secara automatis
			$no_registrasi = $this->surat_serv->getNoRegistrasi(4,148); //4 adalah panjangnya, AN adalah kode huruf
			$this->view->no_registrasi=$no_registrasi;
			
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('ahliwarisantrian');
			
		}
		
		//menyimpan antrian ahliwaris
		public function simpanahliwarisantrianAction(){
			if(isset($_POST['name'])){ 
				$id_kelurahan = $this->id_kelurahan;			
				$id_pengguna = $this->id_pengguna;		
				$nama_pengguna = $this->id_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$no_telp = $_POST['no_telp'];
				$waktu_antrian = date('H:i:s');
				$antrian_oleh = $nama_pengguna;
				$jam_masuk = date('H:i:s');
				$status = 1;
				
				
				//simpan data ke tabel ahliwaris
				$data = array("id_pengguna" =>  	$id_pengguna,
							"id_kelurahan" => $id_kelurahan,
							"no_registrasi" => $no_registrasi,
							"nik" => $nik,
							"waktu_antrian" => $waktu_antrian,
							"antrian_oleh" => $antrian_oleh,
							"jam_masuk" => $jam_masuk,							
							"status" => $status,
							"no_telp" => $no_telp
							);										 
				$hasil = $this->surat_serv->getsimpanahliwarisantrian($data);
				
				//simpan data ke tabel no_registrasi
				$registrasi = array("no_registrasi" =>  	$no_registrasi,
				"nik" => $nik							
				);										 
				$hasil = $this->surat_serv->getSimpanNoRegistrasi($registrasi);
				
				
				//jika gagal
				if($hasil=="gagal"){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
					$this->ahliwarisAction();
					$this->render('ahliwaris');					
				}
				//jika sukses
				if($hasil=="sukses"){
					$this->view->peringatan ="<div class='sukses'> Sukses, data berhasil ditambahkan ke antrian </div>";		
					$this->ahliwarisAction();
					$this->render('ahliwaris');
				}	
				}else{
				$this->ahliwarisAction();
				$this->render('ahliwaris');
			}
			
		}
		
		
		public function ahliwarisprosesAction(){
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_waris= $this->_getParam("id_permintaan_waris");
			$no_registrasi= $this->_getParam(no_registrasi);
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;
			// $this->view->id_permintaan_waris= $id_permintaan_waris;
			
			$waktu_antrian= $this->_getParam(waktu_antrian);
			$waktu_sekarang = date("H:i:s");
			$lama = $this->surat_serv->selisih($waktu_antrian,$waktu_sekarang);	
			$this->view->lama= $lama;
			
			$this->view->surat = "Form Isian Surat Keterangan ahliwaris";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
		}
		public function simpanprosesahliwarisAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->id_pengguna;
				
				$waktu_proses = date("H:i:s");
				$proses_oleh= $nama_pengguna;
				
				$id_kelurahan = $this->id_kelurahan;
				$id_permintaan_waris = $_POST['id_permintaan_waris'];
				$id_jenis_surat = $_POST['id_jenis_surat'];
				$id_surat = $_POST['id_surat'];
				$nik = $_POST['nik'];
				$id_pejabat = $_POST['id_pejabat'];
				$no_surat = $_POST['no_surat'];
				$tanggal_surat = $_POST['tanggal_surat'];
				$no_surat_pengantar = $_POST['no_surat_pengantar'];
				$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
				
				$berdasarkan= $_POST['berdasarkan'];
				$hari_meninggal= $_POST['hari_meninggal'];
				$tanggal_meninggal= $_POST['tanggal_meninggal'];
				$tempat_meninggal =$_POST['tempat_meninggal'];
				$sebab_meninggal =$_POST['sebab_meninggal'];
				$keperluan =$_POST['keperluan'];
				$ket =$_POST['ket'];
				
				$status = 2;
				
				$data = array("id_kelurahan" =>  	$id_kelurahan,
							"id_permintaan_waris" => $id_permintaan_waris,
							"nik" => $nik,
							"id_pejabat" => $id_pejabat,
							"id_jenis_surat" => $id_jenis_surat,
							"id_surat" => $id_surat,
							"no_surat" => $no_surat,
							"tanggal_surat" => $tanggal_surat,
							"no_surat_pengantar" => $no_surat_pengantar,
							"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
							"status" => $status,
							"berdasarkan" => $berdasarkan,
							"tanggal_meninggal" => $tanggal_meninggal,
							"tempat_meninggal" => $tempat_meninggal,
							"sebab_meninggal" => $sebab_meninggal,
							"hari_meninggal" => $hari_meninggal,
							"keperluan" => $keperluan,
							"waktu_proses" => $waktu_proses,
							"proses_oleh" => $proses_oleh,
							"ket" => $ket
						);
				var_dump($data);
				$hasil = $this->surat_serv->getsimpanprosesahliwaris($data);
				//jika gagal
				if($hasil=='gagal'){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
					$this->ahliwarisAction();
					$this->render('ahliwaris');	
				}
				//jika sukses
				if($hasil=='sukses'){
					$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diproses </div>";		
					$this->ahliwarisAction();
					$this->render('ahliwaris');
				}
			}else{
				$this->ahliwarisAction();
				$this->render('ahliwaris');
			}
			
		}
		public function ahliwarishapusAction(){
			$id_permintaan_waris= $this->_getParam("id_permintaan_waris");
			$hasil = $this->surat_serv->gethapusahliwaris($id_permintaan_waris);
			
			//jika gagal
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->ahliwarisAction();
				$this->render('ahliwaris');	
			}
			//jika sukses
			if($hasil=='sukses'){
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
				$this->ahliwarisAction();
				$this->render('ahliwaris');
			}			
		}
		public function ahliwariseditAction(){
			$id_permintaan_waris = $this->_getParam("id_permintaan_waris");
			$this->view->hasil = $this->surat_serv->getahliwaris($id_permintaan_waris);
		}
		
		public function simpanprosesahliwariseditAction(){
			$id_permintaan_waris = $this->_getParam('id_permintaan_waris');
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
							"id_permintaan_waris" => $id_permintaan_waris,
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
			
			$hasil = $this->surat_serv->getsimpanahliwarisedit($data);
			//jika gagal
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->ahliwarisAction();
				$this->render('ahliwaris');	
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
				$this->ahliwarisAction();
				$this->render('ahliwaris');
			}
		}
		
		//proses selesai
		public function ahliwarisselesaiAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->id_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_waris= $this->_getParam("id_permintaan_waris");
			$nama= $this->_getParam("nama");
			$nik= $this->_getParam("nik");
			$no_surat= $this->_getParam("no_surat");
			$tanggal_surat= $this->_getParam("tanggal_surat");
			$nama_surat= "Keterangan Keahliwarisan";
			$asal_controller= "ahliwaris";
			$no_registrasi= $this->_getParam("no_registrasi");
			$waktu_antrian= $this->_getParam("waktu_antrian");
			$status= 3;	
			
			//menghitung lama
			
			$waktu_selesai = date("H:i:s");
			$waktu_total = $this->surat_serv->selisih($waktu_antrian,$waktu_selesai);	
			
			
			
			$data = array("id_permintaan_waris" => $id_permintaan_waris,
			"status" => $status,
			"waktu_selesai" => $waktu_selesai,
			"waktu_total" => $waktu_total);
			
			$hasil = $this->surat_serv->getSelesaiahliwaris($data);
			//var_dump($hasil);
			$this->view->asal_controller = $asal_controller;
			$this->view->render = $render;
			$this->view->nik = $nik;
			$this->view->nama = $nama;
			$this->view->no_surat = $no_surat;
			$this->view->tanggal_surat = $tanggal_surat;
			$this->view->nama_surat = $nama_surat;
			$this->view->surat = "Form Tambah Surat";
			$this->render('arsiptambah');	
		}
		
		
	
		
		/////////////////////////////////////////------- 11. DOMISILI PENDUDUK
		//cetak surat domisilipenduduk
		public function domisilipendudukcetakAction(){
			$id_permintaan_domisili_penduduk = $this->_getParam("id_permintaan_domisili_penduduk");
			$this->view->hasil = $this->surat_serv->getdomisilipendudukcetak($id_permintaan_domisili_penduduk);
		}
		
		public function domisilipendudukAction(){
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
			$this->view->jumData = $this->surat_serv->getJumlahdomisilipenduduk($this->id_kelurahan);
			$this->view->dataPerPage = $dataPerPage;
			$this->view->noPage = $noPage;
			$this->view->offset=$offset;
			
			$this->view->surat = "Surat Domisili Penduduk";
			$this->view->permintaan = $this->surat_serv->getProsesdomisilipenduduk($this->id_kelurahan,$offset , $dataPerPage);
			
			//mendapatkan jumlah yang belum diproses dan selesai
			$jumlahstatus1 = $this->surat_serv->getJumlahStatusdomisilipenduduk1();	
			if($jumlahstatus1>=1){		
				$peringatanstatus1 = "Ada $jumlahstatus1 surat yang belum diproses. Silakan tekan tombol proses";
			}
			$this->view->jumlahstatus1 = $jumlahstatus1;
			$this->view->peringatanstatus1 = $peringatanstatus1;
			
			$jumlahstatus2 = $this->surat_serv->getJumlahStatusdomisilipenduduk2();
			if($jumlahstatus2>=1){
				$peringatanstatus2 = "Ada $jumlahstatus2 surat yang belum selesai. Silakan tekan tombol selesai";
			}
			$this->view->jumlahstatus2 = $jumlahstatus2;
			$this->view->peringatanstatus2 = $peringatanstatus2;
		}
		
		public function pencariandomisilipendudukAction(){
			$this->view;
			$this->view->kelurahan = $this->id_kelurahan;
			$this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			$id_pencarian = $_POST['id_pencarian'];
			$pencarian = $_POST['pencarian'];
			if(!$pencarian){
				$this->domisilipendudukAction();
				$this->render('domisilipenduduk');
				}else{
				$this->view->surat = "Surat Keterangan Domisili Penduduk";
				$this->view->cari = $pencarian;
				$this->view->permintaan = $this->surat_serv->getPencariandomisilipenduduk($this->id_kelurahan,$pencarian,$id_pencarian);
			}
			
		}
		
		public function caripendudukdomisilipendudukAction() {
			$this->view;
			$this->view->surat = "Form Isian Surat Domisili Penduduk";
			$this->view->judul = "Masukan NIK";
		}
		
		//antrian domisilipenduduk --> proses memasukan ke antrian domisilipenduduk, status = 1
		public function domisilipendudukantrianAction(){
			$nik = $_POST['nik'];
			$this->view->surat = "Form Antrian Keterangan domisili Penduduk";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			
			//mengambil noregistrasi secara automatis
			$no_registrasi = $this->surat_serv->getNoRegistrasi(4,DMP); //4 adalah panjangnya, AN adalah kode huruf
			$this->view->no_registrasi=$no_registrasi;
			
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('domisilipendudukantrian');
			
		}
		
		//menyimpan antrian domisilipenduduk
		public function simpandomisilipendudukantrianAction(){
			if(isset($_POST['name'])){ 
				$id_kelurahan = $this->id_kelurahan;			
				$id_pengguna = $this->id_pengguna;		
				$nama_pengguna = $this->id_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$no_telp = $_POST['no_telp'];
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
								"status" => $status,
								"no_telp" => $no_telp
								);										 
				$hasil = $this->surat_serv->getsimpandomisilipendudukantrian($data);
				
				//simpan data ke tabel no_registrasi
				$registrasi = array("no_registrasi" =>  	$no_registrasi,
									"nik" => $nik							
									);										 
				$hasil = $this->surat_serv->getSimpanNoRegistrasi($registrasi);
				
				
				//jika gagal
				if($hasil=="gagal"){
					$this->view->peringatan ="<div class='gagal'>$hasil. Maaf ada kesalahan</div>";
					$this->domisilipendudukAction();
					$this->render('domisilipenduduk');					
				}
				//jika sukses
				if($hasil=="sukses"){
					$this->view->peringatan ="<div class='sukses'> Sukses, data berhasil ditambahkan ke antrian </div>";		
					$this->domisilipendudukAction();
					$this->render('domisilipenduduk');
				}	
				}else{
				$this->domisilipendudukAction();
				$this->render('domisilipenduduk');
			}
			
		}
		
		
		public function domisilipendudukprosesAction(){
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_domisili_penduduk= $this->_getParam("id_permintaan_domisili_penduduk");
			$no_registrasi= $this->_getParam(no_registrasi);
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;
			
			$waktu_antrian= $this->_getParam(waktu_antrian);
			$waktu_sekarang = date("H:i:s");
			$lama = $this->surat_serv->selisih($waktu_antrian,$waktu_sekarang);	
			$this->view->lama= $lama;
			
			$this->view->surat = "Form Isian Surat Domisili Penduduk";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
		}
		
		public function simpanprosesdomisilipendudukAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->id_pengguna;
				
				$waktu_proses = date("H:i:s");
				$proses_oleh= $nama_pengguna;
				
				$id_kelurahan = $this->id_kelurahan;
				$id_permintaan_domisili_penduduk = $_POST['id_permintaan_domisili_penduduk'];
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
				$ket = $_POST['ket'];
				$status = 2;
				
				$data = array("id_kelurahan" =>  	$id_kelurahan,
								"id_permintaan_domisili_penduduk" => $id_permintaan_domisili_penduduk,
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
								"status" => $status,
								"waktu_proses" => $waktu_proses,
								"proses_oleh" => $proses_oleh,
								"ket" => $ket
							);
				
				$hasil = $this->surat_serv->getsimpanprosesdomisilipenduduk($data);
				// var_dump($hasil);
				// var_dump($data);
				//jika gagal
				if($hasil=='gagal'){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
					$this->domisilipendudukAction();
					$this->render('domisilipenduduk');	
				}
				//jika sukses
				//jika sukses
				if($hasil=='sukses'){
					$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diproses </div>";		
					$this->domisilipendudukAction();
					$this->render('domisilipenduduk');
				}
			}else{
				$this->domisilipendudukAction();
				$this->render('domisilipenduduk');
			}
			
		}
		public function domisilipendudukhapusAction(){
			$id_permintaan_domisili_penduduk= $this->_getParam("id_permintaan_domisili_penduduk");
			$hasil = $this->surat_serv->gethapusdomisilipenduduk($id_permintaan_domisili_penduduk);
			
			//jika gagal
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->domisilipendudukAction();
				$this->render('domisilipenduduk');	
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
				$this->domisilipendudukAction();
				$this->render('domisilipenduduk');	
			}
		}
		public function domisilipendudukeditAction(){
			$id_permintaan_domisili_penduduk = $this->_getParam("id_permintaan_domisili_penduduk");
			$this->view->hasil = $this->surat_serv->getdomisilipenduduk($id_permintaan_domisili_penduduk);
		}
		
		public function simpanprosesdomisilipendudukeditAction(){
			
			$id_permintaan_domisili_penduduk = $this->_getParam('id_permintaan_domisili_penduduk');
			$id_kelurahan = $this->id_kelurahan;
			$nik = $_POST['nik'];
			$no_surat = $_POST['no_surat'];
			$tanggal_surat = $_POST['tanggal_surat'];
			$no_surat_pengantar = $_POST['no_surat_pengantar'];
			$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];			
			$keperluan = $_POST['keperluan'];
			$masa_berlaku = $_POST['masa_berlaku'];
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
						"id_permintaan_domisili_penduduk" => $id_permintaan_domisili_penduduk,
						"nik" => $nik,
						"no_surat" => $no_surat,
						"tanggal_surat" => $tanggal_surat,
						"no_surat_pengantar" => $no_surat_pengantar,
						"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
						"keperluan" => $keperluan,
						"masa_berlaku" => $masa_berlaku
						);
			
			$hasil = $this->surat_serv->getsimpanprosesdomisilipendudukedit($data);
			//jika gagal
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->domisilipendudukAction();
				$this->render('domisilipenduduk');	
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
				$this->domisilipendudukAction();
				$this->render('domisilipenduduk');		
			}
		}
		
		//proses selesai
		public function domisilipendudukselesaiAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->id_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_domisili_penduduk= $this->_getParam("id_permintaan_domisili_penduduk");
			$nama= $this->_getParam("nama");
			$nik= $this->_getParam("nik");
			$no_surat= $this->_getParam("no_surat");
			$tanggal_surat= $this->_getParam("tanggal_surat");
			$nama_surat= "Keterangan domisili Penduduk";
			$asal_controller= "domisilipenduduk";
			$no_registrasi= $this->_getParam("no_registrasi");
			$waktu_antrian= $this->_getParam("waktu_antrian");
			$status= 3;	
			
			//menghitung lama
			
			$waktu_selesai = date("H:i:s");
			$waktu_total = $this->surat_serv->selisih($waktu_antrian,$waktu_selesai);				
			
			$data = array("id_permintaan_domisili_penduduk" => $id_permintaan_domisili_penduduk,
							"status" => $status,
							"waktu_selesai" => $waktu_selesai,
							"waktu_total" => $waktu_total
						);
			
			$hasil = $this->surat_serv->getSelesaidomisilipenduduk($data);
			//var_dump($hasil);
			$this->view->asal_controller = $asal_controller;
			$this->view->render = $render;
			$this->view->nik = $nik;
			$this->view->nama = $nama;
			$this->view->no_surat = $no_surat;
			$this->view->tanggal_surat = $tanggal_surat;
			$this->view->nama_surat = $nama_surat;
			$this->view->surat = "Form Tambah Surat";
			$this->render('arsiptambah');	
		} //////////// END 11. DOMISILI PENDUDUK
		
		
		/////////////////////////////////////////------- 11. KT AJB
		//cetak surat KT AJB
		public function ktbajbcetakAction(){
			$id_permintaan_ajb = $this->_getParam("id_permintaan_ajb");
			$this->view->hasil = $this->surat_serv->getktbajbcetak($id_permintaan_ajb);
		}
		
		public function ktbajbAction(){
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
			$this->view->jumData = $this->surat_serv->getJumlahktbajb($this->id_kelurahan);
			$this->view->dataPerPage = $dataPerPage;
			$this->view->noPage = $noPage;
			$this->view->offset=$offset;
			
			$this->view->surat = "Surat Ket. Tanah & Bangunan (AJB)";
			$this->view->permintaan = $this->surat_serv->getProsesktbajb($this->id_kelurahan,$offset , $dataPerPage);
			
			//mendapatkan jumlah yang belum diproses dan selesai
			$jumlahstatus1 = $this->surat_serv->getJumlahStatusktbajb1();	
			if($jumlahstatus1>=1){		
				$peringatanstatus1 = "Ada $jumlahstatus1 surat yang belum diproses. Silakan tekan tombol proses";
			}
			$this->view->jumlahstatus1 = $jumlahstatus1;
			$this->view->peringatanstatus1 = $peringatanstatus1;
			
			$jumlahstatus2 = $this->surat_serv->getJumlahStatusktbajb2();
			if($jumlahstatus2>=1){
				$peringatanstatus2 = "Ada $jumlahstatus2 surat yang belum selesai. Silakan tekan tombol selesai";
			}
			$this->view->jumlahstatus2 = $jumlahstatus2;
			$this->view->peringatanstatus2 = $peringatanstatus2;
		}
		
		public function pencarianktbajbAction(){
			$this->view;
			$this->view->kelurahan = $this->id_kelurahan;
			$this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			$id_pencarian = $_POST['id_pencarian'];
			$pencarian = $_POST['pencarian'];
			if(!$pencarian){
				$this->ktbajbAction();
				$this->render('ktbajb');
				}else{
				$this->view->surat = "Surat  Ket. Tanah & Bangunan (AJB)";
				$this->view->cari = $pencarian;
				$this->view->permintaan = $this->surat_serv->getPencarianktbajb($this->id_kelurahan,$pencarian,$id_pencarian);
			}
			
		}
		
		public function caripendudukktbajbAction() {
			$this->view;
			$this->view->surat = "Form Isian Surat Ket. Tanah & Bangunan (AJB)";
			$this->view->judul = "Masukan NIK";
		}
		
		//antrian ktbajb --> proses memasukan ke antrian ktbajb, status = 1
		public function ktbajbantrianAction(){
			$nik = $_POST['nik'];
			$this->view->surat = "Form Antrian Ket. Tanah & Bangunan (AJB)";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			
			//mengambil noregistrasi secara automatis
			$no_registrasi = $this->surat_serv->getNoRegistrasi(4,DMP); //4 adalah panjangnya, AN adalah kode huruf
			$this->view->no_registrasi=$no_registrasi;
			
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('ktbajbantrian');
			
		}
		
		//menyimpan antrian ktbajb
		public function simpanktbajbantrianAction(){
			if(isset($_POST['name'])){ 
				$id_kelurahan = $this->id_kelurahan;			
				$id_pengguna = $this->id_pengguna;		
				$nama_pengguna = $this->id_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$no_telp = $_POST['no_telp'];
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
								"status" => $status,
								"no_telp" => $no_telp
								);										 
				$hasil = $this->surat_serv->getsimpanktbajbantrian($data);
				
				//simpan data ke tabel no_registrasi
				$registrasi = array("no_registrasi" =>  	$no_registrasi,
									"nik" => $nik							
									);										 
				$hasil = $this->surat_serv->getSimpanNoRegistrasi($registrasi);
				
				
				//jika gagal
				if($hasil=="gagal"){
					$this->view->peringatan ="<div class='gagal'>$hasil. Maaf ada kesalahan</div>";
					$this->ktbajbAction();
					$this->render('ktbajb');					
				}
				//jika sukses
				if($hasil=="sukses"){
					$this->view->peringatan ="<div class='sukses'> Sukses, data berhasil ditambahkan ke antrian </div>";		
					$this->ktbajbAction();
					$this->render('ktbajb');
				}	
				}else{
				$this->ktbajbAction();
				$this->render('ktbajb');
			}
			
		}
		
		
		public function ktbajbprosesAction(){
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_ajb= $this->_getParam("id_permintaan_ajb");
			$no_registrasi= $this->_getParam(no_registrasi);
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;
			
			$waktu_antrian= $this->_getParam(waktu_antrian);
			$waktu_sekarang = date("H:i:s");
			$lama = $this->surat_serv->selisih($waktu_antrian,$waktu_sekarang);	
			$this->view->lama= $lama;
			
			$this->view->surat = "Form Isian Surat Ket. Tanah & Bangunan (AJB)";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
		}
		
		public function simpanprosesktbajbAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->id_pengguna;
				
				$waktu_proses = date("H:i:s");
				$proses_oleh= $nama_pengguna;
				
				$id_kelurahan = $this->id_kelurahan;
				$id_permintaan_ajb = $_POST['id_permintaan_ajb'];
				$id_jenis_surat = $_POST['id_jenis_surat'];
				$id_surat = $_POST['id_surat'];
				
				$nik = $_POST['nik'];
				$id_pejabat = $_POST['id_pejabat'];
				$no_surat = $_POST['no_surat'];
				$tanggal_surat = $_POST['tanggal_surat'];
				$no_surat_pengantar = $_POST['no_surat_pengantar'];
				$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
				$keperluan = $_POST['keperluan'];	
				$ket = $_POST['ket'];
				$status = 2;
				
				//////// form isian ktbajb
				$nama_pemilik = $_POST['nama_pemilik'];
				$alamat_pemilik = $_POST['alamat_pemilik'];
				$pekerjaan_pemilik = $_POST['pekerjaan_pemilik'];
				$luas_tanah = $_POST['luas_tanah'];
				$luas_bangunan = $_POST['luas_bangunan'];
				$no_persil = $_POST['no_persil'];
				$no_kohir = $_POST['no_kohir'];
				$blok_tanah = $_POST['blok_tanah'];
				$rt_tanah = $_POST['rt_tanah'];
				$rw_tanah = $_POST['rw_tanah'];
				$kel_tanah = $_POST['kel_tanah'];
				$kec_tanah = $_POST['kec_tanah'];
				$no_akta = $_POST['no_akta'];
				$batas_utara = $_POST['batas_utara'];
				$batas_barat = $_POST['batas_barat'];
				$batas_timur = $_POST['batas_timur'];
				$batas_selatan = $_POST['batas_selatan'];
				$no_pbb = $_POST['no_pbb'];
				$harga_tanah = $_POST['harga_tanah'];
				$harga_bangunan = $_POST['harga_bangunan'];
				
				$data = array("id_kelurahan" =>  	$id_kelurahan,
								"id_permintaan_ajb" => $id_permintaan_ajb,
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
								"status" => $status,
								"waktu_proses" => $waktu_proses,
								"proses_oleh" => $proses_oleh,
								"ket" => $ket,
								
								////// form isian ktbajb
								"nama_pemilik" => $nama_pemilik,
								"alamat_pemilik" => $alamat_pemilik,
								"pekerjaan_pemilik" => $pekerjaan_pemilik,
								"luas_tanah" => $luas_tanah,
								"luas_bangunan" => $luas_bangunan,
								"no_persil" => $no_persil,
								"no_kohir" => $no_kohir,
								"blok_tanah" => $blok_tanah,
								"rt_tanah" => $rt_tanah,
								"rw_tanah" => $rw_tanah,
								"kel_tanah" => $kel_tanah,
								"kec_tanah" => $kec_tanah,
								"no_akta" => $no_akta,
								"batas_utara" => $batas_utara,
								"batas_barat" => $batas_barat,
								"batas_timur" => $batas_timur,
								"batas_selatan" => $batas_selatan,
								"no_pbb" => $no_pbb,
								"harga_tanah" => $harga_tanah,
								"harga_bangunan" => $harga_bangunan
								
							);
				
				$hasil = $this->surat_serv->getsimpanprosesktbajb($data);
				// var_dump($hasil);
				// var_dump($data);
				//jika gagal
				if($hasil=='gagal'){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
					$this->ktbajbAction();
					$this->render('ktbajb');	
				}
				//jika sukses
				//jika sukses
				if($hasil=='sukses'){
					$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diproses </div>";		
					$this->ktbajbAction();
					$this->render('ktbajb');
				}
			}else{
				$this->ktbajbAction();
				$this->render('ktbajb');
			}
			
		}
		public function ktbajbhapusAction(){
			$id_permintaan_ajb= $this->_getParam("id_permintaan_ajb");
			$hasil = $this->surat_serv->gethapusktbajb($id_permintaan_ajb);
			
			//jika gagal
		if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->ktbajbAction();
				$this->render('ktbajb');	
			}
			//jika sukses
			if($hasil=='sukses'){
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
			$this->ktbajbAction();
			$this->render('ktbajb');	
			}
		}
		public function ktbajbeditAction(){
			$id_permintaan_ajb = $this->_getParam("id_permintaan_ajb");
			$this->view->hasil = $this->surat_serv->getktbajb($id_permintaan_ajb);
		}
		
		public function simpanprosesktbajbeditAction(){
			
			$id_permintaan_ajb = $this->_getParam('id_permintaan_ajb');
			$id_kelurahan = $this->id_kelurahan;
			$nik = $_POST['nik'];
			$no_surat = $_POST['no_surat'];
			$tanggal_surat = $_POST['tanggal_surat'];
			$no_surat_pengantar = $_POST['no_surat_pengantar'];
			$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];			
			$keperluan = $_POST['keperluan'];
			$masa_berlaku = $_POST['masa_berlaku'];
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
					"id_permintaan_ajb" => $id_permintaan_ajb,
					"nik" => $nik,
					"no_surat" => $no_surat,
					"tanggal_surat" => $tanggal_surat,
					"no_surat_pengantar" => $no_surat_pengantar,
					"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
					"keperluan" => $keperluan,
					"masa_berlaku" => $masa_berlaku
					);
			
			$hasil = $this->surat_serv->getsimpanprosesktbajbedit($data);
			//jika gagal
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->ktbajbAction();
				$this->render('ktbajb');	
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
				$this->ktbajbAction();
				$this->render('ktbajb');		
			}
		}
		
		//proses selesai
		public function ktbajbselesaiAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->id_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_ajb= $this->_getParam("id_permintaan_ajb");
			$nama= $this->_getParam("nama");
			$nik= $this->_getParam("nik");
			$no_surat= $this->_getParam("no_surat");
			$tanggal_surat= $this->_getParam("tanggal_surat");
			$nama_surat= "Ket. Tanah & Bangunan (AJB)";
			$asal_controller= "ktbajb";
			$no_registrasi= $this->_getParam("no_registrasi");
			$waktu_antrian= $this->_getParam("waktu_antrian");
			$status= 3;	
			
			//menghitung lama
			
			$waktu_selesai = date("H:i:s");
			$waktu_total = $this->surat_serv->selisih($waktu_antrian,$waktu_selesai);				
			
			$data = array("id_permintaan_ajb" => $id_permintaan_ajb,
							"status" => $status,
							"waktu_selesai" => $waktu_selesai,
							"waktu_total" => $waktu_total
						);
			
			$hasil = $this->surat_serv->getSelesaiktbajb($data);
			//var_dump($hasil);
			$this->view->asal_controller = $asal_controller;
			$this->view->render = $render;
			$this->view->nik = $nik;
			$this->view->nama = $nama;
			$this->view->no_surat = $no_surat;
			$this->view->tanggal_surat = $tanggal_surat;
			$this->view->nama_surat = $nama_surat;
			$this->view->surat = "Form Tambah Surat";
			$this->render('arsiptambah');	
		} //////////// END 11. Ket. Tanah & Bangunan (AJB)
		
		
		/////////////////////////////////////////------- 11. MUTASI PBB
		//cetak surat mutasi pbb
		public function mutasipbbcetakAction(){
			$id_permintaan_mutasi_pbb = $this->_getParam("id_permintaan_mutasi_pbb");
			$this->view->hasil = $this->surat_serv->getmutasipbbcetak($id_permintaan_mutasi_pbb);
		}
		
		public function mutasipbbAction(){
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
			$this->view->jumData = $this->surat_serv->getJumlahmutasipbb($this->id_kelurahan);
			$this->view->dataPerPage = $dataPerPage;
			$this->view->noPage = $noPage;
			$this->view->offset=$offset;
			
			$this->view->surat = "Surat Mutasi Balik Nama PBB";
			$this->view->permintaan = $this->surat_serv->getProsesmutasipbb($this->id_kelurahan,$offset , $dataPerPage);
			
			//mendapatkan jumlah yang belum diproses dan selesai
			$jumlahstatus1 = $this->surat_serv->getJumlahStatusmutasipbb1();	
			if($jumlahstatus1>=1){		
				$peringatanstatus1 = "Ada $jumlahstatus1 surat yang belum diproses. Silakan tekan tombol proses";
			}
			$this->view->jumlahstatus1 = $jumlahstatus1;
			$this->view->peringatanstatus1 = $peringatanstatus1;
			
			$jumlahstatus2 = $this->surat_serv->getJumlahStatusmutasipbb2();
			if($jumlahstatus2>=1){
				$peringatanstatus2 = "Ada $jumlahstatus2 surat yang belum selesai. Silakan tekan tombol selesai";
			}
			$this->view->jumlahstatus2 = $jumlahstatus2;
			$this->view->peringatanstatus2 = $peringatanstatus2;
		}
		
		public function pencarianmutasipbbAction(){
			$this->view;
			$this->view->kelurahan = $this->id_kelurahan;
			$this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			$id_pencarian = $_POST['id_pencarian'];
			$pencarian = $_POST['pencarian'];
			if(!$pencarian){
				$this->mutasipbbAction();
				$this->render('mutasipbb');
				}else{
				$this->view->surat = "Surat Mutasi Balik Nama PBB";
				$this->view->cari = $pencarian;
				$this->view->permintaan = $this->surat_serv->getPencarianmutasipbb($this->id_kelurahan,$pencarian,$id_pencarian);
			}
			
		}
		
		public function caripendudukmutasipbbAction() {
			$this->view;
			$this->view->surat = "Form Isian Surat Mutasi Balik Nama PBB";
			$this->view->judul = "Masukan NIK";
		}
		
		//antrian mutasipbb --> proses memasukan ke antrian mutasipbb, status = 1
		public function mutasipbbantrianAction(){
			$nik = $_POST['nik'];
			$this->view->surat = "Form Antrian Surat Mutasi Balik Nama PBB";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			
			//mengambil noregistrasi secara automatis
			$no_registrasi = $this->surat_serv->getNoRegistrasi(4,DMP); //4 adalah panjangnya, AN adalah kode huruf
			$this->view->no_registrasi=$no_registrasi;
			
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('mutasipbbantrian');
			
		}
		
		//menyimpan antrian mutasipbb
		public function simpanmutasipbbantrianAction(){
			if(isset($_POST['name'])){ 
				$id_kelurahan = $this->id_kelurahan;			
				$id_pengguna = $this->id_pengguna;		
				$nama_pengguna = $this->id_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$no_telp = $_POST['no_telp'];
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
								"status" => $status,
								"no_telp" => $no_telp
								);										 
				$hasil = $this->surat_serv->getsimpanmutasipbbantrian($data);
				
				//simpan data ke tabel no_registrasi
				$registrasi = array("no_registrasi" =>  	$no_registrasi,
									"nik" => $nik							
									);										 
				$hasil = $this->surat_serv->getSimpanNoRegistrasi($registrasi);
				
				
				//jika gagal
				if($hasil=="gagal"){
					$this->view->peringatan ="<div class='gagal'>$hasil. Maaf ada kesalahan</div>";
					$this->mutasipbbAction();
					$this->render('mutasipbb');					
				}
				//jika sukses
				if($hasil=="sukses"){
					$this->view->peringatan ="<div class='sukses'> Sukses, data berhasil ditambahkan ke antrian </div>";		
					$this->mutasipbbAction();
					$this->render('mutasipbb');
				}	
				}else{
				$this->mutasipbbAction();
				$this->render('mutasipbb');
			}
			
		}
		
		
		public function mutasipbbprosesAction(){
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_mutasi_pbb= $this->_getParam("id_permintaan_mutasi_pbb");
			$no_registrasi= $this->_getParam(no_registrasi);
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;
			
			$waktu_antrian= $this->_getParam(waktu_antrian);
			$waktu_sekarang = date("H:i:s");
			$lama = $this->surat_serv->selisih($waktu_antrian,$waktu_sekarang);	
			$this->view->lama= $lama;
			
			$this->view->surat = "Form Isian Surat Domisili Penduduk";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
		}
		
		public function simpanprosesmutasipbbAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->id_pengguna;
				
				$waktu_proses = date("H:i:s");
				$proses_oleh= $nama_pengguna;
				
				$id_kelurahan = $this->id_kelurahan;
				$id_permintaan_mutasi_pbb = $_POST['id_permintaan_mutasi_pbb'];
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
				$ket = $_POST['ket'];
				$status = 2;
				
				$data = array("id_kelurahan" =>  	$id_kelurahan,
								"id_permintaan_mutasi_pbb" => $id_permintaan_mutasi_pbb,
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
								"status" => $status,
								"waktu_proses" => $waktu_proses,
								"proses_oleh" => $proses_oleh,
								"ket" => $ket
							);
				
				$hasil = $this->surat_serv->getsimpanprosesmutasipbb($data);
				// var_dump($hasil);
				// var_dump($data);
				//jika gagal
				if($hasil=='gagal'){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
					$this->mutasipbbAction();
					$this->render('mutasipbb');	
				}
				//jika sukses
				//jika sukses
				if($hasil=='sukses'){
					$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diproses </div>";		
					$this->mutasipbbAction();
					$this->render('mutasipbb');
				}
			}else{
				$this->mutasipbbAction();
				$this->render('mutasipbb');
			}
			
		}
		public function mutasipbbhapusAction(){
			$id_permintaan_mutasi_pbb= $this->_getParam("id_permintaan_mutasi_pbb");
			$hasil = $this->surat_serv->gethapusmutasipbb($id_permintaan_mutasi_pbb);
			
			//jika gagal
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->mutasipbbAction();
				$this->render('mutasipbb');	
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
			$this->mutasipbbAction();
			$this->render('mutasipbb');	
		}
		public function mutasipbbeditAction(){
			$id_permintaan_mutasi_pbb = $this->_getParam("id_permintaan_mutasi_pbb");
			$this->view->hasil = $this->surat_serv->getmutasipbb($id_permintaan_mutasi_pbb);
		}
		
		public function simpanprosesmutasipbbeditAction(){
			
			$id_permintaan_mutasi_pbb = $this->_getParam('id_permintaan_mutasi_pbb');
			$id_kelurahan = $this->id_kelurahan;
			$nik = $_POST['nik'];
			$no_surat = $_POST['no_surat'];
			$tanggal_surat = $_POST['tanggal_surat'];
			$no_surat_pengantar = $_POST['no_surat_pengantar'];
			$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];			
			$keperluan = $_POST['keperluan'];
			$masa_berlaku = $_POST['masa_berlaku'];
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
					"id_permintaan_mutasi_pbb" => $id_permintaan_mutasi_pbb,
					"nik" => $nik,
					"no_surat" => $no_surat,
					"tanggal_surat" => $tanggal_surat,
					"no_surat_pengantar" => $no_surat_pengantar,
					"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
					"keperluan" => $keperluan,
					"masa_berlaku" => $masa_berlaku
					);
			
			$hasil = $this->surat_serv->getsimpanprosesmutasipbbedit($data);
			//jika gagal
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->mutasipbbAction();
				$this->render('mutasipbb');	
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
				$this->mutasipbbAction();
				$this->render('mutasipbb');		
			}
		}
		
		//proses selesai
		public function mutasipbbselesaiAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->id_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_mutasi_pbb= $this->_getParam("id_permintaan_mutasi_pbb");
			$nama= $this->_getParam("nama");
			$nik= $this->_getParam("nik");
			$no_surat= $this->_getParam("no_surat");
			$tanggal_surat= $this->_getParam("tanggal_surat");
			$nama_surat= "Keterangan Mutasi Balik Nama PBB";
			$asal_controller= "mutasipbb";
			$no_registrasi= $this->_getParam("no_registrasi");
			$waktu_antrian= $this->_getParam("waktu_antrian");
			$status= 3;	
			
			//menghitung lama
			
			$waktu_selesai = date("H:i:s");
			$waktu_total = $this->surat_serv->selisih($waktu_antrian,$waktu_selesai);				
			
			$data = array("id_permintaan_mutasi_pbb" => $id_permintaan_mutasi_pbb,
							"status" => $status,
							"waktu_selesai" => $waktu_selesai,
							"waktu_total" => $waktu_total
						);
			
			$hasil = $this->surat_serv->getSelesaimutasipbb($data);
			//var_dump($hasil);
			$this->view->asal_controller = $asal_controller;
			$this->view->render = $render;
			$this->view->nik = $nik;
			$this->view->nama = $nama;
			$this->view->no_surat = $no_surat;
			$this->view->tanggal_surat = $tanggal_surat;
			$this->view->nama_surat = $nama_surat;
			$this->view->surat = "Form Tambah Surat";
			$this->render('arsiptambah');	
		} //////////// END 11. DOMISILI PENDUDUK
		
		/////////////////////////////////////////------- 11. Penerbitan PBB
		//cetak surat Penerbitan PBB
		public function penerbitanpbbcetakAction(){
			$id_permintaan_penerbitan_pbb = $this->_getParam("id_permintaan_penerbitan_pbb");
			$this->view->hasil = $this->surat_serv->getpenerbitanpbbcetak($id_permintaan_penerbitan_pbb);
		}
		
		public function penerbitanpbbAction(){
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
			$this->view->jumData = $this->surat_serv->getJumlahpenerbitanpbb($this->id_kelurahan);
			$this->view->dataPerPage = $dataPerPage;
			$this->view->noPage = $noPage;
			$this->view->offset=$offset;
			
			$this->view->surat = "Surat Penerbitan SPPT PBB";
			$this->view->permintaan = $this->surat_serv->getProsespenerbitanpbb($this->id_kelurahan,$offset , $dataPerPage);
			
			//mendapatkan jumlah yang belum diproses dan selesai
			$jumlahstatus1 = $this->surat_serv->getJumlahStatuspenerbitanpbb1();	
			if($jumlahstatus1>=1){		
				$peringatanstatus1 = "Ada $jumlahstatus1 surat yang belum diproses. Silakan tekan tombol proses";
			}
			$this->view->jumlahstatus1 = $jumlahstatus1;
			$this->view->peringatanstatus1 = $peringatanstatus1;
			
			$jumlahstatus2 = $this->surat_serv->getJumlahStatuspenerbitanpbb2();
			if($jumlahstatus2>=1){
				$peringatanstatus2 = "Ada $jumlahstatus2 surat yang belum selesai. Silakan tekan tombol selesai";
			}
			$this->view->jumlahstatus2 = $jumlahstatus2;
			$this->view->peringatanstatus2 = $peringatanstatus2;
		}
		
		public function pencarianpenerbitanpbbAction(){
			$this->view;
			$this->view->kelurahan = $this->id_kelurahan;
			$this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			$id_pencarian = $_POST['id_pencarian'];
			$pencarian = $_POST['pencarian'];
			if(!$pencarian){
				$this->penerbitanpbbAction();
				$this->render('penerbitanpbb');
				}else{
				$this->view->surat = "Surat Penerbitan SPPT PBB";
				$this->view->cari = $pencarian;
				$this->view->permintaan = $this->surat_serv->getPencarianpenerbitanpbb($this->id_kelurahan,$pencarian,$id_pencarian);
			}
			
		}
		
		public function caripendudukpenerbitanpbbAction() {
			$this->view;
			$this->view->surat = "Form Isian Penerbitan SPPT PBB";
			$this->view->judul = "Masukan NIK";
		}
		
		//antrian penerbitanpbb --> proses memasukan ke antrian penerbitanpbb, status = 1
		public function penerbitanpbbantrianAction(){
			$nik = $_POST['nik'];
			$this->view->surat = "Form Antrian Surat Penerbitan SPPT PBB";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			
			//mengambil noregistrasi secara automatis
			$no_registrasi = $this->surat_serv->getNoRegistrasi(4,DMP); //4 adalah panjangnya, AN adalah kode huruf
			$this->view->no_registrasi=$no_registrasi;
			
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('penerbitanpbbantrian');
			
		}
		
		//menyimpan antrian penerbitanpbb
		public function simpanpenerbitanpbbantrianAction(){
			if(isset($_POST['name'])){ 
				$id_kelurahan = $this->id_kelurahan;			
				$id_pengguna = $this->id_pengguna;		
				$nama_pengguna = $this->id_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$no_telp = $_POST['no_telp'];
				$waktu_antrian = date('H:i:s');
				$antrian_oleh = $nama_pengguna;
				$jam_masuk = date('H:i:s');
				$status = 1;
				
				//simpan data ke tabel Penerbitan SPPT PBB
				$data = array("id_pengguna" =>  	$id_pengguna,
								"id_kelurahan" => $id_kelurahan,
								"no_registrasi" => $no_registrasi,
								"nik" => $nik,
								"waktu_antrian" => $waktu_antrian,
								"antrian_oleh" => $antrian_oleh,
								"jam_masuk" => $jam_masuk,							
								"status" => $status,
								"no_telp" => $no_telp
								);										 
				$hasil = $this->surat_serv->getsimpanpenerbitanpbbantrian($data);
				
				//simpan data ke tabel no_registrasi
				$registrasi = array("no_registrasi" =>  	$no_registrasi,
									"nik" => $nik							
									);										 
				$hasil = $this->surat_serv->getSimpanNoRegistrasi($registrasi);
				
				
				//jika gagal
				if($hasil=="gagal"){
					$this->view->peringatan ="<div class='gagal'>$hasil. Maaf ada kesalahan</div>";
					$this->penerbitanpbbAction();
					$this->render('penerbitanpbb');					
				}
				//jika sukses
				if($hasil=="sukses"){
					$this->view->peringatan ="<div class='sukses'> Sukses, data berhasil ditambahkan ke antrian </div>";		
					$this->penerbitanpbbAction();
					$this->render('penerbitanpbb');
				}	
				}else{
				$this->penerbitanpbbAction();
				$this->render('penerbitanpbb');
			}
			
		}
		
		
		public function penerbitanpbbprosesAction(){
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_penerbitan_pbb= $this->_getParam("id_permintaan_penerbitan_pbb");
			$no_registrasi= $this->_getParam(no_registrasi);
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;
			
			$waktu_antrian= $this->_getParam(waktu_antrian);
			$waktu_sekarang = date("H:i:s");
			$lama = $this->surat_serv->selisih($waktu_antrian,$waktu_sekarang);	
			$this->view->lama= $lama;
			
			$this->view->surat = "Form Isian Penerbitan SPPT PBB";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
		}
		
		public function simpanprosespenerbitanpbbAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->id_pengguna;
				
				$waktu_proses = date("H:i:s");
				$proses_oleh= $nama_pengguna;
				
				$id_kelurahan = $this->id_kelurahan;
				$id_permintaan_penerbitan_pbb = $_POST['id_permintaan_penerbitan_pbb'];
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
				$ket = $_POST['ket'];
				$status = 2;
				
				$data = array("id_kelurahan" =>  	$id_kelurahan,
								"id_permintaan_penerbitan_pbb" => $id_permintaan_penerbitan_pbb,
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
								"status" => $status,
								"waktu_proses" => $waktu_proses,
								"proses_oleh" => $proses_oleh,
								"ket" => $ket
							);
				
				$hasil = $this->surat_serv->getsimpanprosespenerbitanpbb($data);
				// var_dump($hasil);
				// var_dump($data);
				//jika gagal
				if($hasil=='gagal'){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
					$this->penerbitanpbbAction();
					$this->render('penerbitanpbb');	
				}
				//jika sukses
				//jika sukses
				if($hasil=='sukses'){
					$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diproses </div>";		
					$this->penerbitanpbbAction();
					$this->render('penerbitanpbb');
				}
			}else{
				$this->penerbitanpbbAction();
				$this->render('penerbitanpbb');
			}
			
		}
		public function penerbitanpbbhapusAction(){
			$id_permintaan_penerbitan_pbb= $this->_getParam("id_permintaan_penerbitan_pbb");
			$hasil = $this->surat_serv->gethapuspenerbitanpbb($id_permintaan_penerbitan_pbb);
			
			//jika gagal
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->penerbitanpbbAction();
				$this->render('penerbitanpbb');	
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
			$this->penerbitanpbbAction();
			$this->render('penerbitanpbb');	
		}
		public function penerbitanpbbeditAction(){
			$id_permintaan_penerbitan_pbb = $this->_getParam("id_permintaan_penerbitan_pbb");
			$this->view->hasil = $this->surat_serv->getpenerbitanpbb($id_permintaan_penerbitan_pbb);
		}
		
		public function simpanprosespenerbitanpbbeditAction(){
			
			$id_permintaan_penerbitan_pbb = $this->_getParam('id_permintaan_penerbitan_pbb');
			$id_kelurahan = $this->id_kelurahan;
			$nik = $_POST['nik'];
			$no_surat = $_POST['no_surat'];
			$tanggal_surat = $_POST['tanggal_surat'];
			$no_surat_pengantar = $_POST['no_surat_pengantar'];
			$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];			
			$keperluan = $_POST['keperluan'];
			$masa_berlaku = $_POST['masa_berlaku'];
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
					"id_permintaan_penerbitan_pbb" => $id_permintaan_penerbitan_pbb,
					"nik" => $nik,
					"no_surat" => $no_surat,
					"tanggal_surat" => $tanggal_surat,
					"no_surat_pengantar" => $no_surat_pengantar,
					"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
					"keperluan" => $keperluan,
					"masa_berlaku" => $masa_berlaku
					);
			
			$hasil = $this->surat_serv->getsimpanprosespenerbitanpbbedit($data);
			//jika gagal
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->penerbitanpbbAction();
				$this->render('penerbitanpbb');	
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
				$this->penerbitanpbbAction();
				$this->render('penerbitanpbb');		
			}
		}
		
		//proses selesai
		public function penerbitanpbbselesaiAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->id_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_penerbitan_pbb= $this->_getParam("id_permintaan_penerbitan_pbb");
			$nama= $this->_getParam("nama");
			$nik= $this->_getParam("nik");
			$no_surat= $this->_getParam("no_surat");
			$tanggal_surat= $this->_getParam("tanggal_surat");
			$nama_surat= "Keterangan Penerbitan PBB";
			$asal_controller= "penerbitanpbb";
			$no_registrasi= $this->_getParam("no_registrasi");
			$waktu_antrian= $this->_getParam("waktu_antrian");
			$status= 3;	
			
			//menghitung lama
			
			$waktu_selesai = date("H:i:s");
			$waktu_total = $this->surat_serv->selisih($waktu_antrian,$waktu_selesai);				
			
			$data = array("id_permintaan_penerbitan_pbb" => $id_permintaan_penerbitan_pbb,
							"status" => $status,
							"waktu_selesai" => $waktu_selesai,
							"waktu_total" => $waktu_total
						);
			
			$hasil = $this->surat_serv->getSelesaipenerbitanpbb($data);
			//var_dump($hasil);
			$this->view->asal_controller = $asal_controller;
			$this->view->render = $render;
			$this->view->nik = $nik;
			$this->view->nama = $nama;
			$this->view->no_surat = $no_surat;
			$this->view->tanggal_surat = $tanggal_surat;
			$this->view->nama_surat = $nama_surat;
			$this->view->surat = "Form Penerbitan SPPT PBB";
			$this->render('arsiptambah');	
		} //////////// END 11. Penerbitan SPPT PBB

		/////////////////////////////////////////------- 11. ORANG YANG SAMA
		//cetak surat Orang yang sama
		public function orangyangsamacetakAction(){
			$id_permintaan_orang_yang_sama = $this->_getParam("id_permintaan_orang_yang_sama");
			$this->view->hasil = $this->surat_serv->getorangyangsamacetak($id_permintaan_orang_yang_sama);
		}
		
		public function orangyangsamaAction(){
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
			$this->view->jumData = $this->surat_serv->getJumlahorangyangsama($this->id_kelurahan);
			$this->view->dataPerPage = $dataPerPage;
			$this->view->noPage = $noPage;
			$this->view->offset=$offset;
			
			$this->view->surat = "Surat Orang yang Sama";
			$this->view->permintaan = $this->surat_serv->getProsesorangyangsama($this->id_kelurahan,$offset , $dataPerPage);
			
			//mendapatkan jumlah yang belum diproses dan selesai
			$jumlahstatus1 = $this->surat_serv->getJumlahStatusorangyangsama1();	
			if($jumlahstatus1>=1){		
				$peringatanstatus1 = "Ada $jumlahstatus1 surat yang belum diproses. Silakan tekan tombol proses";
			}
			$this->view->jumlahstatus1 = $jumlahstatus1;
			$this->view->peringatanstatus1 = $peringatanstatus1;
			
			$jumlahstatus2 = $this->surat_serv->getJumlahStatusorangyangsama2();
			if($jumlahstatus2>=1){
				$peringatanstatus2 = "Ada $jumlahstatus2 surat yang belum selesai. Silakan tekan tombol selesai";
			}
			$this->view->jumlahstatus2 = $jumlahstatus2;
			$this->view->peringatanstatus2 = $peringatanstatus2;
		}
		
		public function pencarianorangyangsamaAction(){
			$this->view;
			$this->view->kelurahan = $this->id_kelurahan;
			$this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			$id_pencarian = $_POST['id_pencarian'];
			$pencarian = $_POST['pencarian'];
			if(!$pencarian){
				$this->orangyangsamaAction();
				$this->render('orangyangsama');
				}else{
				$this->view->surat = "Surat Orang yang Sama";
				$this->view->cari = $pencarian;
				$this->view->permintaan = $this->surat_serv->getPencarianorangyangsama($this->id_kelurahan,$pencarian,$id_pencarian);
			}
			
		}
		
		public function caripendudukorangyangsamaAction() {
			$this->view;
			$this->view->surat = "Form Isian Orang yang Sama";
			$this->view->judul = "Masukan NIK";
		}
		
		//antrian orangyangsama --> proses memasukan ke antrian orangyangsama, status = 1
		public function orangyangsamaantrianAction(){
			$nik = $_POST['nik'];
			$this->view->surat = "Form Antrian Surat Orang yang Sama";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			
			//mengambil noregistrasi secara automatis
			$no_registrasi = $this->surat_serv->getNoRegistrasi(4,DMP); //4 adalah panjangnya, AN adalah kode huruf
			$this->view->no_registrasi=$no_registrasi;
			
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('orangyangsamaantrian');
			
		}
		
		//menyimpan antrian orangyangsama
		public function simpanorangyangsamaantrianAction(){
			if(isset($_POST['name'])){ 
				$id_kelurahan = $this->id_kelurahan;			
				$id_pengguna = $this->id_pengguna;		
				$nama_pengguna = $this->id_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$no_telp = $_POST['no_telp'];
				$waktu_antrian = date('H:i:s');
				$antrian_oleh = $nama_pengguna;
				$jam_masuk = date('H:i:s');
				$status = 1;
				
				//simpan data ke tabel Orang yang Sama
				$data = array("id_pengguna" =>  	$id_pengguna,
								"id_kelurahan" => $id_kelurahan,
								"no_registrasi" => $no_registrasi,
								"nik" => $nik,
								"waktu_antrian" => $waktu_antrian,
								"antrian_oleh" => $antrian_oleh,
								"jam_masuk" => $jam_masuk,							
								"status" => $status,
								"no_telp" => $no_telp
								);										 
				$hasil = $this->surat_serv->getsimpanorangyangsamaantrian($data);
				
				//simpan data ke tabel no_registrasi
				$registrasi = array("no_registrasi" =>  	$no_registrasi,
									"nik" => $nik							
									);										 
				$hasil = $this->surat_serv->getSimpanNoRegistrasi($registrasi);
				
				
				//jika gagal
				if($hasil=="gagal"){
					$this->view->peringatan ="<div class='gagal'>$hasil. Maaf ada kesalahan</div>";
					$this->orangyangsamaAction();
					$this->render('orangyangsama');					
				}
				//jika sukses
				if($hasil=="sukses"){
					$this->view->peringatan ="<div class='sukses'> Sukses, data berhasil ditambahkan ke antrian </div>";		
					$this->orangyangsamaAction();
					$this->render('orangyangsama');
				}	
				}else{
				$this->orangyangsamaAction();
				$this->render('orangyangsama');
			}
			
		}
		
		
		public function orangyangsamaprosesAction(){
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_orang_yang_sama= $this->_getParam("id_permintaan_orang_yang_sama");
			$no_registrasi= $this->_getParam(no_registrasi);
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;
			
			$waktu_antrian= $this->_getParam(waktu_antrian);
			$waktu_sekarang = date("H:i:s");
			$lama = $this->surat_serv->selisih($waktu_antrian,$waktu_sekarang);	
			$this->view->lama= $lama;
			
			$this->view->surat = "Form Isian Orang yang Sama";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
		}
		
		public function simpanprosesorangyangsamaAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->id_pengguna;
				
				$waktu_proses = date("H:i:s");
				$proses_oleh= $nama_pengguna;
				
				$id_kelurahan = $this->id_kelurahan;
				$id_permintaan_orang_yang_sama = $_POST['id_permintaan_orang_yang_sama'];
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
				$ket = $_POST['ket'];
				$status = 2;
				
				$data = array("id_kelurahan" =>  	$id_kelurahan,
								"id_permintaan_orang_yang_sama" => $id_permintaan_orang_yang_sama,
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
								"status" => $status,
								"waktu_proses" => $waktu_proses,
								"proses_oleh" => $proses_oleh,
								"ket" => $ket
							);
				
				$hasil = $this->surat_serv->getsimpanprosesorangyangsama($data);
				// var_dump($hasil);
				// var_dump($data);
				//jika gagal
				if($hasil=='gagal'){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
					$this->orangyangsamaAction();
					$this->render('orangyangsama');	
				}
				//jika sukses
				//jika sukses
				if($hasil=='sukses'){
					$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diproses </div>";		
					$this->orangyangsamaAction();
					$this->render('orangyangsama');
				}
			}else{
				$this->orangyangsamaAction();
				$this->render('orangyangsama');
			}
			
		}
		public function orangyangsamahapusAction(){
			$id_permintaan_orang_yang_sama= $this->_getParam("id_permintaan_orang_yang_sama");
			$hasil = $this->surat_serv->gethapusorangyangsama($id_permintaan_orang_yang_sama);
			
			//jika gagal
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->orangyangsamaAction();
				$this->render('orangyangsama');	
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
			$this->orangyangsamaAction();
			$this->render('orangyangsama');	
		}
		public function orangyangsamaeditAction(){
			$id_permintaan_orang_yang_sama = $this->_getParam("id_permintaan_orang_yang_sama");
			$this->view->hasil = $this->surat_serv->getorangyangsama($id_permintaan_orang_yang_sama);
		}
		
		public function simpanprosesorangyangsamaeditAction(){
			
			$id_permintaan_orang_yang_sama = $this->_getParam('id_permintaan_orang_yang_sama');
			$id_kelurahan = $this->id_kelurahan;
			$nik = $_POST['nik'];
			$no_surat = $_POST['no_surat'];
			$tanggal_surat = $_POST['tanggal_surat'];
			$no_surat_pengantar = $_POST['no_surat_pengantar'];
			$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];			
			$keperluan = $_POST['keperluan'];
			$masa_berlaku = $_POST['masa_berlaku'];
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
					"id_permintaan_orang_yang_sama" => $id_permintaan_orang_yang_sama,
					"nik" => $nik,
					"no_surat" => $no_surat,
					"tanggal_surat" => $tanggal_surat,
					"no_surat_pengantar" => $no_surat_pengantar,
					"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
					"keperluan" => $keperluan,
					"masa_berlaku" => $masa_berlaku
					);
			
			$hasil = $this->surat_serv->getsimpanprosesorangyangsamaedit($data);
			//jika gagal
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->orangyangsamaAction();
				$this->render('orangyangsama');	
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
				$this->orangyangsamaAction();
				$this->render('orangyangsama');		
			}
		}
		
		//proses selesai
		public function orangyangsamaselesaiAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->id_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_orang_yang_sama= $this->_getParam("id_permintaan_orang_yang_sama");
			$nama= $this->_getParam("nama");
			$nik= $this->_getParam("nik");
			$no_surat= $this->_getParam("no_surat");
			$tanggal_surat= $this->_getParam("tanggal_surat");
			$nama_surat= "Keterangan Penerbitan PBB";
			$asal_controller= "orangyangsama";
			$no_registrasi= $this->_getParam("no_registrasi");
			$waktu_antrian= $this->_getParam("waktu_antrian");
			$status= 3;	
			
			//menghitung lama
			
			$waktu_selesai = date("H:i:s");
			$waktu_total = $this->surat_serv->selisih($waktu_antrian,$waktu_selesai);				
			
			$data = array("id_permintaan_orang_yang_sama" => $id_permintaan_orang_yang_sama,
							"status" => $status,
							"waktu_selesai" => $waktu_selesai,
							"waktu_total" => $waktu_total
						);
			
			$hasil = $this->surat_serv->getSelesaiorangyangsama($data);
			//var_dump($hasil);
			$this->view->asal_controller = $asal_controller;
			$this->view->render = $render;
			$this->view->nik = $nik;
			$this->view->nama = $nama;
			$this->view->no_surat = $no_surat;
			$this->view->tanggal_surat = $tanggal_surat;
			$this->view->nama_surat = $nama_surat;
			$this->view->surat = "Form Orang yang Sama";
			$this->render('arsiptambah');	
		} //////////// END 11. Orang yang Sama


			/////////////////////////////////////////------- 11. Ket. Tanah dan Bangunan Sertifikat
		//cetak surat Ket. Tanah dan Bangunan Sertifikat
		public function ktbsertifikatcetakAction(){
			$id_permintaan_sertifikat = $this->_getParam("id_permintaan_sertifikat");
			$this->view->hasil = $this->surat_serv->getktbsertifikatcetak($id_permintaan_sertifikat);
		}
		
		public function ktbsertifikatAction(){
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
			$this->view->jumData = $this->surat_serv->getJumlahktbsertifikat($this->id_kelurahan);
			$this->view->dataPerPage = $dataPerPage;
			$this->view->noPage = $noPage;
			$this->view->offset=$offset;
			
			$this->view->surat = "Surat Ket. Tanah dan Bangunan Sertifikat";
			$this->view->permintaan = $this->surat_serv->getProsesktbsertifikat($this->id_kelurahan,$offset , $dataPerPage);
			
			//mendapatkan jumlah yang belum diproses dan selesai
			$jumlahstatus1 = $this->surat_serv->getJumlahStatusktbsertifikat1();	
			if($jumlahstatus1>=1){		
				$peringatanstatus1 = "Ada $jumlahstatus1 surat yang belum diproses. Silakan tekan tombol proses";
			}
			$this->view->jumlahstatus1 = $jumlahstatus1;
			$this->view->peringatanstatus1 = $peringatanstatus1;
			
			$jumlahstatus2 = $this->surat_serv->getJumlahStatusktbsertifikat2();
			if($jumlahstatus2>=1){
				$peringatanstatus2 = "Ada $jumlahstatus2 surat yang belum selesai. Silakan tekan tombol selesai";
			}
			$this->view->jumlahstatus2 = $jumlahstatus2;
			$this->view->peringatanstatus2 = $peringatanstatus2;
		}
		
		public function pencarianktbsertifikatAction(){
			$this->view;
			$this->view->kelurahan = $this->id_kelurahan;
			$this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			$id_pencarian = $_POST['id_pencarian'];
			$pencarian = $_POST['pencarian'];
			if(!$pencarian){
				$this->ktbsertifikatAction();
				$this->render('ktbsertifikat');
				}else{
				$this->view->surat = "Surat Ket. Tanah dan Bangunan Sertifikat";
				$this->view->cari = $pencarian;
				$this->view->permintaan = $this->surat_serv->getPencarianktbsertifikat($this->id_kelurahan,$pencarian,$id_pencarian);
			}
			
		}
		
		public function caripendudukktbsertifikatAction() {
			$this->view;
			$this->view->surat = "Form Isian Ket. Tanah dan Bangunan Sertifikat";
			$this->view->judul = "Masukan NIK";
		}
		
		//antrian ktbsertifikat --> proses memasukan ke antrian ktbsertifikat, status = 1
		public function ktbsertifikatantrianAction(){
			$nik = $_POST['nik'];
			$this->view->surat = "Form Antrian Surat Ket. Tanah dan Bangunan Sertifikat";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			
			//mengambil noregistrasi secara automatis
			$no_registrasi = $this->surat_serv->getNoRegistrasi(4,KTB); //4 adalah panjangnya, AN adalah kode huruf
			$this->view->no_registrasi=$no_registrasi;
			
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('ktbsertifikatantrian');
			
		}
		
		//menyimpan antrian ktbsertifikat
		public function simpanktbsertifikatantrianAction(){
			if(isset($_POST['name'])){ 
				$id_kelurahan = $this->id_kelurahan;			
				$id_pengguna = $this->id_pengguna;		
				$nama_pengguna = $this->id_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$no_telp = $_POST['no_telp'];
				$waktu_antrian = date('H:i:s');
				$antrian_oleh = $nama_pengguna;
				$jam_masuk = date('H:i:s');
				$status = 1;
				
				//simpan data ke tabel Ket. Tanah dan Bangunan Sertifikat
				$data = array("id_pengguna" =>  	$id_pengguna,
								"id_kelurahan" => $id_kelurahan,
								"no_registrasi" => $no_registrasi,
								"nik" => $nik,
								"waktu_antrian" => $waktu_antrian,
								"antrian_oleh" => $antrian_oleh,
								"jam_masuk" => $jam_masuk,							
								"status" => $status,
								"no_telp" => $no_telp
								);										 
				$hasil = $this->surat_serv->getsimpanktbsertifikatantrian($data);
				
				//simpan data ke tabel no_registrasi
				$registrasi = array("no_registrasi" =>  	$no_registrasi,
									"nik" => $nik							
									);										 
				$hasil = $this->surat_serv->getSimpanNoRegistrasi($registrasi);
				
				
				//jika gagal
				if($hasil=="gagal"){
					$this->view->peringatan ="<div class='gagal'>$hasil. Maaf ada kesalahan</div>";
					$this->ktbsertifikatAction();
					$this->render('ktbsertifikat');					
				}
				//jika sukses
				if($hasil=="sukses"){
					$this->view->peringatan ="<div class='sukses'> Sukses, data berhasil ditambahkan ke antrian </div>";		
					$this->ktbsertifikatAction();
					$this->render('ktbsertifikat');
				}	
				}else{
				$this->ktbsertifikatAction();
				$this->render('ktbsertifikat');
			}
			
		}
		
		
		public function ktbsertifikatprosesAction(){
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_sertifikat= $this->_getParam("id_permintaan_sertifikat");
			$no_registrasi= $this->_getParam(no_registrasi);
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;
			
			$waktu_antrian= $this->_getParam(waktu_antrian);
			$waktu_sekarang = date("H:i:s");
			$lama = $this->surat_serv->selisih($waktu_antrian,$waktu_sekarang);	
			$this->view->lama= $lama;
			
			$this->view->surat = "Form Isian Ket. Tanah dan Bangunan Sertifikat";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
		}
		
		public function simpanprosesktbsertifikatAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->id_pengguna;
				
				$waktu_proses = date("H:i:s");
				$proses_oleh= $nama_pengguna;
				
				$id_kelurahan = $this->id_kelurahan;
				$id_permintaan_sertifikat = $_POST['id_permintaan_sertifikat'];
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
				$ket = $_POST['ket'];
				$status = 2;
				
				$data = array("id_kelurahan" =>  	$id_kelurahan,
								"id_permintaan_sertifikat" => $id_permintaan_sertifikat,
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
								"status" => $status,
								"waktu_proses" => $waktu_proses,
								"proses_oleh" => $proses_oleh,
								"ket" => $ket
							);
				
				$hasil = $this->surat_serv->getsimpanprosesktbsertifikat($data);
				// var_dump($hasil);
				// var_dump($data);
				//jika gagal
				if($hasil=='gagal'){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
					$this->ktbsertifikatAction();
					$this->render('ktbsertifikat');	
				}
				//jika sukses
				//jika sukses
				if($hasil=='sukses'){
					$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diproses </div>";		
					$this->ktbsertifikatAction();
					$this->render('ktbsertifikat');
				}
			}else{
				$this->ktbsertifikatAction();
				$this->render('ktbsertifikat');
			}
			
		}
		public function ktbsertifikathapusAction(){
			$id_permintaan_sertifikat= $this->_getParam("id_permintaan_sertifikat");
			$hasil = $this->surat_serv->gethapusktbsertifikat($id_permintaan_sertifikat);
			
			//jika gagal
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->ktbsertifikatAction();
				$this->render('ktbsertifikat');	
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
			$this->ktbsertifikatAction();
			$this->render('ktbsertifikat');	
		}
		public function ktbsertifikateditAction(){
			$id_permintaan_sertifikat = $this->_getParam("id_permintaan_sertifikat");
			$this->view->hasil = $this->surat_serv->getktbsertifikat($id_permintaan_sertifikat);
		}
		
		public function simpanprosesktbsertifikateditAction(){
			
			$id_permintaan_sertifikat = $this->_getParam('id_permintaan_sertifikat');
			$id_kelurahan = $this->id_kelurahan;
			$nik = $_POST['nik'];
			$no_surat = $_POST['no_surat'];
			$tanggal_surat = $_POST['tanggal_surat'];
			$no_surat_pengantar = $_POST['no_surat_pengantar'];
			$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];			
			$keperluan = $_POST['keperluan'];
			$masa_berlaku = $_POST['masa_berlaku'];
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
					"id_permintaan_sertifikat" => $id_permintaan_sertifikat,
					"nik" => $nik,
					"no_surat" => $no_surat,
					"tanggal_surat" => $tanggal_surat,
					"no_surat_pengantar" => $no_surat_pengantar,
					"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
					"keperluan" => $keperluan,
					"masa_berlaku" => $masa_berlaku
					);
			
			$hasil = $this->surat_serv->getsimpanprosesktbsertifikatedit($data);
			//jika gagal
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->ktbsertifikatAction();
				$this->render('ktbsertifikat');	
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
				$this->ktbsertifikatAction();
				$this->render('ktbsertifikat');		
			}
		}
		
		//proses selesai
		public function ktbsertifikatselesaiAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->id_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_sertifikat= $this->_getParam("id_permintaan_sertifikat");
			$nama= $this->_getParam("nama");
			$nik= $this->_getParam("nik");
			$no_surat= $this->_getParam("no_surat");
			$tanggal_surat= $this->_getParam("tanggal_surat");
			$nama_surat= "Keterangan Penerbitan PBB";
			$asal_controller= "ktbsertifikat";
			$no_registrasi= $this->_getParam("no_registrasi");
			$waktu_antrian= $this->_getParam("waktu_antrian");
			$status= 3;	
			
			//menghitung lama
			
			$waktu_selesai = date("H:i:s");
			$waktu_total = $this->surat_serv->selisih($waktu_antrian,$waktu_selesai);				
			
			$data = array("id_permintaan_sertifikat" => $id_permintaan_sertifikat,
							"status" => $status,
							"waktu_selesai" => $waktu_selesai,
							"waktu_total" => $waktu_total
						);
			
			$hasil = $this->surat_serv->getSelesaiktbsertifikat($data);
			//var_dump($hasil);
			$this->view->asal_controller = $asal_controller;
			$this->view->render = $render;
			$this->view->nik = $nik;
			$this->view->nama = $nama;
			$this->view->no_surat = $no_surat;
			$this->view->tanggal_surat = $tanggal_surat;
			$this->view->nama_surat = $nama_surat;
			$this->view->surat = "Form Ket. Tanah dan Bangunan Sertifikat";
			$this->render('arsiptambah');	
		} //////////// END 11. Ket. Tanah dan Bangunan Sertifikat


			/////////////////////////////////////////------- 11. Kartu identitas kerja
		//cetak surat Kartu identitas kerja
		public function kartuidentitaskerjacetakAction(){
			$id_permintaan_sertifikat = $this->_getParam("id_permintaan_sertifikat");
			$this->view->hasil = $this->surat_serv->getktbsertifikatcetak($id_permintaan_sertifikat);
		}
		
		public function kartuidentitaskerjaAction(){
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
			$this->view->jumData = $this->surat_serv->getJumlahkartuidentitaskerja($this->id_kelurahan);
			$this->view->dataPerPage = $dataPerPage;
			$this->view->noPage = $noPage;
			$this->view->offset=$offset;
			
			$this->view->surat = "Surat Ket. Tanah dan Bangunan Sertifikat";
			$this->view->permintaan = $this->surat_serv->getProseskartuidentitaskerja($this->id_kelurahan,$offset , $dataPerPage);
			
			//mendapatkan jumlah yang belum diproses dan selesai
			$jumlahstatus1 = $this->surat_serv->getJumlahStatuskartuidentitaskerja1();	
			if($jumlahstatus1>=1){		
				$peringatanstatus1 = "Ada $jumlahstatus1 surat yang belum diproses. Silakan tekan tombol proses";
			}
			$this->view->jumlahstatus1 = $jumlahstatus1;
			$this->view->peringatanstatus1 = $peringatanstatus1;
			
			$jumlahstatus2 = $this->surat_serv->getJumlahStatuskartuidentitaskerja2();
			if($jumlahstatus2>=1){
				$peringatanstatus2 = "Ada $jumlahstatus2 surat yang belum selesai. Silakan tekan tombol selesai";
			}
			$this->view->jumlahstatus2 = $jumlahstatus2;
			$this->view->peringatanstatus2 = $peringatanstatus2;
		}
		
		public function pencariankartuidentitaskerjaAction(){
			$this->view;
			$this->view->kelurahan = $this->id_kelurahan;
			$this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			$id_pencarian = $_POST['id_pencarian'];
			$pencarian = $_POST['pencarian'];
			if(!$pencarian){
				$this->kartuidentitaskerjaAction();
				$this->render('kartuidentitaskerja');
				}else{
				$this->view->surat = "Surat Ket. Tanah dan Bangunan Sertifikat";
				$this->view->cari = $pencarian;
				$this->view->permintaan = $this->surat_serv->getPencariankartuidentitaskerja($this->id_kelurahan,$pencarian,$id_pencarian);
			}
			
		}
		
		public function caripendudukkartuidentitaskerjaAction() {
			$this->view;
			$this->view->surat = "Form Isian Ket. Tanah dan Bangunan Sertifikat";
			$this->view->judul = "Masukan NIK";
		}
		
		//antrian kartuidentitaskerja --> proses memasukan ke antrian kartuidentitaskerja, status = 1
		public function kartuidentitaskerjaantrianAction(){
			$nik = $_POST['nik'];
			$this->view->surat = "Form Antrian Surat Ket. Tanah dan Bangunan Sertifikat";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			
			//mengambil noregistrasi secara automatis
			$no_registrasi = $this->surat_serv->getNoRegistrasi(4,KIK); //4 adalah panjangnya, AN adalah kode huruf
			$this->view->no_registrasi=$no_registrasi;
			
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('kartuidentitaskerjaantrian');
			
		}
		
		//menyimpan antrian kartuidentitaskerja
		public function simpankartuidentitaskerjaantrianAction(){
			if(isset($_POST['name'])){ 
				$id_kelurahan = $this->id_kelurahan;			
				$id_pengguna = $this->id_pengguna;		
				$nama_pengguna = $this->id_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$no_telp = $_POST['no_telp'];
				$waktu_antrian = date('H:i:s');
				$antrian_oleh = $nama_pengguna;
				$jam_masuk = date('H:i:s');
				$status = 1;
				
				//simpan data ke tabel Ket. Tanah dan Bangunan Sertifikat
				$data = array("id_pengguna" =>  	$id_pengguna,
								"id_kelurahan" => $id_kelurahan,
								"no_registrasi" => $no_registrasi,
								"nik" => $nik,
								"waktu_antrian" => $waktu_antrian,
								"antrian_oleh" => $antrian_oleh,
								"jam_masuk" => $jam_masuk,							
								"status" => $status,
								"no_telp" => $no_telp
								);										 
				$hasil = $this->surat_serv->getsimpankartuidentitaskerjaantrian($data);
				
				//simpan data ke tabel no_registrasi
				$registrasi = array("no_registrasi" =>  	$no_registrasi,
									"nik" => $nik							
									);										 
				$hasil = $this->surat_serv->getSimpanNoRegistrasi($registrasi);
				
				
				//jika gagal
				if($hasil=="gagal"){
					$this->view->peringatan ="<div class='gagal'>$hasil. Maaf ada kesalahan</div>";
					$this->kartuidentitaskerjaAction();
					$this->render('kartuidentitaskerja');					
				}
				//jika sukses
				if($hasil=="sukses"){
					$this->view->peringatan ="<div class='sukses'> Sukses, data berhasil ditambahkan ke antrian </div>";		
					$this->kartuidentitaskerjaAction();
					$this->render('kartuidentitaskerja');
				}	
				}else{
				$this->kartuidentitaskerjaAction();
				$this->render('kartuidentitaskerja');
			}
			
		}
		
		
		public function kartuidentitaskerjaprosesAction(){
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			
			$id_permintaan_sertifikat= $this->_getParam("id_permintaan_sertifikat");
			$no_registrasi= $this->_getParam(no_registrasi);
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;
			
			$waktu_antrian= $this->_getParam(waktu_antrian);
			$waktu_sekarang = date("H:i:s");
			$lama = $this->surat_serv->selisih($waktu_antrian,$waktu_sekarang);	
			$this->view->lama= $lama;
			
			$this->view->surat = "Form Isian Ket. Tanah dan Bangunan Sertifikat";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
		}
		
		public function simpanproseskartuidentitaskerjaAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->id_pengguna;
				
				$waktu_proses = date("H:i:s");
				$proses_oleh= $nama_pengguna;
				
				$id_kelurahan = $this->id_kelurahan;
				$id_permintaan_sertifikat = $_POST['id_permintaan_sertifikat'];
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
				$ket = $_POST['ket'];
				$status = 2;
				
				$data = array("id_kelurahan" =>  	$id_kelurahan,
								"id_permintaan_sertifikat" => $id_permintaan_sertifikat,
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
								"status" => $status,
								"waktu_proses" => $waktu_proses,
								"proses_oleh" => $proses_oleh,
								"ket" => $ket
							);
				
				$hasil = $this->surat_serv->getsimpanproseskartuidentitaskerja($data);
				// var_dump($hasil);
				// var_dump($data);
				//jika gagal
				if($hasil=='gagal'){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
					$this->kartuidentitaskerjaAction();
					$this->render('kartuidentitaskerja');	
				}
				//jika sukses
				//jika sukses
				if($hasil=='sukses'){
					$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diproses </div>";		
					$this->kartuidentitaskerjaAction();
					$this->render('kartuidentitaskerja');
				}
			}else{
				$this->kartuidentitaskerjaAction();
				$this->render('kartuidentitaskerja');
			}
			
		}
		public function kartuidentitaskerjahapusAction(){
			$id_permintaan_sertifikat= $this->_getParam("id_permintaan_sertifikat");
			$hasil = $this->surat_serv->gethapuskartuidentitaskerja($id_permintaan_sertifikat);
			
			//jika gagal
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->kartuidentitaskerjaAction();
				$this->render('kartuidentitaskerja');	
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
			$this->kartuidentitaskerjaAction();
			$this->render('kartuidentitaskerja');	
		}
		public function kartuidentitaskerjaeditAction(){
			$id_permintaan_sertifikat = $this->_getParam("id_permintaan_sertifikat");
			$this->view->hasil = $this->surat_serv->getkartuidentitaskerja($id_permintaan_sertifikat);
		}
		
		public function simpanproseskartuidentitaskerjaeditAction(){
			
			$id_permintaan_sertifikat = $this->_getParam('id_permintaan_sertifikat');
			$id_kelurahan = $this->id_kelurahan;
			$nik = $_POST['nik'];
			$no_surat = $_POST['no_surat'];
			$tanggal_surat = $_POST['tanggal_surat'];
			$no_surat_pengantar = $_POST['no_surat_pengantar'];
			$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];			
			$keperluan = $_POST['keperluan'];
			$masa_berlaku = $_POST['masa_berlaku'];
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
					"id_permintaan_sertifikat" => $id_permintaan_sertifikat,
					"nik" => $nik,
					"no_surat" => $no_surat,
					"tanggal_surat" => $tanggal_surat,
					"no_surat_pengantar" => $no_surat_pengantar,
					"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
					"keperluan" => $keperluan,
					"masa_berlaku" => $masa_berlaku
					);
			
			$hasil = $this->surat_serv->getsimpanproseskartuidentitaskerjaedit($data);
			//jika gagal
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->kartuidentitaskerjaAction();
				$this->render('kartuidentitaskerja');	
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
				$this->kartuidentitaskerjaAction();
				$this->render('kartuidentitaskerja');		
			}
		}
		
		//proses selesai
		public function kartuidentitaskerjaselesaiAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->id_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_sertifikat= $this->_getParam("id_permintaan_sertifikat");
			$nama= $this->_getParam("nama");
			$nik= $this->_getParam("nik");
			$no_surat= $this->_getParam("no_surat");
			$tanggal_surat= $this->_getParam("tanggal_surat");
			$nama_surat= "Keterangan Penerbitan PBB";
			$asal_controller= "kartuidentitaskerja";
			$no_registrasi= $this->_getParam("no_registrasi");
			$waktu_antrian= $this->_getParam("waktu_antrian");
			$status= 3;	
			
			//menghitung lama
			
			$waktu_selesai = date("H:i:s");
			$waktu_total = $this->surat_serv->selisih($waktu_antrian,$waktu_selesai);				
			
			$data = array("id_permintaan_sertifikat" => $id_permintaan_sertifikat,
							"status" => $status,
							"waktu_selesai" => $waktu_selesai,
							"waktu_total" => $waktu_total
						);
			
			$hasil = $this->surat_serv->getSelesaikartuidentitaskerja($data);
			//var_dump($hasil);
			$this->view->asal_controller = $asal_controller;
			$this->view->render = $render;
			$this->view->nik = $nik;
			$this->view->nama = $nama;
			$this->view->no_surat = $no_surat;
			$this->view->tanggal_surat = $tanggal_surat;
			$this->view->nama_surat = $nama_surat;
			$this->view->surat = "Form Ket. Tanah dan Bangunan Sertifikat";
			$this->render('arsiptambah');	
		} //////////// END 11. Ket. Tanah dan Bangunan Sertifikat


		//--------------------------------------SURAT KIPEM	
		public function kipemcetakAction(){
			$id_permintaan_kipem = $this->_getParam("id_permintaan_kipem");
			$this->view->hasil = $this->surat_serv->getkipemcetak($id_permintaan_kipem);
		}
		
		public function kipemAction(){
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
			$this->view->jumData = $this->surat_serv->getJumlahkipem($this->id_kelurahan);
			$this->view->dataPerPage = $dataPerPage;
			$this->view->noPage = $noPage;
			$this->view->offset=$offset;
			
			$this->view->surat = "Surat Keterangan kipem";
			$this->view->permintaan = $this->surat_serv->getProseskipem($this->id_kelurahan,$offset,$dataPerPage);
			
			//mendapatkan jumlah yang belum diproses dan selesai
			$jumlahstatus1 = $this->surat_serv->getJumlahStatuskipem1();	
			if($jumlahstatus1>=1){		
				$peringatanstatus1 = "Ada $jumlahstatus1 surat yang belum diproses. Silakan tekan tombol proses";
			}
			$this->view->jumlahstatus1 = $jumlahstatus1;
			$this->view->peringatanstatus1 = $peringatanstatus1;
			
			$jumlahstatus2 = $this->surat_serv->getJumlahStatuskipem2();
			if($jumlahstatus2>=1){
				$peringatanstatus2 = "Ada $jumlahstatus2 surat yang belum selesai. Silakan tekan tombol selesai";
			}
			$this->view->jumlahstatus2 = $jumlahstatus2;
			$this->view->peringatanstatus2 = $peringatanstatus2;
		}
		
		public function pencariankipemAction(){
			$this->view;
			$this->view->kelurahan = $this->id_kelurahan;
			$this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			$id_pencarian = $_POST['id_pencarian'];
			$pencarian = $_POST['pencarian'];
			if(!$pencarian){
				$this->kipemAction();
				$this->render('kipem');
				}else{
				$this->view->surat = "Surat Keterangan kipem";
				$this->view->cari = $pencarian;
				$this->view->permintaan = $this->surat_serv->getPencariankipem($this->id_kelurahan,$pencarian,$id_pencarian);
			}
		}
		
		public function caripendudukkipemAction() {
			$this->view;
			$this->view->surat = "Form Isian Surat Keterangan kipem";
			$this->view->judul = "Masukan NIK";
		}
		
		//antrian kipem --> proses memasukan ke antrian kipem, status = 1
		public function kipemantrianAction(){
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			
			$nik = $_POST['nik'];
			$this->view->surat = "Form Antrian Keterangan kipem";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			
			//mengambil noregistrasi secara automatis
			$no_registrasi = $this->surat_serv->getNoRegistrasi(4,KIP); //4 adalah panjangnya, AN adalah kode huruf
			$this->view->no_registrasi=$no_registrasi;
			
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('kipemantrian');
			
		}
		
		//menyimpan antrian andon nikah
		public function simpankipemantrianAction(){
			if(isset($_POST['name'])){ 
				$id_kelurahan = $this->id_kelurahan;			
				$id_pengguna = $this->id_pengguna;		
				$nama_pengguna = $this->id_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$no_telp = $_POST['no_telp'];
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
								"status" => $status,
								"no_telp" => $no_telp
								);										 
				$hasil = $this->surat_serv->getsimpankipemantrian($data);
				
				//simpan data ke tabel no_registrasi
				$registrasi = array("no_registrasi" =>  	$no_registrasi,
									"nik" => $nik							
									);										 
				$hasil = $this->surat_serv->getSimpanNoRegistrasi($registrasi);
				
				
				//jika gagal
				if($hasil=="gagal"){
					$this->view->peringatan ="<div class='gagal'>$hasil. Maaf ada kesalahan;</div>";
					$this->kipemAction();
					$this->render('kipem');					
				}
				//jika sukses
				if($hasil=="sukses"){
					$this->view->peringatan ="<div class='sukses'> Sukses, data berhasil ditambahkan ke antrian </div>";		
					$this->kipemAction();
					$this->render('kipem');
				}	
				}else{
				$this->kipemAction();
				$this->render('kipem');
			}
			
		}
		
		public function kipemprosesAction(){
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->id_pengguna;
			
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			$no_registrasi= $this->_getParam(no_registrasi);
			
			$waktu_antrian= $this->_getParam(waktu_antrian);
			$waktu_sekarang = date("H:i:s");
			$lama = $this->surat_serv->selisih($waktu_antrian,$waktu_sekarang);	
			
			
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;		
			$this->view->lama= $lama;
			
			$this->view->surat = "Form Isian Surat Keterangan kipem";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('kipemproses');
		
		}
		
		public function simpanproseskipemAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->id_pengguna;
				
				$waktu_proses = date("H:i:s");
				$proses_oleh= $nama_pengguna;
				
				$id_kelurahan = $this->id_kelurahan;
				$id_permintaan_kipem = $_POST['id_permintaan_kipem'];
				$id_jenis_surat = $_POST['id_jenis_surat'];
				$id_surat = $_POST['id_surat'];
				$keperluan = $_POST['keperluan'];
				$nik = $_POST['nik'];
				$id_pejabat = $_POST['id_pejabat'];
				$no_surat = $_POST['no_surat'];
				$tanggal_surat = $_POST['tanggal_surat'];
				$ket = $_POST['ket'];
				$no_surat_pengantar = strip_tags($_POST['no_surat_pengantar']);
				$tanggal_surat_pengantar = strip_tags($_POST['tanggal_surat_pengantar']);
				$status = 2;
				
				$data = array("id_kelurahan" => $id_kelurahan,
								"id_permintaan_kipem" => $id_permintaan_kipem,
								"keperluan" => $keperluan,
								"nik" => $nik,
								"id_pejabat" => $id_pejabat,
								"id_jenis_surat" => $id_jenis_surat,
								"id_surat" => $id_surat,
								"no_surat" => $no_surat,
								"tanggal_surat" => $tanggal_surat,
								"no_surat_pengantar" => $no_surat_pengantar,
								"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
								"status" => $status,
								"waktu_proses" => $waktu_proses,
								"proses_oleh" => $proses_oleh,
								"ket" => $ket
								);
				
				$hasil = $this->surat_serv->getsimpanproseskipem($data);
				// var_dump($hasil);
				// var_dump($data);
				//jika gagal
				if($hasil=='gagal'){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
					$this->kipemAction();
					$this->render('kipem');
				}
				//jika sukses
				if($hasil=='sukses'){
					$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diproses </div>";		
					$this->kipemAction();
					$this->render('kipem');
				}
			}else{
				$this->kipemAction();
				$this->render('kipem');
			}
			
		}
		public function kipemhapusAction(){
			$id_permintaan_kipem= $this->_getParam("id_permintaan_kipem");
			$hasil = $this->surat_serv->gethapuskipem($id_permintaan_kipem);
			
			//jika gagal
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->kipemAction();
				$this->render('kipem');
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
			$this->kipemAction();
			$this->render('kipem');	
		}
		public function kipemeditAction(){
			$this->view->surat = "Surat Keterangan kipem";
			$id_permintaan_kipem = $this->_getParam("id_permintaan_kipem");
			$this->view->hasil = $this->surat_serv->getkipem($id_permintaan_kipem);
		}
		
		public function simpanproseskipemeditAction(){
			$id_permintaan_kipem = $this->_getParam('id_permintaan_kipem');
			$id_kelurahan = $this->id_kelurahan;
			$nik = $_POST['nik'];
			$no_surat = $_POST['no_surat'];
			$tanggal_surat = $_POST['tanggal_surat'];
			$no_surat_pengantar = $_POST['no_surat_pengantar'];
			$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
			$keperluan = $_POST['keperluan'];
			$ket = $_POST['ket'];
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
							"id_permintaan_kipem" => $id_permintaan_kipem,
							"nik" => $nik,
							"no_surat" => $no_surat,
							"tanggal_surat" => $tanggal_surat,
							"no_surat_pengantar" => $no_surat_pengantar,
							"keperluan" => $keperluan,
							"ket" => $ket,
							"tanggal_surat_pengantar" => $tanggal_surat_pengantar);
			
			$hasil = $this->surat_serv->getsimpankipemedit($data);
			//jika gagal 
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->kipemAction();
				$this->render('kipem');
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
				$this->kipemAction();
				$this->render('kipem');
			}
		}
		
		//proses selesai
		public function kipemselesaiAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->id_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_kipem= $this->_getParam("id_permintaan_kipem");
			$nama= $this->_getParam("nama");
			$nik= $this->_getParam("nik");
			$no_surat= $this->_getParam("no_surat");
			$tanggal_surat= $this->_getParam("tanggal_surat");
			$nama_surat= "Keterangan kipem";
			$asal_controller= "kipem";
			$no_registrasi= $this->_getParam("no_registrasi");
			$waktu_antrian= $this->_getParam("waktu_antrian");
			$status= 3;	
			
			//menghitung lama
			
			$waktu_selesai = date("H:i:s");
			$waktu_total = $this->surat_serv->selisih($waktu_antrian,$waktu_selesai);
			
			$data = array("id_permintaan_kipem" => $id_permintaan_kipem,
			"status" => $status,
			"waktu_selesai" => $waktu_selesai,
			"waktu_total" => $waktu_total);
			
			$hasil = $this->surat_serv->getSelesaikipem($data);
			//var_dump($hasil);
			$this->view->asal_controller = $asal_controller;
			$this->view->render = $render;
			$this->view->nik = $nik;
			$this->view->nama = $nama;
			$this->view->no_surat = $no_surat;
			$this->view->tanggal_surat = $tanggal_surat;
			$this->view->nama_surat = $nama_surat;
			$this->view->surat = "Form Tambah Surat";
			$this->render('arsiptambah');	
		}


		//////////////////////////////////////////////
		//--------------------------------------surat KTP	
		public function ktpcetakAction(){
			$id_permintaan_ktp = $this->_getParam("id_permintaan_ktp");
			$this->view->hasil = $this->surat_serv->getktpcetak($id_permintaan_ktp);
		}
		
		public function ktpAction(){
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
			$this->view->jumData = $this->surat_serv->getJumlahktp($this->id_kelurahan);
			$this->view->dataPerPage = $dataPerPage;
			$this->view->noPage = $noPage;
			$this->view->offset=$offset;
			
			$this->view->surat = "Surat Keterangan ktp";
			$this->view->permintaan = $this->surat_serv->getProsesktp($this->id_kelurahan,$offset,$dataPerPage);
			
			//mendapatkan jumlah yang belum diproses dan selesai
			$jumlahstatus1 = $this->surat_serv->getJumlahStatusktp1();	
			if($jumlahstatus1>=1){		
				$peringatanstatus1 = "Ada $jumlahstatus1 surat yang belum diproses. Silakan tekan tombol proses";
			}
			$this->view->jumlahstatus1 = $jumlahstatus1;
			$this->view->peringatanstatus1 = $peringatanstatus1;
			
			$jumlahstatus2 = $this->surat_serv->getJumlahStatusktp2();
			if($jumlahstatus2>=1){
				$peringatanstatus2 = "Ada $jumlahstatus2 surat yang belum selesai. Silakan tekan tombol selesai";
			}
			$this->view->jumlahstatus2 = $jumlahstatus2;
			$this->view->peringatanstatus2 = $peringatanstatus2;
		}
		
		public function pencarianktpAction(){
			$this->view;
			$this->view->kelurahan = $this->id_kelurahan;
			$this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			$id_pencarian = $_POST['id_pencarian'];
			$pencarian = $_POST['pencarian'];
			if(!$pencarian){
				$this->ktpAction();
				$this->render('ktp');
				}else{
				$this->view->surat = "Surat Keterangan ktp";
				$this->view->cari = $pencarian;
				$this->view->permintaan = $this->surat_serv->getPencarianktp($this->id_kelurahan,$pencarian,$id_pencarian);
			}
		}
		
		public function caripendudukktpAction() {
			$this->view;
			$this->view->surat = "Form Isian Surat Keterangan ktp";
			$this->view->judul = "Masukan NIK";
		}
		
		//antrian ktp --> proses memasukan ke antrian ktp, status = 1
		public function ktpantrianAction(){
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			
			$nik = $_POST['nik'];
			$this->view->surat = "Form Antrian Keterangan ktp";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			
			//mengambil noregistrasi secara automatis
			$no_registrasi = $this->surat_serv->getNoRegistrasi(4,KTP); //4 adalah panjangnya, AN adalah kode huruf
			$this->view->no_registrasi=$no_registrasi;
			
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('ktpantrian');
			
		}
		
		//menyimpan antrian andon nikah
		public function simpanktpantrianAction(){
			if(isset($_POST['name'])){ 
				$id_kelurahan = $this->id_kelurahan;			
				$id_pengguna = $this->id_pengguna;		
				$nama_pengguna = $this->id_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$no_telp = $_POST['no_telp'];
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
								"status" => $status,
								"no_telp" => $no_telp
								);										 
				$hasil = $this->surat_serv->getsimpanktpantrian($data);
				
				//simpan data ke tabel no_registrasi
				$registrasi = array("no_registrasi" =>  	$no_registrasi,
									"nik" => $nik							
									);										 
				$hasil = $this->surat_serv->getSimpanNoRegistrasi($registrasi);
				
				
				//jika gagal
				if($hasil=="gagal"){
					$this->view->peringatan ="<div class='gagal'>$hasil. Maaf ada kesalahan;</div>";
					$this->ktpAction();
					$this->render('ktp');					
				}
				//jika sukses
				if($hasil=="sukses"){
					$this->view->peringatan ="<div class='sukses'> Sukses, data berhasil ditambahkan ke antrian </div>";		
					$this->ktpAction();
					$this->render('ktp');
				}	
				}else{
				$this->ktpAction();
				$this->render('ktp');
			}
			
		}
		
		public function ktpprosesAction(){
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->id_pengguna;
			
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			$no_registrasi= $this->_getParam(no_registrasi);
			
			$waktu_antrian= $this->_getParam(waktu_antrian);
			$waktu_sekarang = date("H:i:s");
			$lama = $this->surat_serv->selisih($waktu_antrian,$waktu_sekarang);	
			
			
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;		
			$this->view->lama= $lama;
			
			$this->view->surat = "Form Isian Surat Keterangan ktp";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('ktpproses');
		
		}
		
		public function simpanprosesktpAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->id_pengguna;
				
				$waktu_proses = date("H:i:s");
				$proses_oleh= $nama_pengguna;
				
				$id_kelurahan = $this->id_kelurahan;
				$id_permintaan_ktp = $_POST['id_permintaan_ktp'];
				$id_jenis_surat = $_POST['id_jenis_surat'];
				$id_surat = $_POST['id_surat'];
				$keperluan = $_POST['keperluan'];
				$nik = $_POST['nik'];
				$id_pejabat = $_POST['id_pejabat'];
				$no_surat = $_POST['no_surat'];
				$tanggal_surat = $_POST['tanggal_surat'];
				$ket = $_POST['ket'];
				$no_surat_pengantar = strip_tags($_POST['no_surat_pengantar']);
				$tanggal_surat_pengantar = strip_tags($_POST['tanggal_surat_pengantar']);
				$status = 2;
				
				$data = array("id_kelurahan" => $id_kelurahan,
								"id_permintaan_ktp" => $id_permintaan_ktp,
								"keperluan" => $keperluan,
								"nik" => $nik,
								"id_pejabat" => $id_pejabat,
								"id_jenis_surat" => $id_jenis_surat,
								"id_surat" => $id_surat,
								"no_surat" => $no_surat,
								"tanggal_surat" => $tanggal_surat,
								"no_surat_pengantar" => $no_surat_pengantar,
								"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
								"status" => $status,
								"waktu_proses" => $waktu_proses,
								"proses_oleh" => $proses_oleh,
								"ket" => $ket
								);
				
				$hasil = $this->surat_serv->getsimpanprosesktp($data);
				// var_dump($hasil);
				// var_dump($data);
				//jika gagal
				if($hasil=='gagal'){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
					$this->ktpAction();
					$this->render('ktp');
				}
				//jika sukses
				if($hasil=='sukses'){
					$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diproses </div>";		
					$this->ktpAction();
					$this->render('ktp');
				}
			}else{
				$this->ktpAction();
				$this->render('ktp');
			}
			
		}
		public function ktphapusAction(){
			$id_permintaan_ktp= $this->_getParam("id_permintaan_ktp");
			$hasil = $this->surat_serv->gethapusktp($id_permintaan_ktp);
			
			//jika gagal
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->ktpAction();
				$this->render('ktp');
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
			$this->ktpAction();
			$this->render('ktp');	
		}
		public function ktpeditAction(){
			$this->view->surat = "Surat Keterangan ktp";
			$id_permintaan_ktp = $this->_getParam("id_permintaan_ktp");
			$this->view->hasil = $this->surat_serv->getktp($id_permintaan_ktp);
		}
		
		public function simpanprosesktpeditAction(){
			$id_permintaan_ktp = $this->_getParam('id_permintaan_ktp');
			$id_kelurahan = $this->id_kelurahan;
			$nik = $_POST['nik'];
			$no_surat = $_POST['no_surat'];
			$tanggal_surat = $_POST['tanggal_surat'];
			$no_surat_pengantar = $_POST['no_surat_pengantar'];
			$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
			$keperluan = $_POST['keperluan'];
			$ket = $_POST['ket'];
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
							"id_permintaan_ktp" => $id_permintaan_ktp,
							"nik" => $nik,
							"no_surat" => $no_surat,
							"tanggal_surat" => $tanggal_surat,
							"no_surat_pengantar" => $no_surat_pengantar,
							"keperluan" => $keperluan,
							"ket" => $ket,
							"tanggal_surat_pengantar" => $tanggal_surat_pengantar);
			
			$hasil = $this->surat_serv->getsimpanktpedit($data);
			//jika gagal 
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->ktpAction();
				$this->render('ktp');
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
				$this->ktpAction();
				$this->render('ktp');
			}
		}
		
		//proses selesai
		public function ktpselesaiAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->id_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_ktp= $this->_getParam("id_permintaan_ktp");
			$nama= $this->_getParam("nama");
			$nik= $this->_getParam("nik");
			$no_surat= $this->_getParam("no_surat");
			$tanggal_surat= $this->_getParam("tanggal_surat");
			$nama_surat= "Keterangan ktp";
			$asal_controller= "ktp";
			$no_registrasi= $this->_getParam("no_registrasi");
			$waktu_antrian= $this->_getParam("waktu_antrian");
			$status= 3;	
			
			//menghitung lama
			
			$waktu_selesai = date("H:i:s");
			$waktu_total = $this->surat_serv->selisih($waktu_antrian,$waktu_selesai);
			
			$data = array("id_permintaan_ktp" => $id_permintaan_ktp,
			"status" => $status,
			"waktu_selesai" => $waktu_selesai,
			"waktu_total" => $waktu_total);
			
			$hasil = $this->surat_serv->getSelesaiktp($data);
			//var_dump($hasil);
			$this->view->asal_controller = $asal_controller;
			$this->view->render = $render;
			$this->view->nik = $nik;
			$this->view->nama = $nama;
			$this->view->no_surat = $no_surat;
			$this->view->tanggal_surat = $tanggal_surat;
			$this->view->nama_surat = $nama_surat;
			$this->view->surat = "Form Tambah Surat";
			$this->render('arsiptambah');	
		} // END KTP

		//////////////////////////////////////////////// SURAT KK
		//////////////////////////////////////////////
		//--------------------------------------surat KK	
		public function kkcetakAction(){
			$id_permintaan_kk = $this->_getParam("id_permintaan_kk");
			$this->view->hasil = $this->surat_serv->getkkcetak($id_permintaan_kk);
		}
		
		public function kkAction(){
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
			$this->view->jumData = $this->surat_serv->getJumlahkk($this->id_kelurahan);
			$this->view->dataPerPage = $dataPerPage;
			$this->view->noPage = $noPage;
			$this->view->offset=$offset;
			
			$this->view->surat = "Surat Keterangan kk";
			$this->view->permintaan = $this->surat_serv->getProseskk($this->id_kelurahan,$offset,$dataPerPage);
			
			//mendapatkan jumlah yang belum diproses dan selesai
			$jumlahstatus1 = $this->surat_serv->getJumlahStatuskk1();	
			if($jumlahstatus1>=1){		
				$peringatanstatus1 = "Ada $jumlahstatus1 surat yang belum diproses. Silakan tekan tombol proses";
			}
			$this->view->jumlahstatus1 = $jumlahstatus1;
			$this->view->peringatanstatus1 = $peringatanstatus1;
			
			$jumlahstatus2 = $this->surat_serv->getJumlahStatuskk2();
			if($jumlahstatus2>=1){
				$peringatanstatus2 = "Ada $jumlahstatus2 surat yang belum selesai. Silakan tekan tombol selesai";
			}
			$this->view->jumlahstatus2 = $jumlahstatus2;
			$this->view->peringatanstatus2 = $peringatanstatus2;
		}
		
		public function pencariankkAction(){
			$this->view;
			$this->view->kelurahan = $this->id_kelurahan;
			$this->id_kelurahan;
			$id_surat = $this->_getParam("id_surat");
			$id_pencarian = $_POST['id_pencarian'];
			$pencarian = $_POST['pencarian'];
			if(!$pencarian){
				$this->kkAction();
				$this->render('kk');
				}else{
				$this->view->surat = "Surat Keterangan kk";
				$this->view->cari = $pencarian;
				$this->view->permintaan = $this->surat_serv->getPencariankk($this->id_kelurahan,$pencarian,$id_pencarian);
			}
		}
		
		public function caripendudukkkAction() {
			$this->view;
			$this->view->surat = "Form Isian Surat Keterangan kk";
			$this->view->judul = "Masukan NIK";
		}
		
		//antrian kk --> proses memasukan ke antrian kk, status = 1
		public function kkantrianAction(){
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			
			$nik = $_POST['nik'];
			$this->view->surat = "Form Antrian Keterangan kk";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			
			//mengambil noregistrasi secara automatis
			$no_registrasi = $this->surat_serv->getNoRegistrasi(4,kkk); //4 adalah panjangnya, AN adalah kode huruf
			$this->view->no_registrasi=$no_registrasi;
			
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('kkantrian');
			
		}
		
		//menyimpan antrian andon nikah
		public function simpankkantrianAction(){
			if(isset($_POST['name'])){ 
				$id_kelurahan = $this->id_kelurahan;			
				$id_pengguna = $this->id_pengguna;		
				$nama_pengguna = $this->id_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$no_telp = $_POST['no_telp'];
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
								"status" => $status,
								"no_telp" => $no_telp
								);										 
				$hasil = $this->surat_serv->getsimpankkantrian($data);
				
				//simpan data ke tabel no_registrasi
				$registrasi = array("no_registrasi" =>  	$no_registrasi,
									"nik" => $nik							
									);										 
				$hasil = $this->surat_serv->getSimpanNoRegistrasi($registrasi);
				
				
				//jika gagal
				if($hasil=="gagal"){
					$this->view->peringatan ="<div class='gagal'>$hasil. Maaf ada kesalahan;</div>";
					$this->kkAction();
					$this->render('kk');					
				}
				//jika sukses
				if($hasil=="sukses"){
					$this->view->peringatan ="<div class='sukses'> Sukses, data berhasil ditambahkan ke antrian </div>";		
					$this->kkAction();
					$this->render('kk');
				}	
				}else{
				$this->kkAction();
				$this->render('kk');
			}
			
		}
		
		public function kkprosesAction(){
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->id_pengguna;
			
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			$no_registrasi= $this->_getParam(no_registrasi);
			
			$waktu_antrian= $this->_getParam(waktu_antrian);
			$waktu_sekarang = date("H:i:s");
			$lama = $this->surat_serv->selisih($waktu_antrian,$waktu_sekarang);	
			
			
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;		
			$this->view->lama= $lama;
			
			$this->view->surat = "Form Isian Surat Keterangan kk";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('kkproses');
		
		}
		
		public function simpanproseskkAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->id_pengguna;
				
				$waktu_proses = date("H:i:s");
				$proses_oleh= $nama_pengguna;
				
				$id_kelurahan = $this->id_kelurahan;
				$id_permintaan_kk = $_POST['id_permintaan_kk'];
				$id_jenis_surat = $_POST['id_jenis_surat'];
				$id_surat = $_POST['id_surat'];
				$keperluan = $_POST['keperluan'];
				$nik = $_POST['nik'];
				$id_pejabat = $_POST['id_pejabat'];
				$no_surat = $_POST['no_surat'];
				$tanggal_surat = $_POST['tanggal_surat'];
				$ket = $_POST['ket'];
				$no_surat_pengantar = strip_tags($_POST['no_surat_pengantar']);
				$tanggal_surat_pengantar = strip_tags($_POST['tanggal_surat_pengantar']);
				$status = 2;
				
				$data = array("id_kelurahan" => $id_kelurahan,
								"id_permintaan_kk" => $id_permintaan_kk,
								"keperluan" => $keperluan,
								"nik" => $nik,
								"id_pejabat" => $id_pejabat,
								"id_jenis_surat" => $id_jenis_surat,
								"id_surat" => $id_surat,
								"no_surat" => $no_surat,
								"tanggal_surat" => $tanggal_surat,
								"no_surat_pengantar" => $no_surat_pengantar,
								"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
								"status" => $status,
								"waktu_proses" => $waktu_proses,
								"proses_oleh" => $proses_oleh,
								"ket" => $ket
								);
				
				$hasil = $this->surat_serv->getsimpanproseskk($data);
				// var_dump($hasil);
				// var_dump($data);
				//jika gagal
				if($hasil=='gagal'){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
					$this->kkAction();
					$this->render('kk');
				}
				//jika sukses
				if($hasil=='sukses'){
					$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diproses </div>";		
					$this->kkAction();
					$this->render('kk');
				}
			}else{
				$this->kkAction();
				$this->render('kk');
			}
			
		}
		public function kkhapusAction(){
			$id_permintaan_kk= $this->_getParam("id_permintaan_kk");
			$hasil = $this->surat_serv->gethapuskk($id_permintaan_kk);
			
			//jika gagal
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->kkAction();
				$this->render('kk');
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
			$this->kkAction();
			$this->render('kk');	
		}
		public function kkeditAction(){
			$this->view->surat = "Surat Keterangan kk";
			$id_permintaan_kk = $this->_getParam("id_permintaan_kk");
			$this->view->hasil = $this->surat_serv->getkk($id_permintaan_kk);
		}
		
		public function simpanproseskkeditAction(){
			$id_permintaan_kk = $this->_getParam('id_permintaan_kk');
			$id_kelurahan = $this->id_kelurahan;
			$nik = $_POST['nik'];
			$no_surat = $_POST['no_surat'];
			$tanggal_surat = $_POST['tanggal_surat'];
			$no_surat_pengantar = $_POST['no_surat_pengantar'];
			$tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
			$keperluan = $_POST['keperluan'];
			$ket = $_POST['ket'];
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
							"id_permintaan_kk" => $id_permintaan_kk,
							"nik" => $nik,
							"no_surat" => $no_surat,
							"tanggal_surat" => $tanggal_surat,
							"no_surat_pengantar" => $no_surat_pengantar,
							"keperluan" => $keperluan,
							"ket" => $ket,
							"tanggal_surat_pengantar" => $tanggal_surat_pengantar);
			
			$hasil = $this->surat_serv->getsimpankkedit($data);
			//jika gagal 
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->kkAction();
				$this->render('kk');
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
				$this->kkAction();
				$this->render('kk');
			}
		}
		
		//proses selesai
		public function kkselesaiAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->id_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_kk= $this->_getParam("id_permintaan_kk");
			$nama= $this->_getParam("nama");
			$nik= $this->_getParam("nik");
			$no_surat= $this->_getParam("no_surat");
			$tanggal_surat= $this->_getParam("tanggal_surat");
			$nama_surat= "Keterangan kk";
			$asal_controller= "kk";
			$no_registrasi= $this->_getParam("no_registrasi");
			$waktu_antrian= $this->_getParam("waktu_antrian");
			$status= 3;	
			
			//menghitung lama
			
			$waktu_selesai = date("H:i:s");
			$waktu_total = $this->surat_serv->selisih($waktu_antrian,$waktu_selesai);
			
			$data = array("id_permintaan_kk" => $id_permintaan_kk,
			"status" => $status,
			"waktu_selesai" => $waktu_selesai,
			"waktu_total" => $waktu_total);
			
			$hasil = $this->surat_serv->getSelesaikk($data);
			//var_dump($hasil);
			$this->view->asal_controller = $asal_controller;
			$this->view->render = $render;
			$this->view->nik = $nik;
			$this->view->nama = $nama;
			$this->view->no_surat = $no_surat;
			$this->view->tanggal_surat = $tanggal_surat;
			$this->view->nama_surat = $nama_surat;
			$this->view->surat = "Form Tambah Surat";
			$this->render('arsiptambah');	
		}
		
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////    LAIN LAIN      /////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		
		//--------------------------------------surat serbaguna	
		public function serbagunacetakAction(){
			$id_permintaan_serbaguna = $this->_getParam("id_permintaan_serbaguna");
			$this->view->hasil = $this->surat_serv->getserbagunacetak($id_permintaan_serbaguna);
		}
		
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
			
			$this->view->surat = "Surat Keterangan lain-lain";
			$this->view->permintaan = $this->surat_serv->getProsesserbaguna($this->id_kelurahan,$offset,$dataPerPage);
			
			//mendapatkan jumlah yang belum diproses dan selesai
			$jumlahstatus1 = $this->surat_serv->getJumlahStatusSerbaguna1();	
			if($jumlahstatus1>=1){		
				$peringatanstatus1 = "Ada $jumlahstatus1 surat yang belum diproses. Silakan tekan tombol proses";
			}
			$this->view->jumlahstatus1 = $jumlahstatus1;
			$this->view->peringatanstatus1 = $peringatanstatus1;
			
			$jumlahstatus2 = $this->surat_serv->getJumlahStatusSerbaguna2();
			if($jumlahstatus2>=1){
				$peringatanstatus2 = "Ada $jumlahstatus2 surat yang belum selesai. Silakan tekan tombol selesai";
			}
			$this->view->jumlahstatus2 = $jumlahstatus2;
			$this->view->peringatanstatus2 = $peringatanstatus2;
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
				$this->view->surat = "Surat Keterangan lain-lain";
				$this->view->cari = $pencarian;
				$this->view->permintaan = $this->surat_serv->getPencarianserbaguna($this->id_kelurahan,$pencarian,$id_pencarian);
			}
		}
		
		public function caripendudukserbagunaAction() {
			$this->view;
			$this->view->surat = "Form Isian Surat Keterangan lain-lain";
			$this->view->judul = "Masukan NIK";
		}
		
		//antrian serbaguna --> proses memasukan ke antrian serbaguna, status = 1
		public function serbagunaantrianAction(){
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			
			$nik = $_POST['nik'];
			$this->view->surat = "Form Antrian Keterangan Serbaguna";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			
			//mengambil noregistrasi secara automatis
			$no_registrasi = $this->surat_serv->getNoRegistrasi(4,SER); //4 adalah panjangnya, AN adalah kode huruf
			$this->view->no_registrasi=$no_registrasi;
			
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('serbagunaantrian');
			
		}
		
		//menyimpan antrian andon nikah
		public function simpanserbagunaantrianAction(){
			if(isset($_POST['name'])){ 
				$id_kelurahan = $this->id_kelurahan;			
				$id_pengguna = $this->id_pengguna;		
				$nama_pengguna = $this->id_pengguna;
				
				$no_registrasi = $_POST['no_registrasi'];
				$nik = $_POST['nik'];
				$no_telp = $_POST['no_telp'];
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
								"status" => $status,
								"no_telp" => $no_telp
								);										 
				$hasil = $this->surat_serv->getsimpanserbagunaantrian($data);
				
				//simpan data ke tabel no_registrasi
				$registrasi = array("no_registrasi" =>  	$no_registrasi,
									"nik" => $nik							
									);										 
				$hasil = $this->surat_serv->getSimpanNoRegistrasi($registrasi);
				
				
				//jika gagal
				if($hasil=="gagal"){
					$this->view->peringatan ="<div class='gagal'>$hasil. Maaf ada kesalahan;</div>";
					$this->serbagunaAction();
					$this->render('serbaguna');					
				}
				//jika sukses
				if($hasil=="sukses"){
					$this->view->peringatan ="<div class='sukses'> Sukses, data berhasil ditambahkan ke antrian </div>";		
					$this->serbagunaAction();
					$this->render('serbaguna');
				}	
				}else{
				$this->serbagunaAction();
				$this->render('serbaguna');
			}
			
		}
		
		public function serbagunaprosesAction(){
			$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
			
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->id_pengguna;
			
			$this->view->getSurat = $this->surat_serv->getKodeSurat(3);
			$no_registrasi= $this->_getParam(no_registrasi);
			
			$waktu_antrian= $this->_getParam(waktu_antrian);
			$waktu_sekarang = date("H:i:s");
			$lama = $this->surat_serv->selisih($waktu_antrian,$waktu_sekarang);	
			
			
			$nik= $this->_getParam("nik");
			$this->view->no_registrasi= $no_registrasi;
			$KodeKelurahan = 'KEL.LG';
			$this->view->KodeKelurahan= $KodeKelurahan;		
			$this->view->lama= $lama;
			
			$this->view->surat = "Form Isian Surat Keterangan lain-lain";
			$hasil = $this->surat_serv->getPenduduk($nik);
			$this->view->hasil = $hasil;
			$this->view->pejabat = $this->surat_serv->getPejabatAll($this->id_kelurahan);
			$this->render('serbagunaproses');
		
		}
		
		public function simpanprosesserbagunaAction(){
			if(isset($_POST['name'])){ //menghindari duplikasi data
				$id_pengguna = $this->id_pengguna;
				$nama_pengguna = $this->id_pengguna;
				
				$waktu_proses = date("H:i:s");
				$proses_oleh= $nama_pengguna;
				
				$id_kelurahan = $this->id_kelurahan;
				$id_permintaan_serbaguna = $_POST['id_permintaan_serbaguna'];
				$id_jenis_surat = $_POST['id_jenis_surat'];
				$id_surat = $_POST['id_surat'];
				$keperluan = $_POST['keperluan'];
				$nik = $_POST['nik'];
				$id_pejabat = $_POST['id_pejabat'];
				$no_surat = $_POST['no_surat'];
				$tanggal_surat = $_POST['tanggal_surat'];
				$ket = $_POST['ket'];
				$no_surat_pengantar = strip_tags($_POST['no_surat_pengantar']);
				$tanggal_surat_pengantar = strip_tags($_POST['tanggal_surat_pengantar']);
				$status = 2;
				
				$data = array("id_kelurahan" => $id_kelurahan,
								"id_permintaan_serbaguna" => $id_permintaan_serbaguna,
								"keperluan" => $keperluan,
								"nik" => $nik,
								"id_pejabat" => $id_pejabat,
								"id_jenis_surat" => $id_jenis_surat,
								"id_surat" => $id_surat,
								"no_surat" => $no_surat,
								"tanggal_surat" => $tanggal_surat,
								"no_surat_pengantar" => $no_surat_pengantar,
								"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
								"status" => $status,
								"waktu_proses" => $waktu_proses,
								"proses_oleh" => $proses_oleh,
								"ket" => $ket
								);
				
				$hasil = $this->surat_serv->getsimpanprosesserbaguna($data);
				// var_dump($hasil);
				// var_dump($data);
				//jika gagal
				if($hasil=='gagal'){
					$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
					$this->serbagunaAction();
					$this->render('serbaguna');
				}
				//jika sukses
				if($hasil=='sukses'){
					$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diproses </div>";		
					$this->serbagunaAction();
					$this->render('serbaguna');
				}
			}else{
				$this->serbagunaAction();
				$this->render('serbaguna');
			}
			
		}
		public function serbagunahapusAction(){
			$id_permintaan_serbaguna= $this->_getParam("id_permintaan_serbaguna");
			$hasil = $this->surat_serv->gethapusserbaguna($id_permintaan_serbaguna);
			
			//jika gagal
			if($hasil=='gagal'){
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
			$this->view->surat = "Surat Keterangan lain-lain";
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
			$keperluan = $_POST['keperluan'];
			$ket = $_POST['ket'];
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
							"id_permintaan_serbaguna" => $id_permintaan_serbaguna,
							"nik" => $nik,
							"no_surat" => $no_surat,
							"tanggal_surat" => $tanggal_surat,
							"no_surat_pengantar" => $no_surat_pengantar,
							"keperluan" => $keperluan,
							"ket" => $ket,
							"tanggal_surat_pengantar" => $tanggal_surat_pengantar);
			
			$hasil = $this->surat_serv->getsimpanserbagunaedit($data);
			//jika gagal 
			if($hasil=='gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->serbagunaAction();
				$this->render('serbaguna');
			}
			//jika sukses
			if($hasil=='sukses'){
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
				$this->serbagunaAction();
				$this->render('serbaguna');
			}
		}
		
		//proses selesai
		public function serbagunaselesaiAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->id_pengguna;
			
			$selesai_oleh= $id_pengguna;
			
			$id_permintaan_serbaguna= $this->_getParam("id_permintaan_serbaguna");
			$nama= $this->_getParam("nama");
			$nik= $this->_getParam("nik");
			$no_surat= $this->_getParam("no_surat");
			$tanggal_surat= $this->_getParam("tanggal_surat");
			$nama_surat= "Keterangan lain-lain";
			$asal_controller= "serbaguna";
			$no_registrasi= $this->_getParam("no_registrasi");
			$waktu_antrian= $this->_getParam("waktu_antrian");
			$status= 3;	
			
			//menghitung lama
			
			$waktu_selesai = date("H:i:s");
			$waktu_total = $this->surat_serv->selisih($waktu_antrian,$waktu_selesai);
			
			$data = array("id_permintaan_serbaguna" => $id_permintaan_serbaguna,
			"status" => $status,
			"waktu_selesai" => $waktu_selesai,
			"waktu_total" => $waktu_total);
			
			$hasil = $this->surat_serv->getSelesaiSerbaguna($data);
			//var_dump($hasil);
			$this->view->asal_controller = $asal_controller;
			$this->view->render = $render;
			$this->view->nik = $nik;
			$this->view->nama = $nama;
			$this->view->no_surat = $no_surat;
			$this->view->tanggal_surat = $tanggal_surat;
			$this->view->nama_surat = $nama_surat;
			$this->view->surat = "Form Tambah Surat";
			$this->render('arsiptambah');	
		}
		
		//penduduk
		public function pendudukAction(){
			$this->view;
			$this->id_kelurahan;
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
			
			$this->view->dataPerPage = $dataPerPage;
			$this->view->noPage = $noPage;
			$this->view->offset=$offset;
			
			$this->view->surat = "Data Penduduk";
			
			if(isset($_POST['btnCari'])){
				$id_pencarian = $_POST['id_pencarian'];
				$pencarian = trim($_POST['pencarian']);
				
				if(!$pencarian){
					$this->pendudukAction();
					$this->render('penduduk');
				}else{
					
					
					$this->view->cari = $pencarian;	
					$this->view->jumData = $this->surat_serv->getJumlahPendudukCari($id_pencarian, $pencarian,$this->id_kelurahan);
					$this->view->hasil = $this->surat_serv->getCariPenduduk($id_pencarian, $pencarian,$this->id_kelurahan,$offset,$dataPerPage);
				}
			
			}else{
				$this->view->jumData = $this->surat_serv->getJumlahPenduduk($this->id_kelurahan);
				$this->view->hasil = $this->surat_serv->getAllPenduduk($this->id_kelurahan,$offset,$dataPerPage);
			}
		}
		
		///tambah penduduk
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