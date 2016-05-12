<?php

namespace App\Model;

use Doctrine\DBAL\Query\QueryBuilder;
use Silex\Application;

class JeuxModel {

    private $db;

    public function __construct(Application $app) {
        $this->db = $app['db'];
    }
    public function getAllJeux() {
        $queryBuilder = new QueryBuilder($this->db);
        $queryBuilder
            ->select('j.id', 'j.typeJeux_id', 'j.nom', 'j.prix', 'j.photo', 'j.plateforme', 'j.dispo', 'j.stock', 't.libelle')
            ->from('Jeux', 'j')
            ->innerJoin('j', 'typeJeux', 't', 'j.typeJeux_id=t.id')
            ->addOrderBy('j.nom', 'ASC');
        return $queryBuilder->execute()->fetchAll();

    }

    public function insertJeux($donnees) {
        $queryBuilder = new QueryBuilder($this->db);
        $queryBuilder->insert('Jeux')
            ->values([
                'nom' => '?',
                'typeJeux_id' => '?',
                'prix' => '?',
                'photo' => '?',
                'plateforme' => '?',
                'dispo' => '?',
                'stock' => '?'
            ])
            ->setParameter(0, $donnees['nom'])
            ->setParameter(1, $donnees['typeJeux_id'])
            ->setParameter(2, $donnees['prix'])
            ->setParameter(3, $donnees['photo'])
            ->setParameter(4, $donnees['plateforme'])
            ->setParameter(5, $donnees['dispo'])
            ->setParameter(6, $donnees['stock']
            )
        ;
        return $queryBuilder->execute();
    }

    function getJeux($id) {
        $queryBuilder = new QueryBuilder($this->db);
        $queryBuilder
            ->select('id', 'typeJeux_id', 'nom', 'prix', 'photo','dispo','plateforme','dispo','stock')
            ->from('Jeux')
            ->where('id= :id')
            ->setParameter('id', $id);
        return $queryBuilder->execute()->fetch();
    }

    public function updateJeux($donnees) {
        $queryBuilder = new QueryBuilder($this->db);
        $queryBuilder
            ->update('Jeux')
            ->set('nom', '?')
            ->set('typeJeux_id','?')
            ->set('prix','?')
            ->set('photo','?')
            ->set('plateforme','?')
            ->set('dispo','?')
            ->set('stock','?')
            ->where('id= ?')
            ->setParameter(0, $donnees['nom'])
            ->setParameter(1, $donnees['typeJeux_id'])
            ->setParameter(2, $donnees['prix'])
            ->setParameter(3, $donnees['photo'])
            ->setParameter(2, $donnees['plateforme'])
            ->setParameter(3, $donnees['dispo'])
            ->setParameter(3, $donnees['stock'])
            ->setParameter(4, $donnees['id']);
        return $queryBuilder->execute();
    }

    public function deleteJeux($id) {
        $queryBuilder = new QueryBuilder($this->db);
        $queryBuilder
            ->delete('Jeux')
            ->where('id = :id')
            ->setParameter('id',(int)$id)
        ;
        return $queryBuilder->execute();
    }



}