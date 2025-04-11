<?php
	// insertion de la classe Connexion
	require_once("../../config/connexion.php");
	require_once("../../modele/proposition.php");
	echo "Ceci est une page de tests.</br>";
	
	// appel de la fonction static de connexion à la base
	Connexion::connect();
	
	echo "Et ici est testé l'affichage des propositions :";
	$les_propositions = proposition::getAllPropositions();
	foreach($les_propositions as $proposition){
		echo "<br>";
		$proposition->afficher();
	}
?>	