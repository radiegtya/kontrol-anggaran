<?php

/**
 * This is the model class for table "nrk".
 *
 * The followings are the available columns in table 'nrk':
 * @property integer $id
 * @property string $nrk
 * @property string $contract_number
 * @property string $contract_date
 * @property double $limit
 * @property double $term_of_limit
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class Nrk extends VAbstractActiveRecord {

    public $termin;
    public $limit_per_termin;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'nrk';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nrk, contract_number', 'required'),
            array('nrk', 'unique'),
            array('created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('limit', 'numerical'),
            array('nrk, contract_number', 'length', 'max' => 256),
            array('contract_date, created_at, updated_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, nrk, contract_number, contract_date, limit,created_at, created_by, updated_at, updated_by', 'safe', 'on' => 'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'nrk' => 'Nomor Register Kontrak',
            'contract_number' => 'Nomor Kontrak',
            'contract_date' => 'Tanggal Kontrak',
            'limit' => 'Pagu',
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
        $criteria->compare('nrk', $this->nrk, true);
        $criteria->compare('contract_number', $this->contract_number, true);
        $criteria->compare('contract_date', $this->contract_date, true);
        $criteria->compare('limit', $this->limit);
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
     * @return Nrk the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getNrkOptions() {
        $models = Nrk::model()->findAll();
        $options = array();
        foreach ($models as $model) {
            $options[$model->id] = "[$model->nrk] | $model->contract_number";
        }
        return $options;
    }

    public function getNrkNumberOptions() {
        $models = Nrk::model()->findAll();
        $options = array();
        foreach ($models as $model) {
            $options[$model->contract_number] = "$model->contract_number | $model->contract_date";
        }
        return $options;
    }

}
