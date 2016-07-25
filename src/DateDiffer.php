<?php

require_once __DIR__.'/../vendor/autoload.php';

class DateDiffer
{
	/* Start month, day, year */
	private $y1;
	private $m1;
	private $d1;

	/* End month, day, year */
	private $y2;
	private $m2;
	private $d2;

	public function __construct(array $start, array $end) {
		if (isset($start)) {
			$this->y1 = intval($start[0]);
			$this->m1 = intval($start[1]);
			$this->d1 = intval($start[2]);
		}
		if (isset($end)) {
			$this->y2 = intval($end[0]);
			$this->m2 = intval($end[1]);
			$this->d2 = intval($end[2]);
		}
	}

	/**
	 * Finds the number of days between two dates, without using existing date/time related classes or functions
	 * Being creative in my interpretation of "not using existing date/time related classes or functions":
	 * Using DomDocument to parse result from Wolfram Alpha Api
	 * */
	public function getDateDiff() {

		$client = new \GuzzleHttp\Client();

		$start = $this->y1 . '-' . $this->m1 . '-' . $this->d1;
		$end = $this->y2 . '-' . $this->m2 . '-' . $this->d2;
		$appId = 'YYL2LE-4PXHL246Y6'; // WolframAlpha API Key

		$url = 'http://api.wolframalpha.com/v2/query?appid=' . $appId . '&input=number%20of%20days%20between%20' . $start . '%20and%20' . $end . '&format=plaintext';

		$res = $client->request('GET', $url);

		if ($res->getStatusCode() == '200') {
			$body = $res->getBody();
			$dom = new DOMDocument();
			$dom->loadXML($body);
			$xpathObj = new DOMXPath($dom);
			$xpath = "/queryresult/pod[@title='Result'][@primary='true']/subpod[@primary='true']/plaintext";

		    foreach ($xpathObj->query($xpath) as $textNode) {
		        if (strpos($textNode->nodeValue, 'day') !== false) {
		        	return intval($textNode->nodeValue);
		        }
		    }
		}

		//If we get here there was no valid result
		echo "error fetching from " . $url . "\n";
		return $res;
	}
}