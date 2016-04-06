<?php

/* @WebProfiler/Collector/router.html.twig */
class __TwigTemplate_a0726ce269966d1dc132bc8521d960f6ad22960e125d430fc649adb2f5218e03 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@WebProfiler/Profiler/layout.html.twig", "@WebProfiler/Collector/router.html.twig", 1);
        $this->blocks = array(
            'toolbar' => array($this, 'block_toolbar'),
            'menu' => array($this, 'block_menu'),
            'panel' => array($this, 'block_panel'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@WebProfiler/Profiler/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_4785ecb87413cc1bd51e718750e00282d77d552d5e6d1bb1297685bf0facf35e = $this->env->getExtension("native_profiler");
        $__internal_4785ecb87413cc1bd51e718750e00282d77d552d5e6d1bb1297685bf0facf35e->enter($__internal_4785ecb87413cc1bd51e718750e00282d77d552d5e6d1bb1297685bf0facf35e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@WebProfiler/Collector/router.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_4785ecb87413cc1bd51e718750e00282d77d552d5e6d1bb1297685bf0facf35e->leave($__internal_4785ecb87413cc1bd51e718750e00282d77d552d5e6d1bb1297685bf0facf35e_prof);

    }

    // line 3
    public function block_toolbar($context, array $blocks = array())
    {
        $__internal_f2c77997b586752e67bc24f2a4d5d95623d587f1f1e2e5da51e29215368d1557 = $this->env->getExtension("native_profiler");
        $__internal_f2c77997b586752e67bc24f2a4d5d95623d587f1f1e2e5da51e29215368d1557->enter($__internal_f2c77997b586752e67bc24f2a4d5d95623d587f1f1e2e5da51e29215368d1557_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "toolbar"));

        
        $__internal_f2c77997b586752e67bc24f2a4d5d95623d587f1f1e2e5da51e29215368d1557->leave($__internal_f2c77997b586752e67bc24f2a4d5d95623d587f1f1e2e5da51e29215368d1557_prof);

    }

    // line 5
    public function block_menu($context, array $blocks = array())
    {
        $__internal_eaa4bed3b527ba1d0c0a9e482a3a9985b91d05dda4ef2c739a9bfe16b7e50b34 = $this->env->getExtension("native_profiler");
        $__internal_eaa4bed3b527ba1d0c0a9e482a3a9985b91d05dda4ef2c739a9bfe16b7e50b34->enter($__internal_eaa4bed3b527ba1d0c0a9e482a3a9985b91d05dda4ef2c739a9bfe16b7e50b34_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "menu"));

        // line 6
        echo "<span class=\"label\">
    <span class=\"icon\">";
        // line 7
        echo twig_include($this->env, $context, "@WebProfiler/Icon/router.svg");
        echo "</span>
    <strong>Routing</strong>
</span>
";
        
        $__internal_eaa4bed3b527ba1d0c0a9e482a3a9985b91d05dda4ef2c739a9bfe16b7e50b34->leave($__internal_eaa4bed3b527ba1d0c0a9e482a3a9985b91d05dda4ef2c739a9bfe16b7e50b34_prof);

    }

    // line 12
    public function block_panel($context, array $blocks = array())
    {
        $__internal_f01c4136587ddee8205ff43fb0fe3b187749703e26fe87755c6738ad84c436f3 = $this->env->getExtension("native_profiler");
        $__internal_f01c4136587ddee8205ff43fb0fe3b187749703e26fe87755c6738ad84c436f3->enter($__internal_f01c4136587ddee8205ff43fb0fe3b187749703e26fe87755c6738ad84c436f3_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "panel"));

        // line 13
        echo "    ";
        echo $this->env->getExtension('http_kernel')->renderFragment($this->env->getExtension('routing')->getPath("_profiler_router", array("token" => (isset($context["token"]) ? $context["token"] : $this->getContext($context, "token")))));
        echo "
";
        
        $__internal_f01c4136587ddee8205ff43fb0fe3b187749703e26fe87755c6738ad84c436f3->leave($__internal_f01c4136587ddee8205ff43fb0fe3b187749703e26fe87755c6738ad84c436f3_prof);

    }

    public function getTemplateName()
    {
        return "@WebProfiler/Collector/router.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  73 => 13,  67 => 12,  56 => 7,  53 => 6,  47 => 5,  36 => 3,  11 => 1,);
    }
}
/* {% extends '@WebProfiler/Profiler/layout.html.twig' %}*/
/* */
/* {% block toolbar %}{% endblock %}*/
/* */
/* {% block menu %}*/
/* <span class="label">*/
/*     <span class="icon">{{ include('@WebProfiler/Icon/router.svg') }}</span>*/
/*     <strong>Routing</strong>*/
/* </span>*/
/* {% endblock %}*/
/* */
/* {% block panel %}*/
/*     {{ render(path('_profiler_router', { token: token })) }}*/
/* {% endblock %}*/
/* */
