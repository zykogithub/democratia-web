<?php
    
    require_once("/src/utils/ApiClient.php");
    $api = new ApiClient();

    $api->get([$groupe->get("idGroupe")],"SELECT id_internaute, courriel FROM internaute WHERE id_internaute NOT IN (SELECT id_internaute FROM infos_membre WHERE id_groupe = ?)");
    $resultat = $api->getValeurRetourne();

    $internautes = [];
    foreach ($resultat as $data) {
        $internautes[] = $data;
    }
    echo "
    <div class=\"addMemberBloc\">
        <input type=\"text\" id=\"searchBar\" placeholder=\"Rechercher un internaute...\">
        <div class=\"results\">";
            foreach ($internautes as $internaute){
                echo "<div class=\"result-item\" data-id=\"".$internaute['id_internaute']."\" data-name=".strtolower($internaute['courriel']).">
                    <strong>".sprintf("%05d", $internaute['id_internaute'])."</strong>
                    <span>".$internaute['courriel']."</span>
                    <button class=\"add-button\">+</button>
                </div>";
            }
        echo "
        </div>
        <button id=\"sendNewMembersButton\">Confirmer</button>
    </div>
    <script src='../../scripts/gestionMembres.js'></script>";
?>