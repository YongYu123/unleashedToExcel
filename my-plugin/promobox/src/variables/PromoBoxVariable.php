<?php
/**
 * PromoBox plugin for Craft CMS 3.x
 *
 * promobox test
 *
 * @link      https://github.com/YongYu123
 * @copyright Copyright (c) 2018 YongYu
 */

namespace pluginspromobox\promobox\variables;

use pluginspromobox\promobox\PromoBox;

use Craft;

/**
 * PromoBox Variable
 *
 * Craft allows plugins to provide their own template variables, accessible from
 * the {{ craft }} global variable (e.g. {{ craft.promoBox }}).
 *
 * https://craftcms.com/docs/plugins/variables
 *
 * @author    YongYu
 * @package   PromoBox
 * @since     0.0.1
 */
class PromoBoxVariable
{
    // Public Methods
    // =========================================================================

    /**
     * Whatever you want to output to a Twig template can go into a Variable method.
     * You can have as many variable functions as you want.  From any Twig template,
     * call it like this:
     *
     *     {{ craft.promoBox.exampleVariable }}
     *
     * Or, if your variable requires parameters from Twig:
     *
     *     {{ craft.promoBox.exampleVariable(twigValue) }}
     *
     * @param null $optional
     * @return string
     */
    public function exampleVariable($optional = null)
    {
        $result = "And away we go to the Twig template...";
        if ($optional) {
            $result = "I'm feeling optional today...";
        }
        return $result;
    }
}
