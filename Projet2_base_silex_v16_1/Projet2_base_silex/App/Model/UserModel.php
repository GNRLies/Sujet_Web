<?php
namespace App\Model;

use Silex\Application;

class UserModel {

	private $db;

	public function __construct(Application $app) {
		$this->db = $app['db'];
	}

	public function verif_login_mdp_Utilisateur($login,$mdp){
		$sql = "SELECT id,login,password,droit FROM users WHERE login = ? AND password = ?";
		$res=$this->db->executeQuery($sql,[$login,$mdp]);   //md5($mdp);
		if($res->rowCount()==1)
			return $res->fetch();
		else
			return false;
	}
	public function updateClient($donnees) {
		$queryBuilder = new QueryBuilder($this->db);
		$queryBuilder
			->update('users')
			->set('email', '?')
			->set('password','?')
			->set('login','?')
			->set('nom','?')
			->set('code_postale','?')
			->set('ville','?')
			->set('adresse','?')
			->where('id= ?')
			->setParameter(0, $donnees['email'])
			->setParameter(1, $donnees['password'])
			->setParameter(2, $donnees['login'])
			->setParameter(3, $donnees['nom'])
			->setParameter(4, $donnees['code_postale'])
			->setParameter(5, $donnees['ville'])
			->setParameter(6, $donnees['stock'])
			->setParameter(7, $donnees['adresse'])
			->setParameter(8, $donnees['id']);
		return $queryBuilder->execute();
	}
}