<?php
if (! function_exists('jsonToXML')) {
	function arrayToXml($arr, &$xml)
	{
		foreach($arr as $key => $value){
			if(is_int($key)){
				$key = 'Element'.$key;  //To avoid numeric tags like <0></0>
			}

			if(is_array($value) && in_array($key, ['AdditionalIssueDocInfo'])){
				$label = $xml->addChild($key);
				//arrayToXml($value, $label);  //Adds nested elements.
			} else if(is_array($value)){
				$label = $xml->addChild($key);
				arrayToXml($value, $label);  //Adds nested elements.
			} else {
				$xml->addChild($key, $value);
			}
		}
	}
}


function arrayToStrXml($arr, $parent = "Root")
{
	$xml = "<$parent>";
	foreach ($arr as $key => $value) {
		if(is_int($key)){
			$key = 'Element'.$key;  //To avoid numeric tags like <0></0>
		}

		if(is_array($value) && in_array($key, ['Codes'])){
			$xml .= "<$key>";
			$xml .= tagInfo($value, "Code");
			$xml .= "</$key>";


		} elseif (is_array($value) && in_array($key, ['AdditionalIssueDocInfo', 'TaxIDAdditionalInfo', 'AdditionalBranchInfo','AdditionlInfo', 'AditionalInfo'])){
			$xml .= "<$key>";
			$xml .= tagInfo($value, "Info");
			$xml .= "</$key>";


		} elseif (is_array($value)){
			$xml .= arrayToStrXml($value, $key);
		} else {
			$xml .= "<$key>$value</$key>";
		}
	}
	$xml .= "</$parent>";
	return $xml;
}

function tagInfo($arr, $tag)
{
	$r = '';
	foreach ($arr as $key => $value) {
		$r .= "<$tag Name=\"$key\" Value=\"$value\"/>";
	}
	return $r;
}