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

    public function getKodeSurat($id_surat) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT  * from surat where id_surat = $id_surat");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //contoh autonumber 
    function autonumber($tabel, $kolom, $lebar = 0, $awalan = '') {
        $query = "select $kolom from $tabel order by $kolom desc limit 1";
        $hasil = mysql_query($query);
        $jumlahrecord = mysql_num_rows($hasil);
        if ($jumlahrecord == 0)
            $nomor = 1;
        else {
            $row = mysql_fetch_array($hasil);
            $nomor = intval(substr($row[0], strlen($awalan))) + 1;
        }
        if ($lebar > 0)
            $angka = $awalan . str_pad($nomor, $lebar, "0", STR_PAD_LEFT);
        else
            $angka = $awalan . $nomor;
        return $angka;
    }

    //mendapatkan noregistrasi terakhir autoincrement
    public function getNoRegistrasi($lebar = 0, $awalan = '') {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("Select no_registrasi from no_registrasi order by RIGHT(no_registrasi,4) desc limit 1");

            $jumlahrecord = count($result);

            if ($jumlahrecord == 0)
                $nomor = 1;
            elseif ($jumlahrecord > 0) {
                $nomor = intval(substr($result, strlen($awalan))) + 1;
            }
            if ($lebar > 0)
                $angka = $awalan . str_pad($nomor, $lebar, "0", STR_PAD_LEFT);
            else
                $angka = $awalan . $nomor;
            return $angka;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    function selisih($time_1, $time_2) {
        date_default_timezone_set('Asia/Jakarta');

        $a = explode(":", $time_1);
        $b = explode(":", $time_2);

        /* Explode parameter $time_1 */
        $a_hour = $a[0];
        $a_minutes = $a[1];
        $a_seconds = $a[2];

        /* Explode parameter $time_2 */
        $b_hour = $b[0];
        $b_minutes = $b[1];
        $b_seconds = $b[2];

        /* declare result variabel */
        $c_hour = NULL;
        $c_minutes = NULL;
        $c_seconds = NULL;

        /* -----------------------------------------
         * Pengurangan detik
         * -----------------------------------------
         * */
        if ($b_seconds >= $a_seconds) {
            $c_seconds = $b_seconds - $a_seconds;
        } else {
            $c_seconds = ($b_seconds + 60) - $a_seconds;
            $b_minutes--;
        }

        /* -----------------------------------------
         * Pengurangan menit
         * -----------------------------------------
         * */
        if ($b_minutes >= $a_minutes) {
            $c_minutes = $b_minutes - $a_minutes;
        } else {
            $c_minutes = ($b_minutes + 60) - $a_minutes;
            $b_hour--;
        }

        /* -----------------------------------------
         * Pengurangan jam
         * -----------------------------------------
         * */
        if ($b_hour >= $a_hour) {
            $c_hour = $b_hour - $a_hour;
        } else {
            $c_hour = ($a_hour - $b_hour);
        }

        /* Checking time format */
        if (strlen($c_seconds) == 1)
            $c_seconds = '0' . $c_seconds;
        if (strlen($c_minutes) == 1)
            $c_minutes = '0' . $c_minutes;
        if (strlen($c_hour) == 1)
            $c_hour = '0' . $c_hour;

        /* Return result */
        return $c_hour . ':' . $c_minutes . ':' . $c_seconds;
    }

    //MENGISI NO REGISTRASI DARI DATA ANTRIAN
    public function getSimpanNoRegistrasi(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("no_registrasi" => $data['no_registrasi'],
                "id_surat" => $data['id_surat'],
                "antrian_oleh" => $data['antrian_oleh'],
                "waktu_antrian" => $data['waktu_antrian'],
                "status" => $data['status'],
                "nik" => $data['nik']);

            $db->insert('no_registrasi', $paramInput);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    //MENGUPADTE NO REGISTRASI DARI DATA PROSES
    public function getUpdateNoRegistrasi(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array(
                "id_surat" => $data['id_surat'],
                "id_pejabat" => $data['id_pejabat'],
                "waktu_proses" => $data['waktu_proses'],
                "status" => $data['status'],
                "proses_oleh" => $data['proses_oleh']
            );

            $where[] = " no_registrasi = '" . $data['no_registrasi'] . "'";

            $db->update('no_registrasi', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    //MENGUPADTE NO REGISTRASI DARI DATA SELESAI
    public function getUpdateSelesaiNoRegistrasi(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array(
                "status" => $data['status'],
                "waktu_selesai" => $data['waktu_selesai'],
                "waktu_total" => $data['waktu_total']
            );

            $where[] = " no_registrasi = '" . $data['no_registrasi'] . "'";

            $db->update('no_registrasi', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
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

            $db->insert('data_arsip', $paramInput);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!rumah sakit
    //cetak surat Rumah sakit
    public function getrumahsakitcetak($id_permintaan_rumahsakit) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //proses simpan antrian -> status menjadi 1
    public function getsimpanrumahsakitantrian(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_pengguna" => $data['id_pengguna'],
                "id_kelurahan" => $data['id_kelurahan'],
                "no_registrasi" => $data['no_registrasi'],
                "nik" => $data['nik'],
                "waktu_antrian" => $data['waktu_antrian'],
                "antrian_oleh" => $data['antrian_oleh'],
                "jam_masuk" => $data['jam_masuk'],
                "status" => $data['status'],
                "no_telp" => $data['no_telp']
            );

            $db->insert('permintaan_rumahsakit', $paramInput);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getProsesRumahSakit($id_kelurahan, $offset, $dataPerPage) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahRumahSakit($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_rumahsakit where id_kelurahan=$id_kelurahan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPencarianRumahSakit($id_kelurahan, $pencarian, $id_pencarian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            if (!$pencarian) {
                $result = $db->fetchAll("SELECT a.id_permintaan_rumahsakit, a.no_surat, a.tanggal_surat, b.nik, b.nama, b.rt, b.rw, a.status FROM permintaan_rumahsakit a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
            } else {
                if ($id_pencarian == 1) {
                    $result = $db->fetchAll("SELECT a.id_permintaan_rumahsakit, a.no_surat, a.tanggal_surat, b.nik, b.nama, b.rt, b.rw, a.status FROM permintaan_rumahsakit a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
                } else if ($id_pencarian == 2) {
                    $result = $db->fetchAll("SELECT a.id_permintaan_rumahsakit, a.no_surat, a.tanggal_surat, b.nik, b.nama, b.rt, b.rw, a.status FROM permintaan_rumahsakit a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
                }
            }
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getrumahsakit($id_permintaan_rumahsakit) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*, b.*, c.* FROM permintaan_rumahsakit a, data_penduduk b, pejabat_kelurahan c WHERE  a.nik = b.nik  AND a.id_permintaan_rumahsakit = $id_permintaan_rumahsakit");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesrs(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
                "id_pejabat" => $data['id_pejabat'],
                "id_jenis_surat" => $data['id_jenis_surat'],
                "id_surat" => $data['id_surat'],
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

            $where[] = " id_permintaan_rumahsakit = '" . $data['id_permintaan_rumahsakit'] . "'";

            $db->update('permintaan_rumahsakit', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getsimpanprosesrsedit(array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
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

            $where[] = " id_permintaan_rumahsakit = '" . $data['id_permintaan_rumahsakit'] . "'";

            $db->update('permintaan_rumahsakit', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function gethapusrumahsakit($id_permintaan_rumahsakit) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $where[] = " id_permintaan_rumahsakit = '" . $id_permintaan_rumahsakit . "'";

            $db->delete('permintaan_rumahsakit', $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getJumlahStatusRumahsakit1() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_rumahsakit where status='1'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahStatusRumahsakit2() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_rumahsakit where status='2'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getSelesaiRumahsakit($data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("status" => $data['status'],
                "waktu_selesai" => $data['waktu_selesai'],
                "waktu_total" => $data['waktu_total']
            );

            $where[] = " id_permintaan_rumahsakit = '" . $data['id_permintaan_rumahsakit'] . "'";

            $db->update('permintaan_rumahsakit', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    ////////////////////////////////////////////////////////
    ////////////////////////////////////////////penduduk
    /////////////////////////////////////////////////////////
    public function getJumlahPenduduk($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from data_penduduk where id_kelurahan='$id_kelurahan'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahPendudukCari($id_pencarian, $pencarian, $id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from data_penduduk where id_kelurahan='$id_kelurahan' 
				AND '$id_pencarian' like '$pencarian%' ");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getCariPenduduk($id_pencarian, $pencarian, $id_kelurahan, $offset, $dataPerPage) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchAll("SELECT  * from data_penduduk 
				where id_kelurahan='$id_kelurahan' 
				AND $id_pencarian like '$pencarian%'
				order by nama asc
				LIMIT $offset , $dataPerPage
				");

            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getAllPenduduk($id_kelurahan, $offset, $dataPerPage) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchAll("SELECT  * from data_penduduk where id_kelurahan='$id_kelurahan' order by nama asc
				LIMIT $offset , $dataPerPage
				");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPenduduk($nik) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT  * from data_penduduk where nik = '$nik'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanpenduduk(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("no_kk" => $data['no_kk'],
                "nama_kep" => $data['nama_kep'],
                "alamat" => $data['alamat'],
                "rt" => $data['rt'],
                "rw" => $data['rw'],
                "dusun" => "Leuwigajah",
                "kode_pos" => $data['kode_pos'],
                "nik" => $data['nik'],
                "nama" => $data['nama'],
                "jenis_kelamin" => $data['jenis_kelamin'],
                "tempat_lahir" => $data['tempat_lahir'],
                "tanggal_lahir" => $data['tanggal_lahir'],
                "no_akta" => $data['no_akta'],
                "gol_darah" => $data['gol_darah'],
                "agama" => $data['agama'],
                "pekerjaan" => $data['pekerjaan'],
                "status_perkawinan" => $data['status_perkawinan'],
                "id_kelurahan" => $data['id_kelurahan']);

            $db->insert('data_penduduk', $paramInput);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getsimpanpendudukedit(array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("no_kk" => $data['no_kk'],
                "nama_kep" => $data['nama_kep'],
                "alamat" => $data['alamat'],
                "rt" => $data['rt'],
                "rw" => $data['rw'],
                "dusun" => $data['dusun'],
                "kode_pos" => $data['kode_pos'],
                "nik" => $data['nik'],
                "nama" => $data['nama'],
                "jenis_kelamin" => $data['jenis_kelamin'],
                "tempat_lahir" => $data['tempat_lahir'],
                "tanggal_lahir" => $data['tanggal_lahir'],
                "no_akta" => $data['no_akta'],
                "gol_darah" => $data['gol_darah'],
                "agama" => $data['agama'],
                "pekerjaan" => $data['pekerjaan'],
                "status_perkawinan" => $data['status_perkawinan'],
                "id_kelurahan" => $data['id_kelurahan']);

            $where[] = " nik = '" . $data['nik'] . "'";

            $db->update('data_penduduk', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function gethapuspenduduk($nik) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');

        try {
            $db->beginTransaction();
            $where[] = " nik = '" . $nik . "'";

            $db->delete('data_penduduk', $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    ////////////////////////////////////////////////////////
    //////////////////////////////////////////// Pengambilan
    /////////////////////////////////////////////////////////

    public function getAllPengambilan($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchAll("select an.id_surat, an.waktu_antrian,dp.nik,dp.nama,dp.alamat,an.no_registrasi, an.status, an.waktu_antrian, an.antrian_oleh,an.proses_oleh, di.nama_pengguna as nama_pegawai, an.waktu_proses,an.waktu_selesai, DATE_FORMAT(an.tgl_dibuat,'%d') as tanggal_surat 
				from data_penduduk dp, no_registrasi an,pengguna p, data_pegawai di
				where  an.status <> 4 AND
				an.nik=dp.nik 
				and p.id_data_pegawai = di.id_data_pegawai
				
				and (an.antrian_oleh = p.id_pengguna
				or an.proses_oleh = p.id_pengguna)				
				order by an.no_registrasi desc
				"); //and DATE_FORMAT(an.tgl_dibuat,'%d') = DAY(NOW())
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }
	
	public function getAllSudahPengambilan($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchAll("select dpn.nama_pengambil,dpn.waktu_ambil, dpn.petugas, an.id_surat, an.waktu_antrian,dp.nik,dp.nama,dp.alamat,an.no_registrasi, an.status, an.waktu_antrian, an.antrian_oleh,an.proses_oleh, di.nama_pengguna as nama_pegawai, an.waktu_proses,an.waktu_selesai, DATE_FORMAT(an.tgl_dibuat,'%d') as tanggal_surat 
				from data_penduduk dp, no_registrasi an,data_pengambilan dpn, pengguna p, data_pegawai di
				where  
				an.nik=dp.nik 
				and p.id_data_pegawai = di.id_data_pegawai
				and dpn.no_registrasi = an.no_registrasi
				and (an.antrian_oleh = p.id_pengguna
				or an.proses_oleh = p.id_pengguna)				
				order by an.no_registrasi desc
				"); //and DATE_FORMAT(an.tgl_dibuat,'%d') = DAY(NOW())
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPengambilan($no_registrasi) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("select an.id_surat, an.waktu_antrian,dp.nik,dp.nama,dp.alamat,an.no_registrasi, an.status, an.waktu_antrian, an.antrian_oleh,an.proses_oleh, di.nama_pengguna as nama_pegawai, an.waktu_proses,an.waktu_selesai, DATE_FORMAT(an.tgl_dibuat,'%d') as tanggal_surat 
				from data_penduduk dp, no_registrasi an,pengguna p, data_pegawai di
				where  an.status != '4' AND
				an.nik=dp.nik  AND
				p.id_data_pegawai = di.id_data_pegawai AND
				an.no_registrasi = '$no_registrasi'
				and (an.antrian_oleh = p.id_pengguna
				or an.proses_oleh = p.id_pengguna)				
				order by an.no_registrasi desc
				");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanpengambilanedit(array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("no_registrasi" => $data['no_registrasi'],
                "nama_pengambil" => $data['nama_pengambil'],
                "petugas" => $data['petugas'],
                "waktu_ambil" => $data['waktu_ambil']
            );

            $db->insert('data_pengambilan', $paramInput);
					
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];
            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

	public function getubahstatsupengambilan(array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $param = array("status" => 4);

            $where[] = " no_registrasi = '" . $data['no_registrasi'] . "'";

            $db->update('no_registrasi', $param, $where);
			
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());
			var_dump($errmsgArr);
            $errMsg = $errmsgArr[0];
            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    ///////////////////////////////////////////////

    public function getPejabatpemperdayaan($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT  * from pejabat_kelurahan where id_kelurahan = $id_kelurahan && id_jenis_pengguna = 3");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPejabattantrib($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT  * from pejabat_kelurahan where id_kelurahan = $id_kelurahan && id_jenis_pengguna = 3");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPejabatekbang($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT  * from pejabat_kelurahan where id_kelurahan = $id_kelurahan && id_jenis_pengguna = 3");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPejabatpemerintahan($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT  * from pejabat_kelurahan where id_kelurahan = $id_kelurahan && id_jenis_pengguna = 3");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPejabatAll($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchAll("SELECT  * from pejabat_kelurahan where id_kelurahan = $id_kelurahan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    ////////////////SEKOLAH
    //cetak surat sekolah
    public function getsekolahcetak($id_permintaan_sekolah) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getProsesSekolah($id_kelurahan, $offset, $dataPerPage) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahSekolah($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_sekolah where id_kelurahan=$id_kelurahan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPencarianSekolah($id_kelurahan, $pencarian, $id_pencarian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            if (!$pencarian) {
                $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_sekolah a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
            } else {
                if ($id_pencarian == 1) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_sekolah a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
                } else if ($id_pencarian == 2) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_sekolah a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
                }
            }
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //proses simpan antrian -> status menjadi 1
    public function getsimpansekolahantrian(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_pengguna" => $data['id_pengguna'],
                "id_kelurahan" => $data['id_kelurahan'],
                "no_registrasi" => $data['no_registrasi'],
                "nik" => $data['nik'],
                "waktu_antrian" => $data['waktu_antrian'],
                "antrian_oleh" => $data['antrian_oleh'],
                "jam_masuk" => $data['jam_masuk'],
                "status" => $data['status'],
                "no_telp" => $data['no_telp']
            );

            $db->insert('permintaan_sekolah', $paramInput);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getsimpanprosessekolah(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_pengguna" => $data['id_pengguna'],
                "id_kelurahan" => $data['id_kelurahan'],
                "id_jenis_surat" => $data['id_jenis_surat'],
                "id_surat" => $data['id_surat'],
                "id_pejabat" => $data['id_pejabat'],
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

            $where[] = " id_permintaan_sekolah = '" . $data['id_permintaan_sekolah'] . "'";

            $db->update('permintaan_sekolah', $paramInput, $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function gethapussekolah($id_permintaan_sekolah) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $where[] = " id_permintaan_sekolah = '" . $id_permintaan_sekolah . "'";

            $db->delete('permintaan_sekolah', $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getsekolah($id_permintaan_sekolah) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosessekolahedit(array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
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

            $where[] = " id_permintaan_sekolah = '" . $data['id_permintaan_sekolah'] . "'";

            $db->update('permintaan_sekolah', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getJumlahStatusSekolah1() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_sekolah where status='1'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahStatusSekolah2() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_sekolah where status='2'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getSelesaiSekolah($data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("status" => $data['status'],
                "waktu_selesai" => $data['waktu_selesai'],
                "waktu_total" => $data['waktu_total']
            );

            $where[] = " id_permintaan_sekolah = '" . $data['id_permintaan_sekolah'] . "'";

            $db->update('permintaan_sekolah', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    //----------------------------------- Keterangan ANDON NIKAH
    //cetak surat andonnikah
    public function getandonnikahcetak($id_permintaan_andonnikah) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //proses simpan antrian -> status menjadi 1
    public function getsimpanandonnikahantrian(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_pengguna" => $data['id_pengguna'],
                "id_kelurahan" => $data['id_kelurahan'],
                "no_registrasi" => $data['no_registrasi'],
                "nik" => $data['nik'],
                "waktu_antrian" => $data['waktu_antrian'],
                "antrian_oleh" => $data['antrian_oleh'],
                "jam_masuk" => $data['jam_masuk'],
                "status" => $data['status'],
                "no_telp" => $data['no_telp']
            );

            $db->insert('permintaan_andonnikah', $paramInput);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    //proses menampilkan untuk memproses antrian 
    public function getProsesAndonNikah($id_kelurahan, $offset, $dataPerPage) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_andonnikah a, data_penduduk b 
			WHERE a.id_kelurahan = '$id_kelurahan' AND a.nik = b.nik 
			ORDER BY  a.no_registrasi DESC 
			LIMIT $offset , $dataPerPage");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahAndonNikah($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_andonnikah where id_kelurahan=$id_kelurahan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPencarianAndonNikah($id_kelurahan, $pencarian, $id_pencarian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            if (!$pencarian) {
                $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_andonnikah a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
            } else {
                if ($id_pencarian == 1) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_andonnikah a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
                } else if ($id_pencarian == 2) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_andonnikah a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
                }
            }
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesandonnikah(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
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

            $where[] = " id_permintaan_andonnikah = '" . $data['id_permintaan_andonnikah'] . "'";

            $db->update('permintaan_andonnikah', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function gethapusandonnikah($id_permintaan_andonnikah) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $where[] = " id_permintaan_andonnikah = '" . $id_permintaan_andonnikah . "'";

            $db->delete('permintaan_andonnikah', $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getandonnikah($id_permintaan_andonnikah) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesandonnikahedit(array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
                "id_permintaan_andonnikah" => $data['id_permintaan_andonnikah'],
                "nik" => $data['nik'],
                "no_surat" => $data['no_surat'],
                "tanggal_surat" => $data['tanggal_surat'],
                "no_surat_pengantar" => $data['no_surat_pengantar'],
                "tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
                "nama_pasangan" => $data['nama_pasangan'],
                "alamat_pasangan" => $data['alamat_pasangan']);

            $where[] = " id_permintaan_andonnikah = '" . $data['id_permintaan_andonnikah'] . "'";

            $db->update('permintaan_andonnikah', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    //simpan selesai
    public function getSelesaiAndonnikah($data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("status" => $data['status'],
                "waktu_selesai" => $data['waktu_selesai'],
                "waktu_total" => $data['waktu_total']
            );

            $where[] = " id_permintaan_andonnikah = '" . $data['id_permintaan_andonnikah'] . "'";

            $db->update('permintaan_andonnikah', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getJumlahStatusAndonnikah1() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_andonnikah where status='1'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahStatusAndonnikah2() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_andonnikah where status='2'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    ///////////////////// KETERANGAN NIKAH
    //----------------------------------- Keterangan NA
    //cetak surat na
    public function getnacetak($id_permintaan_na) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //proses simpan antrian -> status menjadi 1
    public function getsimpannaantrian(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_pengguna" => $data['id_pengguna'],
                "id_kelurahan" => $data['id_kelurahan'],
                "no_registrasi" => $data['no_registrasi'],
                "nik" => $data['nik'],
                "waktu_antrian" => $data['waktu_antrian'],
                "antrian_oleh" => $data['antrian_oleh'],
                "jam_masuk" => $data['jam_masuk'],
                "status" => $data['status'],
                "no_telp" => $data['no_telp']
            );

            $db->insert('permintaan_na', $paramInput);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    //proses menampilkan untuk memproses antrian 
    public function getProsesNa($id_kelurahan, $offset, $dataPerPage) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_na a, data_penduduk b 
			WHERE a.id_kelurahan = '$id_kelurahan' AND a.nik = b.nik 
			ORDER BY  a.no_registrasi DESC 
			LIMIT $offset , $dataPerPage");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahna($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_na where id_kelurahan=$id_kelurahan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPencarianna($id_kelurahan, $pencarian, $id_pencarian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            if (!$pencarian) {
                $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_na a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
            } else {
                if ($id_pencarian == 1) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_na a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
                } else if ($id_pencarian == 2) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_na a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
                }
            }
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesna(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
                "nik" => $data['nik'],
                "id_pejabat" => $data['id_pejabat'],
                "id_jenis_surat" => $data['id_jenis_surat'],
                "id_surat" => $data['id_surat'],
                "no_surat" => $data['no_surat'],
                "tanggal_surat" => $data['tanggal_surat'],
                "no_surat_pengantar" => $data['no_surat_pengantar'],
                "tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
                "nama_istri" => $data['nama_istri'],
                "nama_ayah" => $data['nama_ayah'],
                "nama_ibu" => $data['nama_ibu'],
                "status" => $data['status'],
                "waktu_proses" => $data['waktu_proses'],
                "proses_oleh" => $data['proses_oleh'],
                "ket" => $data['ket']
            );

            $where[] = " id_permintaan_na = '" . $data['id_permintaan_na'] . "'";

            $db->update('permintaan_na', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function gethapusna($id_permintaan_na) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $where[] = " id_permintaan_na = '" . $id_permintaan_na . "'";

            $db->delete('permintaan_na', $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getna($id_permintaan_na) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesnaedit(array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array(
                "nik" => $data['nik'],
                "no_surat" => $data['no_surat'],
                "tanggal_surat" => $data['tanggal_surat'],
                "no_surat_pengantar" => $data['no_surat_pengantar'],
                "tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
                "nama_istri" => $data['nama_istri'],
                "nama_ayah" => $data['nama_ayah'],
                "nama_ibu" => $data['nama_ibu']);

            $where[] = " id_permintaan_na = '" . $data['id_permintaan_na'] . "'";

            $db->update('permintaan_na', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    //simpan selesai
    public function getSelesaina($data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("status" => $data['status'],
                "waktu_selesai" => $data['waktu_selesai'],
                "waktu_total" => $data['waktu_total']
            );

            $where[] = " id_permintaan_na = '" . $data['id_permintaan_na'] . "'";

            $db->update('permintaan_na', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getJumlahStatusna1() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_na where status='1'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahStatusna2() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_na where status='2'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    ////////////////////////////////////BELUM MENIKAH
    //cetak surat belum nikah cetak
    public function getbelummenikahcetak($id_permintaan_belummenikah) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //proses simpan antrian -> status menjadi 1
    public function getsimpanbelummenikahantrian(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_pengguna" => $data['id_pengguna'],
                "id_kelurahan" => $data['id_kelurahan'],
                "no_registrasi" => $data['no_registrasi'],
                "nik" => $data['nik'],
                "waktu_antrian" => $data['waktu_antrian'],
                "antrian_oleh" => $data['antrian_oleh'],
                "jam_masuk" => $data['jam_masuk'],
                "status" => $data['status'],
                "no_telp" => $data['no_telp']
            );

            $db->insert('permintaan_belummenikah', $paramInput);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getProsesBelumMenikah($id_kelurahan, $offset, $dataPerPage) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahbm($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_belummenikah where id_kelurahan=$id_kelurahan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPencarianBelumMenikah($id_kelurahan, $pencarian, $id_pencarian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            if (!$pencarian) {
                $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_belummenikah a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
            } else {
                if ($id_pencarian == 1) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_belummenikah a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
                } else if ($id_pencarian == 2) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_belummenikah a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
                }
            }
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesbelummenikah(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
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

            $where[] = " id_permintaan_belummenikah = '" . $data['id_permintaan_belummenikah'] . "'";

            $db->update('permintaan_belummenikah', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function gethapusbelummenikah($id_permintaan_belummenikah) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $where[] = " id_permintaan_belummenikah = '" . $id_permintaan_belummenikah . "'";

            $db->delete('permintaan_belummenikah', $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    // menampilkan keseluruhan  
    public function getbelummenikah($id_permintaan_belummenikah) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesbelummenikahedit(array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
                "id_permintaan_belummenikah" => $data['id_permintaan_belummenikah'],
                "nik" => $data['nik'],
                "no_surat" => $data['no_surat'],
                "tanggal_surat" => $data['tanggal_surat'],
                "no_surat_pengantar" => $data['no_surat_pengantar'],
                "tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
                "keperluan" => $data['keperluan']);

            $where[] = " id_permintaan_belummenikah = '" . $data['id_permintaan_belummenikah'] . "'";

            $db->update('permintaan_belummenikah', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getJumlahStatusbelummenikah1() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_belummenikah where status='1'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahStatusbelummenikah2() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_belummenikah where status='2'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //simpan selesai
    public function getSelesaiBelummenikah($data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("status" => $data['status'],
                "waktu_selesai" => $data['waktu_selesai'],
                "waktu_total" => $data['waktu_total']
            );

            $where[] = " id_permintaan_belummenikah = '" . $data['id_permintaan_belummenikah'] . "'";

            $db->update('permintaan_belummenikah', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    ////////////////////////////////////BELUM MEMPUNYAI RUMAH
    //cetak surat BPR
    public function getbprcetak($id_permintaan_bpr) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //proses simpan antrian -> status menjadi 1
    public function getsimpanbprantrian(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_pengguna" => $data['id_pengguna'],
                "id_kelurahan" => $data['id_kelurahan'],
                "no_registrasi" => $data['no_registrasi'],
                "nik" => $data['nik'],
                "waktu_antrian" => $data['waktu_antrian'],
                "antrian_oleh" => $data['antrian_oleh'],
                "jam_masuk" => $data['jam_masuk'],
                "status" => $data['status'],
                "no_telp" => $data['no_telp']
            );

            $db->insert('permintaan_bpr', $paramInput);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getProsesbpr($id_kelurahan, $offset, $dataPerPage) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahbpr($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_bpr where id_kelurahan=$id_kelurahan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPencarianbpr($id_kelurahan, $pencarian, $id_pencarian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            if (!$pencarian) {
                $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_bpr a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
            } else {
                if ($id_pencarian == 1) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_bpr a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
                } else if ($id_pencarian == 2) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_bpr a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
                }
            }
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesbpr(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
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

            $where[] = " id_permintaan_bpr = '" . $data['id_permintaan_bpr'] . "'";

            $db->update('permintaan_bpr', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function gethapusbpr($id_permintaan_bpr) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $where[] = " id_permintaan_bpr = '" . $id_permintaan_bpr . "'";

            $db->delete('permintaan_bpr', $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getbpr($id_permintaan_bpr) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*, b.*, c.* FROM permintaan_bpr a, data_penduduk b, pejabat_kelurahan c WHERE  a.nik = b.nik AND a.id_permintaan_bpr = $id_permintaan_bpr");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesbpredit(array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
                "id_permintaan_bpr" => $data['id_permintaan_bpr'],
                "nik" => $data['nik'],
                "no_surat" => $data['no_surat'],
                "tanggal_surat" => $data['tanggal_surat'],
                "no_surat_pengantar" => $data['no_surat_pengantar'],
                "tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
                "keperluan" => $data['keperluan'],
                "stl" => $data['stl']);

            $where[] = " id_permintaan_bpr = '" . $data['id_permintaan_bpr'] . "'";

            $db->update('permintaan_bpr', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getJumlahStatusbpr1() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_bpr where status='1'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahStatusbpr2() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_bpr where status='2'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //simpan selesai
    public function getSelesaiBpr($data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("status" => $data['status'],
                "waktu_selesai" => $data['waktu_selesai'],
                "waktu_total" => $data['waktu_total']
            );

            $where[] = " id_permintaan_bpr = '" . $data['id_permintaan_bpr'] . "'";

            $db->update('permintaan_bpr', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    ////////////////////////////////////IBADAH HAJI
    //cetak surat ibadah haji
    public function getibadahhajicetak($id_permintaan_ibadahhaji) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //proses simpan antrian -> status menjadi 1
    public function getsimpanibadahhajiantrian(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_pengguna" => $data['id_pengguna'],
                "id_kelurahan" => $data['id_kelurahan'],
                "no_registrasi" => $data['no_registrasi'],
                "nik" => $data['nik'],
                "waktu_antrian" => $data['waktu_antrian'],
                "antrian_oleh" => $data['antrian_oleh'],
                "jam_masuk" => $data['jam_masuk'],
                "status" => $data['status'],
                "no_telp" => $data['no_telp']
            );

            $db->insert('permintaan_ibadahhaji', $paramInput);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getProsesibadahhaji($id_kelurahan, $offset, $dataPerPage) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahih($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_ibadahhaji where id_kelurahan=$id_kelurahan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPencarianib($id_kelurahan, $pencarian, $id_pencarian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            if (!$pencarian) {
                $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_ibadahhaji a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
            } else {
                if ($id_pencarian == 1) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_ibadahhaji a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
                } else if ($id_pencarian == 2) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_ibadahhaji a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
                }
            }
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesibadahhaji(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
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

            $where[] = " id_permintaan_ibadahhaji = '" . $data['id_permintaan_ibadahhaji'] . "'";

            $db->update('permintaan_ibadahhaji', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function gethapusibadahhaji($id_permintaan_ibadahhaji) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $where[] = " id_permintaan_ibadahhaji = '" . $id_permintaan_ibadahhaji . "'";

            $db->delete('permintaan_ibadahhaji', $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getibadahhaji($id_permintaan_ibadahhaji) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*, b.*, c.* 
			FROM permintaan_ibadahhaji a, data_penduduk b, pejabat_kelurahan c 
			WHERE  a.nik = b.nik  AND a.id_permintaan_ibadahhaji = $id_permintaan_ibadahhaji");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesibadahhajiedit(array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array(
                "no_surat" => $data['no_surat'],
                "tanggal_surat" => $data['tanggal_surat'],
                "no_surat_pengantar" => $data['no_surat_pengantar'],
                "tanggal_surat_pengantar" => $data['tanggal_surat_pengantar']
            );

            $where[] = " id_permintaan_ibadahhaji = '" . $data['id_permintaan_ibadahhaji'] . "'";

            $db->update('permintaan_ibadahhaji', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getJumlahStatusibadahhaji1() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_ibadahhaji where status='1'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahStatusibadahhaji2() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_ibadahhaji where status='2'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //simpan selesai
    public function getSelesaiIbadahhaji($data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("status" => $data['status'],
                "waktu_selesai" => $data['waktu_selesai'],
                "waktu_total" => $data['waktu_total']
            );

            $where[] = " id_permintaan_ibadahhaji = '" . $data['id_permintaan_ibadahhaji'] . "'";

            $db->update('permintaan_ibadahhaji', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    ////////////////////////////////////JANDA
    //cetak surat Janda
    public function getjandacetak($id_permintaan_janda) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //proses simpan antrian -> status menjadi 1
    public function getsimpanjandaantrian(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_pengguna" => $data['id_pengguna'],
                "id_kelurahan" => $data['id_kelurahan'],
                "no_registrasi" => $data['no_registrasi'],
                "nik" => $data['nik'],
                "waktu_antrian" => $data['waktu_antrian'],
                "antrian_oleh" => $data['antrian_oleh'],
                "jam_masuk" => $data['jam_masuk'],
                "status" => $data['status'],
                "no_telp" => $data['no_telp']
            );

            $db->insert('permintaan_janda', $paramInput);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getProsesjanda($id_kelurahan, $offset, $dataPerPage) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_janda a, data_penduduk b 
			WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik 
			order by a.no_registrasi desc, a.tanggal_surat desc LIMIT $offset , $dataPerPage");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahJanda($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_janda where id_kelurahan=$id_kelurahan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPencarianjanda($id_kelurahan, $pencarian, $id_pencarian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            if (!$pencarian) {
                $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_janda a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik LIMIT 0 , 30");
            } else {
                if ($id_pencarian == 1) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_janda a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik AND a.no_surat = '$pencarian'  LIMIT 0 , 30");
                } else if ($id_pencarian == 2) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_janda a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
                }
            }
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesjanda(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
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

            $where[] = " id_permintaan_janda= '" . $data['id_permintaan_janda'] . "'";

            $db->update('permintaan_janda', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function gethapusjanda($id_permintaan_janda) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $where[] = " id_permintaan_janda = '" . $id_permintaan_janda . "'";

            $db->delete('permintaan_janda', $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getjanda($id_permintaan_janda) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesjandaedit(array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
                "id_permintaan_janda" => $data['id_permintaan_janda'],
                "nik" => $data['nik'],
                "no_surat" => $data['no_surat'],
                "tanggal_surat" => $data['tanggal_surat'],
                "no_surat_pengantar" => $data['no_surat_pengantar'],
                "tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
                "sebab_janda" => $data['sebab_janda'],
                "keperluan" => $data['keperluan']);

            $where[] = " id_permintaan_janda = '" . $data['id_permintaan_janda'] . "'";

            $db->update('permintaan_janda', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getJumlahStatusjanda1() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_janda where status='1'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahStatusjanda2() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_janda where status='2'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //simpan selesai
    public function getSelesaiJanda($data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("status" => $data['status'],
                "waktu_selesai" => $data['waktu_selesai'],
                "waktu_total" => $data['waktu_total']
            );

            $where[] = " id_permintaan_janda = '" . $data['id_permintaan_janda'] . "'";

            $db->update('permintaan_janda', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    ////////////////////////////////////IJIN KERAMAIAN
    //cetak surat Ijin Keramaian
    public function getikcetak($id_permintaan_ik) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //proses simpan antrian -> status menjadi 1
    public function getsimpanikantrian(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_pengguna" => $data['id_pengguna'],
                "id_kelurahan" => $data['id_kelurahan'],
                "no_registrasi" => $data['no_registrasi'],
                "nik" => $data['nik'],
                "waktu_antrian" => $data['waktu_antrian'],
                "antrian_oleh" => $data['antrian_oleh'],
                "jam_masuk" => $data['jam_masuk'],
                "status" => $data['status'],
                "no_telp" => $data['no_telp']
            );

            $db->insert('permintaan_ik', $paramInput);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getProsesik($id_kelurahan, $offset, $dataPerPage) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahik($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_ik where id_kelurahan=$id_kelurahan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPencarianik($id_kelurahan, $pencarian, $id_pencarian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            if (!$pencarian) {
                $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_ik a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
            } else {
                if ($id_pencarian == 1) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_ik a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
                } else if ($id_pencarian == 2) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_ik a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
                }
            }
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesik(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
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


            $where[] = " id_permintaan_ik = '" . $data['id_permintaan_ik'] . "'";

            $db->update('permintaan_ik', $paramInput, $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function gethapusik($id_permintaan_ik) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $where[] = " id_permintaan_ik = '" . $id_permintaan_ik . "'";

            $db->delete('permintaan_ik', $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getik($id_permintaan_ik) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesikedit(array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
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

            $where[] = " id_permintaan_ik = '" . $data['id_permintaan_ik'] . "'";

            $db->update('permintaan_ik', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getJumlahStatusik1() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_ik where status='1'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahStatusik2() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_ik where status='2'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //simpan selesai
    public function getSelesaiIk($data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("status" => $data['status'],
                "waktu_selesai" => $data['waktu_selesai'],
                "waktu_total" => $data['waktu_total']
            );

            $where[] = " id_permintaan_ik = '" . $data['id_permintaan_ik'] . "'";

            $db->update('permintaan_ik', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    ////////////////////////////////////BELUM Pengantar SKCK
    //cetak surat Pengantar SKCK
    public function getpscetak($id_permintaan_ps) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //proses simpan antrian -> status menjadi 1
    public function getsimpanpsantrian(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_pengguna" => $data['id_pengguna'],
                "id_kelurahan" => $data['id_kelurahan'],
                "no_registrasi" => $data['no_registrasi'],
                "nik" => $data['nik'],
                "waktu_antrian" => $data['waktu_antrian'],
                "antrian_oleh" => $data['antrian_oleh'],
                "jam_masuk" => $data['jam_masuk'],
                "status" => $data['status'],
                "no_telp" => $data['no_telp']
            );

            $db->insert('permintaan_ps', $paramInput);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getProsesps($id_kelurahan, $offset, $dataPerPage) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahps($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_ps where id_kelurahan=$id_kelurahan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPencarianps($id_kelurahan, $pencarian, $id_pencarian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            if (!$pencarian) {
                $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_ps a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
            } else {
                if ($id_pencarian == 1) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_ps a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
                } else if ($id_pencarian == 2) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_ps a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
                }
            }
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesps(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
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

            $where[] = " id_permintaan_ps = '" . $data['id_permintaan_ps'] . "'";

            $db->update('permintaan_ps', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function gethapusps($id_permintaan_ps) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $where[] = " id_permintaan_ps = '" . $id_permintaan_ps . "'";

            $db->delete('permintaan_ps', $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getps($id_permintaan_ps) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosespsedit(array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
                "id_permintaan_ps" => $data['id_permintaan_ps'],
                "no_surat" => $data['no_surat'],
                "tanggal_surat" => $data['tanggal_surat'],
                "no_surat_pengantar" => $data['no_surat_pengantar'],
                "tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
                "keperluan" => $data['keperluan']);

            $where[] = " id_permintaan_ps = '" . $data['id_permintaan_ps'] . "'";

            $db->update('permintaan_ps', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getJumlahStatusps1() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_ps where status='1'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahStatusps2() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_ps where status='2'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //simpan selesai
    public function getSelesaiPs($data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("status" => $data['status'],
                "waktu_selesai" => $data['waktu_selesai'],
                "waktu_total" => $data['waktu_total']
            );

            $where[] = " id_permintaan_ps = '" . $data['id_permintaan_ps'] . "'";

            $db->update('permintaan_ps', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    ////////////////////////////////////BERSIH DIRI
    //cetak surat Bersih Diri
    public function getbdcetak($id_permintaan_bd) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //proses simpan antrian -> status menjadi 1
    public function getsimpanbdantrian(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_pengguna" => $data['id_pengguna'],
                "id_kelurahan" => $data['id_kelurahan'],
                "no_registrasi" => $data['no_registrasi'],
                "nik" => $data['nik'],
                "waktu_antrian" => $data['waktu_antrian'],
                "antrian_oleh" => $data['antrian_oleh'],
                "jam_masuk" => $data['jam_masuk'],
                "status" => $data['status'],
                "no_telp" => $data['no_telp']
            );

            $db->insert('permintaan_bd', $paramInput);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getProsesbd($id_kelurahan, $offset, $dataPerPage) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahbd($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_bd where id_kelurahan=$id_kelurahan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPencarianbd($id_kelurahan, $pencarian, $id_pencarian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            if (!$pencarian) {
                $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_bd a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
            } else {
                if ($id_pencarian == 1) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_bd a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
                } else if ($id_pencarian == 2) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_bd a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
                }
            }
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesbd(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
                "nik" => $data['nik'],
                "id_pejabat" => $data['id_pejabat'],
                "id_jenis_surat" => $data['id_jenis_surat'],
                "id_surat" => $data['id_surat'],
                "nama_ayah" => $data['nama_ayah'],
                "tempat_lahir_ayah" => $data['tempat_lahir_ayah'],
                "tanggal_lahir_ayah" => $data['tanggal_lahir_ayah'],
                "alamat_ayah" => $data['alamat_ayah'],
                "pekerjaan_ayah" => $data['pekerjaan_ayah'],
                "agama_ayah" => $data['agama_ayah'],
                "nama_ibu" => $data['nama_ibu'],
                "tempat_lahir_ibu" => $data['tempat_lahir_ibu'],
                "tanggal_lahir_ibu" => $data['tanggal_lahir_ibu'],
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

            $where[] = " id_permintaan_bd = '" . $data['id_permintaan_bd'] . "'";

            $db->update('permintaan_bd', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function gethapusbd($id_permintaan_bd) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $where[] = " id_permintaan_bd = '" . $id_permintaan_bd . "'";

            $db->delete('permintaan_bd', $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getbd($id_permintaan_bd) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesbdedit(array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array(
                "nama_ayah" => $data['nama_ayah'],
                "tempat_lahir_ayah" => $data['tempat_lahir_ayah'],
                "tanggal_lahir_ayah" => $data['tanggal_lahir_ayah'],
                "alamat_ayah" => $data['alamat_ayah'],
                "pekerjaan_ayah" => $data['pekerjaan_ayah'],
                "agama_ayah" => $data['agama_ayah'],
                "nama_ibu" => $data['nama_ibu'],
                "tempat_lahir_ibu" => $data['tempat_lahir_ibu'],
                "tanggal_lahir_ibu" => $data['tanggal_lahir_ibu'],
                "agama_ibu" => $data['agama_ibu'],
                "alamat_ibu" => $data['alamat_ibu'],
                "pekerjaan_ibu" => $data['pekerjaan_ibu'],
                "no_surat" => $data['no_surat'],
                "tanggal_surat" => $data['tanggal_surat'],
                "no_surat_pengantar" => $data['no_surat_pengantar'],
                "tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
                "keperluan" => $data['keperluan']);

            $where[] = " id_permintaan_bd = '" . $data['id_permintaan_bd'] . "'";

            $db->update('permintaan_bd', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getJumlahStatusbd1() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_bd where status='1'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahStatusbd2() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_bd where status='2'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //simpan selesai
    public function getSelesaiBd($data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("status" => $data['status'],
                "waktu_selesai" => $data['waktu_selesai'],
                "waktu_total" => $data['waktu_total']
            );

            $where[] = " id_permintaan_bd = '" . $data['id_permintaan_bd'] . "'";

            $db->update('permintaan_bd', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    //////////////////////DOMISILI YAYASAN
    //cetak surat domisiliyayasan
    public function getdomisiliyayasancetak($id_permintaan_domisili_yayasan) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //proses simpan antrian -> status menjadi 1
    public function getsimpandomisiliyayasanantrian(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_pengguna" => $data['id_pengguna'],
                "id_kelurahan" => $data['id_kelurahan'],
                "no_registrasi" => $data['no_registrasi'],
                "nik" => $data['nik'],
                "waktu_antrian" => $data['waktu_antrian'],
                "antrian_oleh" => $data['antrian_oleh'],
                "jam_masuk" => $data['jam_masuk'],
                "status" => $data['status'],
                "no_telp" => $data['no_telp']
            );

            $db->insert('permintaan_domisili_yayasan', $paramInput);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getProsesdomisiliyayasan($id_kelurahan, $offset, $dataPerPage) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahdomisiliyayasan($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_domisili_yayasan where id_kelurahan=$id_kelurahan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPencarianDomisiliYayasan($id_kelurahan, $pencarian, $id_pencarian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            if (!$pencarian) {
                $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_domisili_yayasan a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
            } else {
                if ($id_pencarian == 1) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_domisili_yayasan a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
                } else if ($id_pencarian == 2) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_domisili_yayasan a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
                }
            }
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesdomisiliyayasan(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
                "nik" => $data['nik'],
                "id_pejabat" => $data['id_pejabat'],
                "id_jenis_surat" => $data['id_jenis_surat'],
                "id_surat" => $data['id_surat'],
                "no_surat" => $data['no_surat'],
                "tanggal_surat" => $data['tanggal_surat'],
                "no_surat_pengantar" => $data['no_surat_pengantar'],
                "tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
                "keperluan" => $data['keperluan'],
                //yang beda															
                "nama_yayasan" => $data['nama_yayasan'],
                "alamat_yayasan" => $data['alamat_yayasan'],
                "no_akta_notaris" => $data['no_akta_notaris'],
                "notaris" => $data['notaris'],
                "nama_ketua" => $data['nama_ketua'],
                "nama_sekretaris" => $data['nama_sekretaris'],
                "nama_bendahara" => $data['nama_bendahara'],
                "status" => $data['status'],
                "waktu_proses" => $data['waktu_proses'],
                "proses_oleh" => $data['proses_oleh'],
                "ket" => $data['ket']);

            $where[] = " id_permintaan_domisili_yayasan = '" . $data['id_permintaan_domisili_yayasan'] . "'";

            $db->update('permintaan_domisili_yayasan', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function gethapusdomisiliyayasan($id_permintaan_domisili_yayasan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');

        try {
            $db->beginTransaction();
            $where[] = " id_permintaan_domisili_yayasan = '" . $id_permintaan_domisili_yayasan . "'";

            $db->delete('permintaan_domisili_yayasan', $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getdomisiliyayasan($id_permintaan_domisili_yayasan) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesdomisiliyayasanedit(array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
                "id_permintaan_domisili_yayasan" => $data['id_permintaan_domisili_yayasan'],
                "nik" => $data['nik'],
                "no_surat" => $data['no_surat'],
                "tanggal_surat" => $data['tanggal_surat'],
                "no_surat_pengantar" => $data['no_surat_pengantar'],
                "tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
                "nama_yayasan" => $data['nama_yayasan'],
                "alamat_yayasan" => $data['alamat_yayasan'],
                "no_akta_notaris" => $data['no_akta_notaris'],
                "notaris" => $data['notaris'],
                "nama_ketua" => $data['nama_ketua'],
                "nama_sekretaris" => $data['nama_sekretaris'],
                "nama_bendahara" => $data['nama_bendahara']);

            $where[] = " id_permintaan_domisili_yayasan = '" . $data['id_permintaan_domisili_yayasan'] . "'";

            $db->update('permintaan_domisili_yayasan', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getJumlahStatusDomisiliyayasan1() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_domisili_yayasan where status='1'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahStatusDomisiliyayasan2() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_domisili_yayasan where status='2'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //simpan selesai
    public function getSelesaiDomisiliyayasan($data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("status" => $data['status'],
                "waktu_selesai" => $data['waktu_selesai'],
                "waktu_total" => $data['waktu_total']
            );

            $where[] = " id_permintaan_domisili_yayasan = '" . $data['id_permintaan_domisili_yayasan'] . "'";

            $db->update('permintaan_domisili_yayasan', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    //////////////////////DOMISILI PARPOL
    //cetak surat domisili parpol
    public function getdomisiliparpolcetak($id_permintaan_domisili_parpol) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //proses simpan antrian -> status menjadi 1
    public function getsimpandomisiliparpolantrian(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_pengguna" => $data['id_pengguna'],
                "id_kelurahan" => $data['id_kelurahan'],
                "no_registrasi" => $data['no_registrasi'],
                "nik" => $data['nik'],
                "waktu_antrian" => $data['waktu_antrian'],
                "antrian_oleh" => $data['antrian_oleh'],
                "jam_masuk" => $data['jam_masuk'],
                "status" => $data['status'],
                "no_telp" => $data['no_telp']
            );

            $db->insert('permintaan_domisili_parpol', $paramInput);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getProsesdomisiliparpol($id_kelurahan, $offset, $dataPerPage) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahdomisiliparpol($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_domisili_parpol where id_kelurahan=$id_kelurahan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPencarianDomisiliParpol($id_kelurahan, $pencarian, $id_pencarian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            if (!$pencarian) {
                $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_domisili_parpol a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
            } else {
                if ($id_pencarian == 1) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_domisili_parpol a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
                } else if ($id_pencarian == 2) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_domisili_parpol a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
                }
            }
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesdomisiliparpol(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
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


            $where[] = " id_permintaan_domisili_parpol = '" . $data['id_permintaan_domisili_parpol'] . "'";

            $db->update('permintaan_domisili_parpol', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function gethapusdomisiliparpol($id_permintaan_domisili_parpol) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $where[] = " id_permintaan_domisili_parpol = '" . $id_permintaan_domisili_parpol . "'";

            $db->delete('permintaan_domisili_parpol', $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getdomisiliparpol($id_permintaan_domisili_parpol) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesdomisiliparpoledit(array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
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

            $where[] = " id_permintaan_domisili_parpol = '" . $data['id_permintaan_domisili_parpol'] . "'";

            $db->update('permintaan_domisili_parpol', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getJumlahStatusDomisiliparpol1() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_domisili_parpol where status='1'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahStatusDomisiliparpol2() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_domisili_parpol where status='2'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //simpan selesai
    public function getSelesaiDomisiliparpol($data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("status" => $data['status'],
                "waktu_selesai" => $data['waktu_selesai'],
                "waktu_total" => $data['waktu_total']
            );

            $where[] = " id_permintaan_domisili_parpol = '" . $data['id_permintaan_domisili_parpol'] . "'";

            $db->update('permintaan_domisili_parpol', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    //////////////////////DOMISILI PERUSAHAAN
    //cetak surat domisili perusahaan
    public function getdomisiliperusahaancetak($id_permintaan_domisili_perusahaan) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //proses simpan antrian -> status menjadi 1
    public function getsimpandomisiliperusahaanantrian(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array(
                "id_kelurahan" => $data['id_kelurahan'],
                "no_registrasi" => $data['no_registrasi'],
                "nik" => $data['nik'],
                "waktu_antrian" => $data['waktu_antrian'],
                "antrian_oleh" => $data['antrian_oleh'],
                "jam_masuk" => $data['jam_masuk'],
                "status" => $data['status'],
                "no_telp" => $data['no_telp']
            );

            $db->insert('permintaan_domisili_perusahaan', $paramInput);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getProsesdomisiliperusahaan($id_kelurahan, $offset, $dataPerPage) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahdomisiliperusahaan($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_domisili_perusahaan where id_kelurahan=$id_kelurahan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPencarianDomisiliPerusahaan($id_kelurahan, $pencarian, $id_pencarian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            if (!$pencarian) {
                $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_domisili_perusahaan a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
            } else {
                if ($id_pencarian == 1) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_domisili_perusahaan a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
                } else if ($id_pencarian == 2) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_domisili_perusahaan a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
                }
            }
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesdomisiliperusahaan(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
                "nik" => $data['nik'],
                "id_pejabat" => $data['id_pejabat'],
                "no_surat" => $data['no_surat'],
                "id_jenis_surat" => $data['id_jenis_surat'],
                "id_surat" => $data['id_surat'],
                "tanggal_surat" => $data['tanggal_surat'],
                "no_surat_pengantar" => $data['no_surat_pengantar'],
                "tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
                "jabatan" => $data['jabatan'],
                "nama_perusahaan" => $data['nama_perusahaan'],
                "akta_pendirian_perusahaan" => $data['akta_pendirian_perusahaan'],
                "bergerak_bidang" => $data['bergerak_bidang'],
                "jumlah_pegawai" => $data['jumlah_pegawai'],
                "jam_kerja" => $data['jam_kerja'],
                "alamat_usaha" => $data['alamat_usaha'],
                "notaris" => $data['notaris'],
                "telp_kantor" => $data['telp_kantor'],
                "status" => $data['status'],
                "waktu_proses" => $data['waktu_proses'],
                "proses_oleh" => $data['proses_oleh'],
                "keperluan" => $data['keperluan'],
                "ket" => $data['ket']);

            $where[] = " id_permintaan_domisili_perusahaan = '" . $data['id_permintaan_domisili_perusahaan'] . "'";

            $db->update('permintaan_domisili_perusahaan', $paramInput, $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function gethapusdomisiliperusahaan($id_permintaan_domisili_perusahaan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $where[] = " id_permintaan_domisili_perusahaan = '" . $id_permintaan_domisili_perusahaan . "'";

            $db->delete('permintaan_domisili_perusahaan', $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getdomisiliperusahaan($id_permintaan_domisili_perusahaan) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesdomisiliperusahaanedit(array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array(
                "no_surat" => $data['no_surat'],
                "jenis_perusahaan" => $data['jenis_perusahaan'],
                "jumlah_pegawai" => $data['jumlah_pegawai'],
                "tanggal_surat" => $data['tanggal_surat'],
                "no_surat_pengantar" => $data['no_surat_pengantar'],
                "tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
                "keperluan" => $data['keperluan'],
                "jabatan" => $data['jabatan'],
                "nama_perusahaan" => $data['nama_perusahaan'],
                "akta_pendirian_perusahaan" => $data['akta_pendirian_perusahaan'],
                "bergerak_bidang" => $data['bergerak_bidang'],
                "jumlah_pegawai" => $data['jumlah_pegawai'],
                "jam_kerja" => $data['jam_kerja'],
                "alamat_usaha" => $data['alamat_usaha'],
                "notaris" => $data['notaris'],
                "telp_kantor" => $data['telp_kantor']
            );

            $where[] = " id_permintaan_domisili_perusahaan = '" . $data['id_permintaan_domisili_perusahaan'] . "'";

            $db->update('permintaan_domisili_perusahaan', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getJumlahStatusDomisiliperusahaan1() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_domisili_perusahaan where status='1'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahStatusDomisiliperusahaan2() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_domisili_perusahaan where status='2'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //simpan selesai
    public function getSelesaiDomisiliperusahaan($data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("status" => $data['status'],
                "waktu_selesai" => $data['waktu_selesai'],
                "waktu_total" => $data['waktu_total']
            );

            $where[] = " id_permintaan_domisili_perusahaan = '" . $data['id_permintaan_domisili_perusahaan'] . "'";

            $db->update('permintaan_domisili_perusahaan', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    //////////////////////KETERANGAN TEMPAT USAHA
    //cetak surat domisili perusahaan
    public function getketerangantempatusahacetak($id_permintaan_keterangan_tempat_usaha) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*, k.alamat as alamat_kelurahan, b.alamat as alamat_warga
			FROM permintaan_keterangan_tempat_usaha a, data_penduduk b, pejabat_kelurahan c, kelurahan k
			E  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
			AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_keterangan_tempat_usaha = $id_permintaan_keterangan_tempat_usaha");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //		proses simpan antrian -> status menjadi 1
    public function getsimpanketerangantempatusahaantrian(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_pengguna" => $data['id_pengguna'],
                "id_kelurahan" => $data['id_kelurahan'],
                "no_registrasi" => $data['no_registrasi'],
                "nik" => $data['nik'],
                "waktu_antrian" => $data['waktu_antrian'],
                "antrian_oleh" => $data['antrian_oleh'],
                "jam_masuk" => $data['jam_masuk'],
                "status" => $data['status'],
                "no_telp" => $data['no_telp']
            );

            $db->insert('permintaan_keterangan_tempat_usaha', $paramInput);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getProsesketerangantempatusaha($id_kelurahan, $offset, $dataPerPage) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahketerangantempatusaha($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_keterangan_tempat_usaha where id_kelurahan=$id_kelurahan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPencarianKeteranganTempatUsaha($id_kelurahan, $pencarian, $id_pencarian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            if (!$pencarian) {
                $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_keterangan_tempat_usaha a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
            } else {
                if ($id_pencarian == 1) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_keterangan_tempat_usaha a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
                } else if ($id_pencarian == 2) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_keterangan_tempat_usaha a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
                }
            }
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesketerangantempatusaha(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
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
                "status" => $data['status'],
                "waktu_proses" => $data['waktu_proses'],
                "proses_oleh" => $data['proses_oleh'],
                "ket" => $data['ket']);

            $where[] = " id_permintaan_keterangan_tempat_usaha = '" . $data['id_permintaan_keterangan_tempat_usaha'] . "'";

            $db->update('permintaan_keterangan_tempat_usaha', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function gethapusketerangantempatusaha($id_permintaan_keterangan_tempat_usaha) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $where[] = " id_permintaan_keterangan_tempat_usaha = '" . $id_permintaan_keterangan_tempat_usaha . "'";

            $db->delete('permintaan_keterangan_tempat_usaha', $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getketerangantempatusaha($id_permintaan_keterangan_tempat_usaha) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*, b.*, c.* 
			FROM permintaan_keterangan_tempat_usaha a, data_penduduk b, pejabat_kelurahan c 
			WHERE  a.nik = b.nik AND a.id_permintaan_keterangan_tempat_usaha = $id_permintaan_keterangan_tempat_usaha");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesketerangantempatusahaedit(array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
                "id_permintaan_keterangan_tempat_usaha" => $data['id_permintaan_keterangan_tempat_usaha'],
                "nik" => $data['nik'],
                "no_surat" => $data['no_surat'],
                "tanggal_surat" => $data['tanggal_surat'],
                "no_surat_pengantar" => $data['no_surat_pengantar'],
                "bidang_usaha" => $data['bidang_usaha'],
                "alamat_usaha" => $data['alamat_usaha'],
                "tanggal_surat_pengantar" => $data['tanggal_surat_pengantar']);

            $where[] = " id_permintaan_keterangan_tempat_usaha = '" . $data['id_permintaan_keterangan_tempat_usaha'] . "'";

            $db->update('permintaan_keterangan_tempat_usaha', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getJumlahStatusKeterangantempatusaha1() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_keterangan_tempat_usaha where status='1'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahStatusKeterangantempatusaha2() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_keterangan_tempat_usaha where status='2'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //		simpan selesai
    public function getSelesaiKeterangantempatusaha($data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("status" => $data['status'],
                "waktu_selesai" => $data['waktu_selesai'],
                "waktu_total" => $data['waktu_total']
            );

            $where[] = " id_permintaan_keterangan_tempat_usaha = '" . $data['id_permintaan_keterangan_tempat_usaha'] . "'";

            $db->update('permintaan_keterangan_tempat_usaha', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    ////////////////////////////////////lahir lama
    //		cetak surat keterangan kelahiran lama
    public function getlahircetak($id_permintaan_lahir) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*
			FROM permintaan_lahir a, data_penduduk b, pejabat_kelurahan c, kelurahan k
			WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
			AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_lahir = '$id_permintaan_lahir'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //		proses simpan antrian -> status menjadi 1
    public function getsimpanlahirantrian(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_pengguna" => $data['id_pengguna'],
                "id_kelurahan" => $data['id_kelurahan'],
                "no_registrasi" => $data['no_registrasi'],
                "nik" => $data['nik'],
                "waktu_antrian" => $data['waktu_antrian'],
                "antrian_oleh" => $data['antrian_oleh'],
                "jam_masuk" => $data['jam_masuk'],
                "status" => $data['status'],
                "no_telp" => $data['no_telp']
            );

            $db->insert('permintaan_lahir', $paramInput);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getProseslahir($id_kelurahan, $offset, $dataPerPage) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahlahir($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_lahir where id_kelurahan=$id_kelurahan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPencarianlahir($id_kelurahan, $pencarian, $id_pencarian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            if (!$pencarian) {
                $result = $db->fetchAll("SELECT  id_permintaan_lahir, no_surat, tanggal_surat, nik, rt, status FROM permintaan_lahir WHERE id_kelurahan = $id_kelurahan  LIMIT 0 , 30");
            } else {
                if ($id_pencarian == 1) {
                    $result = $db->fetchAll("SELECT  id_permintaan_lahir, no_surat, tanggal_surat, nik, rt, status FROM permintaan_lahir WHERE id_kelurahan = $id_kelurahan && no_surat = '$pencarian'  LIMIT 0 , 30");
                } else if ($id_pencarian == 2) {
                    $result = $db->fetchAll("SELECT  id_permintaan_lahir, no_surat, tanggal_surat, nik, rt, status 
			FROM permintaan_lahir WHERE id_kelurahan = $id_kelurahan && nik = '$pencarian'  LIMIT 0 , 30");
                }
            }
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanproseslahir(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
                "nik" => $data['nik'],
                "id_pejabat" => $data['id_pejabat'],
                "id_jenis_surat" => $data['id_jenis_surat'],
                "id_surat" => $data['id_surat'],
                "tanggal_surat" => $data['tanggal_surat'],
                "no_surat_pengantar" => $data['no_surat_pengantar'],
                "tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
                //data anak
                "nama_anak" => $data['nama_anak'],
                "jenis_kelamin_anak" => $data['jenis_kelamin_anak'],
                "tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
                "tempat_lahir_anak" => $data['tempat_lahir_anak'],
                "tgl_lahir_anak" => $data['tgl_lahir_anak'],
                "anak_ke" => $data['anak_ke'],
                "jam_lahir" => $data['jam_lahir'],
                "hari_lahir" => $data['hari_lahir'],
                //data orang tua
                "nama_ayah" => $data['nama_ayah'],
                "agama_ayah" => $data['agama_ayah'],
                "pekerjaan_ayah" => $data['pekerjaan_ayah'],
                "alamat_ayah" => $data['alamat_ayah'],
                "umur_ayah" => $data['umur_ayah'],
                "nama_ibu" => $data['nama_ibu'],
                "agama_ibu" => $data['agama_ibu'],
                "pekerjaan_ibu" => $data['pekerjaan_ibu'],
                "alamat_ibu" => $data['alamat_ibu'],
                "umur_ibu" => $data['umur_ibu'],
                "status" => $data['status'],
                "waktu_proses" => $data['waktu_proses'],
                "proses_oleh" => $data['proses_oleh'],
                "ket" => $data['ket']);

            $where[] = " id_permintaan_lahir = '" . $data['id_permintaan_lahir'] . "'";

            $db->update('permintaan_lahir', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function gethapuslahir($id_permintaan_lahir) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');


        try {
            $db->beginTransaction();
            $where[] = " id_permintaan_lahir = '" . $id_permintaan_lahir . "'";

            $db->delete('permintaan_lahir', $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getlahir($id_permintaan_lahir) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanlahiredit(array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
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
                "jam_lahir" => $data['jam_lahir'],
                "hari_lahir" => $data['hari_lahir'],
                //data orang tua
                "nama_ayah" => $data['nama_ayah'],
                "agama_ayah" => $data['agama_ayah'],
                "pekerjaan_ayah" => $data['pekerjaan_ayah'],
                "alamat_ayah" => $data['alamat_ayah'],
                "umur_ayah" => $data['umur_ayah'],
                "nama_ibu" => $data['nama_ibu'],
                "agama_ibu" => $data['agama_ibu'],
                "pekerjaan_ibu" => $data['pekerjaan_ibu'],
                "alamat_ibu" => $data['alamat_ibu'],
                "umur_ibu" => $data['umur_ibu']
            );

            $where[] = " id_permintaan_lahir = '" . $data['id_permintaan_lahir'] . "'";

            $db->update('permintaan_lahir', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getJumlahStatusLahir1() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_lahir where status='1'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahStatusLahir2() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_lahir where status='2'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //		simpan selesai
    public function getSelesaiLahir($data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("status" => $data['status'],
                "waktu_selesai" => $data['waktu_selesai'],
                "waktu_total" => $data['waktu_total']
            );

            $where[] = " id_permintaan_lahir = '" . $data['id_permintaan_lahir'] . "'";

            $db->update('permintaan_lahir', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    ////////////////////////////////////mati lama
    //		cetak surat keterangan kematian lama
    public function getmaticetak($id_permintaan_mati) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getProsesmati($id_kelurahan, $offset, $dataPerPage) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahmati($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_mati where id_kelurahan=$id_kelurahan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPencarianmati($id_kelurahan, $pencarian, $id_pencarian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            if (!$pencarian) {
                $result = $db->fetchAll("SELECT  id_permintaan_mati, no_surat, tanggal_surat, nik, rt, status FROM permintaan_mati WHERE id_kelurahan = $id_kelurahan  LIMIT 0 , 30");
            } else {
                if ($id_pencarian == 1) {
                    $result = $db->fetchAll("SELECT  id_permintaan_mati, no_surat, tanggal_surat, nik, rt, status FROM permintaan_mati WHERE id_kelurahan = $id_kelurahan && no_surat = '$pencarian'  LIMIT 0 , 30");
                } else if ($id_pencarian == 2) {
                    $result = $db->fetchAll("SELECT  id_permintaan_mati, no_surat, tanggal_surat, nik, rt, status 
			FROM permintaan_mati WHERE id_kelurahan = $id_kelurahan && nik = '$pencarian'  LIMIT 0 , 30");
                }
            }
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //		proses simpan antrian -> status menjadi 1
    public function getsimpanmatiantrian(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_pengguna" => $data['id_pengguna'],
                "id_kelurahan" => $data['id_kelurahan'],
                "no_registrasi" => $data['no_registrasi'],
                "nik" => $data['nik'],
                "waktu_antrian" => $data['waktu_antrian'],
                "antrian_oleh" => $data['antrian_oleh'],
                "jam_masuk" => $data['jam_masuk'],
                "status" => $data['status'],
                "no_telp" => $data['no_telp']
            );

            $db->insert('permintaan_mati', $paramInput);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getsimpanprosesmati(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
                "nik" => $data['nik'],
                "id_pejabat" => $data['id_pejabat'],
                "no_surat" => $data['no_surat'],
                "id_jenis_surat" => $data['id_jenis_surat'],
                "id_surat" => $data['id_surat'],
                "tanggal_surat" => $data['tanggal_surat'],
                "no_surat_pengantar" => $data['no_surat_pengantar'],
                "tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
                "status" => $data['status'],
                "tanggal_meninggal" => $data['tanggal_meninggal'],
                "hari_meninggal" => $data['hari_meninggal'],
                "jam_meninggal" => $data['jam_meninggal'],
                "lokasi_meninggal" => $data['lokasi_meninggal'],
                "penyebab_meninggal" => $data['penyebab_meninggal'],
                "usia_meninggal" => $data['usia_meninggal'],
                "keperluan" => $data['keperluan'],
                "waktu_proses" => $data['waktu_proses'],
                "proses_oleh" => $data['proses_oleh'],
                "ket" => $data['ket']
            );

            $where[] = " id_permintaan_mati = '" . $data['id_permintaan_mati'] . "'";

            $db->update('permintaan_mati', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function gethapusmati($id_permintaan_mati) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');


        try {
            $db->beginTransaction();
            $where[] = " id_permintaan_mati = '" . $id_permintaan_mati . "'";

            $db->delete('permintaan_mati', $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getmati($id_permintaan_mati) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*, b.* ,pk.*
			FROM permintaan_mati a, data_penduduk b, pejabat_kelurahan pk 
			WHERE a.nik = b.nik  AND id_permintaan_mati = $id_permintaan_mati");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanmatiedit(array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
                "id_permintaan_mati" => $data['id_permintaan_mati'],
                "nik" => $data['nik'],
                "no_surat" => $data['no_surat'],
                "tanggal_surat" => $data['tanggal_surat'],
                "no_surat_pengantar" => $data['no_surat_pengantar'],
                "tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
                "tanggal_meninggal" => $data['tanggal_meninggal'],
                "hari_meninggal" => $data['hari_meninggal'],
                "jam_meninggal" => $data['jam_meninggal'],
                "lokasi_meninggal" => $data['lokasi_meninggal'],
                "penyebab_meninggal" => $data['penyebab_meninggal'],
                "usia_meninggal" => $data['usia_meninggal'],
                "keperluan" => $data['keperluan']
            );

            $where[] = " id_permintaan_mati = '" . $data['id_permintaan_mati'] . "'";

            $db->update('permintaan_mati', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getJumlahStatusMati1() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_mati where status='1'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahStatusMati2() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_mati where status='2'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //		simpan selesai
    public function getSelesaiMati($data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("status" => $data['status'],
                "waktu_selesai" => $data['waktu_selesai'],
                "waktu_total" => $data['waktu_total']
            );

            $where[] = " id_permintaan_mati = '" . $data['id_permintaan_mati'] . "'";

            $db->update('permintaan_mati', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    ////////////////////////////////////waris
    //		cetak surat WARIS	
    public function getahliwariscetak($id_permintaan_waris) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //proses menampilkan untuk memproses antrian 
    public function getProsesahliwaris($id_kelurahan, $offset, $dataPerPage) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahahliwaris($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_waris where id_kelurahan=$id_kelurahan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahStatusahliwaris1() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_waris where status='1'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahStatusahliwaris2() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_waris where status='2'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPencarianahliwaris($id_kelurahan, $pencarian, $id_pencarian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            if (!$pencarian) {
                $result = $db->fetchAll("SELECT  id_permintaan_waris, no_surat, tanggal_surat, nik, rt, status FROM permintaan_waris WHERE id_kelurahan = $id_kelurahan  LIMIT 0 , 30");
            } else {
                if ($id_pencarian == 1) {
                    $result = $db->fetchAll("SELECT  id_permintaan_waris, no_surat, tanggal_surat, nik, rt, status FROM permintaan_waris WHERE id_kelurahan = $id_kelurahan && no_surat = '$pencarian'  LIMIT 0 , 30");
                } else if ($id_pencarian == 2) {
                    $result = $db->fetchAll("SELECT  id_permintaan_waris, no_surat, tanggal_surat, nik, rt, status 
			FROM permintaan_waris WHERE id_kelurahan = $id_kelurahan && nik = '$pencarian'  LIMIT 0 , 30");
                }
            }
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //		proses simpan antrian -> status menjadi 1
    public function getsimpanahliwarisantrian(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_pengguna" => $data['id_pengguna'],
                "id_kelurahan" => $data['id_kelurahan'],
                "no_registrasi" => $data['no_registrasi'],
                "nik" => $data['nik'],
                "waktu_antrian" => $data['waktu_antrian'],
                "antrian_oleh" => $data['antrian_oleh'],
                "jam_masuk" => $data['jam_masuk'],
                "status" => $data['status'],
                "no_telp" => $data['no_telp']
            );

            $db->insert('permintaan_waris', $paramInput);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getsimpanprosesahliwaris(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
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
                "hari_meninggal" => $data['hari_meninggal'],
                "tanggal_meninggal" => $data['tanggal_meninggal'],
                "tempat_meninggal" => $data['tempat_meninggal'],
                "sebab_meninggal" => $data['sebab_meninggal'],
                "keperluan" => $data['keperluan'],
                "waktu_proses" => $data['waktu_proses'],
                "proses_oleh" => $data['proses_oleh'],
                "ket" => $data['ket']
            );

            $where[] = " id_permintaan_waris = '" . $data['id_permintaan_waris'] . "'";

            $db->update('permintaan_waris', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function gethapusahliwaris($id_permintaan_waris) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');


        try {
            $db->beginTransaction();
            $where[] = " id_permintaan_waris = '" . $id_permintaan_waris . "'";

            $db->delete('permintaan_waris', $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getahliwaris($id_permintaan_waris) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT  * FROM permintaan_waris WHERE id_permintaan_waris = $id_permintaan_waris");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanahliwarisedit(array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array(
                "hari_meninggal" => $data['hari_meninggal'],
                "tanggal_meninggal" => $data['tanggal_meninggal'],
                "tempat_meninggal" => $data['tempat_meninggal'],
                "sebab_meninggal" => $data['sebab_meninggal'],
                "no_surat" => $data['no_surat'],
                "tanggal_surat" => $data['tanggal_surat'],
                "no_surat_pengantar" => $data['no_surat_pengantar'],
                "rt" => $data['rt'],
                "tanggal_surat_pengantar" => $data['tanggal_surat_pengantar']
            );

            $where[] = " id_permintaan_waris = '" . $data['id_permintaan_waris'] . "'";

            $db->update('permintaan_waris', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    //		simpan selesai
    public function getSelesaiahliwaris($data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("status" => $data['status'],
                "waktu_selesai" => $data['waktu_selesai'],
                "waktu_total" => $data['waktu_total']
            );

            $where[] = " id_permintaan_waris = '" . $data['id_permintaan_waris'] . "'";

            $db->update('permintaan_waris', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    ////////////////////////////////////Lain-lain
    public function getserbagunacetak($id_permintaan_serbaguna) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*
			FROM permintaan_serbaguna a, data_penduduk b, pejabat_kelurahan c, kelurahan k
			WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
			AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_serbaguna = $id_permintaan_serbaguna");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //proses simpan antrian -> status menjadi 1
    public function getsimpanserbagunaantrian(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_pengguna" => $data['id_pengguna'],
                "id_kelurahan" => $data['id_kelurahan'],
                "no_registrasi" => $data['no_registrasi'],
                "nik" => $data['nik'],
                "waktu_antrian" => $data['waktu_antrian'],
                "antrian_oleh" => $data['antrian_oleh'],
                "jam_masuk" => $data['jam_masuk'],
                "status" => $data['status'],
                "no_telp" => $data['no_telp']
            );

            $db->insert('permintaan_serbaguna', $paramInput);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getProsesserbaguna($id_kelurahan, $offset, $dataPerPage) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahserbaguna($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_serbaguna where id_kelurahan=$id_kelurahan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPencarianserbaguna($id_kelurahan, $pencarian, $id_pencarian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            if (!$pencarian) {
                $result = $db->fetchAll("SELECT  id_permintaan_serbaguna, no_surat, tanggal_surat, nik, rt, status FROM permintaan_serbaguna WHERE id_kelurahan = $id_kelurahan  LIMIT 0 , 30");
            } else {
                if ($id_pencarian == 1) {
                    $result = $db->fetchAll("SELECT  id_permintaan_serbaguna, no_surat, tanggal_surat, nik, rt, status FROM permintaan_serbaguna WHERE id_kelurahan = $id_kelurahan && no_surat = '$pencarian'  LIMIT 0 , 30");
                } else if ($id_pencarian == 2) {
                    $result = $db->fetchAll("SELECT  id_permintaan_serbaguna, no_surat, tanggal_surat, nik, rt, status 
			FROM permintaan_serbaguna WHERE id_kelurahan = $id_kelurahan && nik = '$pencarian'  LIMIT 0 , 30");
                }
            }
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesserbaguna(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
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

            $where[] = " id_permintaan_serbaguna = '" . $data['id_permintaan_serbaguna'] . "'";

            $db->update('permintaan_serbaguna', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function gethapusserbaguna($id_permintaan_serbaguna) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');


        try {
            $db->beginTransaction();
            $where[] = " id_permintaan_serbaguna = '" . $id_permintaan_serbaguna . "'";

            $db->delete('permintaan_serbaguna', $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getserbaguna($id_permintaan_serbaguna) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanserbagunaedit(array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
                "id_permintaan_serbaguna" => $data['id_permintaan_serbaguna'],
                "keperluan" => $data['keperluan'],
                "ket" => $data['ket'],
                "nik" => $data['nik'],
                "no_surat" => $data['no_surat'],
                "tanggal_surat" => $data['tanggal_surat'],
                "no_surat_pengantar" => $data['no_surat_pengantar'],
                "tanggal_surat_pengantar" => $data['tanggal_surat_pengantar']);

            $where[] = " id_permintaan_serbaguna = '" . $data['id_permintaan_serbaguna'] . "'";

            $db->update('permintaan_serbaguna', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());
            var_dump($errmsgArr);
            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    //		simpan selesai
    public function getSelesaiSerbaguna($data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("status" => $data['status'],
                "waktu_selesai" => $data['waktu_selesai'],
                "waktu_total" => $data['waktu_total']
            );

            $where[] = " id_permintaan_serbaguna = '" . $data['id_permintaan_serbaguna'] . "'";

            $db->update('permintaan_serbaguna', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getJumlahStatusSerbaguna1() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_serbaguna where status='1'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahStatusSerbaguna2() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_serbaguna where status='2'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //////////////////////DOMISILI YAYASAN PANITIA PEMBANGUNAN
    //		cetak surat domisilipanitiapemb
    public function getdomisilipanitiapembcetak($id_permintaan_domisili_panitia_pembangunan) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //		proses simpan antrian -> status menjadi 1
    public function getsimpandomisilipanitiapembantrian(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_pengguna" => $data['id_pengguna'],
                "id_kelurahan" => $data['id_kelurahan'],
                "no_registrasi" => $data['no_registrasi'],
                "nik" => $data['nik'],
                "waktu_antrian" => $data['waktu_antrian'],
                "antrian_oleh" => $data['antrian_oleh'],
                "jam_masuk" => $data['jam_masuk'],
                "status" => $data['status'],
                "no_telp" => $data['no_telp']
            );

            $db->insert('permintaan_domisili_panitia_pembangunan', $paramInput);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    //		proses menampilkan untuk memproses antrian 
    public function getProsesdomisilipanitiapemb($id_kelurahan, $offset, $dataPerPage) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahdomisilipanitiapemb($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_domisili_panitia_pembangunan where id_kelurahan=$id_kelurahan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPencariandomisilipanitiapemb($id_kelurahan, $pencarian, $id_pencarian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            if (!$pencarian) {
                $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_domisili_panitia_pembangunan a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
            } else {
                if ($id_pencarian == 1) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_domisili_panitia_pembangunan a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
                } else if ($id_pencarian == 2) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_domisili_panitia_pembangunan a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
                }
            }
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesdomisilipanitiapemb(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
                "nik" => $data['nik'],
                "id_pejabat" => $data['id_pejabat'],
                "id_jenis_surat" => $data['id_jenis_surat'],
                "id_surat" => $data['id_surat'],
                "no_surat" => $data['no_surat'],
                "tanggal_surat" => $data['tanggal_surat'],
                "no_surat_pengantar" => $data['no_surat_pengantar'],
                "tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
                "keperluan" => $data['keperluan'],
                "status" => $data['status'],
                "waktu_proses" => $data['waktu_proses'],
                "proses_oleh" => $data['proses_oleh'],
                "ket" => $data['ket'],
                "nama_pembangunan" => $data['nama_pembangunan'],
                "alamat_pembangunan" => $data['alamat_pembangunan'],
                "nama_ketua" => $data['nama_ketua'],
                "nama_sekretaris" => $data['nama_sekretaris'],
                "nama_bendahara" => $data['nama_bendahara']
            );

            $where[] = " id_permintaan_domisili_panitia_pembangunan = '" . $data['id_permintaan_domisili_panitia_pembangunan'] . "'";

            $db->update('permintaan_domisili_panitia_pembangunan', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function gethapusdomisilipanitiapemb($id_permintaan_domisili_panitia_pembangunan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $where[] = " id_permintaan_domisili_panitia_pembangunan = '" . $id_permintaan_domisili_panitia_pembangunan . "'";

            $db->delete('permintaan_domisili_panitia_pembangunan', $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getdomisilipanitiapemb($id_permintaan_domisili_panitia_pembangunan) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesdomisilipanitiapembedit(array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array(
                "no_surat" => $data['no_surat'],
                "tanggal_surat" => $data['tanggal_surat'],
                "no_surat_pengantar" => $data['no_surat_pengantar'],
                "tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
                "keperluan" => $data['keperluan'],
                "ket" => $data['ket'],
                "nama_pembangunan" => $data['nama_pembangunan'],
                "alamat_pembangunan" => $data['alamat_pembangunan'],
                "nama_ketua" => $data['nama_ketua'],
                "nama_sekretaris" => $data['nama_sekretaris'],
                "nama_bendahara" => $data['nama_bendahara']);

            $where[] = " id_permintaan_domisili_panitia_pembangunan = '" . $data['id_permintaan_domisili_panitia_pembangunan'] . "'";

            $db->update('permintaan_domisili_panitia_pembangunan', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    //		simpan selesai
    public function getSelesaidomisilipanitiapemb($data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("status" => $data['status'],
                "waktu_selesai" => $data['waktu_selesai'],
                "waktu_total" => $data['waktu_total']
            );

            $where[] = " id_permintaan_domisili_panitia_pembangunan = '" . $data['id_permintaan_domisili_panitia_pembangunan'] . "'";

            $db->update('permintaan_domisili_panitia_pembangunan', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getJumlahStatusdomisilipanitiapemb1() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_domisili_panitia_pembangunan where status='1'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahStatusdomisilipanitiapemb2() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_domisili_panitia_pembangunan where status='2'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //////////////////////11. DOMISILI PENDUDUK
    //		cetak surat ket domisili penduduk
    public function getdomisilipendudukcetak($id_permintaan_domisili_penduduk) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //		proses simpan antrian -> status menjadi 1
    public function getsimpandomisilipendudukantrian(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_pengguna" => $data['id_pengguna'],
                "id_kelurahan" => $data['id_kelurahan'],
                "no_registrasi" => $data['no_registrasi'],
                "nik" => $data['nik'],
                "waktu_antrian" => $data['waktu_antrian'],
                "antrian_oleh" => $data['antrian_oleh'],
                "jam_masuk" => $data['jam_masuk'],
                "status" => $data['status'],
                "no_telp" => $data['no_telp']
            );

            $db->insert('permintaan_domisili_penduduk', $paramInput);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    //		proses menampilkan untuk memproses antrian 
    public function getProsesdomisilipenduduk($id_kelurahan, $offset, $dataPerPage) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahdomisilipenduduk($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_domisili_penduduk where id_kelurahan=$id_kelurahan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPencariandomisilipenduduk($id_kelurahan, $pencarian, $id_pencarian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            if (!$pencarian) {
                $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_domisili_penduduk a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
            } else {
                if ($id_pencarian == 1) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_domisili_penduduk a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
                } else if ($id_pencarian == 2) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_domisili_penduduk a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
                }
            }
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesdomisilipenduduk(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
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

            $where[] = " id_permintaan_domisili_penduduk = '" . $data['id_permintaan_domisili_penduduk'] . "'";

            $db->update('permintaan_domisili_penduduk', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function gethapusdomisilipenduduk($id_permintaan_domisili_penduduk) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $where[] = " id_permintaan_domisili_penduduk = '" . $id_permintaan_domisili_penduduk . "'";

            $db->delete('permintaan_domisili_penduduk', $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getdomisilipenduduk($id_permintaan_domisili_penduduk) {
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
            echo $e->getMessage() . '<br>';
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

            $where[] = " id_permintaan_domisili_penduduk = '" . $data['id_permintaan_domisili_penduduk'] . "'";

            $db->update('permintaan_domisili_penduduk', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    //		simpan selesai
    public function getSelesaidomisilipenduduk($data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("status" => $data['status'],
                "waktu_selesai" => $data['waktu_selesai'],
                "waktu_total" => $data['waktu_total']
            );

            $where[] = " id_permintaan_domisili_penduduk = '" . $data['id_permintaan_domisili_penduduk'] . "'";

            $db->update('permintaan_domisili_penduduk', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getJumlahStatusdomisilipenduduk1() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_domisili_penduduk where status='1'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahStatusdomisilipenduduk2() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_domisili_penduduk where status='2'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //////////////////////ORANG YANG SAMA
    //		cetak surat ket domisili penduduk
    public function getorangyangsamacetak($id_permintaan_orang_yang_sama) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //		proses simpan antrian -> status menjadi 1
    public function getsimpanorangyangsamaantrian(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_pengguna" => $data['id_pengguna'],
                "id_kelurahan" => $data['id_kelurahan'],
                "no_registrasi" => $data['no_registrasi'],
                "nik" => $data['nik'],
                "waktu_antrian" => $data['waktu_antrian'],
                "antrian_oleh" => $data['antrian_oleh'],
                "jam_masuk" => $data['jam_masuk'],
                "status" => $data['status'],
                "no_telp" => $data['no_telp']
            );

            $db->insert('permintaan_orang_yang_sama', $paramInput);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    //		proses menampilkan untuk memproses antrian  orangyangsama
    public function getProsesorangyangsama($id_kelurahan, $offset, $dataPerPage) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_orang_yang_sama a, data_penduduk b 
			WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik 
			ORDER BY  a.no_registrasi DESC 
			LIMIT $offset , $dataPerPage");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahorangyangsama($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_orang_yang_sama where id_kelurahan=$id_kelurahan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPencarianorangyangsama($id_kelurahan, $pencarian, $id_pencarian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            if (!$pencarian) {
                $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_orang_yang_sama a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
            } else {
                if ($id_pencarian == 1) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_orang_yang_sama a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
                } else if ($id_pencarian == 2) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_orang_yang_sama a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
                }
            }
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesorangyangsama(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
                "nik" => $data['nik'],
                "id_pejabat" => $data['id_pejabat'],
                "id_jenis_surat" => $data['id_jenis_surat'],
                "id_surat" => $data['id_surat'],
                "no_surat" => $data['no_surat'],
                "tanggal_surat" => $data['tanggal_surat'],
                "no_surat_pengantar" => $data['no_surat_pengantar'],
                "tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
                "keperluan" => $data['keperluan'],
                "perbedaan_penulisan" => $data['perbedaan_penulisan'],
                "status" => $data['status'],
                "waktu_proses" => $data['waktu_proses'],
                "proses_oleh" => $data['proses_oleh'],
                "ket" => $data['ket']);

            $where[] = " id_permintaan_orang_yang_sama = '" . $data['id_permintaan_orang_yang_sama'] . "'";

            $db->update('permintaan_orang_yang_sama', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function gethapusorangyangsama($id_permintaan_orang_yang_sama) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $where[] = " id_permintaan_orang_yang_sama = '" . $id_permintaan_orang_yang_sama . "'";

            $db->delete('permintaan_orang_yang_sama', $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getorangyangsama($id_permintaan_orang_yang_sama) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*, b.*, c.* 
			FROM permintaan_orang_yang_sama a, data_penduduk b, pejabat_kelurahan c 
			WHERE  a.nik = b.nik  
			AND a.id_permintaan_orang_yang_sama = $id_permintaan_orang_yang_sama");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesorangyangsamaedit(array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array(
                "no_surat" => $data['no_surat'],
                "tanggal_surat" => $data['tanggal_surat'],
                "no_surat_pengantar" => $data['no_surat_pengantar'],
                "tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
                "perbedaan_penulisan" => $data['perbedaan_penulisan'],
                "keperluan" => $data['keperluan'],
                "perbedaan_penulisan" => $data['perbedaan_penulisan'],
                "ket" => $data['ket']);

            $where[] = " id_permintaan_orang_yang_sama = '" . $data['id_permintaan_orang_yang_sama'] . "'";

            $db->update('permintaan_orang_yang_sama', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    //		simpan selesai
    public function getSelesaiorangyangsama($data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("status" => $data['status'],
                "waktu_selesai" => $data['waktu_selesai'],
                "waktu_total" => $data['waktu_total']
            );

            $where[] = " id_permintaan_orang_yang_sama = '" . $data['id_permintaan_orang_yang_sama'] . "'";

            $db->update('permintaan_orang_yang_sama', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getJumlahStatusorangyangsama1() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_orang_yang_sama where status='1'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahStatusorangyangsama2() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_orang_yang_sama where status='2'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    ////////////////////////////////////Ket. Tanah dan Bangunan AJB
    //cetak ket ajb
    public function getktbajbcetak($id_permintaan_ajb) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //		proses simpan antrian -> status menjadi 1
    public function getsimpanktbajbantrian(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_pengguna" => $data['id_pengguna'],
                "id_kelurahan" => $data['id_kelurahan'],
                "no_registrasi" => $data['no_registrasi'],
                "nik" => $data['nik'],
                "waktu_antrian" => $data['waktu_antrian'],
                "antrian_oleh" => $data['antrian_oleh'],
                "jam_masuk" => $data['jam_masuk'],
                "status" => $data['status'],
                "no_telp" => $data['no_telp']
            );

            $db->insert('permintaan_ajb', $paramInput);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    //		proses menampilkan untuk memproses antrian  ktbajb
    public function getProsesktbajb($id_kelurahan, $offset, $dataPerPage) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahktbajb($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_ajb where id_kelurahan=$id_kelurahan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPencarianktbajb($id_kelurahan, $pencarian, $id_pencarian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            if (!$pencarian) {
                $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_ajb a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
            } else {
                if ($id_pencarian == 1) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_ajb a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
                } else if ($id_pencarian == 2) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_ajb a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
                }
            }
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesktbajb(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
                "nik" => $data['nik'],
                "id_pejabat" => $data['id_pejabat'],
                "id_jenis_surat" => $data['id_jenis_surat'],
                "id_surat" => $data['id_surat'],
                "no_surat" => $data['no_surat'],
                "tanggal_surat" => $data['tanggal_surat'],
                "no_surat_pengantar" => $data['no_surat_pengantar'],
                "tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
                "keperluan" => $data['keperluan'],
                "status" => $data['status'],
                "waktu_proses" => $data['waktu_proses'],
                "proses_oleh" => $data['proses_oleh'],
                "ket" => $data['ket'],
                ///////harga_bangunan
                "nama_pemilik" => $data['nama_pemilik'],
                "alamat_pemilik" => $data['alamat_pemilik'],
                "pekerjaan_pemilik" => $data['pekerjaan_pemilik'],
                "luas_tanah" => $data['luas_tanah'],
                "luas_bangunan" => $data['luas_bangunan'],
                "no_persil" => $data['no_persil'],
                "no_kohir" => $data['ket'],
                "blok_tanah" => $data['blok_tanah'],
                "kel_tanah" => $data['kel_tanah'],
                "rt_tanah" => $data['rt_tanah'],
                "rw_tanah" => $data['rw_tanah'],
                "kec_tanah" => $data['kec_tanah'],
                "no_akta" => $data['no_akta'],
                "batas_utara" => $data['batas_utara'],
                "batas_barat" => $data['batas_barat'],
                "batas_timur" => $data['batas_timur'],
                "batas_selatan" => $data['batas_selatan'],
                "no_pbb" => $data['no_pbb'],
                "harga_tanah" => $data['harga_tanah'],
                "harga_bangunan" => $data['harga_bangunan']
            );

            $where[] = " id_permintaan_ajb = '" . $data['id_permintaan_ajb'] . "'";

            $db->update('permintaan_ajb', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function gethapusktbajb($id_permintaan_ajb) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $where[] = " id_permintaan_ajb = '" . $id_permintaan_ajb . "'";

            $db->delete('permintaan_ajb', $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getktbajb($id_permintaan_ajb) {
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
            echo $e->getMessage() . '<br>';
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
                "ket" => $data['ket'],
                ///////ktb ajb
                "nama_pemilik" => $data['nama_pemilik'],
                "alamat_pemilik" => $data['alamat_pemilik'],
                "pekerjaan_pemilik" => $data['pekerjaan_pemilik'],
                "luas_tanah" => $data['luas_tanah'],
                "luas_bangunan" => $data['luas_bangunan'],
                "no_persil" => $data['no_persil'],
                "no_kohir" => $data['ket'],
                "blok_tanah" => $data['blok_tanah'],
                "kel_tanah" => $data['kel_tanah'],
                "rt_tanah" => $data['rt_tanah'],
                "rw_tanah" => $data['rw_tanah'],
                "kec_tanah" => $data['kec_tanah'],
                "no_akta" => $data['no_akta'],
                "batas_utara" => $data['batas_utara'],
                "batas_barat" => $data['batas_barat'],
                "batas_timur" => $data['batas_timur'],
                "batas_selatan" => $data['batas_selatan'],
                "no_pbb" => $data['no_pbb'],
                "harga_tanah" => $data['harga_tanah'],
                "harga_bangunan" => $data['harga_bangunan']);

            $where[] = " id_permintaan_ajb = '" . $data['id_permintaan_ajb'] . "'";

            $db->update('permintaan_ajb', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    //		simpan selesai
    public function getSelesaiktbajb($data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("status" => $data['status'],
                "waktu_selesai" => $data['waktu_selesai'],
                "waktu_total" => $data['waktu_total']
            );

            $where[] = " id_permintaan_ajb = '" . $data['id_permintaan_ajb'] . "'";

            $db->update('permintaan_ajb', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getJumlahStatusktbajb1() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_ajb where status='1'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahStatusktbajb2() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_ajb where status='2'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    ////////////////////////////////////Ket. Pindah
    //cetak ket Pindah
    public function getpindahcetak($id_permintaan_pindah) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*, k.alamat as alamat_kelurahan, b.alamat as alamat_warga
			FROM permintaan_pindah a, data_penduduk b, pejabat_kelurahan c, kelurahan k
			WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
			AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_pindah = $id_permintaan_pindah");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //		proses simpan antrian -> status menjadi 1
    public function getsimpanpindahantrian(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_pengguna" => $data['id_pengguna'],
                "id_kelurahan" => $data['id_kelurahan'],
                "no_registrasi" => $data['no_registrasi'],
                "nik" => $data['nik'],
                "waktu_antrian" => $data['waktu_antrian'],
                "antrian_oleh" => $data['antrian_oleh'],
                "jam_masuk" => $data['jam_masuk'],
                "status" => $data['status'],
                "no_telp" => $data['no_telp']
            );

            $db->insert('permintaan_pindah', $paramInput);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    //		proses menampilkan untuk memproses antrian  pindah
    public function getProsespindah($id_kelurahan, $offset, $dataPerPage) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_pindah a, data_penduduk b 
			WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik 
			ORDER BY  a.no_registrasi DESC 
			LIMIT $offset , $dataPerPage");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahpindah($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_pindah where id_kelurahan=$id_kelurahan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPencarianpindah($id_kelurahan, $pencarian, $id_pencarian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            if (!$pencarian) {
                $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_pindah a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
            } else {
                if ($id_pencarian == 1) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_pindah a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
                } else if ($id_pencarian == 2) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_pindah a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
                }
            }
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosespindah(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
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
                ///////yang beda
                "alamatpindah" => $data['alamatpindah'],
                "rtpindah" => $data['rtpindah'],
                "rwpindah" => $data['rwpindah'],
                "kelurahanpindah" => $data['kelurahanpindah'],
                "kecamatanpindah" => $data['kecamatanpindah'],
                "kotapindah" => $data['kotapindah'],
                "provinsipindah" => $data['provinsipindah'],
                "tanggalpindah" => $data['tanggalpindah'],
                "alasanpindah" => $data['alasanpindah'],
                "pengikut" => $data['pengikut']
            );

            $where[] = " id_permintaan_pindah = '" . $data['id_permintaan_pindah'] . "'";

            $db->update('permintaan_pindah', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function gethapuspindah($id_permintaan_pindah) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $where[] = " id_permintaan_pindah = '" . $id_permintaan_pindah . "'";

            $db->delete('permintaan_pindah', $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getpindah($id_permintaan_pindah) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*, b.*, c.* 
			FROM permintaan_pindah a, data_penduduk b, pejabat_kelurahan c 
			WHERE  a.nik = b.nik  
			AND a.id_permintaan_pindah = $id_permintaan_pindah");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosespindahedit(array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array(
                "ket" => $data['ket'],
                ///////yang beda
                "alamatpindah" => $data['alamatpindah'],
                "rtpindah" => $data['rtpindah'],
                "rwpindah" => $data['rwpindah'],
                "kelurahanpindah" => $data['kelurahanpindah'],
                "kecamatanpindah" => $data['kecamatanpindah'],
                "kotapindah" => $data['kotapindah'],
                "provinsipindah" => $data['provinsipindah'],
                "tanggalpindah" => $data['tanggalpindah'],
                "alasanpindah" => $data['alasanpindah'],
                "pengikut" => $data['pengikut']
            );
            $where[] = " id_permintaan_pindah = '" . $data['id_permintaan_pindah'] . "'";

            $db->update('permintaan_pindah', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    //		simpan selesai
    public function getSelesaipindah($data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("status" => $data['status'],
                "waktu_selesai" => $data['waktu_selesai'],
                "waktu_total" => $data['waktu_total']
            );

            $where[] = " id_permintaan_pindah = '" . $data['id_permintaan_pindah'] . "'";

            $db->update('permintaan_pindah', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getJumlahStatuspindah1() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_pindah where status='1'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahStatuspindah2() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_pindah where status='2'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    ////////////////////////////////////Ket. sertifikat
    //cetak ket sertifikat
    public function getktbsertifikatcetak($id_permintaan_sertifikat) {
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
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //		proses simpan antrian -> status menjadi 1
    public function getsimpanktbsertifikatantrian(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_pengguna" => $data['id_pengguna'],
                "id_kelurahan" => $data['id_kelurahan'],
                "no_registrasi" => $data['no_registrasi'],
                "nik" => $data['nik'],
                "waktu_antrian" => $data['waktu_antrian'],
                "antrian_oleh" => $data['antrian_oleh'],
                "jam_masuk" => $data['jam_masuk'],
                "status" => $data['status'],
                "no_telp" => $data['no_telp']
            );

            $db->insert('permintaan_sertifikat', $paramInput);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    //		proses menampilkan untuk memproses antrian  ktbsertifikat
    public function getProsesktbsertifikat($id_kelurahan, $offset, $dataPerPage) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_sertifikat a, data_penduduk b 
			WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik 
			ORDER BY  a.no_registrasi DESC 
			LIMIT $offset , $dataPerPage");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahktbsertifikat($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_sertifikat where id_kelurahan=$id_kelurahan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPencarianktbsertifikat($id_kelurahan, $pencarian, $id_pencarian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            if (!$pencarian) {
                $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_sertifikat a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
            } else {
                if ($id_pencarian == 1) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_sertifikat a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
                } else if ($id_pencarian == 2) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_sertifikat a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
                }
            }
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesktbsertifikat(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
                "nik" => $data['nik'],
                "id_pejabat" => $data['id_pejabat'],
                "id_jenis_surat" => $data['id_jenis_surat'],
                "id_surat" => $data['id_surat'],
                "no_surat" => $data['no_surat'],
                "tanggal_surat" => $data['tanggal_surat'],
                "no_surat_pengantar" => $data['no_surat_pengantar'],
                "tanggal_surat_pengantar" => $data['tanggal_surat_pengantar'],
                "keperluan" => $data['keperluan'],
                "status" => $data['status'],
                "waktu_proses" => $data['waktu_proses'],
                "proses_oleh" => $data['proses_oleh'],
                "ket" => $data['ket'],
                ///////harga_bangunan
                "nama_pemilik" => $data['nama_pemilik'],
                "alamat_pemilik" => $data['alamat_pemilik'],
                "pekerjaan_pemilik" => $data['pekerjaan_pemilik'],
                "luas_tanah" => $data['luas_tanah'],
                "luas_bangunan" => $data['luas_bangunan'],
                "no_persil" => $data['no_persil'],
                "no_kohir" => $data['ket'],
                "blok_tanah" => $data['blok_tanah'],
                "kel_tanah" => $data['kel_tanah'],
                "rt_tanah" => $data['rt_tanah'],
                "rw_tanah" => $data['rw_tanah'],
                "kec_tanah" => $data['kec_tanah'],
                "no_akta" => $data['no_akta'],
                "batas_utara" => $data['batas_utara'],
                "batas_barat" => $data['batas_barat'],
                "batas_timur" => $data['batas_timur'],
                "batas_selatan" => $data['batas_selatan'],
                "no_pbb" => $data['no_pbb'],
                "harga_tanah" => $data['harga_tanah'],
                "harga_bangunan" => $data['harga_bangunan']
            );

            $where[] = " id_permintaan_sertifikat = '" . $data['id_permintaan_sertifikat'] . "'";

            $db->update('permintaan_sertifikat', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function gethapusktbsertifikat($id_permintaan_sertifikat) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $where[] = " id_permintaan_sertifikat = '" . $id_permintaan_sertifikat . "'";

            $db->delete('permintaan_sertifikat', $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getktbsertifikat($id_permintaan_sertifikat) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*, b.*, c.* 
			FROM permintaan_sertifikat a, data_penduduk b, pejabat_kelurahan c 
			WHERE  a.nik = b.nik  
			AND a.id_permintaan_sertifikat = $id_permintaan_sertifikat");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesktbsertifikatedit(array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array(
                "keperluan" => $data['keperluan'],
                "ket" => $data['ket'],
                ///////ktb ajb
                "nama_pemilik" => $data['nama_pemilik'],
                "alamat_pemilik" => $data['alamat_pemilik'],
                "pekerjaan_pemilik" => $data['pekerjaan_pemilik'],
                "luas_tanah" => $data['luas_tanah'],
                "luas_bangunan" => $data['luas_bangunan'],
                "no_persil" => $data['no_persil'],
                "no_kohir" => $data['ket'],
                "blok_tanah" => $data['blok_tanah'],
                "kel_tanah" => $data['kel_tanah'],
                "rt_tanah" => $data['rt_tanah'],
                "rw_tanah" => $data['rw_tanah'],
                "kec_tanah" => $data['kec_tanah'],
                "no_akta" => $data['no_akta'],
                "batas_utara" => $data['batas_utara'],
                "batas_barat" => $data['batas_barat'],
                "batas_timur" => $data['batas_timur'],
                "batas_selatan" => $data['batas_selatan'],
                "no_pbb" => $data['no_pbb'],
                "harga_tanah" => $data['harga_tanah'],
                "harga_bangunan" => $data['harga_bangunan']);

            $where[] = " id_permintaan_sertifikat = '" . $data['id_permintaan_sertifikat'] . "'";

            $db->update('permintaan_sertifikat', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    //		simpan selesai
    public function getSelesaiktbsertifikat($data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("status" => $data['status'],
                "waktu_selesai" => $data['waktu_selesai'],
                "waktu_total" => $data['waktu_total']
            );

            $where[] = " id_permintaan_sertifikat = '" . $data['id_permintaan_sertifikat'] . "'";

            $db->update('permintaan_sertifikat', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getJumlahStatusktbsertifikat1() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_sertifikat where status='1'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahStatusktbsertifikat2() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_sertifikat where status='2'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

// end sertifikat
    ////////////////////////////////////Mutasi Balik Nama PBB
    //cetak mutasi balik nama PBB
    public function getmutasipbbcetak($id_permintaan_mutasi_pbb) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*, k.alamat as alamat_kelurahan, b.alamat as alamat_warga
			FROM permintaan_pbb_mutasi a, data_penduduk b, pejabat_kelurahan c, kelurahan k
			WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
			AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_mutasi_pbb = $id_permintaan_mutasi_pbb");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //proses simpan antrian -> status menjadi 1
    public function getsimpanmutasipbbantrian(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_pengguna" => $data['id_pengguna'],
                "id_kelurahan" => $data['id_kelurahan'],
                "no_registrasi" => $data['no_registrasi'],
                "nik" => $data['nik'],
                "waktu_antrian" => $data['waktu_antrian'],
                "antrian_oleh" => $data['antrian_oleh'],
                "jam_masuk" => $data['jam_masuk'],
                "status" => $data['status'],
                "no_telp" => $data['no_telp']
            );

            $db->insert('permintaan_pbb_mutasi', $paramInput);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    //		proses menampilkan untuk memproses antrian  mutasipbb
    public function getProsesmutasipbb($id_kelurahan, $offset, $dataPerPage) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_pbb_mutasi a, data_penduduk b 
			WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik 
			ORDER BY  a.no_registrasi DESC 
			LIMIT $offset , $dataPerPage");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahmutasipbb($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_pbb_mutasi where id_kelurahan=$id_kelurahan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPencarianmutasipbb($id_kelurahan, $pencarian, $id_pencarian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            if (!$pencarian) {
                $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_pbb_mutasi a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
            } else {
                if ($id_pencarian == 1) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_pbb_mutasi a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
                } else if ($id_pencarian == 2) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_pbb_mutasi a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
                }
            }
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesmutasipbb(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
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
                "no_pbb" => $data['no_pbb'],
                "atas_nama" => $data['atas_nama'],
                "kepada" => $data['kepada'],
                "luas_tanah" => $data['luas_tanah'],
                "bukti_kepemilikan" => $data['bukti_kepemilikan'],
                "no_bukti_kepemilikan" => $data['no_bukti_kepemilikan'],
                "tanggal_bukti_kepemilikan" => $data['tanggal_bukti_kepemilikan'],
                "atas_nama_bukti_kepemilikan" => $data['atas_nama_bukti_kepemilikan'],
                "status" => $data['status'],
                "waktu_proses" => $data['waktu_proses'],
                "proses_oleh" => $data['proses_oleh'],
                "ket" => $data['ket']);

            $where[] = " id_permintaan_mutasi_pbb = '" . $data['id_permintaan_mutasi_pbb'] . "'";

            $db->update('permintaan_pbb_mutasi', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function gethapusmutasipbb($id_permintaan_mutasi_pbb) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $where[] = " id_permintaan_mutasi_pbb = '" . $id_permintaan_mutasi_pbb . "'";

            $db->delete('permintaan_pbb_mutasi', $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getmutasipbb($id_permintaan_mutasi_pbb) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*, b.*, c.* 
			FROM permintaan_pbb_mutasi a, data_penduduk b, pejabat_kelurahan c 
			WHERE  a.nik = b.nik  
			AND a.id_permintaan_mutasi_pbb = $id_permintaan_mutasi_pbb");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesmutasipbbedit(array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array(
                "no_pbb" => $data['no_pbb'],
                "atas_nama" => $data['atas_nama'],
                "kepada" => $data['kepada'],
                "luas_tanah" => $data['luas_tanah'],
                "bukti_kepemilikan" => $data['bukti_kepemilikan'],
                "no_bukti_kepemilikan" => $data['no_bukti_kepemilikan'],
                "tanggal_bukti_kepemilikan" => $data['tanggal_bukti_kepemilikan'],
                "atas_nama_bukti_kepemilikan" => $data['atas_nama_bukti_kepemilikan'],
                "keperluan" => $data['keperluan'],
                "masa_berlaku" => $data['masa_berlaku'],
                "ket" => $data['ket']);

            $where[] = " id_permintaan_mutasi_pbb = '" . $data['id_permintaan_mutasi_pbb'] . "'";

            $db->update('permintaan_pbb_mutasi', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    //		simpan selesai
    public function getSelesaimutasipbb($data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("status" => $data['status'],
                "waktu_selesai" => $data['waktu_selesai'],
                "waktu_total" => $data['waktu_total']
            );

            $where[] = " id_permintaan_mutasi_pbb = '" . $data['id_permintaan_mutasi_pbb'] . "'";

            $db->update('permintaan_pbb_mutasi', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getJumlahStatusmutasipbb1() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_pbb_mutasi where status='1'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahStatusmutasipbb2() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_pbb_mutasi where status='2'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    ///////////////////////////////////Penerbitan PBB
    //cetak penerbitan PBB
    public function getpenerbitanpbbcetak($id_permintaan_penerbitan_pbb) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*, k.alamat as alamat_kelurahan, b.alamat as alamat_warga
			FROM permintaan_pbb_penerbitan a, data_penduduk b, pejabat_kelurahan c, kelurahan k
			WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
			AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_penerbitan_pbb = $id_permintaan_penerbitan_pbb");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //proses simpan antrian -> status menjadi 1
    public function getsimpanpenerbitanpbbantrian(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_pengguna" => $data['id_pengguna'],
                "id_kelurahan" => $data['id_kelurahan'],
                "no_registrasi" => $data['no_registrasi'],
                "nik" => $data['nik'],
                "waktu_antrian" => $data['waktu_antrian'],
                "antrian_oleh" => $data['antrian_oleh'],
                "jam_masuk" => $data['jam_masuk'],
                "status" => $data['status'],
                "no_telp" => $data['no_telp']
            );

            $db->insert('permintaan_pbb_penerbitan', $paramInput);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    //		proses menampilkan untuk memproses antrian  penerbitanpbb
    public function getProsespenerbitanpbb($id_kelurahan, $offset, $dataPerPage) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_pbb_penerbitan a, data_penduduk b 
			WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik 
			ORDER BY  a.no_registrasi DESC 
			LIMIT $offset , $dataPerPage");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahpenerbitanpbb($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_pbb_penerbitan where id_kelurahan=$id_kelurahan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPencarianpenerbitanpbb($id_kelurahan, $pencarian, $id_pencarian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            if (!$pencarian) {
                $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_pbb_penerbitan a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik  LIMIT 0 , 30");
            } else {
                if ($id_pencarian == 1) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_pbb_penerbitan a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.no_surat = '$pencarian'  LIMIT 0 , 30");
                } else if ($id_pencarian == 2) {
                    $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_pbb_penerbitan a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik && a.nik = '$pencarian'  LIMIT 0 , 30");
                }
            }
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosespenerbitanpbb(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
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

            $where[] = " id_permintaan_penerbitan_pbb = '" . $data['id_permintaan_penerbitan_pbb'] . "'";

            $db->update('permintaan_pbb_penerbitan', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function gethapuspenerbitanpbb($id_permintaan_penerbitan_pbb) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $where[] = " id_permintaan_penerbitan_pbb = '" . $id_permintaan_penerbitan_pbb . "'";

            $db->delete('permintaan_pbb_penerbitan', $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getpenerbitanpbb($id_permintaan_penerbitan_pbb) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*, b.*, c.* 
			FROM permintaan_pbb_penerbitan a, data_penduduk b, pejabat_kelurahan c 
			WHERE  a.nik = b.nik  
			AND a.id_permintaan_penerbitan_pbb = $id_permintaan_penerbitan_pbb");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
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

            $where[] = " id_permintaan_penerbitan_pbb = '" . $data['id_permintaan_penerbitan_pbb'] . "'";

            $db->update('permintaan_pbb_penerbitan', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    //		simpan selesai
    public function getSelesaipenerbitanpbb($data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("status" => $data['status'],
                "waktu_selesai" => $data['waktu_selesai'],
                "waktu_total" => $data['waktu_total']
            );

            $where[] = " id_permintaan_penerbitan_pbb = '" . $data['id_permintaan_pbb_penerbitan'] . "'";

            $db->update('permintaan_pbb_penerbitan', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getJumlahStatuspenerbitanpbb1() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_pbb_penerbitan where status='1'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahStatuspenerbitanpbb2() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_pbb_penerbitan where status='2'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    ////////////////////////////////////Split PBB
    //cetak split PBB
    public function getsplitpbbcetak($id_permintaan_split_pbb) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*, k.alamat as alamat_kelurahan, b.alamat as alamat_warga
			FROM permintaan_pbb_split a, data_penduduk b, pejabat_kelurahan c, kelurahan k
			WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
			AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_split_pbb = $id_permintaan_split_pbb");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    ////////////////////////////////////lahir baru
    //		cetak surat keterangan kelahiran baru
    public function getlahirbarucetak($id_permintaan_lahir_baru) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*, k.alamat as alamat_kelurahan, b.alamat as alamat_warga
			FROM permintaan_lahir_baru a, data_penduduk b, pejabat_kelurahan c, kelurahan k
			WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
			AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_lahir_baru = $id_permintaan_lahir_baru");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    ////////////////////////////////////mati baru
    //		cetak surat keterangan kematian baru
    public function getmatibarucetak($id_permintaan_mati_baru) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*, k.alamat as alamat_kelurahan, b.alamat as alamat_warga
			FROM permintaan_mati_baru a, data_penduduk b, pejabat_kelurahan c, kelurahan k
			WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
			AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_mati_baru = $id_permintaan_mati_baru");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    /////////////////////////////////////////////////////////// KIPEM
    public function getkipemcetak($id_permintaan_kipem) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*
			FROM permintaan_kipem a, data_penduduk b, pejabat_kelurahan c, kelurahan k
			WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
			AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_kipem = $id_permintaan_kipem");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //proses simpan antrian -> status menjadi 1
    public function getsimpankipemantrian(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_pengguna" => $data['id_pengguna'],
                "id_kelurahan" => $data['id_kelurahan'],
                "no_registrasi" => $data['no_registrasi'],
                "nik" => $data['nik'],
                "waktu_antrian" => $data['waktu_antrian'],
                "antrian_oleh" => $data['antrian_oleh'],
                "jam_masuk" => $data['jam_masuk'],
                "status" => $data['status'],
                "no_telp" => $data['no_telp']
            );

            $db->insert('permintaan_kipem', $paramInput);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getProseskipem($id_kelurahan, $offset, $dataPerPage) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_kipem a, data_penduduk b 
			WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik 
			ORDER BY  a.no_registrasi DESC 
			LIMIT $offset , $dataPerPage");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahkipem($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_kipem where id_kelurahan=$id_kelurahan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPencariankipem($id_kelurahan, $pencarian, $id_pencarian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            if (!$pencarian) {
                $result = $db->fetchAll("SELECT  id_permintaan_kipem, no_surat, tanggal_surat, nik, rt, status FROM permintaan_kipem WHERE id_kelurahan = $id_kelurahan  LIMIT 0 , 30");
            } else {
                if ($id_pencarian == 1) {
                    $result = $db->fetchAll("SELECT  id_permintaan_kipem, no_surat, tanggal_surat, nik, rt, status FROM permintaan_kipem WHERE id_kelurahan = $id_kelurahan && no_surat = '$pencarian'  LIMIT 0 , 30");
                } else if ($id_pencarian == 2) {
                    $result = $db->fetchAll("SELECT  id_permintaan_kipem, no_surat, tanggal_surat, nik, rt, status 
			FROM permintaan_kipem WHERE id_kelurahan = $id_kelurahan && nik = '$pencarian'  LIMIT 0 , 30");
                }
            }
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanproseskipem(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
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

            $where[] = " id_permintaan_kipem = '" . $data['id_permintaan_kipem'] . "'";

            $db->update('permintaan_kipem', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function gethapuskipem($id_permintaan_kipem) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');


        try {
            $db->beginTransaction();
            $where[] = " id_permintaan_kipem = '" . $id_permintaan_kipem . "'";

            $db->delete('permintaan_kipem', $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getkipem($id_permintaan_kipem) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*, b.*, c.* 
			FROM permintaan_kipem a, data_penduduk b, pejabat_kelurahan c 
			WHERE  a.nik = b.nik  
			AND a.id_permintaan_kipem = $id_permintaan_kipem");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpankipemedit(array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
                "id_permintaan_kipem" => $data['id_permintaan_kipem'],
                "keperluan" => $data['keperluan'],
                "ket" => $data['ket'],
                "nik" => $data['nik'],
                "no_surat" => $data['no_surat'],
                "tanggal_surat" => $data['tanggal_surat'],
                "no_surat_pengantar" => $data['no_surat_pengantar'],
                "tanggal_surat_pengantar" => $data['tanggal_surat_pengantar']);

            $where[] = " id_permintaan_kipem = '" . $data['id_permintaan_kipem'] . "'";

            $db->update('permintaan_kipem', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());
            var_dump($errmsgArr);
            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    //		simpan selesai
    public function getSelesaikipem($data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("status" => $data['status'],
                "waktu_selesai" => $data['waktu_selesai'],
                "waktu_total" => $data['waktu_total']
            );

            $where[] = " id_permintaan_kipem = '" . $data['id_permintaan_kipem'] . "'";

            $db->update('permintaan_kipem', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getJumlahStatuskipem1() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_kipem where status='1'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahStatuskipem2() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_kipem where status='2'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //////////////// end kipem
    /////////////////////////////////// surat ktp
    public function getktpcetak($id_permintaan_ktp) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*
			FROM permintaan_ktp a, data_penduduk b, pejabat_kelurahan c, kelurahan k
			WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
			AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_ktp = $id_permintaan_ktp");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //proses simpan antrian -> status menjadi 1
    public function getsimpanktpantrian(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_pengguna" => $data['id_pengguna'],
                "id_kelurahan" => $data['id_kelurahan'],
                "no_registrasi" => $data['no_registrasi'],
                "nik" => $data['nik'],
                "waktu_antrian" => $data['waktu_antrian'],
                "antrian_oleh" => $data['antrian_oleh'],
                "jam_masuk" => $data['jam_masuk'],
                "status" => $data['status'],
                "no_telp" => $data['no_telp']
            );

            $db->insert('permintaan_ktp', $paramInput);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getProsesktp($id_kelurahan, $offset, $dataPerPage) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_ktp a, data_penduduk b 
			WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik 
			ORDER BY  a.no_registrasi DESC 
			LIMIT $offset , $dataPerPage");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahktp($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_ktp where id_kelurahan=$id_kelurahan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPencarianktp($id_kelurahan, $pencarian, $id_pencarian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            if (!$pencarian) {
                $result = $db->fetchAll("SELECT  id_permintaan_ktp, no_surat, tanggal_surat, nik, rt, status FROM permintaan_ktp WHERE id_kelurahan = $id_kelurahan  LIMIT 0 , 30");
            } else {
                if ($id_pencarian == 1) {
                    $result = $db->fetchAll("SELECT  id_permintaan_ktp, no_surat, tanggal_surat, nik, rt, status FROM permintaan_ktp WHERE id_kelurahan = $id_kelurahan && no_surat = '$pencarian'  LIMIT 0 , 30");
                } else if ($id_pencarian == 2) {
                    $result = $db->fetchAll("SELECT  id_permintaan_ktp, no_surat, tanggal_surat, nik, rt, status 
			FROM permintaan_ktp WHERE id_kelurahan = $id_kelurahan && nik = '$pencarian'  LIMIT 0 , 30");
                }
            }
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesktp(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
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

            $where[] = " id_permintaan_ktp = '" . $data['id_permintaan_ktp'] . "'";

            $db->update('permintaan_ktp', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function gethapusktp($id_permintaan_ktp) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');


        try {
            $db->beginTransaction();
            $where[] = " id_permintaan_ktp = '" . $id_permintaan_ktp . "'";

            $db->delete('permintaan_ktp', $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getktp($id_permintaan_ktp) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*, b.*, c.* 
			FROM permintaan_ktp a, data_penduduk b, pejabat_kelurahan c 
			WHERE  a.nik = b.nik  
			AND a.id_permintaan_ktp = $id_permintaan_ktp");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanktpedit(array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
                "id_permintaan_ktp" => $data['id_permintaan_ktp'],
                "keperluan" => $data['keperluan'],
                "ket" => $data['ket'],
                "nik" => $data['nik'],
                "no_surat" => $data['no_surat'],
                "tanggal_surat" => $data['tanggal_surat'],
                "no_surat_pengantar" => $data['no_surat_pengantar'],
                "tanggal_surat_pengantar" => $data['tanggal_surat_pengantar']);

            $where[] = " id_permintaan_ktp = '" . $data['id_permintaan_ktp'] . "'";

            $db->update('permintaan_ktp', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());
            var_dump($errmsgArr);
            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    //		simpan selesai
    public function getSelesaiktp($data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("status" => $data['status'],
                "waktu_selesai" => $data['waktu_selesai'],
                "waktu_total" => $data['waktu_total']
            );

            $where[] = " id_permintaan_ktp = '" . $data['id_permintaan_ktp'] . "'";

            $db->update('permintaan_ktp', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getJumlahStatusktp1() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_ktp where status='1'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahStatusktp2() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_ktp where status='2'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

////// end ktp
    ////////////////////////////////// surat kk
    public function getkkcetak($id_permintaan_kk) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*
			FROM permintaan_kk a, data_penduduk b, pejabat_kelurahan c, kelurahan k
			WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
			AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_kk = $id_permintaan_kk");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //proses simpan antrian -> status menjadi 1
    public function getsimpankkantrian(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_pengguna" => $data['id_pengguna'],
                "id_kelurahan" => $data['id_kelurahan'],
                "no_registrasi" => $data['no_registrasi'],
                "nik" => $data['nik'],
                "waktu_antrian" => $data['waktu_antrian'],
                "antrian_oleh" => $data['antrian_oleh'],
                "jam_masuk" => $data['jam_masuk'],
                "status" => $data['status'],
                "no_telp" => $data['no_telp']
            );

            $db->insert('permintaan_kk', $paramInput);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getProseskk($id_kelurahan, $offset, $dataPerPage) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_kk a, data_penduduk b 
			WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik 
			ORDER BY  a.no_registrasi DESC 
			LIMIT $offset , $dataPerPage");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahkk($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_kk where id_kelurahan=$id_kelurahan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPencariankk($id_kelurahan, $pencarian, $id_pencarian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            if (!$pencarian) {
                $result = $db->fetchAll("SELECT  id_permintaan_kk, no_surat, tanggal_surat, nik, rt, status FROM permintaan_kk WHERE id_kelurahan = $id_kelurahan  LIMIT 0 , 30");
            } else {
                if ($id_pencarian == 1) {
                    $result = $db->fetchAll("SELECT  id_permintaan_kk, no_surat, tanggal_surat, nik, rt, status FROM permintaan_kk WHERE id_kelurahan = $id_kelurahan && no_surat = '$pencarian'  LIMIT 0 , 30");
                } else if ($id_pencarian == 2) {
                    $result = $db->fetchAll("SELECT  id_permintaan_kk, no_surat, tanggal_surat, nik, rt, status 
			FROM permintaan_kk WHERE id_kelurahan = $id_kelurahan && nik = '$pencarian'  LIMIT 0 , 30");
                }
            }
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanproseskk(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
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

            $where[] = " id_permintaan_kk = '" . $data['id_permintaan_kk'] . "'";

            $db->update('permintaan_kk', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function gethapuskk($id_permintaan_kk) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');


        try {
            $db->beginTransaction();
            $where[] = " id_permintaan_kk = '" . $id_permintaan_kk . "'";

            $db->delete('permintaan_kk', $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getkk($id_permintaan_kk) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*, b.*, c.* 
			FROM permintaan_kk a, data_penduduk b, pejabat_kelurahan c 
			WHERE  a.nik = b.nik  
			AND a.id_permintaan_kk = $id_permintaan_kk");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpankkedit(array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
                "id_permintaan_kk" => $data['id_permintaan_kk'],
                "keperluan" => $data['keperluan'],
                "ket" => $data['ket'],
                "nik" => $data['nik'],
                "no_surat" => $data['no_surat'],
                "tanggal_surat" => $data['tanggal_surat'],
                "no_surat_pengantar" => $data['no_surat_pengantar'],
                "tanggal_surat_pengantar" => $data['tanggal_surat_pengantar']);

            $where[] = " id_permintaan_kk = '" . $data['id_permintaan_kk'] . "'";

            $db->update('permintaan_kk', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());
            var_dump($errmsgArr);
            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    //		simpan selesai
    public function getSelesaikk($data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("status" => $data['status'],
                "waktu_selesai" => $data['waktu_selesai'],
                "waktu_total" => $data['waktu_total']
            );

            $where[] = " id_permintaan_kk = '" . $data['id_permintaan_kk'] . "'";

            $db->update('permintaan_kk', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getJumlahStatuskk1() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_kk where status='1'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahStatuskk2() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_kk where status='2'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    ////////////////////////////////////KARTU IDENTITAS KERJA
    public function getkartuidentitaskerjacetak($id_permintaan_kartuidentitaskerja) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*
			FROM permintaan_kartuidentitaskerja a, data_penduduk b, pejabat_kelurahan c, kelurahan k
			WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
			AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_kartuidentitaskerja = $id_permintaan_kartuidentitaskerja");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //proses simpan antrian -> status menjadi 1
    public function getsimpankartuidentitaskerjaantrian(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_pengguna" => $data['id_pengguna'],
                "id_kelurahan" => $data['id_kelurahan'],
                "no_registrasi" => $data['no_registrasi'],
                "nik" => $data['nik'],
                "waktu_antrian" => $data['waktu_antrian'],
                "antrian_oleh" => $data['antrian_oleh'],
                "jam_masuk" => $data['jam_masuk'],
                "status" => $data['status'],
                "no_telp" => $data['no_telp']
            );

            $db->insert('permintaan_kartuidentitaskerja', $paramInput);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getProseskartuidentitaskerja($id_kelurahan, $offset, $dataPerPage) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_kartuidentitaskerja a, data_penduduk b 
			WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik 
			ORDER BY  a.no_registrasi DESC 
			LIMIT $offset , $dataPerPage");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahkartuidentitaskerja($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_kartuidentitaskerja where id_kelurahan=$id_kelurahan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPencariankartuidentitaskerja($id_kelurahan, $pencarian, $id_pencarian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            if (!$pencarian) {
                $result = $db->fetchAll("SELECT  id_permintaan_kartuidentitaskerja, no_surat, tanggal_surat, nik, rt, status FROM permintaan_kartuidentitaskerja WHERE id_kelurahan = $id_kelurahan  LIMIT 0 , 30");
            } else {
                if ($id_pencarian == 1) {
                    $result = $db->fetchAll("SELECT  id_permintaan_kartuidentitaskerja, no_surat, tanggal_surat, nik, rt, status FROM permintaan_kartuidentitaskerja WHERE id_kelurahan = $id_kelurahan && no_surat = '$pencarian'  LIMIT 0 , 30");
                } else if ($id_pencarian == 2) {
                    $result = $db->fetchAll("SELECT  id_permintaan_kartuidentitaskerja, no_surat, tanggal_surat, nik, rt, status 
			FROM permintaan_kartuidentitaskerja WHERE id_kelurahan = $id_kelurahan && nik = '$pencarian'  LIMIT 0 , 30");
                }
            }
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanproseskartuidentitaskerja(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
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

            $where[] = " id_permintaan_kartuidentitaskerja = '" . $data['id_permintaan_kartuidentitaskerja'] . "'";

            $db->update('permintaan_kartuidentitaskerja', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function gethapuskartuidentitaskerja($id_permintaan_kartuidentitaskerja) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');


        try {
            $db->beginTransaction();
            $where[] = " id_permintaan_kartuidentitaskerja = '" . $id_permintaan_kartuidentitaskerja . "'";

            $db->delete('permintaan_kartuidentitaskerja', $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getkartuidentitaskerja($id_permintaan_kartuidentitaskerja) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*, b.*, c.* 
			FROM permintaan_kartuidentitaskerja a, data_penduduk b, pejabat_kelurahan c 
			WHERE  a.nik = b.nik  
			AND a.id_permintaan_kartuidentitaskerja = $id_permintaan_kartuidentitaskerja");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpankartuidentitaskerjaedit(array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
                "id_permintaan_kartuidentitaskerja" => $data['id_permintaan_kartuidentitaskerja'],
                "keperluan" => $data['keperluan'],
                "ket" => $data['ket'],
                "nik" => $data['nik'],
                "no_surat" => $data['no_surat'],
                "tanggal_surat" => $data['tanggal_surat'],
                "no_surat_pengantar" => $data['no_surat_pengantar'],
                "tanggal_surat_pengantar" => $data['tanggal_surat_pengantar']);

            $where[] = " id_permintaan_kartuidentitaskerja = '" . $data['id_permintaan_kartuidentitaskerja'] . "'";

            $db->update('permintaan_kartuidentitaskerja', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());
            var_dump($errmsgArr);
            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    //		simpan selesai
    public function getSelesaikartuidentitaskerja($data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("status" => $data['status'],
                "waktu_selesai" => $data['waktu_selesai'],
                "waktu_total" => $data['waktu_total']
            );

            $where[] = " id_permintaan_kartuidentitaskerja = '" . $data['id_permintaan_kartuidentitaskerja'] . "'";

            $db->update('permintaan_kartuidentitaskerja', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getJumlahStatuskartuidentitaskerja1() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_kartuidentitaskerja where status='1'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahStatuskartuidentitaskerja2() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_kartuidentitaskerja where status='2'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    /////////////////////////////////////////////////////////// IMB
    public function getimbcetak($id_permintaan_imb) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*
			FROM permintaan_imb a, data_penduduk b, pejabat_kelurahan c, kelurahan k
			WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
			AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_imb = $id_permintaan_imb");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //proses simpan antrian -> status menjadi 1
    public function getsimpanimbantrian(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_pengguna" => $data['id_pengguna'],
                "id_kelurahan" => $data['id_kelurahan'],
                "no_registrasi" => $data['no_registrasi'],
                "nik" => $data['nik'],
                "waktu_antrian" => $data['waktu_antrian'],
                "antrian_oleh" => $data['antrian_oleh'],
                "jam_masuk" => $data['jam_masuk'],
                "status" => $data['status'],
                "no_telp" => $data['no_telp']
            );

            $db->insert('permintaan_imb', $paramInput);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getProsesimb($id_kelurahan, $offset, $dataPerPage) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_imb a, data_penduduk b 
			WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik 
			ORDER BY  a.no_registrasi DESC 
			LIMIT $offset , $dataPerPage");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahimb($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_imb where id_kelurahan=$id_kelurahan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPencarianimb($id_kelurahan, $pencarian, $id_pencarian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            if (!$pencarian) {
                $result = $db->fetchAll("SELECT  id_permintaan_imb, no_surat, tanggal_surat, nik, rt, status FROM permintaan_imb WHERE id_kelurahan = $id_kelurahan  LIMIT 0 , 30");
            } else {
                if ($id_pencarian == 1) {
                    $result = $db->fetchAll("SELECT  id_permintaan_imb, no_surat, tanggal_surat, nik, rt, status FROM permintaan_imb WHERE id_kelurahan = $id_kelurahan && no_surat = '$pencarian'  LIMIT 0 , 30");
                } else if ($id_pencarian == 2) {
                    $result = $db->fetchAll("SELECT  id_permintaan_imb, no_surat, tanggal_surat, nik, rt, status 
			FROM permintaan_imb WHERE id_kelurahan = $id_kelurahan && nik = '$pencarian'  LIMIT 0 , 30");
                }
            }
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesimb(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
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

            $where[] = " id_permintaan_imb = '" . $data['id_permintaan_imb'] . "'";

            $db->update('permintaan_imb', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function gethapusimb($id_permintaan_imb) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');


        try {
            $db->beginTransaction();
            $where[] = " id_permintaan_imb = '" . $id_permintaan_imb . "'";

            $db->delete('permintaan_imb', $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getimb($id_permintaan_imb) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*, b.*, c.* 
			FROM permintaan_imb a, data_penduduk b, pejabat_kelurahan c 
			WHERE  a.nik = b.nik  
			AND a.id_permintaan_imb = $id_permintaan_imb");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanimbedit(array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
                "id_permintaan_imb" => $data['id_permintaan_imb'],
                "keperluan" => $data['keperluan'],
                "ket" => $data['ket'],
                "nik" => $data['nik'],
                "no_surat" => $data['no_surat'],
                "tanggal_surat" => $data['tanggal_surat'],
                "no_surat_pengantar" => $data['no_surat_pengantar'],
                "tanggal_surat_pengantar" => $data['tanggal_surat_pengantar']);

            $where[] = " id_permintaan_imb = '" . $data['id_permintaan_imb'] . "'";

            $db->update('permintaan_imb', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());
            var_dump($errmsgArr);
            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    //		simpan selesai
    public function getSelesaiimb($data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("status" => $data['status'],
                "waktu_selesai" => $data['waktu_selesai'],
                "waktu_total" => $data['waktu_total']
            );

            $where[] = " id_permintaan_imb = '" . $data['id_permintaan_imb'] . "'";

            $db->update('permintaan_imb', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getJumlahStatusimb1() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_imb where status='1'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahStatusimb2() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_imb where status='2'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //////////////// end imb
    /////////////////////////////////////////////////////////// SIUP
    public function getsiupcetak($id_permintaan_siup) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*
			FROM permintaan_siup a, data_penduduk b, pejabat_kelurahan c, kelurahan k
			WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
			AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_siup = $id_permintaan_siup");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //proses simpan antrian -> status menjadi 1
    public function getsimpansiupantrian(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_pengguna" => $data['id_pengguna'],
                "id_kelurahan" => $data['id_kelurahan'],
                "no_registrasi" => $data['no_registrasi'],
                "nik" => $data['nik'],
                "waktu_antrian" => $data['waktu_antrian'],
                "antrian_oleh" => $data['antrian_oleh'],
                "jam_masuk" => $data['jam_masuk'],
                "status" => $data['status'],
                "no_telp" => $data['no_telp']
            );

            $db->insert('permintaan_siup', $paramInput);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getProsessiup($id_kelurahan, $offset, $dataPerPage) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_siup a, data_penduduk b 
			WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik 
			ORDER BY  a.no_registrasi DESC 
			LIMIT $offset , $dataPerPage");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahsiup($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_siup where id_kelurahan=$id_kelurahan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPencariansiup($id_kelurahan, $pencarian, $id_pencarian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            if (!$pencarian) {
                $result = $db->fetchAll("SELECT  id_permintaan_siup, no_surat, tanggal_surat, nik, rt, status FROM permintaan_siup WHERE id_kelurahan = $id_kelurahan  LIMIT 0 , 30");
            } else {
                if ($id_pencarian == 1) {
                    $result = $db->fetchAll("SELECT  id_permintaan_siup, no_surat, tanggal_surat, nik, rt, status FROM permintaan_siup WHERE id_kelurahan = $id_kelurahan && no_surat = '$pencarian'  LIMIT 0 , 30");
                } else if ($id_pencarian == 2) {
                    $result = $db->fetchAll("SELECT  id_permintaan_siup, no_surat, tanggal_surat, nik, rt, status 
			FROM permintaan_siup WHERE id_kelurahan = $id_kelurahan && nik = '$pencarian'  LIMIT 0 , 30");
                }
            }
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosessiup(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
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

            $where[] = " id_permintaan_siup = '" . $data['id_permintaan_siup'] . "'";

            $db->update('permintaan_siup', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function gethapussiup($id_permintaan_siup) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');


        try {
            $db->beginTransaction();
            $where[] = " id_permintaan_siup = '" . $id_permintaan_siup . "'";

            $db->delete('permintaan_siup', $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getsiup($id_permintaan_siup) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*, b.*, c.* 
			FROM permintaan_siup a, data_penduduk b, pejabat_kelurahan c 
			WHERE  a.nik = b.nik  
			AND a.id_permintaan_siup = $id_permintaan_siup");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpansiupedit(array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
                "id_permintaan_siup" => $data['id_permintaan_siup'],
                "keperluan" => $data['keperluan'],
                "ket" => $data['ket'],
                "nik" => $data['nik'],
                "no_surat" => $data['no_surat'],
                "tanggal_surat" => $data['tanggal_surat'],
                "no_surat_pengantar" => $data['no_surat_pengantar'],
                "tanggal_surat_pengantar" => $data['tanggal_surat_pengantar']);

            $where[] = " id_permintaan_siup = '" . $data['id_permintaan_siup'] . "'";

            $db->update('permintaan_siup', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());
            var_dump($errmsgArr);
            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    //		simpan selesai
    public function getSelesaisiup($data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("status" => $data['status'],
                "waktu_selesai" => $data['waktu_selesai'],
                "waktu_total" => $data['waktu_total']
            );

            $where[] = " id_permintaan_siup = '" . $data['id_permintaan_siup'] . "'";

            $db->update('permintaan_siup', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getJumlahStatussiup1() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_siup where status='1'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahStatussiup2() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_siup where status='2'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //////////////// end siup
    /////////////////////////////////////////////////////////// adm pensiun
    public function getadmpensiuncetak($id_permintaan_adm_pensiun) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*
			FROM permintaan_adm_pensiun a, data_penduduk b, pejabat_kelurahan c, kelurahan k
			WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
			AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_adm_pensiun = $id_permintaan_adm_pensiun");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //proses simpan antrian -> status menjadi 1
    public function getsimpanadmpensiunantrian(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_pengguna" => $data['id_pengguna'],
                "id_kelurahan" => $data['id_kelurahan'],
                "no_registrasi" => $data['no_registrasi'],
                "nik" => $data['nik'],
                "waktu_antrian" => $data['waktu_antrian'],
                "antrian_oleh" => $data['antrian_oleh'],
                "jam_masuk" => $data['jam_masuk'],
                "status" => $data['status'],
                "no_telp" => $data['no_telp']
            );

            $db->insert('permintaan_adm_pensiun', $paramInput);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getProsesadmpensiun($id_kelurahan, $offset, $dataPerPage) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_adm_pensiun a, data_penduduk b 
			WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik 
			ORDER BY  a.no_registrasi DESC 
			LIMIT $offset , $dataPerPage");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahadmpensiun($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_adm_pensiun where id_kelurahan=$id_kelurahan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPencarianadmpensiun($id_kelurahan, $pencarian, $id_pencarian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            if (!$pencarian) {
                $result = $db->fetchAll("SELECT  id_permintaan_adm_pensiun, no_surat, tanggal_surat, nik, rt, status FROM permintaan_adm_pensiun WHERE id_kelurahan = $id_kelurahan  LIMIT 0 , 30");
            } else {
                if ($id_pencarian == 1) {
                    $result = $db->fetchAll("SELECT  id_permintaan_adm_pensiun, no_surat, tanggal_surat, nik, rt, status FROM permintaan_adm_pensiun WHERE id_kelurahan = $id_kelurahan && no_surat = '$pencarian'  LIMIT 0 , 30");
                } else if ($id_pencarian == 2) {
                    $result = $db->fetchAll("SELECT  id_permintaan_adm_pensiun, no_surat, tanggal_surat, nik, rt, status 
			FROM permintaan_adm_pensiun WHERE id_kelurahan = $id_kelurahan && nik = '$pencarian'  LIMIT 0 , 30");
                }
            }
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesadmpensiun(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
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

            $where[] = " id_permintaan_adm_pensiun = '" . $data['id_permintaan_adm_pensiun'] . "'";

            $db->update('permintaan_adm_pensiun', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function gethapusadmpensiun($id_permintaan_adm_pensiun) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');


        try {
            $db->beginTransaction();
            $where[] = " id_permintaan_adm_pensiun = '" . $id_permintaan_adm_pensiun . "'";

            $db->delete('permintaan_adm_pensiun', $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getadmpensiun($id_permintaan_adm_pensiun) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*, b.*, c.* 
			FROM permintaan_adm_pensiun a, data_penduduk b, pejabat_kelurahan c 
			WHERE  a.nik = b.nik  
			AND a.id_permintaan_adm_pensiun = $id_permintaan_adm_pensiun");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanadmpensiunedit(array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
                "id_permintaan_adm_pensiun" => $data['id_permintaan_adm_pensiun'],
                "keperluan" => $data['keperluan'],
                "ket" => $data['ket'],
                "nik" => $data['nik'],
                "no_surat" => $data['no_surat'],
                "tanggal_surat" => $data['tanggal_surat'],
                "no_surat_pengantar" => $data['no_surat_pengantar'],
                "tanggal_surat_pengantar" => $data['tanggal_surat_pengantar']);

            $where[] = " id_permintaan_adm_pensiun = '" . $data['id_permintaan_adm_pensiun'] . "'";

            $db->update('permintaan_adm_pensiun', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());
            var_dump($errmsgArr);
            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    //		simpan selesai
    public function getSelesaiadmpensiun($data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("status" => $data['status'],
                "waktu_selesai" => $data['waktu_selesai'],
                "waktu_total" => $data['waktu_total']
            );

            $where[] = " id_permintaan_adm_pensiun = '" . $data['id_permintaan_adm_pensiun'] . "'";

            $db->update('permintaan_adm_pensiun', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getJumlahStatusadmpensiun1() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_adm_pensiun where status='1'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahStatusadmpensiun2() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_adm_pensiun where status='2'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //////////////// end admpensiun
    /////////////////////////////////////////////////////////// SURAT KUASA
    public function getsuratkuasacetak($id_permintaan_suratkuasa) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*
			FROM permintaan_suratkuasa a, data_penduduk b, pejabat_kelurahan c, kelurahan k
			WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
			AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_suratkuasa = $id_permintaan_suratkuasa");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //proses simpan antrian -> status menjadi 1
    public function getsimpansuratkuasaantrian(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_pengguna" => $data['id_pengguna'],
                "id_kelurahan" => $data['id_kelurahan'],
                "no_registrasi" => $data['no_registrasi'],
                "nik" => $data['nik'],
                "waktu_antrian" => $data['waktu_antrian'],
                "antrian_oleh" => $data['antrian_oleh'],
                "jam_masuk" => $data['jam_masuk'],
                "status" => $data['status'],
                "no_telp" => $data['no_telp']
            );

            $db->insert('permintaan_suratkuasa', $paramInput);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getProsessuratkuasa($id_kelurahan, $offset, $dataPerPage) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_suratkuasa a, data_penduduk b 
			WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik 
			ORDER BY  a.no_registrasi DESC 
			LIMIT $offset , $dataPerPage");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahsuratkuasa($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_suratkuasa where id_kelurahan=$id_kelurahan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPencariansuratkuasa($id_kelurahan, $pencarian, $id_pencarian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            if (!$pencarian) {
                $result = $db->fetchAll("SELECT  id_permintaan_suratkuasa, no_surat, tanggal_surat, nik, rt, status FROM permintaan_suratkuasa WHERE id_kelurahan = $id_kelurahan  LIMIT 0 , 30");
            } else {
                if ($id_pencarian == 1) {
                    $result = $db->fetchAll("SELECT  id_permintaan_suratkuasa, no_surat, tanggal_surat, nik, rt, status FROM permintaan_suratkuasa WHERE id_kelurahan = $id_kelurahan && no_surat = '$pencarian'  LIMIT 0 , 30");
                } else if ($id_pencarian == 2) {
                    $result = $db->fetchAll("SELECT  id_permintaan_suratkuasa, no_surat, tanggal_surat, nik, rt, status 
			FROM permintaan_suratkuasa WHERE id_kelurahan = $id_kelurahan && nik = '$pencarian'  LIMIT 0 , 30");
                }
            }
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosessuratkuasa(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
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

            $where[] = " id_permintaan_suratkuasa = '" . $data['id_permintaan_suratkuasa'] . "'";

            $db->update('permintaan_suratkuasa', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function gethapussuratkuasa($id_permintaan_suratkuasa) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');


        try {
            $db->beginTransaction();
            $where[] = " id_permintaan_suratkuasa = '" . $id_permintaan_suratkuasa . "'";

            $db->delete('permintaan_suratkuasa', $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getsuratkuasa($id_permintaan_suratkuasa) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*, b.*, c.* 
			FROM permintaan_suratkuasa a, data_penduduk b, pejabat_kelurahan c 
			WHERE  a.nik = b.nik  
			AND a.id_permintaan_suratkuasa = $id_permintaan_suratkuasa");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpansuratkuasaedit(array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
                "id_permintaan_suratkuasa" => $data['id_permintaan_suratkuasa'],
                "keperluan" => $data['keperluan'],
                "ket" => $data['ket'],
                "nik" => $data['nik'],
                "no_surat" => $data['no_surat'],
                "tanggal_surat" => $data['tanggal_surat'],
                "no_surat_pengantar" => $data['no_surat_pengantar'],
                "tanggal_surat_pengantar" => $data['tanggal_surat_pengantar']);

            $where[] = " id_permintaan_suratkuasa = '" . $data['id_permintaan_suratkuasa'] . "'";

            $db->update('permintaan_suratkuasa', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());
            var_dump($errmsgArr);
            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    //		simpan selesai
    public function getSelesaisuratkuasa($data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("status" => $data['status'],
                "waktu_selesai" => $data['waktu_selesai'],
                "waktu_total" => $data['waktu_total']
            );

            $where[] = " id_permintaan_suratkuasa = '" . $data['id_permintaan_suratkuasa'] . "'";

            $db->update('permintaan_suratkuasa', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getJumlahStatussuratkuasa1() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_suratkuasa where status='1'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahStatussuratkuasa2() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_suratkuasa where status='2'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //////////////// end suratkuasa
    /////////////////////////////////////////////////////////// Rekomendasi Proposal
    public function getrekomendasiproposalpembcetak($id_permintaan_rekomendasi_pembangunan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*
			FROM permintaan_rekomendasi_proposal a, data_penduduk b, pejabat_kelurahan c, kelurahan k
			WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
			AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_rekomendasi_pembangunan = $id_permintaan_rekomendasi_pembangunan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //		proses simpan antrian -> status menjadi 1
    public function getsimpanrekomendasiproposalpembantrian(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_pengguna" => $data['id_pengguna'],
                "id_kelurahan" => $data['id_kelurahan'],
                "no_registrasi" => $data['no_registrasi'],
                "nik" => $data['nik'],
                "waktu_antrian" => $data['waktu_antrian'],
                "antrian_oleh" => $data['antrian_oleh'],
                "jam_masuk" => $data['jam_masuk'],
                "status" => $data['status'],
                "no_telp" => $data['no_telp']
            );

            $db->insert('permintaan_rekomendasi_proposal', $paramInput);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getProsesrekomendasiproposalpemb($id_kelurahan, $offset, $dataPerPage) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_rekomendasi_proposal a, data_penduduk b 
			WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik 
			ORDER BY  a.no_registrasi DESC 
			LIMIT $offset , $dataPerPage");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahrekomendasiproposalpemb($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_rekomendasi_proposal where id_kelurahan=$id_kelurahan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPencarianrekomendasiproposalpemb($id_kelurahan, $pencarian, $id_pencarian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            if (!$pencarian) {
                $result = $db->fetchAll("SELECT  id_permintaan_rekomendasi_pembangunan, no_surat, tanggal_surat, nik, rt, status FROM permintaan_rekomendasi_proposal WHERE id_kelurahan = $id_kelurahan  LIMIT 0 , 30");
            } else {
                if ($id_pencarian == 1) {
                    $result = $db->fetchAll("SELECT  id_permintaan_rekomendasi_pembangunan, no_surat, tanggal_surat, nik, rt, status FROM permintaan_rekomendasi_proposal WHERE id_kelurahan = $id_kelurahan && no_surat = '$pencarian'  LIMIT 0 , 30");
                } else if ($id_pencarian == 2) {
                    $result = $db->fetchAll("SELECT  id_permintaan_rekomendasi_pembangunan, no_surat, tanggal_surat, nik, rt, status 
			FROM permintaan_rekomendasi_proposal WHERE id_kelurahan = $id_kelurahan && nik = '$pencarian'  LIMIT 0 , 30");
                }
            }
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesrekomendasiproposalpemb(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
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
                "proposal_dari" => $data['proposal_dari'],
                "alamat_proposal" => $data['alamat_proposal'],
                "ditujukan_ke" => $data['ditujukan_ke'],
                "ket" => $data['ket']);

            $where[] = " id_permintaan_rekomendasi_pembangunan = '" . $data['id_permintaan_rekomendasi_pembangunan'] . "'";

            $db->update('permintaan_rekomendasi_proposal', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function gethapusrekomendasiproposalpemb($id_permintaan_rekomendasi_pembangunan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');


        try {
            $db->beginTransaction();
            $where[] = " id_permintaan_rekomendasi_pembangunan = '" . $id_permintaan_rekomendasi_pembangunan . "'";

            $db->delete('permintaan_rekomendasi_proposal', $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getrekomendasiproposalpemb($id_permintaan_rekomendasi_pembangunan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*, b.*, c.* 
			FROM permintaan_rekomendasi_proposal a, data_penduduk b, pejabat_kelurahan c 
			WHERE  a.nik = b.nik  
			AND a.id_permintaan_rekomendasi_pembangunan = $id_permintaan_rekomendasi_pembangunan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanrekomendasiproposalpembedit(array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
                "id_permintaan_rekomendasi_pembangunan" => $data['id_permintaan_rekomendasi_pembangunan'],
                "keperluan" => $data['keperluan'],
                "proposal_dari" => $data['proposal_dari'],
                "alamat_proposal" => $data['alamat_proposal'],
                "ditujukan_ke" => $data['ditujukan_ke'],
                "ket" => $data['ket'],
                "nik" => $data['nik'],
                "no_surat" => $data['no_surat'],
                "tanggal_surat" => $data['tanggal_surat'],
                "no_surat_pengantar" => $data['no_surat_pengantar'],
                "tanggal_surat_pengantar" => $data['tanggal_surat_pengantar']);

            $where[] = " id_permintaan_rekomendasi_pembangunan = '" . $data['id_permintaan_rekomendasi_pembangunan'] . "'";

            $db->update('permintaan_rekomendasi_proposal', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());
            var_dump($errmsgArr);
            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    //		simpan selesai
    public function getSelesairekomendasiproposalpemb($data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("status" => $data['status'],
                "waktu_selesai" => $data['waktu_selesai'],
                "waktu_total" => $data['waktu_total']
            );

            $where[] = " id_permintaan_rekomendasi_pembangunan = '" . $data['id_permintaan_rekomendasi_pembangunan'] . "'";

            $db->update('permintaan_rekomendasi_proposal', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getJumlahStatusrekomendasiproposalpemb1() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_rekomendasi_proposal where status='1'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahStatusrekomendasiproposalpemb2() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_rekomendasi_proposal where status='2'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //////////////// end rekomendasiproposalpemb
    /////////////////////////////////////////////////////////// BELUM BEKERJA
    public function getbelumbekerjacetak($id_permintaan_belum_bekerja) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*, b.*, c.* , k.*
			FROM permintaan_belum_bekerja a, data_penduduk b, pejabat_kelurahan c, kelurahan k
			WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat 
			AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_belum_bekerja = $id_permintaan_belum_bekerja");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //proses simpan antrian -> status menjadi 1
    public function getsimpanbelumbekerjaantrian(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_pengguna" => $data['id_pengguna'],
                "id_kelurahan" => $data['id_kelurahan'],
                "no_registrasi" => $data['no_registrasi'],
                "nik" => $data['nik'],
                "waktu_antrian" => $data['waktu_antrian'],
                "antrian_oleh" => $data['antrian_oleh'],
                "jam_masuk" => $data['jam_masuk'],
                "status" => $data['status'],
                "no_telp" => $data['no_telp']
            );

            $db->insert('permintaan_belum_bekerja', $paramInput);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getProsesbelumbekerja($id_kelurahan, $offset, $dataPerPage) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_belum_bekerja a, data_penduduk b 
			WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik 
			ORDER BY  a.no_registrasi DESC 
			LIMIT $offset , $dataPerPage");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahbelumbekerja($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_belum_bekerja where id_kelurahan=$id_kelurahan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPencarianbelumbekerja($id_kelurahan, $pencarian, $id_pencarian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            if (!$pencarian) {
                $result = $db->fetchAll("SELECT  id_permintaan_belum_bekerja, no_surat, tanggal_surat, nik, rt, status FROM permintaan_belum_bekerja WHERE id_kelurahan = $id_kelurahan  LIMIT 0 , 30");
            } else {
                if ($id_pencarian == 1) {
                    $result = $db->fetchAll("SELECT  id_permintaan_belum_bekerja, no_surat, tanggal_surat, nik, rt, status FROM permintaan_belum_bekerja WHERE id_kelurahan = $id_kelurahan && no_surat = '$pencarian'  LIMIT 0 , 30");
                } else if ($id_pencarian == 2) {
                    $result = $db->fetchAll("SELECT  id_permintaan_belum_bekerja, no_surat, tanggal_surat, nik, rt, status 
			FROM permintaan_belum_bekerja WHERE id_kelurahan = $id_kelurahan && nik = '$pencarian'  LIMIT 0 , 30");
                }
            }
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosesbelumbekerja(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
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

            $where[] = " id_permintaan_belum_bekerja = '" . $data['id_permintaan_belum_bekerja'] . "'";

            $db->update('permintaan_belum_bekerja', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function gethapusbelumbekerja($id_permintaan_belum_bekerja) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');


        try {
            $db->beginTransaction();
            $where[] = " id_permintaan_belum_bekerja = '" . $id_permintaan_belum_bekerja . "'";

            $db->delete('permintaan_belum_bekerja', $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getbelumbekerja($id_permintaan_belum_bekerja) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*, b.*, c.* 
			FROM permintaan_belum_bekerja a, data_penduduk b, pejabat_kelurahan c 
			WHERE  a.nik = b.nik  
			AND a.id_permintaan_belum_bekerja = $id_permintaan_belum_bekerja");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanbelumbekerjaedit(array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
                "id_permintaan_belum_bekerja" => $data['id_permintaan_belum_bekerja'],
                "keperluan" => $data['keperluan'],
                "ket" => $data['ket'],
                "nik" => $data['nik'],
                "no_surat" => $data['no_surat'],
                "tanggal_surat" => $data['tanggal_surat'],
                "no_surat_pengantar" => $data['no_surat_pengantar'],
                "tanggal_surat_pengantar" => $data['tanggal_surat_pengantar']);

            $where[] = " id_permintaan_belum_bekerja = '" . $data['id_permintaan_belum_bekerja'] . "'";

            $db->update('permintaan_belum_bekerja', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());
            var_dump($errmsgArr);
            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    //		simpan selesai
    public function getSelesaibelumbekerja($data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("status" => $data['status'],
                "waktu_selesai" => $data['waktu_selesai'],
                "waktu_total" => $data['waktu_total']
            );

            $where[] = " id_permintaan_belum_bekerja = '" . $data['id_permintaan_belum_bekerja'] . "'";

            $db->update('permintaan_belum_bekerja', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getJumlahStatusbelumbekerja1() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_belum_bekerja where status='1'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahStatusbelumbekerja2() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_belum_bekerja where status='2'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //////////////// end belumbekerja	
    /////////////////////////////////////////////////////////// PENELITIAN
    public function getpenelitiancetak($id_permintaan_penelitian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*,  c.* , k.*
			FROM permintaan_penelitian a, pejabat_kelurahan c, kelurahan k
			WHERE  a.id_pejabat = c.id_pejabat 
			AND a.id_kelurahan=k.id_kelurahan AND a.id_permintaan_penelitian = $id_permintaan_penelitian");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //proses simpan antrian -> status menjadi 1
    public function getsimpanpenelitianantrian(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_pengguna" => $data['id_pengguna'],
                "id_kelurahan" => $data['id_kelurahan'],
                "no_registrasi" => $data['no_registrasi'],
                "nik" => $data['nik'],
                "waktu_antrian" => $data['waktu_antrian'],
                "antrian_oleh" => $data['antrian_oleh'],
                "jam_masuk" => $data['jam_masuk'],
                "status" => $data['status'],
                "no_telp" => $data['no_telp']
            );

            $db->insert('permintaan_penelitian', $paramInput);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getProsespenelitian($id_kelurahan, $offset, $dataPerPage) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchAll("SELECT a.*, b.* FROM permintaan_penelitian a, data_penduduk b 
			WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik 
			ORDER BY  a.no_registrasi DESC 
			LIMIT $offset , $dataPerPage");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahpenelitian($id_kelurahan) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah from permintaan_penelitian where id_kelurahan=$id_kelurahan");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getPencarianpenelitian($id_kelurahan, $pencarian, $id_pencarian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            if (!$pencarian) {
                $result = $db->fetchAll("SELECT  id_permintaan_penelitian, no_surat, tanggal_surat, nik, rt, status FROM permintaan_penelitian WHERE id_kelurahan = $id_kelurahan  LIMIT 0 , 30");
            } else {
                if ($id_pencarian == 1) {
                    $result = $db->fetchAll("SELECT  id_permintaan_penelitian, no_surat, tanggal_surat, nik, rt, status FROM permintaan_penelitian WHERE id_kelurahan = $id_kelurahan && no_surat = '$pencarian'  LIMIT 0 , 30");
                } else if ($id_pencarian == 2) {
                    $result = $db->fetchAll("SELECT  id_permintaan_penelitian, no_surat, tanggal_surat, nik, rt, status 
			FROM permintaan_penelitian WHERE id_kelurahan = $id_kelurahan && nik = '$pencarian'  LIMIT 0 , 30");
                }
            }
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanprosespenelitian(Array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
                "keperluan" => $data['keperluan'],
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
                "ket" => $data['ket'],
                "kegiatanawal" => $data['kegiatanawal'],
                "kegiatanakhir" => $data['kegiatanakhir']
            );

            $where[] = " id_permintaan_penelitian = '" . $data['id_permintaan_penelitian'] . "'";

            $db->update('permintaan_penelitian', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function gethapuspenelitian($id_permintaan_penelitian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');

        try {
            $db->beginTransaction();
            $where[] = " id_permintaan_penelitian = '" . $id_permintaan_penelitian . "'";

            $db->delete('permintaan_penelitian', $where);
            $db->commit();

            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());

            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    public function getpenelitian($id_permintaan_penelitian) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchRow("SELECT a.*, b.*, c.* 
			FROM permintaan_penelitian a, data_penduduk b, pejabat_kelurahan c 
			WHERE  a.nik = b.nik  
			AND a.id_permintaan_penelitian = $id_permintaan_penelitian");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getsimpanpenelitianedit(array $data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("id_kelurahan" => $data['id_kelurahan'],
                "id_permintaan_penelitian" => $data['id_permintaan_penelitian'],
                "keperluan" => $data['keperluan'],
                "ket" => $data['ket'],
                "nik" => $data['nik'],
                "no_surat" => $data['no_surat'],
                "tanggal_surat" => $data['tanggal_surat'],
                "no_surat_pengantar" => $data['no_surat_pengantar'],
                "tanggal_surat_pengantar" => $data['tanggal_surat_pengantar']);

            $where[] = " id_permintaan_penelitian = '" . $data['id_permintaan_penelitian'] . "'";

            $db->update('permintaan_penelitian', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            $errmsgArr = explode(":", $e->getMessage());
            var_dump($errmsgArr);
            $errMsg = $errmsgArr[0];

            if ($errMsg == "SQLSTATE[23000]") {
                return "gagal.Data Sudah Ada.";
            } else {
                return "sukses";
            }
        }
    }

    //simpan selesai
    public function getSelesaipenelitian($data) {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->beginTransaction();
            $paramInput = array("status" => $data['status'],
                "waktu_selesai" => $data['waktu_selesai'],
                "waktu_total" => $data['waktu_total']
            );

            $where[] = " id_permintaan_penelitian = '" . $data['id_permintaan_penelitian'] . "'";

            $db->update('permintaan_penelitian', $paramInput, $where);
            $db->commit();
            return 'sukses';
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . '<br>';
            return 'gagal';
        }
    }

    public function getJumlahStatuspenelitian1() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status1 from permintaan_penelitian where status='1'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    public function getJumlahStatuspenelitian2() {
        $registry = Zend_Registry::getInstance();
        $db = $registry->get('db');
        try {
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $result = $db->fetchOne("SELECT  COUNT(*) AS jumlah_status2 from permintaan_penelitian where status='2'");
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            return 'Data tidak ada <br>';
        }
    }

    //////////////// end penelitian
}

?>							