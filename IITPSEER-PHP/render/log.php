<?php
date_default_timezone_set('Asia/Calcutta');
//post data log
$date=date('d_F_Y_h_i_s_A');
$values = '';
$errRef = time();
foreach($_POST as $key=>$value) {
  if($key!='apiKey')
    $values.= "\t".$key . "=" . $value . "\n";
}
 
$finalstring= "\n --------------\n$errRef\t [".$_SERVER['REMOTE_ADDR']."] \n [$date] \n  $values ";
$filename = 'logs/p_log.txt';
$handle = fopen($filename, 'a');
fwrite($handle, $values);
fclose($handle);
function errorLog($error){
	$filename = 'logs/errorLog.txt';
	$finalstring= "\n --------------\n$errRef\t [".$_SERVER['REMOTE_ADDR']."] \n [$date] \n  $error";
	$handle = fopen($filename, 'a');
	fwrite($handle, $values);
	fclose($handle);
}