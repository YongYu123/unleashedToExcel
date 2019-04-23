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

}