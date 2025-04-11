<?php
    echo "
        <form action=\"controleurCreationGroupe.php?idInternaute=".$idInternaute."\" method=\"post\" enctype=\"multipart/form-data\">
            <div class=\"input-field\" id=\"groupeNameContainer\">
                <label for=\"name\">Nom du groupe:</label>
                <input required type=\"text\" id=\"name\" name=\"groupeName\" maxlength=\"100\" placeholder=\"Ex : Nom du groupe\"/>
            </div>
            <div class=\"input-field\" id=\"groupeColorContainer\">
                <label for=\"color\">Couleur représentative:</label>
                <input required type=\"color\" id=\"color\" name=\"groupeColor\"/>
            </div>
            <div class=\"input-field\" id=\"groupeImageContainer\">
                <label for=\"image\">Image:</label>
                <input required type=\"file\" id=\"image\" name=\"groupeImage\" accept=\".jpg,.png\"/>
            </div>
            <div class=\"input-field\" id=\"groupeBudgetContainer\">
                <label for=\"budget\">Budget:</label>
                <input required type=\"number\" id=\"budget\" name=\"groupeBudget\" min=\"0\" max=\"999999999999\" placeholder=\"Ex : 12000\"/>
            </div>
            <div class=\"input-field\" id=\"thematiquesContainer\">
                <label for=\"thematiques\">Thématiques avec budget :</label>
                <textarea readonly rows=\"20\" id=\"thematiques\" name=\"groupeThematiques\" style=\"overflow:auto;resize:none\"></textarea>
                <div id=\"thematiqueFields\">
                    <input type=\"text\" class=\"champThematique\" id=\"themeName\" name=\"themeName\" maxlength=\"100\" placeholder=\"Ex : Nom de la thématique\"/>
                    <input type=\"number\" class=\"champThematique\" id=\"themeBudget\" name=\"themeBudget\" min=\"-1\" max=\"999999999999\" placeholder=\"Ex : 3000 (-1 pour supprimé la thématique)\"/>
                </div>
                <button type =\"button\" id=\"addThematique\">Ajouter une thematique</button>
            </div>
            <div class=\"input-field\" id=\"groupeDiscussionDurationContainer\">
                <label for=\"nbjDftDiscuss\">Durée par défaut des phases de discussion (en jours):</label>
                <input required type=\"text\" id=\"nbjDftDiscuss\" name=\"groupeNbjDftDiscuss\" min=\"0\" placeholder=\"Ex : 14\"/>
            </div>
            <div class=\"input-field\" id=\"groupeVoteDurationContainer\">
                <label for=\"nbjDftVote\">Durée par défaut des votes (en jours):</label>
                <input required type=\"text\" id=\"nbjDftVote\" name=\"groupeNbjDftVote\" min=\"0\" placeholder=\"Ex : 14\"/>
            </div>
            <input id=\"send\" type=\"submit\"/>
        </form>
        <script src='../../scripts/creationGroupe.js'></script>
    ";
?>