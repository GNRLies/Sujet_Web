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

    function  insertPanier($jeux_id,$user_id){
        $queryBuilder = new QueryBuilder($this->db);
        $prix = (float) $queryBuilder->select('prix')->from('jeux')->where('id=:jeux_id')
            ->setParameter('jeux_id', $jeux_id)->execute()->fetchColumn(0);
        $queryBuilder->insert('paniers')
            ->values([
                'quantite' => '1',
                'prix' =>':prix',
                'user_id' => ':user_id',
                'jeux_id' => ':jeux_id',
            ])
            ->setParameter('prix', $prix)
            ->setParameter('user_id', $user_id)
            ->setParameter('jeux_id', $jeux_id)
        ;
        return $queryBuilder->execute();
    }

    public function deletePanier($jeux_id, $user_id){
        $queryBuilder = new QueryBuilder($this->db);
        $queryBuilder
            ->delete('paniers')
            ->where('user_id =:user_id')
            ->andWhere('jeux_id=:jeux_id')
            ->setParameter('user_id',$user_id)
            ->setParameter('jeux_id',$jeux_id)
        ;
        return $queryBuilder->execute();
    }


    function countNbJeuxLigne($jeux_id,$user_id){
        $queryBuilder = new QueryBuilder($this->db);
        $queryBuilder
            ->select('quantite')->from('paniers')
            ->where('jeux_id= :jeux_id')
            ->andWhere('user_id = :idUser')
            ->andWhere('commande_id is Null')
            ->setParameter('jeux_id',$jeux_id)->setParameter('idUser',$user_id);
        return $queryBuilder->execute()->fetchColumn(0);
    }

    public function calculprix($user_id) {
        $queryBuilder = new QueryBuilder($this->db);
        $queryBuilder
            ->select('SUM(prix*quantite) AS prix')
            ->from('Paniers')
            ->where('user_id = :user_id')
            ->setParameter('user_id', $user_id);
        return $queryBuilder->execute()->fetchAll();

    }

    public function updateJeuxLigneAdd($jeux_id, $user_id){
        $queryBuilder = new QueryBuilder($this->db);
        $prix = (float) $queryBuilder->select('prix')->from('jeux')->where('id=:jeux_id')
            ->setParameter('jeux_id', $jeux_id)->execute()->fetchColumn(0);
        $queryBuilder ->update('paniers')
            ->set('quantite','quantite+1')->set('prix',':prix')
            ->where('jeux_id = :jeux_id')->andWhere('user_id = :user_id')
            ->andWhere('commande_id is Null')
            ->setParameter('prix',$prix)->setParameter('jeux_id',$jeux_id)
            ->setParameter('user_id',$user_id);
        return $queryBuilder->execute();
    }

    public function updateJeuxLigneDel($jeux_id, $user_id){
        $queryBuilder = new QueryBuilder($this->db);
        $prix = (float) $queryBuilder->select('prix')->from('jeux')->where('id=:jeux_id')
            ->setParameter('jeux_id', $jeux_id)->execute()->fetchColumn(0);
        $queryBuilder ->update('paniers')
            ->set('quantite','quantite-1')->set('prix',':prix')
            ->where('jeux_id = :jeux_id')->andWhere('user_id = :user_id')
            ->andWhere('commande_id is Null')
            ->setParameter('prix',$prix)
            ->setParameter('jeux_id',$jeux_id)
            ->setParameter('user_id',$user_id);
        return $queryBuilder->execute();
    }

    public function deleteAllPanier($user_id)
    {
        $queryBuilder = new QueryBuilder($this->db);
        $queryBuilder
            ->delete('paniers')
            ->where('user_id =:user_id')
            ->setParameter('user_id',$user_id)
        ;
        return $queryBuilder->execute();
    }

    public function validerCommande($user_id,$prix)
    {
        $queryBuilder = new QueryBuilder($this->db);
        $queryBuilder->insert('commandes')
            ->values([
                'user_id' => ':user_id',
                'prix' =>':prix',
                'etat_id' => ':etat_id',
            ])
            ->setParameter('user_id', $user_id)
            ->setParameter('prix', $prix)
            ->setParameter('etat_id', 1)
        ;
        return $queryBuilder->execute();
    }


}