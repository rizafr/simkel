<?php
class pengguna_Service {
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
	//----------------------------------------------kelurahan
	public function getKelurahan(){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select * from kelurahan");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	
	}
	
	public function getPilihKelurahan($id_kelurahan){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("select * from kelurahan where id_kelurahan = '$id_kelurahan'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	
	}
	
	public function gethapuskelurahan($id_kelurahan) {
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$where[] = " id_kelurahan = '".$id_kelurahan."'";
			
			$db->delete('kelurahan', $where);
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
	
	public function getsimpankelurahan	(array $data) {
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("nama_kelurahan" => $data['nama_kelurahan'],
								"nama_lurah" => $data['nama_lurah'],
								"kecamatan" => $data['kecamatan'],
								"alamat" => $data['alamat'],
								"no_telepon" => $data['no_telepon'],
								"kode_pos" => $data['kode_pos'],
			
			);
			
			$db->insert('kelurahan',$paramInput);
			$db->commit();
			return 'sukses';
		} catch (Exception $e) {
			 $db->rollBack();
			 echo $e->getMessage().'<br>';
			 return 'gagal';
		}
	}
	
	public function getsimpankelurahanedit(array $data) {
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_kelurahan" => $data['id_kelurahan'],
								"nama_kelurahan" => $data['nama_kelurahan'],
								"nama_lurah" => $data['nama_lurah'],
								"kecamatan" => $data['kecamatan'],
								"alamat" => $data['alamat'],
								"no_telepon" => $data['no_telepon'],
								"kode_pos" => $data['kode_pos'],
			
			);
			$where[] = " id_kelurahan = '".$data['id_kelurahan']."'";
			
			$db->update('kelurahan',$paramInput, $where);
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
	//-------------------------------------------------------jenispengguna
	public function gethapusjenispengguna($id_jenis_pengguna) {
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$where[] = " id_jenis_pengguna = '".$id_jenis_pengguna."'";
			
			$db->delete('jenis_pengguna', $where);
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
	
	public function getsimpanjenispengguna	(array $data) {
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("nama_jenis_pengguna" => $data['nama_jenis_pengguna']);
			
			$db->insert('jenis_pengguna',$paramInput);
			$db->commit();
			return 'sukses';
		} catch (Exception $e) {
			 $db->rollBack();
			 echo $e->getMessage().'<br>';
			 return 'gagal';
		}
	}
	public function getsimpanjenispenggunaedit(array $data) {
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_jenis_pengguna" => $data['id_jenis_pengguna'],
								"nama_jenis_pengguna" => $data['nama_jenis_pengguna']);
			
			$where[] = " id_jenis_pengguna = '".$data['id_jenis_pengguna']."'";
			
			$db->update('jenis_pengguna',$paramInput, $where);
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
	
	public function getJenisPengguna(){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select * from jenis_pengguna ");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	
	}
	
	public function getPegawai(){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select * from data_pegawai ");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	
	}
	
	public function getPilihJenisPengguna($id_jenis_pengguna){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("select * from jenis_pengguna where id_jenis_pengguna = '$id_jenis_pengguna' ");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	
	}
	//-----------------------------------------------------pengguna
	public function getDataPengguna($username, $password){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("select * from pengguna where username='$username' && password='$password'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	
	
	public function getPengguna(){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("SELECT a.*, b.*, c.*, d.*
									FROM jenis_pengguna a, kelurahan b, data_pegawai c, pengguna d
									WHERE a.id_jenis_pengguna = d.id_jenis_pengguna && b.id_kelurahan = d.id_kelurahan && c.id_data_pegawai = d.id_data_pegawai
									order by a.nama_jenis_pengguna");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	
	public function getPilihPengguna($id_pengguna){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT a.*, b.*, c.*, d.*
									FROM jenis_pengguna a, kelurahan b, data_pegawai c, pengguna d
									WHERE a.id_jenis_pengguna = d.id_jenis_pengguna && b.id_kelurahan = d.id_kelurahan && c.id_data_pegawai = d.id_data_pegawai
									&& d.id_pengguna='$id_pengguna'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	public function gethapuspengguna($id_pengguna) {
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$where[] = " id_pengguna = '".$id_pengguna."'";
			
			$db->delete('pengguna', $where);
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
	
	public function getsimpanpengguna(array $data) {
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_pengguna"=>$data['id_pengguna'],
								"id_jenis_pengguna" => $data['id_jenis_pengguna'],
								"id_kelurahan" => $data['id_kelurahan'],								
								"id_data_pegawai" => $data['id_data_pegawai'],								
								"username" => $data['username'],
								"password" => $data['password']);
			
			$db->insert('pengguna',$paramInput);
			$db->commit();
			return 'sukses';
		} catch (Exception $e) {
			 $db->rollBack();
			 echo $e->getMessage().'<br>';
			 return 'gagal';
		}
	}
	
	public function getsimpanpenggunaedit(array $data) {
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_pengguna"=>$data['id_pengguna'],
								"id_jenis_pengguna" => $data['id_jenis_pengguna'],
								"id_kelurahan" => $data['id_kelurahan'],								
								"username" => $data['username'],
								"password" => $data['password']);
			
			$where[] = " id_pengguna = '".$data['id_pengguna']."'";
			
			$db->update('pengguna',$paramInput, $where);
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
	
	public function getsimpanpegawaiedit(array $data) {
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("nip_pengguna"=>$data['nip_pengguna'],
								"nama_pengguna" => $data['nama_pengguna'],
								"jabatan" => $data['jabatan'],
								"alamat" => $data['alamat'],
								"no_telp" => $data['no_telp']
								);
			
			$where[] = " id_data_pegawai = '".$data['id_data_pegawai']."'";
			
			$db->update('data_pegawai',$paramInput, $where);
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
	//------------------------------------------------surat
	public function getSurat($id_surat){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select nama_surat from surat where id_surat = '$id_surat'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	public function getPilihSurat($id_surat){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("select a.id_jenis_surat, a.id_surat, a.nama_surat, b.nama_jenis_surat from  surat a, jenis_surat b where a.id_jenis_surat = b.id_jenis_surat && id_surat = '$id_surat'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	public function gethapussurat($id_surat) {
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$where[] = " id_surat = '".$id_surat."'";
			
			$db->delete('surat', $where);
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
	public function getsimpansurat(array $data) {
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("nama_surat" => $data['nama_surat'],
						"id_jenis_surat" => $data['id_jenis_surat']);
			
			$db->insert('surat',$paramInput);
			$db->commit();
			return 'sukses';
		} catch (Exception $e) {
			 $db->rollBack();
			 echo $e->getMessage().'<br>';
			 return 'gagal';
		}
	}
	public function getsimpansuratedit(array $data) {
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_surat" => $data['id_surat'],
			"nama_surat" => $data['nama_surat'],
						"id_jenis_surat" => $data['id_jenis_surat']);
			
			$where[] = " id_surat = '".$data['id_surat']."'";
			
			$db->update('surat',$paramInput, $where);
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
	//-----------------------------------------------permintaan
	public function getProses($id_surat){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("SELECT  a.nomor_surat, a.tgl_surat, b.nik, b.nama_lengkap, b.rt, b.rw
										FROM permintaan a, data_penduduk b WHERE a.nik_penduduk = b.nik LIMIT 0 , 30");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	public function getDataPermintaanAcc($id_jenis_pengguna,$id_kelurahan){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("SELECT a.id_permintaan , a.nomor_surat, a.tgl_surat, b.nik, 		b.nama_lengkap, b.rt, b.rw, c.nama_surat, d.nama_kelurahan
										FROM permintaan a, data_penduduk b, surat c, kelurahan d WHERE a.id_kelurahan=d.id_kelurahan && a.id_surat = c.id_surat && a.nik_penduduk = b.nik && a.id_kelurahan='$id_kelurahan' 
										&& a.id_jenis_pengguna='$id_jenis_pengguna' && status_nya=1 LIMIT 0 , 30");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	public function getDataPermintaan($id_jenis_pengguna,$id_kelurahan){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("SELECT a.id_permintaan , a.nomor_surat, a.tgl_surat, b.nik, 		b.nama_lengkap, b.rt, b.rw, c.nama_surat, d.nama_kelurahan
										FROM permintaan a, data_penduduk b, surat c, kelurahan d WHERE a.id_kelurahan=d.id_kelurahan && a.id_surat = c.id_surat && a.nik_penduduk = b.nik && a.id_kelurahan='$id_kelurahan' 
										&& a.id_jenis_pengguna='$id_jenis_pengguna' && status_nya=0 LIMIT 0 , 30");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	//----------------------------------------------pemberdayaan acc
	public function getaccsekolah($id_permintaan,$tgl_disetujui,$disetujui_oleh){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_permintaan_sekolah" => $id_permintaan,
								"tgl_disetujui" => $tgl_disetujui,
								"disetujui_oleh" => $disetujui_oleh,
								"status" => 1);
			
			$where[] = " id_permintaan_sekolah = '".$id_permintaan."'";
			
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
		public function getaccrumahsakit($id_permintaan,$tgl_disetujui,$disetujui_oleh){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_permintaan_rumahsakit" => $id_permintaan,
								"tgl_disetujui" => $tgl_disetujui,
								"disetujui_oleh" => $disetujui_oleh,
								"status" => 1);
			
			$where[] = " id_permintaan_rumahsakit = '".$id_permintaan."'";
			
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
		public function getaccps($id_permintaan,$tgl_disetujui,$disetujui_oleh){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_permintaan_ps" => $id_permintaan,
								"tgl_disetujui" => $tgl_disetujui,
								"disetujui_oleh" => $disetujui_oleh,
								"status" => 1);
			
			$where[] = " id_permintaan_ps = '".$id_permintaan."'";
			
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
	public function getaccjanda($id_permintaan,$tgl_disetujui,$disetujui_oleh){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_permintaan_janda" => $id_permintaan,
								"tgl_disetujui" => $tgl_disetujui,
								"disetujui_oleh" => $disetujui_oleh,
								"status" => 1);
			
			$where[] = " id_permintaan_janda = '".$id_permintaan."'";
			
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
	public function getaccik($id_permintaan,$tgl_disetujui,$disetujui_oleh){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_permintaan_ik" => $id_permintaan,
								"tgl_disetujui" => $tgl_disetujui,
								"disetujui_oleh" => $disetujui_oleh,
								"status" => 1);
			
			$where[] = " id_permintaan_ik = '".$id_permintaan."'";
			
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
		public function getaccibadahhaji($id_permintaan,$tgl_disetujui,$disetujui_oleh){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_permintaan_ibadahhaji" => $id_permintaan,
								"tgl_disetujui" => $tgl_disetujui,
								"disetujui_oleh" => $disetujui_oleh,
								"status" => 1);
			
			$where[] = " id_permintaan_ibadahhaji = '".$id_permintaan."'";
			
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
		public function getaccbpr($id_permintaan,$tgl_disetujui,$disetujui_oleh){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_permintaan_bpr" => $id_permintaan,
								"tgl_disetujui" => $tgl_disetujui,
								"disetujui_oleh" => $disetujui_oleh,
								"status" => 1);
			
			$where[] = " id_permintaan_bpr = '".$id_permintaan."'";
			
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
		public function getaccbelummenikah($id_permintaan,$tgl_disetujui,$disetujui_oleh){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_permintaan_belummenikah" => $id_permintaan,
								"tgl_disetujui" => $tgl_disetujui,
								"disetujui_oleh" => $disetujui_oleh,
								"status" => 1);
			
			$where[] = " id_permintaan_belummenikah = '".$id_permintaan."'";
			
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
		public function getaccbd($id_permintaan,$tgl_disetujui,$disetujui_oleh){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_permintaan_bd" => $id_permintaan,
								"tgl_disetujui" => $tgl_disetujui,
								"disetujui_oleh" => $disetujui_oleh,
								"status" => 1);
			
			$where[] = " id_permintaan_bd = '".$id_permintaan."'";
			
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
		public function getaccandonnikah($id_permintaan,$tgl_disetujui,$disetujui_oleh){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_permintaan_andonnikah" => $id_permintaan,
								"tgl_disetujui" => $tgl_disetujui,
								"disetujui_oleh" => $disetujui_oleh,
								"status" => 1);
			
			$where[] = " id_permintaan_andonnikah = '".$id_permintaan."'";
			
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
	
	//----------------------------------------pejabat
	public function getJabatan(){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select * from jenis_pengguna where id_jenis_pengguna != 1 && id_jenis_pengguna !=2");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	public function getDataPejabat(){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select a.id_pejabat, a.nama_pejabat, a.nip_pejabat, b.nama_kelurahan, c.nama_jenis_pengguna from pejabat_kelurahan a, kelurahan b, jenis_pengguna c where a.id_kelurahan = b.id_kelurahan && a.id_jenis_pengguna = c.id_jenis_pengguna");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	public function gethapuspejabat($id_pejabat) {
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$where[] = " id_pejabat = '".$id_pejabat."'";
			
			$db->delete('pejabat_kelurahan', $where);
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
	public function getsimpanpejabat(array $data) {
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("nip_pejabat" => $data['nip_pejabat'],
							"nama_pejabat" => $data['nama_pejabat'],
							"id_kelurahan" => $data['id_kelurahan'],
						"id_jenis_pengguna" => $data['id_jenis_pengguna']);
			
			$db->insert('pejabat_kelurahan',$paramInput);
			$db->commit();
			return 'sukses';
		} catch (Exception $e) {
			 $db->rollBack();
			 echo $e->getMessage().'<br>';
			 return 'gagal';
		}
	}
	public function getPejabatId($id_pejabat){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("select * from pejabat_kelurahan where id_pejabat = $id_pejabat");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	public function getsimpanpejabatedit(array $data) {
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_pejabat" => $data['id_pejabat'],
							"nip_pejabat" => $data['nip_pejabat'],
							"nama_pejabat" => $data['nama_pejabat'],
							"id_kelurahan" => $data['id_kelurahan'],
						"id_jenis_pengguna" => $data['id_jenis_pengguna']);
			
			$where[] = " id_pejabat = '".$data['id_pejabat']."'";
			
			$db->update('pejabat_kelurahan',$paramInput, $where);
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
	//----------------------------------------jenis surat
	public function getDataSurat(){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select a.id_surat, a.nama_surat, b.nama_jenis_surat from  surat a, jenis_surat b where a.id_jenis_surat = b.id_jenis_surat");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	public function getJenisSurat(){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select *from jenis_surat");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	
	//----------------------------------------menu umum
	public function getPemberdayaan(){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select * from surat where id_jenis_surat = 1");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	public function getTantrib(){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select * from surat where id_jenis_surat = 2");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	public function getEkonomiPembangunan(){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select * from surat where id_jenis_surat = 3");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	public function getPemerintahan(){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select * from surat where id_jenis_surat = 4");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	
	//-----------------------------------------------ekbang acc
	public function getaccdomisiliyayasan($id_permintaan,$tgl_disetujui,$disetujui_oleh){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_permintaan_domisili_yayasan" => $id_permintaan,
								"tgl_disetujui" => $tgl_disetujui,
								"disetujui_oleh" => $disetujui_oleh,
								"status" => 1);
			
			$where[] = " id_permintaan_domisili_yayasan = '".$id_permintaan."'";
			
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
	public function getaccdomisiliparpol($id_permintaan,$tgl_disetujui,$disetujui_oleh){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_permintaan_domisili_parpol" => $id_permintaan,
								"tgl_disetujui" => $tgl_disetujui,
								"disetujui_oleh" => $disetujui_oleh,
								"status" => 1);
			
			$where[] = " id_permintaan_domisili_parpol = '".$id_permintaan."'";
			
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
	public function getaccdomisiliperusahaan($id_permintaan,$tgl_disetujui,$disetujui_ole){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_permintaan_domisili_perusahaan" => $id_permintaan,
								"tgl_disetujui" => $tgl_disetujui,
								"disetujui_oleh" => $disetujui_oleh,
								"status" => 1);
			
			$where[] = " id_permintaan_domisili_perusahaan = '".$id_permintaan."'";
			
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
	
	public function getaccketerangantempatusaha($id_permintaan,$tgl_disetujui,$disetujui_oleh){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_permintaan_keterangan_tempat_usaha" => $id_permintaan,
								"tgl_disetujui" => $tgl_disetujui,
								"disetujui_oleh" => $disetujui_oleh,
								"status" => 1);
			
			$where[] = " id_permintaan_keterangan_tempat_usaha = '".$id_permintaan."'";
			
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
	
	//------------------------------pemerintahan acc
	public function getacclahir($id_permintaan,$tgl_disetujui,$disetujui_oleh){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_permintaan_lahir" => $id_permintaan,
								"tgl_disetujui" => $tgl_disetujui,
								"disetujui_oleh" => $disetujui_oleh,
								"status" => 1);
			
			$where[] = " id_permintaan_lahir = '".$id_permintaan."'";
			
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
	
	public function getaccmati($id_permintaan,$tgl_disetujui,$disetujui_oleh){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_permintaan_mati" => $id_permintaan,
								"tgl_disetujui" => $tgl_disetujui,
								"disetujui_oleh" => $disetujui_oleh,

								"status" => 1);
			
			$where[] = " id_permintaan_mati = '".$id_permintaan."'";
			
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
	
	public function getaccwaris($id_permintaan){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_permintaan_waris" => $id_permintaan,
								"status" => 1);
			
			$where[] = " id_permintaan_waris = '".$id_permintaan."'";
			
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
	
	public function getaccserbaguna($id_permintaan){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_permintaan_serbaguna" => $id_permintaan,
								"status" => 1);
			
			$where[] = " id_permintaan_serbaguna = '".$id_permintaan."'";
			
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
	
	//--------------------------------------------------Laporan Per Pelayanan
	//--------rumah sakit
	//rumah sakit perhari
	public function getrumahsakithari($tanggal,$bln,$thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_rumahsakit a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna)
										and date_format(a.tanggal_surat, '%d %M %Y') = '$tanggal $bln $thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	
	}
	//rumah sakit perbulan
	public function getrumahsakitbulan($bln,$thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_rumahsakit a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna)	 
										and date_format(a.tanggal_surat, '%M %Y') = '$bln $thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	
	}
	//rumah sakit pertahun
	public function getrumahsakittahun($thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_rumahsakit a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna) 
										and date_format(a.tanggal_surat, '%Y') = '$thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	
	}
	
	//--------andonnikah
	//andonnikah per hari
	public function getandonnikahhari($hari,$bln,$thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_andonnikah a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna)
										and date_format(a.tanggal_surat, '%d %M %Y') = '$hari $bln $thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	//andonnikah per bulan
	public function getandonnikahbulan($bln,$thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_andonnikah a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna) 
										and date_format(a.tanggal_surat, '%M %Y') = '$bln $thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	//andonnikah per tahun
	public function getandonnikahtahun($thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_andonnikah a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna) 
										and date_format(a.tanggal_surat, '%Y') = '$thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	
	//--------bpr
	//bpr per hari
	public function getbprhari($hari,$bln,$thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_bpr a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna)
										and date_format(a.tanggal_surat, '%d %M %Y') = '$hari $bln $thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	//bpr per bulan
	public function getbprbulan($bln,$thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_bpr a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna)
										and date_format(a.tanggal_surat, '%M %Y') = '$bln $thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	//bpr per tahun
	public function getbprtahun($thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_bpr a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna) 
										and date_format(a.tanggal_surat, '%Y') = '$thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	
	//--------Janda
	//Janda per hari
	public function getjandahari($hari,$bln,$thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_janda a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna)
										and date_format(a.tanggal_surat, '%d %M %Y') = '$hari $bln $thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	//Janda per bulan
	public function getjandabulan($bln,$thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_janda a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna)	 
										and date_format(a.tanggal_surat, '%M %Y') = '$bln $thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	//Janda per tahun
	public function getjandatahun($thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_janda a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna) 
										and date_format(a.tanggal_surat, '%Y') = '$thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	
	//--------Sekolah
	//Sekolah per hari
	public function getsekolahhari($hari,$bln,$thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_sekolah a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna) 
										and date_format(a.tanggal_surat, '%d %M %Y') = '$hari $bln $thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	//Sekolah per bulan
	public function getsekolahbulan($bln,$thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_sekolah a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna) 	 
										and date_format(a.tanggal_surat, '%M %Y') = '$bln $thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	//Sekolah per tahun
	public function getsekolahtahun($thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_sekolah a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna) 
										and date_format(a.tanggal_surat, '%Y') = '$thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	
	//--------Belum Menikah
	//Belum Menikah per hari
	public function getbelummenikahhari($hari,$bln,$thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_belummenikah a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna)
										and date_format(a.tanggal_surat, '%d %M %Y') = '$hari $bln $thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	//Belum Menikah per bulan
	public function getbelummenikahbulan($bln,$thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_belummenikah a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna)
										and date_format(a.tanggal_surat, '%M %Y') = '$bln $thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	//Belum Menikah per tahun
	public function getbelummenikahtahun($thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_belummenikah a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna)  
										and date_format(a.tanggal_surat, '%Y') = '$thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	
	//--------Ibadah Haji
	//Ibadah Haji per hari
	public function getibadahhajihari($hari,$bln,$thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_ibadahhaji a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna)
										and date_format(a.tanggal_surat, '%d %M %Y') = '$hari $bln $thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	//Ibadah Haji per bulan
	public function getibadahhajibulan($bln,$thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_ibadahhaji a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna) 
										and date_format(a.tanggal_surat, '%M %Y') = '$bln $thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	//Ibadah Haji per tahun
	public function getibadahhajitahun($thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_ibadahhaji a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna)
										and date_format(a.tanggal_surat, '%Y') = '$thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	
	//--------Ijin Keramaian
	//Ijin Keramaian per hari
	public function getikhari($hari,$bln,$thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_ik a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna)
										and date_format(a.tanggal_surat, '%d %M %Y') = '$hari $bln $thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	//Ijin Keramaian per bulan
	public function getikbulan($bln,$thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_ik a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna) 	 
										and date_format(a.tanggal_surat, '%M %Y') = '$bln $thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	//Ijin Keramaian per tahun
	public function getiktahun($thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_ik a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna)
										and date_format(a.tanggal_surat, '%Y') = '$thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	
	//--------Pengantar SKCK
	//Pengantar SKCK per hari
	public function getpshari($hari,$bln,$thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*,            
										jp.nama_jenis_pengguna
										from data_penduduk p, permintaan_ps a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and date_format(a.tanggal_surat, '%d %M %Y') = '$hari $bln $thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	//Pengantar SKCK per bulan
	public function getpsbulan($bln,$thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna
										from data_penduduk p, permintaan_ps a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 	 
										and date_format(a.tanggal_surat, '%M %Y') = '$bln $thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	//Pengantar SKCK per tahun
	public function getpstahun($thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna
										from data_penduduk p, permintaan_ps a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna  
										and date_format(a.tanggal_surat, '%Y') = '$thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	
	//--------Bersih Diri
	//Bersih Diri per hari
	public function getbdhari($hari,$bln,$thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_bd a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna)
										and date_format(a.tanggal_surat, '%d %M %Y') = '$hari $bln $thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	//Bersih Diri per bulan
	public function getbdbulan($bln,$thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_bd a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna)	 
										and date_format(a.tanggal_surat, '%M %Y') = '$bln $thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	//Bersih Diri per tahun
	public function getbdtahun($thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_bd a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna)
										and date_format(a.tanggal_surat, '%Y') = '$thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	
	//--------Domisili Parpol
	//Domisili Parpol per hari
	public function getdomisiliparpolhari($tanggal,$bln,$thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_domisili_parpol a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna)
										and date_format(a.tanggal_surat, '%d %M %Y') = '$tanggal $bln $thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	//Domisili Parpol per bulan
	public function getdomisiliparpolbulan($bln,$thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_domisili_parpol a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna) 
										and date_format(a.tanggal_surat, '%M %Y') = '$bln $thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	//Domisili Parpol per tahun
	public function getdomisiliparpoltahun($thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_domisili_parpol a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna)
										and date_format(a.tanggal_surat, '%Y') = '$thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	
	//--------Domisili Yayasan
	//Domisili Yayasan per hari
	public function getdomisiliyayasanhari($tanggal,$bln,$thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_domisili_yayasan a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna)
										and date_format(a.tanggal_surat, '%d %M %Y') = '$tanggal $bln $thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	//Domisili Yayasan per bulan
	public function getdomisiliyayasanbulan($bln,$thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_domisili_yayasan a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna)
										and date_format(a.tanggal_surat, '%M %Y') = '$bln $thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	//Domisili Yayasan per tahun
	public function getdomisiliyayasantahun($thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_domisili_yayasan a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna)
										and date_format(a.tanggal_surat, '%Y') = '$thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	
	//--------Domisili Perusahaan
	//Domisili Perusahaan per hari
	public function getdomisiliperusahaanhari($tanggal,$bln,$thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_domisili_perusahaan a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna)
										and date_format(a.tanggal_surat, '%d %M %Y') = '$tanggal $bln $thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	//Domisili Perusahaan per bulan
	public function getdomisiliperusahaanbulan($bln,$thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_domisili_perusahaan a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna)  
										and date_format(a.tanggal_surat, '%M %Y') = '$bln $thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	//Domisili Perusahaan per tahun
	public function getdomisiliperusahaantahun($thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_domisili_perusahaan a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna)
										and date_format(a.tanggal_surat, '%Y') = '$thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	
	//--------Keterangan Tempat Usaha
	//Keterangan Tempat Usaha per hari
	public function getketerangantempatusahahari($tanggal,$bln,$thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_keterangan_tempat_usaha a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna)  
										and date_format(a.tanggal_surat, '%d %M %Y') = '$tanggal $bln $thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	//Keterangan Tempat Usaha per bulan
	public function getketerangantempatusahabulan($bln,$thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_keterangan_tempat_usaha a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna) 
										and date_format(a.tanggal_surat, '%M %Y') = '$bln $thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	//Keterangan Tempat Usaha per tahun
	public function getketerangantempatusahatahun($thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_keterangan_tempat_usaha a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna) 
										and date_format(a.tanggal_surat, '%Y') = '$thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	
	//--------Lahir
	//Lahir per hari
	public function getlahirhari($tanggal,$bln,$thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_lahir a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna) 
										and date_format(a.tanggal_surat, '%d %M %Y') = '$tanggal $bln $thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	//Lahir per bulan
	public function getlahirbulan($bln,$thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_lahir a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna)
										and date_format(a.tanggal_surat, '%M %Y') = '$bln $thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	//Lahir per tahun
	public function getlahirtahun($thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_lahir a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna)
										and date_format(a.tanggal_surat, '%Y') = '$thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	
	//--------Mati
	//Mati per hari
	public function getmatihari($tanggal,$bln,$thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_mati a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna)
										and date_format(a.tanggal_surat, '%d %M %Y') = '$tanggal $bln $thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	//Mati per bulan
	public function getmatibulan($bln,$thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_mati a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna)
										and date_format(a.tanggal_surat, '%M %Y') = '$bln $thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	//Mati per tahun
	public function getmatitahun($thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_mati a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna) 
										and date_format(a.tanggal_surat, '%Y') = '$thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	
	//--------Serbaguna
	//serbaguna perhari
	public function getserbagunahari($tanggal,$bln,$thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_serbaguna a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna)
										and date_format(a.tanggal_surat, '%d %M %Y') = '$tanggal $bln $thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	
	}
	//serbaguna perbulan
	public function getserbagunabulan($bln,$thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_serbaguna a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna)	 
										and date_format(a.tanggal_surat, '%M %Y') = '$bln $thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	
	}
	//rumah sakit pertahun
	public function getserbagunatahun($thn){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select  p.*, a.*,
										s.nama_surat,
										j.nama_pejabat,j.nip_pejabat,
										k.*  ,            
										jp.nama_jenis_pengguna,
										dp.nama_pengguna as nama_pegawai
										from data_penduduk p, data_pegawai dp, permintaan_serbaguna a, surat s, pejabat_kelurahan j, pengguna u, kelurahan k , jenis_pengguna jp
										where a.nik=p.nik 
										and a.id_surat = s.id_surat
										and a.id_pejabat = j.id_pejabat
										and a.id_pengguna = u.id_pengguna
										and a.id_kelurahan = k.id_kelurahan
										and j.id_jenis_pengguna = jp.id_jenis_pengguna 
										and u.id_data_pegawai = dp.id_data_pegawai
										and (a.antrian_oleh = u.id_pengguna or a.proses_oleh = u.id_pengguna) 
										and date_format(a.tanggal_surat, '%Y') = '$thn'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	
	}
	
	//--------------------------------------------------Petugas Layanan
	public function getpetugas(){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select p.*, dp.* from pengguna p, data_pegawai dp
										where p.id_data_pegawai = dp.id_data_pegawai");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }	
	}
	//pilih nama petugas
	public function getnamapetugas($petugas){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("select dp.nama_pengguna from pengguna p, data_pegawai dp
									where p.id_data_pegawai=dp.id_data_pegawai
									and p.id_pengguna='$petugas'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	//laporan per petugas andon
	public function getlaporanperpetugasandon($petugas){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select a.*, p.*, dp.* from permintaan_andonnikah a, pengguna p, data_pegawai dp
									where (a.antrian_oleh=p.id_pengguna or a.proses_oleh=p.id_pengguna)
									and p.id_data_pegawai=dp.id_data_pegawai
									and (a.antrian_oleh='$petugas' or a.proses_oleh='$petugas')");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	//laporan per petugas sekolah
	public function getlaporanperpetugassekolah($petugas){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select a.*, p.*, dp.* from permintaan_sekolah a, pengguna p, data_pegawai dp
									where (a.antrian_oleh=p.id_pengguna or a.proses_oleh=p.id_pengguna)
									and p.id_data_pegawai=dp.id_data_pegawai
									and (a.antrian_oleh='$petugas' or a.proses_oleh='$petugas')");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	//laporan per petugas rumah sakit
	public function getlaporanperpetugasrs($petugas){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select a.*, p.*, dp.* from permintaan_rumahsakit a, pengguna p, data_pegawai dp
									where (a.antrian_oleh=p.id_pengguna or a.proses_oleh=p.id_pengguna)
									and p.id_data_pegawai=dp.id_data_pegawai
									and (a.antrian_oleh='$petugas' or a.proses_oleh='$petugas')");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	//laporan per petugas PS
	public function getlaporanperpetugasps($petugas){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select a.*, p.*, dp.* from permintaan_ps a, pengguna p, data_pegawai dp
									where (a.antrian_oleh=p.id_pengguna or a.proses_oleh=p.id_pengguna)
									and p.id_data_pegawai=dp.id_data_pegawai
									and (a.antrian_oleh='$petugas' or a.proses_oleh='$petugas')");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	//laporan per petugas BPR
	public function getlaporanperpetugasbpr($petugas){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select a.*, p.*, dp.* from permintaan_bpr a, pengguna p, data_pegawai dp
									where (a.antrian_oleh=p.id_pengguna or a.proses_oleh=p.id_pengguna)
									and p.id_data_pegawai=dp.id_data_pegawai
									and (a.antrian_oleh='$petugas' or a.proses_oleh='$petugas')");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	//laporan per petugas Mati
	public function getlaporanperpetugasmati($petugas){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select a.*, p.*, dp.* from permintaan_mati a, pengguna p, data_pegawai dp
									where (a.antrian_oleh=p.id_pengguna or a.proses_oleh=p.id_pengguna)
									and p.id_data_pegawai=dp.id_data_pegawai
									and (a.antrian_oleh='$petugas' or a.proses_oleh='$petugas')");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	//laporan per petugas Lahir
	public function getlaporanperpetugaslahir($petugas){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select a.*, p.*, dp.* from permintaan_lahir a, pengguna p, data_pegawai dp
									where (a.antrian_oleh=p.id_pengguna or a.proses_oleh=p.id_pengguna)
									and p.id_data_pegawai=dp.id_data_pegawai
									and (a.antrian_oleh='$petugas' or a.proses_oleh='$petugas')");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	
	//prestasi petugas
	public function getPrestasi(){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select a.*, p.*, dp.* from permintaan_lahir a, pengguna p, data_pegawai dp
									where (a.antrian_oleh=p.id_pengguna or a.proses_oleh=p.id_pengguna)
									and p.id_data_pegawai=dp.id_data_pegawai
									and (a.antrian_oleh='$petugas' or a.proses_oleh='$petugas')");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	
	//--------------------------------------------------Laporan Keseluruhan
	public function getkeseluruhan(){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select dp.*, nr.*,
											(CASE WHEN left(nr.no_registrasi,3)='400' then 'ANDON NIKAH' END ) as jenis_surat
											from data_penduduk dp, no_registrasi nr
											where nr.nik = dp.nik and  date_format(nr.tgl_dibuat, '%Y-%m-%d') =   CURDATE()
											order by right(nr.no_registrasi,4) desc");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	
	}
	
	
	
	//-----------------------------------Arsip
	
	public function getJumlahArsip(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from data_arsip");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
	public function getdataarsip($offset,$dataPerPage){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select p.*, a.* 
											from data_penduduk p, data_arsip a 
											where a.nik = p.nik order by id_data_arsip desc
											LIMIT $offset , $dataPerPage");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
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
							"data_file" => $data['data_file']);
			
			$db->insert('data_arsip',$paramInput);
			$db->commit();
			return 'sukses';
		} catch (Exception $e) {
			 $db->rollBack();
			 echo $e->getMessage().'<br>';
			 return 'gagal';
		}
	}
	public function getarsipid($id_data_arsip){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("select * from data_arsip where id_data_arsip = $id_data_arsip");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	public function getsimpanarsipedit(array $data) {
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_data_arsip" => $data['id_data_arsip'],
							"nama_surat" => $data['nama_surat'],
							"no_surat" => $data['no_surat'],
							"tanggal_surat" => $data['tanggal_surat'],
							"ruangan" => $data['ruangan'],
							"lemari" => $data['lemari'],
							"rak" => $data['rak'],
							"kotak" => $data['kotak']
							);
			
			$where[] = " id_data_arsip = '".$data['id_data_arsip']."'";
			
			$db->update('data_arsip',$paramInput, $where);
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
	public function gethapusarsip($id_data_arsip) {
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$where[] = " id_data_arsip = '".$id_data_arsip."'";
			
			$db->delete('data_arsip', $where);
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
	//pencarian arsip
	public function getcariarsip($cariarsip){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select a.*,p.nama from data_arsip a, data_penduduk p 
									where (p.nama like '%$cariarsip%'  or a.nik like '%$cariarsip%' 
									or a.nama_surat like '%$cariarsip%' 
									or a.no_surat like '%$cariarsip%' or a.tanggal_surat like '%$cariarsip%' 
									or a.ruangan like '%$cariarsip%' or a.lemari like '%$cariarsip%' 
									or a.rak like '%$cariarsip%' or a.kotak like '%$cariarsip%') and p.nik=a.nik");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	
	
	//-----------------------------------Berita
	
	public function getJumlahBerita(){
			$registry = Zend_Registry::getInstance();
			$db = $registry->get('db');
			try {
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from berita");
				return $result;
				} catch (Exception $e) {
				echo $e->getMessage().'<br>';
				return 'Data tidak ada <br>';
			}
		}
		
	public function getdataberita($offset,$dataPerPage){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select * from berita LIMIT $offset , $dataPerPage");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	
	public function getsimpanberita(array $data) {
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("judul_berita" => $data['judul_berita'],
							"isi_berita" => $data['isi_berita']);
			
			$db->insert('berita',$paramInput);
			$db->commit();
			return 'sukses';
		} catch (Exception $e) {
			 $db->rollBack();
			 echo $e->getMessage().'<br>';
			 return 'gagal';
		}
	}
	public function getberitaid($id_berita){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("select * from berita where id_berita = $id_berita");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	public function getsimpanberitaedit(array $data) {
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("judul_berita" => $data['judul_berita'],
							"isi_berita" => $data['isi_berita']);
			
			$where[] = " id_berita = '".$data['id_berita']."'";
			
			$db->update('berita',$paramInput, $where);
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
	public function gethapusberita($id_berita) {
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$where[] = " id_berita = '".$id_berita."'";
			
			$db->delete('berita', $where);
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
	//pencarian berita
	public function getcariberita($cariberita){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select * from berita  where isi_berita like '%$cariberita%' or judul_berita like '%$cariberita%' 
									");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	
	//-----------------------------------------Laporan Waktu Layanan
	public function getwaktu($namasurat){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select * from $namasurat ");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	
	//----------------------------------------Pegawai
	public function getDataPegawai(){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select * from data_pegawai");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	public function gethapuspegawai($id_data_pegawai) {
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$where[] = " id_data_pegawai = '".$id_data_pegawai."'";
			
			$db->delete('data_pegawai', $where);
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
	public function getsimpanpegawai(array $data) {
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("nip_pengguna" => $data['nip_pengguna'],
							"nama_pengguna" => $data['nama_pengguna'],
							"jabatan" => $data['jabatan'],
							"golongan" => $data['golongan'],
							"alamat" => $data['alamat'],
							"no_telp" => $data['no_telp']);						
			$db->insert('data_pegawai',$paramInput);
			$db->commit();
			return 'sukses';
		} catch (Exception $e) {
			 $db->rollBack();
			 echo $e->getMessage().'<br>';
			 return 'gagal';
		}
	}
	
	public function getPegawaiId($id_data_pegawai){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("select * from data_pegawai where id_data_pegawai = $id_data_pegawai");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	
	public function getsimpanpegawaiasliedit(array $data) {
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("nip_pengguna" => $data['nip_pengguna'],
							"nama_pengguna" => $data['nama_pengguna'],
							"jabatan" => $data['jabatan'],
							"golongan" => $data['golongan'],
							"alamat" => $data['alamat'],
							"no_telp" => $data['no_telp']);					
			$where[] = " id_data_pegawai = '".$data['id_data_pegawai']."'";
			
			$db->update('data_pegawai',$paramInput, $where);
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
}
?>
