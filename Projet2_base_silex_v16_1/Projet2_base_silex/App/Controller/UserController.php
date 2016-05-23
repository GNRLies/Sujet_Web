<?php
namespace App\Controller;
use Symfony\Component\Validator\Constraints as Assert;
use App\Model\UserModel;
use Silex\Application;
use Silex\ControllerProviderInterface;

class UserController implements ControllerProviderInterface {

	private $userModel;

	public function index(Application $app) {
		return $this->connexionUser($app);
	}

	public function connexionUser(Application $app)
	{
		return $app["twig"]->render('v_session_connexion.html.twig');
	}


	public function validFormConnexionUser(Application $app)
	{

		$app['session']->clear();
		$donnees['login']=$app['request']->request->get('login');
		$donnees['password']=$app['request']->request->get('password');

		$this->userModel = new UserModel($app);
		$data=$this->userModel->verif_login_mdp_Utilisateur($donnees['login'],$donnees['password']);

		if($data != NULL)
		{
			$app['session']->set('droit', $data['droit']);  //dans twig {{ app.session.get('droit') }}
			$app['session']->set('login', $data['login']);
			$app['session']->set('user_id', $data['id']);
			$app['session']->set('logged', 1);
			return $app->redirect($app["url_generator"]->generate("Jeux.index"));
		}
		else
		{
			$app['session']->set('erreur','mot de passe ou login incorrect');
			return $app["twig"]->render('v_session_connexion.html.twig');
		}
	}

	public function deconnexionSession(Application $app)
	{
		$app['session']->clear();
		$app['session']->getFlashBag()->add('msg', 'vous êtes déconnecté');
		return $app->redirect($app["url_generator"]->generate("Jeux.index"));
	}

	public function validFormEdit(Application $app, Request $req)
	{
		var_dump($app['request']->attributes);
		if (isset($_POST['email']) && isset($_POST['password']) and isset($_POST['login']) and isset($_POST['code_postale'])and isset($_POST['ville']) and isset($_POST['adressse'])) {
			$donnees = [
				'email' => htmlspecialchars($_POST['email']),
				'password' => htmlspecialchars($req->get('password')),
				'code_postale' => htmlspecialchars($req->get('prix')),
				'plateforme' => htmlspecialchars($req->get('plateforme')),
				'ville' => htmlspecialchars($req->get('ville')),
				'adressse' => htmlspecialchars($req->get('adressse')),
			];
			if ((!preg_match("/^[A-Za-z ]{2,}/", $donnees['nom']))) $erreurs['nom'] = 'nom composé de 2 lettres minimum';
			if (!is_numeric($donnees['typeJeux_id'])) $erreurs['typeJeux_id'] = 'veuillez saisir une valeur';
			if (!is_numeric($donnees['prix'])) $erreurs['prix'] = 'saisir une valeur numérique';
			if ((!preg_match("/^[A-Za-z ]{2,}/", $donnees['plateforme']))) $erreurs['plateforme'] = 'nom composé de 2 lettres minimum';
			if (!is_numeric($donnees['dispo'])) $erreurs['dispo'] = 'saisir une valeur numérique';
			if (!preg_match("/[A-Za-z0-9]{2,}.(jpeg|jpg|png)/", $donnees['photo'])) $erreurs['photo'] = 'nom de fichier incorrect (extension jpeg , jpg ou png)';
			if (!is_numeric($donnees['id'])) $erreurs['id'] = 'saisir une valeur numérique';
			$contraintes = new Assert\Collection(
				[
					'id' => [new Assert\NotBlank(), new Assert\Type('digit')],
					'typeJeux_id' => [new Assert\NotBlank(), new Assert\Type('digit')],
					'nom' => [
						new Assert\NotBlank(['message' => 'saisir une valeur']),
						new Assert\Length(['min' => 2, 'minMessage' => "Le nom doit faire au moins {{ limit }} caractères."])
					],
					'photo' => [
						new Assert\Length(array('min' => 5)),
						new Assert\Regex(['pattern' => '/[A-Za-z0-9]{2,}.(jpeg|jpg|png)/',
							'match' => true,
							'message' => 'nom de fichier incorrect (extension jpeg , jpg ou png)']),
					],
					'prix' => [new Assert\Type(array(
						'type' => 'numeric',
						'message' => 'La valeur {{ value }} n\'est pas valide, le type est {{ type }}.',
					))
					],
					'plateforme' => [
						new Assert\NotBlank(['message' => 'saisir une valeur']),
						new Assert\Length(['min' => 2, 'minMessage' => "Le nom doit faire au moins {{ limit }} caractères."])
					],
					'dispo' => new Assert\Type(array(
						'type' => 'numeric',
						'message' => 'La valeur {{ value }} n\'est pas valide, le type est {{ type }}.',
					))

				]);
			$errors = $app['validator']->validate($donnees, $contraintes);   //ce n'est pas validateValue

			$violationList = $this->get('validator')->validateValue($req->request->all(), $contraintes);
			var_dump($violationList);

			die();
			if (count($errors) > 0) {
				foreach ($errors as $error) {
					echo $error->getPropertyPath() . '/ ' . $error->getMessage() . "\n";
				}
				die();
				var_dump($erreurs);

				if (!empty($erreurs)) {
					$this->typeJeuxModel = new TypeJeuxModel($app);
					$typeJeux = $this->typeJeuxModel->getAllTypeJeux();
					return $app["twig"]->render('backOff/Jeux/edit.html.twig', ['donnees' => $donnees, 'errors' => $errors, 'erreurs' => $erreurs, 'typeJeux' => $typeJeux]);
				} else {
					$this->JeuxModel = new JeuxModel($app);
					$this->JeuxModel->updateJeux($donnees);
					return $app->redirect($app["url_generator"]->generate("Jeux.index"));
				}

			} else
				return $app->abort(404, 'error Pb id form edit');

		}
	}

	public function connect(Application $app) {
		$controllers = $app['controllers_factory'];
		$controllers->match('/', 'App\Controller\UserController::index')->bind('user.index');
		$controllers->get('/login', 'App\Controller\UserController::connexionUser')->bind('user.login');
		$controllers->post('/login', 'App\Controller\UserController::validFormConnexionUser')->bind('user.validFormlogin');
		$controllers->get('/logout', 'App\Controller\UserController::deconnexionSession')->bind('user.logout');
		return $controllers;
	}
}