<? include "header.phtml"; ?>
<? include "menubaradmin.phtml"; ?>
<?// include "barkanan.phtml"; ?>
      <div id="contentadmin">
        <h1>Data Pengguna</h1>
		
		<form action="<? echo $this->basePath;?>/home/index/tanggalrs" method="post">
		<div class="form_settings2">
				<select name="bln">
				<option selected="selected">Bulan</option>
				<?php
				$bulan_ind=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
				$bulan=array("January","Februari","March","April","May","June","July","August","September","October","November","December");
				$jlh_bln=count($bulan_ind);
				for($c=0; $c<$jlh_bln; $c+=1){
					echo"<option value=$bulan[$c]> $bulan_ind[$c] </option>";
				}
				?>
				</select>
				<select name="thn">
				<option selected="selected">Tahun</option>
				<?php
				for($i=date('Y'); $i>=2010; $i-=1){
				echo"<option value=$i> $i </option>";
				}
				?>
				</select>
				<input class="submit" type="submit" name="name" value="cari" />
			 </div>
		</form><br>
		
		<table style="width:100%; border-spacing:0;">
          <tr align ="center">
			  <th>No</th>
			  <th>Jenis Pengguna</th>
			  <th>Kelurahan</th>
			  <th>Nama</th>
			  <th>NIP</th>
			  <th>Username</th>
			  <th>Password</th>
			  <th colspan=2>Aksi</th>
		  </tr>
		  <?php $i=1; foreach($this->Pengguna as $data) : ?>
			<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $this->escape($data->nama_jenis_pengguna);?></td>	
            <td><?php echo $this->escape($data->nama_kelurahan);?></td>
            <td><?php echo $this->escape($data->nama_pengguna);?></td>
            <td><?php echo $this->escape($data->nip_pengguna);?></td>
            <td><?php echo $this->escape($data->username);?></td>
            <td><?php echo $this->escape($data->password);?></td>
			
			
            <td><a href="<?php echo $this->basePath; ?>/home/index/penggunaedit?id_pengguna=<?php echo $this->escape($data->id_pengguna);?> "title="edit"><img src="<? echo $this->basePath;?>/images/user_edit.png" alt="" title="" border="0" /></a></td>
            <td><a href="<?php echo $this->basePath; ?>/home/index/penggunahapus?id_pengguna=<?php echo $this->escape($data->id_pengguna);?>" title="hapus" class="ask"><img src="<? echo $this->basePath;?>/images/trash.png" alt="" title="" border="0" /></a></td>
		
			
        </tr>
		<?php $i++; endforeach; ?>
          
        </table>
      </div>
	 </div>
	
   <?include "footer.phtml"; ?>