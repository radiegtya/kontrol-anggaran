<?php

abstract class VAbstractActiveRecord extends CActiveRecord {

    /**
     * Prepares create_time, create_user_id, update_time and update_user_
      id attributes before performing validation.
     */
    protected function beforeValidate() {
        if ($this->isNewRecord) {
            if (!$this->created_at)
                $this->created_at = new CDbExpression('NOW()');
            if (!$this->updated_at)
                $this->updated_at = new CDbExpression('NOW()');
            $this->created_by = $this->updated_by = Yii::app()->user->id;
        } else {
            if (!$this->updated_at)
                $this->updated_at = new CDbExpression('NOW()');
            $this->updated_by = Yii::app()->user->id;
        }
        return parent::beforeValidate();
    }

    /*
     * populate dropdownList from db
     */

    public function getOptions() {
        return CHtml::listData($this->findAll(), 'id', 'name');
    }

    public function getOptionsCodeName() {
        return CHtml::listData($this->findAll(array('order'=>'id ASC')), 'code', 'name');
    }

}
