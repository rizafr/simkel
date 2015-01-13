<?php
require_once 'Zend/Controller/Action.php';
require_once 'Zend/Session.php';
require_once "service/pengguna/Pengguna_Service.php";
require_once "service/pengguna/Surat_Service.php";
require_once 'Zend/Session/Namespace.php';
class Home_IndexController extends Zend_Controller_Action {
	
    public function init() {
       // Local to this controller only; affects all actions, as loaded in init:
	   //UNTUK SETTING GLOBAL BASE PATH
		$registry = Zend_Registry::getInstance();
		$this->auth = Zend_Auth::getInstance();	   
		$this->view->baseData = $registry->get('baseData');
		$this->view->basePath = $registry->get('basepath');
		$this->view->procPath = $registry->get('procpath');	 
		
		
		$user = new Zend_Session_Namespace('user');
		$this->id_kelurahan = $user->id_kelurahan;
		$this->id_jenis_pengguna = $user->id_jenis_pengguna;
		$this->id_pengguna = $user->id_pengguna;
		$this->nama_pengguna = $user->nama_pengguna;
		
		
		$this->pengguna = Pengguna_Service::getInstance();
		$this->kelurahan_serv = Pengguna_Service::getInstance();
		$this->data_serv = Pengguna_Service::getInstance();
		$this->surat_serv = Surat_Service::getInstance();
	
		$this->view->id_jenis_pengguna = $this->id_jenis_pengguna;
		
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
			$jumlahstatuskartuidentitaskerja = $this->surat_serv->getJumlahStatuskartuidentitaskerja1();
			
			//masuk ke array statusTantrib
			$this->view->statusTantrib = array(
					7 => $jumlahstatusik,
					8 => $jumlahstatusps,
					9 => $jumlahstatusbd,
					20 => $jumlahstatusDomisiliyayasan,
					50 => $jumlahstatuskartuidentitaskerja,
			);
			
			//3. SURAT EKBANG
			$this->view->ekonomipembangunan = $this->data_serv->getEkonomiPembangunan();
			
			//jumlah yang belum diproses
			$jumlahstatusbpr = $this->surat_serv->getJumlahStatusbpr1();
			$jumlahstatusdomisiliparpol = $this->surat_serv->getJumlahStatusDomisiliparpol1();
			$jumlahstatusdomisiliperusahaan = $this->surat_serv->getJumlahStatusDomisiliperusahaan1();
			$jumlahstatusKeterangantempatusaha = $this->surat_serv->getJumlahStatusKeterangantempatusaha1();
			$jumlahstatusdomisilipanitiapemb = $this->surat_serv->getJumlahStatusdomisilipanitiapemb1();
			$jumlahstatusimb = $this->surat_serv->getJumlahStatusimb1();
			$jumlahstatussiup = $this->surat_serv->getJumlahStatussiup1();
			
			
			//masuk ke array statusTantrib
			$this->view->statusEkbang = array(
					5 => $jumlahstatusbpr,
					21 => $jumlahstatusdomisiliparpol,
					22 => $jumlahstatusdomisiliperusahaan,
					23 => $jumlahstatusKeterangantempatusaha,
					42 => $jumlahstatusdomisilipanitiapemb,
					43 => $jumlahstatusimb,
					46 => $jumlahstatussiup,
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
	public function logoutAction(){
		$user = new Zend_Session_Namespace('user');
		$user->unsetAll();
		$this->render('index');
		  
	}
	public function homeAction(){
		
		$username = htmlspecialchars(strip_tags(htmlentities(addslashes(trim($_POST['username'])))));
		$password = htmlspecialchars(strip_tags(htmlentities(addslashes(trim($_POST['password'])))));
		$jenispengguna = $_POST['jenispengguna'];
		
			if($username && $password){
				$hasil = $this->data_serv->getDataPengguna($username, $password);
				$user = new Zend_Session_Namespace('user');
				$id_jenis_pengguna = $hasil->id_jenis_pengguna;
				$id_kelurahan = $hasil->id_kelurahan;
				$id_pengguna = $hasil->id_pengguna;
				$nama_pengguna = $hasil->nama_pengguna;
				
				$user->id_jenis_pengguna = $hasil->id_jenis_pengguna;
				$user->id_kelurahan = $hasil->id_kelurahan;
				$user->id_pengguna = $hasil->id_pengguna;
				$user->nama_pengguna = $hasil->nama_pengguna;
				
				$this->id_kelurahan = $user->id_kelurahan;
				$this->id_jenis_pengguna = $user->id_jenis_pengguna;
				$this->id_pengguna = $user->id_pengguna;
				$this->nama_pengguna = $user->nama_pengguna;
				if($hasil){					
					if($hasil->id_jenis_pengguna==1){
						
						$this->homeadminAction();
						$this->render('homeadmin');
					}else if($hasil->id_jenis_pengguna==2){
						$this->view;
						$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
					}else if($hasil->id_jenis_pengguna>2 && $hasil->id_jenis_pengguna<7){
						if($hasil->id_jenis_pengguna==3){
							$this->rumahsakitAction();
							$this->render('rumahsakit');
						}else if($hasil->id_jenis_pengguna==4){
							$this->ikAction();
							$this->render('ik');
						}else if($hasil->id_jenis_pengguna==5){
							$this->domisiliyayasanAction();
							$this->render('domisiliyayasan');
						}else if($hasil->id_jenis_pengguna==6){
							$this->lahirAction();
							$this->render('lahir');
						}
					}
				}else{
					$this->view->peringatan ="username dan password yang anda masukan tidak sesuai";
					$this->indexAction();
					$this->render('index');
				}
			}else{
				$this->view->peringatan ="anda belum mengisi username dan password";
				$this->indexAction();
				$this->render('index');
			}		
	}

	////////////////////////////////////////////////////////admin //pengguna
	public function homeadminAction(){
		// $this->view;
		$this->view->Pengguna = $this->pengguna->getPengguna();	
	}
	
	public function penggunahapusAction(){
		$id_pengguna= $this->_getParam("id_pengguna");
		$hasil = $this->pengguna->gethapuspengguna($id_pengguna);
		
		//jika gagal
		if(!hasil){
			$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
			$this->homeadminAction();
			$this->render('homeadmin');			
		}
		//jika sukses
		$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
		$this->homeadminAction();
		$this->render('homeadmin');	
	}
	public function tambahpenggunaAction(){
		$this->view->kelurahan = $this->kelurahan_serv->getKelurahan();
		$this->view->jenis_pengguna = $this->pengguna->getJenisPengguna();
		$this->view->pegawai = $this->pengguna->getPegawai();
	}
    public function simpanpenggunaAction(){
	if(isset($_POST['daftar'])){		
		$id_pengguna = $this->_getParam('id_pengguna');
		$id_data_pegawai = $this->_getParam('id_data_pegawai');
		$id_jenis_pengguna = $_POST['id_jenis_pengguna'];
		$id_kelurahan = $_POST['id_kelurahan'];
		$nama_pengguna = $_POST['nama_pengguna'];
		$nip_pengguna = $_POST['nip_pengguna'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		$data = array("id_pengguna" => $id_pengguna,
							"id_jenis_pengguna" => $id_jenis_pengguna,
							"id_kelurahan" => $id_kelurahan,
							"id_data_pegawai" => $id_data_pegawai,
							"username" => $username,
							"password" => $password);
									 
		$hasil = $this->pengguna->getsimpanpengguna($data);
			
		//jika gagal
		if(!hasil){
			$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
			$this->homeadminAction();
			$this->render('homeadmin');			
		}
		//jika sukses
		$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil ditambahkan </div>";		
		$this->homeadminAction();
		$this->render('homeadmin');
		}else{
			$this->homeadminAction();
			$this->render('homeadmin');
		}
			
	}
	public function penggunaeditAction(){
		$this->view;
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
		
		$data = array("id_pengguna" => $id_pengguna,
							"id_jenis_pengguna" => $id_jenis_pengguna,
							"id_kelurahan" => $id_kelurahan,
							"nama_pengguna" => $nama_pengguna,
							"nip_pengguna" => $nip_pengguna,
							"username" => $username,
							"password" => $password);
		
		$data2 = array("id_data_pegawai" => $id_data_pegawai,							
							"nama_pengguna" => $nama_pengguna,
							"nip_pengguna" => $nip_pengguna);
									 
		$hasil = $this->pengguna->getsimpanpenggunaedit($data);
		$hasil2 = $this->pengguna->getsimpanpegawaiedit($data2);
		
		//jika gagal
		if(!hasil){
			$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
			$this->homeadminAction();
			$this->render('homeadmin');			
		}
		//jika sukses
		$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
		$this->homeadminAction();
		$this->render('homeadmin');
	}
	
	//////////////////////////////////////////pejabat
	public function datapejabatAction(){
		$this->view;
		$this->view->pejabat = $this->data_serv->getDataPejabat();
	}
	public function pejabathapusAction(){
		$id_pejabat= $this->_getParam("id_pejabat");
		$hasil = $this->data_serv->gethapuspejabat($id_pejabat);
		
		//jika gagal
		if(!hasil){
			$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
			$this->datapejabatAction();
			$this->render('datapejabat');			
		}
		//jika sukses
		$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
			$this->datapejabatAction();
			$this->render('datapejabat');		
	}
	public function tambahpejabatAction(){
		$this->view;
		$this->view->kelurahan = $this->data_serv->getkelurahan();
		$this->view->jabatan = $this->data_serv->getJabatan();
	}
	public function simpanpejabatAction(){
		if(isset($_POST['name'])){
			 $nip_pejabat = $_POST['nip_pejabat'];
			 $nama_pejabat = $_POST['nama_pejabat'];
			 $id_kelurahan = $_POST['id_kelurahan'];
			 $id_jenis_pengguna = $_POST['id_jenis_pengguna'];
			
			
			$data = array("nip_pejabat" => $nip_pejabat,
						"nama_pejabat" => $nama_pejabat,
						"id_kelurahan" => $id_kelurahan,
						"id_jenis_pengguna" => $id_jenis_pengguna);
										 
			$hasil = $this->pengguna->getsimpanpejabat($data);
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->datapejabatAction();
				$this->render('datapejabat');			
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil ditambahkan </div>";		
				$this->datapejabatAction();
				$this->render('datapejabat');	
		}else{
			$this->datapejabatAction();
			$this->render('datapejabat');
		}		
	}
	public function pejabateditAction(){
		
		$id_pejabat= $this->_getParam("id_pejabat");
		$this->view;
		$this->view->kelurahan = $this->data_serv->getkelurahan();
		$this->view->jabatan = $this->data_serv->getJabatan();
		$hasil= $this->data_serv->getPejabatId($id_pejabat);
		$this->view->hasil  = $hasil;
	}
	public function simpanpejabateditAction(){
		$id_pejabat= $this->_getParam("id_pejabat");
		 $nip_pejabat = $_POST['nip_pejabat'];
		 $nama_pejabat = $_POST['nama_pejabat'];
		 $id_kelurahan = $_POST['id_kelurahan'];
		 $id_jenis_pengguna = $_POST['id_jenis_pengguna'];
		
		
		$data = array("id_pejabat" => $id_pejabat,
					"nip_pejabat" => $nip_pejabat,
					"nama_pejabat" => $nama_pejabat,
					"id_kelurahan" => $id_kelurahan,
					"id_jenis_pengguna" => $id_jenis_pengguna);
									 
		$hasil = $this->pengguna->getsimpanpejabatedit($data);
		//jika gagal
		if(!hasil){
			$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
			$this->datapejabatAction();
			$this->render('datapejabat');			
		}
		//jika sukses maka muncul notif
		$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
			$this->datapejabatAction();
			$this->render('datapejabat');	
		
	}
	
	////////////////////////////////////////////////////////////////////////////kelurahan
	public function kelurahanAction(){
		$this->view;
		$this->view->kelurahan = $this->kelurahan_serv->getKelurahan();
	}
	public function tambahkelurahanAction(){
		$this->view;
		//$this->view->kelurahan = $this->kelurahan_serv->getKelurahan();
	}
	public function kelurahanhapusAction(){
		$id_kelurahan= $this->_getParam("id_kelurahan");
		$hasil = $this->pengguna->gethapuskelurahan($id_kelurahan);
		
		$this->kelurahanAction();
		$this->render('kelurahan');	
	}
	
	public function simpankelurahanAction(){
		if(isset($_POST['name'])){
			$kode_kelurahan = $_POST['kode_kelurahana'];
			$nama_kelurahan = $_POST['nama_kelurahan'];
			$nama_lurah= $_POST['nama_lurah'];
			$kecamatan= $_POST['kecamatan'];
			$alamat = $_POST['alamat'];
			$no_telepon = $_POST['no_telepon'];
			$kode_pos = $_POST['kode_pos'];
			
			
			$data = array("nama_kelurahan" => $nama_kelurahan,
							"nama_lurah" => $nama_lurah,
							"kecamatan" => $kecamatan,
							"alamat" => $alamat,
							"no_telepon" => $no_telepon,
							"kode_pos" => $kode_pos,
			);
										 
			$hasil = $this->pengguna->getsimpankelurahan($data);
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->kelurahanAction();
				$this->render('kelurahan');				
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil ditambahkan </div>";		
			$this->kelurahanAction();
			$this->render('kelurahan');	
		}else{
			$this->kelurahanAction();
			$this->render('kelurahan');			
		}
	}
	public function kelurahaneditAction(){
		$id_kelurahan = $this->_getParam('id_kelurahan');
		$this->view->kelurahan = $this->data_serv->getPilihKelurahan($id_kelurahan);
	}
	public function simpankelurahaneditAction(){
		$id_kelurahan = $this->_getParam('id_kelurahan');
		$nama_kelurahan = $_POST['nama_kelurahan'];
		$nama_lurah= $_POST['nama_lurah'];
		$kecamatan= $_POST['kecamatan'];
		$alamat = $_POST['alamat'];
		$no_telepon = $_POST['no_telepon'];
		$kode_pos = $_POST['kode_pos'];
		
		
		$data = array("nama_kelurahan" => $nama_kelurahan,
						"id_kelurahan" => $id_kelurahan,
						"nama_lurah" => $nama_lurah,
						"kecamatan" => $kecamatan,
						"alamat" => $alamat,
						"no_telepon" => $no_telepon,
						"kode_pos" => $kode_pos,
		);						 
		$hasil = $this->pengguna->getsimpankelurahanedit($data);
		$this->kelurahanAction();
		$this->render('kelurahan');	
	}
	
	/////////////////////////////////////////jenis pengguna	
	public function jenispenggunaAction(){
		$this->view;
		$this->view->jenis_pengguna = $this->pengguna->getJenisPengguna();
	} 
	
	public function jenispenggunahapusAction(){
		$id_jenis_pengguna= $this->_getParam("id_jenis_pengguna");
		$hasil = $this->pengguna->gethapusjenispengguna($id_jenis_pengguna);
		
		$this->jenispenggunaAction();
		$this->render('jenispengguna');	
	}
	public function tambahjenispenggunaAction(){
		//$this view;
	}
	public function jenispenggunaeditAction(){
		$this->view;
		$id_jenis_pengguna = $this->_getParam('id_jenis_pengguna');
		$hasil = $this->data_serv->getPilihJenisPengguna($id_jenis_pengguna);
		$this->view->jenispengguna = $hasil;
	}
	
	
	public function simpanjenispenggunaAction(){
		$nama_jenis_pengguna = $_POST['nama_jenis_pengguna'];
		
		
		$data = array("nama_jenis_pengguna" => $nama_jenis_pengguna);
									 
		$hasil = $this->pengguna->getsimpanjenispengguna($data);
		$this->jenispenggunaAction();
		$this->render('jenispengguna');	
	}
	public function simpanjenispenggunaeditAction(){
		$this->view;
		$id_jenis_pengguna = $this->_getParam('id_jenis_pengguna');
		$nama_jenis_pengguna = $_POST['nama_jenis_pengguna'];
		
		
		$data = array("id_jenis_pengguna" => $id_jenis_pengguna,
					"nama_jenis_pengguna" => $nama_jenis_pengguna);
									 
		$hasil = $this->pengguna->getsimpanjenispenggunaedit($data);
		
		$this->jenispenggunaAction();
		$this->render('jenispengguna');
		
	}
	/////////////////////////////////////menu pengguna umum
	public function penggunaumumAction(){
		$id_surat = $this->_getParam("id_surat");
		$this->view->surat = $this->data_serv->getSurat($id_surat);
		
	}
	///////////////////////////////////menu Ketua
	public function homeketuaAction(){
		$id_kelurahan = $this->id_kelurahan;
		$id_jenis_pengguna = $this->id_jenis_pengguna;
		$this->view->surat = "Surat Keterangan Tidak Mampu untuk Rumah Sakit";
		
		$this->view->jenispengguna=$this->data_serv->getPilihJenisPengguna($id_jenis_pengguna);
		$this->view->kelurahan=$this->data_serv->getPilihKelurahan($id_kelurahan);
		
		$this->view->permintaan = $this->surat_serv->getProsesRumahSakit($this->id_kelurahan,0,30);
	}
	
	//--------------------------------Rumah Sakit
	public function rumahsakitAction(){
		$id_kelurahan = $this->id_kelurahan;
		$id_jenis_pengguna = $this->id_jenis_pengguna;		
		
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
		
		$this->view->surat = "Surat Keterangan Tidak Mampu untuk Rumah Sakit";
		$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
		$this->view->jenispengguna=$this->data_serv->getPilihJenisPengguna($id_jenis_pengguna);
		$this->view->kelurahan=$this->data_serv->getPilihKelurahan($id_kelurahan);
		
		$this->view->permintaan = $this->surat_serv->getProsesRumahSakit($this->id_kelurahan,$offset, $dataPerPage);
	}
	
	//-------------------------------Sekolah
	public function sekolahAction(){
		$id_kelurahan = $this->id_kelurahan;
		$id_jenis_pengguna = $this->id_jenis_pengguna;
		
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
		
		$this->view->surat = "Surat Keterangan Tidak Mampu untuk Sekolah";
		$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
		$this->view->jenispengguna=$this->data_serv->getPilihJenisPengguna($id_jenis_pengguna);
		$this->view->kelurahan=$this->data_serv->getPilihKelurahan($id_kelurahan);
		
		$this->view->permintaan = $this->surat_serv->getProsesSekolah($this->id_kelurahan,$offset,$dataPerPage);
	}
	
	//------------------------------------Andonnikah
	public function andonnikahAction(){
		$id_kelurahan = $this->id_kelurahan;
		$id_jenis_pengguna = $this->id_jenis_pengguna;
		
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
		$this->view->jumData = $this->surat_serv->getJumlahAndonNikah($this->id_kelurahan);
		$this->view->dataPerPage = $dataPerPage;
		$this->view->noPage = $noPage;
		$this->view->offset=$offset;
		
		$this->view->surat = "Surat Andon Nikah";
		$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
		$this->view->jenispengguna=$this->data_serv->getPilihJenisPengguna($id_jenis_pengguna);
		$this->view->kelurahan=$this->data_serv->getPilihKelurahan($id_kelurahan);
		
		$this->view->permintaan = $this->surat_serv->getProsesAndonNikah($this->id_kelurahan,$offset,$dataPerPage);
		
	}
	
	//-------------------------------Belum Menikah
	public function belummenikahAction(){
		$id_kelurahan = $this->id_kelurahan;
		$id_jenis_pengguna = $this->id_jenis_pengguna;
		
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
		$this->view->jumData = $this->surat_serv->getJumlahbm($this->id_kelurahan);
		$this->view->dataPerPage = $dataPerPage;
		$this->view->noPage = $noPage;
		$this->view->offset=$offset;
		
		$this->view->surat = "Surat Keterangan Belum Menikah";
		$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
		$this->view->jenispengguna=$this->data_serv->getPilihJenisPengguna($id_jenis_pengguna);
		$this->view->kelurahan=$this->data_serv->getPilihKelurahan($id_kelurahan);
		
		$this->view->permintaan = $this->surat_serv->getProsesBelumMenikah($this->id_kelurahan,$offset,$dataPerPage);
	}
	
	//-----------------------BPR
	public function bprAction(){
		$id_kelurahan = $this->id_kelurahan;
		$id_jenis_pengguna = $this->id_jenis_pengguna;
		
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
		$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
		$this->view->jenispengguna=$this->data_serv->getPilihJenisPengguna($id_jenis_pengguna);
		$this->view->kelurahan=$this->data_serv->getPilihKelurahan($id_kelurahan);
		
		$this->view->permintaan = $this->surat_serv->getProsesbpr($this->id_kelurahan,$offset,$dataPerPage);
	}
	public function ibadahhajiAction(){
		$id_kelurahan = $this->id_kelurahan;
		$id_jenis_pengguna = $this->id_jenis_pengguna;
		
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
		$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
		$this->view->jenispengguna=$this->data_serv->getPilihJenisPengguna($id_jenis_pengguna);
		$this->view->kelurahan=$this->data_serv->getPilihKelurahan($id_kelurahan);
		
		$this->view->permintaan = $this->surat_serv->getProsesibadahhaji($this->id_kelurahan,$offset,$dataPerPage);
	}
	
	//---------------------------Janda
	public function jandaAction(){
		$id_kelurahan = $this->id_kelurahan;
		$id_jenis_pengguna = $this->id_jenis_pengguna;
		
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
		$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
		$this->view->jenispengguna=$this->data_serv->getPilihJenisPengguna($id_jenis_pengguna);
		$this->view->kelurahan=$this->data_serv->getPilihKelurahan($id_kelurahan);
		
		$this->view->permintaan = $this->surat_serv->getProsesjanda($this->id_kelurahan,$offset,$dataPerPage);
	}
	
	//------------------------------Ijin Keramaian IK
	public function ikAction(){
		$id_kelurahan = $this->id_kelurahan;
		$id_jenis_pengguna = $this->id_jenis_pengguna;
		
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
		
		$this->view->surat = "Surat Keterangan Ijin Keramain";
		$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
		$this->view->jenispengguna=$this->data_serv->getPilihJenisPengguna($id_jenis_pengguna);
		$this->view->kelurahan=$this->data_serv->getPilihKelurahan($id_kelurahan);
		
		$this->view->permintaan = $this->surat_serv->getProsesik($this->id_kelurahan,$offset,$dataPerPage);
	}
	
	//-----------------PS
	public function psAction(){
		$id_kelurahan = $this->id_kelurahan;
		$id_jenis_pengguna = $this->id_jenis_pengguna;
		
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
		$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
		$this->view->jenispengguna=$this->data_serv->getPilihJenisPengguna($id_jenis_pengguna);
		$this->view->kelurahan=$this->data_serv->getPilihKelurahan($id_kelurahan);
		
		$this->view->permintaan = $this->surat_serv->getProsesps($this->id_kelurahan,$offset,$dataPerPage);
	}
	
	//---------------------Bersih Diri 
	public function bdAction(){
		$id_kelurahan = $this->id_kelurahan;
		$id_jenis_pengguna = $this->id_jenis_pengguna;
		
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
		$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
		$this->view->jenispengguna=$this->data_serv->getPilihJenisPengguna($id_jenis_pengguna);
		$this->view->kelurahan=$this->data_serv->getPilihKelurahan($id_kelurahan);
		
		$this->view->permintaan = $this->surat_serv->getProsesbd($this->id_kelurahan,$offset,$dataPerPage);
	}
	
	//////////////////////
	public function homeketuaaccAction(){
		$id_kelurahan = $this->id_kelurahan;
		$id_jenis_pengguna = $this->id_jenis_pengguna;
		$id_kelurahan;
		//echo "jahsdjhasd";
		//$this->view;
		$this->view->jenispengguna=$this->data_serv->getPilihJenisPengguna($id_jenis_pengguna);
		$this->view->kelurahan=$this->data_serv->getPilihKelurahan($id_kelurahan);
		
	}
	public function menubarketuaAction(){
		
	}
	public function sekolahacceditAction(){
			$id_permintaan = $this->_getParam('id_permintaan');
			$nama_pengguna = $this->nama_pengguna;
			
			$tgl_disetujui = date("Y-m-d H:i:s");
			$disetujui_oleh= $nama_pengguna;
			
			$hasil = $this->data_serv->getaccsekolah($id_permintaan,$tgl_disetujui,$disetujui_oleh);
			$this->sekolahAction();
			$this->render('sekolah');
	}
	public function rumahsakitacceditAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->nama_pengguna;
			
			$tgl_disetujui = date("Y-m-d H:i:s");
			$disetujui_oleh= $nama_pengguna;
			
			$id_permintaan = $this->_getParam('id_permintaan');
			$hasil = $this->data_serv->getaccrumahsakit($id_permintaan,$tgl_disetujui,$disetujui_oleh);
			$this->rumahsakitAction();
			$this->render('rumahsakit');
	}
	public function psacceditAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->nama_pengguna;
			
			$tgl_disetujui = date("Y-m-d H:i:s");
			$disetujui_oleh= $nama_pengguna;
			
			$id_permintaan = $this->_getParam('id_permintaan');
			$hasil = $this->data_serv->getaccps($id_permintaan,$tgl_disetujui,$disetujui_oleh);
			$this->psAction();
			$this->render('ps');
	}
	public function jandaacceditAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->nama_pengguna;
			
			$tgl_disetujui = date("Y-m-d H:i:s");
			$disetujui_oleh= $nama_pengguna;
		
			$id_permintaan = $this->_getParam('id_permintaan');
			$hasil = $this->data_serv->getaccjanda($id_permintaan,$tgl_disetujui,$disetujui_oleh);
			$this->jandaAction();
			$this->render('janda');
	}
	public function ikacceditAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->nama_pengguna;
			
			$tgl_disetujui = date("Y-m-d H:i:s");
			$disetujui_oleh= $nama_pengguna;
			
			$id_permintaan = $this->_getParam('id_permintaan');
			$hasil = $this->data_serv->getaccik($id_permintaan,$tgl_disetujui,$disetujui_oleh);
			$this->ikAction();
			$this->render('ik');
	}
	public function ibadahhajiacceditAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->nama_pengguna;
			
			$tgl_disetujui = date("Y-m-d H:i:s");
			$disetujui_oleh= $nama_pengguna;
			
			$id_permintaan = $this->_getParam('id_permintaan');
			$hasil = $this->data_serv->getaccibadahhaji($id_permintaan,$tgl_disetujui,$disetujui_oleh);
			$this->ibadahhajiAction();
			$this->render('ibadahhaji');
	}
	public function bpracceditAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->nama_pengguna;
			
			$tgl_disetujui = date("Y-m-d H:i:s");
			$disetujui_oleh= $nama_pengguna;
			
			$id_permintaan = $this->_getParam('id_permintaan');
			$hasil = $this->data_serv->getaccbpr($id_permintaan,$tgl_disetujui,$disetujui_oleh);
			$this->bprAction();
			$this->render('bpr');
	}
	public function belummenikahacceditAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->nama_pengguna;
			
			$tgl_disetujui = date("Y-m-d H:i:s");
			$disetujui_oleh= $nama_pengguna;
			
			$id_permintaan = $this->_getParam('id_permintaan');
			$hasil = $this->data_serv->getaccbelummenikah($id_permintaan,$tgl_disetujui,$disetujui_oleh);
			$this->belummenikahAction();
			$this->render('belummenikah');
	}
	public function bdacceditAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->nama_pengguna;
			
			$tgl_disetujui = date("Y-m-d H:i:s");
			$disetujui_oleh= $nama_pengguna;
			
			
			$id_permintaan = $this->_getParam('id_permintaan');
			$hasil = $this->data_serv->getaccbd($id_permintaan,$tgl_disetujui,$disetujui_oleh);
			$this->bdAction();
			$this->render('bd');
	}
	public function andonnikahacceditAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->nama_pengguna;
			
			$tgl_disetujui = date("Y-m-d H:i:s");
			$disetujui_oleh= $nama_pengguna;
			
			$id_permintaan = $this->_getParam('id_permintaan');
			$hasil = $this->data_serv->getaccandonnikah($id_permintaan,$tgl_disetujui,$disetujui_oleh);
			$this->andonnikahAction();
			$this->render('andonnikah');
	}
		
	///////////////////////////////////////////////////surat
	public function datasuratAction(){
		$this->view;
		$this->view->surat = $this->data_serv->getDataSurat();
	}
	public function tambahsuratAction(){
		$this->view;
		$this->view->jenissurat = $this->data_serv->getJenisSurat();
	}
	 public function simpansuratAction(){
		$nama_surat = $_POST['nama_surat'];
		$id_jenis_surat = $_POST['id_jenis_surat'];
		
		$data = array("nama_surat" => $nama_surat,
					"id_jenis_surat" => $id_jenis_surat);
									 
		$hasil = $this->data_serv->getsimpansurat($data);
		$this->datasuratAction();
		$this->render('datasurat');	
	}
	public function surathapusAction(){
		$id_surat= $this->_getParam("id_surat");
		$hasil = $this->data_serv->gethapussurat($id_surat);
		
		$this->datasuratAction();
		$this->render('datasurat');
	}
	public function surateditAction(){
		$id_surat = $this->_getParam("id_surat");
		$this->view->jenissurat = $this->data_serv->getJenisSurat();
		$this->view->surat = $this->data_serv->getPilihSurat($id_surat);
	}
	public function simpansurateditAction(){
		$id_surat = $this->_getParam('id_surat');
		$nama_surat = $_POST['nama_surat'];
		$id_jenis_surat = $_POST['id_jenis_surat'];
		
		$data = array("id_surat" => $id_surat,
						"nama_surat" => $nama_surat,
					"id_jenis_surat" => $id_jenis_surat);
									 
		$hasil = $this->data_serv->getsimpansuratedit($data);
		$this->datasuratAction();
		$this->render('datasurat');	
	}
	//ekbang
	public function domisiliyayasanAction(){
		$id_kelurahan = $this->id_kelurahan;
		$id_jenis_pengguna = $this->id_jenis_pengguna;
		
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
		
		$this->view->surat = "Surat Keterangan Domisili Yayasan";
		$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
		$this->view->jenispengguna=$this->data_serv->getPilihJenisPengguna($id_jenis_pengguna);
		$this->view->kelurahan=$this->data_serv->getPilihKelurahan($id_kelurahan);
		
		$this->view->permintaan = $this->surat_serv->getProsesdomisiliyayasan($this->id_kelurahan,$offset,$dataPerPage);
	}
	
	//-----------------------------------Domisili Perusahaan
	public function domisiliperusahaanAction(){
		$id_kelurahan = $this->id_kelurahan;
		$id_jenis_pengguna = $this->id_jenis_pengguna;
		
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
		
		$this->view->surat = "Surat Keterangan Domisili Perusahaan";
		$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
		$this->view->jenispengguna=$this->data_serv->getPilihJenisPengguna($id_jenis_pengguna);
		$this->view->kelurahan=$this->data_serv->getPilihKelurahan($id_kelurahan);
		
		$this->view->permintaan = $this->surat_serv->getProsesdomisiliperusahaan($this->id_kelurahan,$offset , $dataPerPage);
	}	
	
	//---------------------------------------Domisili Parpol
	public function domisiliparpolAction(){
		$id_kelurahan = $this->id_kelurahan;
		$id_jenis_pengguna = $this->id_jenis_pengguna;
		
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
		
		$this->view->surat = "Surat Keterangan Domisili Parpol";
		$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
		$this->view->jenispengguna=$this->data_serv->getPilihJenisPengguna($id_jenis_pengguna);
		$this->view->kelurahan=$this->data_serv->getPilihKelurahan($id_kelurahan);
		
		$this->view->permintaan = $this->surat_serv->getProsesdomisiliparpol($this->id_kelurahan,$offset , $dataPerPage);
	}
	public function keterangantempatusahaAction(){
		$id_kelurahan = $this->id_kelurahan;
		$id_jenis_pengguna = $this->id_jenis_pengguna;
		
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
		$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
		$this->view->jenispengguna=$this->data_serv->getPilihJenisPengguna($id_jenis_pengguna);
		$this->view->kelurahan=$this->data_serv->getPilihKelurahan($id_kelurahan);
		
		$this->view->permintaan = $this->surat_serv->getProsesketerangantempatusaha($this->id_kelurahan,$offset ,$dataPerPage);
	}
	public function domisiliyayasanacceditAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->nama_pengguna;
			
			$id_permintaan = $this->_getParam('id_permintaan');
			
			$tgl_disetujui = date("Y-m-d H:i:s");
			$disetujui_oleh= $nama_pengguna;
			$this->view->surat = "Surat Keterangan Domisili Yayasan";
			$hasil = $this->data_serv->getaccdomisiliyayasan($id_permintaan,$tgl_disetujui,$disetujui_oleh);
			$this->domisiliyayasanAction();
			$this->render('domisiliyayasan');
	}
	public function domisiliparpolacceditAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->nama_pengguna;
			
			$id_permintaan = $this->_getParam('id_permintaan');
			
			$tgl_disetujui = date("Y-m-d H:i:s");
			$disetujui_oleh= $nama_pengguna;
			
			$this->view->surat = "Surat Keterangan Domisili Parpol";
			$hasil = $this->data_serv->getaccdomisiliparpol($id_permintaan,$tgl_disetujui,$disetujui_oleh);
			$this->domisiliparpolAction();
			$this->render('domisiliparpol');
	}
	public function domisiliperusahaanacceditAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->nama_pengguna;
			
			$id_permintaan = $this->_getParam('id_permintaan');
			
			$tgl_disetujui = date("Y-m-d H:i:s");
			$disetujui_oleh= $nama_pengguna;
			
			$hasil = $this->data_serv->getaccdomisiliperusahaan($id_permintaan,$tgl_disetujui,$disetujui_oleh);
			$this->domisiliperusahaanAction();
			$this->render('domisiliperusahaan');
	}
	public function keterangantempatusahaacceditAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->nama_pengguna;
			
			$id_permintaan = $this->_getParam('id_permintaan');
			
			$tgl_disetujui = date("Y-m-d H:i:s");
			$disetujui_oleh= $nama_pengguna;
			
			$hasil = $this->data_serv->getaccketerangantempatusaha($id_permintaan,$tgl_disetujui,$disetujui_oleh);
			$this->keterangantempatusahaAction();
			$this->render('keterangantempatusaha');
	}
	
	//--------------------------------lahir
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
		$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
		$this->view->jenispengguna=$this->data_serv->getPilihJenisPengguna($id_jenis_pengguna);
		$this->view->kelurahan=$this->data_serv->getPilihKelurahan($id_kelurahan);
		
		$this->view->permintaan = $this->surat_serv->getProseslahir($this->id_kelurahan,$offset ,$dataPerPage);
	}
	
	public function lahiracceditAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->nama_pengguna;
			
			$id_permintaan = $this->_getParam('id_permintaan');
			
			$tgl_disetujui = date("Y-m-d H:i:s");
			$disetujui_oleh= $nama_pengguna;
			
			$hasil = $this->data_serv->getacclahir($id_permintaan,$tgl_disetujui,$disetujui_oleh);
			$this->lahirAction();
			$this->render('lahir');
	}
	
	//--------------------------------mati
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
		
		$this->view->surat = "Surat Keterangan Mati";
		$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
		$this->view->jenispengguna=$this->data_serv->getPilihJenisPengguna($id_jenis_pengguna);
		$this->view->kelurahan=$this->data_serv->getPilihKelurahan($id_kelurahan);
		
		$this->view->permintaan = $this->surat_serv->getProsesmati($this->id_kelurahan,$offset ,$dataPerPage);
	}
	
	public function matiacceditAction(){
			$id_pengguna = $this->id_pengguna;
			$nama_pengguna = $this->nama_pengguna;
			
			$id_permintaan = $this->_getParam('id_permintaan');
			
			$tgl_disetujui = date("Y-m-d H:i:s");
			$disetujui_oleh= $nama_pengguna;
			
			$hasil = $this->data_serv->getaccmati($id_permintaan,$tgl_disetujui,$disetujui_oleh);
			$this->matiAction();
			$this->render('mati');
	}
	public function warisacceditAction(){
			$id_permintaan = $this->_getParam('id_permintaan');
			$hasil = $this->data_serv->getaccwaris($id_permintaan);
			$this->warisAction();
			$this->render('waris');
	}
	public function serbagunaacceditAction(){
			$id_permintaan = $this->_getParam('id_permintaan');
			$hasil = $this->data_serv->getaccserbaguna($id_permintaan);
			$this->serbagunaAction();
			$this->render('serbaguna');
	}
	
	//-----------------------------------------LAPORAN Per Jenis Layanan
	//NA
	public function nacetakAction(){
			$id_surat = $this->_getParam("id_surat");
			$this->render('nacetak');
	}
	
	public function nahariAction(){
			$tanggal = $this->_getParam("tanggal");
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->tanggal = $tanggal;
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getnahari($tanggal, $bln, $thn);
			$this->render('nahari');
	}
	
	public function nabulanAction(){
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getnabulan($bln, $thn);
			$this->render('nabulan');
	}
	
	public function natahunAction(){
			$thn = $this->_getParam("thn");	
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getnatahun($thn);
			$this->render('natahun');
	}
	
	//Rumah sakit
	public function rumahsakitcetakAction(){
			$id_surat = $this->_getParam("id_surat");
			$this->render('rumahsakitcetak');
	}
	
	public function rumahsakithariAction(){
			$tanggal = $this->_getParam("tanggal");
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->tanggal = $tanggal;
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getrumahsakithari($tanggal, $bln, $thn);
			$this->render('rumahsakithari');
	}
	
	public function rumahsakitbulanAction(){
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getrumahsakitbulan($bln, $thn);
			$this->render('rumahsakitbulan');
	}
	
	public function rumahsakittahunAction(){
			$thn = $this->_getParam("thn");	
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getrumahsakittahun($thn);
			$this->render('rumahsakittahun');
	}	
	
	//Sekolah
	public function sekolahcetakAction(){
			$id_surat = $this->_getParam("id_surat");
			$this->render('sekolahcetak');
	}
	
	public function sekolahhariAction(){
			$tanggal = $this->_getParam("tanggal");
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->tanggal = $tanggal;
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getsekolahhari($tanggal, $bln, $thn);
			$this->render('sekolahhari');
	}
	
	public function sekolahbulanAction(){
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getsekolahbulan($bln, $thn);
			$this->render('sekolahbulan');
	}
	
	public function sekolahtahunAction(){
			$thn = $this->_getParam("thn");	
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getsekolahtahun($thn);
			$this->render('sekolahtahun');
	}
	
	//Andonnikah
	public function andonnikahcetakAction(){
			$id_surat = $this->_getParam("id_surat");
			$this->render('andonnikahcetak');
	}
		
	public function andonnikahhariAction(){
			$tanggal = $this->_getParam("tanggal");
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->tanggal = $tanggal;
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getandonnikahhari($tanggal, $bln, $thn);
			$this->render('andonnikahhari');
	}
	
	public function andonnikahbulanAction(){
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getandonnikahbulan($bln, $thn);
			$this->render('andonnikahbulan');
	}
	
	public function andonnikahtahunAction(){
			$thn = $this->_getParam("thn");	
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getandonnikahtahun($thn);
			$this->render('andonnikahtahun');
	}
	
	
	//Keterangan Belum Menikah
	public function belummenikahcetakAction(){
			$id_surat = $this->_getParam("id_surat");
			$this->render('belummenikahcetak');
	}
	
	public function belummenikahhariAction(){
			$tanggal = $this->_getParam("tanggal");
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->tanggal = $tanggal;
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getbelummenikahhari($tanggal, $bln, $thn);
			$this->render('belummenikahhari');
	}
	
	public function belummenikahbulanAction(){
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getbelummenikahbulan($bln, $thn);
			$this->render('belummenikahbulan');
	}
	
	public function belummenikahtahunAction(){
			$thn = $this->_getParam("thn");	
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getbelummenikahtahun($thn);
			$this->render('belummenikahtahun');
	}
	
	//Keterangan BPR
	public function bprcetakAction(){
		$id_surat = $this->_getParam("id_surat");
		$this->render('bprcetak');
	}
	
	public function bprhariAction(){
			$tanggal = $this->_getParam("tanggal");
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->tanggal = $tanggal;
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getbprhari($tanggal, $bln, $thn);
			$this->render('bprhari');
	}
	
	public function bprbulanAction(){
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getbprbulan($bln, $thn);
			$this->render('bprbulan');
	}
	
	public function bprtahunAction(){
			$thn = $this->_getParam("thn");	
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getbprtahun($thn);
			$this->render('bprtahun');
	}
	
	//Keterangan Ibadah Haji
	public function ibadahhajicetakAction(){
		$id_surat = $this->_getParam("id_surat");
		$this->render('ibadahhajicetak');
	}
	
	public function ibadahhajihariAction(){
			$tanggal = $this->_getParam("tanggal");
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->tanggal = $tanggal;
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getibadahhajihari($tanggal, $bln, $thn);
			$this->render('ibadahhajihari');
	}
	
	public function ibadahhajibulanAction(){
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getibadahhajibulan($bln, $thn);
			$this->render('ibadahhajibulan');
	}
	
	public function ibadahhajitahunAction(){
			$thn = $this->_getParam("thn");	
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getibadahhajitahun($thn);
			$this->render('ibadahhajitahun');
	}
	
	//Keterangan Janda
	public function jandacetakAction(){
		$id_surat = $this->_getParam("id_surat");
		$this->render('jandacetak');
	}
	
	public function jandahariAction(){
			$tanggal = $this->_getParam("tanggal");
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->tanggal = $tanggal;
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getjandahari($tanggal, $bln, $thn);
			$this->render('jandahari');
	}
	
	public function jandabulanAction(){
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getjandabulan($bln, $thn);
			$this->render('jandabulan');
	}
	
	public function jandatahunAction(){
			$thn = $this->_getParam("thn");	
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getjandatahun($thn);
			$this->render('jandatahun');
	}
	
	//Keterangan IK
	public function ikcetakAction(){
		$id_surat = $this->_getParam("id_surat");
		$this->render('ikcetak');
	}
	
	public function ikhariAction(){
			$tanggal = $this->_getParam("tanggal");
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->tanggal = $tanggal;
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getikhari($tanggal, $bln, $thn);
			$this->render('ikhari');
	}
	
	public function ikbulanAction(){
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getikbulan($bln, $thn);
			$this->render('ikbulan');
	}
	
	public function iktahunAction(){
			$thn = $this->_getParam("thn");	
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getiktahun($thn);
			$this->render('iktahun');
	}
	
	//Keterangan PS
	public function pscetakAction(){
		$id_surat = $this->_getParam("id_surat");
		$this->render('pscetak');
	}
	
	public function pshariAction(){
			$tanggal = $this->_getParam("tanggal");
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->tanggal = $tanggal;
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getpshari($tanggal, $bln, $thn);
			$this->render('pshari');
	}
	
	public function psbulanAction(){
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getpsbulan($bln, $thn);
			$this->render('psbulan');
	}
	
	public function pstahunAction(){
			$thn = $this->_getParam("thn");	
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getpstahun($thn);
			$this->render('pstahun');
	}
	
	//Keterangan Bersih Diri
	public function bdcetakAction(){
		$id_surat = $this->_getParam("id_surat");
		$this->render('bdcetak');
	}
	
	public function bdhariAction(){
			$tanggal = $this->_getParam("tanggal");
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->tanggal = $tanggal;
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getbdhari($tanggal, $bln, $thn);
			$this->render('bdhari');
	}
	
	public function bdbulanAction(){
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getbdbulan($bln, $thn);
			$this->render('bdbulan');
	}
	
	public function bdtahunAction(){
			$thn = $this->_getParam("thn");	
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getbdtahun($thn);
			$this->render('bdtahun');
	}
	
	//Keterangan domisili parpol
	public function domisiliparpolcetakAction(){
		$id_surat = $this->_getParam("id_surat");
		$this->render('domisiliparpolcetak');
	}
	
	public function domisiliparpolhariAction(){
			$tanggal = $this->_getParam("tanggal");
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->tanggal = $tanggal;
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getdomisiliparpolhari($tanggal, $bln, $thn);
			$this->render('domisiliparpolhari');
	}
	
	public function domisiliparpolbulanAction(){
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getdomisiliparpolbulan($bln, $thn);
			$this->render('domisiliparpolbulan');
	}
	
	public function domisiliparpoltahunAction(){
			$thn = $this->_getParam("thn");	
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getdomisiliparpoltahun($thn);
			$this->render('domisiliparpoltahun');
	}
	
	//Keterangan domisili yayasan
	public function domisiliyayasancetakAction(){
		$id_surat = $this->_getParam("id_surat");
		$this->render('domisiliyayasancetak');
	}
	
	public function domisiliyayasanhariAction(){
			$tanggal = $this->_getParam("tanggal");
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->tanggal = $tanggal;
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getdomisiliyayasanhari($tanggal, $bln, $thn);
			$this->render('domisiliyayasanhari');
	}
	
	public function domisiliyayasanbulanAction(){
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getdomisiliyayasanbulan($bln, $thn);
			$this->render('domisiliyayasanbulan');
	}
	
	public function domisiliyayasantahunAction(){
			$thn = $this->_getParam("thn");	
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getdomisiliyayasantahun($thn);
			$this->render('domisiliyayasantahun');
	}
	
	//Keterangan domisili perusahaan
	public function domisiliperusahaancetakAction(){
		$id_surat = $this->_getParam("id_surat");
		$this->render('domisiliperusahaancetak');
	}
	
	public function domisiliperusahaanhariAction(){
			$tanggal = $this->_getParam("tanggal");
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->tanggal = $tanggal;
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getdomisiliperusahaanhari($tanggal, $bln, $thn);
			$this->render('domisiliperusahaanhari');
	}
	
	public function domisiliperusahaanbulanAction(){
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getdomisiliperusahaanbulan($bln, $thn);
			$this->render('domisiliperusahaanbulan');
	}
	
	public function domisiliperusahaantahunAction(){
			$thn = $this->_getParam("thn");	
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getdomisiliperusahaantahun($thn);
			$this->render('domisiliperusahaantahun');
	}
	
	//Keterangan tempat usaha
	public function keterangantempatusahacetakAction(){
		$id_surat = $this->_getParam("id_surat");
		$this->render('keterangantempatusahacetak');
	}
	
	public function keterangantempatusahahariAction(){
			$tanggal = $this->_getParam("tanggal");
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->tanggal = $tanggal;
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getketerangantempatusahahari($tanggal, $bln, $thn);
			$this->render('keterangantempatusahahari');
	}
	
	public function keterangantempatusahabulanAction(){
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getketerangantempatusahabulan($bln, $thn);
			$this->render('keterangantempatusahabulan');
	}
	
	public function keterangantempatusahatahunAction(){
			$thn = $this->_getParam("thn");	
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getketerangantempatusahatahun($thn);
			$this->render('keterangantempatusahatahun');
	}
	
	//Keterangan lahir
	public function lahircetakAction(){
		$id_surat = $this->_getParam("id_surat");
		$this->render('lahircetak');
	}
	
	public function lahirhariAction(){
			$tanggal = $this->_getParam("tanggal");
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->tanggal = $tanggal;
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getlahirhari($tanggal, $bln, $thn);
			$this->render('lahirhari');
	}
	
	public function lahirbulanAction(){
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getlahirbulan($bln, $thn);
			$this->render('lahirbulan');
	}
	
	public function lahirtahunAction(){
			$thn = $this->_getParam("thn");	
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getlahirtahun($thn);
			$this->render('lahirtahun');
	}
	
	//Keterangan mati
	public function maticetakAction(){
		$id_surat = $this->_getParam("id_surat");
		$this->render('maticetak');
	}
	
	public function matihariAction(){
			$tanggal = $this->_getParam("tanggal");
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->tanggal = $tanggal;
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getmatihari($tanggal, $bln, $thn);
			$this->render('matihari');
	}
	
	public function matibulanAction(){
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getmatibulan($bln, $thn);
			$this->render('matibulan');
	}
	
	public function matitahunAction(){
			$thn = $this->_getParam("thn");	
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getmatitahun($thn);
			$this->render('matitahun');
	}
	
	//Keterangan waris
	public function wariscetakAction(){
		$id_surat = $this->_getParam("id_surat");
		$this->render('wariscetak');
	}
	
	//Keterangan serbaguna
	public function serbagunaAction(){
		$id_surat = $this->_getParam("id_surat");
		$this->render('serbagunacetak');
	}
	
	public function serbagunahariAction(){
			$tanggal = $this->_getParam("tanggal");
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->tanggal = $tanggal;
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getserbagunahari($tanggal, $bln, $thn);
			$this->render('serbagunahari');
	}
	
	public function serbagunabulanAction(){
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getserbagunabulan($bln, $thn);
			$this->render('serbagunabulan');
	}
	
	public function serbagunatahunAction(){
			$thn = $this->_getParam("thn");	
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getserbagunatahun($thn);
			$this->render('serbagunatahun');
	}
	
	//Keterangan Domisili Panitia Pembangunan
	public function domisilipanitiapembcetakAction(){
		$id_surat = $this->_getParam("id_surat");
		$this->render('domisilipanitiapembcetak');
	}
	
	public function domisilipanitiapembhariAction(){
			$tanggal = $this->_getParam("tanggal");
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->tanggal = $tanggal;
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getdomisilipanitiapembhari($tanggal, $bln, $thn);
			$this->render('domisilipanitiapembhari');
	}
	
	public function domisilipanitiapembbulanAction(){
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getdomisilipanitiapembbulan($bln, $thn);
			$this->render('domisilipanitiapembbulan');
	}
	
	public function domisilipanitiapembtahunAction(){
			$thn = $this->_getParam("thn");	
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getdomisilipanitiapembtahun($thn);
			$this->render('domisilipanitiapembtahun');
	}
	
	//Keterangan Orang yang Sama
	public function orangyangsamacetakAction(){
		$id_surat = $this->_getParam("id_surat");
		$this->render('orangyangsamacetak');
	}
	
	public function orangyangsamahariAction(){
			$tanggal = $this->_getParam("tanggal");
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->tanggal = $tanggal;
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getorangyangsamahari($tanggal, $bln, $thn);
			$this->render('orangyangsamahari');
	}
	
	public function orangyangsamabulanAction(){
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getorangyangsamabulan($bln, $thn);
			$this->render('orangyangsamabulan');
	}
	
	public function orangyangsamatahunAction(){
			$thn = $this->_getParam("thn");	
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getorangyangsamatahun($thn);
			$this->render('orangyangsamatahun');
	}
	
	//Keterangan Ahli Waris
	public function ahliwariscetakAction(){
		$id_surat = $this->_getParam("id_surat");
		$this->render('ahliwariscetak');
	}
	
	public function ahliwarishariAction(){
			$tanggal = $this->_getParam("tanggal");
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->tanggal = $tanggal;
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getahliwarishari($tanggal, $bln, $thn);
			$this->render('ahliwarishari');
	}
	
	public function ahliwarisbulanAction(){
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getahliwarisbulan($bln, $thn);
			$this->render('ahliwarisbulan');
	}
	
	public function ahliwaristahunAction(){
			$thn = $this->_getParam("thn");	
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getahliwaristahun($thn);
			$this->render('ahliwaristahun');
	}
	
	//Keterangan Domisili Penduduk
	public function domisilipendudukcetakAction(){
		$id_surat = $this->_getParam("id_surat");
		$this->render('domisilipendudukcetak');
	}
	
	public function domisilipendudukhariAction(){
			$tanggal = $this->_getParam("tanggal");
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->tanggal = $tanggal;
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getdomisilipendudukhari($tanggal, $bln, $thn);
			$this->render('domisilipendudukhari');
	}
	
	public function domisilipendudukbulanAction(){
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getdomisilipendudukbulan($bln, $thn);
			$this->render('domisilipendudukbulan');
	}
	
	public function domisilipenduduktahunAction(){
			$thn = $this->_getParam("thn");	
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getdomisilipenduduktahun($thn);
			$this->render('domisilipenduduktahun');
	}
	
	//Keterangan Tanah & Bangunan AJB
	public function ktbajbcetakAction(){
		$id_surat = $this->_getParam("id_surat");
		$this->render('ktbajbcetak');
	}
	
	public function ktbajbhariAction(){
			$tanggal = $this->_getParam("tanggal");
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->tanggal = $tanggal;
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getktbajbhari($tanggal, $bln, $thn);
			$this->render('ktbajbhari');
	}
	
	public function ktbajbbulanAction(){
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getktbajbbulan($bln, $thn);
			$this->render('ktbajbbulan');
	}
	
	public function ktbajbtahunAction(){
			$thn = $this->_getParam("thn");	
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getktbajbtahun($thn);
			$this->render('ktbajbtahun');
	}
	
	//Keterangan Tanah & Bangunan Sertifikat
	public function ktbsertifikatcetakAction(){
		$id_surat = $this->_getParam("id_surat");
		$this->render('ktbsertifikatcetak');
	}
	
	public function ktbsertifikathariAction(){
			$tanggal = $this->_getParam("tanggal");
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->tanggal = $tanggal;
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getktbsertifikathari($tanggal, $bln, $thn);
			$this->render('ktbsertifikathari');
	}
	
	public function ktbsertifikatbulanAction(){
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getktbsertifikatbulan($bln, $thn);
			$this->render('ktbsertifikatbulan');
	}
	
	public function ktbsertifikattahunAction(){
			$thn = $this->_getParam("thn");	
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getktbsertifikattahun($thn);
			$this->render('ktbsertifikattahun');
	}
	
	//Keterangan Kematian Baru
	public function matibarucetakAction(){
		$id_surat = $this->_getParam("id_surat");
		$this->render('matibarucetak');
	}
	
	public function matibaruhariAction(){
			$tanggal = $this->_getParam("tanggal");
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->tanggal = $tanggal;
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getmatibaruhari($tanggal, $bln, $thn);
			$this->render('matibaruhari');
	}
	
	public function matibarubulanAction(){
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getmatibarubulan($bln, $thn);
			$this->render('matibarubulan');
	}
	
	public function matibarutahunAction(){
			$thn = $this->_getParam("thn");	
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getmatibarutahun($thn);
			$this->render('matibarutahun');
	}
	
	//Keterangan Kelahiran Baru
	public function lahirbarucetakAction(){
		$id_surat = $this->_getParam("id_surat");
		$this->render('lahirbarucetak');
	}
	
	public function lahirbaruhariAction(){
			$tanggal = $this->_getParam("tanggal");
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->tanggal = $tanggal;
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getlahirbaruhari($tanggal, $bln, $thn);
			$this->render('lahirbaruhari');
	}
	
	public function lahirbarubulanAction(){
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getlahirbarubulan($bln, $thn);
			$this->render('lahirbarubulan');
	}
	
	public function lahirbarutahunAction(){
			$thn = $this->_getParam("thn");	
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getlahirbarutahun($thn);
			$this->render('lahirbarutahun');
	}
	
	//Keterangan Mutasi Balik Nama PBB
	public function mutasipbbcetakAction(){
		$id_surat = $this->_getParam("id_surat");
		$this->render('mutasipbbcetak');
	}
	
	public function mutasipbbhariAction(){
			$tanggal = $this->_getParam("tanggal");
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->tanggal = $tanggal;
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getmutasipbbhari($tanggal, $bln, $thn);
			$this->render('mutasipbbhari');
	}
	
	public function mutasipbbbulanAction(){
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getmutasipbbbulan($bln, $thn);
			$this->render('mutasipbbbulan');
	}
	
	public function mutasipbbtahunAction(){
			$thn = $this->_getParam("thn");	
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getmutasipbbtahun($thn);
			$this->render('mutasipbbtahun');
	}
	
	//Keterangan Penerbitan SPPT PBB
	public function penerbitanpbbcetakAction(){
		$id_surat = $this->_getParam("id_surat");
		$this->render('penerbitanpbbcetak');
	}
	
	public function penerbitanpbbhariAction(){
			$tanggal = $this->_getParam("tanggal");
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->tanggal = $tanggal;
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getpenerbitanpbbhari($tanggal, $bln, $thn);
			$this->render('penerbitanpbbhari');
	}
	
	public function penerbitanpbbbulanAction(){
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getpenerbitanpbbbulan($bln, $thn);
			$this->render('penerbitanpbbbulan');
	}
	
	public function penerbitanpbbtahunAction(){
			$thn = $this->_getParam("thn");	
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getpenerbitanpbbtahun($thn);
			$this->render('penerbitanpbbtahun');
	}
	
	//Keterangan Split PBB
	public function splitpbbcetakAction(){
		$id_surat = $this->_getParam("id_surat");
		$this->render('splitpbbcetak');
	}
	
	public function splitpbbhariAction(){
			$tanggal = $this->_getParam("tanggal");
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->tanggal = $tanggal;
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getsplitpbbhari($tanggal, $bln, $thn);
			$this->render('splitpbbhari');
	}
	
	public function splitpbbbulanAction(){
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getsplitpbbbulan($bln, $thn);
			$this->render('splitpbbbulan');
	}
	
	public function splitpbbtahunAction(){
			$thn = $this->_getParam("thn");	
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getsplitpbbtahun($thn);
			$this->render('splitpbbtahun');
	}
	
	//Keterangan KTP
	public function ktpcetakAction(){
		$id_surat = $this->_getParam("id_surat");
		$this->render('ktpcetak');
	}
	
	public function ktphariAction(){
			$tanggal = $this->_getParam("tanggal");
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->tanggal = $tanggal;
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getktphari($tanggal, $bln, $thn);
			$this->render('ktphari');
	}
	
	public function ktpbulanAction(){
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getktpbulan($bln, $thn);
			$this->render('ktpbulan');
	}
	
	public function ktptahunAction(){
			$thn = $this->_getParam("thn");	
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getktptahun($thn);
			$this->render('ktptahun');
	}
	
	//Keterangan KK
	public function kkcetakAction(){
		$id_surat = $this->_getParam("id_surat");
		$this->render('kkcetak');
	}
	
	public function kkhariAction(){
			$tanggal = $this->_getParam("tanggal");
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->tanggal = $tanggal;
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getkkhari($tanggal, $bln, $thn);
			$this->render('kkhari');
	}
	
	public function kkbulanAction(){
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getkkbulan($bln, $thn);
			$this->render('kkbulan');
	}
	
	public function kktahunAction(){
			$thn = $this->_getParam("thn");	
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getkktahun($thn);
			$this->render('kktahun');
	}
	
	//Keterangan KIPEM
	public function kipemcetakAction(){
		$id_surat = $this->_getParam("id_surat");
		$this->render('kipemcetak');
	}
	
	public function kipemhariAction(){
			$tanggal = $this->_getParam("tanggal");
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->tanggal = $tanggal;
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getkipemhari($tanggal, $bln, $thn);
			$this->render('kipemhari');
	}
	
	public function kipembulanAction(){
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getkipembulan($bln, $thn);
			$this->render('kipembulan');
	}
	
	public function kipemtahunAction(){
			$thn = $this->_getParam("thn");	
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getkipemtahun($thn);
			$this->render('kipemtahun');
	}
	
	//Keterangan SIUP / TDP
	public function siupcetakAction(){
		$id_surat = $this->_getParam("id_surat");
		$this->render('siupcetak');
	}
	
	public function siuphariAction(){
			$tanggal = $this->_getParam("tanggal");
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->tanggal = $tanggal;
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getsiuphari($tanggal, $bln, $thn);
			$this->render('siuphari');
	}
	
	public function siupbulanAction(){
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getsiupbulan($bln, $thn);
			$this->render('siupbulan');
	}
	
	public function siuptahunAction(){
			$thn = $this->_getParam("thn");	
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getsiuptahun($thn);
			$this->render('siuptahun');
	}
	
	//Keterangan Pindah
	public function pindahcetakAction(){
		$id_surat = $this->_getParam("id_surat");
		$this->render('pindahcetak');
	}
	
	public function pindahhariAction(){
			$tanggal = $this->_getParam("tanggal");
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->tanggal = $tanggal;
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getpindahhari($tanggal, $bln, $thn);
			$this->render('pindahhari');
	}
	
	public function pindahbulanAction(){
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getpindahbulan($bln, $thn);
			$this->render('pindahbulan');
	}
	
	public function pindahtahunAction(){
			$thn = $this->_getParam("thn");	
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getpindahtahun($thn);
			$this->render('pindahtahun');
	}
	
	//Keterangan Penelitian
	public function penelitiancetakAction(){
		$id_surat = $this->_getParam("id_surat");
		$this->render('penelitiancetak');
	}
	
	public function penelitianhariAction(){
			$tanggal = $this->_getParam("tanggal");
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->tanggal = $tanggal;
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getpenelitianhari($tanggal, $bln, $thn);
			$this->render('penelitianhari');
	}
	
	public function penelitianbulanAction(){
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getpenelitianbulan($bln, $thn);
			$this->render('penelitianbulan');
	}
	
	public function penelitiantahunAction(){
			$thn = $this->_getParam("thn");	
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getpenelitiantahun($thn);
			$this->render('penelitiantahun');
	}
	
	//------------------------------------------------Petugas Layanan
	//petugas cetak
	public function laporanperpetugascetakAction(){
		$this->view->petugas = $this->data_serv->getpetugas();
		$this->render('laporanperpetugascetak');
	}
		
	//per petugas
	public function laporanperpetugasAction(){		
		$petugas = $this->_getParam("petugas");
		$tanggal = $this->_getParam("tanggal");
		$bln = $this->_getParam("bln");
		$thn = $this->_getParam("thn");	
		
		$namapetugas = $this->data_serv->getnamapetugas($petugas);			
		$this->view->namapetugas=$namapetugas;
		$this->view->tanggal = $tanggal;
		$this->view->bln = $bln;
		$this->view->thn = $thn;
		
		$this->view->namapetugas=$namapetugas;
		$this->view->cetakandon = $this->data_serv->getlaporanperpetugasandon($petugas, $tanggal, $bln, $thn);
		$this->view->cetaksekolah = $this->data_serv->getlaporanperpetugassekolah($petugas, $tanggal, $bln, $thn);
		$this->view->cetakrs = $this->data_serv->getlaporanperpetugasrs($petugas, $tanggal, $bln, $thn);
		$this->view->cetakps = $this->data_serv->getlaporanperpetugasps($petugas, $tanggal, $bln, $thn);
		$this->view->cetakbpr = $this->data_serv->getlaporanperpetugasbpr($petugas, $tanggal, $bln, $thn);
		$this->view->cetakmati = $this->data_serv->getlaporanperpetugasmati($petugas, $tanggal, $bln, $thn);
		$this->view->cetaklahir = $this->data_serv->getlaporanperpetugaslahir($petugas, $tanggal, $bln, $thn);
		$this->view->cetakbelummenikah = $this->data_serv->getlaporanperpetugasbm($petugas, $tanggal, $bln, $thn);
		$this->view->cetakjanda = $this->data_serv->getlaporanperpetugasjanda($petugas, $tanggal, $bln, $thn);
		$this->view->cetakna = $this->data_serv->getlaporanperpetugasna($petugas, $tanggal, $bln, $thn);
		$this->view->cetakik = $this->data_serv->getlaporanperpetugasik($petugas, $tanggal, $bln, $thn);
		$this->view->cetakbd = $this->data_serv->getlaporanperpetugasbd($petugas, $tanggal, $bln, $thn);
		$this->view->cetakkik = $this->data_serv->getlaporanperpetugaskik($petugas, $tanggal, $bln, $thn);
		$this->view->cetakdy = $this->data_serv->getlaporanperpetugasdy($petugas, $tanggal, $bln, $thn);
		$this->view->cetakperusahaan = $this->data_serv->getlaporanperpetugasperusahaan($petugas, $tanggal, $bln, $thn);
		$this->view->cetakpanpemb = $this->data_serv->getlaporanperpetugaspanpemb($petugas, $tanggal, $bln, $thn);
		$this->view->cetakparpol = $this->data_serv->getlaporanperpetugasparpol($petugas, $tanggal, $bln, $thn);
		$this->view->cetakusaha = $this->data_serv->getlaporanperpetugasusaha($petugas, $tanggal, $bln, $thn);
		$this->view->cetaksiup = $this->data_serv->getlaporanperpetugassiup($petugas, $tanggal, $bln, $thn);
		$this->view->cetakibadahhaji = $this->data_serv->getlaporanperpetugasibadahhaji($petugas, $tanggal, $bln, $thn);
		$this->view->cetakktp = $this->data_serv->getlaporanperpetugasktp($petugas, $tanggal, $bln, $thn);
		$this->view->cetakkk = $this->data_serv->getlaporanperpetugaskk($petugas, $tanggal, $bln, $thn);
		$this->view->cetakkipem = $this->data_serv->getlaporanperpetugaskipem($petugas, $tanggal, $bln, $thn);
		$this->view->cetakorangsama = $this->data_serv->getlaporanperpetugasorangsama($petugas, $tanggal, $bln, $thn);
		$this->view->cetakwaris = $this->data_serv->getlaporanperpetugaswaris($petugas, $tanggal, $bln, $thn);
		$this->view->cetakdomisilipend = $this->data_serv->getlaporanperpetugasdomisilipend($petugas, $tanggal, $bln, $thn);
		$this->view->cetakajb = $this->data_serv->getlaporanperpetugasajb($petugas, $tanggal, $bln, $thn);
		$this->view->cetaksertifikat = $this->data_serv->getlaporanperpetugassertifikat($petugas, $tanggal, $bln, $thn);
		$this->view->cetakkuasa = $this->data_serv->getlaporanperpetugaskuasa($petugas, $tanggal, $bln, $thn);
		$this->view->cetakpbbmutasi = $this->data_serv->getlaporanperpetugaspbbmutasi($petugas, $tanggal, $bln, $thn);
		$this->view->cetakpbbsplit = $this->data_serv->getlaporanperpetugaspbbsplit($petugas, $tanggal, $bln, $thn);
		$this->view->cetakpbbpenerbitan = $this->data_serv->getlaporanperpetugaspbbpenerbitan($petugas, $tanggal, $bln, $thn);
		$this->view->cetaklahirbaru = $this->data_serv->getlaporanperpetugaslahirbaru($petugas, $tanggal, $bln, $thn);
		$this->view->cetakmatibaru = $this->data_serv->getlaporanperpetugasmatibaru($petugas, $tanggal, $bln, $thn);
		$this->render('laporanperpetugas');
	}
	
	//pretasi petugas
	public function prestasipetugasAction(){
		$this->view;
		//$this->view->prestasi = $this->pengguna->getPrestasi();	
	}
	
	//----------------------------------------------Laporan Seluruh Petugas
	//Seluruh Petugas
	public function seluruhpetugascetakAction(){
		$this->view;
	}	
	public function seluruhpetugashariAction(){
			$tanggal = $this->_getParam("tanggal");
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->tanggal = $tanggal;
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getseluruhpetugashari($tanggal, $bln, $thn);
			$this->render('seluruhpetugashari');
	}	
	// public function seluruhpetugasbulanAction(){
			// $bln = $this->_getParam("bln");
			// $thn = $this->_getParam("thn");	
			// $this->view->bln = $bln;
			// $this->view->thn = $thn;
			// $this->view->cetak = $this->data_serv->getkeseluruhanbulan($bln, $thn);
			// $this->view->rekap = $this->data_serv->getRekapBulan($bln, $thn);
			// $this->render('laporankeseluruhanbulan');
	// }	
	// public function seluruhpetugastahunAction(){
			// $thn = $this->_getParam("thn");	
			// $this->view->thn = $thn;
			// $this->view->cetak = $this->data_serv->getkeseluruhantahun($thn);
			// $this->view->rekap = $this->data_serv->getRekapTahun($thn);
			// $this->render('laporankeseluruhantahun');
	// }
	
	//----------------------------------------------Laporan Keseluruhan
	//Keseluruhan
	public function laporankeseluruhancetakAction(){
		$this->view;
	}	
	public function laporankeseluruhanhariAction(){
			$tanggal = $this->_getParam("tanggal");
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->tanggal = $tanggal;
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getkeseluruhanhari($tanggal, $bln, $thn);
			$this->view->rekap = $this->data_serv->getRekapHari($tanggal, $bln, $thn);
			$this->render('laporankeseluruhanhari');
	}	
	public function laporankeseluruhanbulanAction(){
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getkeseluruhanbulan($bln, $thn);
			$this->view->rekap = $this->data_serv->getRekapBulan($bln, $thn);
			$this->render('laporankeseluruhanbulan');
	}	
	public function laporankeseluruhantahunAction(){
			$thn = $this->_getParam("thn");	
			$this->view->thn = $thn;
			$this->view->cetak = $this->data_serv->getkeseluruhantahun($thn);
			$this->view->rekap = $this->data_serv->getRekapTahun($thn);
			$this->render('laporankeseluruhantahun');
	}
	
	public function laporankeseluruhantahungrafikAction(){
			$tanggal = $this->_getParam("tanggal");
			$bln = $this->_getParam("bln");
			$thn = $this->_getParam("thn");	
			$this->view->tanggal = $tanggal;
			$this->view->bln = $bln;
			$this->view->thn = $thn;
			$this->view->rekap = $this->data_serv->getKeseluruhanGrafik($thn);
			$this->view->rekapPejabat = $this->data_serv->getPejabatGrafik($thn);
			$this->view->rekapAntri = $this->data_serv->getAntrianGrafik($thn);
			$this->view->rekapProses = $this->data_serv->getProsesGrafik($thn);
			
			$this->render('laporankeseluruhantahungrafik');
	}
	
	//------------------------------------- Laporan Arsip
	public function arsipdataAction(){
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
			$this->view->jumData = $this->data_serv->getJumlahArsip();
			$this->view->dataPerPage = $dataPerPage;
			$this->view->noPage = $noPage;
			$this->view->offset=$offset;
			
			$id_surat = $this->_getParam("id_surat");
			$this->view;
			$this->view->arsip = $this->data_serv->getdataarsip($offset,$dataPerPage);
	}
	
	public function arsiphapusAction(){
		$id_data_arsip= $this->_getParam("id_data_arsip");
		$hasil = $this->data_serv->gethapusarsip($id_data_arsip);
		//jika gagal
		if($hasil == 'gagal'){
			$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
			$this->arsipdataAction();
			$this->render('arsipdata');			
		}
		//jika sukses
		$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
			$this->arsipdataAction();
			$this->render('arsipdata');
		
	}
	public function arsiptambahAction(){
		$this->view->surat = $this->data_serv->getDataSurat();
		$this->render('arsiptambah');
	}
	
	public function simpanarsipAction(){
		if(isset($_POST['simpan'])){
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
			//$file_ext        = strtolower(end(explode('.',$file_name)));
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
						
						$hasil = $this->data_serv->getsimpanarsip($data);
						//jika gagal
						if($hasil == 'gagal'){
							$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
							$this->arsipdataAction();
							$this->render('arsipdata');			
						}
							//jika sukses
						if($hasil == 'sukses'){
							$this->view->peringatan ="<div class='sukses'> Sukses! $file_name. data berhasil ditambahkan </div>";		
							$this->arsipdataAction();
							$this->render('arsipdata');
						}
						
						
						
                    }else{
                       $this->view->peringatan ="<div class='gagal'> ERROR: Besar ukuran file (file size) maksimal 2 Mb! </div>";
						$this->arsipdataAction();
						$this->render('arsipdata');		
                    }
                }else{
                   $this->view->peringatan ="<div class='gagal'> ERROR: Ekstensi file tidak di izinkan! </div>";						
					$this->arsipdataAction();
					$this->render('arsipdata');	
                }
		}			
	}
	
	
	public function arsipeditAction(){		
		$id_data_arsip= $this->_getParam("id_data_arsip");
		
		$this->view->hasil= $this->data_serv->getarsipid($id_data_arsip);		
		$this->view->surat = $this->data_serv->getDataSurat();
	}
	public function simpanarsipeditAction(){
		if(isset($_POST['Ubah'])){
			$nik = $_POST['nik'];
			$id_data_arsip = $_POST['id_data_arsip'];
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
			//$file_ext        = strtolower(end(explode('.',$file_name)));
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
							"id_data_arsip" => $id_data_arsip,
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
						
						$hasil = $this->data_serv->getsimpanarsipedit($data);
						//jika gagal
						if($hasil == 'gagal'){
							$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
							$this->arsipdataAction();
							$this->render('arsipdata');			
						}
							//jika sukses
						if($hasil == 'sukses'){
							$this->view->peringatan ="<div class='sukses'> Sukses! $file_name. data berhasil ditambahkan </div>";		
							$this->arsipdataAction();
							$this->render('arsipdata');
						}
						
						
						
                    }else{
                       $this->view->peringatan ="<div class='gagal'> ERROR: Besar ukuran file (file size) maksimal 2 Mb! </div>";
						$this->arsipdataAction();
						$this->render('arsipdata');		
                    }
                }else{
                   $this->view->peringatan ="<div class='gagal'> ERROR: Ekstensi file tidak di izinkan! </div>";						
					$this->arsipdataAction();
					$this->render('arsipdata');	
                }
		}	
		
	}
	public function arsipcariAction(){
		$cariarsip = $_POST['cariarsip'];		
		$arsip = $this->data_serv->getcariarsip($cariarsip);
		
		$this->view->arsip = $arsip;
		// $hasil = $this->data_serv->getcariarsip($cariarsip);
		// cariarsip
	}
	
	public function arsipdownloadAction(){
			 $id_data_arsip= $this->_getParam("id_data_arsip");
			$this->view->hasil= $this->data_serv->getarsipid($id_data_arsip);		
	
	}
	
	
	//------------------------------------- Kelola Berita
	public function beritadataAction(){
		
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
			$this->view->jumData = $this->data_serv->getJumlahBerita();
			$this->view->dataPerPage = $dataPerPage;
			$this->view->noPage = $noPage;
			$this->view->offset=$offset;
			
			$id_surat = $this->_getParam("id_surat");
				$this->view;
			$this->view->berita = $this->data_serv->getdataberita($offset,$dataPerPage);
	}
	
	public function beritahapusAction(){
		$id_berita= $this->_getParam("id_berita");
		$hasil = $this->data_serv->gethapusberita($id_berita);
		//jika gagal
		if($hasil == 'gagal'){
			$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
			$this->beritadataAction();
			$this->render('beritadata');			
		}
		//jika sukses
		if($hasil == 'sukses'){
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil dihapus </div>";		
			$this->beritadataAction();
			$this->render('beritadata');
		}
		
	}
	public function beritatambahAction(){
		$this->render('beritatambah');
	}
	
	public function simpanberitaAction(){
		if(isset($_POST['simpan'])){
			 $judul_berita = $_POST['judul_berita'];
			 $isi_berita = $_POST['isi_berita']; 
			 
			$data = array("judul_berita" => $judul_berita,
						"isi_berita" => $isi_berita);
						
				 
				$hasil = $this->data_serv->getsimpanberita($data);
				// var_dump ($data);
				// var_dump ($hasil);
				//jika gagal
					if($hasil == 'gagal'){
						$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
						$this->beritadataAction();
						$this->render('beritadata');			
					}
						//jika sukses
					if($hasil == 'sukses'){
						$this->view->peringatan ="<div class='sukses'> Sukses! &quot$judul_berita&quot berhasil ditambahkan </div>";		
						$this->beritadataAction();
						$this->render('beritadata');
					}
		
		}else{
			$this->beritadataAction();
			$this->render('beritadata');
		}		
	}
	public function beritaeditAction(){		
		$id_berita= $this->_getParam("id_berita");
		
		$this->view->hasil= $this->data_serv->getberitaid($id_berita);
	}
	public function simpanberitaeditAction(){
		 $id_berita= $this->_getParam("id_berita");
		 $isi_berita = $_POST['isi_berita'];
		 $judul_berita = $_POST['judul_berita'];
		
		$data = array("id_berita" => $id_berita,
						"judul_berita" => $judul_berita,
						"isi_berita" => $isi_berita);
		
		$hasil = $this->pengguna->getsimpanberitaedit($data);									 
		//jika gagal
			if($hasil == 'gagal'){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->beritadataAction();
				$this->render('beritadata');			
			}
			
				// var_dump ($data);
				// var_dump ($hasil);
			//jika sukses
			if($hasil == 'sukses'){
				$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
				$this->beritadataAction();
				$this->render('beritadata');
			}				
		
	}
	public function beritacariAction(){
		$cariberita = $_POST['cariberita'];		
		$this->view->berita = $this->data_serv->getcariberita($cariberita);	
		$hasil = $this->data_serv->getcariberita($cariberita);
	}
	
	//------------------------------------- Laporan Waktu Layanan
	public function laporanwaktuAction(){
	
		if(isset($_POST['pilih'])){
			$namasurat = $_POST['namasurat'];
			
			$this->view->judul_surat = array(
					"permintaan_adm_cerai" => "Ket. Adm. Cerai",
					"permintaan_ajb" => "Ket. Tanah & Bangunan (AJB)",					
					"permintaan_sertifikat" => "Ket. Tanah & Bangunan (Sertifikat)",					
					"permintaan_andonnikah" => "Ket. Andon Nikah",					
					"permintaan_bd" => "Ket. Bersih Diri",					
					"permintaan_belummenikah" => "Ket. Belum Menikah",					
					"permintaan_belum_bekerja" => "Ket. Belum Bekerja",					
					"permintaan_bpr" => "Ket. Belum Memiliki Rumah",					
					"permintaan_domisili_panitia_pembangunan" => "Ket. Domisili Panitia Pembangunan",					
					"permintaan_domisili_parpol" => "Ket. Domisili Parpol",					
					"permintaan_domisili_penduduk" => "Ket. Domisili Penduduk",					
					"permintaan_domisili_perusahaan" => "Ket. Domisili Perusahaan",					
					"permintaan_domisili_yayasan" => "Ket. Domisili Yayasan",					
					"permintaan_ibadahhaji" => "Ket.Menunaikan Ibadah Haji",					
					"permintaan_ik" => "Ket. Ijin Keramaian",					
					"permintaan_imb" => "Ket. Ijin Mendirikan Bangunan",					
					"permintaan_janda" => "Ket. Status Janda / Duda",					
					"permintaan_kartuidentitaskerja" => "KKet. Kartu Identitas Kerja",					
					"permintaan_keterangan_tempat_usaha" => "Keterangan Tempat Usaha",					
					"permintaan_kipem" => "Ket. Kipem",					
					"permintaan_kk" => "Kartu Keluarga (KK)",					
					"permintaan_ktp" => "Kartu Tanda Penduduk (KTP)",					
					"permintaan_lahir" => "Ket. Kelahiran Lama",					
					"permintaan_mati" => "Ket. Kematian Lama",					
					"permintaan_lahir_baru" => "Ket. Kelahiran Baru",					
					"permintaan_mati_baru" => "Ket. Kematian Baru",					
					"permintaan_na" => "Ket. Nikah (NA)",					
					"permintaan_orang_yang_sama" => "Ket. Orang yang Sama",					
					"permintaan_pbb_mutasi" => "Ket. Mutasi Balik Nama PBB",					
					"permintaan_pbb_split" => "Ket. Split PBB Pemecahan",					
					"permintaan_pbb_penerbitan" => "Ket. Penerbitan SPPT PBB",					
					"permintaan_ps" => "Pengantar SKCK",					
					"permintaan_rumahsakit" => "Ket.SKTM Rumah Sakit",					
					"permintaan_sekolah" => "Ket. SKTM Sekolah",					
					"permintaan_siup" => "Ket. SIUP",					
					"permintaan_surat_kuasa" => "Ket. Surat Kuasa",					
					"permintaan_waris" => "Ket. Waris",					
					"permintaan_serbaguna" => "Surat Serbaguna",					
			);
			
			// $pecah=explode("_", $namasurat);
			// $judul_surat="" .$pecah[1]." ".$pecah[2]." ".$pecah[3];

			//$this->view->judul_surat= strtoupper($judul_surat);
			$this->view->namasurat= $namasurat;
			$this->view->waktu = $this->data_serv->getwaktu($namasurat);
			//$this->view->surat = $this->data_serv->getnamasurat();
			$this->render('laporanwaktu');
		}
	}

	public function laporanwaktucetakAction(){
	
	
			$namasurat = $_POST['namasurat'];
			$namasurat= $this->_getParam("namasurat");	

			$pecah=explode("_", $namasurat);
			$judul_surat="" .$pecah[1]." ".$pecah[2]." ".$pecah[3];
			
			$this->view->judul_surat= strtoupper($judul_surat);		
			$this->view->waktu = $this->data_serv->getwaktu($namasurat);
			//$this->view->surat = $this->data_serv->getnamasurat();
			$this->render('laporanwaktucetak');
		
	}
	
	//------------------------------------Pegawai
	public function pegawaidataAction(){
		$this->view;
		$this->view->pegawai = $this->data_serv->getDataPegawai();
	}
	
	public function pegawaihapusAction(){
		$id_data_pegawai= $this->_getParam("id_data_pegawai");
		$hasil = $this->data_serv->gethapuspegawai($id_data_pegawai);
		
		//jika gagal
		if(!hasil){
			$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
			$this->pegawaidataAction();
			$this->render('pegawaidata');			
		}
		//jika sukses
		$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil ditambahkan </div>";		
			$this->pegawaidataAction();
			$this->render('pegawaidata');	
		
	}
	public function pegawaitambahAction(){
		$this->view;
	}
	public function simpanpegawaiAction(){
		if(isset($_POST['tambah'])){
			 $nip_pengguna = $_POST['nip_pengguna'];
			 $nama_pengguna = $_POST['nama_pengguna'];
			 $jabatan = $_POST['jabatan'];
			 $golongan = $_POST['golongan'];
			 $alamat = $_POST['alamat'];
			 $no_telp = $_POST['no_telp'];			
			
			$data = array("nip_pengguna" => $nip_pengguna,
						"nama_pengguna" => $nama_pengguna,
						"jabatan" => $jabatan,
						"golongan" => $golongan,
						"alamat" => $alamat,
						"no_telp" => $no_telp);
										 
			$hasil = $this->pengguna->getsimpanpegawai($data);
			//jika gagal
			if(!hasil){
				$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
				$this->pegawaidataAction();
				$this->render('pegawaidata');			
			}
			//jika sukses
			$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil ditambahkan </div>";		
				$this->pegawaidataAction();
				$this->render('pegawaidata');	
		}else{
			$this->pegawaidataAction();
			$this->render('pegawaidata');
		}		
	}
	public function pegawaieditAction(){		
		$id_data_pegawai= $this->_getParam("id_data_pegawai");
		$this->view;
		$hasil= $this->data_serv->getPegawaiId($id_data_pegawai);
		$this->view->hasil  = $hasil;
	}
	public function simpanpegawaieditAction(){
		 $id_data_pegawai = $this->_getParam("id_data_pegawai");
		 $nip_pengguna = $_POST['nip_pengguna'];
		 $nama_pengguna = $_POST['nama_pengguna'];
		 $jabatan = $_POST['jabatan'];
		 $golongan = $_POST['golongan'];
		 $alamat = $_POST['alamat'];
		 $no_telp = $_POST['no_telp'];
		
		
		$data = array("id_data_pegawai" => $id_data_pegawai,
						"nip_pengguna" => $nip_pengguna,
						"nama_pengguna" => $nama_pengguna,
						"jabatan" => $jabatan,
						"golongan" => $golongan,
						"alamat" => $alamat,
						"no_telp" => $no_telp);
									 
		$hasil = $this->pengguna->getsimpanpegawaiasliedit($data);
		//jika gagal
		if(!hasil){
			$this->view->peringatan ="<div class='gagal'> Maaf ada kesalahan </div>";
			$this->pegawaidataAction();
			$this->render('pegawaidata');			
		}
		//jika sukses maka muncul notif
		$this->view->peringatan ="<div class='sukses'> Sukses! data berhasil diubah </div>";		
			$this->pegawaidataAction();
			$this->render('pegawaidata');	
		
	}
}
?>