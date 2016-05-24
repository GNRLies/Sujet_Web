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
        return $app["twig"]->render('backOff/Panier/show.html.twig',['data'=>$panier]);
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
        if($this->panierModel->countNbJeuxLigne($jeux_id,$user_id)!=1){
            $this->panierModel->updateJeuxLigneDel($jeux_id,$user_id);
        }
        else {
            $this->panierModel->deletePanier($jeux_id,$user_id);
        }
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
                return $app["twig"]->render('backOff/Jeux/add.html.twig',['donnees'=>$donnees,'erreurs'=>$erreurs,'typeJeux'=>$typeJeux]);
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


    public function edit(Application $app, $id) {
        $this->panierModel = new PanierModel($app);
        $donnees = $this->panierModel->getAllPanier($id);
        $this->produitModel->updatePanier($id);
        $donnees->render(array('donnees' => $donnees ,'path'=>BASE_URL));
        return $app->redirect($app["url_generator"]->generate("Panier.show"));
        return "edit Panier";
    }

    /**
     * Returns routes to connect to the given application.
     *
     * @param Application $app An Application instance
     *
     * @return ControllerCollection A ControllerCollection instance
     */

    public function validFormEdit(Application $app, Request $req)
    {
        var_dump($app['request']->attributes);
        if (isset($_POST['nom']) && isset($_POST['typeJeux_id']) and isset($_POST['nom']) and isset($_POST['photo']) and isset($_POST['id'])) {
            $donnees = [
                'nom' => htmlspecialchars($_POST['nom']),                     //echaper les entrées
                'typeJeux_id' => htmlspecialchars($app['request']->get('typeJeux_id')),
                'prix' => htmlspecialchars($req->get('prix')),
                'plateforme' => htmlspecialchars($req->get('plateforme')),
                'dispo' => htmlspecialchars($req->get('dispo')),
                'stock' => htmlspecialchars($req->get('stock')),
                'photo' => $app->escape($req->get('photo')),
                'id' => $app->escape($req->get('id')),
                $req->query->get('photo')
            ];
            if ((!preg_match("/^[A-Za-z ]{2,}/", $donnees['nom']))) $erreurs['nom'] = 'nom composé de 2 lettres minimum';
            if (!is_numeric($donnees['typeJeux_id'])) $erreurs['typeJeux_id'] = 'veuillez saisir une valeur';
            if (!is_numeric($donnees['prix'])) $erreurs['prix'] = 'saisir une valeur numérique';
            if ((!preg_match("/^[A-Za-z ]{2,}/", $donnees['plateforme']))) $erreurs['plateforme'] = 'nom composé de 2 lettres minimum';
            if (!is_numeric($donnees['dispo'])) $erreurs['dispo'] = 'saisir une valeur numérique';
            if (!is_numeric($donnees['stock'])) $erreurs['stock'] = 'saisir une valeur numérique';
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
                    )),
                    'stock' => new Assert\Type(array(
                        'type' => 'numeric',
                        'message' => 'La valeur {{ value }} n\'est pas valide, le type est {{ type }}.',
                    )),

                ]);
            $errors = $app['validator']->validate($donnees, $contraintes);   //ce n'est pas validateValue

            $violationList = $this->get('validator')->validateValue($req->request->all(), $contraintes);
            var_dump($violationList);

            die();
            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    echo $error->getPropertyPath() . ' ' . $error->getMessage() . "\n";
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

    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get('/', 'App\Controller\PanierController::index')->bind('Panier.index');
        $controllers->get('/show', 'App\Controller\PanierController::show')->bind('Panier.show');
        $controllers->get('/add/{id}', 'App\Controller\PanierController::add')->bind('Panier.add')->assert('id', '\d+');;
        $controllers->get('/delete/{id}', 'App\Controller\PanierController::delete')->bind('Panier.delete')->assert('id', '\d+');;
        $controllers->put('/edit', 'App\Controller\PanierController::edit')->bind('Panier.edit');


        $controllers->get('/add', 'App\Controller\PanierController::add')->bind('Panier.add');

        $controllers->get('/delete/{id}', 'App\Controller\JeuxController::delete')->bind('Jeux.delete')->assert('id', '\d+');;
        $controllers->delete('/delete', 'App\Controller\JeuxController::validFormDelete')->bind('Jeux.validFormDelete');

        $controllers->get('/edit/{id}', 'App\Controller\JeuxController::edit')->bind('Jeux.edit')->assert('id', '\d+');;
        $controllers->put('/edit', 'App\Controller\JeuxController::validFormEdit')->bind('Jeux.validFormEdit');



        return $controllers;
    }
}
