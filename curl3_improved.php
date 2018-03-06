<?php
require 'vendor/autoload.php';
set_time_limit(0);
use Symfony\Component\DomCrawler\Crawler;



$i = 1;

function loadpage($j){
	$ch = curl_init();
	
	$url = "http://sou.zhaopin.com/jobs/searchresult.ashx?jl=%E6%88%90%E9%83%BD%2b%E5%8C%97%E4%BA%AC%2b%E4%B8%8A%E6%B5%B7%2b%E5%B9%BF%E5%B7%9E&kw=php&isadv=0&sg=8fadebacbec34d6e8fb32ede4a7a1267&p=".$j."";
	
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$re = curl_exec($ch);
	return $re;
	//curl_close($ch);
}
for($j = 0; $j <= 20; $j++){
	$re1 = loadpage($j);
	parsepage($re1);
}
function parsepage($re){
	$file = 'info_10pages.txt';

	$fhandler = fopen($file, 'a+');
	$crawler = new Crawler($re);
	$table = $crawler->filterXPath('//table[@class="newlist"]/tr/td');
	$i = 1;
	foreach($table as $k=>$v){
/*		if($i%7 == 0){
			$i == 1;
			continue;
		}*/
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
	
}




function rawtocsv($content){
	$re = trim($content);
	//$re = str_replace(' ','', $re);

	$str = preg_replace('#\s+#'," ",$re);
	return $str;
}