<?php

/**
 * This is the model class for table "budget".
 *
 * The followings are the available columns in table 'budget':
 * @property integer $id
 * @property integer $dipa_id
 * @property string $budget_year
 * @property string $satker_code
 * @property string $department_code
 * @property string $unit_code
 * @property string $program_code
 * @property string $activity_code
 * @property string $output_code
 * @property string $suboutput_code
 * @property string $component_code
 * @property string $subcomponent_code
 * @property string $account_code
 * @property double $total_budget_limit
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * The followings are the available model relations:
 * @property User $createdBy
 * @property User $updatedBy
 */
class Budget extends VAbstractActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'budget';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
//            array('dipa_id', 'required'),
            array('dipa_id, created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('total_budget_limit', 'numerical'),
            array('budget_year', 'length', 'max' => 4),
            array('satker_code, code, activity_code, output_code, suboutput_code, component_code, subcomponent_code, account_code', 'length', 'max' => 256),
            array('created_at, updated_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, dipa_id, budget_year, code, satker_code, activity_code, output_code, suboutput_code, component_code, subcomponent_code, account_code, total_budget_limit, created_at, created_by, updated_at, updated_by', 'safe', 'on' => 'search'),
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
            'dipa' => array(self::BELONGS_TO, 'Dipa', 'dipa_id'),
            'satker' => array(self::BELONGS_TO, 'Satker', array('satker_code' => 'code')),
            'activity' => array(self::BELONGS_TO, 'Activity', array('activity_code' => 'code')),
            'outputCode' => array(self::BELONGS_TO, 'Output', array('output_code' => 'code')),
            'suboutputCode' => array(self::BELONGS_TO, 'Suboutput', array('suboutput_code' => 'code')),
            'componentCode' => array(self::BELONGS_TO, 'Component', array('component_code' => 'code')),
            'subcomponentCode' => array(self::BELONGS_TO, 'Subcomponent', array('subcomponent_code' => 'code')),
            'accountCode' => array(self::BELONGS_TO, 'Account', array('account_code' => 'code')),
            'package' => array(self::HAS_ONE, 'Package', array('budget_code' => 'code')),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'code' => 'Kode Anggaran',
            'dipa_id' => 'DIPA',
            'budget_year' => 'Tahun Anggaran',
            'satker_code' => 'Satker',
            'activity_code' => 'Kegiatan',
            'output_code' => 'Output',
            'suboutput_code' => 'Suboutput',
            'component_code' => 'Komponen',
            'subcomponent_code' => 'Subkomponen',
            'account_code' => 'Akun',
            'total_budget_limit' => 'Jumlah',
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
        $criteria->compare('dipa_id', $this->dipa_id);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('budget_year', $this->budget_year, true);
        $criteria->compare('satker_code', $this->satker_code, true);
        $criteria->compare('activity_code', $this->activity_code);
        $criteria->compare('output_code', $this->output_code);
        $criteria->compare('suboutput_code', $this->suboutput_code);
        $criteria->compare('component_code', $this->component_code);
        $criteria->compare('subcomponent_code', $this->subcomponent_code);
        $criteria->compare('account_code', $this->account_code);
        $criteria->compare('total_budget_limit', $this->total_budget_limit, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('updated_at', $this->updated_at, true);
        $criteria->compare('updated_by', $this->updated_by);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'id DESC',
            ),
            'pagination' => array(
                'pageSize' => 30,
            )
        ));
    }

    public function searchBudget($id) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->condition = "dipa_id=$id";

//        $criteria->compare('dipa_id', $this->dipa_id);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('budget_year', $this->budget_year, true);
        $criteria->compare('satker_code', $this->satker_code, true);
        $criteria->compare('activity_code', $this->activity_code);
        $criteria->compare('output_code', $this->output_code);
        $criteria->compare('suboutput_code', $this->suboutput_code);
        $criteria->compare('component_code', $this->component_code);
        $criteria->compare('subcomponent_code', $this->subcomponent_code);
        $criteria->compare('account_code', $this->account_code);
        $criteria->compare('total_budget_limit', $this->total_budget_limit, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('updated_at', $this->updated_at, true);
        $criteria->compare('updated_by', $this->updated_by);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'id DESC',
            ),
            'pagination' => array(
                'pageSize' => 30,
            )
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Budget the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getBudgetOptions() {
        return CHtml::listData($this->findAll(), 'code', 'code');
    }

    public function getBudgetForDipaOptions() {
        $models = Budget::model()->findAll();
        $options = array();
        foreach ($models as $model) {
            $subcomponent = Subcomponent::model()->findByAttributes(array('code' => $model->subcomponent_code));
            if ($subcomponent) {
                $options[$model->code] = "[ $model->code ] | $subcomponent->name";
            } else {
                $options[$model->code] = "[ $model->code ]";
            }
        }
        return $options;
    }

}
