<?php

namespace craftcmspromobox\promoboxfield\fields;

use craftcmspromobox\promoboxfield\PromoBoxField;
use Craft;
use craft\base\ElementInterface;
use craft\base\Field;

class SponsershipField extends SponsershipSelectOptions
{
	

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('promo-box-field', 'Hub-select');
    }

     /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->multi = true;
    }


    /**
	 * @inheritdoc
	 * @see craft\base\SavableComponentInterface
	 */
	public function getSettingsHtml(): string
	{
		
		return Craft::$app->getView()->renderTemplate(
			'promo-box-field/_settings',
			[
				'field' => $this,
				'sections' => $this->getSections(),
			]
		);
    }
    




    /**
     * @inheritdoc
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {

        // Get our id and namespace
        $id = Craft::$app->getView()->formatInputId($this->handle);
        $namespacedId = Craft::$app->getView()->namespaceInputId($id);
		
        // Render the input template
        return Craft::$app->getView()->renderTemplate(
            'promo-box-field/_multiselect',
            [
                'name' => $this->handle,
                'values' => $value,
                'field' => $this,
                'id' => $id,
                'namespacedId' => $namespacedId,
				'options' => $this->translatedOptions(),
            ]
        );
    }


    	/**
	 * Retrieves all sections in an id, name pair, suitable for the underlying options display.
	 */
	private function getSections() {
		$sections = array();
		foreach (Craft::$app->getSections()->getEditableSections() as $section) {
			$sections[$section->id] =['value'=>$section->handle, 'label' =>Craft::t('site',$section->name)];
		}
		return $sections;
	}
   
}