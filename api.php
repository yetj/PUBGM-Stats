<?php

require __DIR__ . '/vendor/autoload.php';

class API {
	public $sheetID;
	public $service;
	
	public function __construct($sheetID = "") {
		if ($sheetID != "") {
			$this->setSheetID($sheetID);
		}
		
		$client = new \Google_Client();

		$client->setApplicationName('Google Sheets and PHP');

		$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);

		$client->setAccessType('offline');

		$client->setAuthConfig(__DIR__ . '/credentials_uRBKnZk2fmLG9hv7.json');
		
		$service = new Google_Service_Sheets($client);
		
		$this->service = $service;
	}
	
	public function setSheetID($sheetID) {
		$this->sheetID = $sheetID;
	}
	
	public function getSheetID() {
		return $this->sheetID;
	}
	
	public function getSheet() {
		if ($this->sheetID) {
			$response = $this->service->spreadsheets->get($this->sheetID);
			return $response;
		}
	}
	
	public function getName() {
		if ($this->sheetID) {
			$response = $this->service->spreadsheets->get($this->sheetID)->getProperties()->getTitle();
			return $response;
		}
	}
	
	public function getRange($range = "") {
		if ($range !== "") {
			try {
				$values = $this->service->spreadsheets_values->get($this->sheetID, $range)->getValues();
				if (empty($values)) {
					return "No data found";
				}
				else {
					return $values;
				}
			}
			catch (Exception $e) {
				return "[h5fs] Error while fetching values. ".$e->getMessage();
			}
		}
		else {
			return "[n64f] Range is empty";
		}
	}
	
	public function getBatchRange($range = []) {
		if (!empty($range)) {
			try {
				$params = [];
				$params['ranges'] = $range;
				
				$values = $this->service->spreadsheets_values->batchGet($this->sheetID, $params);
				if (empty($values)) {
					return "No data found";
				}
				else {
					return $values['valueRanges'];
				}
			}
			catch (Exception $e) {
				return "[h5fs] Error while fetching values. ".$e->getMessage();
			}
		}
		else {
			return "[n64f] Range is empty";
		}
	}
}