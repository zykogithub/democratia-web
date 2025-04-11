<?php
    
    require_once("/src/utils/ApiClient.php");

    class Groupe {
        private int $idGroupe;
        private string $nomGroupe;
        private string $couleurGroupe;
        private string $image;
        private float $budget;
        private int $nbjDftVote;
        private int $nbjDftDiscuss;
        private int $nbSignalement;

        public function __construct(
            int $idGroupe = 0, 
            string $nomGroupe = "", 
            string $couleurGroupe = "#df03fc", 
            string $image = "", 
            float $budget = 0.0, 
            int $nbjDftVote = 0, 
            int $nbjDftDiscuss = 0, 
            int $nbSignalement = 0
        ) {
            $this->idGroupe = $idGroupe;
            $this->nomGroupe = $nomGroupe;
            $this->couleurGroupe = $couleurGroupe;
            $this->image = $image;
            $this->budget = $budget;
            $this->nbjDftVote = $nbjDftVote;
            $this->nbjDftDiscuss = $nbjDftDiscuss;
            $this->nbSignalement = $nbSignalement;
        }

        public function get($attribut) {return $this -> $attribut;}
        public function set($attribut, $valeur) {return $this -> $attribut = $valeur;}
        
        public function page(){
            echo "<div class='groupe-bloc'>";
                    echo "<div class='image-container'>";
                        echo "<img class=\"group-image\" src='../../ressource/image/groupes/".$this->image."'><br>";
                    echo "</div>";
                    echo "<div class='groupe-bar' style='background-color:".$this->couleurGroupe."'>";
                        echo "<div class='name-container'>";
                            echo "<span>".$this->nomGroupe."</span>";
                        echo "</div>";
                        echo "<div class='options-container'>";
                            echo "<a href='controleurListePropositions.php?action=gestionMembres&idGroupe=".$this->idGroupe."&idInternaute=".$_GET["idInternaute"]."'>";
                                echo "<img src='../../ressource/image/members.png'><br>";
                            echo "</a>";
                            echo "<a href='controleurListePropositions.php?action=optionsRole&idGroupe=".$this->idGroupe."&idInternaute=".$_GET["idInternaute"]."'>";
                                echo "<img src='../../ressource/image/settings.png'><br>";
                            echo "</a>";
                        echo "</div>";
                    echo "</div>";
            echo "</div>";
        }

        public function vignette() {
            echo "<div class='groupe-bloc'>";
                echo "<a href='../listePropositions/controleurListePropositions.php?idGroupe=".$this->idGroupe."&idInternaute=".intval($_GET["idInternaute"])."' style='text-decoration: none; color: inherit;'>";
                    echo "<div class='image-container'>";
                        echo "<img class=\"group-image\" src='../../ressource/image/groupes/".$this->image."'><br>";
                    echo "</div>";
                    echo "<div class='name-container'>";
                        echo "<span>".$this->nomGroupe."</span>";
                    echo "</div>";
                echo "</a>";
            echo "</div>";
        }

        public function thematiques(int $idGroupe){
            $api = new ApiClient();
            $api->get([$idGroupe],"SELECT id_thematique, nom_thematique, budget_thematique FROM theme_groupe NATURAL JOIN thematique WHERE id_groupe = ?");
            $resultat = $api->getValeurRetourne();
            $thematiquesData = $resultat;
            var_dump($resultat);
            $lesThematiques = [];
            foreach ($thematiquesData as $data) {
                $lesThematiques[] = array(
                    "id_thematique" => $data["id_thematique"],
                    "nom_thematique" => $data["nom_thematique"],
                    "budget_thematique" => $data["budget_thematique"]
                );
            }
            return $lesThematiques;
        }

        public static function getGroupeById(int $idGroupe){
            $api = new ApiClient();
            $api->get([$idGroupe],"SELECT * FROM groupe G WHERE G.id_groupe = ?");
            $resultat = $api->getValeurRetourne();
            $data=$resultat[0];
            $groupe = new Groupe(
                $data['id_groupe'] ?? 0,
                $data['nom_groupe'] ?? "",
                $data['couleur_groupe'] ?? "",
                $data['image'] ?? "",
                $data['budget'] ?? 0.0,
                $data['nbj_dft_vote'] ?? 0,
                $data['nbj_dft_discuss'] ?? 0,
                $data['nb_signalement'] ?? 0
            );
            return $groupe;
        }

        public static function getGroupesUtilisateur(int $idUtilisateur): array {
            $api = new ApiClient();
            $api->get([$idUtilisateur],"SELECT * FROM groupe G INNER JOIN infos_membre IM ON IM.id_groupe = G.id_groupe WHERE id_internaute = ?");
            $resultat = $api->getValeurRetourne();
            if (!$resultat) {
                return [];
            }
            $groupesData = $resultat;
            $lesGroupes = [];
            foreach ($groupesData as $data) {
                $lesGroupes[] = new Groupe(
                    $data['id_groupe'] ?? 0,
                    $data['nom_groupe'] ?? "",
                    $data['couleur_groupe'] ?? "",
                    $data['image'] ?? "",
                    $data['budget'] ?? 0.0,
                    $data['nbj_dft_vote'] ?? 0,
                    $data['nbj_dft_discuss'] ?? 0,
                    $data['nb_signalement'] ?? 0
                );
            }
            return $lesGroupes;
        }

        public static function afficherGroupesUtilisateur(int $idUtilisateur) {
            $groupes = self::getGroupesUtilisateur($idUtilisateur);
            if (count($groupes)<1){
                echo "Vous n'avez rejoint aucun groupe";
            }else{
                echo "<div class=container-groupes>";
                foreach ($groupes as $groupe) {
                    $groupe->vignette();
                }
                echo "</div>";
            }
        }
    }
?>
