<?php

class VAuth extends CWidget {

    /**
     * to get user by login id
     */
    public static function getGroupId() {
        $user_id = Yii::app()->user->id;

        if ($user_id)
            return User::model()->findByPk($user_id)->group_id;
    }

    /**
     * get actions system admin or another type user
     * @param int $group_id
     * @param type $className
     * @return type
     */
    public static function getActions($group_id, $className) {
        $group_id = 2; //2 is admin users        

        if ($group_id == 2)
            $model = GroupAuth::model()->find("className = '$className' AND group_id = $group_id OR group_id = 1")->action;
        elseif($group_id == 1)
            $model = GroupAuth::model()->find("className = '$className' AND group_id = $group_id")->action;

        $model = trim($model);

        $arrayModels = explode(',', $model);
        $data = array();

        for ($i = 0; $i < sizeof($arrayModels); $i++) {
            $data[$i] = $arrayModels[$i];
        }
        return $data;
    }

    /**
     * get users by group_id
     * @param type $group_id
     * @return type
     */
    public static function getUsers($group_id) {
        if ($group_id == 1) {
            $models = User::model()->findAllByAttributes(array(
                'group_id' => $group_id,
                    ));
        } elseif ($group_id == 2) {
            $models = User::model()->findAll("group_id = $group_id OR group_id = 1");
        }

        $data = array();
        $i = 0;
        foreach ($models as $model) {
            $data[$i] = $model->username;
            $i++;
        }
        return $data;
    }

    public static function getAccessRules($group_id = 2, $className = 'default', $defaultActions = null, $authActions = null) {
        $defaultActions = (!$defaultActions) ? array('index', 'view') : $defaultActions;
        $authActions = (!$authActions) ? array('create', 'update') : $authActions;

        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => $defaultActions,
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => $authActions,
                'users' => array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => self::getActions($group_id, $className),
                'users' => self::getUsers($group_id),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

}
