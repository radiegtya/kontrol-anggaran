<?php

class UpController extends Controller {

    public $title = 'UP/TUP';

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
        return VAuth::getAccessRules('up', array('createMultiple', 'updateDetail', 'deleteDetail'));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->title = 'Rincian UP';

//UP model detail view
        $model = $this->loadModel($id);
        $userId = Yii::app()->user->id;
        $user = User::model()->findByPk($userId);

//UPDetail model Gridview
        $modelDetail = new UpDetail('searchDetail');
        $modelDetail->unsetAttributes();
        if (isset($_GET['UpDetail']))
            $modelDetail->attributes = $_GET['UpDetail'];

//Create new UPDetail
        $newDetail = new UpDetail;
        $this->performAjaxValidation($newDetail);
        if (isset($_POST['UpDetail'])) {
            if ($_POST['UpDetail']['limit'] == NULL && $_POST['UpDetail']['package_code'] == NULL) {
                Yii::app()->user->setFlash('error', 'Mohon isikan data pada form.');
            } else {
                $detailLimit = $_POST['UpDetail']['limit'];
                $packageCode = $_POST['UpDetail']['package_code'];
                $checkDetail = UpDetail::model()->findByAttributes(array('up_number_of_letter' => "$model->number_of_letter", 'package_code' => "$packageCode"));
                $package = Package::model()->findByAttributes(array('code' => $packageCode));
                $detailLists = UpDetail::model()->findAllByAttributes(array('up_number_of_letter' => $model->number_of_letter));
                $total = 0;
                if ($detailLists) {
                    foreach ($detailLists as $detailList) {
                        $total +=$detailList->limit;
                    }
                }
                $totalNewLimit = $total + $detailLimit;
                if ($checkDetail) {
                    Yii::app()->user->setFlash('error', 'Paket sudah digunakan dalam UP');
                } elseif ($detailLimit > $package->limit) {
                    Yii::app()->user->setFlash('error', 'Pagu UP Detail tidak boleh melebihi pagu paket');
                } elseif ($totalNewLimit > $model->total_up) {
                    Yii::app()->user->setFlash('error', 'Pagu UP Detail tidak boleh melebihi pagu UP');
                } else {
                    $newDetail->attributes = $_POST['UpDetail'];
                    $newDetail->up_number_of_letter = $model->number_of_letter;
                    if ($newDetail->save()) {
                        //Update package account UP status from "LS" to "UP"
                        $packagesAccounts = PackageAccount::model()->findAllByAttributes(array('package_code' => $newDetail->package_code));
                        foreach ($packagesAccounts as $packagesAccount) {
                            $packagesAccount->up = "UP";
                            $packagesAccount->update();
                        }
                        Yii::app()->user->setFlash('success', 'Detail berhasil ditambahkan');
                        $this->redirect(array('view', 'id' => $model->id));
                    }
                }
            }
        }
        $this->render('view', array(
            'model' => $model,
            'modelDetail' => $modelDetail,
            'addDetail' => $newDetail,
            'user' => $user,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $this->title = 'Tambah UP';
        $model = new Up;
        $this->performAjaxValidation($model);

        if (isset($_POST['Up'])) {
            $model->attributes = $_POST['Up'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Data berhasil ditambahkan.');
                $this->redirect(array('view', 'id' => $model->id));
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
        $this->title = 'Update UP';
        $model = $this->loadModel($id);
        $modelNumber = $model->number_of_letter;
        $currentUp = UpDetail::model()->findAllByAttributes(array('up_number_of_letter' => $model->number_of_letter));
        $detail = false;
        if ($currentUp) {
            $detail = TRUE;
        }
        $latestUP = Up::model()->find(array('order' => 'id DESC'));
        if ($model->number_of_letter != $latestUP->number_of_letter) {
            Yii::app()->user->setFlash('error', 'Sudah ada UP baru. Tidak dapat mengedit UP lama.');
            $this->redirect(array('admin'));
        }
// Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Up'])) {
            $numberLetter = $_POST['Up']['number_of_letter'];
//            $totalUp = $_POST['Up']['total_up'];
//            if ($model->total_up != $totalUp) {
//                Yii::app()->user->setFlash('error', 'Tidak dapat merubah Pagu UP.');
//            } else {
            $model->attributes = $_POST['Up'];
            if ($model->update()) {
                $details = UpDetail::model()->findAllByAttributes(array('up_number_of_letter' => $modelNumber));
                foreach ($details as $detail) {
                    $detail->up_number_of_letter = $numberLetter;
                    $detail->update();
                }
                $realizations = Realization::model()->findAllByAttributes(array('number_of_letter' => $modelNumber));
                foreach ($realizations as $realization) {
                    $realization->up_number_of_letter = $numberLetter;
                    $realization->update();
                }
                Yii::app()->user->setFlash('success', 'Data berhasil diupdate');
                $this->redirect(array('view', 'id' => $model->id));
            }
//            }
        }

        $this->render('update', array(
            'model' => $model,
            'detail' => $detail,
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
            $currentUp = UpDetail::model()->findAllByAttributes(array('up_number_of_letter' => $model->number_of_letter));
            $latestUP = Up::model()->find(array('order' => 'id DESC'));
            if ($model->number_of_letter != $latestUP->number_of_letter) {
                Yii::app()->user->setFlash('error', 'Sudah ada UP baru. Tidak dapat menghapus UP lama.');
                $this->redirect(array('view', 'id' => $model->id));
            }
            $realization = $model->getTotal($model->number_of_letter)["realization"];
            if ($realization != 0) {
                Yii::app()->user->setFlash('error', 'Tidak dapat menghapus UP yang sudah terrealisasi.');
                $this->redirect(array('view', 'id' => $model->id));
            }
//Delete Detail
            $details = UpDetail::model()->findAllByAttributes(array('up_number_of_letter' => $model->number_of_letter));
            foreach ($details as $detail) {
//update package UP status to LS
                $package = Package::model()->findByAttributes(array('code' => $detail->package_code));
                $package->up = 'LS';
                $package->update();
//update package UP status to LS
                $detail->delete();
            }
//Delete Detail

            $model->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionDeleteDetail($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request			
            $model = UpDetail::model()->findByPk($id);
            $up = Up::model()->findByAttributes(array('number_of_letter' => $model->up_number_of_letter));
            $realization = $model->getTotalDetail($model->package_name, $model->up_number_of_letter)["realization"];
            if ($realization != 0) {
                Yii::app()->user->setFlash('error', 'Tidak dapat menghapus detail yang sudah direalisasi');
                $this->redirect(array('view', 'id' => $up->id));
            }
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
        $dataProvider = new CActiveDataProvider('Up');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionUpdateDetail($id) {
        $this->title = 'Update Detail UP';
        $model = UpDetail::model()->findByPk($id);
        $currentUp = UpDetail::model()->findAllByAttributes(array('up_number_of_letter' => $model->up_number_of_letter));
        $currentTotal = 0;
        if ($currentUp) {
            foreach ($currentUp as $currentUpDetail) {
                $currentTotal +=$currentUpDetail->limit;
            }
        }


// Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['UpDetail'])) {
            $currentLimit = $model->limit;
            $limit = $_POST['UpDetail']['limit'];
            $tempTotal = $currentTotal - $currentLimit + $limit;
            $latestUP = Up::model()->find(array('order' => 'id DESC'));
            $upLimit = $latestUP->total_up;
            $up = Up::model()->findByAttributes(array('number_of_letter' => $model->up_number_of_letter));
            if ($model->up_number_of_letter != $latestUP->number_of_letter) {
                Yii::app()->user->setFlash('error', 'Sudah ada UP baru. Tidak dapat mengedit detail UP lama.');
                $this->redirect(array('view', 'id' => $up->id));
            } else {
                $realization = $model->getTotalDetail($model->package_code, $model->up_number_of_letter)["realization"];
                if ($limit < $realization) {
                    Yii::app()->user->setFlash('error', 'Pagu Detail tidak boleh lebih kecil dari Pagu detail yang sudah direalisasikan.');
                    $this->redirect(array('view', 'id' => $up->id));
                }
            }

            if ($tempTotal > $upLimit) {
                Yii::app()->user->setFlash('error', 'Update Pagu Detail UP tidak boleh melebihi total Pagu UP.');
            } else {
                $model->attributes = $_POST['UpDetail'];
                if ($model->update()) {
                    Yii::app()->user->setFlash('success', 'Data berhasil diupdate');
//$this->redirect(array('view','id'=>$model->id));
                    $this->redirect(array('view', 'id' => $up->id));
                }
            }
        }

        $this->render('updateDetail', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $this->title = 'Daftar UP';
        $model = new Up('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Up']))
            $model->attributes = $_GET['Up'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /*
     * edit data through view
     */

    public function actionEditable() {
        Yii::import('bootstrap.widgets.TbEditableSaver');
        $es = new TbEditableSaver('Up');
        $es->update();
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Up::model()->findByPk($id);
        if ($model ===
                null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model, $formId = 'up-form') {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'up-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function sendEmail() {
        $to1 = 'yourmail@host';

        $message = $this->renderPartial('/up/sendEmail', array(''), true);
        $subject = '=?UTF-8?B?' . base64_encode('Anggaran') . '?=';
        $headers = 'From: $to1 <vlocorp>' . "\r\n";
        $headers .= 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        mail(" <$to1>", $subject, $message, $headers);
    }

}
