<?php
    
    require_once("/src/utils/ApiClient.php");
    class internaute {
        private int $id_internaute;
        private string $nom_internaute;
        private string $prenom_internaute;
        private string $adresse_postal;
        private string $courriel;
        private string $role;

        public function __construct(
            int $id_internaute = 0,
            string $nom_internaute = "",
            string $prenom_internaute = "",
            string $adresse_postal = "",
            string $courriel = "",
            string $role = ""
        ) {
            $this->id_internaute = $id_internaute;
            $this->nom_internaute = $nom_internaute;
            $this->prenom_internaute = $prenom_internaute;
            $this->adresse_postal = $adresse_postal;
            $this->courriel = $courriel;
            $this->role = $role;
        }

        public function get($attribut) {return $this -> $attribut;}
        public function set($attribut, $valeur) {return $this -> $attribut = $valeur;}

        public function vignette(bool $isAdmin) {
            $roleInternaute=$this->role;
            echo "<div class='membre-bloc' member-id='".$this->id_internaute."' role='".$roleInternaute."'>";
            echo "<div class='id-container'>";
            echo "<span>".sprintf("%05d", $this->id_internaute)."</span>";
            echo "</div>";
            echo "<div class='noms-container'>";
            echo "<span>".$this->prenom_internaute." ".$this->nom_internaute."</span>";
            echo "</div>";
            echo "<div class='courriel-container'>";
            echo "<span>".$this->courriel."</span>";
            echo "</div>";
            if($isAdmin){
                if($roleInternaute!='Administrateur'){
                    $roles=['Membre','Administrateur','Décideur','Modérateur','Assesseur','Scrutateur'];
                    $idRole=array_search($roleInternaute, $roles);
                    array_splice($roles, $idRole, 1);
                    array_splice($roles, array_search('Administrateur', $roles), 1);
                    echo "<div class='role-container'>
                    <select class=\"role-selector\">
                    <option value=\"".$roleInternaute."\">".$roleInternaute."</option>";
                    foreach($roles as $role){
                        echo "<option value=\"".$role."\">$role</option>";
                    }
                    echo "</select>
                    <button class=\"del-button\">X</button>
                    </div>";
                }else{
                    echo "<div class='role-container'>";
                    echo "<span>".$roleInternaute."</span>";
                    echo "</div>";
                }
            }else{
                echo "<div class='role-container'";
                echo "<span>".$roleInternaute."</span>";
                echo "</div>";
            }
            echo "</div>";
        }

        public static function getInternauteById(int $idGroupe, int $idInternaute){
            $api = new ApiClient();
            $api->get([$idGroupe, $idInternaute],"SELECT id_internaute, nom_internaute, prenom_internaute, adresse_postale, courriel, nom_role FROM internaute NATURAL JOIN infos_membre NATURAL JOIN role WHERE id_groupe = ? AND id_internaute = ?");
            $resultat = $api->getValeurRetourne();
            $data=$resultat[0];
            $internaute = new Internaute(
                $data['id_internaute'] ?? 0,
                $data['nom_internaute'] ?? "",
                $data['prenom_internaute'] ?? "",
                $data['adresse_postal'] ?? "",
                $data['courriel'] ?? "",
                $data['nom_role'] ?? ""
            );
            return $internaute;
        }

        public static function getMembresGroupe(int $idGroupe): array {
            $api = new ApiClient();
            $api->get([$idGroupe],"SELECT id_internaute, nom_internaute, prenom_internaute, adresse_postale, courriel, nom_role FROM internaute NATURAL JOIN infos_membre NATURAL JOIN role WHERE id_groupe = ?");
            $resultat = $api->getValeurRetourne();
            if (!$resultat) {
                return [];
            }
            $membresData = $resultat;
            $lesMembres = [];
            foreach ($membresData as $data) {
                $lesMembres[] = new Internaute(
                    $data['id_internaute'] ?? 0,
                    $data['nom_internaute'] ?? "",
                    $data['prenom_internaute'] ?? "",
                    $data['adresse_postal'] ?? "",
                    $data['courriel'] ?? "",
                    $data['nom_role'] ?? ""
                );
            }
            return $lesMembres;
        }

        public static function afficherMembresGroupe(int $idGroupe, string $roleUtilisateur) {
            $membres = self::getMembresGroupe($idGroupe);
            $isAdmin = ($roleUtilisateur == "Administrateur" ? true : false);
            if (count($membres)<1){
                echo "Problème de récupération des membres";
            }else{
                echo "<div class=container-membres>";
                foreach ($membres as $membre) {
                    $membre->vignette($isAdmin);
                }
                if($isAdmin){
                    echo "<button id=\"sendUpdatedMembersButton\">Confirmer</button>";
                }
                echo "</div>";
            }
        }
    }
?>
