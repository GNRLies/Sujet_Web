<?php

namespace App\Model;

use Doctrine\DBAL\Query\QueryBuilder;
use Silex\Application;

class PanierModel {

    private $db;

    public function __construct(Application $app) {
        $this->db = $app['db'];
    }
    // http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/query-builder.html#join-clauses
    public function getAllPanier() {
//        $sql = "SELECT p.id, t.libelle, p.nom, p.prix, p.photo
//            FROM produits as p,typeProduits as t
//            WHERE p.typeProduit_id=t.id ORDER BY p.nom;";
//        $req = $this->db->query($sql);
//        return $req->fetchAll();
        $queryBuilder = new QueryBuilder($this->db);
        $queryBuilder
            ->select('p.id', 'p.quantite', 'p.prix', 'p.dateAjoutPanier', 'p.user_id', 'p.jeux_id', 'p.commande_id')
            ->from('Paniers', 'p')
            ->innerJoin('p', 'users', 'u', 'p.user_id=u.id')
            ->innerJoin('p', 'jeux', 'j', 'p.jeux_id=j.id')
            ->innerJoin('p', 'commandes', 'c', 'p.commande_id=c.id')
            ->addOrderBy('p.id', 'ASC');
        return $queryBuilder->execute()->fetchAll();

    }


}