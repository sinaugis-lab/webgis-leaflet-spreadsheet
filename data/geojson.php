<?php
	include 'spreadsheetconfig.php';

  $rowCount = 0;
  $features = array();
  $error = FALSE;
  $output = array();

  // attempt to set the socket timeout, if it fails then echo an error
  if ( ! ini_set('default_socket_timeout', 15))
  {
    $output = array('error' => 'Unable to Change PHP Socket Timeout');
    $error = TRUE;
  } // end if, set socket timeout

  // if the opening the CSV file handler does not fail
  if ( !$error && (($dataHandle = fopen($dataSpreadsheetUrl, "r")) !== FALSE) )
  {
    // while CSV has data, read up to 10000 rows
    while (($csvRow = fgetcsv($dataHandle, 10000, ",")) !== FALSE)
    {
      $rowCount++;
      if ($rowCount == 1) { continue; } // skip the first/header row of the CSV

      $output[] = array(
        'features' => array(
          'KODE' => $csvRow[0],
          'KECAMATAN' => $csvRow[1],
          'POSITIF' => $csvRow[2],
          'ODP' => $csvRow[3],
          'PDP' => $csvRow[4],
          'DIRAWAT' => $csvRow[5],
          'SEMBUH' => $csvRow[6],
          'MENINGGAL' => $csvRow[7],
          'KABUPATEN' => $csvRow[8],
        )
      );
    } // end while, loop through CSV data

    fclose($dataHandle); // close the CSV file handler
    
  }  // end if , read file handler opened

  // else, file didn't open for reading
  else
  {
    $output = array('error' => 'Problem Reading Google CSV');
  }  // end else, file open fail

  //Read geojson file
  $geojsonAdmin = file_get_contents("diy/batas_kecamatan_diy.geojson");
  $polygonAdmin = json_decode($geojsonAdmin, TRUE);

  
	foreach ($polygonAdmin['features'] as $key => $first_value) {
      foreach ($output as $second_value) {
        if($first_value['properties']['WADMKC']==$second_value['features']['KECAMATAN']){
        	$polygonAdmin['features'][$key]['properties']['POSITIF'] = $second_value['features']['POSITIF'];
          $polygonAdmin['features'][$key]['properties']['ODP'] = $second_value['features']['ODP'];
          $polygonAdmin['features'][$key]['properties']['PDP'] = $second_value['features']['PDP'];
          $polygonAdmin['features'][$key]['properties']['DIRAWAT'] = $second_value['features']['DIRAWAT'];
          $polygonAdmin['features'][$key]['properties']['SEMBUH'] = $second_value['features']['SEMBUH'];
          $polygonAdmin['features'][$key]['properties']['MENINGGAL'] = $second_value['features']['MENINGGAL'];
          $polygonAdmin['features'][$key]['properties']['KABUPATEN'] = $second_value['features']['KABUPATEN'];
        } else {}
      } 
  }

	$combined_output = json_encode($polygonAdmin, JSON_NUMERIC_CHECK); 

	header("Access-Control-Allow-Origin: *");
  // header('Cache-Control: no-cache, must-revalidate');
	header('Content-Type: application/json');
	echo $combined_output;
?>