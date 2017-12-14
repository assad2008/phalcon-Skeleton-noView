<?php

/* index.html */
class __TwigTemplate_3a6832cbdeb38d5b752845918f001d07a942093772c26df0f1abc5004b768bc2 extends Twig_Template
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
        // line 1
        echo "<!DOCTYPE html>
<html>
<head>
\t<title></title>
</head>
<body>

";
        // line 8
        echo twig_escape_filter($this->env, ($context["hello"] ?? null), "html", null, true);
        echo "
</body>
</html>";
    }

    public function getTemplateName()
    {
        return "index.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  28 => 8,  19 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("<!DOCTYPE html>
<html>
<head>
\t<title></title>
</head>
<body>

{{ hello }}
</body>
</html>", "index.html", "/www/wwwroot/phalcon.yeedev.xyz/src/views/index.html");
    }
}
