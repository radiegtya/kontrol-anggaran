<?php

/**
 * This is the model class for table "error_dipa".
 *
 * The followings are the available columns in table 'error_dipa':
 * @property integer $id
 * @property string $code
 * @property string $budget_year
 * @property string $satker_code
 * @property string $activity_code
 * @property string $output_code
 * @property string $suboutput_code
 * @property string $component_code
 * @property string $subcomponent_code
 * @property string $account_code
 * @property double $total_budget_limit
 * @property string $description
 */
class ErrorDipa extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'error_dipa';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('code', 'required'),
            array('total_budget_limit', 'numerical'),
            array('code, satker_code, activity_code, output_code, suboutput_code, component_code, subcomponent_code, account_code', 'length', 'max' => 256),
            array('budget_year', 'length', 'max' => 4),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, code, budget_year, satker_code, activity_code, output_code, suboutput_code, component_code, subcomponent_code, account_code, total_budget_limit, description', 'safe', 'on' => 'search'),
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
            'code' => 'Kode Akun Paket',
            'budget_year' => 'Tahun Anggaran',
            'satker_code' => 'Kode Satker',
            'activity_code' => 'Kode Kegiatan',
            'output_code' => 'Kode Output',
            'suboutput_code' => 'Kode Suboutput',
            'component_code' => 'Kode Komponen',
            'subcomponent_code' => 'Kode Subkomponen',
            'account_code' => 'Kode Akun',
            'total_budget_limit' => 'Total Anggaran',
            'description' => 'Keterangan Error',
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
        $criteria->compare('description', $this->description, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ErrorDipa the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
