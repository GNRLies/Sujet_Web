<?php
namespace App\Model;

use Doctrine\DBAL\Query\QueryBuilder;
use Silex\Application;

class UserModel {

	private $db;

	public function __construct(Application $app) {
		$this->db = $app['db'];
	}
	public function getUsers($id){
		$queryBuilder = new QueryBuilder($this->db);
		$queryBuilder
			->select('id','email','password','login','nom','code_postal','ville','adresse')
			->from('users')
			->where('id=:id')
			->setParameter('id',$id);
		return $queryBuilder->execute()->fetch();
	}

	public function verif_login_mdp_Utilisateur($login,$mdp){
		$sql = "SELECT id,login,password,droit FROM users WHERE login = ? AND password = ?";
		$res=$this->db->executeQuery($sql,[$login,$mdp]);   //md5($mdp);
		if($res->rowCount()==1)
			return $res->fetch();
		else
			return false;
	}
	public function updateClient($donnees,$id) {
	$queryBuilder = new QueryBuilder($this->db);
	$queryBuilder
		->update('users')
		->set('email', '?')
		->set('password','?')
		->set('login','?')
		->set('nom','?')
		->set('code_postal','?')
		->set('ville','?')
		->set('adresse','?')
		->where('id= ?')
		->setParameter(0, $donnees['email'])
		->setParameter(1, $donnees['password'])
		->setParameter(2, $donnees['login'])
		->setParameter(3, $donnees['nom'])
		->setParameter(4, $donnees['code_postal'])
		->setParameter(5, $donnees['ville'])
		->setParameter(6, $donnees['adresse'])
		->setParameter(7, $id);
	return $queryBuilder->execute();
	}
	public function insertClient($donnees) {
		$queryBuilder = new QueryBuilder($this->db);
		$queryBuilder->insert('users')
			->values([
				'email' => '?',
				'password' => '?',
				'login' => '?',
				'nom' => '?',
				'code_postal' => '?',
				'ville' => '?',
				'adresse' => '?',
				'droit' => '?'

			])
			->setParameter(0, $donnees['email'])
			->setParameter(1, $donnees['password'])
			->setParameter(2, $donnees['login'])
			->setParameter(3, $donnees['nom'])
			->setParameter(4, $donnees['code_postal'])
			->setParameter(5, $donnees['ville'])
			->setParameter(6, $donnees['adresse'])
			->setParameter(7,"DROITclient");
		return $queryBuilder->execute();
	}
}