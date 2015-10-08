<?php

/**
 * This is the model class for table "dipa".
 *
 * The followings are the available columns in table 'dipa':
 * @property integer $id
 * @property string $dipa_number
 * @property string $dipa_date
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * The followings are the available model relations:
 * @property User $createdBy
 * @property User $updatedBy
 */
class Dipa extends VAbstractActiveRecord {

    public $file;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'dipa';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('dipa_date, type, dipa_number', 'required'),
            array('dipa_number', 'unique'),
            array('type', 'length', 'max' => 50),
            array('created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('budget_year', 'numerical', 'integerOnly' => true),
            array('dipa_number', 'length', 'max' => 256),
            array('dipa_date, created_at, updated_at', 'safe'),
            array('file', 'file', 'types' => 'xls,xlsx', 'allowEmpty' => false, 'on' => 'create'),
            array('file', 'file', 'types' => 'xls,xlsx', 'allowEmpty' => true, 'on' => 'update'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, dipa_number, budget_year,dipa_date, type, created_at, created_by, updated_at, updated_by', 'safe', 'on' => 'search'),
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
            'budget' => array(self::HAS_MANY, 'Dipa', 'dipa_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'budget_year' => 'Tahun Anggaran',
            'dipa_number' => 'Nomor DIPA/POK',
            'dipa_date' => 'Tanggal DIPA/POK',
            'type' => 'Jenis',
            'file' => 'File d_item.xls',
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
        $criteria->compare('budget_year', $this->budget_year);
        $criteria->compare('dipa_number', $this->dipa_number, true);
        $criteria->compare('dipa_date', $this->dipa_date, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('type', $this->type);
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
     * @return Dipa the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getDipaOptions() {
        return CHtml::listData($this->findAll(), 'id', 'dipa_number');
    }

    public function getTotal($id) {
        $budgets = Budget::model()->findAllByAttributes(array('dipa_id' => $id));
        $total = 0;
        if ($budgets) {
            foreach ($budgets as $budget) {
                $total +=$budget->total_budget_limit;
            }
        }
        return $total;
    }

}
