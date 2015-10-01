<?php

/**
 * This is the model class for table "budget_temp".
 *
 * The followings are the available columns in table 'budget_temp':
 * @property integer $id
 * @property string $code
 * @property integer $dipa_id
 * @property string $budget_year
 * @property string $satker_code
 * @property string $activity_code
 * @property string $output_code
 * @property string $suboutput_code
 * @property string $component_code
 * @property string $subcomponent_code
 * @property string $account_code
 * @property double $total_budget_limit
 * @property string $realization_status
 * @property string $structure_status
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class BudgetTemp extends VAbstractActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'budget_temp';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
//            array('dipa_id, realization_status, structure_status', 'required'),
            array('created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('total_budget_limit', 'numerical'),
            array('code, satker_code, activity_code, output_code, suboutput_code, component_code, subcomponent_code, account_code', 'length', 'max' => 256),
            array('budget_year', 'length', 'max' => 4),
//            array('realization_record', 'length', 'max' => 12),
            array('created_at, updated_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, code, budget_year, satker_code, activity_code, output_code, suboutput_code, component_code, subcomponent_code, account_code, total_budget_limit, created_at, created_by, updated_at, updated_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'code' => 'Code',
            'budget_year' => 'Budget Year',
            'satker_code' => 'Satker Code',
            'activity_code' => 'Activity Code',
            'output_code' => 'Output Code',
            'suboutput_code' => 'Suboutput Code',
            'component_code' => 'Component Code',
            'subcomponent_code' => 'Subcomponent Code',
            'account_code' => 'Account Code',
            'total_budget_limit' => 'Total Budget Limit',
            'realization_record' => 'Data Realisasi',
            'has_error' => 'Ada Error',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
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
        $criteria->compare('budget_year', $this->budget_year, true);
        $criteria->compare('satker_code', $this->satker_code, true);
        $criteria->compare('activity_code', $this->activity_code, true);
        $criteria->compare('output_code', $this->output_code, true);
        $criteria->compare('suboutput_code', $this->suboutput_code, true);
        $criteria->compare('component_code', $this->component_code, true);
        $criteria->compare('subcomponent_code', $this->subcomponent_code, true);
        $criteria->compare('account_code', $this->account_code, true);
        $criteria->compare('total_budget_limit', $this->total_budget_limit);
        $criteria->compare('realization_record', $this->realization_record, true);
        $criteria->compare('has_error', $this->has_error, true);
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
     * @return BudgetTemp the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
