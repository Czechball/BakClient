<?php

class Network
{
		
		private $cookieFile;
		private $agent = "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/534.30 (KHTML, like Gecko) Chrome/12.0.742.112 Safari/534.30";
		
		private $urlLogin = "https://rodice.gymspit.cz/login.aspx";
		private $urlPost = "https://rodice.gymspit.cz/login.aspx";
		private $urlLanding = "https://rodice.gymspit.cz/uvod.aspx";
		
		public $urlMarks = "https://rodice.gymspit.cz/prehled.aspx?s=2";
		public $urlVysvedceni = "https://rodice.gymspit.cz/prehled.aspx?s=4";
		public $urlTimetable = "https://rodice.gymspit.cz/prehled.aspx?s=6";
		public $urlAbsence = "https://rodice.gymspit.cz/prehled.aspx?s=3";
		public $urlAbsence2 = "https://rodice.gymspit.cz/prehled.aspx?s=9";
		public $urlJidelnaLogin = "https://jidelna.cz/index.php?page=listek&Zarizeni_ID=260&Zacatek=2013-06-13";

		/* Viewstates */
		private $vsLogin = "/wEPDwULLTExNzI0NzY5MDQPZBYCZg9kFgICAw9kFgICAQ9kFg5mD2QWAgIBDw8WBB4ISW1hZ2VVcmwFDWltYWdlcy9jcy5wbmceB1Rvb2xUaXAFDVptxJtuYSBqYXp5a2FkZAIBDw8WAh4EVGV4dAUKdcW+aXZhdGVsOmRkAgIPDxYCHwIFCW9kaGzDoXNpdGRkAgMPDxYCHwIFB2ptw6lubzpkZAIEDw8WAh4HVmlzaWJsZWhkZAIGD2QWFgIDDw8WAh8CBQ5QxZlpaGzDocWhZW7DrWRkAgUPDxYCHwIFF1DFmWlobGHFoW92YWPDrSBqbcOpbm86ZGQCCQ8PFgIfAgUGSGVzbG86ZGQCCw8PFgIfA2hkFgICAQ8PFgIfAgURemFwb21lbnV0w6kgaGVzbG9kZAINDw8WAh8DaGRkAhEPDxYCHwIFClXFvml2YXRlbDpkZAITDxBkZBYAZAIVDxBkZBYAZAIXDzwrAAYBAA8WAh8CBQtQxZlpaGzDoXNpdGRkAhsPDxYGHwIFI1DFmWlobMOhc2l0IHNlIHBvbW9jw60gV2luZG93cyBMaXZlHgtOYXZpZ2F0ZVVybGUfA2hkZAIdDxAPFgIfAgUXWsWvc3RhdCBwxZlpaGzDocWhZW4oYSlkZGRkAgcPPCsACAEGPCsAEgEAFgIeCkhlYWRlclRleHQFDVptxJtuYSBqYXp5a2FkGAEFHl9fQ29udHJvbHNSZXF1aXJlUG9zdEJhY2tLZXlfXxYGBRtjdGwwMCRjcGhtYWluJEJ1dHRvblByaWhsYXMFGGN0bDAwJGNwaG1haW4kY2hlY2tzdGFsZQULY3RsMDAkcG9wdXAFEWN0bDAwJHBvcHVwJGltZ2NzBRFjdGwwMCRwb3B1cCRpbWdlbgURY3RsMDAkcG9wdXAkaW1nZnJdGjCYqcRcDiOzV5VYedzpAnnnVvpCUTYbiECNprwgDw==";

		public function __construct()
		{
			$this -> cookieFile = tempnam("/tmp", "cookies");
		}
		
		public function __destruct()
		{
			//unlink($this -> cookiefile);
		}
		
		public function httpsRequest($url, $fields = NULL)
		{
			$ch = curl_init();

			if(!is_null($fields))
			{
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
			}
			curl_setopt($ch, CURLOPT_REFERER, $this -> urlLogin);
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_USERAGENT, $this -> agent);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_COOKIEFILE, $this -> cookieFile);
			curl_setopt($ch, CURLOPT_COOKIEJAR, $this -> cookieFile);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$result = curl_exec ($ch);
			curl_close ($ch);			
			return $result;		
		}
		
		public function pageLogin()
		{
			return $this -> httpsRequest($this -> urlLogin);		
		}
		
		public function pageLanding()
		{
			return $this -> httpsRequest($this -> urlLanding);				
		}
		
		public function pageSubmit($fields)
		{
			return $this -> httpsRequest($this -> urlPost, $fields);				
		}
		
		public function pageSubmitData($username, $password)
		{
		
			/* Složí POST pole pro login */
			$postfields = array(
				'ctl00$cphmain$TextBoxjmeno' => $username, 
				'ctl00$cphmain$TextBoxheslo' => $password, 
				'ctl00$cphmain$ButtonPrihlas' => "", 
				"__VIEWSTATE" => urlencode($this -> vsLogin),
				"DXScript" => "1_145,1_81,1_99,1_106,1_137,1_92,1_78,1_130,1_128,1_95"
			);
			//return http_build_query($postfields);
			return $postfields;

		}
		
}
?>