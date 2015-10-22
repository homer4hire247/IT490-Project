#!/usr/bin/php
<?php
 	ini_set('display_errors',1);
        ini_set('display_startup_errors',1);
        error_reporting(-1);

	function get_data($url)
        {
                $ch = curl_init();
                $timeout = 5;
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                $data = curl_exec($ch);
                curl_close($ch);
                return $data;
        }

	for ($x = 1; $x <= 10; $x++)
        {
               // $timeToSleep++;
               // if($timeToSleep == 5)
               // {
                       // sleep(30);
                       // $timeToSleep = 0;
               // }
                $json = 'http://www.giantbomb.com/api/game/3030-'.$x.'/?api_key=193e8694d3f76bad6edbce7452d3154ad8731a64&format=json&field_list=name';
                $data = get_data($json);
                $obj = json_decode($data);
                $name = $obj->{'results'};
                $game[$x] = $name->{'name'};
        }
	

	$connection = new MongoClient("mongodb://testadmin:12adam12@ds041633.mongolab.com:41633/it420");

	$db = $connection->selectDB("it420");
	$owner = $db->selectCollection('games');
	$owner->insert(array('owner' => 'agoldman','Titles' => $game));
	$connection->close();

?>
