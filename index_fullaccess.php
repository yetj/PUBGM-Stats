<?
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

$rank_Phase1 = [];
$rank_Phase2 = [];
$rank_Phase3 = [];
$rank_General = [];
$rank_Bonus = [];

if(isset($_REQUEST['clearCache'])) {
	$clearCache = 1;
}

if(isset($_GET['r'])) {
	$region = $_GET['r'];
	if (array_key_exists($region, $regions)) {
		if (array_key_exists($region, $newRegions)) {
			$newRegion = true;
		}
		
		$region = str_replace("_", " ", $region);
		
		/// GET Unique Tabs
		if (file_exists("cache/".$_GET['r']."_tabs.json") && (filemtime("cache/".$_GET['r']."_tabs.json") > time()-$CACHE_TIME_TABS) && $clearCache == 0) {
			
			$file = "cache/".$_GET['r']."_tabs.json";
			$results = json_decode(file_get_contents($file), true);
			
		}
		else {
			$API = new API($regions[$_GET['r']]);
			$results = null;
			if ($newRegion) {
				$results = $API->getRange('config!C29:C');
			}
			else {
				$results = $API->getRange('teams&points!C24:C');
			}
			
			/// save to cache
			$file = "cache/".$_GET['r']."_tabs.json";
			file_put_contents($file, json_encode($results));
		}
		
		$tabs = [];
		foreach ($results as $result) {
			if (isset($result[0])) {
				$tabs[] = $result[0];
			}
		}

		$unique_tabs = array_unique($tabs);
		
		/// GET match results		
		if(isset($_POST['t'])) {
			
			/// GET Players & Teams
			
			if (!$API) {
				$API = new API($regions[$_GET['r']]);
			}
			
			if ($newRegion) {
				$results = $API->getRange('config!BK2:BN');
			}
			else {
				$results = $API->getRange('teams&points!AW2:AZ');
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
		
			$selectedTabs = $_POST['t'];
			
			$tabsToGet = [];
			
			foreach ($selectedTabs as $k => $v) {
				$tabsToGet[] = "'".$k."'!C2:AP";
			}
			
			if (!$API) {
				$API = new API($regions[$_GET['r']]);
			}
			$dataTabs = $API->getBatchRange($tabsToGet);
			
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
		
			// GET Rankings
			if (!$API) {
				$API = new API($regions[$_GET['r']]);
			}
			$sheetName = $API->getName();
			
			if ($newRegion) {
				if (strpos($sheetName, "PMPL") !== false) {
					$cupType = "PMPLnew";
					
					// Phase 1
					$results = $API->getRange('production!X6:AC25');
					if (is_array($results)) {
						foreach ($results as $result) {
							$teamName = $result[0];
							$ranking = new Ranking($teamName);
							$ranking->addStats($result);
							
							$rank_Phase1[] = $ranking;
						}
					}
					
					// Phase 2
					$results = $API->getRange('production!AM6:AR25');
					if (is_array($results)) {
						foreach ($results as $result) {
							$teamName = $result[0];
							$ranking = new Ranking($teamName);
							$ranking->addStats($result);
							
							$rank_Phase2[] = $ranking;
						}
					}
					
					// Phase 3
					$results = $API->getRange('production!BB6:BG25');
					if (is_array($results)) {
						foreach ($results as $result) {
							$teamName = $result[0];
							$ranking = new Ranking($teamName);
							$ranking->addStats($result);
							
							$rank_Phase3[] = $ranking;
						}
					}
					
					// General
					$results = $API->getRange('production!BQ6:BV25');
					if (is_array($results)) {
						foreach ($results as $result) {
							$teamName = $result[0];
							$ranking = new Ranking($teamName);
							$ranking->addStats($result);
							
							$rank_General[] = $ranking;
						}
					}
					
					// Bonus
					$results = $API->getRange('production!CF6:CK25');
					if (is_array($results)) {
						foreach ($results as $result) {
							$teamName = $result[0];
							$ranking = new Ranking($teamName);
							$ranking->addStatsBonus($result);
							
							$rank_Bonus[] = $ranking;
						}
					}
					
					// Finals
					$results = $API->getRange('production!CV6:DB21');
					if (is_array($results)) {
						foreach ($results as $result) {
							$teamName = $result[0];
							$ranking = new Ranking($teamName);
							$ranking->addStatsBonusFinals($result);
							
							$rank_Finals[] = $ranking;
						}
					}
					
				}
			}
			else {
			
				if (strpos($sheetName, "PMCO") !== false) {
					$cupType = "PMCO";
					
					// Group Stage
					$results = $API->getRange('production!AO6:AT37');
					if (is_array($results)) {
						foreach ($results as $result) {
							$teamName = $result[0];
							$ranking = new Ranking($teamName);
							$ranking->addStats($result);
							
							$rank_GroupStage[] = $ranking;
						}
					}
					
					// Finals
					$results = $API->getRange('production!BQ6:BV21');
					if (is_array($results)) {
						foreach ($results as $result) {
							$teamName = $result[0];
							$ranking = new Ranking($teamName);
							$ranking->addStats($result);
							
							$rank_Finals[] = $ranking;
						}
					}
					
				}
				elseif (strpos($sheetName, "PMPL Quali - Scoresheet AF") !== false) {
					$cupType = "PMPLQAF";
					
					// Play-ins
					$results = $API->getRange('production!CE6:CJ21');
					if (is_array($results)) {
						foreach ($results as $result) {
							$teamName = $result[0];
							$ranking = new Ranking($teamName);
							$ranking->addStats($result);
							
							$rank_GroupStage[] = $ranking;
						}
					}
					
					// Main stage
					$results = $API->getRange('production!BQ6:BV29');
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
					$results = $API->getRange('production!BC6:BH21');
					if (is_array($results)) {
						foreach ($results as $result) {
							$teamName = $result[0];
							$ranking = new Ranking($teamName);
							$ranking->addStats($result);
							
							$rank_Finals[] = $ranking;
						}
					}
				}
				elseif (strpos($sheetName, "PMWI Week 1") !== false) {
					$cupType = "PMWI";
					
					// Overall Standings
					$results = $API->getRange('production!CE6:CJ23');
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
					
					
					if (strpos($sheetName, "2023") !== false) {
						$cupType = "PMPL2023";
						
						// League Play Week 1
						$results = $API->getRange('production!BC6:BH25');
						if (is_array($results)) {
							foreach ($results as $result) {
								$teamName = $result[0];
								$ranking = new Ranking($teamName);
								$ranking->addStats($result);
								
								$rank_Phase1[] = $ranking;
							}
						}
						// League Play Week 2
						$results = $API->getRange('production!BQ6:BV25');
						if (is_array($results)) {
							foreach ($results as $result) {
								$teamName = $result[0];
								$ranking = new Ranking($teamName);
								$ranking->addStats($result);
								
								$rank_Phase2[] = $ranking;
							}
						}
						// League Play Week 3
						$results = $API->getRange('production!CE6:CJ25');
						if (is_array($results)) {
							foreach ($results as $result) {
								$teamName = $result[0];
								$ranking = new Ranking($teamName);
								$ranking->addStats($result);
								
								$rank_Phase3[] = $ranking;
							}
						}
						// Super Weekends
						$results = $API->getRange('production!CS6:CX25');
						if (is_array($results)) {
							foreach ($results as $result) {
								$teamName = $result[0];
								$ranking = new Ranking($teamName);
								$ranking->addStats($result);
								
								$rank_SuperWeekends[] = $ranking;
							}
						}
						// Finals
						$results = $API->getRange('production!DG6:DL21');
						if (is_array($results)) {
							foreach ($results as $result) {
								$teamName = $result[0];
								$ranking = new Ranking($teamName);
								$ranking->addStats($result);
								
								$rank_Finals[] = $ranking;
							}
						}
						// Super Weekends + Finals
						$results = $API->getRange('production!DV6:EA25');
						if (is_array($results)) {
							foreach ($results as $result) {
								$teamName = $result[0];
								$ranking = new Ranking($teamName);
								$ranking->addStats($result);
								
								$rank_SWandFinals[] = $ranking;
							}
						}
						
					}
					else {
						// League Play
						$results = $API->getRange('production!BC6:BH25');
						if (is_array($results)) {
							foreach ($results as $result) {
								$teamName = $result[0];
								$ranking = new Ranking($teamName);
								$ranking->addStats($result);
								
								$rank_GroupStage[] = $ranking;
							}
						}
						
						
						// Super Weekends
						$results = $API->getRange('production!BQ6:BV25');
						if (is_array($results)) {
							foreach ($results as $result) {
								$teamName = $result[0];
								$ranking = new Ranking($teamName);
								$ranking->addStats($result);
								
								$rank_SuperWeekends[] = $ranking;
							}
						}
						
						// Finals
						$results = $API->getRange('production!CE6:CJ21');
						if (is_array($results)) {
							foreach ($results as $result) {
								$teamName = $result[0];
								$ranking = new Ranking($teamName);
								$ranking->addStats($result);
								
								$rank_Finals[] = $ranking;
							}
						}
						
						// Super Weekends + Finals
						$results = $API->getRange('production!CT6:CY25');
						if (is_array($results)) {
							foreach ($results as $result) {
								$teamName = $result[0];
								$ranking = new Ranking($teamName);
								$ranking->addStats($result);
								
								$rank_SWandFinals[] = $ranking;
							}
						}
					}
				}
			}
		}
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
	
	<link href="./css/tablesort.css" rel="stylesheet">
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
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarRegion" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							<?= $region ? $region : "Select Region"; ?>
						</a>
						<ul class="dropdown-menu dropdown-menu-info" aria-labelledby="navbarRegion" style="max-height: 500px; overflow-y: scroll;">
							<? foreach($regions as $k => $v): ?>
								<li>
									<a class="dropdown-item<?= $region == str_replace("_", " ", $k) ? " active" : ""; ?>" href="?r=<?= $k; ?>">
										<?= str_replace("_", " ", $k); ?>
									</a>
								</li>
							<? endforeach; ?>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</nav>
<? if ($region && $unique_tabs): ?>
	<div class="p-2 tabs">
		<form action="" method="post">
			<input type="hidden" name="r" value="<?= $_GET['r']; ?>" />
			Tabs:
			<? foreach($unique_tabs as $tab): ?>
				<input type="checkbox" class="btn-check btn-<?= $tab; ?>" id="btn-<?= $tab; ?>" name="t[<?= $tab; ?>]" <?= array_key_exists($tab, $selectedTabs) ? "checked" : ""; ?> autocomplete="off">
				<label class="btn btn-sm btn-outline-info my-1" for="btn-<?= $tab; ?>"><?= $tab; ?></label>
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
				<button class="nav-link d-print-none" id="nav-mvp-tab" data-bs-toggle="tab" data-bs-target="#nav-mvp" type="button" role="tab" aria-controls="nav-mvp" aria-selected="false">MVP</button>
				<button class="nav-link d-print-none" id="nav-mvp_new-tab" data-bs-toggle="tab" data-bs-target="#nav-mvp_new" type="button" role="tab" aria-controls="nav-mvp_new" aria-selected="false">MVP new</button>
				<button class="nav-link d-print-none" id="nav-rankings-tab" data-bs-toggle="tab" data-bs-target="#nav-rankings" type="button" role="tab" aria-controls="nav-rankings" aria-selected="false">Rankings</button>
			</div>
		</nav>
		<div class="tab-content" id="nav-tabContent">
			<div class="tab-pane show active" id="nav-playerstats" role="tabpanel" aria-labelledby="nav-playerstats-tab">
				<table class="table table-sm table-hover table-striped table-responsive table-sortable">
					<caption><small>Total Survival Time: <?= floor($totalSurvivalTime/(24*60*60)) ?>d_<?= gmdate("H:i:s", $totalSurvivalTime); ?> (<?= $totalSurvivalTime; ?>) | Total Damage: <?= $totalDamage; ?> | Total Kills: <?= $totalKills; ?></small></caption>
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
							<th>Avg. Survival time</th>
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
							<tr class="<?= $player->isMVP_new == 1 ? ' table-success' : "";?><?= $player->isMVP == 1 ? ' table-info' : "";?>">
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
								<td>
									<? if ($player->games > 0): ?>
										<?= gmdate("i:s", $player->survivalTime/$player->games); ?>
									<? else: ?>
										00:00
									<? endif; ?>
								</td>
								<td><?= $player->driveDistance; ?></td>
								<td><?= $player->marchDistance; ?></td>
								<td><?= $player->assists; ?></td>
								<td><?= $player->killNumByGrenade; ?></td>
								<td><?= $player->games > 0 ? round($player->rank / $player->games, 2) : 0; ?></td>
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
				<table class="table table-sm table-hover table-striped table-sortable">
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
							<th>Avg. Survival time</th>
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
								<td>
									<? if ($team->games > 0): ?>
										<?= gmdate("i:s", $team->survivalTime/$team->games); ?>
									<? else: ?>
										00:00
									<? endif; ?>
								</td>
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
				
				<table class="table table-sm table-hover table-striped table-sortable">
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
			<div class="tab-pane fade" id="nav-mvp" role="tabpanel" aria-labelledby="nav-mvp-tab">
				<?
					// SORT Players by kill num and damage
					usort($players, function($a, $b): int {
						return $b->mvp <=> $a->mvp;
					});
				?>
				
				<table class="table table-sm table-hover table-striped table-sortable">
					<caption><small>Total Survival Time: <?= floor($totalSurvivalTime/(24*60*60)) ?>d_<?= gmdate("H:i:s", $totalSurvivalTime); ?> (<?= $totalSurvivalTime; ?>) | Total Damage: <?= $totalDamage; ?> | Total Kills: <?= $totalKills; ?></small></caption>
					<thead>
						<tr style="position: sticky; top: -1px; background-color: #5ae3ff;">
							<th>Team name</th>
							<th>Player</th>
							<th>MVP</th>
							<th>Kills</th>
							<th>Damage</th>
							<th>Survival Time</th>
						</tr>
					</thead>
					<tbody>
						<? foreach ($players as $player): ?>
							<tr>
								<td><?= $player->team; ?></td>
								<td><?= $player->nickname; ?></td>
								<td><?= $player->mvp; ?></td>
								<td><?= $player->killNum; ?></td>
								<td><?= $player->damage; ?></td>
								<td><?= floor($player->survivalTime/(24*60*60)) ?>d_<?= gmdate("H:i:s", $player->survivalTime); ?></td>
							</tr>
						<? endforeach; ?>
						<? if (count($players) == 0): ?>
							<tr>
								<td colspan="6"><center><i>No data found...</i></center></td>
							</tr>
						<? endif; ?>
					</tbody>
				</table>
			</div>
			<div class="tab-pane fade" id="nav-mvp_new" role="tabpanel" aria-labelledby="nav-mvp_new-tab">
				<?
					// SORT Players by kill num and damage
					usort($players, function($a, $b): int {
						return $b->mvp_new <=> $a->mvp_new;
					});
				?>
				
				<table class="table table-sm table-hover table-striped table-sortable">
					<caption><small>Total Survival Time: <?= floor($totalSurvivalTime/(24*60*60)) ?>d_<?= gmdate("H:i:s", $totalSurvivalTime); ?> (<?= $totalSurvivalTime; ?>) | Total Damage: <?= $totalDamage; ?> | Total Kills: <?= $totalKills; ?> | Total Knocknouts: <?= $totalKnockouts; ?></small></caption>
					<thead>
						<tr style="position: sticky; top: -1px; background-color: #5ae3ff;">
							<th>Team name</th>
							<th>Player</th>
							<th>MVP</th>
							<th>Kills</th>
							<th>Damage</th>
							<th>Knocknouts</th>
							<th>Survival Time</th>
						</tr>
					</thead>
					<tbody>
						<? foreach ($players as $player): ?>
							<tr>
								<td><?= $player->team; ?></td>
								<td><?= $player->nickname; ?></td>
								<td><?= $player->mvp_new; ?></td>
								<td><?= $player->killNum; ?></td>
								<td><?= $player->damage; ?></td>
								<td><?= $player->knockouts; ?></td>
								<td><?= floor($player->survivalTime/(24*60*60)) ?>d_<?= gmdate("H:i:s", $player->survivalTime); ?></td>
							</tr>
						<? endforeach; ?>
						<? if (count($players) == 0): ?>
							<tr>
								<td colspan="6"><center><i>No data found...</i></center></td>
							</tr>
						<? endif; ?>
					</tbody>
				</table>
			</div>
			<div class="tab-pane fade" id="nav-rankings" role="tabpanel" aria-labelledby="nav-rankings-tab">
				<table>
					<thead>
						<tr>
							<? if($cupType == "PMCO"): ?>
								<th>Group stage</th>
								<th>Finals</th>
							<? elseif($cupType == "PMPLQAF"): ?>
								<th>Play-ins</th>
								<th>Main Stage</th>
							<? elseif($cupType == "PMPLQ"): ?>
								<th>Overall Ranking</th>
							<? elseif($cupType == "PMWI"): ?>
								<th>Overall Ranking</th>
							<? elseif($cupType == "PMPL2023"): ?>
								<th>League Play Week 1</th>
								<th>League Play Week 2</th>
								<th>League Play Week 3</th>
							<? elseif($cupType == "PMPL"): ?>
								<th>League Play</th>
								<th>Super Weekends</th>
							<? elseif($cupType == "PMPLnew"): ?>
								<th>Phase 1</th>
								<th>Phase 2</th>
								<th>Phase 3</th>
							<? endif; ?>
						</tr>
					</thead>
					<tbody>
						<tr>
							<? if($cupType == "PMCO"): ?>
								<td style="vertical-align: top;"><?= Ranking::prepareRanking($rank_GroupStage) ?></td>
								<td style="vertical-align: top;"><?= Ranking::prepareRanking($rank_Finals) ?></td>
							<? elseif($cupType == "PMPLQAF"): ?>
								<td style="vertical-align: top;"><?= Ranking::prepareRanking($rank_GroupStage) ?></td>
								<td style="vertical-align: top;"><?= Ranking::prepareRanking($rank_Finals) ?></td>
							<? elseif($cupType == "PMWI"): ?>
								<td style="vertical-align: top;"><?= Ranking::prepareRanking($rank_Finals) ?></td>
							<? elseif($cupType == "PMPLQ"): ?>
								<td style="vertical-align: top;"><?= Ranking::prepareRanking($rank_Finals) ?></td>
							<? elseif($cupType == "PMPL2023"): ?>
								<td style="vertical-align: top;"><?= Ranking::prepareRanking($rank_Phase1) ?></td>
								<td style="vertical-align: top;"><?= Ranking::prepareRanking($rank_Phase2) ?></td>
								<td style="vertical-align: top;"><?= Ranking::prepareRanking($rank_Phase3) ?></td>
							<? elseif($cupType == "PMPL"): ?>
								<td style="vertical-align: top;"><?= Ranking::prepareRanking($rank_GroupStage) ?></td>
								<td style="vertical-align: top;"><?= Ranking::prepareRanking($rank_SuperWeekends) ?></td>
							<? elseif($cupType == "PMPLnew"): ?>
								<td style="vertical-align: top;"><?= Ranking::prepareRanking($rank_Phase1) ?></td>
								<td style="vertical-align: top;"><?= Ranking::prepareRanking($rank_Phase2) ?></td>
								<td style="vertical-align: top;"><?= Ranking::prepareRanking($rank_Phase3) ?></td>
							<? endif; ?>
						</tr>
					</tbody>
				</table>
				
				<? if($cupType == "PMPL"): ?>
					<table>
						<thead>
							<tr>
								<th>Super Weekends + Finals</th>
								<th>Finals</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td style="vertical-align: top;"><?= Ranking::prepareRanking($rank_Finals) ?></td>
								<td style="vertical-align: top;"><?= Ranking::prepareRanking($rank_SWandFinals) ?></td>
							</tr>
						</tbody>
					</table>
				<? elseif($cupType == "PMPL2023"): ?>
					<table>
						<thead>
							<tr>
								<th>Super Weekends</th>
								<th>Super Weekends + Finals</th>
								<th>Finals</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td style="vertical-align: top;"><?= Ranking::prepareRanking($rank_SuperWeekends) ?></td>
								<td style="vertical-align: top;"><?= Ranking::prepareRanking($rank_SWandFinals) ?></td>
								<td style="vertical-align: top;"><?= Ranking::prepareRanking($rank_Finals) ?></td>
							</tr>
						</tbody>
					</table>
				<? elseif($cupType == "PMPLnew"): ?>
					<table>
						<thead>
							<tr>
								<th>General ranking</th>
								<th>Bonus points</th>
								<th>Finals</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td style="vertical-align: top;"><?= Ranking::prepareRanking($rank_General) ?></td>
								<td style="vertical-align: top;"><?= Ranking::prepareRankingBonus($rank_Bonus) ?></td>
								<td style="vertical-align: top;"><?= Ranking::prepareRankingBonusFinals($rank_Finals) ?></td>
							</tr>
						</tbody>
					</table>
				<? endif; ?>
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
	<script src="./js/tablesort.js"></script>
</body>
</html>