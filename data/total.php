<?php
  include 'spreadsheetconfig.php';
  
  $rowCount = 0;
  $totalHandle = fopen($totalSpreadsheetUrl, "r");
  
  while (($row = fgetcsv($totalHandle, 0, ",")) !== FALSE)
  {
    $rowCount++;
    if ($rowCount == 1) { continue; } // skip the first/header row of the CSV

    $i = 0;
    $totalpositif = $row[$i++];
    $totalodp = $row[$i++];
    $totalpdp = $row[$i++];
    $totaldirawat = $row[$i++];
    $totalsembuh = $row[$i++];
    $totalmeninggal = $row[$i++];
    $tanggalupdatedata = $row[$i++];
  } // end while, loop through CSV data
  fclose($totalHandle);
?>