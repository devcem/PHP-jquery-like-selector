<?php


include("lib/getbone.php");
include("lib/ganon.php");



$content = $bone->get('https://eksisozluk.com/1112211-com--4457656?a=popular');

//echo $content->html()->find(".content");

foreach($content->html()->find(".content") as $element){
	echo $element->text()."<hr>";
}

?>