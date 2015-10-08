<?php

/**
 * This is the model class for table "error_realization".
 *
 * The followings are the available columns in table 'error_realization':
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
 * @property string $description
 */
class ErrorRealization extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'error_realization';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('description', 'required'),
			array('total_spm, ppn, pph', 'numerical'),
			array('packageAccount_code, package_code, spm_number, nrk, nrs', 'length', 'max'=>256),
			array('up_ls', 'length', 'max'=>2),
			array('receiver', 'length', 'max'=>13),
			array('spm_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, packageAccount_code, package_code, up_ls, spm_number, spm_date, total_spm, ppn, pph, receiver, nrk, nrs, description', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'packageAccount_code' => 'Package Account Code',
			'package_code' => 'Package Code',
			'up_ls' => 'UP/LS',
			'spm_number' => 'Spm Number',
			'spm_date' => 'Spm Date',
			'total_spm' => 'Total Spm',
			'ppn' => 'Ppn',
			'pph' => 'Pph',
			'receiver' => 'Receiver',
			'nrk' => 'Nomor Register Kontrak',
			'nrs' => 'Nomor Register Suplier',
			'description' => 'Keterangan',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('packageAccount_code',$this->packageAccount_code,true);
		$criteria->compare('package_code',$this->package_code,true);
		$criteria->compare('up_ls',$this->up_ls,true);
		$criteria->compare('spm_number',$this->spm_number,true);
		$criteria->compare('spm_date',$this->spm_date,true);
		$criteria->compare('total_spm',$this->total_spm);
		$criteria->compare('ppn',$this->ppn);
		$criteria->compare('pph',$this->pph);
		$criteria->compare('receiver',$this->receiver,true);
		$criteria->compare('nrk',$this->nrk,true);
		$criteria->compare('nrs',$this->nrs,true);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ErrorRealization the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
