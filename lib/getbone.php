<?php

class http
{

	private $userAgent = "Opera/9.80 (J2ME/MIDP; Opera Mini/4.2.14912/870; U; id) Presto/2.4.15";
	public  $result;
	public  $session;

	public function get($url,$sessionDrop=false){
		
		global $userAgent;
		global $session;
		
		if($session){
			$ch = $session;
		}else{
			$ch = curl_init();
		}
		
	
        $cookie = tempnam('/tmp', 'CURLCOOKIE');


        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1');
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);

		//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

		$output = curl_exec($ch);
		
		if($sessionDrop==true){
			curl_close($ch);
		}

		$result = array();
		$result["out"] = $output;
		$result["ch"]  = $ch;
		$session = $ch;

		return new html($result);

    }

    public function post($url,$fields,$sessionDrop=false){
		
		global $userAgent;
		global $session;
		
		if($session){
			$ch = $session;
		}else{
			$ch = curl_init();
		}

		$fields_string = "";

		foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		rtrim($fields_string, '&');

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
		curl_setopt($ch, CURLOPT_POST, count($fields));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_COOKIEJAR,  "/jar/cookie.txt"); 
		curl_setopt($ch, CURLOPT_COOKIEFILE, "/jar/cookie.txt"); 

		//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

		$output = curl_exec($ch);

		if($sessionDrop==true){
			curl_close($ch);
		}

		$result = array();
		$result["out"] = $output;
		$result["ch"] = $ch;
		$session = $ch;

		return new html($result);

    } 

}

class html{

	public function __construct ( $html ) {
	    $this->html = $html;
	}

	public function html(){
		return new object(str_get_dom($this->html["out"]));
    }

    public function innerHtml(){
		return $this->html["out"];
    }

    public function session(){
		return $this->html["ch"];
    }

}

class object{

	public function __construct ( $html ) {
	    $this->html = $html;
	}

	public function find($form){
		
    	$construct = $this->html;
    	$input     = $construct($form);
    	$fill      = array();

    	foreach($input as $element) {	
		   		$fill[] = new prop($element);
		}

		return $fill;
    }

	public function serialize($form){
		
    	$construct = $this->html;
    	$input     = $construct($form);
    	$fill      = array();

		foreach($input as $element) {	

		   if(isset($element->attributes["name"]) && isset($element->attributes["value"])){
		   		$name = (string) $element->attributes["name"];
		   		$fill[$name] = $element->attributes["value"];
		   }
		   
		}

		return $fill;
    }
}

class prop{

	public function __construct ( $html ) {
	    $this->html = $html;
	}

	public function attr($form){
		$object = $this->html;

		return $object->attributes[$form];
    }

    public function text(){
		$object = $this->html;
		
		return $object->getPlainText();
    }
}

$bone = new http();
