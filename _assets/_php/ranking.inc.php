<?php

function rankPersonagem(){
	global $SQL;
	$query = "SELECT nick, profile, level, date, team_id FROM " . USUARIOS . " ORDER BY level DESC";
    $stmt = $SQL->query($query);
    $x = 0;
   	while($row = $stmt->fetch_row()){
   		$rankP["nick"][$x] = $row[0];
   		$rankP["profile"][$x] = $row[1];
   		$rankP["level"][$x] = $row[2];
   		$rankP["date"][$x] = $row[3];
   		$rankP["team_id"][$x] = $row[4];
   		++$x;
   	}
   	unset($x, $row, $query);
   	$stmt->close();
   	return $rankP;

}

function rankTeam(){
	global $SQL;
	$query = "SELECT name, level, wins, loses FROM " . TEAM . " ORDER BY level DESC";
    $stmt = $SQL->query($query);
    $x = 0;
   	while($row = $stmt->fetch_row()){
   		$rankT["name"][$x] = $row[0];
   		$rankT["level"][$x] = $row[1];
   		$rankT["wins"][$x] = $row[2];
   		$rankT["loses"][$x] = $row[3];
   		++$x;
   	}
   	unset($x, $row, $query);
   	$stmt->close();
   	return $rankT;
}