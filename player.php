<?

class Player {
	public $nickname;
	public $team;
	public $uids;
	
	public $games = 0;
	public $killNum = 0;
	public $liveState = 0;
	public $gotAirDropNum = 0;
	public $maxKillDistance = 0;
	public $damage = 0;
	public $inDamage = 0;
	public $heal = 0;
	public $headShotNum = 0;
	public $killNumInVehicle = 0;
	public $survivalTime = 0;
	public $driveDistance = 0;
	public $marchDistance = 0;
	public $assists = 0;
	public $killNumByGrenade = 0;
	public $rank = 0;
	public $outsideBlueCircleTime = 0;
	public $knockouts = 0;
	public $rescueTimes = 0;
	public $useSmokeGrenadeNum = 0;
	public $useFragGrenadeNum = 0;
	public $mvp = 0;
	public $isMVP = 0;
	public $mvp_new = 0;
	public $isMVP_new = 0;
	
	public function __construct ($nickname, $team) {
		if ($nickname && $team) {
			$this->nickname = $nickname;
			$this->team = $team;
		}
	}
	
	public function setNickname($nickname) {
		if ($nickname) {
			$this->nickname = $nickname;
		}
		else {
			throw new Exception("[k5f3] Missing Nickname");
		}
	}
	
	public function setTeam($team) {
		if ($team) {
			$this->team = $team;
		}
		else {
			throw new Exception("[k6f9] Missing Team");
		}
	}
	
	public function setNicknameAndTeam() {
		if ($nickname && $team) {
			$this->nickname = $nickname;
			$this->team = $team;
		}
		else {
			throw new Exception("[g4d2] Missing Nickname or Team");
		}
	}
	
	public function addUid($uid) {
		$this->uids[] = $uid;
	}
	
	public function addStats($data) {
		if (!empty($data)) {
			$this->games++;
			$this->killNum += $data[15];
			$this->liveState = $data[14] === 0 ? $this->liveState++ : $this->liveState;
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
			$this->rank += $data[32];
			$this->outsideBlueCircleTime += $data[34];
			$this->knockouts += $data[35];
			$this->rescueTimes += $data[36];
			$this->useSmokeGrenadeNum += $data[37];
			$this->useFragGrenadeNum += $data[38];
		}
		else {
			throw new Exception("[m6g2] Missing Stats");
		}
	}
}