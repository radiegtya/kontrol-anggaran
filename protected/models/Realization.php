<?php

/**
 * This is the model class for table "realization".
 *
 * The followings are the available columns in table 'realization':
 * @property integer $id
 * @property string $packageAccount_code
 * @property string $package_code
 * @property string $up_ls
 * @property string $spm_number
 * @property string $spm_date
 * @property double $total_spm
 * @property double $ppn
 * @property double $pph
 * @property string $receiver
 * @property string $nrk
 * @property string $nrs
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class Realization extends VAbstractActiveRecord {

    public $file;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'realization';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('total_spm, ppn, pph', 'numerical'),
            array('packageAccount_code, package_code, spm_number, nrk, nrs', 'length', 'max' => 256),
            array('up_ls', 'length', 'max' => 2),
            array('receiver', 'length', 'max' => 13),
            array('spm_date, created_at, updated_at', 'safe'),
            array('file', 'file', 'types' => 'xls,xlsx', 'allowEmpty' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, packageAccount_code, package_code, up_ls, spm_number, spm_date, total_spm, ppn, pph, receiver, nrk, nrs, created_at, created_by, updated_at, updated_by', 'safe', 'on' => 'search'),
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
            'package' => array(self::BELONGS_TO, 'Package', array('package_code' => 'code')),
            'packageAccount' => array(self::BELONGS_TO, 'PackageAccount', array('packageAccount_code' => 'code')),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'packageAccount_code' => 'Akun Paket',
            'package_code' => 'Paket Pekerjaan',
            'up_ls' => 'UP/LS',
            'spm_number' => 'Nomor SPM',
            'spm_date' => 'Tanggal SPM',
            'total_spm' => 'Jumlah SPM',
            'ppn' => 'PPN',
            'pph' => 'PPH',
            'receiver' => 'Penerima',
            'nrk' => 'Nomor Register Kontrak',
            'nrs' => 'Nomor Register Suplier',
            'created_at' => 'Dibuat Pada',
            'created_by' => 'Oleh',
            'updated_at' => 'Diupdate Pada',
            'updated_by' => 'Oleh',
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
        $criteria->compare('packageAccount_code', $this->packageAccount_code, true);
        $criteria->compare('package_code', $this->package_code, true);
        $criteria->compare('up_ls', $this->up_ls, true);
        $criteria->compare('spm_number', $this->spm_number, true);
        $criteria->compare('spm_date', $this->spm_date, true);
        $criteria->compare('total_spm', $this->total_spm);
        $criteria->compare('ppn', $this->ppn);
        $criteria->compare('pph', $this->pph);
        $criteria->compare('receiver', $this->receiver, true);
        $criteria->compare('nrk', $this->nrk, true);
        $criteria->compare('nrs', $this->nrs, true);
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
     * @return Realization2 the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
