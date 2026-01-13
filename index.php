<?
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
require __DIR__ . '/api.php';
require __DIR__ . '/config.php';
require __DIR__ . '/player.php';
require __DIR__ . '/team.php';
require __DIR__ . '/ranking.php';

$region = "";
$unique_tabs = [];
$players = [];
$teams = [];
$newRegion = false;

$API = null;

$clearCache = 0;

$totalSurvivalTime = 0;
$totalSurvivalTimeDays = 0;
$totalDamage = 0;
$totalKills = 0;
$totalKnockouts = 0;
$highestMVP = -1;
$highestMVPNew = -1;

$selectedTabs = [];

$notFoundPlayers = [];

$cupType = '';
$rank_GroupStage = [];
$rank_SuperWeekends = [];
$rank_Finals = [];
$rank_SWandFinals = [];

$results = null;

$link = "";

$r = null;
$tX = [];
$allowedTabs = [];

if(isset($_GET['clearCache'])) {
	$clearCache = 1;
}

if(isset($_GET['stats'])) {
	$link = $_GET['stats'];
	if (array_key_exists($link, $links)) {
		$r = $links[$link]['r'];
		//$tX = $links[$link]['t'];
		$allowedTabs = $links[$link]['t'];
	}
}

if(isset($_POST['t'])) {
	$tabsPost = $_POST['t'];
	foreach($tabsPost as $k => $v) {
		if (array_key_exists($k, $allowedTabs)) {
			$tX[$k] = $v;
		}
	}
}
else {
	$tX = $allowedTabs;
}

if(isset($r)) {
	$region = $r;
	if (array_key_exists($region, $regions)) {
		if (array_key_exists($region, $newRegions)) {
			$newRegion = true;
		}
		
		$region = str_replace("_", " ", $region);
		
		/// GET Unique Tabs
		if (file_exists("cache/".$r."_tabs.json") && (filemtime("cache/".$r."_tabs.json") > time()-$CACHE_TIME_TABS) && $clearCache == 0) {
			
			$file = "cache/".$r."_tabs.json";
			$results = json_decode(file_get_contents($file), true);
			
		}
		else {
			if (!$API) {
				$API = new API($regions[$r]);
			}
			
			$results = null;
			if ($newRegion) {
				$results = $API->getRange('config!C29:C');
			}
			else {
				$results = $API->getRange('teams&points!C24:C');
			}
			
			/// save to cache
			$file = "cache/".$r."_tabs.json";
			file_put_contents($file, json_encode($results));
		}
		
		$tabs = [];
		foreach ($results as $result) {
			if (isset($result[0])) {
				$tabs[] = $result[0];
			}
		}

		$unique_tabs = array_unique($tabs);
		
		/// GET Players & Teams
		if (file_exists("cache/".$r."_PlayersAndTeams.json") && (filemtime("cache/".$r."_PlayersAndTeams.json") > time()-$CACHE_TIME) && $clearCache == 0) {
			
			$file = "cache/".$r."_PlayersAndTeams.json";
			$results = json_decode(file_get_contents($file), true);
			
		}
		else {
			if (!$API) {
				$API = new API($regions[$r]);
			}
			
			if ($newRegion) {
				$results = $API->getRange('config!BK2:BN');
			}
			else {
				$results = $API->getRange('teams&points!AW2:AZ');
			}
			
			/// save to cache
			$file = "cache/".$r."_PlayersAndTeams.json";
			file_put_contents($file, json_encode($results));
		}
		
		if (is_array($results)) {
			
			foreach ($results as $result) {
				if (isset($result[3])) {
					$nickname = $result[3];
					$team = $result[2];
					$uid = $result[1];
					$needToAddPlayer = true;
					$needToAddTeam = true;
					
					foreach ($players as $player) {
						if ($player->nickname == $nickname && $player->team == $team) {
							$player->addUid($uid);
							$needToAddPlayer = false;
							break;
						}
					}
					
					foreach ($teams as $t) {
						if ($t->name == $team) {
							$needToAddTeam = false;
							break;
						}
					}
					
					if ($needToAddPlayer == true) {
						$player = new Player($nickname, $team);
						$player->addUid($uid);
						
						$players[] = $player;
					}
					
					if ($needToAddTeam == true) {
						$tt = new Team($team);
						
						$teams[] = $tt;
					}
				}
			}
			// SORT Players by team and name
			usort($players, function($a, $b): int {
				if ($a->team === $b->team) {
					return strtolower($a->nickname) <=> strtolower($b->nickname);
				}
				return strtolower($a->team) <=> strtolower($b->team);
			});
			
			// SORT Team by name
			usort($teams, function($a, $b): int {
				return strtolower($a->name) <=> strtolower($b->name);
			});
		}
		
		/// GET match results		
		if(sizeof($tX) > 0) {
			$selectedTabs = $tX;
			
			$tabsToGet = [];
			
			foreach ($selectedTabs as $k => $v) {
				$tabsToGet[] = "'".$k."'!C2:AP";
			}
			
			$dataTabs = null;
			
			if (file_exists("cache/".$r."_dataTabs_".md5(implode(",", $tabsToGet)).".json") && (filemtime("cache/".$r."_dataTabs_".md5(implode(",", $tabsToGet)).".json") > time()-$CACHE_TIME) && $clearCache == 0) {
				
				$file = "cache/".$r."_dataTabs_".md5(implode(",", $tabsToGet)).".json";
				$dataTabs = json_decode(file_get_contents($file), true);
			}
			else {
				if (!$API) {
					$API = new API($regions[$r]);
				}
				
				$dataTabs = $API->getBatchRange($tabsToGet);
				
				/// save to cache
				$file = "cache/".$r."_dataTabs_".md5(implode(",", $tabsToGet)).".json";
				file_put_contents($file, json_encode($dataTabs));
			}
			
			foreach ($dataTabs as $dataTab) {
				foreach ($dataTab['values'] as $row) {
					if (!empty($row) && $row[0] != "uId" && $row[0] > 0) {
						
						$uid = $row[0];
						
						$totalSurvivalTime += $row[26];
						$totalDamage += $row[21];
						$totalKills += $row[15];
						$totalKnockouts += $row[35];
						
						$foundplayer = false;
						$teamOfPlayer = null;
						// FIND PLAYER
						foreach ($players as $foundPlayer) {
							if (in_array($uid, $foundPlayer->uids)) {
								$foundPlayer->addStats($row);
								$teamOfPlayer = $foundPlayer->team;
								$foundplayer = true;
								break;
							}
						}
						
						// FIND TEAM
						if ($teamOfPlayer !== null) {
							foreach ($teams as $foundTeam) {
								if ($foundTeam->name == $teamOfPlayer) {
									$foundTeam->addStats($row);
								}
							}
						}
						
						if ($foundplayer == false) {
							$entry = $row[0]." - ".$row[1];
							if (!in_array($entry, $notFoundPlayers)) {
								$notFoundPlayers[] = $entry;
							}
						}
					}
				}
			}
			
			//MVP Calculations
			foreach ($players as $mvpPlayer) {
				if ($totalSurvivalTime > 0 && $totalDamage > 0 && $totalKills > 0 && $totalKnockouts > 0) {
					$mvpPlayer->mvp = (($mvpPlayer->survivalTime/$totalSurvivalTime)*0.4)+(($mvpPlayer->damage/$totalDamage)*0.4)+(($mvpPlayer->killNum/$totalKills)*0.2);

					$mvpPlayer->mvp_new = (($mvpPlayer->survivalTime/$totalSurvivalTime)*0.2)+(($mvpPlayer->damage/$totalDamage)*0.3)+(($mvpPlayer->killNum/$totalKills)*0.4)+(($mvpPlayer->knockouts/$totalKnockouts)*0.1);
				
					if ($mvpPlayer->mvp > $highestMVP) {
						$highestMVP = $mvpPlayer->mvp;
					}

					if ($mvpPlayer->mvp_new > $highestMVPNew) {
						$highestMVPNew = $mvpPlayer->mvp_new;
					}
				}
			}
			
			foreach ($players as $mvpPlayer) {
				if ($mvpPlayer->mvp == $highestMVP) {
					$mvpPlayer->isMVP = 1;
				}
				if ($mvpPlayer->mvp_new == $highestMVPNew) {
					$mvpPlayer->isMVP_new = 1;
				}
			}
		}
		
		// GET Rankings
		/*
		$sheetName = null;
		
		if ((filemtime("cache/".$r."_sheetName.json") > time()-$CACHE_TIME) && $clearCache == 0) {
			
			$file = "cache/".$r."_sheetName.json";
			$sheetName = json_decode(file_get_contents($file), true);
		}
		else {
			if (!$API) {
				$API = new API($regions[$r]);
			}
			
			$sheetName =  $API->getName();
			
			/// save to cache
			$file = "cache/".$r."_sheetName.json";
			file_put_contents($file, json_encode($sheetName));
		}
		
		if (!$API) {
			$API = new API($regions[$r]);
		}
		
		
		if (strpos($sheetName, "PMCO") !== false) {
			$cupType = "PMCO";
			
			$results = null;
			
			
			// Group Stage
			if ((filemtime("cache/".$r."_rankGroupStage.json") > time()-$CACHE_TIME) && $clearCache == 0) {
				
				$file = "cache/".$r."_rankGroupStage.json";
				$results = json_decode(file_get_contents($file), true);
				
			}
			else {
				if (!$API) {
					$API = new API($regions[$r]);
				}
				
				$results = $API->getRange('production!AO6:AT37');
				
				/// save to cache
				$file = "cache/".$r."_rankGroupStage.json";
				file_put_contents($file, json_encode($results));
			}
			
			if (is_array($results)) {
				foreach ($results as $result) {
					$teamName = $result[0];
					$ranking = new Ranking($teamName);
					$ranking->addStats($result);
					
					$rank_GroupStage[] = $ranking;
				}
			}
			
			// Finals
			if ((filemtime("cache/".$r."_rankFinals.json") > time()-$CACHE_TIME) && $clearCache == 0) {
				
				$file = "cache/".$r."_rankFinals.json";
				$results = json_decode(file_get_contents($file), true);
				
			}
			else {
				if (!$API) {
					$API = new API($regions[$r]);
				}
				
				$results = $API->getRange('production!BQ6:BV21');
				
				/// save to cache
				$file = "cache/".$r."_rankFinals.json";
				file_put_contents($file, json_encode($results));
			}
			
			if (is_array($results)) {
				foreach ($results as $result) {
					$teamName = $result[0];
					$ranking = new Ranking($teamName);
					$ranking->addStats($result);
					
					$rank_Finals[] = $ranking;
				}
			}
			
		}
		elseif (strpos($sheetName, "PMPL Quali") !== false) {
			$cupType = "PMPLQ";
			
			// Overall Standings
			if ((filemtime("cache/".$r."_rankFinals.json") > time()-$CACHE_TIME) && $clearCache == 0) {
				
				$file = "cache/".$r."_rankFinals.json";
				$results = json_decode(file_get_contents($file), true);
				
			}
			else {
				if (!$API) {
					$API = new API($regions[$r]);
				}
				
				$results = $API->getRange('production!BC6:BH21');
				
				/// save to cache
				$file = "cache/".$r."_rankFinals.json";
				file_put_contents($file, json_encode($results));
			}
			
			if (is_array($results)) {
				foreach ($results as $result) {
					$teamName = $result[0];
					$ranking = new Ranking($teamName);
					$ranking->addStats($result);
					
					$rank_Finals[] = $ranking;
				}
			}
		}
		elseif (strpos($sheetName, "PMPL") !== false) {
			$cupType = "PMPL";
			
			
			$results = null;
			
			// Super Weekends
			if ((filemtime("cache/".$r."_rankSuperWeekends.json") > time()-$CACHE_TIME) && $clearCache == 0) {
				
				$file = "cache/".$r."_rankSuperWeekends.json";
				$results = json_decode(file_get_contents($file), true);
				
			}
			else {
				if (!$API) {
					$API = new API($regions[$r]);
				}
				
				$results = $API->getRange('production!BQ6:BV25');
				
				/// save to cache
				$file = "cache/".$r."_rankSuperWeekends.json";
				file_put_contents($file, json_encode($results));
			}
			
			if (is_array($results)) {
				foreach ($results as $result) {
					$teamName = $result[0];
					$ranking = new Ranking($teamName);
					$ranking->addStats($result);
					
					$rank_SuperWeekends[] = $ranking;
				}
			}
			
			// Finals
			if ((filemtime("cache/".$r."_rankFinals.json") > time()-$CACHE_TIME) && $clearCache == 0) {
				
				$file = "cache/".$r."_rankFinals.json";
				$results = json_decode(file_get_contents($file), true);
				
			}
			else {
				if (!$API) {
					$API = new API($regions[$r]);
				}
				
				$results = $API->getRange('production!CE6:CJ21');
				
				/// save to cache
				$file = "cache/".$r."_rankFinals.json";
				file_put_contents($file, json_encode($results));
			}
			
			if (is_array($results)) {
				foreach ($results as $result) {
					$teamName = $result[0];
					$ranking = new Ranking($teamName);
					$ranking->addStats($result);
					
					$rank_Finals[] = $ranking;
				}
			}
			
			// Super Weekends + Finals
			if ((filemtime("cache/".$r."_rankSWandFinals.json") > time()-$CACHE_TIME) && $clearCache == 0) {
				
				$file = "cache/".$r."_rankSWandFinals.json";
				$results = json_decode(file_get_contents($file), true);
				
			}
			else {
				if (!$API) {
					$API = new API($regions[$r]);
				}
				
				$results = $API->getRange('production!CT6:CY25');
				
				/// save to cache
				$file = "cache/".$r."_rankSWandFinals.json";
				file_put_contents($file, json_encode($results));
			}
			
			if (is_array($results)) {
				foreach ($results as $result) {
					$teamName = $result[0];
					$ranking = new Ranking($teamName);
					$ranking->addStats($result);
					
					$rank_SWandFinals[] = $ranking;
				}
			}
		}
		*/
		
		
	}
	else {
		$region = "";
	}
}

/*
echo '<pre>';
$x = new API('1C7wqW0p0z5VoGFBFNc4RgdfUjGjTV8eqIIRonn10CqA');
$result = $x->getSheet();
print_r($result);


$result = $x->getRange('teams&points!C24:C');
//$result = $x->getBatchRange(['teams&points!C24:C30','teams&points!C40:C50']);


/// GET Unique Tabs
$results = $x->getRange('teams&points!C24:C');
$tabs = [];
foreach ($results as $result) {
	$tabs[] = $result[0];
}

$unique_tabs = array_unique($tabs);

*/
//print_r($result);
//echo '</pre>';
?>

<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>PUBG Mobile Stats<?= $region ? " - ".$region : ""; ?></title>
	<link rel="icon" type="image/x-icon" href="favicon.ico">

	<!-- Bootstrap CSS -->
	<link href="./css/bootstrap.min.css" rel="stylesheet">
	
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-27949876-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-27949876-1');
	</script>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
		<div class="container-fluid">
			
			<a class="navbar-brand" style="padding:0;" href="./"><img src="stats.png" alt="PUBG Mobile Stats">&nbsp;PUBG Mobile Stats</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav">
					<li class="nav-item ">
						<a class="nav-link" href="#" id="" role="button">
							<?= $region ? $region : "Incorect link..."; ?>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
<? if ($region && $unique_tabs): ?>
	<div class="p-2 tabs">
		<form action="" method="post">
			Tabs:
			<? foreach($unique_tabs as $tab): ?>
				<input type="checkbox" class="btn-check btn-<?= $tab; ?>" id="btn-<?= $tab; ?>" <?= !array_key_exists($tab, $allowedTabs) ? 'disabled="disabled"' : '' ?> name="t[<?= $tab; ?>]" <?= array_key_exists($tab, $selectedTabs) ? "checked" : ""; ?> autocomplete="off">
				<label class="btn btn-sm btn-outline-<?= !array_key_exists($tab, $allowedTabs) ? 'secondary"' : 'info' ?> my-1" for="btn-<?= $tab; ?>"><?= $tab; ?></label>
			<? endforeach; ?>
			<button type="submit" class="btn btn-sm btn-primary my-1 d-print-none">Show...</button>
		</form>
	</div>
	<? if(!empty($notFoundPlayers)): ?>
		<div class="alert alert-danger" role="alert">
			At least one player is not found! Team and Player Stats may be affected due to this!<br>
			<ul>
				<? foreach($notFoundPlayers as $notFoundPlayer): ?>
					<li><?= $notFoundPlayer; ?></li>
				<? endforeach; ?>
			</ul>
		</div>
	<? endif; ?>
	<? if (!empty($selectedTabs)): ?>
		<nav>
			<div class="nav nav-tabs" id="nav-tab" role="tablist">
				<button class="nav-link active" id="nav-playerstats-tab" data-bs-toggle="tab" data-bs-target="#nav-playerstats" type="button" role="tab" aria-controls="nav-playerstats" aria-selected="true">Player Stats</button>
				<button class="nav-link" id="nav-teams-tab" data-bs-toggle="tab" data-bs-target="#nav-teams" type="button" role="tab" aria-controls="nav-teams" aria-selected="false">Team Stats</button>
				<button class="nav-link d-print-none" id="nav-kills-tab" data-bs-toggle="tab" data-bs-target="#nav-kills" type="button" role="tab" aria-controls="nav-kills" aria-selected="false">Top Kills</button>
			</div>
		</nav>
		<div class="tab-content" id="nav-tabContent">
			<div class="tab-pane show active" id="nav-playerstats" role="tabpanel" aria-labelledby="nav-playerstats-tab">
				<table class="table table-sm table-hover table-striped table-responsive">
					<caption><small>Total Survival Time: <?= floor($totalSurvivalTime/(24*60*60)) ?>d_<?= gmdate("H:i:s", $totalSurvivalTime); ?> (<?= $totalSurvivalTime; ?>) | Total Damage: <?= $totalDamage; ?> | Total Kills: <?= $totalKills; ?> | Total Knocknouts: <?= $totalKnockouts; ?></small></caption>
					<thead>
						<tr style="position: sticky; top: -1px; background-color: #5ae3ff;">
							<th>Team name</th>
							<th>Player name</th>
							<th>Games</th>
							<th>Kills</th>
							<th>Alive</th>
							<th>Air Drop</th>
							<th>Max Kill Distance</th>
							<th>Damage dealt</th>
							<th>Damage received</th>
							<th>Heal</th>
							<th>Headshots</th>
							<th>Kill num in Vehicle</th>
							<th>Survival time</th>
							<th>Drive Distance</th>
							<th>March Distance</th>
							<th>Assists</th>
							<th>Kill by Granade</th>
							<th>Avg rank</th>
							<th>Outside Blue Circle Time</th>
							<th>Knockouts</th>
							<th>Rescue Times</th>
							<th>Used Smokes</th>
							<th>Used Frag Granades</th>
							<th class="d-print-none">MVP</th>
							<th class="d-print-none">MVP new</th>
						</tr>
					</thead>
					<tbody>
						<? foreach ($players as $player): ?>
							<tr <?= $player->isMVP_new == 1 ? 'class="table-success"' : "";?><?= $player->isMVP == 1 ? 'class="table-info"' : "";?>>
								<td><?= $player->team; ?></td>
								<td><?= $player->nickname; ?></td>
								<td><?= $player->games; ?></td>
								<td><?= $player->killNum; ?></td>
								<td><?= $player->liveState; ?></td>
								<td><?= $player->gotAirDropNum; ?></td>
								<td><?= $player->maxKillDistance; ?></td>
								<td><?= $player->damage; ?></td>
								<td><?= $player->inDamage; ?></td>
								<td><?= $player->heal; ?></td>
								<td><?= $player->headShotNum; ?></td>
								<td><?= $player->killNumInVehicle; ?></td>
								<td><?= floor($player->survivalTime/(24*60*60)) ?>d_<?= gmdate("H:i:s", $player->survivalTime); ?></td>
								<td><?= $player->driveDistance; ?></td>
								<td><?= $player->marchDistance; ?></td>
								<td><?= $player->assists; ?></td>
								<td><?= $player->killNumByGrenade; ?></td>
								<td>~<?= $player->games > 0 ? round($player->rank / $player->games, 2) : 0; ?></td>
								<td><?= gmdate("H:i:s", $player->outsideBlueCircleTime); ?></td>
								<td><?= $player->knockouts; ?></td>
								<td><?= $player->rescueTimes; ?></td>
								<td><?= $player->useSmokeGrenadeNum; ?></td>
								<td><?= $player->useFragGrenadeNum; ?></td>
								<td class="d-print-none"><?= round($player->mvp,8); ?></td>
								<td class="d-print-none"><?= round($player->mvp_new,8); ?></td>
							</tr>
						<? endforeach; ?>
						<? if (count($players) == 0): ?>
							<tr>
								<td colspan="24"><center><i>No data found...</i></center></td>
							</tr>
						<? endif; ?>
					</tbody>
				</table>
			</div>
			<div class="tab-pane fade" id="nav-teams" role="tabpanel" aria-labelledby="nav-teams-tab">
				<table class="table table-sm table-hover table-striped">
					<thead>
						<tr style="position: sticky; top: -1px; background-color: #5ae3ff;">
							<th>Team name</th>
							<th>Kills</th>
							<th>Air Drop</th>
							<th>Max Kill Distance</th>
							<th>Damage dealt</th>
							<th>Damage received</th>
							<th>Heal</th>
							<th>Headshots</th>
							<th>Kill num in Vehicle</th>
							<th>Survival time</th>
							<th>Drive Distance</th>
							<th>March Distance</th>
							<th>Assists</th>
							<th>Kill by Granade</th>
							<th>Outside Blue Circle Time</th>
							<th>Knockouts</th>
							<th>Rescue Times</th>
							<th>Used Smokes</th>
							<th>Used Frag Granades</th>
						</tr>
					</thead>
					<tbody>
						<? foreach ($teams as $team): ?>
							<tr>
								<td><?= $team->name; ?></td>
								<td><?= $team->killNum; ?></td>
								<td><?= $team->gotAirDropNum; ?></td>
								<td><?= $team->maxKillDistance; ?></td>
								<td><?= $team->damage; ?></td>
								<td><?= $team->inDamage; ?></td>
								<td><?= $team->heal; ?></td>
								<td><?= $team->headShotNum; ?></td>
								<td><?= $team->killNumInVehicle; ?></td>
								<td><?= floor($team->survivalTime/(24*60*60)) ?>d_<?= gmdate("H:i:s", $team->survivalTime); ?></td>
								<td><?= $team->driveDistance; ?></td>
								<td><?= $team->marchDistance; ?></td>
								<td><?= $team->assists; ?></td>
								<td><?= $team->killNumByGrenade; ?></td>
								<td><?= gmdate("H:i:s", $team->outsideBlueCircleTime); ?></td>
								<td><?= $team->knockouts; ?></td>
								<td><?= $team->rescueTimes; ?></td>
								<td><?= $team->useSmokeGrenadeNum; ?></td>
								<td><?= $team->useFragGrenadeNum; ?></td>
							</tr>
						<? endforeach; ?>
						<? if (count($teams) == 0): ?>
							<tr>
								<td colspan="19"><center><i>No data found...</i></center></td>
							</tr>
						<? endif; ?>
					</tbody>
				</table>
			</div>
			<div class="tab-pane fade" id="nav-kills" role="tabpanel" aria-labelledby="nav-kills-tab">
				<?
					// SORT Players by kill num and damage
					usort($players, function($a, $b): int {
						if ($a->killNum === $b->killNum) {
							return $b->damage <=> $a->damage;
						}
						return $b->killNum <=> $a->killNum;
					});
				?>
				
				<table class="table table-sm table-hover table-striped">
					<thead>
						<tr style="position: sticky; top: -1px; background-color: #5ae3ff;">
							<th>Team name</th>
							<th>Player</th>
							<th>Kills</th>
							<th>Damage</th>
						</tr>
					</thead>
					<tbody>
						<? foreach ($players as $player): ?>
							<tr>
								<td><?= $player->team; ?></td>
								<td><?= $player->nickname; ?></td>
								<td><?= $player->killNum; ?></td>
								<td><?= $player->damage; ?></td>
							</tr>
						<? endforeach; ?>
						<? if (count($players) == 0): ?>
							<tr>
								<td colspan="4"><center><i>No data found...</i></center></td>
							</tr>
						<? endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	<? endif; ?>
<? endif; ?>
	<br>
	<footer class="d-none d-print-block footer px-4 bg-light py-0">
		<span class="text-muted"><small><i>Created by Kamil yetj. Contact via discord: yetj#2517</i></small></span>
	</footer>
	
	<footer class="fixed-bottom footer mt-auto py-2 px-4 bg-light d-print-none">
		<span class="text-muted"><small><i>Created by Kamil yetj. Contact via discord: yetj#2517</i></small></span>
	</footer>
	<script src="./js/bootstrap.bundle.min.js"></script>
</body>
</html>