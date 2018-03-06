<?php
require 'vendor/autoload.php';
set_time_limit(0);
use Symfony\Component\DomCrawler\Crawler;
$url = "http://sou.zhaopin.com/jobs/searchresult.ashx?jl=%E6%88%90%E9%83%BD&kw=PHP&sm=0&p=1";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$re = curl_exec($ch);
file_put_contents('./zhaopinginfo.txt', $re);

$crawler = new Crawler($re);
//$table = $crawler->filterXPath('//table[@class="newlist"]/tr');
$table = $crawler->filterXPath('//table[@class="newlist"]/tr/td');
/*$j = 1;
foreach($table as $k=>$v){
	if($j%7 == 1){
	var_dump($v->textContent);
		
	}
	$j++;
	

}
die;*/
//$raw = $crawler->filter('table > tr > td');
$i = 1;
$file = 'info2.txt';
$fhandler = fopen($file, 'a+');
$tmp = array();
foreach($table as $k=>$v){
	if($i%7 == 1){
		$title = trim($v->textContent);
		fwrite($fhandler, $title.",");
		$i++;
		continue;
	}
	else if($i%7 == 3){
		$company = trim($v->textContent);
		fwrite($fhandler, $company.",");
		$i++;
		continue;
	}else if($i%7 == 4){
		$salary = trim($v->textContent);
		fwrite($fhandler, $salary.",");
		$i++;
		continue;
	}else if($i%7 == 5){
		$location = trim($v->textContent);
		fwrite($fhandler, $location."\n");
		$i++;
		continue;
	}else{
		$i++;
		continue;
	}

	
}

fclose($fhandler);

function rawtocsv($content){
	$re = trim($content);
	//$re = str_replace(' ','', $re);

	$str = preg_replace('#\s+#'," ",$re);
	return $str;
}