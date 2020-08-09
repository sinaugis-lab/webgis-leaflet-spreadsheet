<?php
	include 'spreadsheetconfig.php';

	$rowCount = 0;
	$dashboardHandle = fopen($dashboardSpreadsheetUrl, "r");

	//Loop through the CSV rows.
	while (($row = fgetcsv($dashboardHandle, 0, ",")) !== FALSE) {
		$rowCount++;
		if ($rowCount == 1) { continue; } // skip the first/header row of the CSV
	    //Print out my column data.
	  
	  $i = 0;
	  $judul_tab = $row[$i++];
	  $navbar_icon = $row[$i++];
		$judul_navbar = $row[$i++];
		$attribution = $row[$i++];
		$instansi = $row[$i++];
		$email = $row[$i++];
		$telepon = $row[$i++];
		$alamat = $row[$i++];
		$spreadsheet_url = $row[$i++];
		$judul_total_positif = $row[$i++];
		$judul_total_odp = $row[$i++];
		$judul_total_pdp = $row[$i++];
		$judul_total_dirawat = $row[$i++];
		$judul_total_sembuh = $row[$i++];
		$judul_total_meninggal = $row[$i++];
		$judul_tabel = $row[$i++];
	}
	fclose($dashboardHandle); // close the CSV file handler
?>