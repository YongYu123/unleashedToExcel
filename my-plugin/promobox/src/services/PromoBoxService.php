<?php
/**
 * PromoBox plugin for Craft CMS 3.x
 *
 * promobox test
 *
 * @link      https://github.com/YongYu123
 * @copyright Copyright (c) 2018 YongYu
 */

namespace pluginspromobox\promobox\services;

use pluginspromobox\promobox\PromoBox;

use Craft;
use craft\base\Component;

/**
 * PromoBoxService Service
 *
 * All of your plugin’s business logic should go in services, including saving data,
 * retrieving data, etc. They provide APIs that your controllers, template variables,
 * and other plugins can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    YongYu
 * @package   PromoBox
 * @since     0.0.1
 */
class PromoBoxService extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * This function can literally be anything you want, and you can have as many service
     * functions as you want
     *
     * From any other plugin file, call it like this:
     *
     *     PromoBox::$plugin->promoBoxService->exampleService()
     *
     * @return mixed
     */
    public function exampleService()
    {
        $result = 'something';
        // Check our Plugin's settings for `someAttribute`
        if (PromoBox::$plugin->getSettings()->someAttribute) {
        }

        return $result;
    }
}
