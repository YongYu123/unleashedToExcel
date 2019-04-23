<?php
/**
 * PromoBoxField plugin for Craft CMS 3.x
 *
 * promobox hub sponsorship
 *
 * @link      https://github.com/YongYu123
 * @copyright Copyright (c) 2018 YongYu
 */

namespace craftcmspromobox\promoboxfield;

use craftcmspromobox\promoboxfield\fields\SponsershipField as SponsershipField; 
use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\services\Fields;
use craft\events\RegisterComponentTypesEvent;
use craft\web\UrlManager;

use yii\base\Event;

/**
 * Class PromoBoxField
 *
 * @author    YongYu
 * @package   PromoBoxField
 * @since     0.0.1
 *
 */
class PromoBoxField extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var PromoBoxField
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '0.0.1';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;



        Event::on(
            Fields::class,
            Fields::EVENT_REGISTER_FIELD_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = SponsershipField::class;
            }
        );

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );

        Craft::info(
            Craft::t(
                'promo-box-field',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

}
