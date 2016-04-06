<?php

/* @Twig/Exception/exception_full.html.twig */
class __TwigTemplate_ef55fbdec10941b0e599664716a81b0f4f3038eab17824e81ecc96036ddabc2d extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@Twig/layout.html.twig", "@Twig/Exception/exception_full.html.twig", 1);
        $this->blocks = array(
            'head' => array($this, 'block_head'),
            'title' => array($this, 'block_title'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@Twig/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_29b4973bbffa73150f07fcd3906591861ab9ae8166a94a5414b4f0b418ecb235 = $this->env->getExtension("native_profiler");
        $__internal_29b4973bbffa73150f07fcd3906591861ab9ae8166a94a5414b4f0b418ecb235->enter($__internal_29b4973bbffa73150f07fcd3906591861ab9ae8166a94a5414b4f0b418ecb235_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Twig/Exception/exception_full.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_29b4973bbffa73150f07fcd3906591861ab9ae8166a94a5414b4f0b418ecb235->leave($__internal_29b4973bbffa73150f07fcd3906591861ab9ae8166a94a5414b4f0b418ecb235_prof);

    }

    // line 3
    public function block_head($context, array $blocks = array())
    {
        $__internal_38773317000142325f865771c3e1e0c0eec723344831e3f87000a969dbc5aeb2 = $this->env->getExtension("native_profiler");
        $__internal_38773317000142325f865771c3e1e0c0eec723344831e3f87000a969dbc5aeb2->enter($__internal_38773317000142325f865771c3e1e0c0eec723344831e3f87000a969dbc5aeb2_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "head"));

        // line 4
        echo "    <link href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('request')->generateAbsoluteUrl($this->env->getExtension('asset')->getAssetUrl("bundles/framework/css/exception.css")), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\" media=\"all\" />
";
        
        $__internal_38773317000142325f865771c3e1e0c0eec723344831e3f87000a969dbc5aeb2->leave($__internal_38773317000142325f865771c3e1e0c0eec723344831e3f87000a969dbc5aeb2_prof);

    }

    // line 7
    public function block_title($context, array $blocks = array())
    {
        $__internal_9485b8e641ef4c2adf4deb260730158e9824fa66ac79f96834dddf15d8238400 = $this->env->getExtension("native_profiler");
        $__internal_9485b8e641ef4c2adf4deb260730158e9824fa66ac79f96834dddf15d8238400->enter($__internal_9485b8e641ef4c2adf4deb260730158e9824fa66ac79f96834dddf15d8238400_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        // line 8
        echo "    ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["exception"]) ? $context["exception"] : $this->getContext($context, "exception")), "message", array()), "html", null, true);
        echo " (";
        echo twig_escape_filter($this->env, (isset($context["status_code"]) ? $context["status_code"] : $this->getContext($context, "status_code")), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, (isset($context["status_text"]) ? $context["status_text"] : $this->getContext($context, "status_text")), "html", null, true);
        echo ")
";
        
        $__internal_9485b8e641ef4c2adf4deb260730158e9824fa66ac79f96834dddf15d8238400->leave($__internal_9485b8e641ef4c2adf4deb260730158e9824fa66ac79f96834dddf15d8238400_prof);

    }

    // line 11
    public function block_body($context, array $blocks = array())
    {
        $__internal_c74df5b02420bdf7f6d6032716278953aeb1bf05ef5942c7697d23a109a498cf = $this->env->getExtension("native_profiler");
        $__internal_c74df5b02420bdf7f6d6032716278953aeb1bf05ef5942c7697d23a109a498cf->enter($__internal_c74df5b02420bdf7f6d6032716278953aeb1bf05ef5942c7697d23a109a498cf_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 12
        echo "    ";
        $this->loadTemplate("@Twig/Exception/exception.html.twig", "@Twig/Exception/exception_full.html.twig", 12)->display($context);
        
        $__internal_c74df5b02420bdf7f6d6032716278953aeb1bf05ef5942c7697d23a109a498cf->leave($__internal_c74df5b02420bdf7f6d6032716278953aeb1bf05ef5942c7697d23a109a498cf_prof);

    }

    public function getTemplateName()
    {
        return "@Twig/Exception/exception_full.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  78 => 12,  72 => 11,  58 => 8,  52 => 7,  42 => 4,  36 => 3,  11 => 1,);
    }
}
/* {% extends '@Twig/layout.html.twig' %}*/
/* */
/* {% block head %}*/
/*     <link href="{{ absolute_url(asset('bundles/framework/css/exception.css')) }}" rel="stylesheet" type="text/css" media="all" />*/
/* {% endblock %}*/
/* */
/* {% block title %}*/
/*     {{ exception.message }} ({{ status_code }} {{ status_text }})*/
/* {% endblock %}*/
/* */
/* {% block body %}*/
/*     {% include '@Twig/Exception/exception.html.twig' %}*/
/* {% endblock %}*/
/* */
