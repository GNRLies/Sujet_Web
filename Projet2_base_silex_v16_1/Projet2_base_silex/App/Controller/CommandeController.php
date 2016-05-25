<?php
namespace App\Controller;

use App\Model\CommandeModel;
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

class CommandeController implements ControllerProviderInterface
{
    private $panierModel;
    private $jeuxModel;
    private $CommandeModel;


    public function __construct()
    {
    }

    public function index(Application $app) {
        return $this->show($app);
    }

    public function show(Application $app) {
        $userid = $app["session"]->get('user_id');
        $this->CommandeModel = new CommandeModel($app);
        $commande = $this->CommandeModel->getAllCommande($userid);
        return $app["twig"]->render('frontOff/Commande/show.html.twig',['data'=>$commande]);
    }


    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get('/', 'App\Controller\CommandeController::index')->bind('commande.index');
        $controllers->get('/show', 'App\Controller\CommandeController::show')->bind('commande.show');

        return $controllers;
    }
}
