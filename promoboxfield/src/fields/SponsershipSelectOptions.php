<?php

namespace craftcmspromobox\promoboxfield\fields;
use craftcmspromobox\promoboxfield\PromoBoxField;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\fields\data\OptionData;
use craft\fields\data\MultiOptionsFieldData;
use craft\fields\data\SingleOptionFieldData;
use craft\helpers\Db;
use yii\db\Schema;
use craft\helpers\Json;
use craft\db\Query;

class SponsershipSelectOptions extends Field
{
    public $options;
    public $whitelistedSections;

    protected $multi=true;


    /**
     * @inheritdoc
     */

    public function init()
    {
        parent::init();
        $this->options = $this->translatedOptions();
    }


    /**
     * @inheritdoc
     */

    public function getContentColumnType(): string
    {
        if ($this->multi) {
            // See how much data we could possibly be saving if everything was selected.
            $length = 0;

            if ($this->options) {
                foreach ($this->options as $option) {
                    if (!empty($option['value'])) {
                        // +3 because it will be json encoded. Includes the surrounding quotes and comma.
                        $length += strlen($option['value']) + 3;
                    }
                }
            }

            // Add +2 for the outer brackets and -1 for the last comma.
            return Db::getTextualColumnTypeByContentLength($length + 1);
        }

        return Schema::TYPE_STRING;
    }

      /**
     * @inheritdoc
     */
    public function normalizeValue($value, ElementInterface $element = null)
    {
        if ($value instanceof MultiOptionsFieldData || $value instanceof SingleOptionFieldData) {
            return $value;
        }

        if (is_string($value)) {
            $value = Json::decodeIfJson($value);
        }

        // Normalize to an array
        $selectedValues = (array) $value;

        if ($this->multi) {
            // Convert the value to a MultiOptionsFieldData object
            $options = [];
            foreach ($selectedValues as $val) {
                $label = $this->optionLabel($val);
                $options[] = new OptionData($label, $val, true);
            }
            $value = new MultiOptionsFieldData($options);
        } else {
            // Convert the value to a SingleOptionFieldData object
            $value = reset($selectedValues) ?: null;
            $label = $this->optionLabel($value);
            $value = new SingleOptionFieldData($label, $value, true);
        }

        $options = [];

        if ($this->options) {
            foreach ($this->options as $option) {
                $selected = in_array($option['value'], $selectedValues, true);
                $options[] = new OptionData($option['label'], $option['value'], $selected);
            }
        }

        $value->setOptions($options);


        return $value;
    }

    /**
     * @inheritdoc
     */
    public function serializeValue($value, ElementInterface $element = null)
    {
        return parent::serializeValue($value, $element);
    }

      // Protected Methods
    // =========================================================================

    /**
     * Returns an option's label by its value.
     *
     * @param string|null $value
     * @return string|null
     */
    protected function optionLabel(string $value = null)
    {
        if ($this->options) {
            foreach ($this->options as $option) {
                if ($option['value'] == $value) {
                    return $option['label'];
                }
            }
        }

        return $value;
    }

    protected function translatedOptions()
    {
       $entries = (new Query)->select(['*'])->from(['entries'])
       ->join('INNER JOIN','content','content."elementId"=entries.id')
       ->join('INNER JOIN','sections','sections.id=entries."sectionId"')
       ->join('INNER JOIN','elements_sites','elements_sites.id=entries.id')
       ->where(['handle'=>$this->whitelistedSections])
       ->all();

       $entriesList=[];
       foreach($entries as $entry){
           //if need more, add behind $entry['id']
           $entriesList[$entry['id']]=['value'=>json_encode(array_slice($entry, 0,5)),'label'=>$entry['title']];
       }

             usort($entriesList, function($a, $b) {
             return strcasecmp($a['label'], $b['label']);
         });
    
      return $entriesList;
    }

   


}