<?php

/**
 * This is the model class for table "package_account".
 *
 * The followings are the available columns in table 'package_account':
 * @property integer $id
 * @property string $code
 * @property string $satker_code
 * @property string $activity_code
 * @property string $output_code
 * @property string $suboutput_code
 * @property string $component_code
 * @property string $package_code
 * @property string $account_code
 * @property string $budget_code
 * @property string $province_code
 * @property string $city_code
 * @property string $ppk_code
 * @property double $limit
 * @property string $up
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * The followings are the available model relations:
 * @property User $createdBy
 * @property User $updatedBy
 */
class PackageAccount extends VAbstractActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'package_account';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('limit', 'numerical'),
            array('province_code, city_code, code, satker_code, activity_code, output_code, suboutput_code, component_code, package_code, account_code, ppk_code', 'length', 'max' => 256),
            array('created_at, updated_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, code, satker_code, activity_code, output_code, suboutput_code, component_code, package_code, account_code, province_code, city_code, ppk_code, limit, created_at, created_by, updated_at, updated_by', 'safe', 'on' => 'search'),
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
            'satker' => array(self::BELONGS_TO, 'Satker', array('satker_code' => 'code')),
            'activity' => array(self::BELONGS_TO, 'Activity', array('activity_code' => 'code')),
            'output' => array(self::BELONGS_TO, 'Output', array('output_code' => 'code')),
            'suboutput' => array(self::BELONGS_TO, 'Suboutput', array('suboutput_code' => 'code')),
            'component' => array(self::BELONGS_TO, 'Component', array('component_code' => 'code')),
            'package' => array(self::BELONGS_TO, 'Package', array('package_code' => 'code')),
            'account' => array(self::BELONGS_TO, 'Account', array('account_code' => 'code')),
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
            'code' => 'Kode Akun Paket',
            'satker_code' => 'Satker',
            'activity_code' => 'Kegiatan',
            'output_code' => 'Output',
            'suboutput_code' => 'Suboutput',
            'component_code' => 'Komponen',
            'package_code' => 'Paket',
            'account_code' => 'Akun',
            'province_code' => 'Provinsi',
            'city_code' => 'Kota',
            'ppk_code' => 'PPK',
            'limit' => 'Pagu',
            'up' => 'Up',
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
        $criteria->compare('package_code', $this->package_code, true);
        $criteria->compare('account_code', $this->account_code, true);
        $criteria->compare('province_code', $this->province_code);
        $criteria->compare('city_code', $this->city_code);
        $criteria->compare('ppk_code', $this->ppk_code, true);
        $criteria->compare('limit', $this->limit);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('updated_at', $this->updated_at, true);
        $criteria->compare('updated_by', $this->updated_by);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchPackage($code) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->condition = "package_code='$code'";

        $criteria->compare('id', $this->id);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('satker_code', $this->satker_code, true);
        $criteria->compare('activity_code', $this->activity_code, true);
        $criteria->compare('output_code', $this->output_code, true);
        $criteria->compare('suboutput_code', $this->suboutput_code, true);
        $criteria->compare('component_code', $this->component_code, true);
        $criteria->compare('account_code', $this->account_code, true);
        $criteria->compare('province_code', $this->province_code);
        $criteria->compare('city_code', $this->city_code);
        $criteria->compare('ppk_code', $this->ppk_code, true);
        $criteria->compare('limit', $this->limit);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('updated_at', $this->updated_at, true);
        $criteria->compare('updated_by', $this->updated_by);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PackageAccount the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getPackageAccount() {
        $models = PackageAccount::model()->findAll();
        $options = array();
        if ($models) {
            foreach ($models as $model) {
                $name = $model->package->name;
                $options[$model->code] = "$name" . " | " . "$model->account_code";
            }
        }
        return $options;
    }

    public function getTotal($code) {
        $totalRealization = 0;
        $totalRestMoney = 0;
        $usingRate = 0;
//        Calculate total realization for each package
        $models = Realization::model()->findAllByAttributes(array('packageAccount_code' => "$code"));
        foreach ($models as $model) {
            $totalRealization +=$model->total_spm;
        }
        //        Calculate total realization for each package
        //Get Package Limit
        $paket = PackageAccount::model()->findByAttributes(array('code' => "$code"));
        $limit = $paket->limit;
        //Get Package Limit


        $totalRestMoney = $limit - $totalRealization;
        $rate = $totalRealization / $limit;
        $usingRate = round($rate, 4);

        return array(
            'realization' => $totalRealization,
            'restMoney' => $totalRestMoney,
            'rate' => $usingRate,
        );
    }

    public function summary($packageCode) {
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

    public function overlimit($code, $newRealization) {
        $overlimit = FALSE;
        $realized = 0;
        $limit = 0;
        $packageAccount = PackageAccount::model()->findByAttributes(array('code' => "$code"));
        if ($packageAccount) {
            $limit = $packageAccount->limit;
        }
        $realization = Realization::model()->findAllByAttributes(array('packageAccount_code' => "$code"));
        if ($realization) {
            foreach ($realization as $data) {
                $realized+=$data->total_spm;
            }
        }
        $temporaySummary = $realized + $newRealization;
        if ($temporaySummary > $limit) {
            $overlimit = TRUE;
        }
        return $overlimit;
    }

}
