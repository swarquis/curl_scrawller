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
$table = $crawler->filterXPath('//table[@class="newlist"]/tr');
$i = 0;
$file = 'info.csv';
$fhandler = fopen($file, 'a+');
foreach($table as $k=>$v){
	/*$content = $crawler->filterXPath('//table[@class="newlist"]/tr[0]');
	$detail = $crawler->filterXPath('//table[@class="newlist"]/tr[1]');*/
	//$record = strip_tags(trim($v->textContent));
	//$pattern = '#\s+#m';
	//preg_replace($pattern,'',$record);
	//$arr = explode('\n', $record);
	if($i%2 == 0){
		$detail = $v->textContent;
		$detail = rawtocsv($detail);
		if($i == 0){
			$i++;
			continue;
		}

		print($detail);die;
		fwrite($fhandler, $detail."\n");
	}else{
		$content = $v->textContent;
		$content = rawtocsv($content);
	}
	
	$i++;

	
}
fclose($fhandler);

function rawtocsv($content){
	$re = trim($content);
	//$re = str_replace(' ','', $re);

	$str = preg_replace('#\s+#'," ",$re);
	return $str;
}