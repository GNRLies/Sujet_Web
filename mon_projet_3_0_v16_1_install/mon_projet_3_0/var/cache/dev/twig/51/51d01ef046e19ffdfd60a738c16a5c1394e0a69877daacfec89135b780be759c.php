<?php

/* projetTest1YMLBundle:Default:index.html.twig */
class __TwigTemplate_c7252e792c7f136b57a76fce53a0a72ff9c09f6f63120de157d55341074314a3 extends Twig_Template
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
        $__internal_132d108791c0aa8a2c170b86127763ddcd023fabc8d0d1a1f2074d8274c25211 = $this->env->getExtension("native_profiler");
        $__internal_132d108791c0aa8a2c170b86127763ddcd023fabc8d0d1a1f2074d8274c25211->enter($__internal_132d108791c0aa8a2c170b86127763ddcd023fabc8d0d1a1f2074d8274c25211_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "projetTest1YMLBundle:Default:index.html.twig"));

        // line 2
        echo "<html>
<body>
Hello !
<a href=\"";
        // line 5
        echo $this->env->getExtension('routing')->getPath("maRoute1SurPage1");
        echo "\"> mon lien sur la page 1</a>
</body>
</html>";
        
        $__internal_132d108791c0aa8a2c170b86127763ddcd023fabc8d0d1a1f2074d8274c25211->leave($__internal_132d108791c0aa8a2c170b86127763ddcd023fabc8d0d1a1f2074d8274c25211_prof);

    }

    public function getTemplateName()
    {
        return "projetTest1YMLBundle:Default:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  27 => 5,  22 => 2,);
    }
}
/* {#views/Default/index.html.twig #}*/
/* <html>*/
/* <body>*/
/* Hello !*/
/* <a href="{{ path('maRoute1SurPage1') }}"> mon lien sur la page 1</a>*/
/* </body>*/
/* </html>*/
