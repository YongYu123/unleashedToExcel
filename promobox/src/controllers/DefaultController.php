<?php
/**
 * PromoBox plugin for Craft CMS 3.x
 *
 * fff
 *
 * @link      https://github.com/YongYu123
 * @copyright Copyright (c) 2018 YongYu
 */

namespace craftcmspromobox\promobox\controllers;

use craftcmspromobox\promobox\PromoBox;

use Craft;
use craft\base\Element;
use craft\base\Section;
use craft\web\Controller;

/**
 * Default Controller
 *
 * Generally speaking, controllers are the middlemen between the front end of
 * the CP/website and your plugin’s services. They contain action methods which
 * handle individual tasks.
 *
 * A common pattern used throughout Craft involves a controller action gathering
 * post data, saving it on a model, passing the model off to a service, and then
 * responding to the request appropriately depending on the service method’s response.
 *
 * Action methods begin with the prefix “action”, followed by a description of what
 * the method does (for example, actionSaveIngredient()).
 *
 * https://craftcms.com/docs/plugins/controllers
 *
 * @author    YongYu
 * @package   PromoBox
 * @since     11
 */
class DefaultController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = ['index', 'do-something'];

    // Public Methods
    // =========================================================================

    /**
     * Handle a request going to our plugin's index action URL,
     * e.g.: actions/promo-box/default
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $result = 'Welcome to the DefaultController actionIndex() method';
    //    $section =  Craft::$app->getSections()->getEditableSections();
    //    $oneofSection = array_search('Hub',$section);
    //    $entry = Craft::$app->getEntries();
    $entry = Craft::$app->getSections()->getAllSections();
    $sections = array();
    foreach (Craft::$app->getSections()->getAllSections() as $section) {
        $sections[$section->id] =['handle'=>$section->handle, 'name' =>Craft::t('site',$section->name)];
    }
       dd($sections);
        return $result;
    }

    /**
     * Handle a request going to our plugin's actionDoSomething URL,
     * e.g.: actions/promo-box/default/do-something
     *
     * @return mixed
     */
    public function actionDoSomething()
    {
        $result = 'Welcome to the DefaultController actionDoSomething() method';
        dd(Craft::$app->getSections()->getEditableSections());
        return $result;
    }
}
