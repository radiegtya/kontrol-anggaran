<?php

/**
 * This is the model class for table "group_auth".
 *
 * The followings are the available columns in table 'group_auth':
 * @property integer $id
 * @property string $className
 * @property string $action
 * @property integer $group_id
 *
 * The followings are the available model relations:
 * @property Group $group
 */
class GroupAuth extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return GroupAuth the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'group_auth';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('className, action', 'required'),
            array('group_id', 'numerical', 'integerOnly' => true),
            array('className', 'length', 'max' => 64),
            array('action', 'length', 'max' => 256),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, className, action, group_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'group' => array(self::BELONGS_TO, 'Group', 'group_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'className' => 'Class Name',
            'action' => 'Action',
            'group_id' => 'Group',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('className', $this->className, true);
        $criteria->compare('action', $this->action, true);
        $criteria->compare('group_id', $this->group_id);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

}