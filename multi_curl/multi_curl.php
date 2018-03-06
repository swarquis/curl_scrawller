<?php
require_once __DIR__."/../vendor/autoload.php";
set_time_limit(0);
use Symfony\Component\DomCrawler\Crawler;
// create both cURL resources
$mh = curl_multi_init();
$start = microtime(true);
for($i = 0; $i < 21; $i++){
    
       $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://sou.zhaopin.com/jobs/searchresult.ashx?in=210500%3B160400%3B160000%3B160600&jl=%E6%88%90%E9%83%BD%2B%E4%B8%8A%E6%B5%B7%2B%E9%87%8D%E5%BA%86%2B%E5%8E%A6%E9%97%A8%2B%E5%93%88%E5%B0%94%E6%BB%A8&kw=PHP&sm=0&p=".$i);
        curl_setopt($ch, CURLOPT_HEADER, 0); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_multi_add_handle($mh,$ch);
        $charr[$i] = $ch;
   
}


$active = 0;
//execute the handles
/*do {
    $mrc = curl_multi_exec($mh, $active);

} while ($mrc == CURLM_CALL_MULTI_PERFORM);


while ($active && $mrc == CURLM_OK) {
    if (curl_multi_select($mh) != -1) {
        do {
            $mrc = curl_multi_exec($mh, $active);
        } while ($mrc == CURLM_CALL_MULTI_PERFORM);
    }
}*/
do {
    curl_multi_exec($mh, $active);
    curl_multi_select($mh);
} while ($active > 0);

//$file = 'info_20pages.txt';
//$fhandler = fopen($file, 'a+');
for($i=0; $i<21;$i++){
    $content = curl_multi_getcontent($charr[$i]);
    //fwrite($fhandler, $content);
    parsepage($content);
}
//fclose($fhandler);  
//close the handles
for($i=0; $i<21;$i++){
    curl_multi_remove_handle($mh, $charr[$i]);

}

curl_multi_close($mh);


$end = microtime(true);
echo "time elapsed: ".($end-$start);
//create the multiple cURL handle
//time elapsed: 5.3353049755096


function parsepage($re){
    $file = 'info_20pages.txt';

    $fhandler = fopen($file, 'a+');
    $crawler = new Crawler($re);
    $table = $crawler->filterXPath('//table[@class="newlist"]/tr/td');
    $i = 1;
    foreach($table as $k=>$v){
/*      if($i%7 == 0){
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