<?php

class NrkController extends Controller {

    public $title = 'Nomor Register Kontrak';

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

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
        return VAuth::getAccessRules('nrk', array('updateDetail'));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->title = 'Rincian NRK';
        $model = $this->loadModel($id);
        $register = $model->nrk;
        $number = $model->contract_number;
        $modelDetail = new NrkDetail('searchDetail');
        $modelDetail->unsetAttributes();  // clear any default values
        if (isset($_GET['NrkDetail'])) {
            $modelDetail->attributes = $_GET['NrkDetail'];
        }
        $detail = new NrkDetail;
        if (isset($_POST['NrkDetail'])) {
            $detail->attributes = $_POST['NrkDetail'];
            $detail->nrk_register = $model->nrk;
            $detail->nrk_contract_number = $model->contract_number;
            $detail->save();
        }
        $this->render('view', array(
            'model' => $model,
            'modelDetail' => $modelDetail,
            'number' => $number,
            'register' => $register,
            'addDetail' => $detail,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $this->title = 'Tambah NRK';
        $model = new Nrk;
        $models = array();
        for ($i = 0; $i < 12; $i++) {
            $models[] = new NrkDetail();
        }
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Nrk'])) {
            $model->attributes = $_POST['Nrk'];
            $pagu = 0;
            foreach ($models as $i => $modelDetail) {
                $pagu +=$_POST['NrkDetail'][$i]['limit_per_termin'];
            }
            $paguLimit = $_POST['Nrk']['limit'];
            $restMoney = $paguLimit - $pagu;
            print_r($restMoney);

            //check total equal of value
            if ($restMoney != 0) {
                Yii::app()->user->setFlash('error', 'Total Pagu Per Termin Harus Sama Dengan Total Pagu NRK');
                $this->redirect('create');
            }
            //end of check total equal of value
            $termin = 0;
            foreach ($models as $i => $modelDetail) {

                if (isset($_POST['NrkDetail'][$i])) {
                    $modelDetail->attributes = $_POST['NrkDetail'][$i];
                    $modelDetail->nrk_register = $_POST['Nrk']['nrk'];
                    $modelDetail->nrk_contract_number = $_POST['Nrk']['contract_number'];

//                    $modelDetail->termin = ++$termin;
                    if ($_POST['NrkDetail'][$i]['limit_per_termin'] != NULL) {
                        $modelDetail->save();
                    }
                }
            }
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Data successfully created');
                //$this->redirect(array('view','id'=>$model->id));
                $this->redirect(array('admin'));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'models' => $models,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $this->title = 'Update NRK';
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Nrk'])) {
            $model->attributes = $_POST['Nrk'];
            $details = NrkDetail::model()->findAllByAttributes(array('nrk_register' => $model->nrk, 'nrk_contract_number' => $model->contract_number));
            foreach ($details as $detail) {
                $detail->nrk_register = $_POST['Nrk']['nrk'];
                $detail->nrk_contract_number = $_POST['Nrk']['contract_number'];
                $detail->update();
            }
            if ($model->update()) {
                Yii::app()->user->setFlash('success', 'Data successfully updated');
                $this->redirect(array('admin'));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionUpdateDetail($id) {
        $model = NrkDetail::model()->findByPk($id);
        $nrk = Nrk::model()->findByAttributes(array('nrk' => $model->nrk_register));
        $this->performAjaxValidation($model);

        if (isset($_POST['NrkDetail'])) {
            $model->attributes = $_POST['NrkDetail'];

            if ($model->update()) {
                Yii::app()->user->setFlash('success', 'Data successfully updated');
                //$this->redirect(array('view','id'=>$model->id));
                $this->redirect(array('view', 'id' => $nrk->id));
            }
        }

        $this->render('updateDetail', array(
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
            $details = NrkDetail::model()->findAllByAttributes(array('nrk_register' => $model->nrk, 'nrk_contract_number' => $model->contract_number));
            if ($details) {
                foreach ($details as $detail) {
                    $detail->delete();
                }
            }
            $model->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] :
                                array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */ public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Nrk');
        $this->render('index', array
            (
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $this->title = 'Daftar NRK';
        $model = new Nrk('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Nrk']))
            $model->attributes = $_GET

                    ['Nrk'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /*
     * edit data through view
     */

    public function actionEditable() {
        Yii::import('bootstrap.widgets.TbEditableSaver');
        $es = new TbEditableSaver('Nrk');
        $es->update();
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be
      loaded
     */
    public function loadModel($id) {
        $model = Nrk::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model, $formId = 'nrk-form') {
        if (isset(
                        $_POST['ajax']) && $_POST['ajax'] === 'nrk-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function sendEmail() {
        $to1 = 'yourmail@host';

        $message = $this->renderPartial('/nrk/sendEmail', array(''), true);
        $subject = '=?UTF-8?B?' . base64_encode('Anggaran') . '?=';
        $headers = 'From: $to1 <vlocorp>' . "\r\n";
        $headers .= 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        mail("<$to1>", $subject, $message, $headers);
    }

}
