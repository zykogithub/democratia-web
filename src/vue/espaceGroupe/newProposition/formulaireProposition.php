<?php
    echo "
        <form action=\"controleurCreationProposition.php?idInternaute=".$idInternaute."&idGroupe=".$idGroupe."\" method=\"post\" enctype=\"multipart/form-data\">
            <div class=\"input-field\" id=\"propositionTitleContainer\">
                <label for=\"title\">Titre de la proposition:</label>
                <input required type=\"text\" id=\"title\" name=\"propositionTitle\"/>
            </div>
            <div class=\"input-field\" id=\"propositionDescriptionContainer\">
                <label for=\"description\">Description de la proposition:</label>
                <textarea maxlength=\"5000\" id=\"description\" name=\"propositionDescription\" placeholder=\"Entrez la description\" style=\"overflow:auto;resize:none\"></textarea>
            </div>
            <div class=\"input-field\" id=\"discussionEndingDateContainer\">
                <label for=\"discussEndDate\">Date de fin de la phase de discussion:</label>
                <input required type=\"date\" id=\"discussEndDate\" name=\"propositionDiscussEndDate\" min=\"".date("Y-m-d", strtotime("+".$groupe->get("nbjDftDiscuss")." days"))."\"/>
            </div>
            <div class=\"input-field\" id=\"idThematiqueContainer\">
                <label for=\"idThematique\">Thématique de la proposition:</label>
                <select class=\"thematique-selector\" id=\"idThematique\" name=\"propositionIdThematique\">";
                $thematiques=$groupe->thematiques($idGroupe);
                foreach($thematiques as $thematique){
                    echo "<option value=\"".$thematique["id_thematique"]."\" budget=\"".$thematique["budget_thematique"]."\">".$thematique["nom_thematique"]."</option>";
                }
                echo "</select>
            </div>
            <div class=\"input-field\" id=\"propositionBudgetContainer\">
                <label for=\"budget\">Budget de la proposition:</label>
                <input required type=\"number\" id=\"budget\" name=\"propositionBudget\" min=\"0\"/>
            </div>
            <div class=\"input-field\" id=\"typeScrutinContainer\">
                <label for=\"typeScrutin\">Thématique de la proposition:</label>
                <select class=\"scrutin-selector\" id=\"typeScrutin\" name=\"propositionTypeScrutin\">
                    <option value=\"1\">Pour/Contre</option>
                    <option value=\"2\">Majoritaire (1 Tour)</option>
                    <option value=\"3\">Majoritaire (2 Tour)</option>
                </select>
            </div>
            <div class=\"input-field\" id=\"choixContainer\">
                <label for=\"choix\">Choix pour ce vote:</label>
                <textarea readonly rows=\"20\" id=\"choix\" name=\"propositionChoix\" style=\"overflow:auto;resize:none\"></textarea>
                <div id=\"choixFields\">
                    <input type=\"text\" class=\"champChoix\" id=\"champ1\" name=\"champ1\" maxlength=\"50\" placeholder=\"Libelle du choix favorable\"/>
                    <input type=\"text\" class=\"champChoix\" id=\"champ2\" name=\"champ2\" maxlength=\"50\" placeholder=\"Libelle du choix défavorable\"/>
                </div>
                <button type =\"button\" id=\"addChoix\">Ajouter</button>
            </div>
            <input id=\"send\" type=\"submit\"/>
        </form>
        <script src='../../scripts/creationProposition.js'></script>
    ";
?>