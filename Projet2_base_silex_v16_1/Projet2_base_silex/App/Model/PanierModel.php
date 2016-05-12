<?php

namespace App\Model;

use Doctrine\DBAL\Query\QueryBuilder;
use Silex\Application;

class PanierModel {

    private $db;
    private $panierModel;
    private $jeuxModel;

    public function __construct(Application $app) {
        $this->db = $app['db'];
    }
    // http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/query-builder.html#join-clauses
    public function getAllPanier($data) {
        $queryBuilder = new QueryBuilder($this->db);
        $queryBuilder
            ->select('p.id', 'p.quantite', 'p.prix', 'p.dateAjoutPanier', 'p.user_id', 'p.jeux_id', 'p.commande_id', 'j.nom')
            ->from('Paniers', 'p')
            ->where('p.user_id = :user_id')
            ->innerJoin('p', 'users', 'u', 'p.user_id=u.id')
            ->innerJoin('p', 'jeux', 'j', 'p.jeux_id=j.id')
            //->innerJoin('p', 'commandes', 'c', 'p.commande_id=c.id')
            ->addOrderBy('p.id', 'ASC')
            ->setParameter('user_id', $data);
        return $queryBuilder->execute()->fetchAll();

    }

    public function add($app, $req) {
        $panierModel = new PanierModel($app);
        $jeuxModel = new JeuxModel($app);
        $jeux_id = $app->escape($req->get('id'));
        $user_id = $app['session']->get('user_id');
    }



//    function countNbProduitLigne($produit_id,$user_id){
//        $queryBuilder = new QueryBuilder($this->db);
//        $queryBuilder
//            ->select('count(produit_id)')->from('panier')
//            ->where('produit_id= :idProduit')
//            ->andWhere('user_id = :idUser')
//            ->andWhere('commande_id is Null')
//            ->setParameter('idProduit',$produit_id)->setParameter('idUser',$user_id);
//        return $queryBuilder->execute()->
//}




}