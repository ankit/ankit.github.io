<?php

class CalaisPHP {
	
	var $apiKey 		= "";
	var $url 			= "http://api.opencalais.com/enlighten/calais.asmx/Enlighten";
	var $paramsXML 		= "";
	var $contentType 	= "text/html";

	function CalaisPHP($apiKey = false) {
		
		if ($apiKey !== false)
		{
			$this->apiKey = $apiKey;
		}

		$this->paramsXML = $this->buildParamsXML();
	}
	function callEnlighten($content) {

		if (!is_string($content) || strlen($content) == 0)
		{
			return "Non-empty content is required";
		}
	
		$data = "licenseID=".urlencode($this->apiKey);
		$data .= "&paramsXML=".urlencode($this->paramsXML);
		$data .= "&content=".urlencode($content); 
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_POST, 1);
		$response = curl_exec($ch);
		curl_close($ch);

	
		if ($response === false || (strpos($response, "<Exception>") !== false)) {
			return "Enlighten ERROR: ".$response;
		}
		
		return $response;
	}

	function buildParamsXML() {

		$ret = "<c:params xmlns:c=\"http://s.opencalais.com/1/pred/\" " . 
			"xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\"> " .
			"<c:processingDirectives c:contentType=\"".$this->contentType."\" " .
			"c:outputFormat=\"text/simple\"></c:processingDirectives> " .
			"<c:userDirectives c:allowDistribution=\"false\" " .
			"c:allowSearch=\"false\" c:externalID=\" \" " .
			"c:submitter=\"Calais PHP Demo\"></c:userDirectives> " .
			"<c:externalMetadata></c:externalMetadata></c:params>";
		
		return $ret;
	}
	
	function setContentType($contentType) {
		$this->contentType = $contentType;
		$this->paramsXML = $this->buildParamsXML();
	}
	
	function getContentType() {
		return $this->contentType;
	}
}


?>
