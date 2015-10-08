<?php

/**
 * This is the model class for table "package".
 *
 * The followings are the available columns in table 'package':
 * @property integer $id
 * @property string $code
 * @property string $satker_code
 * @property string $activity_code
 * @property string $output_code
 * @property string $suboutput_code
 * @property string $component_code
 * @property string $subcomponent_name
 * @property string $name
 * @property integer $province_code
 * @property integer $city_code
 * @property string $ppk_code
 * @property double $limit
 * @property string $up
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class Package extends VAbstractActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'package';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('code', 'unique'),
            array('code, province_code, city_code, satker_code, activity_code, output_code, suboutput_code, component_code, name, ppk_code', 'length', 'max' => 256),
            array('created_at, updated_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, code, satker_code, activity_code, output_code, suboutput_code, component_code, name, province_code, city_code, ppk_code, created_at, created_by, updated_at, updated_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'created_by'),
            'user' => array(self::BELONGS_TO, 'User', 'updated_by'),
            'satker' => array(self::BELONGS_TO, 'Satker', array('satker_code' => 'code')),
            'activity' => array(self::BELONGS_TO, 'Activity', array('activity_code' => 'code')),
            'output' => array(self::BELONGS_TO, 'Output', array('output_code' => 'code')),
            'suboutput' => array(self::BELONGS_TO, 'Suboutput', array('suboutput_code' => 'code')),
            'component' => array(self::BELONGS_TO, 'Component', array('component_code' => 'code')),
            'subcomponent' => array(self::BELONGS_TO, 'Subcomponent', array('code' => 'code')),
            'province' => array(self::BELONGS_TO, 'Province', array('province_code' => 'code')),
            'city' => array(self::BELONGS_TO, 'City', array('city_code' => 'code')),
            'ppk' => array(self::BELONGS_TO, 'Ppk', array('ppk_code' => 'code')),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'code' => 'Kode Paket',
            'satker_code' => 'Satker',
            'activity_code' => 'Kegiatan',
            'output_code' => 'Output',
            'suboutput_code' => 'Suboutput',
            'component_code' => 'Komponen',
            'name' => 'Nama Paket',
            'province_code' => 'Provinsi',
            'city_code' => 'Kota',
            'ppk_code' => 'PPK',
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
        $criteria->compare('code', $this->code, true);
        $criteria->compare('satker_code', $this->satker_code, true);
        $criteria->compare('activity_code', $this->activity_code, true);
        $criteria->compare('output_code', $this->output_code, true);
        $criteria->compare('suboutput_code', $this->suboutput_code, true);
        $criteria->compare('component_code', $this->component_code, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('province_code', $this->province_code);
        $criteria->compare('city_code', $this->city_code);
        $criteria->compare('ppk_code', $this->ppk_code, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('updated_at', $this->updated_at, true);
        $criteria->compare('updated_by', $this->updated_by);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20,
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Package the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getPackageOptions() {
        $models = Package::model()->findAll();
        $options = array();
        foreach ($models as $model) {
            $options[$model->code] = "[$model->code] | $model->name";
        }
        return $options;
    }

    public function getTotal($code) {
        $totalRealization = 0;
        $totalRestMoney = 0;
        $usingRate = 0;
//        Calculate total realization for each package
        $models = Realization::model()->findAllByAttributes(array('package_code' => "$code"));
        if ($models) {
            foreach ($models as $model) {
                $totalRealization +=$model->total_spm;
            }
        }
        //        Calculate total realization for each package
        //Get Package Limit
        $packageAccounts = PackageAccount::model()->findAllByAttributes(array('package_code' => "$code"));
        $limit = 0;
        if ($packageAccounts) {
            foreach ($packageAccounts as $data) {
                $limit +=$data->limit;
            }
        }
        //Get Package Limit


        $totalRestMoney = $limit - $totalRealization;
        $rate = $totalRealization / $limit;
        $usingRate = round($rate, 4);

        return array(
            'limit' => $limit,
            'realization' => $totalRealization,
            'restMoney' => $totalRestMoney,
            'rate' => $usingRate,
        );
    }

}
