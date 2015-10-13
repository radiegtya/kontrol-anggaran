<?php

class VEnum extends CHtml {

    public static function getEnumOptions($model, $attribute) {
        $attr = $attribute;
        self::resolveName($model, $attr);
        preg_match('/\((.*)\)/', $model->tableSchema->columns[$attr]->dbType, $matches);
        foreach (explode(',', $matches[1]) as $value) {
            $value = str_replace("'", null, $value);
            $values[$value] = Yii::t('enumItem', $value);
        }

        return $values;
    }

    public static function enumDropDownList($model, $attribute, $htmlOptions) {
        return CHtml::activeDropDownList($model, $attribute, VEnum::getEnumOptions($model, $attribute), $htmlOptions);
    }

}
