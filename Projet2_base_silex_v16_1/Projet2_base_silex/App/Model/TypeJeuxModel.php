<?php

namespace App\Model;

use Doctrine\DBAL\Query\QueryBuilder;
use Silex\Application;

class TypeJeuxModel {

    private $db;

    public function __construct(Application $app) {
        $this->db = $app['db'];
    }


    public function getAllTypeJeux() {
        $queryBuilder = new QueryBuilder($this->db);
        $queryBuilder
            ->select('t.id', 't.libelle')
            ->from('typeJeux', 't')
            ->addOrderBy('t.libelle', 'ASC');
        return $queryBuilder->execute()->fetchAll();
    }
}