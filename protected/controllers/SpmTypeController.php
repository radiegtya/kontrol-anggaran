<?php

class SpmTypeController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    public $title = 'Jenis SPM (Surat Perintah Membayar)';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return VAuth::getAccessRules('spm-type', array(''));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->title = 'Rincian Jenis SPM (Surat Perintah Membayar)';
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $this->title = 'Tambah Jenis SPM (Surat Perintah Membayar)';
        $model = new SpmType;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['SpmType'])) {
            $model->attributes = $_POST['SpmType'];

            //upload image
//            $VUpload = new VUpload();
//            $VUpload->path = 'images/spm-type/';
//            $VUpload->doUpload($model, 'image');

            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Data successfully created');
                //$this->redirect(array('view','id'=>$model->code));
                $this->redirect(array('admin'));
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
        $this->title = 'Update Jenis SPM (Surat Perintah Membayar)';
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['SpmType'])) {
            $model->attributes = $_POST['SpmType'];

            //upload file
//            $VUpload = new VUpload();
//            $VUpload->path = 'images/spm-type/';
//            $VUpload->doUpload($model, 'image');
//            if (!$model->image) { //if there is no image input
//                $model->image = SpmType::model()->findByPk($id)->image;
//            }

            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Data successfully updated');
                //$this->redirect(array('view','id'=>$model->code));
                $this->redirect(array('admin'));
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
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request			
            $model = $this->loadModel($id);
//            $VUpload = new VUpload();
//            $VUpload->path = 'images/spm-type/';
//            $VUpload->doDelete($model, 'image');
            $model->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('SpmType');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $this->title = 'Daftar Jenis SPM (Surat Perintah Membayar)';
        $model = new SpmType('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SpmType']))
            $model->attributes = $_GET['SpmType'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /*
     * edit data through view
     */

    public function actionEditable() {
        Yii::import('bootstrap.widgets.TbEditableSaver');
        $es = new TbEditableSaver('SpmType');
        $es->update();
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = SpmType::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model, $formId = 'spm-type-form') {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'spm-type-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function sendEmail() {
        $to1 = 'yourmail@host';

        $message = $this->renderPartial('/spm-type/sendEmail', array(''), true);
        $subject = '=?UTF-8?B?' . base64_encode('Anggaran') . '?=';
        $headers = 'From: $to1 <vlocorp>' . "\r\n";
        $headers .= 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        mail("<$to1>", $subject, $message, $headers);
    }

}
