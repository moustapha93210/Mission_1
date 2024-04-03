<?php
/**
 * Classe d'accès aux données.

 * Utilise les services de la classe PDO
 * pour l'application GSB
 * Les attributs sont tous statiques,
 * les 4 premiers pour la connexion
 * $monPdo de type PDO
 * $monPdoGsb qui contiendra l'unique instance de la classe

 * @package default
 * @author Cheri Bibi
 * @version    1.0
 * @link       http://www.php.net/manual/fr/book.pdo.php
 */

class PdoGsb{
      	private static $serveur='mysql:host=localhost';
      	private static $bdd='dbname=gsbfrais';
      	private static $user='root' ;
      	private static $mdp='' ;
		private static $monPdo;
		private static $monPdoGsb=null;
/**
 * Constructeur privé, crée l'instance de PDO qui sera sollicitée
 * pour toutes les méthodes de la classe
 */
	private function __construct(){
    	PdoGsb::$monPdo = new PDO(PdoGsb::$serveur.';'.PdoGsb::$bdd, PdoGsb::$user, PdoGsb::$mdp);
		PdoGsb::$monPdo->query("SET CHARACTER SET utf8");
	}
	public function _destruct(){
		PdoGsb::$monPdo = null;
	}

    /**
     * Fonction statique qui crée l'unique instance de la classe
     * Appel : $instancePdoGsb = PdoGsb::getPdoGsb();
     * @return null L'unique objet de la classe PdoGsb
     */
	public  static function getPdoGsb(){
		if(PdoGsb::$monPdoGsb==null){
			PdoGsb::$monPdoGsb= new PdoGsb();
		}
		return PdoGsb::$monPdoGsb;
	}

    /**
     * Retourne les informations d'un visiteur
     * @param $login
     * @param $mdp
     * @return mixed L'id, le nom et le prénom sous la forme d'un tableau associatif
     */
    public function getInfosVisiteur($login, $mdp){
        $req = "select id, nom, prenom, derniereDateConnexion from visiteur where login='$login' and mdp='$mdp'";
        $rs = PdoGsb::$monPdo->query($req);
        $ligne = $rs->fetch();
        return $ligne;
    }

    /**
     * Transforme une date au format français jj/mm/aaaa vers le format anglais aaaa-mm-jj
     
    * @param $madate au format  jj/mm/aaaa
    * @return la date au format anglais aaaa-mm-jj
    */
    public function dateAnglaisVersFrancais($maDate){
        @list($annee,$mois,$jour)=explode('-',$maDate);
        $date="$jour"."/".$mois."/".$annee;
        return $date;
    }

    /**
     * Retourne sous forme d'un tableau associatif toutes les lignes de frais hors forfait
     * concernées par les deux arguments
     * La boucle foreach ne peut être utilisée ici, car on procède
     * à une modification de la structure itérée - transformation du champ date-
     * @param $idVisiteur
     * @param $mois 'sous la forme aaaamm
     * @return array 'Tous les champs des lignes de frais hors forfait sous la forme d'un tableau associatif
     */
    public function getLesFraisHorsForfait($idVisiteur,$mois){
        $req = "select * from lignefraishorsforfait where idvisiteur ='$idVisiteur' 
		and mois = '$mois' ";
        $res = PdoGsb::$monPdo->query($req);
        $lesLignes = $res->fetchAll();
        $nbLignes = count($lesLignes);
        for ($i=0; $i<$nbLignes; $i++){
            $date = $lesLignes[$i]['date'];
            //Gestion des dates
            @list($annee,$mois,$jour) = explode('-',$date);
            $dateStr = "$jour"."/".$mois."/".$annee;
            $lesLignes[$i]['date'] = $dateStr;
        }
        return $lesLignes;
    }

    public function updateDateConnexion($date, $id)
    {
        $sql = "UPDATE `visiteur`
        SET `derniereDateConnexion` = ?
        WHERE `visiteur`.`id` = ? ";

        $stmt = PdoGsb::$monPdo->prepare($sql);

        $stmt->bindValue(1, $date, PDO::PARAM_STR);
        $stmt->bindValue(2, $id, PDO::PARAM_STR);

        $stmt->execute();
        //var_dump($stmt);;


    }


    /**
     * Retourne les mois pour lesquels, un visiteur a une fiche de frais
     * @param $idVisiteur
     * @return array 'Un tableau associatif de clé un mois - aaaamm - et de valeurs l'année et le mois correspondant
     */
    public function getLesMoisDisponibles($idVisiteur){
        $req = "select mois from  fichefrais where idvisiteur ='$idVisiteur' order by mois desc ";
        $res = PdoGsb::$monPdo->query($req);
        $lesMois =array();
        $laLigne = $res->fetch();
        while($laLigne != null)	{
            $mois = $laLigne['mois'];
            $numAnnee =substr( $mois,0,4);
            $numMois =substr( $mois,4,2);
            $lesMois["$mois"]=array(
                "mois"=>"$mois",
                "numAnnee"  => "$numAnnee",
                "numMois"  => "$numMois"
            );
            $laLigne = $res->fetch();
        }
        return $lesMois;
    }

    public function getTypeDeFrais(){
        $req = "SELECT id FROM fraisforfait";
        $res = PdoGsb::$monPdo->query($req);
        $laLigne = $res->fetchAll();
        return $laLigne;
    }

    public function getLesCumulesEtatFrais($idVisiteur, $moisFicheFrais, $idFraisForfait){
        /*echo " 3 Variables : ". $idVisiteur . $moisFicheFrais . $idFraisForfait;*/
        $req = "SELECT ff.idVisiteur, v.nom, v.prenom, (lff.quantite * fraf.montant) AS MontantTotalCumulés, lff.idFraisForfait
        FROM visiteur v
        INNER JOIN fichefrais ff ON ff.idVisiteur = v.id
        INNER JOIN lignefraisforfait lff ON lff.idVisiteur = v.id and lff.mois = ff.mois
        INNER JOIN fraisforfait fraf ON fraf.id = lff.idFraisForfait
        WHERE ff.idVisiteur = '$idVisiteur' AND ff.mois = '$moisFicheFrais' AND lff.idFraisForfait = '$idFraisForfait'";
        /*echo " Req : ". $req;*/
        $res = PdoGsb::$monPdo->query($req);
        /*echo " Bagarre6 ".count($$req);*/
        $laLigne = $res->fetchAll();
        /*echo " Bagarre ".count($laLigne);*/
        return $laLigne;
    }

    /**
     * Retourne les informations d'une fiche de frais d'un visiteur pour un mois donn�
     * @param $idVisiteur
     * @param $mois 'sous la forme aaaamm
     * @return mixed 'Un tableau avec des champs de jointure entre une fiche de frais et la ligne d'�tat
     */
    public function getLesInfosFicheFrais($idVisiteur,$mois){
        $req = "select fichefrais.idEtat as idEtat, fichefrais.dateModif as dateModif, fichefrais.nbJustificatifs as nbJustificatifs, 
			fichefrais.montantValide as montantValide, etat.libelle as libEtat from  fichefrais inner join etat on fichefrais.idEtat = etat.id 
			where fichefrais.idVisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
        $res = PdoGsb::$monPdo->query($req);
        $laLigne = $res->fetch();
        return $laLigne;
    }

    public function getIdvisiteur(){
        $req = "SELECT id FROM visiteur";
        $res = PdoGsb::$monPdo->query($req);
        $laLigne = $res->fetchAll();
        return $laLigne;
    }

    public function getLesCumulesTypeId($idVisiteur, $idFraisForfait){
        /*echo " 3 Variables : ". $idVisiteur . $moisFicheFrais . $idFraisForfait;*/
        $req = "SELECT ff.idVisiteur, lff.mois, lff.idFraisForfait, (lff.quantite * fraf.montant) AS MontantTotalCumulés
        FROM visiteur v
        INNER JOIN fichefrais ff ON ff.idVisiteur = v.id
        INNER JOIN lignefraisforfait lff ON lff.idVisiteur = v.id and lff.mois = ff.mois
        INNER JOIN fraisforfait fraf ON fraf.id = lff.idFraisForfait
        WHERE ff.idVisiteur = '$idVisiteur' AND lff.idFraisForfait = '$idFraisForfait'";
        /*echo " Req : ". $req;*/
        $res = PdoGsb::$monPdo->query($req);
        /*echo " Bagarre6 ".count($$req);*/
        $laLigne = $res->fetchAll();
        /*echo " Bagarre ".count($laLigne);*/
        return $laLigne;
    }

    public function getLesMoisLibelle($idVisiteur, $moisLibelle){
        /*echo " 3 Variables : ". $idVisiteur . $moisFicheFrais . $idFraisForfait;*/
        $req = "SELECT lff.idVisiteur, lff.mois, 
        SUM((CASE WHEN lff.idFraisForfait = 'ETP' THEN (lff.quantite * fraf.montant) END)) AS ETP,
        SUM((CASE WHEN lff.idFraisForfait = 'KM' THEN (lff.quantite * fraf.montant) END)) AS KM,
        SUM((CASE WHEN lff.idFraisForfait = 'NUI' THEN (lff.quantite * fraf.montant) END)) AS NUI,
        SUM((CASE WHEN lff.idFraisForfait = 'REP' THEN (lff.quantite * fraf.montant) END)) AS REP
        FROM lignefraisforfait lff
        INNER JOIN fraisforfait fraf ON lff.idFraisForfait = fraf.id
        WHERE lff.mois = '$idVisiteur'
        GROUP BY lff.idVisiteur";
        /*echo " Req : ". $req;*/
        $res = PdoGsb::$monPdo->query($req);
        /*echo " Bagarre6 ".count($$req);*/
        $laLigne = $res->fetchAll();
        /*echo " Bagarre ".count($laLigne);*/
        return $laLigne;
    }

    public function getLesLibelleId($idVisiteurLibelle){
        /*echo " 3 Variables : ". $idVisiteur . $moisFicheFrais . $idFraisForfait;*/
        $req = "SELECT lff.idVisiteur, fraf.libelle, SUM(lff.quantite * fraf.montant) AS MontantTotalCumulés
        FROM lignefraisforfait lff
        INNER JOIN fraisforfait fraf ON lff.idFraisForfait = fraf.id
        WHERE lff.idVisiteur = '$idVisiteurLibelle'
        GROUP BY lff.idVisiteur = '$idVisiteurLibelle', fraf.libelle";
        /*echo " Req : ". $req;*/
        $res = PdoGsb::$monPdo->query($req);
        /*echo " Bagarre6 ".count($$req);*/
        $laLigne = $res->fetchAll();
        /*echo " Bagarre ".count($laLigne);*/
        return $laLigne;
    }

    public function getLffId(){

        $req = "SELECT id, nom, prenom FROM visiteur";
        $res = PdoGsb::$monPdo->query($req);
        $laLigne = $res->fetchAll();
        return $laLigne;
    }

    public function getLesMoisSansDoublons2($idVisiteur){
        $req = "SELECT DISTINCT mois 
        FROM  fichefrais 
        WHERE idvisiteur ='$idVisiteur'
        ORDER BY mois";
        $res = PdoGsb::$monPdo->query($req);
        $lesMois =array();
        $laLigne = $res->fetch();
        while($laLigne != null)	{
            $mois = $laLigne['mois'];
            $numAnnee =substr( $mois,0,4);
            $numMois =substr( $mois,4,2);
            $lesMois["$mois"]=array(
                "mois"=>"$mois",
                "numAnnee"  => "$numAnnee",
                "numMois"  => "$numMois"
            );
            $laLigne = $res->fetch();
        }
        return $lesMois;
    }

    public function insertFicheFrais($idVisiteur, $mois){
        $req = "INSERT INTO `fichefrais`(`idVisiteur`, `mois`)
        VALUES (?, ?)";
        var_dump($req);

        try
        {
            $stmt = PdoGsb::$monPdo->prepare($req);
            $count = $stmt->execute([$idVisiteur, $mois]);
            
            if ($count === false)
            {
                $erreur = "Erreur lors de l'insertion des données dans la base de données.";
                echo $erreur;
                return false;
            }
            else
            {
                return true;
            }
        }
        catch (PDOException $e)
        {
            $erreur = "Une erreur de base de données s'est produite : " . $e->getMessage();
            echo $erreur;
            return false;
        }

    }


    public function insertLff($idVisiteur, $mois, $idFraisForfait, $quantite){

        $req = "INSERT INTO `lignefraisforfait` (`idVisiteur`, `mois`, `idFraisForfait`, `quantite`)
                VALUES (?, ?, ?, ?)";

        var_dump($req);

        $stmt = PdoGsb::$monPdo->prepare($req);

        $stmt->bindValue(1, $idVisiteur);
        $stmt->bindValue(2, $mois);
        $stmt->bindValue(3, $idFraisForfait);
        $stmt->bindValue(4, $quantite);

        $stmt->execute([$idVisiteur, $mois, $idFraisForfait, $quantite]);


        /*try
        {
            $stmt = PdoGsb::$monPdo->prepare($req);
            $count = $stmt->execute([$idVisiteur, $mois, $idFraisForfait, $quantite]);

            if ($count === false)
            {
                $erreur = "Erreur lors de l'insertion des données dans la base de données.";
                echo $erreur;
                return false;
            }
            else
            {
                return true;
            }
        }
        catch (PDOException $e)
        {
            $erreur = "Une erreur de base de données s'est produite : " . $e->getMessage();
            echo $erreur;
            return false;
        }*/

        
    

    }

    public function getIdvisiteurMoisFicheFrais($idVisiteur, $mois){
        $req = "SELECT idVisiteur, mois
                FROM fichefrais
                WHERE idVisiteur = ? AND mois = ? ";
        /*var_dump($req);*/
        try
        {
            $stmt = PdoGsb::$monPdo->prepare($req);
            $count = $stmt->execute([$idVisiteur, $mois]);
            

            if ($count === true)
            {
                return true;
            }
            else
            {
                $erreur = "Erreur lors de la sélection des données dans la base de données.";
                echo $erreur;
                return false;
            }
        }
        catch (PDOException $e)
        {
            $erreur = "Une erreur de base de données s'est produite : " . $e->getMessage();
            echo $erreur;
            return false;
        }

    }

    public function selectionnerNouvelleDonnee($idVisiteur, $mois)
    {
        $req="SELECT *
            FROM lignefraisforfait
            WHERE idVisiteur='$idVisiteur' AND mois='$mois' ";

        $res = PdoGsb::$monPdo->query($req);
        $laLigne = $res->fetchAll();
        return $laLigne;
    }

        /*
        $stmt = PdoGsb::$monPdo->prepare($req);

        $laLigne = $res->fetch();
        
        return $laLigne;
    }*/



}

