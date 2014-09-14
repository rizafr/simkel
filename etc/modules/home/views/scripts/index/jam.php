 <?
  function jumlah($a){
			date_default_timezone_set('Asia/Jakarta');
			
			$a = explode(":", $a);  
			$a_hour    = $a[0];
			$a_minutes = $a[1];
			$a_seconds = $a[2];
	
			$detik_menit = $a_menutes * 60;
			$jumlah_detik = $detik_menit + $a_second;
			
			
			return $jumlah_detik;
		}
		
?>