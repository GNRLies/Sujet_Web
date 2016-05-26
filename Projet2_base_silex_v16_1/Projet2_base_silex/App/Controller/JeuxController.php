<?php
namespace App\Controller;

use App\Model\JeuxModel;
use App\Model\PanierModel;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;

use Symfony\Component\HttpFoundation\Request;    //pour utiliser request

use App\Model\TypeJeuxModel;

use Symfony\Component\Validator\Constraints as Assert;    //pour utiliser la validation
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Security;

/**
 * @property JeuxModel JeuxModel
 */
class JeuxController implements ControllerProviderInterface
{
    private $jeuxModel;
    private $typeJeuxModel;

    public function __construct()
    {
    }

    public function index(Application $app)
    {
        return $this->show($app);
    }

    public function show(Application $app)
    {
        $this->jeuxModel = new JeuxModel($app);
        $jeux = $this->jeuxModel->getAllJeux();
        $panierModel = new PanierModel($app);
        $user_id = $app['session']->get('user_id');
        $panier = $panierModel->getAllPanier($user_id);
        $prix = $panierModel->calculprix($user_id);
        return $app["twig"]->render('backOff/Jeux/show.html.twig',['data'=>$jeux, 'panier' => $panier, 'prix'=>$prix]);
    }

    public function add(Application $app)
    {
        $this->typeJeuxModel = new TypeJeuxModel($app);
        $typeJeux = $this->typeJeuxModel->getAllTypeJeux();
        return $app["twig"]->render('backOff/Jeux/add.html.twig', ['typeJeux' => $typeJeux, 'path' => BASE_URL]);
        return "add Jeux";
    }

    public function validFormAdd(Application $app, Request $req)
    {
        var_dump($app['request']->attributes);
        if (isset($_POST['nom']) && isset($_POST['typeJeux_id']) and isset($_POST['nom']) and isset($_POST['photo']) and isset($_POST['plateforme']) and isset($_POST['dispo'])and isset($_POST['stock'])) {
            $donnees = [
                'nom' => htmlspecialchars($_POST['nom']),                     //echapper les entrées
                'typeJeux_id' => htmlspecialchars($app['request']->get('typeJeux_id')),
                'prix' => htmlspecialchars($req->get('prix')),
                'photo' => $app->escape($req->get('photo')),
                'plateforme' => htmlspecialchars($req->get('plateforme')),
                'dispo' => htmlspecialchars($req->get('dispo')),
                'stock' => htmlspecialchars($req->get('stock')),
            ];
            if ((!preg_match("/^[A-Za-z ]{2,}/", $donnees['nom']))) $erreurs['nom'] = 'nom composé de 2 lettres minimum';
            if (!is_numeric($donnees['typeJeux_id'])) $erreurs['typeJeux_id'] = 'veuillez saisir une valeur';
            if (!is_numeric($donnees['prix'])) $erreurs['prix'] = 'saisir une valeur numérique';
            if (!preg_match("/[A-Za-z0-9]{2,}.(jpeg|jpg|png)/", $donnees['photo'])) $erreurs['photo'] = 'nom de fichier incorrect (extension jpeg , jpg ou png)';
            if ((!preg_match("/^[A-Za-z ]{2,}/", $donnees['plateforme']))) $erreurs['plateforme'] = 'nom composé de 2 lettres minimum';
            if (!is_numeric($donnees['dispo'])) $erreurs['dispo'] = 'saisir une valeur numérique';
            if (!is_numeric($donnees['stock'])) $erreurs['stock'] = 'saisir une valeur numérique';

            if (!empty($erreurs)) {
                $this->typeJeuxModel = new TypeJeuxModel($app);
                $typeJeux = $this->typeJeuxModel->getAllTypeJeux();
                return $app["twig"]->render('backOff/Jeux/add.html.twig', ['donnees' => $donnees, 'erreurs' => $erreurs, 'typeJeux' => $typeJeux]);
            } else {
                $this->JeuxModel = new JeuxModel($app);
                $this->JeuxModel->insertJeux($donnees);
                return $app->redirect($app["url_generator"]->generate("Jeux.index"));
            }

        } else
            return $app->abort(404, 'error Pb data form Add');

    }

    public function delete(Application $app, $id)
    {
        $this->typeJeuxModel = new TypeJeuxModel($app);
        $typeJeux = $this->typeJeuxModel->getAllTypeJeux();
        $this->JeuxModel = new JeuxModel($app);
        $donnees = $this->JeuxModel->getJeux($id);
        return $app["twig"]->render('backOff/Jeux/delete.html.twig', ['typeJeux' => $typeJeux, 'donnees' => $donnees]);
        return "add Jeux";
    }

    public function validFormDelete(Application $app, Request $req)
    {
        $id = $app->escape($req->get('id'));
        if (is_numeric($id)) {
            $this->JeuxModel = new JeuxModel($app);
            $this->JeuxModel->deleteJeux($id);
            return $app->redirect($app["url_generator"]->generate("Jeux.index"));
        } else
            return $app->abort(404, 'error Pb id form Delete');
    }


    /**
     * @param Application $app
     * @param Request $req
     * @return mixed
     */
    public function edit(Application $app,$id){
        $this->typeJeuxModel = new TypeJeuxModel($app);
        $typeJeux = $this->typeJeuxModel->getAllTypeJeux();
        $this->jeuxModel = new JeuxModel($app);
        $donnees = $this->jeuxModel->getJeux($id);
        return $app["twig"]->render('backOff/Jeux/edit.html.twig',['typeJeux' => $typeJeux,'donnees'=>$donnees]);
    }

    public function validFormEdit(Application $app, Request $req)
    {
        $this->jeuxModel = new JeuxModel($app);
        $id = $app['session']->get('id');
        $donnees = $this->jeuxModel->getJeux($id);
        if(isset($_POST['nom']) && isset($_POST['typeJeux_id']) and isset($_POST['nom']) and isset($_POST['photo']) and isset($_POST['plateforme']) and isset($_POST['dispo'])and isset($_POST['stock'])){
            $donnees =[
                'nom' => htmlspecialchars($_POST['nom']),                     //echapper les entrées
                'typeJeux_id' => htmlspecialchars($app['request']->get('typeJeux_id')),
                'prix' => htmlspecialchars($req->get('prix')),
                'photo' => $app->escape($req->get('photo')),
                'plateforme' => htmlspecialchars($req->get('plateforme')),
                'dispo' => htmlspecialchars($req->get('dispo')),
                'stock' => htmlspecialchars($req->get('stock')),
                'id' => $app->escape($req->get('id'))
            ];
            if ((!preg_match("/^[A-Za-z ]{2,}/", $donnees['nom']))) $erreurs['nom'] = 'nom composé de 2 lettres minimum';
            if (!is_numeric($donnees['typeJeux_id'])) $erreurs['typeJeux_id'] = 'veuillez saisir une valeur';
            if (!is_numeric($donnees['prix'])) $erreurs['prix'] = 'saisir une valeur numérique';
            if (!preg_match("/[A-Za-z0-9]{2,}.(jpeg|jpg|png)/", $donnees['photo'])) $erreurs['photo'] = 'nom de fichier incorrect (extension jpeg , jpg ou png)';
            if ((!preg_match("/^[A-Za-z ]{2,}/", $donnees['plateforme']))) $erreurs['plateforme'] = 'nom composé de 2 lettres minimum';
            if (!is_numeric($donnees['dispo'])) $erreurs['dispo'] = 'saisir une valeur numérique';
            if (!is_numeric($donnees['stock'])) $erreurs['stock'] = 'saisir une valeur numérique';
            if(! is_numeric($id))$erreurs['id']='saisir une valeur numérique';
            if (! empty($erreurs)) {
                $this->jeuxModel = new JeuxModel($app);
                return $app["twig"]->render('backOff/Jeux/edit.html.twig',['donnees'=>$donnees,'erreurs'=>$erreurs]);
            }
            else
            {
                $this->jeuxModel->updateJeux($donnees);
                return $app->redirect($app["url_generator"]->generate("Jeux.index"));
            }
        }
        else{
            return $app->abort(404, 'error Pb id form edit');
        }
    }

    public
    function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get('/', 'App\Controller\JeuxController::index')->bind('Jeux.index');
        $controllers->get('/show', 'App\Controller\JeuxController::show')->bind('Jeux.show');

        $controllers->get('/add', 'App\Controller\JeuxController::add')->bind('Jeux.add');
        $controllers->post('/add', 'App\Controller\JeuxController::validFormAdd')->bind('Jeux.validFormAdd');

        $controllers->get('/delete/{id}', 'App\Controller\JeuxController::delete')->bind('Jeux.delete')->assert('id', '\d+');;
        $controllers->delete('/delete', 'App\Controller\JeuxController::validFormDelete')->bind('Jeux.validFormDelete');

        $controllers->get('/edit/{id}', 'App\Controller\JeuxController::edit')->bind('Jeux.edit')->assert('id', '\d+');;
        $controllers->put('/edit', 'App\Controller\JeuxController::validFormEdit')->bind('Jeux.validFormEdit');

        $controllers->get('/', 'App\Controller\CommandeController::index')->bind('commande.index');
        $controllers->get('/show', 'App\Controller\CommandeController::show')->bind('commande.show');

        return $controllers;
    }


    /**
     * Returns routes to connect to the given application.
     *
     * @param Application $app An Application instance
     *
     * @return ControllerCollection A ControllerCollection instance
     */
}
