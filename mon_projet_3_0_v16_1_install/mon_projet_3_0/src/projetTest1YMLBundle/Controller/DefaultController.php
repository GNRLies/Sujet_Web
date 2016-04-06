<?php

namespace projetTest1YMLBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('projetTest1YMLBundle:Default:index.html.twig');
    }

    public function affichagePage1Action()
    {
        return $this->render('projetTest1YMLBundle:Default:maPage1Test.html.twig');
    }

    public function affichagePage2Action(Request $request)
    {
//        echo '<pre>';
//        var_dump($request);
//        echo '</pre>';
        $input1=$request->get('param');
//        var_dump($input1);
//        die();
        echo "submit get : ";
        return $this->render('projetTest1YMLBundle:Default:maPage2Test.html.twig',['champ1'=>$input1]);
    }

    public function affichagePage2formAction(Request $request)
    {
        $input1=$request->get('param');
        return $this->render('projetTest1YMLBundle:Default:maPage2Test.html.twig',['champ1'=>$input1]);
    }
}
