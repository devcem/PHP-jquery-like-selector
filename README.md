PHP-jquery-like-selector
========================

PHP load, post and select elements like jquery

Example for getting Tweets

$content = $bone->get('https://mobile.twitter.com/hashtag/github');
$html    = $content->html();

foreach($html->find(".tweet-text") as $element){
	echo $element->text();
}