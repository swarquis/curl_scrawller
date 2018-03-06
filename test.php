<?php
$content=<<<content
                                
                                    
                                    
                                        javaEE中高级工程师  
                                    
                                
                                
                                成都荣为信息技术有限公司 
                                8000-12000
                                成都
                                置顶
                            
content;
$re = trim($content);
//$re = str_replace(' ','', $re);

$str = preg_replace('#\s+#',',',$re);

//echo $re;
var_dump($str);


echo strval(1);