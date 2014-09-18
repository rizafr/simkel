<?php
public function konfersitotalwaktu($total_detik){
	//konfersi total_detik ke menit detik		 
	$jam = floor($total_detik/3600);
	$sisa = $total_detik% 3600;
	$menit = floor($sisa/60);
	$sisa = $sisa % 60;
	$detik = floor($sisa/1);
	
	return($jam, $menit, $detik);
}
?>