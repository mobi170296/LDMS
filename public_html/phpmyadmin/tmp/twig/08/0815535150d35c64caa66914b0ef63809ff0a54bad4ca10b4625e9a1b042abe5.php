<?php

/* server/variables/variable_table_head.twig */
class __TwigTemplate_7f2846c8755c3f973f524b58e8b0dc9ca65c5fbc7085bbf0c8af3f7d6fc69929 extends Twig_Template
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
        echo "<thead>
    <tr class=\"var-header var-row\">
        <td class=\"var-action\">";
        // line 3
        echo _gettext("Action");
        echo "</td>
        <td class=\"var-name\">";
        // line 4
        echo _gettext("Variable");
        echo "</td>
        <td class=\"var-value\">";
        // line 5
        echo _gettext("Value");
        echo "</td>
    </tr>
</thead>
";
    }

    public function getTemplateName()
    {
        return "server/variables/variable_table_head.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  31 => 5,  27 => 4,  23 => 3,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "server/variables/variable_table_head.twig", "D:\\LDMS\\phpmyadmin\\templates\\server\\variables\\variable_table_head.twig");
    }
}
