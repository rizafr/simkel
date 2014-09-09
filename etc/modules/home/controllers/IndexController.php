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
	
		
		$this->view->pemberdayaan = $this->data_serv->getPemberdayaan();
		$this->view->tantrib = $this->data_serv->getTantrib();
		$this->view->ekonomipembangunan = $this->data_serv->getEkonomiPembangunan();
		$this->view->pemerintahan = $this->data_serv->getPemerintahan();
		
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
		
		$username = trim(htmlspecialchars(strip_tags($_POST['username'])));
		$password = trim(htmlspecialchars(strip_tags($_POST['password'])));
		$jenispengguna = $_POST['jenispengguna'];
		
			if($username && $password){
				$hasil = $this->data_serv->getDataPengguna($username, $password);
				//echo "jajajjaajalsdfssssssssssssssssssssssssssssss <br>";
				//echo $hasil->id_jenis_pengguna;
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
					
					//Zend_Session::destroy( true );
					
					
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
	}
    public function simpanpenggunaAction(){
	if(isset($_POST['name'])){
		$id_jenis_pengguna = $_POST['id_jenis_pengguna'];
		$id_kelurahan = $_POST['id_kelurahan'];
		$nama_pengguna = trim(htmlspecialchars($_POST['nama_pengguna']));
		$nip_pengguna = trim(htmlspecialchars($_POST['nip_pengguna']));
		$username = trim(htmlspecialchars($_POST['username']));
		$password = trim(htmlspecialchars($_POST['password']));
		
		$data = array("id_jenis_pengguna" => $id_jenis_pengguna,
							"id_kelurahan" => $id_kelurahan,
							"nama_pengguna" => $nama_pengguna,
							"nip_pengguna" => $nip_pengguna,
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
									 
		$hasil = $this->pengguna->getsimpanpenggunaedit($data);
		
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
		
		$this->view->permintaan = $this->surat_serv->getPermintaanRumahSakit($this->id_kelurahan,0,30);
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
		
		$this->view->permintaan = $this->surat_serv->getPermintaanRumahSakit($this->id_kelurahan,$offset, $dataPerPage);
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
		
		$this->view->permintaan = $this->surat_serv->getPermintaanSekolah($this->id_kelurahan,$offset,$dataPerPage);
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
		
		$this->view->permintaan = $this->surat_serv->getPermintaanAndonNikah($this->id_kelurahan,$offset,$dataPerPage);
		
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
		
		$this->view->permintaan = $this->surat_serv->getPermintaanBelumMenikah($this->id_kelurahan,$offset,$dataPerPage);
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
		
		$this->view->permintaan = $this->surat_serv->getPermintaanbpr($this->id_kelurahan,$offset,$dataPerPage);
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
		
		$this->view->permintaan = $this->surat_serv->getPermintaanibadahhaji($this->id_kelurahan,$offset,$dataPerPage);
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
		
		$this->view->permintaan = $this->surat_serv->getPermintaanjanda($this->id_kelurahan,$offset,$dataPerPage);
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
		
		$this->view->permintaan = $this->surat_serv->getPermintaanik($this->id_kelurahan,$offset,$dataPerPage);
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
		
		$this->view->permintaan = $this->surat_serv->getPermintaanps($this->id_kelurahan,$offset,$dataPerPage);
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
		
		$this->view->permintaan = $this->surat_serv->getPermintaanbd($this->id_kelurahan,$offset,$dataPerPage);
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
	//////////////
	public function cabutacceditAction(){
	
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
		
		$this->view->permintaan = $this->surat_serv->getPermintaandomisiliyayasan($this->id_kelurahan,$offset,$dataPerPage);
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
		
		$this->view->permintaan = $this->surat_serv->getPermintaandomisiliperusahaan($this->id_kelurahan,$offset , $dataPerPage);
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
		
		$this->view->permintaan = $this->surat_serv->getPermintaandomisiliparpol($this->id_kelurahan,$offset , $dataPerPage);
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
		
		$this->view->permintaan = $this->surat_serv->getPermintaanketerangantempatusaha($this->id_kelurahan,$offset ,$dataPerPage);
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
	
	//lahir
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
		
		$this->view->permintaan = $this->surat_serv->getPermintaanlahir($this->id_kelurahan,$offset ,$dataPerPage);
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
	
	//mati
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
		
		$this->view->permintaan = $this->surat_serv->getPermintaanmati($this->id_kelurahan,$offset ,$dataPerPage);
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
	
	//Keterangan keterangan tempat usaha
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
	
	//Keterangan keterangan lahir
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
	
	//Keterangan keterangan mati
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
	
	//Keterangan keterangan waris
	public function wariscetakAction(){
		$id_surat = $this->_getParam("id_surat");
		$this->render('wariscetak');
	}
	
	//Keterangan keterangan serbaguna
	public function serbagunacetakAction(){
		$id_surat = $this->_getParam("id_surat");
		$this->render('serbagunacetak');
	}
	
	//------------------------------------------------Laporan Data Layanan Per Petugas Layanan
	//petugas
	public function laporanpetugasAction(){
		$this->view->petugas = $this->data_serv->getpetugas();
		$this->render('laporanpetugas');
	}
	
	//----------------------------------------------Laporan Keseluruhan
	//Keseluruhan
	public function laporankeseluruhancetakAction(){
		//Format Tanggal 
		$tanggal = date ('j');
		//Array Bulan 
		$array_bulan = array(1=>'1','2','3', '4', '5', '6','7','8','9','10','11','12'); 
		$bulan = $array_bulan[date('n')];
		//Format Tahun 
		$tahun = date('Y');
		$this->view->keseluruhan = $this->data_serv->getkeseluruhan($tanggal,$bulan,$tahun);
		$this->render('laporankeseluruhancetak');
	}
}
?>