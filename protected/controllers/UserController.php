<?php

Yii::import('ext.auth.VAuth');

class UserController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    public $title = 'User';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return VAuth::getAccessRules('user', array());
    }

    public function actionUpdatePassword($id) {
        $this->title = 'Update Password';
        $model = User::model()->findByPk($id);

        if (isset($_POST['User'])) {
            if (md5($_POST['User']['current_password']) == $model->password && $_POST['User']['new_password'] == $_POST['User']['confirm_new_password']) {
                $model->attributes = $_POST['User'];
                $model->password = md5($_POST['User']['new_password']);
                if ($model->update()) {
                    Yii::app()->user->setFlash('success', 'Password berhasil diupdate.');
                    $this->redirect(array('profile', 'id' => $model->id));
                }
            } elseif (md5($_POST['User']['current_password']) !== $model->password) {
                Yii::app()->user->setFlash('error', 'Password salah');
            } elseif ($_POST['User']['new_password'] !== $_POST['User']['confirm_new_password']) {
                Yii::app()->user->setFlash('error', 'Konfirmasi password baru harus cocok');
            }
        }
        $this->render('updatePassword', array(
            'model' => $model,
        ));
    }

    public function actionUpdateAuth($id) {
        $this->title = 'Update Hak Akses';
        $currentUserId = Yii::app()->user->id;
        $user = User::model()->findByPk($currentUserId);
        $currentUserGroupId = $user->group_id;
        $model = User::model()->findByPk($id);
        if ($currentUserId == $model->id) {
            Yii::app()->user->setFlash('error', 'Tidak dapat mengubah hak akses diri sendiri.');
            $this->redirect(array('admin'));
        } else {
            if (isset($_POST['User'])) {
                if ($model->group->id > $currentUserGroupId) {
                    Yii::app()->user->setFlash('error', 'Level user Anda tidak cukup untuk melakukan operasi ini.');
                    $this->redirect(array('admin'));
                }
                $model->attributes = $_POST['User'];
                $model->group_id = $_POST['User']['group_id'];
                if ($model->update()) {
                    Yii::app()->user->setFlash('success', 'Hak akses berhasil diupdate.');
                    $this->redirect(array('profile', 'id' => $model->id));
                }
            }
        }
        $this->render('updateAuth', array(
            'model' => $model,
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionProfile($id) {
        $this->title = 'Profil User';
        $model = $this->loadModel($id);
        $userId = Yii::app()->user->id;
        $user = User::model()->findByPk($userId);
        $role = $user->group->name;
        $this->render('profile', array(
            'model' => $model,
            'role' => $role,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $this->title = 'Tambah User';
        $model = new User;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '<strong>Success!</strong> Data saved.');
                $this->redirect(array('profile', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $this->title = 'Update User';
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            $model->username = $_POST['User']['username'];
            if ($model->update()) {
                Yii::app()->user->setFlash('success', 'Username berhasil diupdate');
                $this->redirect(array('profile', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $loginUser = Yii::app()->user->id;
        $targetUser = User::model()->findByPK($id);
        if ($loginUser > $targetUser->id) {
            Yii::app()->user->setFlash('error', 'Tidak dapat menghapus user dengan hak akses lebih tinggi.');
        } else {
            $this->loadModel($id)->delete();
        }

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('User');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $this->title = 'Daftar User';
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['User']))
            $model->attributes = $_GET['User'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = User::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
