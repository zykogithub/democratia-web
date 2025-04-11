<?php
require_once ('../../../route.php');
require_once $chemin."/API/Api.php";
require_once $chemin."/src/modele/groupe.php";

class Proposition {
    private int $idProposition;
    private string $titre;
    private string $description;
    private string $datePublication;
    private string $dateFinDiscussion;
    private string $dateFinVote;
    private float $budget;
    private int $nbSignalement;
    private string $thematique;
    private int $idGroupe;

    public function __construct(
        int $idProposition = 0,
        string $titre = "",
        string $description = "",
        string $datePublication = "",
        string $dateFinDiscussion = "",
        string $dateFinVote = "",
        float $budget = 0.0,
        int $nbSignalement = 0,
        string $thematique = "",
        int $idGroupe = 0
    ) {
        $this->idProposition = $idProposition;
        $this->titre = $titre;
        $this->description = $description;
        $this->datePublication = $datePublication;
        $this->dateFinDiscussion = $dateFinDiscussion;
        $this->dateFinVote = $dateFinVote;
        $this->budget = $budget;
        $this->nbSignalement = $nbSignalement;
        $this->thematique = $thematique;
        $this->idGroupe = $idGroupe;
    }

    public function get($attribut) {return $this -> $attribut;}
    public function set($attribut, $valeur) {return $this -> $attribut = $valeur;}

    public function vignette() {
        echo "<div class='proposition-bloc' id='".$this->idProposition."'>";
            echo "<a href='../proposition/controleurProposition.php?idProposition=".$this->idProposition."&idInternaute=".intval($_GET["idInternaute"])."'>";
                echo "<div class='title-container'>";
                    echo "<span>".$this->titre."</span>";
                echo "</div>";
                echo "<div class='budget-container'>";
                    echo "<span>".$this->budget."€</span>";
                echo "</div>";
                echo "<div class='details-container'>";
                    echo "<span> Publication : ".date("d-m-Y", strtotime($this->datePublication))."</span>";
                    echo "<span> Thématique : ".$this->thematique."</span>";
                echo "</div>";
            echo "</a>";
        echo "</div>";
    }

	public static function getAllPropositions(int $idGroupe): array {
		$api = new Api();
		$query = "SELECT * FROM proposition NATURAL JOIN vote NATURAL JOIN thematique WHERE id_groupe = ? ORDER BY date_publication DESC";
		$api->get([$idGroupe], null, $query);
		$resultat = $api->getValeurRetourne();
		if (!$resultat) {
			return [];
		}
	
		$lesPropositions = [];
		foreach ($resultat as $data) {
			$lesPropositions[] = new Proposition(
				$data['id_proposition'] ?? 0,
				$data['titre_proposition'] ?? "",
				$data['description_proposition'] ?? "",
				$data['date_publication'] ?? "",
                $data['date_fin_discuss'] ?? "",
				$date["date_fin_vote"] ?? "",
                $data['budget'] ?? 0.0,
				$data['nb_signalement'] ?? 0,
				$data['nom_thematique'] ?? "",
                $idGroupe
			);
		}
	
		return $lesPropositions;
	}

    public static function afficherPropositionsUtilisateur(Groupe $groupe) {
        $propositions = self::getAllPropositions($groupe->get("idGroupe"));
		$api = new Api();

        if (count($propositions)<1){
            echo "Aucune proposition";
        }else{
            echo "<div class=container-propositions>";
            foreach ($propositions as $proposition) {
                $proposition->vignette();
            }
            echo "</div>";
        }
    }
}
?>
