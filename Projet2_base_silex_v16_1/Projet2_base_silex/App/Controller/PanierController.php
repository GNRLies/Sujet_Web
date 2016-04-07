<?php
namespace App\Controller;

use App\Model\PanierModel;
use Silex\Application;
use Silex\ControllerProviderInterface;

use Symfony\Component\HttpFoundation\Request;   // pour utiliser request

use App\Model\ProduitModel;
use App\Model\TypeProduitModel;

use Symfony\Component\Validator\Constraints as Assert;   // pour utiliser la validation
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Security;

class PanierController implements ControllerProviderInterface
{
    private $panierModel;

    public function __construct()
    {
    }

    public function index(Application $app) {
        return $this->show($app);
    }

    public function show(Application $app) {
        $this->panierModel = new PanierModel($app);
        $panier = $this->panierModel->getAllPanier();
        return $app["twig"]->render('backOff/Panier/show.html.twig',['data'=>$panier]);
    }

//    public function add(Application $app) {
//        $this->typeProduitModel = new TypeProduitModel($app);
//        $typeProduits = $this->typeProduitModel->getAllTypeProduits();
//        return $app["twig"]->render('backOff/Produit/add.html.twig',['typeProduits'=>$typeProduits,'path'=>BASE_URL]);
//        return "add Produit";
//    }
//
//    public function validFormAdd(Application $app, Request $req) {
//       // var_dump($app['request']->attributes);
//        if (isset($_POST['nom']) && isset($_POST['typeProduit_id']) and isset($_POST['nom']) and isset($_POST['photo'])) {
//            $donnees = [
//                'nom' => htmlspecialchars($_POST['nom']),                    // echapper les entrées
//                'typeProduit_id' => htmlspecialchars($app['request']->get('typeProduit_id')),
//                'prix' => htmlspecialchars($req->get('prix')),
//                'photo' => $app->escape($req->get('photo'))  //$req->query->get('photo')
//            ];
//            if ((! preg_match("/^[A-Za-z ]{2,}/",$donnees['nom']))) $erreurs['nom']='nom composé de 2 lettres minimum';
//            if(! is_numeric($donnees['typeProduit_id']))$erreurs['typeProduit_id']='veuillez saisir une valeur';
//            if(! is_numeric($donnees['prix']))$erreurs['prix']='saisir une valeur numérique';
//            if (! preg_match("/[A-Za-z0-9]{2,}.(jpeg|jpg|png)/",$donnees['photo'])) $erreurs['photo']='nom de fichier incorrect (extension jpeg , jpg ou png)';
//
//            if(! empty($erreurs))
//            {
//                $this->typeProduitModel = new TypeProduitModel($app);
//                $typeProduits = $this->typeProduitModel->getAllTypeProduits();
//                return $app["twig"]->render('backOff/Produit/add.html.twig',['donnees'=>$donnees,'erreurs'=>$erreurs,'typeProduits'=>$typeProduits]);
//            }
//            else
//            {
//                $this->ProduitModel = new ProduitModel($app);
//                $this->ProduitModel->insertProduit($donnees);
//                return $app->redirect($app["url_generator"]->generate("produit.index"));
//            }
//
//        }
//        else
//            return $app->abort(404, 'error Pb data form Add');
//
//    }
//
//    public function delete(Application $app, $id) {
//        $this->typeProduitModel = new TypeProduitModel($app);
//        $typeProduits = $this->typeProduitModel->getAllTypeProduits();
//        $this->produitModel = new ProduitModel($app);
//        $donnees = $this->produitModel->getProduit($id);
//        return $app["twig"]->render('backOff/Produit/delete.html.twig',['typeProduits'=>$typeProduits,'donnees'=>$donnees]);
//        return "add Produit";
//    }
//
//    public function validFormDelete(Application $app, Request $req) {
//        $id=$app->escape($req->get('id'));
//        if (is_numeric($id)) {
//            $this->produitModel = new ProduitModel($app);
//            $this->produitModel->deleteProduit($id);
//            return $app->redirect($app["url_generator"]->generate("produit.index"));
//        }
//        else
//            return $app->abort(404, 'error Pb id form Delete');
//    }
//
//
//    public function edit(Application $app, $id) {
//        $this->typeProduitModel = new TypeProduitModel($app);
//        $typeProduits = $this->typeProduitModel->getAllTypeProduits();
//        $this->produitModel = new ProduitModel($app);
//        $donnees = $this->produitModel->getProduit($id);
//        return $app["twig"]->render('backOff/Produit/edit.html.twig',['typeProduits'=>$typeProduits,'donnees'=>$donnees]);
//        return "add Produit";
//    }
//
//    public function validFormEdit(Application $app, Request $req) {
//        // var_dump($app['request']->attributes);
//        if (isset($_POST['nom']) && isset($_POST['typeProduit_id']) and isset($_POST['nom']) and isset($_POST['photo']) and isset($_POST['id'])) {
//            $donnees = [
//                'nom' => htmlspecialchars($_POST['nom']),                    // echaper les entrées
//                'typeProduit_id' => htmlspecialchars($app['request']->get('typeProduit_id')),
//                'prix' => htmlspecialchars($req->get('prix')),
//                'photo' => $app->escape($req->get('photo')),
//                'id' => $app->escape($req->get('id'))//$req->query->get('photo')
//            ];
//            if ((! preg_match("/^[A-Za-z ]{2,}/",$donnees['nom']))) $erreurs['nom']='nom composé de 2 lettres minimum';
//            if(! is_numeric($donnees['typeProduit_id']))$erreurs['typeProduit_id']='veuillez saisir une valeur';
//            if(! is_numeric($donnees['prix']))$erreurs['prix']='saisir une valeur numérique';
//            if (! preg_match("/[A-Za-z0-9]{2,}.(jpeg|jpg|png)/",$donnees['photo'])) $erreurs['photo']='nom de fichier incorrect (extension jpeg , jpg ou png)';
//            if(! is_numeric($donnees['id']))$erreurs['id']='saisir une valeur numérique';
//           $contraintes = new Assert\Collection(
//                [
//                    'id' => [new Assert\NotBlank(),new Assert\Type('digit')],
//                    'typeProduit_id' => [new Assert\NotBlank(),new Assert\Type('digit')],
//                    'nom' => [
//                        new Assert\NotBlank(['message'=>'saisir une valeur']),
//                        new Assert\Length(['min'=>2, 'minMessage'=>"Le nom doit faire au moins {{ limit }} caractères."])
//                    ],
//                    //http://symfony.com/doc/master/reference/constraints/Regex.html
//                    'photo' => [
//                        new Assert\Length(array('min' => 5)),
//                        new Assert\Regex([ 'pattern' => '/[A-Za-z0-9]{2,}.(jpeg|jpg|png)/',
//                        'match'   => true,
//                        'message' => 'nom de fichier incorrect (extension jpeg , jpg ou png)' ]),
//                    ],
//                    'prix' => new Assert\Type(array(
//                        'type'    => 'numeric',
//                        'message' => 'La valeur {{ value }} n\'est pas valide, le type est {{ type }}.',
//                    ))
//                ]);
//            $errors = $app['validator']->validate($donnees,$contraintes);  // ce n'est pas validateValue
//
//        //    $violationList = $this->get('validator')->validateValue($req->request->all(), $contraintes);
////var_dump($violationList);
//
//          //   die();
//            if (count($errors) > 0) {
//                // foreach ($errors as $error) {
//                //     echo $error->getPropertyPath().' '.$error->getMessage()."\n";
//                // }
//                // //die();
//                //var_dump($erreurs);
//
//            // if(! empty($erreurs))
//            // {
//                $this->typeProduitModel = new TypeProduitModel($app);
//                $typeProduits = $this->typeProduitModel->getAllTypeProduits();
//                return $app["twig"]->render('backOff/Produit/edit.html.twig',['donnees'=>$donnees,'errors'=>$errors,'erreurs'=>$erreurs,'typeProduits'=>$typeProduits]);
//            }
//            else
//            {
//                $this->ProduitModel = new ProduitModel($app);
//                $this->ProduitModel->updateProduit($donnees);
//                return $app->redirect($app["url_generator"]->generate("produit.index"));
//            }
//
//        }
//        else
//            return $app->abort(404, 'error Pb id form edit');
//
//    }

    public function connect(Application $app) {  //http://silex.sensiolabs.org/doc/providers.html#controller-providers
        $controllers = $app['controllers_factory'];

        $controllers->get('/', 'App\Controller\PanierController::index')->bind('Panier.index');
        $controllers->get('/show', 'App\Controller\PanierController::show')->bind('Panier.show');

//        $controllers->get('/add', 'App\Controller\produitController::add')->bind('produit.add');
//        $controllers->post('/add', 'App\Controller\produitController::validFormAdd')->bind('produit.validFormAdd');
//
//        $controllers->get('/delete/{id}', 'App\Controller\produitController::delete')->bind('produit.delete')->assert('id', '\d+');;
//        $controllers->delete('/delete', 'App\Controller\produitController::validFormDelete')->bind('produit.validFormDelete');
//
//        $controllers->get('/edit/{id}', 'App\Controller\produitController::edit')->bind('produit.edit')->assert('id', '\d+');;
//        $controllers->put('/edit', 'App\Controller\produitController::validFormEdit')->bind('produit.validFormEdit');

        return $controllers;
    }


}
