<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $last_login_time
 */
class User extends CActiveRecord {

    public $current_password;
    public $new_password;
    public $confirm_new_password;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username, password,', 'required'),
            array('current_password, new_password, confirm_new_password', 'required', 'on'=>'updatePassword'),
            array('group_id', 'numerical', 'integerOnly' => true),
            array('username', 'length', 'max' => 128),
            array('password', 'length', 'max' => 256),
            array('last_login_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, username, password, last_login_time', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'group' => array(self::BELONGS_TO, 'Group', 'group_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'last_login_time' => 'Last Login Time',
            'group_id' => 'Level User',
            'current_password' => 'Password Lama',
            'new_password' => 'Password Baru',
            'confirm_new_password' => 'Konfirmasi Password Baru',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('last_login_time', $this->last_login_time, true);
        $criteria->compare('group_id', $this->group_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function encrypt($password) {
        return md5($password);
    }

    public function afterValidate() {
        parent::afterValidate();
        $this->password = $this->encrypt($this->password);
    }

    public function getOptions() {
        return CHtml::listData($this->findAll(), 'id', 'username');
    }

}
