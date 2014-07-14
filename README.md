PHP-jquery-like-selector
========================

PHP load, post and select elements like jquery

Get Tweets by hashtag

	<?php
		$content = $bone->get('https://mobile.twitter.com/hashtag/github');
		$html    = $content->html();
		
		foreach($html->find(".tweet-text") as $element){
			echo $element->text();
		}
	?>



Get EkşiSözlük entries

	<?php
		$content = $bone->get('https://eksisozluk.com/1112211-com--4457656?a=popular');
	
		foreach($content->html()->find(".content") as $element){
			echo $element->text()."<hr>";
		}
	?>


	
Login to folkd

	<?php
	
		$content = $bone->get('http://www.folkd.com/page/login.html');
		$html    = $content->html();
		
		$fill = array();
		$fill = $html->serialize('#form_login input');
		
		$fill["u"] = "username";
		$fill["p"] = "password";
		
		$content = $bone->post('http://www.folkd.com/page/login.html',$fill);
	
	?>
