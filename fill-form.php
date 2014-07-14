<?php

include("lib/getbone.php");
include("lib/ganon.php");


$content = $bone->get('http://www.folkd.com/page/login.html');
$html    = $content->html();



$fill = array();
$fill = $html->serialize('#form_login input');

$fill["u"] = "commention";
$fill["p"] = "1c2c3c4c";


$content = $bone->post('http://www.folkd.com/page/login.html',$fill);


$content = $bone->get('http://www.folkd.com/page/submit.html');
$html    = $content->html();

echo $html->find("img")[0]->attr("src");


?>