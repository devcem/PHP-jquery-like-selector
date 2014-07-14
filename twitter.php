<?php

include("lib/getbone.php");
include("lib/ganon.php");


$content = $bone->get('https://mobile.twitter.com/hashtag/kanald');
$html    = $content->html();

foreach($html->find(".tweet-text") as $element){
	echo $element->text();
}


?>