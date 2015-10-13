<?php

/**
 * This is the model class for table "subcomponent".
 *
 * The followings are the available columns in table 'subcomponent':
 * @property integer $id
 * @property string $code
 * @property string $component_code
 * @property string $name
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class Subcomponent extends VAbstractActiveRecord {

    public $file;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'subcomponent';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('output_code, suboutput_code, code, component_code, name', 'required'),
            array('created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('satker_code, activity_code, code, output_code, suboutput_code, component_code, name', 'length', 'max' => 256),
            array('created_at, updated_at', 'safe'),
            array('file', 'file', 'types' => 'xls,xlsx', 'allowEmpty' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, satker_code, activity_code, code, output_code, suboutput_code, component_code, name, created_at, created_by, updated_at, updated_by', 'safe', 'on' => 'search'),
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
            'satker' => array(self::BELONGS_TO, 'Satker', array('satker_code' => 'code')),
            'activity' => array(self::BELONGS_TO, 'Activity', array('activity_code' => 'code')),
            'outputCode' => array(self::BELONGS_TO, 'Output', array('output_code' => 'code')),
            'suboutputCode' => array(self::BELONGS_TO, 'Suboutput', array('suboutput_code' => 'code')),
            'componentCode' => array(self::BELONGS_TO, 'Component', array('component_code' => 'code')),
            'package' => array(self::HAS_MANY, 'Package', array('name' => 'code')),
            'createdBy' => array(self::BELONGS_TO, 'User', 'created_by'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'code' => 'Kode Subkomponen',
            'satker_code' => 'Satker',
            'activity_code' => 'Kegiatan',
            'output_code' => 'Output',
            'suboutput_code' => 'Suboutput',
            'component_code' => 'Komponen',
            'name' => 'Nama Subkomponen',
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
        $criteria->compare('satker_code', $this->satker_code);
        $criteria->compare('activity_code', $this->activity_code);
        $criteria->compare('output_code', $this->output_code);
        $criteria->compare('suboutput_code', $this->suboutput_code);
        $criteria->compare('component_code', $this->component_code);
        $criteria->compare('name', $this->name, true);
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
     * @return Subcomponent the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getSubcomponentOptions() {
        $models = Subcomponent::model()->findAll();
        $options = array();
        foreach ($models as $model) {
            $options[$model->code] = "[$model->code] | $model->name";
        }
        return $options;
    }
     public function getNonUsedOnPackage() {
        $models = Subcomponent::model()->findAllBySql("SELECT subcomponent.* FROM subcomponent LEFT JOIN package ON package.code=subcomponent.code WHERE package.code IS NULL");

        $options = array();
        foreach ($models as $model) {
            $options[$model->code] = "[$model->code] | $model->name";
        }
        return $options;
    }

    public function getSubcomponentOptions2() {
        $packages = Package::model()->findAll();
        $code = '';
        foreach ($packages as $package) {
            $code .=$package->code . ';';
        }
        $code = explode(";", $code);
        $models = Subcomponent::model()->findAll(
                
                );
        
        $options = array();
        foreach ($models as $model) {
            $options[$model->id] = "[$model->code] | $model->name";
        }
        return $options;
    }

    public function getTotal($code) {
        $totalRealization = 0;
        $totalRestMoney = 0;
        $models = Package::model()->findAllByAttributes(array('name' => $code));
        foreach ($models as $model) {
            $totalRealization +=$model->getTotal($model->code)['realization'];
            $totalRestMoney +=$model->getTotal($model->code)['restMoney'];
        }
    }

}
