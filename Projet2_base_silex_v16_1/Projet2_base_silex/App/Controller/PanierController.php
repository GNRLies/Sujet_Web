<?php
namespace App\Controller;

use App\Model\PanierModel;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;

use Symfony\Component\HttpFoundation\Request;    //pour utiliser request

use App\Model\JeuxModel;
use App\Model\TypeJeuxModel;

use Symfony\Component\Validator\Constraints as Assert;    //pour utiliser la validation
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Security;

class PanierController implements ControllerProviderInterface
{
    private $panierModel;
    private $jeuxModel;


    public function __construct()
    {
    }

    public function index(Application $app) {
        return $this->show($app);
    }

    public function show(Application $app) {
        $userid = $app["session"]->get('user_id');
        $this->panierModel = new PanierModel($app);
        $panier = $this->panierModel->getAllPanier($userid);
        return $app["twig"]->render('frontOff/Panier/show.html.twig',['data'=>$panier]);
    }

    public function add(Application $app, Request $req) {
        $this->jeuxModel = new JeuxModel($app);
        $this->panierModel = new PanierModel($app);
        $jeux_id = $app->escape($req->get('id'));
        $user_id = $app['session']->get('user_id');
        if($this->panierModel->countNbJeuxLigne($jeux_id,$user_id)>0){
            $this->panierModel->updateJeuxLigneAdd($jeux_id,$user_id);
        }
        else {
            $this->panierModel->insertPanier($jeux_id,$user_id);
        }
        return $app->redirect($app["url_generator"]->generate("Jeux.index"));
        return "add Panier";
    }

    public function delete(Application $app,Request $req){
        $this->jeuxModel = new JeuxModel($app);
        $this->panierModel = new PanierModel($app);
        $jeux_id = $app->escape($req->get('id'));
        $user_id = $app['session']->get('user_id');
        if($this->panierModel->countNbJeuxLigne($jeux_id,$user_id)>1){
            $this->panierModel->updateJeuxLigneDel($jeux_id,$user_id);
        }
        else {
            $this->panierModel->deletePanier($jeux_id,$user_id);
        }
        return $app->redirect($app["url_generator"]->generate("Jeux.index"));
        return "delete Panier";
    }

    public function deleteAll(Application $app,Request $req){
        $this->panierModel = new PanierModel($app);
        $user_id = $app['session']->get('user_id');
        $this->panierModel->deleteAllPanier($user_id);
        return $app->redirect($app["url_generator"]->generate("Jeux.index"));
        return "delete Panier";
    }



    public function validFormAdd(Application $app, Request $req) {
        var_dump($app['request']->attributes);
        if (isset($_POST['nom']) && isset($_POST['typeJeux_id']) and isset($_POST['nom']) and isset($_POST['photo']) and isset($_POST['plateforme']) and isset($_POST['dispo']) and isset($_POST['stock'])) {
            $donnees = [
                'nom' => htmlspecialchars($_POST['nom']),                     //echapper les entrées
                'typeJeux_id' => htmlspecialchars($app['request']->get('typeJeux_id')),
                'prix' => htmlspecialchars($req->get('prix')),
                'photo' => $app->escape($req->get('photo')),
                'plateforme' => htmlspecialchars($req->get('plateforme')),
                'dispo' => htmlspecialchars($req->get('dispo')),
                'stock' => htmlspecialchars($req->get('stock'))
            ];
            if ((!preg_match("/^[A-Za-z ]{2,}/", $donnees['nom']))) $erreurs['nom'] = 'nom composé de 2 lettres minimum';
            if (!is_numeric($donnees['typeJeux_id'])) $erreurs['typeJeux_id'] = 'veuillez saisir une valeur';
            if (!is_numeric($donnees['prix'])) $erreurs['prix'] = 'saisir une valeur numérique';
            if (!preg_match("/[A-Za-z0-9]{2,}.(jpeg|jpg|png)/", $donnees['photo'])) $erreurs['photo'] = 'nom de fichier incorrect (extension jpeg , jpg ou png)';
            if ((!preg_match("/^[A-Za-z ]{2,}/", $donnees['plateforme']))) $erreurs['plateforme'] = 'nom composé de 2 lettres minimum';
            if (!is_numeric($donnees['dispo'])) $erreurs['dispo'] = 'saisir une valeur numérique';
            if (!is_numeric($donnees['stock'])) $erreurs['stock'] = 'saisir une valeur numérique';

            if(! empty($erreurs))
            {
                $this->typeJeuxModel = new TypeJeuxModel($app);
                $typeJeux = $this->typeJeuxModel->getAllTypeJeux();
                return $app["twig"]->render('frontOff/Jeux/add.html.twig',['donnees'=>$donnees,'erreurs'=>$erreurs,'typeJeux'=>$typeJeux]);
            }
            else
            {
                $this->JeuxModel = new JeuxModel($app);
                $this->JeuxModel->insertJeux($donnees);
                return $app->redirect($app["url_generator"]->generate("Jeux.index"));
            }

        }
        else
            return $app->abort(404, 'error Pb data form Add');

    }

    public function validFormDelete(Application $app, Request $req) {
        $id=$app->escape($req->get('id'));
        if (is_numeric($id)) {
            $this->JeuxModel = new JeuxModel($app);
            $this->JeuxModel->deleteJeux($id);
            return $app->redirect($app["url_generator"]->generate("Jeux.index"));
        }
        else
            return $app->abort(404, 'error Pb id form Delete');
    }

    public function valider(Application $app, $prix) {
        $this->panierModel = new PanierModel($app);
        $user_id = $app['session']->get('user_id');
        $this->panierModel->validerCommande($user_id,$prix);
        $this->panierModel->deleteAllPanier($user_id);
        return $app->redirect($app["url_generator"]->generate("Jeux.index"));
        return "delete Panier";
    }


    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get('/', 'App\Controller\PanierController::index')->bind('Panier.index');
        $controllers->get('/show', 'App\Controller\PanierController::show')->bind('Panier.show');

        $controllers->get('/add/{id}', 'App\Controller\PanierController::add')->bind('Panier.add')->assert('id', '\d+');;
        $controllers->get('/delete/{id}', 'App\Controller\PanierController::delete')->bind('Panier.delete')->assert('id', '\d+');;
        $controllers->get('/deleteAll', 'App\Controller\PanierController::deleteAll')->bind('Panier.deleteAll');
      //  $controllers->get('/valider', 'App\Controller\PanierController::valider')->bind('Panier.valider');
        $controllers->get('/valider/{prix}', 'App\Controller\PanierController::valider')->bind('Panier.valider')->value('prix', '0');


        $controllers->get('/add', 'App\Controller\PanierController::add')->bind('Panier.add');

        $controllers->get('/delete/{id}', 'App\Controller\JeuxController::delete')->bind('Jeux.delete')->assert('id', '\d+');;
        $controllers->delete('/delete', 'App\Controller\JeuxController::validFormDelete')->bind('Jeux.validFormDelete');

        $controllers->get('/edit/{id}', 'App\Controller\JeuxController::edit')->bind('Jeux.edit')->assert('id', '\d+');;
        $controllers->put('/edit', 'App\Controller\JeuxController::validFormEdit')->bind('Jeux.validFormEdit');



        return $controllers;
    }
}
