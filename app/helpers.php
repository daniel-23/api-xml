<?php
if (! function_exists('jsonToXML')) {
	function arrayToXml($arr, &$xml)
	{
		foreach($arr as $key => $value){
			if(is_int($key)){
				$key = 'Element'.$key;  //To avoid numeric tags like <0></0>
			}
			if(is_array($value)){
				$label = $xml->addChild($key);
				arrayToXml($value, $label);  //Adds nested elements.
			} else {
				$xml->addChild($key, $value);
			}
		}
	}
}