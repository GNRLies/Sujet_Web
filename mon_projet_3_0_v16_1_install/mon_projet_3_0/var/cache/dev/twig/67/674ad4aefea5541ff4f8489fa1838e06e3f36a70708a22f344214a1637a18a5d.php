<?php

/* projetTest1YMLBundle:Default:maPage1Test.html.twig */
class __TwigTemplate_92de7c6b5261d770103b470c78d166aef96cb23a6e85f46f0f52ceb461ecb601 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_fffb190351dfbd01639bdee7e01d21b93a24c0f9a376913a997f4afa43def906 = $this->env->getExtension("native_profiler");
        $__internal_fffb190351dfbd01639bdee7e01d21b93a24c0f9a376913a997f4afa43def906->enter($__internal_fffb190351dfbd01639bdee7e01d21b93a24c0f9a376913a997f4afa43def906_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "projetTest1YMLBundle:Default:maPage1Test.html.twig"));

        // line 1
        echo "<html>
<body>
maPage1Test<br>
<a href=\"#ancreBidon\">lien sur NQ</a><br>
<br>
<a href=\"";
        // line 6
        echo $this->env->getExtension('routing')->getUrl("maRoute1SurPage1");
        echo "\">lien 1 sur la page 1</a><br>
{<a href=\"";
        // line 7
        echo $this->env->getExtension('routing')->getPath("maRoute1SurPage2");
        echo "\">lien 1 sur la page 2</a><br>}
{<a href=\"";
        // line 8
        echo $this->env->getExtension('routing')->getPath("maRoute2SurPage2");
        echo "\">lien 2 sur la page 2</a><br>}
{<a href=\"";
        // line 9
        echo $this->env->getExtension('routing')->getPath("maRoute2SurPage2", array("param" => "valeur du paramètre"));
        echo "\">lien 1 sur la page 2 avec un paramètre</a><br>}


{<form action=\"";
        // line 12
        echo $this->env->getExtension('routing')->getPath("maRoute2SurPage2");
        echo "\" method=\"get\">}
{<input type=\"text\" value=\"essai1\" name=\"param\"/>}
{</form><br>}
{route méthode POST}
{<form action=\"";
        // line 16
        echo $this->env->getExtension('routing')->getPath("maRoute3SurPage2");
        echo "\" method=\"POST\">}
{<input type=\"text\" value=\"essai2\" name=\"param\" />}
{</form><br>

{route méthode PUT}
{<form action=\"";
        // line 21
        echo $this->env->getExtension('routing')->getPath("maRoute4SurPage2");
        echo "\" method=\"POST\">}
{<input type=\"hidden\" name=\"_method\" value=\"PUT\">}
{<input type=\"hidden\" name=\"_csrf_token\" value=\"";
        // line 23
        echo twig_escape_filter($this->env, $this->env->getExtension('form')->renderCsrfToken("authenticate"), "html", null, true);
        echo "\">}
{<input type=\"text\" value=\"essai\" name=\"input1\"/>}
{</form>#}
</body>
</html>";
        
        $__internal_fffb190351dfbd01639bdee7e01d21b93a24c0f9a376913a997f4afa43def906->leave($__internal_fffb190351dfbd01639bdee7e01d21b93a24c0f9a376913a997f4afa43def906_prof);

    }

    public function getTemplateName()
    {
        return "projetTest1YMLBundle:Default:maPage1Test.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  67 => 23,  62 => 21,  54 => 16,  47 => 12,  41 => 9,  37 => 8,  33 => 7,  29 => 6,  22 => 1,);
    }
}
/* <html>*/
/* <body>*/
/* maPage1Test<br>*/
/* <a href="#ancreBidon">lien sur NQ</a><br>*/
/* <br>*/
/* <a href="{{ url('maRoute1SurPage1') }}">lien 1 sur la page 1</a><br>*/
/* {<a href="{{ path('maRoute1SurPage2') }}">lien 1 sur la page 2</a><br>}*/
/* {<a href="{{ path('maRoute2SurPage2') }}">lien 2 sur la page 2</a><br>}*/
/* {<a href="{{ path('maRoute2SurPage2', {'param':'valeur du paramètre'}) }}">lien 1 sur la page 2 avec un paramètre</a><br>}*/
/* */
/* */
/* {<form action="{{ path('maRoute2SurPage2') }}" method="get">}*/
/* {<input type="text" value="essai1" name="param"/>}*/
/* {</form><br>}*/
/* {route méthode POST}*/
/* {<form action="{{ path('maRoute3SurPage2') }}" method="POST">}*/
/* {<input type="text" value="essai2" name="param" />}*/
/* {</form><br>*/
/* */
/* {route méthode PUT}*/
/* {<form action="{{ path('maRoute4SurPage2') }}" method="POST">}*/
/* {<input type="hidden" name="_method" value="PUT">}*/
/* {<input type="hidden" name="_csrf_token" value="{{ csrf_token('authenticate') }}">}*/
/* {<input type="text" value="essai" name="input1"/>}*/
/* {</form>#}*/
/* </body>*/
/* </html>*/
