<?php

class VAuth extends CComponent {

    /**
     * to generate users by group    
     */
    public static function getUsers($group_id = null) {
        //set group id from getGroupId if there is no input from param
        if (!$group_id)
            $group_id = self::getGroupId();

        //if group_id return null, then return null array
        if (!$group_id)
            return array('');

        $models = User::model()->findAllByAttributes(array(
            'group_id' => $group_id,
                ));

        $data = array();
        $i = 0;
        foreach ($models as $model) {
            $data[$i] = $model->username;
            $i++;
        }
        return $data;
    }

    /**
     * to get list of actions by classname and group id
     */
    public static function getActions($group_id = null, $className = 'default') {
        //set group id from getGroupId if there is no input from param
        if (!$group_id)
            $group_id = self::getGroupId();

        //if group_id return null, then return null array
        if (!$group_id)
            return array('');

        $model = GroupAuth::model()->findByAttributes(array(
                    'className' => $className,
                    'group_id' => $group_id,
                ))->action;

        $model = trim($model);

        $arrayModels = explode(',', $model);
        $data = array();

        for ($i = 0; $i < sizeof($arrayModels); $i++) {
            $data[$i] = $arrayModels[$i];
        }
        return $data;
    }

    /**
     * to get user by login id
     */
    public static function getGroupId() {
        $user_id = Yii::app()->user->id;

        if ($user_id)
            return User::model()->findByPk($user_id)->group_id;
    }

    public function getAuthActions($className = 'default') {
        $group_id = 3; //3 is @ users

        $model = GroupAuth::model()->findByAttributes(array(
                    'className' => $className,
                    'group_id' => $group_id,
                ))->action;

        $model = trim($model);

        $arrayModels = explode(',', $model);
        $data = array();

        for ($i = 0; $i < sizeof($arrayModels); $i++) {
            $data[$i] = $arrayModels[$i];
        }
        return $data;
    }

    public function getAdminActions($className = 'default') {
        $group_id = 2; //2 is admin users

        $model = GroupAuth::model()->findByAttributes(array(
                    'className' => $className,
                    'group_id' => $group_id,
                ))->action;

        $model = trim($model);

        $arrayModels = explode(',', $model);
        $data = array();

        for ($i = 0; $i < sizeof($arrayModels); $i++) {
            $data[$i] = $arrayModels[$i];
        }
        return $data;
    }

    public function getDeveloperActions($className = 'default') {
        $group_id = 1; //1 is developer users

        $model = GroupAuth::model()->findByAttributes(array(
                    'className' => $className,
                    'group_id' => $group_id,
                ))->action;

        $model = trim($model);

        $arrayModels = explode(',', $model);
        $data = array();

        for ($i = 0; $i < sizeof($arrayModels); $i++) {
            $data[$i] = $arrayModels[$i];
        }
        return $data;
    }

    public function getAdminUsers($group_id) {
        $models = User::model()->findAllByAttributes(array(
            'group_id' => $group_id,
                ));

        $data = array();
        $i = 0;
        foreach ($models as $model) {
            $data[$i] = $model->username;
            $i++;
        }
        return $data;
    }

    public static function getAccessRules($group_id = 2, $className = 'default') {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => $this->getAuthActions($className),
                'users' => array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => $this->getAdminActions($className),
                'users' => $this->getAdminUsers($group_id),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

}
