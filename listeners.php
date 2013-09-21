<?php

$servers = array
			(
				'198.27.74.214' => array('port' => '9000', 'sid' => '1'),
				'198.27.74.214' => array('port' => '9000', 'sid' => '1'),
				'198.27.74.214' => array('port' => '9000', 'sid' => '1'),
				'198.27.74.214' => array('port' => '9000', 'sid' => '1'),
				'198.27.74.214' => array('port' => '9000', 'sid' => '1'),
			);

$current_listeners = 0;

foreach ($servers as $server => $settings)
{
	$url = "http://$server:". $settings['port'] ."/stats?sid=". $settings['sid'];
	$raw_data = file_get_contents($url);
	$data = new SimpleXMLElement($raw_data);
	
	$current_listeners += $data->CURRENTLISTENERS;
}

echo $current_listeners ."\n";

?>