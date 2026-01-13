<?

class Team {
	public $name;
	
	public $killNum = 0;
	public $gotAirDropNum = 0;
	public $maxKillDistance = 0;
	public $damage = 0;
	public $inDamage = 0;
	public $heal = 0;
	public $headShotNum = 0;
	public $killNumInVehicle = 0;
	public $survivalTime = 0;
	public $games = 0;
	public $driveDistance = 0;
	public $marchDistance = 0;
	public $assists = 0;
	public $killNumByGrenade = 0;
	public $outsideBlueCircleTime = 0;
	public $knockouts = 0;
	public $rescueTimes = 0;
	public $useSmokeGrenadeNum = 0;
	public $useFragGrenadeNum = 0;
	
	public function __construct ($name) {
		if ($name) {
			$this->name = $name;
		}
	}
	
	public function setName($name) {
		if ($name) {
			$this->name = $name;
		}
		else {
			throw new Exception("[k5f3] Missing Name");
		}
	}
	
	public function addStats($data) {
		if (!empty($data)) {
			$this->killNum += $data[15];
			$this->gotAirDropNum += $data[19];
			$this->maxKillDistance = $this->maxKillDistance > $data[20] ? $this->maxKillDistance : $data[20];
			$this->damage += $data[21];
			$this->inDamage += $data[22];
			$this->heal += $data[23];
			$this->headShotNum += $data[24];
			$this->killNumInVehicle += $data[25];
			$this->survivalTime += $data[26];
			$this->driveDistance += $data[27];
			$this->marchDistance += $data[28];
			$this->assists += $data[30];
			$this->killNumByGrenade += $data[31];
			$this->outsideBlueCircleTime += $data[34];
			$this->knockouts += $data[35];
			$this->rescueTimes += $data[36];
			$this->useSmokeGrenadeNum += $data[37];
			$this->useFragGrenadeNum += $data[38];
			$this->games += 1;
		}
		else {
			throw new Exception("[m6g2] Missing Stats");
		}
	}
}