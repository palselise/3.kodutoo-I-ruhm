<?php
	require_once("../../config.php");
	
	function AllBooksData($edit_id){
    
        $database = "if16_epals";
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		
		$stmt = $mysqli->prepare("SELECT author, title FROM Training WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i", $edit_id);
		$stmt->bind_result($exercise, $series);
		$stmt->execute();
		
		//tekitan objekti
		$person = new Stdclass();
		
		//saime �he rea andmeid
		if($stmt->fetch()){
			// saan siin alles kasutada bind_result muutujaid
			$person->exercise = $exercise;
			$person->series = $series;
			}else{
				// ei saanud rida andmeid k�tte
				// sellist id'd ei ole olemas
				// see rida v�ib olla kustutatud
				header("Location: data.php");
				exit();
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $person;
	}
	function updateExercise($id, $exercise, $series){
    	
        $database = "if16_epals";
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		
		$stmt = $mysqli->prepare("UPDATE Training SET a=?, title=? WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("ssi",$exercise, $series, $id);
		
		// kas �nnestus salvestada
		if($stmt->execute()){
			// �nnestus
			echo "salvestus �nnestus!";
		}
		
		$stmt->close();
		$mysqli->close();
		
	}
	
	
	//KUSTUTAMINE
	function deleteExercise($id){
     	
        $database = "if16_epals";
 		
 		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
 		
 		$stmt = $mysqli->prepare("UPDATE Training SET deleted=NOW() WHERE id=? AND deleted IS NULL");
 		$stmt->bind_param("i",$id);
 		
		// kas �nnestus salvestada
		if($stmt->execute()){
 			// �nnestus
 			echo "salvestus �nnestus!";
 		}
	
 		$stmt->close();
 		$mysqli->close();
 		
 	}
?>