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
		$this->view->permintaan = $this->surat_serv->getPermintaanRumahSakit($this->id_kelurahan, $offset, $dataPerPage);
		
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
	public function rumahsakithapusAction(){
		$id_permintaan_rumahsakit= $this->_getParam("id_permintaan_rumahsakit");
		$hasil = $this->surat_serv->gethapusrumahsakit($id_permintaan_rumahsakit);
		
		//jika gagal
		if(!hasil){
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
	public function simpanpermintaanrseditAction(){
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
										 
			$hasil = $this->surat_serv->getsimpanpermintaanrsedit($data);
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
	//penduduk
	public function tambahpendudukAction(){
	
		$this->view;
		$this->view->surat = "Tambah Penduduk";
		$this->view->kelurahan = $this->pengguna->getKelurahan();
	
	}
	public function simpanpermintaanrsAction(){
		if(isset($_POST['name'])){ //menghindari duplikasi data
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->nama_pengguna;
				
			$tgl_dibuat = date("Y-m-d H:i:s");
			$dibuat_oleh= $nama_pengguna;
			
			 $id_kelurahan = $this->id_kelurahan;
			 $id_pejabat = $_POST['id_pejabat'];
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
			 $status = 0;
			 
			$data = array("id_pengguna" =>  	$id_pengguna,
							"id_kelurahan" =>  	$id_kelurahan,
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
							"tgl_dibuat" => $tgl_dibuat,
							"dibuat_oleh" => $dibuat_oleh);
										 
			$hasil = $this->surat_serv->getsimpanpermintaanrs($data);
			$hasil2 = $this->surat_serv->getsimpanhistoripermintaanrs($data);
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->rumahsakitAction();
				$this->render('rumahsakit');			
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil ditambah </div>";		
			$this->rumahsakitAction();
			$this->render('rumahsakit');
		}else{
			$this->rumahsakitAction();
			$this->render('rumahsakit');		
		}				
	}
	
	public function caripendudukAction() {
		$this->view;
		$this->view->surat = "Form Isian Surat Keterangan Tidak Mampu untuk Rumah Sakit";
		$this->view->judul = "Masukan NIK";
	}
	public function permintaanrsAction(){
		$nik = $_POST['nik'];
		$this->view->surat = "Form Isian Surat Keterangan Tidak Mampu untuk Rumah Sakit";
		$hasil = $this->surat_serv->getPenduduk($nik);
		$this->view->hasil = $hasil;
		$this->view->pejabat = $this->surat_serv->getPejabatpemperdayaan($this->id_kelurahan);
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
		$tanggal_lahir = $_POST['tgl_lahir'];
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
		$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil ditambah </div>";		
			$this->homeAction();
			$this->render('home');	
	
		
	}
	///////////////////////////////Sekolah
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
		$this->view->permintaan = $this->surat_serv->getPermintaanSekolah($this->id_kelurahan,$offset,$dataPerPage);
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
	
	public function permintaansekolahAction(){
		$nik = $_POST['nik'];
		$this->view->surat = "Form Isian Surat Keterangan Tidak Mampu untuk Sekolah";
		$hasil = $this->surat_serv->getPenduduk($nik);
		$this->view->hasil = $hasil;
		$this->view->pejabat = $this->surat_serv->getPejabatpemperdayaan($this->id_kelurahan);
	}
	
	public function simpanpermintaansekolahAction(){
		if(isset($_POST['name'])){ //menghindari duplikasi data
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->nama_pengguna;
				
			$tgl_dibuat = date("Y-m-d H:i:s");
			$dibuat_oleh= $nama_pengguna;
			
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
			 $status = 0;
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
							"id_pejabat" =>  	$id_pejabat,
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
								"tgl_dibuat" => $tgl_dibuat,
								"dibuat_oleh" => $dibuat_oleh
								);
										 
			$hasil = $this->surat_serv->getsimpanpermintaansekolah($data);
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->sekolahAction();
				$this->render('sekolah');				
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil ditambah </div>";		
				$this->sekolahAction();
				$this->render('sekolah');
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
	
		public function simpanpermintaansekolaheditAction(){
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
									 
		$hasil = $this->surat_serv->getsimpanpermintaansekolahedit($data);
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
		$this->view->permintaan = $this->surat_serv->getPermintaanAndonNikah($this->id_kelurahan,$offset,$dataPerPage);
	}
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
	
	public function caripendudukandonnikahAction() {
		$this->view;
		$this->view->surat = "Form Isian Surat Keterangan Andon Nikah";
		$this->view->judul = "Masukan NIK";
	}
	
	public function permintaancariandonnikahAction(){
		$nik = $_POST['nik'];
		$hasil = $this->surat_serv->getCariPenduduk($nik);
		echo json_encode ($hasil);
	}
	public function permintaanandonnikahAction(){
		$nik = $_POST['nik'];
		$this->view->surat = "Form Isian Surat Keterangan Andon Nikah";
		$hasil = $this->surat_serv->getPenduduk($nik);
		$this->view->hasil = $hasil;
		$this->view->pejabat = $this->surat_serv->getPejabatpemperdayaan($this->id_kelurahan);
	}
	public function simpanpermintaanandonnikahAction(){
		if(isset($_POST['name'])){ 
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
			 $nama_pasangan = $_POST['nama_pasangan'];
			 $alamat_pasangan = $_POST['alamat_pasangan'];
			 $status = 0;
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
							"nik" => $nik,
							"id_pejabat" => $id_pejabat,
								"no_surat" => $no_surat,
								"tanggal_surat" => $tanggal_surat,
								"no_surat_pengantar" => $no_surat_pengantar,
								"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
								"nama_pasangan" => $nama_pasangan,
								"alamat_pasangan" => $alamat_pasangan,
								"status" => $status,
								"tgl_dibuat" => $tgl_dibuat,
								"dibuat_oleh" => $dibuat_oleh
								);
										 
			$hasil = $this->surat_serv->getsimpanpermintaanandonnikah($data);
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->andonnikahAction();
				$this->render('andonnikah');					
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil ditambah </div>";		
				$this->andonnikahAction();
				$this->render('andonnikah');	
		}else{
			$this->andonnikahAction();
			$this->render('andonnikah');
		}
		
	}
	public function andonnikahhapusAction(){
		$id_permintaan_andonnikah= $this->_getParam("id_permintaan_andonnikah");
		$hasil = $this->surat_serv->gethapusandonnikah($id_permintaan_andonnikah);
		//jika gagal
		if(!hasil){
			$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
			$this->andonnikahAction();
			$this->render('andonnikah');					
		}
		//jika sukses
		$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
			$this->andonnikahAction();
			$this->render('andonnikah');	
	}
	public function andonnikaheditAction(){
		$id_permintaan_andonnikah = $this->_getParam("id_permintaan_andonnikah");
		$this->view->surat = "Ubah Permintaan Surat Keterangan Andon Nikah";
		$this->view->hasil = $this->surat_serv->getandonnikah($id_permintaan_andonnikah);
	}
	
	public function simpanpermintaanandonnikaheditAction(){
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
									 
		$hasil = $this->surat_serv->getsimpanpermintaanandonnikahedit($data);
		//jika gagal
		if(!hasil){
			$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
			$this->andonnikahAction();
			$this->render('andonnikah');				
		}
		//jika sukses
		$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
			$this->andonnikahAction();
			$this->render('andonnikah');
			
	}
		//-------------------------------BELUM MENIKAH
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
		$this->view->permintaan = $this->surat_serv->getPermintaanBelumMenikah($this->id_kelurahan,$offset,$dataPerPage);
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
	public function permintaanbelummenikahAction(){
		$nik = $_POST['nik'];
		$this->view->surat = "Form Isian Surat Keterangan Belum Menikah";
		$hasil = $this->surat_serv->getPenduduk($nik);
		$this->view->hasil = $hasil;
		$this->view->pejabat = $this->surat_serv->getPejabatpemperdayaan($this->id_kelurahan);
	}
	public function simpanpermintaanbelummenikahAction(){
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
			 $keperluan = $_POST['keperluan'];
			 $status = 0;
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
							"nik" => $nik,
							"id_pejabat" => $id_pejabat,
								"no_surat" => $no_surat,
								"tanggal_surat" => $tanggal_surat,
								"no_surat_pengantar" => $no_surat_pengantar,
								"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
								"keperluan" => $keperluan,
								"status" => $status,
								"tgl_dibuat" => $tgl_dibuat,
								"dibuat_oleh" => $dibuat_oleh
								);
										 
			$hasil = $this->surat_serv->getsimpanpermintaanbelummenikah($data);
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->belummenikahAction();
				$this->render('belummenikah');				
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil ditambah </div>";		
				$this->belummenikahAction();
				$this->render('belummenikah');
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
	
	public function simpanpermintaanbelummenikaheditAction(){
		 $id_permintaan_belummenikah = $this->_getParam('id_permintaan_belummenikah');
		  $id_kelurahan = $this->id_kelurahan;
		 $nik = $_POST['nik'];
		 $no_surat = $_POST['no_surat'];
		 $tanggal_surat = $_POST['tanggal_surat'];
		 $no_surat_pengantar = $_POST['no_surat_pengantar'];
		 $tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
		 $keperluan = $_POST['keperluan'];
		
		
		$data = array("id_kelurahan" =>  	$id_kelurahan,
						"id_permintaan_belummenikah" => $id_permintaan_belummenikah,
						"nik" => $nik,
							"no_surat" => $no_surat,
							"tanggal_surat" => $tanggal_surat,
							"no_surat_pengantar" => $no_surat_pengantar,
							"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
							"keperluan" => $keperluan
							);
									 
		$hasil = $this->surat_serv->getsimpanpermintaanbelummenikahedit($data);
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
	//----------------------------------------BELUM PUNYA RUMAH
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
		$this->view->permintaan = $this->surat_serv->getPermintaanbpr($this->id_kelurahan,$offset,$dataPerPage);
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
	public function permintaanbprAction(){
		$nik = $_POST['nik'];
		$this->view->surat = "Form Isian Surat Keterangan Belum Mempunyai Rumah";
		$hasil = $this->surat_serv->getPenduduk($nik);
		$this->view->hasil = $hasil;
		$this->view->pejabat = $this->surat_serv->getPejabatpemperdayaan($this->id_kelurahan);
	}
	public function simpanpermintaanbprAction(){
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
			 $keperluan = $_POST['keperluan'];
			 $stl = $_POST['stl'];
			 $status = 0;
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
							"nik" => $nik,
							"id_pejabat" => $id_pejabat,
								"no_surat" => $no_surat,
								"tanggal_surat" => $tanggal_surat,
								"no_surat_pengantar" => $no_surat_pengantar,
								"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
								"keperluan" => $keperluan,
								"stl" => $stl,
								"status" => $status,
								"tgl_dibuat" => $tgl_dibuat,
								"dibuat_oleh" => $dibuat_oleh
								);
										 
			$hasil = $this->surat_serv->getsimpanpermintaanbpr($data);
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->bprAction();
				$this->render('bpr');			
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil ditambah </div>";		
				$this->bprAction();
				$this->render('bpr');
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
	
	public function simpanpermintaanbpreditAction(){
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
									 
		$hasil = $this->surat_serv->getsimpanpermintaanbpredit($data);
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
	//--------------------------------------IBADAH HAJI
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
		$this->view->permintaan = $this->surat_serv->getPermintaanIbadahHaji($this->id_kelurahan,$offset,$dataPerPage);
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
	public function permintaanibadahhajiAction(){
		$nik = $_POST['nik'];
		$this->view->surat = "Form Isian Surat Keterangan Menunaikan Ibadah Haji";
		$hasil = $this->surat_serv->getPenduduk($nik);
		$this->view->hasil = $hasil;
		$this->view->pejabat = $this->surat_serv->getPejabatpemperdayaan($this->id_kelurahan);
	}
	public function simpanpermintaanibadahhajiAction(){
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
										 
			$hasil = $this->surat_serv->getsimpanpermintaanibadahhaji($data);
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->ibadahhajiAction();
				$this->render('ibadahhaji');		
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil ditambah </div>";		
				$this->ibadahhajiAction();
				$this->render('ibadahhaji');
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
	
	public function simpanpermintaanibadahhajieditAction(){
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
									 
		$hasil = $this->surat_serv->getsimpanpermintaanibadahhajiedit($data);
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
	//--------------------------------------JANDA
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
		$this->view->permintaan = $this->surat_serv->getPermintaanjanda($this->id_kelurahan,$offset,$dataPerPage);
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
	public function permintaanjandaAction(){
		$nik = $_POST['nik'];
		$this->view->surat = "Form Isian Surat Keterangan Berstatus Janda";
		$hasil = $this->surat_serv->getPenduduk($nik);
		$this->view->hasil = $hasil;
		$this->view->pejabat = $this->surat_serv->getPejabatpemperdayaan($this->id_kelurahan);
	}
	public function simpanpermintaanjandaAction(){
		if(isset($_POST['name'])){ //menghindari duplikasi data
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->nama_pengguna;
				
			$tgl_dibuat = date("Y-m-d H:i:s");
			$dibuat_oleh= $nama_pengguna;

			 $id_kelurahan = $this->id_kelurahan;
			 $id_pejabat = $_POST['id_pejabat'];
			 $nik = $_POST['nik'];
			 $no_surat = $_POST['no_surat'];
			 $tanggal_surat = $_POST['tanggal_surat'];
			 $no_surat_pengantar = $_POST['no_surat_pengantar'];
			 $tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
			 $sebab_janda = $_POST['sebab_janda'];
			 $keperluan = $_POST['keperluan'];
			 $status = 0;
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
							"nik" => $nik,
							"id_pejabat" => $id_pejabat,
								"no_surat" => $no_surat,
								"tanggal_surat" => $tanggal_surat,
								"no_surat_pengantar" => $no_surat_pengantar,
								"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
								"sebab_janda" => $sebab_janda,
								"keperluan" => $keperluan,
								"status" => $status,
								"tgl_dibuat" => $tgl_dibuat,
								"dibuat_oleh" => $dibuat_oleh
								);
										 
			$hasil = $this->surat_serv->getsimpanpermintaanjanda($data);
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->jandaAction();
				$this->render('janda');			
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil ditambah </div>";		
				$this->jandaAction();
				$this->render('janda');	
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
	
	public function simpanpermintaanjandaeditAction(){
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
									 
		$hasil = $this->surat_serv->getsimpanpermintaanjandaedit($data);
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
	//--------------------------------------IJIN KERAMAIAN
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
		$this->view->permintaan = $this->surat_serv->getPermintaanik($this->id_kelurahan,$offset,$dataPerPage);
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
	public function permintaanikAction(){
		$nik = $_POST['nik'];
		$this->view->surat = "Form Isian Surat Ketrangan Ijin Keramaian";
		$hasil = $this->surat_serv->getPenduduk($nik);
		$this->view->hasil = $hasil;
		$this->view->pejabat = $this->surat_serv->getPejabattantrib($this->id_kelurahan);
	}
	public function simpanpermintaanikAction(){
		if(isset($_POST['name'])){ //menghindari duplikasi data
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->nama_pengguna;
				
			$tgl_dibuat = date("Y-m-d H:i:s");
			$dibuat_oleh= $nama_pengguna;
			
			 $id_kelurahan = $this->id_kelurahan;
			 $id_pejabat = $_POST['id_pejabat'];
			 $nik = $_POST['nik'];
			 $no_surat = $_POST['no_surat'];
			 $tanggal_surat = $_POST['tanggal_surat'];
			 $no_surat_pengantar = $_POST['no_surat_pengantar'];
			 $tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
			 $hari_kegiatan = $_POST['hari_kegiatan'];
			 $tanggal_kegiatan = $_POST['tanggal_kegiatan'];
			 $waktu = $_POST['waktu'];
			 $nama_kegiatan = $_POST['nama_kegiatan'];
			$status = 0;
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
							"nik" => $nik,
							"id_pejabat" => $id_pejabat,
								"no_surat" => $no_surat,
								"tanggal_surat" => $tanggal_surat,
								"no_surat_pengantar" => $no_surat_pengantar,
								"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
								"hari_kegiatan" => $hari_kegiatan,
								"tanggal_kegiatan" => $tanggal_kegiatan,
								"waktu" => $waktu,
								"nama_kegiatan" => $nama_kegiatan,
								"status" => $status,
								"tgl_dibuat" => $tgl_dibuat,
								"dibuat_oleh" => $dibuat_oleh);
										 
			$hasil = $this->surat_serv->getsimpanpermintaanik($data);
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->ikAction();
				$this->render('ik');			
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil ditambah </div>";		
				$this->ikAction();
				$this->render('ik');
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
	
	public function simpanpermintaanikeditAction(){
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
									 
		$hasil = $this->surat_serv->getsimpanpermintaanikedit($data);
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
	//--------------------------------------BELUM PENGANTAR SKCK
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
		$this->view->permintaan = $this->surat_serv->getPermintaanps($this->id_kelurahan,$offset,$dataPerPage);
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
	public function permintaanpsAction(){
		$nik = $_POST['nik'];
		$this->view->surat = "Form Isian Surat Pengantar SKCK";
		$hasil = $this->surat_serv->getPenduduk($nik);
		$this->view->hasil = $hasil;
		$this->view->pejabat = $this->surat_serv->getPejabattantrib($this->id_kelurahan);
	}
	public function simpanpermintaanpsAction(){
		if(isset($_POST['name'])){ //menghindari duplikasi data
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->nama_pengguna;
				
			$tgl_dibuat = date("Y-m-d H:i:s");
			$dibuat_oleh= $nama_pengguna;

			 $id_kelurahan = $this->id_kelurahan;
			 $id_pejabat = $_POST['id_pejabat'];
			 $nik = $_POST['nik'];
			 $no_surat = $_POST['no_surat'];
			 $tanggal_surat = $_POST['tanggal_surat'];
			 $no_surat_pengantar = $_POST['no_surat_pengantar'];
			 $tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
			 $keperluan = $_POST['keperluan'];
			 $status = 0;
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
							"id_pejabat" =>  	$id_pejabat,
							"nik" => $nik,
								"no_surat" => $no_surat,
								"tanggal_surat" => $tanggal_surat,
								"no_surat_pengantar" => $no_surat_pengantar,
								"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
								"keperluan" => $keperluan,
								"status" => $status,
								"tgl_dibuat" => $tgl_dibuat,
								"dibuat_oleh" => $dibuat_oleh);
										 
			$hasil = $this->surat_serv->getsimpanpermintaanps($data);
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->psAction();
				$this->render('ps');			
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil ditambah </div>";		
				$this->psAction();
				$this->render('ps');
		}else{
			$this->psAction();
			$this->render('ps');
		}
			
	}
	public function pshapusAction(){
		$id_permintaan_ps= $this->_getParam("id_permintaan_ps");
		$hasil = $this->surat_serv->gethapusps($id_permintaan_ps);
		
		//jika gagal
		if(!hasil){
			$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
			$this->psAction();
			$this->render('ps');			
		}
		//jika sukses
		$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
			$this->psAction();
			$this->render('ps');	
	}
	public function pseditAction(){
		$id_permintaan_ps = $this->_getParam("id_permintaan_ps");
		$this->view->surat = "Ubah Permintaan Surat Pengantar SKCK";
		$this->view->hasil = $this->surat_serv->getps($id_permintaan_ps);
	}
	
	public function simpanpermintaanpseditAction(){
		$id_pengguna = $this->id_pengguna;
		$nama_pengguna = $this->nama_pengguna;
			
		$tgl_dibuat = date("Y-m-d H:i:s");
		$dibuat_oleh= $nama_pengguna;
		
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
							"keperluan" => $keperluan,
							"tgl_dibuat" => $tgl_dibuat,
							"dibuat_oleh" => $dibuat_oleh);
									 
		$hasil = $this->surat_serv->getsimpanpermintaanpsedit($data);
		//jika gagal
		if(!hasil){
			$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
			$this->psAction();
			$this->render('ps');			
		}
		//jika sukses
		$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
			$this->psAction();
			$this->render('ps');	
	}
	//--------------------------------------BERSIH DIRI
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
		$this->view->permintaan = $this->surat_serv->getPermintaanbd($this->id_kelurahan,$offset,$dataPerPage);
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
	public function permintaanbdAction(){
		$nik = $_POST['nik'];
		$this->view->surat = "Form Isian Surat Keterangan Bersih Diri";
		$hasil = $this->surat_serv->getPenduduk($nik);
		$this->view->hasil = $hasil;
		$this->view->pejabat = $this->surat_serv->getPejabattantrib($this->id_kelurahan);
	}
	public function simpanpermintaanbdAction(){
		if(isset($_POST['name'])){ //menghindari duplikasi data
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->nama_pengguna;
				
			$tgl_dibuat = date("Y-m-d H:i:s");
			$dibuat_oleh= $nama_pengguna;

			 $id_kelurahan = $this->id_kelurahan;
			 $nik = $_POST['nik'];
			 $id_pejabat = $_POST['id_pejabat'];
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
			 $status = 0;
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
							"nik" => $nik,
							"id_pejabat" => $id_pejabat,
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
								"tgl_dibuat" => $tgl_dibuat,
								"dibuat_oleh" => $dibuat_oleh);
										 
			$hasil = $this->surat_serv->getsimpanpermintaanbd($data);
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->bdAction();
				$this->render('bd');			
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil ditambah </div>";		
				$this->bdAction();
				$this->render('bd');
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
	
	public function simpanpermintaanbdeditAction(){
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
									 
		$hasil = $this->surat_serv->getsimpanpermintaanbdedit($data);
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
	//--------------------------------------domisili yayasan
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
		$this->view->permintaan = $this->surat_serv->getPermintaanDomisiliYayasan($this->id_kelurahan,$offset,$dataPerPage);
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
	public function permintaandomisiliyayasanAction(){
		$nik = $_POST['nik'];
		$this->view->surat = "Form Isian Surat Domisili Yayasan";
		$hasil = $this->surat_serv->getPenduduk($nik);
		$this->view->hasil = $hasil;
		$this->view->pejabat = $this->surat_serv->getPejabatekbang($this->id_kelurahan);
	}
	public function simpanpermintaandomisiliyayasanAction(){
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
			 $keperluan = $_POST['keperluan'];
			 $masa_berlaku = $_POST['masa_berlaku'];
			 $nama_yayasan = $_POST['nama_yayasan'];
			 $bergerak_bidang = $_POST['bergerak_bidang'];
			 $jumlah_anggota = $_POST['jumlah_anggota'];
			 $jam_kerja = $_POST['jam_kerja'];
			 $alamat_usaha = $_POST['alamat_usaha'];
			 $status = 0;
			
			$data = array("id_kelurahan" =>  $id_kelurahan,
							"id_pejabat" => $id_pejabat,
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
								"alamat_usaha" => $alamat_usaha,
								"status" => $status,
								"tgl_dibuat" => $tgl_dibuat,
								"dibuat_oleh" => $dibuat_oleh);
										 
			$hasil = $this->surat_serv->getsimpanpermintaandomisiliyayasan($data);
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->domisiliyayasanAction();
				$this->render('domisiliyayasan');		
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil ditambah </div>";		
				$this->domisiliyayasanAction();
				$this->render('domisiliyayasan');
		}else{
			$this->domisiliyayasanAction();
			$this->render('domisiliyayasan');
		}
			
	}
	public function domisiliyayasanhapusAction(){
		$id_permintaan_domisili_yayasan= $this->_getParam("id_permintaan_domisili_yayasan");
		$hasil = $this->surat_serv->gethapusdomisiliyayasan($id_permintaan_domisili_yayasan);
		
		//jika gagal
		if(!hasil){
			$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
			$this->domisiliyayasanAction();
			$this->render('domisiliyayasan');		
		}
		//jika sukses
		$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
			$this->domisiliyayasanAction();
			$this->render('domisiliyayasan');
	}
	public function domisiliyayasaneditAction(){
		$id_permintaan_domisili_yayasan = $this->_getParam("id_permintaan_domisili_yayasan");
		$this->view->hasil = $this->surat_serv->getdomisiliyayasan($id_permintaan_domisili_yayasan);
	}
	
	public function simpanpermintaandomisiliyayasaneditAction(){
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
									 
		$hasil = $this->surat_serv->getsimpanpermintaandomisiliyayasanedit($data);
		//jika gagal
		if(!hasil){
			$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
			$this->domisiliyayasanAction();
			$this->render('domisiliyayasan');		
		}
		//jika sukses
		$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
			$this->domisiliyayasanAction();
			$this->render('domisiliyayasan');	
	}
	
	//--------------------------------------domisili parpol
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
		$this->view->permintaan = $this->surat_serv->getPermintaanDomisiliParpol($this->id_kelurahan,$offset , $dataPerPage);
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
	public function permintaandomisiliparpolAction(){
		$nik = $_POST['nik'];
		$this->view->surat = "Form Isian Surat Domisili Parpol";
		$hasil = $this->surat_serv->getPenduduk($nik);
		$this->view->hasil = $hasil;
		$this->view->pejabat = $this->surat_serv->getPejabatekbang($this->id_kelurahan);
	}
	public function simpanpermintaandomisiliparpolAction(){
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
			 $nama_parpol = $_POST['nama_parpol'];
			 $keperluan = $_POST['keperluan'];
			 $masa_berlaku = $_POST['masa_berlaku'];
			 $bergerak_bidang = $_POST['bergerak_bidang'];
			 $jumlah_anggota = $_POST['jumlah_anggota'];
			 $jam_kerja = $_POST['jam_kerja'];
			 $alamat_parpol = $_POST['alamat_parpol'];
			 $status = 0;
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
							"nik" => $nik,
							"id_pejabat" => $id_pejabat,
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
								"tgl_dibuat" => $tgl_dibuat,
								"dibuat_oleh" => $dibuat_oleh);
										 
			$hasil = $this->surat_serv->getsimpanpermintaandomisiliparpol($data);
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->domisiliparpolAction();
				$this->render('domisiliparpol');	
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil ditambah </div>";		
				$this->domisiliparpolAction();
				$this->render('domisiliparpol');
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
	
	public function simpanpermintaandomisiliparpoleditAction(){
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
									 
		$hasil = $this->surat_serv->getsimpanpermintaandomisiliparpoledit($data);
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
	
	//--------------------------------------domisili perusahaan
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
		$this->view->permintaan = $this->surat_serv->getPermintaanDomisiliPerusahaan($this->id_kelurahan,$offset , $dataPerPage);
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
	public function permintaandomisiliperusahaanAction(){
		$nik = $_POST['nik'];
		$this->view->surat = "Form Isian Surat Domisili Perusahaan";
		$hasil = $this->surat_serv->getPenduduk($nik);
		$this->view->hasil = $hasil;
		$this->view->pejabat = $this->surat_serv->getPejabatekbang($this->id_kelurahan);
	}
	public function simpanpermintaandomisiliperusahaanAction(){
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
			 $status = 0;
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
							"nik" => $nik,
							"id_pejabat" => $id_pejabat,
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
								"tgl_dibuat" => $tgl_dibuat,
								"dibuat_oleh" => $dibuat_oleh);
										 
			$hasil = $this->surat_serv->getsimpanpermintaandomisiliperusahaan($data);
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->domisiliperusahaanAction();
				$this->render('domisiliperusahaan');
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil ditambah </div>";		
				$this->domisiliperusahaanAction();
				$this->render('domisiliperusahaan');
		}else{
			$this->domisiliperusahaanAction();
			$this->render('domisiliperusahaan');
		}
			
	}
	public function domisiliperusahaanhapusAction(){
		$id_permintaan_domisili_perusahaan= $this->_getParam("id_permintaan_domisili_perusahaan");
		$hasil = $this->surat_serv->gethapusdomisiliperusahaan($id_permintaan_domisili_perusahaan);
		
		//jika gagal
		if(!hasil){
			$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
			$this->domisiliperusahaanAction();
			$this->render('domisiliperusahaan');
		}
		//jika sukses
		$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
			$this->domisiliperusahaanAction();
			$this->render('domisiliperusahaan');	
	}
	public function domisiliperusahaaneditAction(){
		$id_permintaan_domisili_perusahaan = $this->_getParam("id_permintaan_domisili_perusahaan");
		$this->view->hasil = $this->surat_serv->getdomisiliperusahaan($id_permintaan_domisili_perusahaan);
	}
	
	public function simpanpermintaandomisiliperusahaaneditAction(){
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
									 
		$hasil = $this->surat_serv->getsimpanpermintaandomisiliperusahaanedit($data);
		//jika gagal
		if(!hasil){
			$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
			$this->domisiliperusahaanAction();
			$this->render('domisiliperusahaan');
		}
		//jika sukses
		$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
			$this->domisiliperusahaanAction();
			$this->render('domisiliperusahaan');	
	}
	//--------------------------------------keterangan tempat usaha	
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
		$this->view->permintaan = $this->surat_serv->getPermintaanketerangantempatusaha($this->id_kelurahan,$offset , $dataPerPage);
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
	public function permintaanketerangantempatusahaAction(){
		$nik = $_POST['nik'];
		$this->view->surat = "Form Isian Surat Keterangan Tempat Usaha";
		$hasil = $this->surat_serv->getPenduduk($nik);
		$this->view->hasil = $hasil;
		$this->view->pejabat = $this->surat_serv->getPejabatekbang($this->id_kelurahan);
	}
	public function simpanpermintaanketerangantempatusahaAction(){
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
			 $bidang_usaha = $_POST['bidang_usaha'];
			 $alamat_usaha = $_POST['alamat_usaha'];		 
			 $tanggal_surat_pengantar = $_POST['tanggal_surat_pengantar'];
			 $masa_berlaku = $_POST['masa_berlaku'];
			 $status = 0;
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
							"nik" => $nik,
							"id_pejabat" => $id_pejabat,
								"no_surat" => $no_surat,
								"tanggal_surat" => $tanggal_surat,
								"no_surat_pengantar" => $no_surat_pengantar,
								"bidang_usaha" => $bidang_usaha,
								"alamat_usaha" => $alamat_usaha,
								"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
								"masa_berlaku" => $masa_berlaku,
								"status" => $status,
								"tgl_dibuat" => $tgl_dibuat,
								"dibuat_oleh" => $dibuat_oleh);
										 
			$hasil = $this->surat_serv->getsimpanpermintaanketerangantempatusaha($data);
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->keterangantempatusahaAction();
				$this->render('keterangantempatusaha');	
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil ditambah </div>";		
				$this->keterangantempatusahaAction();
				$this->render('keterangantempatusaha');	
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
	
	public function simpanpermintaanketerangantempatusahaeditAction(){
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
									 
		$hasil = $this->surat_serv->getsimpanpermintaanketerangantempatusahaedit($data);
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
	
	//--------------------------------------lahir	
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
		
		$this->view->surat = "Surat Keterangan Lahir";
		$this->view->permintaan = $this->surat_serv->getPermintaanlahir($this->id_kelurahan,$offset ,$dataPerPage);
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
	public function permintaanlahirAction(){
		$nik = $_POST['nik'];
		$this->view->surat = "Form Isian Surat Keterangan Lahir";
		$hasil = $this->surat_serv->getPenduduk($nik);
		$this->view->hasil = $hasil;
		$this->view->pejabat = $this->surat_serv->getPejabatpemerintahan($this->id_kelurahan);
	}
	public function simpanpermintaanlahirAction(){
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
			 $nama_anak = $_POST['nama_anak'];
			 $jenis_kelamin_anak = $_POST['jenis_kelamin_anak'];
			 $tempat_lahir_anak = $_POST['tempat_lahir_anak'];
			 $tgl_lahir_anak = $_POST['tgl_lahir_anak'];
			 $anak_ke = $_POST['anak_ke'];
			 $jam_lahir = $_POST['jam_lahir'];
			 
			 $status = 0;
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
							"nik" => $nik,
							"id_pejabat" => $id_pejabat,
								"no_surat" => $no_surat,
								"tanggal_surat" => $tanggal_surat,
								"no_surat_pengantar" => $no_surat_pengantar,
								"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
								"nama_anak" => $nama_anak,
								"jenis_kelamin_anak" => $jenis_kelamin_anak,
								"tanggal_surat_pengantar" => $tanggal_surat_pengantar,
								"tempat_lahir_anak" => $tempat_lahir_anak,
								"tgl_lahir_anak" => $tgl_lahir_anak,
								"anak_ke" => $anak_ke,
								"jam_lahir" => $jam_lahir,
								"status" => $status,
								"tgl_dibuat" => $tgl_dibuat,
								"dibuat_oleh" => $dibuat_oleh);
										 
			$hasil = $this->surat_serv->getsimpanpermintaanlahir($data);
			//jika gagal
			if(hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->lahirAction();
				$this->render('lahir');
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil ditambah </div>";		
				$this->lahirAction();
				$this->render('lahir');
		}else{
			$this->lahirAction();
			$this->render('lahir');
		}
			
	}
	public function lahirhapusAction(){
		$id_permintaan_lahir= $this->_getParam("id_permintaan_lahir");
		$hasil = $this->surat_serv->gethapuslahir($id_permintaan_lahir);
		
		//jika gagal
		if(!hasil){
			$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
			$this->lahirAction();
			$this->render('lahir');
		}
		//jika sukses
		$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
			$this->lahirAction();
			$this->render('lahir');
	}
	public function lahireditAction(){
		$id_permintaan_lahir = $this->_getParam("id_permintaan_lahir");
		$this->view->hasil = $this->surat_serv->getlahir($id_permintaan_lahir);
	}
	
	public function simpanpermintaanlahireditAction(){
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
			 $tgl_lahir_anak = $_POST['tgl_lahir_anak'];
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
								"tgl_lahir_anak" => $tgl_lahir_anak,
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
	
	//--------------------------------------mati	
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
		$this->view->permintaan = $this->surat_serv->getPermintaanmati($this->id_kelurahan,$offset ,$dataPerPage);
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
	public function permintaanmatiAction(){
		$nik = $_POST['nik'];
		$this->view->surat = "Form Isian Surat Keterangan mati";
		$hasil = $this->surat_serv->getPenduduk($nik);
		$this->view->hasil = $hasil;
		$this->view->pejabat = $this->surat_serv->getPejabatpemerintahan($this->id_kelurahan);
	}
	public function simpanpermintaanmatiAction(){
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
			$tanggal_meninggal= $_POST['tanggal_meninggal'];
			 $jam_meninggal =$_POST['jam_meninggal'];
			 $lokasi_meninggal =$_POST['tanggal_meninggal'];
			 $penyebab_meninggal =$_POST['penyebab_meninggal'];
			 $usia_meninggal =$_POST['usia_meninggal'];
			 $keperluan =$_POST['keperluan'];
			
			$data = array("id_kelurahan" =>  	$id_kelurahan,
							"nik" => $nik,
							"id_pejabat" => $id_pejabat,
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
								"keperluan" => $keperluan
								);
										 
			$hasil = $this->surat_serv->getsimpanpermintaanmati($data);
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->matiAction();
				$this->render('mati');	
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil ditambah </div>";		
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
	
	public function simpanpermintaanmatieditAction(){
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
		$this->view->permintaan = $this->surat_serv->getPermintaanwaris($this->id_kelurahan);
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
	public function simpanpermintaanwarisAction(){
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
										 
			$hasil = $this->surat_serv->getsimpanpermintaanwaris($data);
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->warisAction();
				$this->render('waris');	
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil ditambah </div>";		
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
	
	public function simpanpermintaanwariseditAction(){
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
		$this->view->permintaan = $this->surat_serv->getPermintaanserbaguna($this->id_kelurahan);
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
	public function simpanpermintaanserbagunaAction(){
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
										 
			$hasil = $this->surat_serv->getsimpanpermintaanserbaguna($data);
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->serbagunaAction();
				$this->render('serbaguna');
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil ditambah </div>";		
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
	
	public function simpanpermintaanserbagunaeditAction(){
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
	
}
?>