<?php

$filename = "./info_10pages.txt";
$handler = fopen($filename, "r");
$handler2 = fopen('./result.txt','a');
while(($data = fgetcsv($handler, 1000, ",")) !== false){
	$data[3] = preg_replace('/(.+)(-.*)/','${1}',$data[3]);
	$data[2] = preg_replace('/(.+)-(.*)/','${1}',$data[2]);
	$data[2] = intval($data[2]);
	var_dump($data[3],$data[2]);
	fwrite($handler2, $data[3].' '.$data[2]."\n");
}
fclose($handler2);

fclose($filename);

/*
data analysis

sql1:select AVG(COL22) as average_sal, col1 as location from table_3 where COL22 > 0 group by col1 order by average_sal desc
calculate average sal from data with respect to location
re:
12625 6885 6036 4173
Beijing Shanghai Guangzhou Chengdu

sql2:select Count(*) as vacancies, col1 as location from table_3 where col22>0 group by col1 order by vacancies desc
re:
392 363 243 242
Beingjing Shanghai Chengdu Guangzhou

 */