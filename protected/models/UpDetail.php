<?php

/**
 * This is the model class for table "up_detail".
 *
 * The followings are the available columns in table 'up_detail':
 * @property integer $id
 * @property string $up_number_of_letter
 * @property string $package_name
 * @property double $limit
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * The followings are the available model relations:
 * @property User $createdBy
 * @property User $updatedBy
 */
class UpDetail extends VAbstractActiveRecord {

    public $restUp;
    public $rateUsingUp;
    public $realization;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'up_detail';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('package_code', 'required'),
            array('created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('limit', 'numerical'),
            array('up_number_of_letter, package_code', 'length', 'max' => 256),
            array('created_at, updated_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, up_number_of_letter, package_code, limit, created_at, created_by, updated_at, updated_by', 'safe', 'on' => 'search'),
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
            'package' => array(self::BELONGS_TO, 'Package', array('package_code' => 'code')),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'up_number_of_letter' => 'Nomor Surat UP',
            'package_code' => 'Kode Akun Paket',
            'limit' => 'Pagu',
            'realization' => 'Realisasi UP',
            'restUp' => 'Sisa UP',
            'rateUpUsing' => 'Penyerapan UP',
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
        $criteria->compare('up_number_of_letter', $this->up_number_of_letter);
        $criteria->compare('package_code', $this->package_code);
        $criteria->compare('limit', $this->limit);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('updated_at', $this->updated_at, true);
        $criteria->compare('updated_by', $this->updated_by);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'id DESC',
            ),
        ));
    }

    public function searchDetail($numberLetter) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->condition = "up_number_of_letter='$numberLetter'";
        $criteria->compare('id', $this->id);
        $criteria->compare('package_code', $this->package_code);
        $criteria->compare('limit', $this->limit);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('updated_at', $this->updated_at, true);
        $criteria->compare('updated_by', $this->updated_by);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'id DESC',
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UpDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getTotalDetail($code, $numberLetter) {
        $totalRealization = 0;
        $totalRestMoney = 0;
        $usingRate = 0;
        $models = Realization::model()->findAllByAttributes(array('package_code' => "$code", 'use_up' => 'UP', 'number_of_letter' => "$numberLetter"));
        foreach ($models as $model) {
            $totalRealization +=$model->total_spm;
        }

        $detail = UpDetail::model()->findByAttributes(array('package_code' => "$code", 'up_number_of_letter' => "$numberLetter"));
        $limit = $detail->limit;

        $totalRestMoney = $limit - $totalRealization;
        $rate = $totalRealization / $limit;
        $usingRate = round($rate, 4);

        return array(
            'realization' => $totalRealization,
            'restUp' => $totalRestMoney,
            'rateUpUsing' => $usingRate,
        );
    }

    public function getTotal($code) {
        $totalRealization = 0;
        $totalRestMoney = 0;
        $usingRate = 0;
        $models = Realization::model()->findAllByAttributes(array('package_code' => "$code", 'use_up' => 'UP'));
        foreach ($models as $model) {
            $totalRealization +=$model->total_spm;
        }

        $detail = UpDetail::model()->findByAttributes(array('package_name' => "$code"), array('order' => 'id DESC'));
        $limit = $detail->limit;

        $totalRestMoney = $limit - $totalRealization;
        $rate = $totalRealization / $limit;
        $usingRate = round($rate, 4);

        return array(
            'realization' => $totalRealization,
            'restUp' => $totalRestMoney,
            'rateUpUsing' => $usingRate,
        );
    }

}
