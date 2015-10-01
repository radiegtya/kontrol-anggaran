<?php

/**
 * This is the model class for table "account".
 *
 * The followings are the available columns in table 'account':
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class Account extends VAbstractActiveRecord {

    public $file;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'account';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('code, name', 'required', 'on' => 'create'),
            array('name', 'required', 'on' => 'update'),
            array('code', 'unique'),
            array('created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('code, name', 'length', 'max' => 256),
            array('created_at, updated_at', 'safe'),
            array('file', 'file', 'types' => 'xls,xlsx', 'allowEmpty' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, code, name, created_at, created_by, updated_at, updated_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'packages' => array(self::HAS_MANY, 'Package', 'account_code'),
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
            'code' => 'Kode Akun',
            'name' => 'Nama Akun',
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

//        $criteria->compare('id', $this->id);
//        $criteria->compare('code', $this->code, true);
        $criteria->compare('name', $this->name, true);
//        $criteria->compare('created_at', $this->created_at, true);
//        $criteria->compare('created_by', $this->created_by);
//        $criteria->compare('updated_at', $this->updated_at, true);
//        $criteria->compare('updated_by', $this->updated_by);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
//            'sort' => array(
//                'defaultOrder' => 'id DESC',
//            ),
            'pagination' => array(
                'pageSize' => 20,
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Account the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getAccountOptions() {
        $models = Account::model()->findAll();
        $options = array();
        foreach ($models as $model) {
            $options[$model->code] = "[$model->code] | $model->name";
        }
        return $options;
    }

}
