<?php
require_once '../../../route.php';
require_once $chemin . "/API/Api.php";

class Proposition {
    private Api $api;
    private int $idProposition;
    private string $titre;
    private string $description;
    private string $publication;
    private float $budget;
    private int $nbSignalement;
    private string $thematique;
    private int $idGroupe;

    public function __construct(
        Api $api,
        int $idProposition = 0,
    ) {
        $this->api = $api;
        $this->idProposition = $idProposition;
        $this->idGroupe = $this->fetchGroupeId();
        $deatail = $this->getProposition($idProposition);
        $this->titre = $deatail['titre_proposition'];
        $this->description = $deatail['description_proposition'];
        $this->publication = $deatail['date_publication'];
        $this->budget = $deatail['budget'];
        $this->nbSignalement = $deatail['nb_signalement'];
        $this->thematique = $deatail['id_thematique'];
    }

    public function get($attribut){
        return $this->$attribut;
    }

    public function set($attribut, $valeur){
        $this->$attribut = $valeur;
    }

    public function afficher(): void {
        echo "<strong>ID Proposition :</strong> " . htmlspecialchars($this->idProposition) . "<br>";
        echo "<strong>Titre :</strong> " . (!empty($this->titre) ? htmlspecialchars($this->titre) : "Non spécifié") . "<br>";
        echo "<strong>Description :</strong> " . (!empty($this->description) ? htmlspecialchars($this->description) : "Non spécifiée") . "<br>";
        echo "<strong>Date de publication :</strong> " . (!empty($this->publication) ? htmlspecialchars($this->publication) : "Non spécifiée") . "<br>";
        echo "<strong>Budget :</strong> " . (!empty($this->budget) ? htmlspecialchars($this->budget) : "Non spécifié") . "<br>";
        echo "<strong>Nombre de signalements :</strong> " . htmlspecialchars($this->nbSignalement) . "<br>";
        echo "<strong>Thématique :</strong> " . (!empty($this->thematique) ? htmlspecialchars($this->thematique) : "Non spécifiée") . "<br>";
        echo "<strong>ID Groupe :</strong> " . htmlspecialchars($this->idGroupe) . "<br>";
    }
    

    private function fetchGroupeId(): int {
        $query = "SELECT id_groupe FROM proposition WHERE id_proposition = ?";
        $this->api->get([$this->idProposition], null, $query);
        $result = $this->api->getValeurRetourne();

        if (!$result || !isset($result[0]['id_groupe'])) {
            throw new Exception("Groupe introuvable pour cette proposition.");
        }

        return (int)$result[0]['id_groupe'];
    }


    public function getAllPropositions(int $idGroup): array {
        $query = "
            SELECT p.*, t.nom_thematique
            FROM proposition p
            INNER JOIN thematique t ON p.id_thematique = t.id_thematique
            WHERE p.id_groupe = ?
        ";
        $this->api->get([$idGroup], null, $query);
        $resultat = $this->api->getValeurRetourne();

        if (!$resultat) {
            return [];
        }

        $propositions = [];
        foreach ($resultat as $data) {
            $propositions[] = new Proposition(
                $this->api,
                (int)$data['id_proposition'],
                $data['titre_proposition'] ?? "",
                $data['description_proposition'] ?? "",
                $data['date_publication'] ?? "",
                (float)$data['budget'],
                (int)$data['nb_signalement'],
                $data['nom_thematique'] ?? ""
            );
        }

        return $propositions;
    }

    public function getProposition($idProposition){
        $query = "SELECT * FROM proposition WHERE id_proposition = ?";
        $this->api->get([$idProposition], null, $query);
        $resultat = $this->api->getValeurRetourne();
        return $resultat[0];
    }

    public function getPropositionDetails(): array {
        $query = "
            SELECT 
                p.id_proposition,
                p.titre_proposition,
                p.description_proposition,
                p.date_publication,
                p.budget,
                t.nom_thematique
            FROM proposition p
            INNER JOIN thematique t ON p.id_thematique = t.id_thematique
            WHERE p.id_proposition = ?
        ";
        $this->api->get([$this->idProposition], null, $query);
        return $this->api->getValeurRetourne()[0] ?? [];
    }

    public function getNombreDemandesVote(): int {
        $query = "
            SELECT COUNT(*) AS nombre_demandes_vote
            FROM demande_vote
            WHERE id_proposition = ?
        ";
        $this->api->get([$this->idProposition], null, $query);
        return (int)$this->api->getValeurRetourne()[0]['nombre_demandes_vote'] ?? 0;
    }

    public function getNombreLikes(): int {
        $query = "
            SELECT COUNT(*) AS nombre_likes
            FROM reaction_proposition
            WHERE id_proposition = ? AND id_reaction = 1
        ";
        $this->api->get([$this->idProposition], null, $query);
        return (int)$this->api->getValeurRetourne()[0]['nombre_likes'] ?? 0;
    }

    public function getNombreDislikes(): int {
        $query = "
            SELECT COUNT(*) AS nombre_dislikes
            FROM reaction_proposition
            WHERE id_proposition = ? AND id_reaction = 2
        ";
        $this->api->get([$this->idProposition], null, $query);
        return (int)$this->api->getValeurRetourne()[0]['nombre_dislikes'] ?? 0;
    }

    public function like(int $idInternaute): void {
        $queryCheck = "
            SELECT id_reaction
            FROM reaction_proposition
            WHERE id_proposition = ? AND id_internaute = ? AND id_groupe = ?
        ";
        $this->api->get([$this->idProposition, $idInternaute, $this->idGroupe], null, $queryCheck);
        $result = $this->api->getValeurRetourne();

        if ($result && isset($result[0]['id_reaction']) && $result[0]['id_reaction'] == 1) {
            $queryDelete = "
                DELETE FROM reaction_proposition
                WHERE id_proposition = ? AND id_internaute = ? AND id_groupe = ?
            ";
            $this->api->delete([$this->idProposition, $idInternaute, $this->idGroupe], null, $queryDelete);
        } else {
            $queryInsert = "
                INSERT INTO reaction_proposition (id_proposition, id_internaute, id_groupe, id_reaction)
                VALUES (?, ?, ?, 1)
            ";
            $this->api->post([$this->idProposition, $idInternaute, $this->idGroupe], null, $queryInsert);
        }
    }

    public function dislike(int $idInternaute): void {
        $queryCheck = "
            SELECT id_reaction
            FROM reaction_proposition
            WHERE id_proposition = ? AND id_internaute = ? AND id_groupe = ?
        ";
        $this->api->get([$this->idProposition, $idInternaute, $this->idGroupe], null, $queryCheck);
        $result = $this->api->getValeurRetourne();

        if ($result && isset($result[0]['id_reaction']) && $result[0]['id_reaction'] == 2) {
            $queryDelete = "
                DELETE FROM reaction_proposition
                WHERE id_proposition = ? AND id_internaute = ? AND id_groupe = ?
            ";
            $this->api->delete([$this->idProposition, $idInternaute, $this->idGroupe], null, $queryDelete);
        } else {
            $queryInsert = "
                INSERT INTO reaction_proposition (id_proposition, id_internaute, id_groupe, id_reaction)
                VALUES (?, ?, ?, 2)
            ";
            $this->api->post([$this->idProposition, $idInternaute, $this->idGroupe], null, $queryInsert);
        }
    }

    public function toggleVoteRequest(int $idInternaute): void {
        $queryCheck = "
            SELECT id_proposition
            FROM demande_vote
            WHERE id_proposition = ? AND id_internaute = ? AND id_groupe = ?
        ";
        $this->api->get([$this->idProposition, $idInternaute, $this->idGroupe], null, $queryCheck);
        $result = $this->api->getValeurRetourne();

        if ($result && isset($result[0]['id_proposition'])) {
            $queryDelete = "
                DELETE FROM demande_vote
                WHERE id_proposition = ? AND id_internaute = ? AND id_groupe = ?
            ";
            $this->api->delete([$this->idProposition, $idInternaute, $this->idGroupe], null, $queryDelete);
        } else {
            $queryInsert = "
                INSERT INTO demande_vote (id_proposition, id_internaute, id_groupe)
                VALUES (?, ?, ?)
            ";
            $this->api->post([$this->idProposition, $idInternaute, $this->idGroupe], null, $queryInsert);
        }
    }

    public function checkIfUserLiked(int $idInternaute): bool {
        $query = "
            SELECT count(*) AS count
            FROM reaction_proposition
            WHERE id_proposition = ? AND id_internaute = ? AND id_groupe = ? AND id_reaction = 1
        ";
    
        // Exécuter la requête et récupérer le résultat
        $this->api->get([$this->idProposition, $idInternaute, $this->idGroupe], null, $query);
        $result = $this->api->getValeurRetourne();
        return reset($result)['count'] > 0;
    }

    public function checkIfUserDisliked(int $idInternaute): bool {
        $query = "
            SELECT count(*) AS count
            FROM reaction_proposition
            WHERE id_proposition = ? AND id_internaute = ? AND id_groupe = ? AND id_reaction = 2
        ";
    
        // Exécuter la requête et récupérer le résultat
        $this->api->get([$this->idProposition, $idInternaute, $this->idGroupe], null, $query);
        $result = $this->api->getValeurRetourne();
        return reset($result)['count'] > 0;
    }

    public function checkIfUserVoted(int $idInternaute): bool {
        $query = "
            SELECT count(*) AS count
            FROM demande_vote
            WHERE id_proposition = ? AND id_internaute = ? AND id_groupe = ?
        ";
    
        // Exécuter la requête et récupérer le résultat
        $this->api->get([$this->idProposition, $idInternaute, $this->idGroupe], null, $query);
        $result = $this->api->getValeurRetourne();
        return reset($result)['count'] > 0;
    } 

    public function signalerProposition(int $idInternaute, string $contenuMessage): void {
        $queryUpdate = "UPDATE proposition SET nb_signalement = nb_signalement + 1 WHERE id_proposition = ?;";
        $this->api->patch([$this->idProposition], null, $queryUpdate);
    }

    public function ajouterCommentaire(int $idInternaute, $commentaire): void {
        $queryInsert = "
            INSERT INTO commentaire (id_proposition, id_internaute, id_groupe, contenu_message, horodatage)
            VALUES (?, ?, ?, ?, NOW())
        ";
        $this->api->post([$this->idProposition, $idInternaute, $this->idGroupe, $commentaire], null, $queryInsert);
    }
    
    
    public function getCommentaires(): array {
        try {
            $query = "
                SELECT c.id_commentaire, c.contenu_message, c.horodatage, c.nb_signalement, i.nom_internaute, i.id_internaute
                FROM commentaire c
                INNER JOIN internaute i ON c.id_internaute = i.id_internaute
                WHERE c.id_proposition = ?
                ORDER BY c.horodatage ASC
            ";
            $this->api->get([$this->idProposition], null, $query);
            
            $result = $this->api->getValeurRetourne();
            
            // Validation explicite du type
            if (is_array($result)) {
                return $result;
            }
            return []; // Retourne un tableau vide si le résultat n'est pas un tableau
        } catch (Exception $e) {
            return []; // Retourne un tableau vide en cas d'exception
        }
    }
    

    public function checkIfVoteFinished(): bool {
        $query = "
            SELECT count(*) AS count FROM vote WHERE id_proposition = ? AND date_fin_vote < NOW()
        ";
    
        $this->api->get([$this->idProposition], null, $query);
        $result = $this->api->getValeurRetourne();
        return $result[0]['count'] > 0;
    }

    public function checkIfVoteInProgress(): bool {
        $query = "
            SELECT count(*) AS count
            FROM proposition
            WHERE id_proposition = ? AND date_fin_discuss < NOW()
        ";
    
        $this->api->get([$this->idProposition], null, $query);
        $result = $this->api->getValeurRetourne();
        return reset($result)['count'] > 0;
    }

    public function getVotesProposition(): array {
        $query = "
            SELECT *
            FROM vote v
            INNER JOIN proposition p ON v.id_proposition = p.id_proposition
            INNER JOIN type_scrutin ts ON v.id_scrutin = ts.id_scrutin
            LEFT JOIN choix c ON c.id_vote = v.id_vote
            LEFT JOIN vote_membre vm ON vm.id_vote = v.id_vote
            LEFT JOIN internaute i ON vm.id_internaute = i.id_internaute
            WHERE p.id_proposition = ?
        ";
        $this->api->get([$this->idProposition], null, $query);
        $result = $this->api->getValeurRetourne();
        return $result;
    }

    public function getChoices(): array {
        try {
            $query = "SELECT * 
                      FROM vote
                      NATURAL JOIN type_scrutin
                      NATURAL JOIN choix
                      WHERE id_proposition = ?";
            $this->api->get([$this->idProposition], null, $query);
            $result = $this->api->getValeurRetourne();
    
            if (empty($result)) {
                return [];
            } else {
                return $result;
            }
        } catch (Exception $e) {
            return [];
        }
    }

    public function getVerifVote(int $idInternaute): bool {
        try {
            $query = "SELECT COUNT(*) AS count
                      FROM vote
                      NATURAL JOIN vote_membre
                      WHERE id_proposition = ? AND id_internaute = ?";
            
            // Exécuter la requête
            $this->api->get([$this->idProposition, $idInternaute], null, $query);
            $result = $this->api->getValeurRetourne();
    
            // Vérifier et retourner le résultat
            if (is_array($result) && isset($result[0]['count'])) {
                return (int)$result[0]['count'] > 0;
            }
    
            return false;
        } catch (Exception $e) {
            // Journaliser l'erreur pour le débogage
            error_log("Erreur dans getVerifVote : " . $e->getMessage());
            return false; // Retourne false en cas d'erreur
        }
    }
    

    public function vote(int $idInternaute, int $idChoix): void {
        try {
            $query = "SELECT id_vote FROM vote WHERE id_proposition = ?";
            $this->api->get([$this->idProposition], null, $query);
            $result = $this->api->getValeurRetourne();
    
            if (!is_array($result) || empty($result[0]['id_vote'])) {
                throw new Exception("Aucun id_vote trouvé pour la proposition.");
            }
            $idVote = $result[0]['id_vote'];
    
            $query = "INSERT INTO vote_membre (id_vote, id_choix, id_groupe, id_internaute)
                      VALUES (?, ?, ?, ?)";
            $this->api->post([$idVote, $idChoix, $this->idGroupe, $idInternaute], null, $query);
    
        } catch (Exception $e) {
            error_log("Erreur lors du vote : " . $e->getMessage());
            throw $e;
        }
    }

    public function Desideur($idInternaute): bool {
        $query = "SELECT id_internaute
                FROM proposition
                NATURAL JOIN infos_membre
                NATURAL JOIN role
                WHERE id_proposition = ? AND nom_role = ?";
        $this->api->get([$this->idProposition, "Décideur"], null, $query);
        $result = $this->api->getValeurRetourne();
        if ($result==0) {
            return false;
        }
        if ($result[0]["id_internaute"] == $idInternaute){
            return true;
        }
        return false;
    }

    public function getTypeScrutin(): array {
        try {
            $query = "SELECT * FROM type_scrutin";
            $this->api->get([], null, $query);
            $result = $this->api->getValeurRetourne();
    
            return is_array($result) ? $result : []; // Vérifie si le résultat est un tableau
        } catch (Exception $e) {
            // Gestion des erreurs
            error_log("Erreur lors de la récupération des types de scrutin : " . $e->getMessage());
            return []; // Retourne un tableau vide en cas d'erreur
        }
    }

    public function organiserVote($date_fin_vote, int $id_scrutin, array $choixs): bool {
        try {
            // Convertir $date_fin_vote en objet DateTime
            $date_fin_vote_obj = new DateTime($date_fin_vote);
            $date_fin_vote_formatted = $date_fin_vote_obj->format('Y-m-d H:i:s');
    
            // Vérifier que les choix ne sont pas vides
            $choixs = array_filter($choixs, fn($choix) => !empty(trim($choix)));
            if (count($choixs) < 2) {
                throw new Exception("Vous devez fournir au moins deux choix valides.");
            }
            
            // Suppression des votes existants pour la proposition
            $query = "DELETE FROM vote WHERE id_proposition = ?";
            $this->api->delete([$this->idProposition], null, $query);
    
            // Insertion du nouveau vote
            $queryInsertVote = "INSERT INTO vote (date_fin_vote, id_proposition, id_scrutin) VALUES (?, ?, ?)";
            $this->api->post([$date_fin_vote_formatted, $this->idProposition, $id_scrutin], null, $queryInsertVote);
    
            // Récupérer l'ID du vote inséré
            $queryGetVoteId = "SELECT id_vote FROM vote WHERE id_proposition = ?";
            $this->api->get([$this->idProposition], null, $queryGetVoteId);
            $voteIdResult = $this->api->getValeurRetourne();
    
    
            // Récupération du dernier ID inséré
            $idVote = $voteIdResult[0]['id_vote'];

            // Mettre `date_fin_discuss` à NOW() - 1 jour dans la table `proposition`
            $queryEndDiscussion = "UPDATE proposition SET date_fin_discuss = DATE_SUB(NOW(), INTERVAL 1 DAY) WHERE id_proposition = ?";
            $this->api->patch([$this->idProposition], null, $queryEndDiscussion);


            $query = "DELETE FROM choix WHERE id_vote = ?";
            $this->api->delete([$this->idProposition], null, $query);

            $queryInsertChoix = "INSERT INTO choix (id_vote, id_choix, libelle_choix) VALUES (?, ?, ?)";
            $i = 1; // Initialisation de l'index pour id_choix
            foreach ($choixs as $choix) {
                $this->api->post([$idVote, $i, trim($choix)], null, $queryInsertChoix);
                $i++; // Incrémentation de l'index après chaque insertion
            }
            

            $query = "SELECT * FROM choix  WHERE id_vote = ?";
            $this->api->get([$idVote], null, $query);
            $result = $this->api->getValeurRetourne();;

            return true; // Succès
        } catch (Exception $e) {
            // En cas d'erreur, afficher un message et retourner false
            error_log("Erreur dans organiserVote: " . $e->getMessage());
            echo "Erreur : " . $e->getMessage() . "<br>";
            return false;
        }
    }

    public function signalerCommentaire($idCommentaire, $contenu_message, $idInternaute) {
        $queryUpdate = "UPDATE commentaire SET nb_signalement = nb_signalement + 1 WHERE id_commentaire = ?;";
        $this->api->patch([$idCommentaire], null, $queryUpdate);
    }
    public function getCommentaire($idCommentaire) {
        $query = "SELECT * FROM commentaire WHERE id_commentaire = ?";
        $this->api->get([$idCommentaire], null, $query);
        return $this->api->getValeurRetourne();
    }

}
