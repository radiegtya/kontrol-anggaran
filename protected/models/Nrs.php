<?php

/**
 * This is the model class for table "nrs".
 *
 * The followings are the available columns in table 'nrs':
 * @property integer $id
 * @property string $nrs
 * @property string $supplier_name
 * @property string $npwp
 * @property string $bank_name
 * @property string $bank_account_number
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class Nrs extends VAbstractActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'nrs';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nrs, supplier_name', 'required'),
            array('nrs, supplier_name', 'unique'),
            array('created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('nrs, supplier_name, npwp, bank_name, bank_account_number', 'length', 'max' => 256),
            array('created_at, updated_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, nrs, supplier_name, npwp, bank_name, bank_account_number, created_at, created_by, updated_at, updated_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'updatedBy' => array(self::BELONGS_TO, 'User', 'updated_by'),
            'createdBy' => array(self::BELONGS_TO, 'User', 'created_by'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'nrs' => 'Nomor Register Supplier',
            'supplier_name' => 'Nama Penyedia',
            'npwp' => 'NPWP',
            'bank_name' => 'Nama Bank',
            'bank_account_number' => 'Nomor Rekening Bank',
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
        $criteria->compare('nrs', $this->nrs, true);
        $criteria->compare('supplier_name', $this->supplier_name, true);
        $criteria->compare('npwp', $this->npwp, true);
        $criteria->compare('bank_name', $this->bank_name, true);
        $criteria->compare('bank_account_number', $this->bank_account_number, true);
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
     * @return Nrs the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getNrsOptions() {
        $models = Nrs::model()->findAll();
        $options = array();
        foreach ($models as $model) {
            $options[$model->id] = "[$model->nrs] | $model->supplier_name";
        }
        return $options;
    }

}
