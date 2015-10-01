<?php

/**
 * This is the model class for table "nrk_detail".
 *
 * The followings are the available columns in table 'nrk_detail':
 * @property integer $id
 * @property string $nrk_contract_number
 * @property string $termin
 * @property double $limit_per_termin
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * The followings are the available model relations:
 * @property User $createdBy
 * @property User $updatedBy
 */
class NrkDetail extends VAbstractActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'nrk_detail';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('limit_per_termin', 'numerical'),
            array('nrk_register, nrk_contract_number', 'length', 'max' => 256),
            array('termin', 'length', 'max' => 2),
            array('created_at, updated_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, nrk_contract_number, termin, limit_per_termin, created_at, created_by, updated_at, updated_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'createdBy' => array(self::BELONGS_TO, 'User', 'created_by'),
            'updatedBy' => array(self::BELONGS_TO, 'User', 'updated_by'),
            'nrk' => array(self::BELONGS_TO, 'Nrk', array('nrk_register' => 'nrk')),
            'nrk' => array(self::BELONGS_TO, 'Nrk', array('nrk_contract_number' => 'contract_number')),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'nrk_register' => 'Nomor Register Kontrak',
            'nrk_contract_number' => 'Nomor Kontrak',
            'termin' => 'Termin',
            'limit_per_termin' => 'Pagu Termin',
            'created_at' => 'Dibuat',
            'created_by' => 'Oleh',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
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
        $criteria->compare('nrk_register', $this->nrk_register);
        $criteria->compare('nrk_contract_number', $this->nrk_contract_number);
        $criteria->compare('termin', $this->termin, true);
        $criteria->compare('limit_per_termin', $this->limit_per_termin);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('updated_at', $this->updated_at, true);
        $criteria->compare('updated_by', $this->updated_by);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
//            'sort' => array(
//                'defaultOrder' => 'id DESC',
//            ),
        ));
    }

    public function searchDetail($register, $number) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
//        $criteria->compare('nrk_register', $this->nrk_register);
        $criteria->condition = "nrk_register='$register'";
//        $criteria->compare('nrk_contract_number', $this->nrk_contract_number);
        $criteria->condition = "nrk_contract_number='$number'";
        $criteria->compare('termin', $this->termin);
        $criteria->compare('limit_per_termin', $this->limit_per_termin);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('updated_at', $this->updated_at, true);
        $criteria->compare('updated_by', $this->updated_by);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
//            'sort' => array(
//                'defaultOrder' => 'id DESC',
//            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return NrkDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
