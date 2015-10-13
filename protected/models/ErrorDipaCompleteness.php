<?php

/**
 * This is the model class for table "error_dipa_completeness".
 *
 * The followings are the available columns in table 'error_dipa_completeness':
 * @property integer $id
 * @property string $code
 * @property string $description
 */
class ErrorDipaCompleteness extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'error_dipa_completeness';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('code, description', 'required'),
            array('code', 'length', 'max' => 256),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, code, description', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'code' => 'Kode Subkomponen',
            'description' => 'Keterangan',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('description', $this->description, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ErrorDipaCompleteness the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
