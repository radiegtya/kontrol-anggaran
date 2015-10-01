<?php

/**
 * This is the model class for table "up".
 *
 * The followings are the available columns in table 'up':
 * @property integer $id
 * @property string $number_of_letter
 * @property string $date_of_letter
 * @property double $total_up
 * @property string $package_data
 * @property string $package_limit
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class Up extends VAbstractActiveRecord {

    public $rateUsingUp;
    public $realization;
    public $restUp;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'up';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('number_of_letter, date_of_letter', 'required'),
            array('number_of_letter', 'unique'),
            array('created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('total_up', 'numerical'),
            array('number_of_letter', 'length', 'max' => 256),
            array('description,created_at, updated_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, number_of_letter, date_of_letter, total_up, created_at, created_by, updated_at, updated_by', 'safe', 'on' => 'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'number_of_letter' => 'Nomor Surat',
            'date_of_letter' => 'Tanggal Surat',
            'total_up' => 'Jumlah UP/TUP',
            'rateUsingUp' => 'Penyerapan UP',
            'realization' => 'Realisasi UP',
            'restUp' => 'Sisa UP',
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
        $criteria->compare('number_of_letter', $this->number_of_letter, true);
        $criteria->compare('date_of_letter', $this->date_of_letter, true);
        $criteria->compare('total_up', $this->total_up);
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
     * @return Up the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getTotalBalance($numberLetter, $dateLetter) {
        $totalBalance = 0;
        $totalRealization = 0;
        $models = UP::model()->findAllByAttributes(array('number_of_letter' => $numberLetter, 'date_of_letter' => $dateLetter));

        foreach ($models as $model) {
            $totalBalance +=$model->total_up;
        }

        $realizations = Realization::model()->findAllByAttributes(array('use_up' => 'UP'));
        foreach ($realizations as $realization) {
            $totalRealization +=$realization->total_spm;
        }

        $totalCurrentBalance = $totalBalance - $totalRealization;

        $rate = $totalRealization / $totalBalance;
        $rate = round($rate, 4);
        return array(
            'realization' => $totalRealization,
            'restUp' => $totalCurrentBalance,
            'rateUsingUp' => $rate,
        );
    }

    public function getTotal($number) {
//        $totalBalance = 0;
        $models = UP::model()->findByAttributes(array('number_of_letter' => $number));

//        foreach ($models as $model) {
        $totalBalance = $models->total_up;
//        }

        $realizations = Realization::model()->findAllByAttributes(array('use_up' => 'UP', 'number_of_letter' => "$number"));
        $totalRealization = 0;
        if ($realizations) {
            foreach ($realizations as $realization) {
                $totalRealization +=$realization->total_spm;
            }
        }
        $totalCurrentBalance = $totalBalance - $totalRealization;
        $rate = $totalRealization / $totalBalance;
        $rate = round($rate, 4);
        return array(
            'realization' => $totalRealization,
            'restUp' => $totalCurrentBalance,
            'rateUsingUp' => $rate,
        );
    }

    public function getUpOptions() {
        $models = Up::model()->findAll();
        $options = array();
        foreach ($models as $model) {
            $subcomponent = Subcomponent::model()->findByAttributes(array('code' => $model->number_of_letter));
            $options[$model->number_of_letter] = "$model->number_of_letter";
        }
        return $options;
    }

}
