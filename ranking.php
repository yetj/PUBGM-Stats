<?

class Ranking {
	public $name;
	public $wwcd = 0;
	public $placePoints = 0;
	public $killPoints = 0;
	public $bonus = 0;
	public $total = 0;
	public $playedMatches = 0;
	
	public function __construct ($name="") {
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
			$this->wwcd = $data[1];
			$this->placePoints = $data[2];
			$this->killPoints = $data[3];
			$this->total = $data[4];
			$this->playedMatches = isset($data[5]) ? $data[5] : "-";
		}
		else {
			throw new Exception("[m6g2] Missing Stats");
		}
	}
	
	public function addStatsBonus($data) {
		if (!empty($data)) {
			$this->wwcd = $data[1];
			$this->placePoints = $data[2];
			$this->killPoints = $data[3];
			$this->total = $data[4];
			$this->playedMatches = $data[5];
		}
		else {
			throw new Exception("[m6g2] Missing Stats");
		}
	}
	
	public function addStatsBonusFinals($data) {
		if (!empty($data)) {
			$this->wwcd = $data[1];
			$this->placePoints = $data[2];
			$this->killPoints = $data[3];
			$this->bonus = $data[4];
			$this->total = $data[5];
			$this->playedMatches = $data[6];
		}
		else {
			throw new Exception("[m6g2] Missing Stats");
		}
	}
	
	public static function prepareRanking($data) {
		$out = "";
		$out .= '<table class="table table-sm table-hover table-striped">
			<thead>
				<tr style="position: sticky; top: -1px; background-color: #5ae3ff;">
					<th>#</th>
					<th>Team name</th>
					<th>WWCD</th>
					<th>Place Points</th>
					<th>Kill Points</th>
					<th>Total</th>
					<th>Played matches</th>
				</tr>
			</thead>
			<tbody>';
		$i = 1;
		foreach ($data as $rankRow):
			$out .= '<tr>
				<td style="text-align:right;">'. $i++ .'.</td>
				<td style="text-align:center;">'. $rankRow->name .'</td>
				<td style="text-align:center;">'. $rankRow->wwcd .'</td>
				<td style="text-align:center;">'. $rankRow->placePoints .'</td>
				<td style="text-align:center;">'. $rankRow->killPoints .'</td>
				<td style="text-align:center;">'. $rankRow->total .'</td>
				<td style="text-align:center;">'. $rankRow->playedMatches .'</td>
			</tr>';
		endforeach;
		
		$out .= '</tbody>
		</table>';
		
		return $out;
	}
	
	public static function prepareRankingBonus($data) {
		$out = "";
		$out .= '<table class="table table-sm table-hover table-striped">
			<thead>
				<tr style="position: sticky; top: -1px; background-color: #5ae3ff;">
					<th>#</th>
					<th>Team name</th>
					<th>Phase 1</th>
					<th>Phase 2</th>
					<th>Phase 3</th>
					<th>General</th>
					<th>Total</th>
				</tr>
			</thead>
			<tbody>';
		$i = 1;
		foreach ($data as $rankRow):
			$out .= '<tr>
				<td style="text-align:right;">'. $i++ .'.</td>
				<td style="text-align:center;">'. $rankRow->name .'</td>
				<td style="text-align:center;">'. $rankRow->wwcd .'</td>
				<td style="text-align:center;">'. $rankRow->placePoints .'</td>
				<td style="text-align:center;">'. $rankRow->killPoints .'</td>
				<td style="text-align:center;">'. $rankRow->total .'</td>
				<td style="text-align:center;">'. $rankRow->playedMatches .'</td>
			</tr>';
		endforeach;
		
		$out .= '</tbody>
		</table>';
		
		return $out;
	}
	
	
	public static function prepareRankingBonusFinals($data) {
		$out = "";
		$out .= '<table class="table table-sm table-hover table-striped">
			<thead>
				<tr style="position: sticky; top: -1px; background-color: #5ae3ff;">
					<th>#</th>
					<th>Team name</th>
					<th>WWCD</th>
					<th>Place Points</th>
					<th>Kill Points</th>
					<th>Bonus</th>
					<th>Total</th>
					<th>Played matches</th>
				</tr>
			</thead>
			<tbody>';
		$i = 1;
		foreach ($data as $rankRow):
			$out .= '<tr>
				<td style="text-align:right;">'. $i++ .'.</td>
				<td style="text-align:center;">'. $rankRow->name .'</td>
				<td style="text-align:center;">'. $rankRow->wwcd .'</td>
				<td style="text-align:center;">'. $rankRow->placePoints .'</td>
				<td style="text-align:center;">'. $rankRow->killPoints .'</td>
				<td style="text-align:center;">'. $rankRow->bonus .'</td>
				<td style="text-align:center;">'. $rankRow->total .'</td>
				<td style="text-align:center;">'. $rankRow->playedMatches .'</td>
			</tr>';
		endforeach;
		
		$out .= '</tbody>
		</table>';
		
		return $out;
	}
}