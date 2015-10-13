<?php

class ActivityController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    public $title = 'Kegiatan';

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
        return VAuth::getAccessRules('activity', array('clear', 'import', 'export'));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->title = 'Rincian Kegiatan';
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $this->title = 'Tambah Kegiatan';
        $model = new Activity;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Activity'])) {
            $model->attributes = $_POST['Activity'];
            $satkerCode = isset($_POST['Activity']['satker_code']) ? $_POST['Activity']['satker_code'] : NULL;
            $code = isset($_POST['Activity']['code']) ? $_POST['Activity']['code'] : NULL;
            $model->code = $satkerCode . "." . $code;
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Data berhasil ditambahkan.');
                $this->redirect(array('index'));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionImport() {
        $this->title = 'Import Kegiatan';
        $model = new Activity;
        if (isset($_POST['Activity'])) {
            $model->file = CUploadedFile::getInstance($model, "file");
            if (!$model->file) {
                Yii::app()->user->setFlash('error', 'Pastikan file telah diisi.');
                $this->redirect('import');
            }
            $filePath = Yii::getPathOfAlias('webroot') . "/imports/" . $model->file;
            if ($model->file->saveAs($filePath)) {
                $objPHPExcel = new PHPExcel();
                $fields = array(
                    array(
                        'name' => 'satker_code', //satker code
                        'col' => 0,
                    ),
                    array(
                        'name' => 'code', //code
                        'col' => 1,
                    ),
                    array(
                        'name' => 'name', //activity name
                        'col' => 2,
                    ),
                );
                $filePath = Yii::getPathOfAlias('webroot') . "/imports/" . $model->file;
                $isSuccess = false;
                $this->importExcelToMysql($filePath, $fields);
            }
        }
        $this->render('import', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $this->title = 'Update Kegiatan';
        $model = $this->loadModel($id);
        $satkerCode = $model->satker_code;
        $code = $model->code;
        $model->code = str_replace($satkerCode . ".", '', $code);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Activity'])) {
            $model->attributes = $_POST['Activity'];
            $satkerCodeUpdate = isset($_POST['Activity']['satker_code']) ? $_POST['Activity']['satker_code'] : NULL;
            $codeUpdate = isset($_POST['Activity']['code']) ? $_POST['Activity']['code'] : NULL;
            $model->code = $satkerCodeUpdate . "." . $codeUpdate;

            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Data successfully updated');
                //$this->redirect(array('view','id'=>$model->code));
                $this->redirect(array('index'));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request			
            $model = $this->loadModel($id);
//            $VUpload = new VUpload();
//            $VUpload->path = 'images/activity/';
//            $VUpload->doDelete($model, 'image');
            $model->delete();

            // if AJAX request (triggered by deletion via index grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $this->title = 'Daftar Kegiatan';
        $model = new Activity('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Activity']))
            $model->attributes = $_GET['Activity'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /*
     * edit data through view
     */

    public function actionEditable() {
        Yii::import('bootstrap.widgets.TbEditableSaver');
        $es = new TbEditableSaver('Activity');
        $es->update();
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Activity::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model, $formId = 'activity-form') {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'activity-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function importExcelToMysql($filePath, $fields = array(), $model = null, $startingRow = 2) {
        $objPHPExcel = PHPExcel_IOFactory::load($filePath);
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            //field validation
            $fieldValidate = array();
            $validated = FALSE;
            for ($col = 0; $col < count($fields); ++$col) {
                $val = $worksheet->getCellByColumnAndRow($fields[$col]['col'], 1)->getValue();
                $fieldValidate[$fields[$col]['name']] = $val;
            }
            if ($fieldValidate['satker_code'] == 'Kode Satker' AND $fieldValidate['code'] == 'Kode Kegiatan' AND $fieldValidate['name'] == 'Uraian Kegiatan') {
                $validated = TRUE;
            }
            //end of validation
            if ($validated == TRUE) {
                $highestRow = $worksheet->getHighestRow(); // e.g. 10
                $isSuccess = FALSE;

                //Doing import data
                for ($row = $startingRow; $row <= $highestRow; ++$row) {
                    $attributes = array();
                    for ($col = 0; $col < count($fields); ++$col) {
                        $val = $worksheet->getCellByColumnAndRow($fields[$col]['col'], $row)->getValue();
                        $attributes[$fields[$col]['name']] = $val;
                    }
                    $satkercode = trim($attributes['satker_code'], " \t\n\r\0\x0B");
                    $code = $satkercode . '.' . trim($attributes['code'], " \t\n\r\0\x0B");
                    $recorded = Activity::model()->find(array('condition' => "code='$code'"));
                    //check if satker_code, code, name not null then execute excel, else show error
                    if ($attributes['satker_code'] != NULL AND $attributes['code'] != NULL AND $attributes['name'] != NULL) {
                        //if concat satker_code & code exists on database, only update the data from excel, else create new data 
                        if ($recorded) {
                            $recorded->attributes = $attributes;
                            $satkerCode = isset($attributes['satker_code']) ? trim($attributes['satker_code'], " \t\n\r\0\x0B") : NULL;
                            $recorded->satker_code = $satkerCode;
                            $recorded->code = $code;
                            if ($recorded->update()) {
                                $isSuccess = TRUE;
                            }
                        } else {
                            $model = new Activity;
                            $model->attributes = $attributes;
                            $satkerCode2 = isset($attributes['satker_code']) ? trim($attributes['satker_code'], " \t\n\r\0\x0B") : NULL;
                            $model->satker_code = $satkerCode2;
                            $model->code = $code;
                            if ($model->save()) {
                                $isSuccess = TRUE;
                            }
                        }
                    }
                }
                //Action when import process done
                if ($isSuccess) {
                    unlink($filePath);
                    Yii::app()->user->setFlash('success', "Data berhasil diimport.");
                    $this->redirect(array('index'));
                } else {
                    unlink($filePath);
                    Yii::app()->user->setFlash('error', "Mohon Masukkan Data secara lengkap.");
                }
            } else {
                unlink($filePath);
                Yii::app()->user->setFlash('error', "Pastikan file yang Anda upload sudah benar!");
                $this->redirect(array('import'));
            }
        }
    }

    /**
     * Clear all data
     */
    public function actionClear() {
        //Check record data on database
        $exist = Activity::model()->exists();
        if ($exist) {
            //Clear Data
            Yii::app()->db->createCommand()->truncateTable(Activity::model()->tableName());
            Yii::app()->user->setFlash('success', 'Data berhasil dibersihkan.');
            $this->redirect(array('index'));
        } else {
            Yii::app()->user->setFlash('error', 'Data tidak ditemukan.');
            $this->redirect(array('index'));
        }
    }

    /**
     * Export Data to Excel
     */
    public function actionExport() {
        /** Get model */
        $models = Activity::model()->findAll();
        /** Error reporting */
        $this->excelErrorReport();

        /** PHPExcel_IOFactory */
        $objReader = new PHPExcel;
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $path = Yii::app()->basePath . '/../export/activity.xlsx';
        $pathExport = Yii::app()->basePath . '/../files/master-kegiatan.xlsx';
        $objPHPExcel = $objReader->load($path);
        $objPHPExcel->setActiveSheetIndex(0);

        /* " Add new data to template" */
        $this->exportExcel($objPHPExcel, $models);
        /** Export to excel* */
        $this->excel($objPHPExcel, $pathExport);
        readfile($pathExport);
        unlink($pathExport);
        exit;
    }

    /**
     * PHP Excel error report
     */
    public function excelErrorReport() {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        date_default_timezone_set('Asia/Jakarta');
    }

    /**
     * PHP Excel doing Export to excel
     */
    public function excel($objPHPExcel, $pathExport) {
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save($pathExport);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($pathExport));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($pathExport));
    }

    //Write data to excel cell
    public function exportExcel($objPHPExcel, $models) {
        $sheet = $objPHPExcel->getActiveSheet();
        $row = 1;
        if ($models) {
            foreach ($models as $model) {
                $satkerCode = $model->satker_code;
                $activityCode = $model->code;
                $code = str_replace($satkerCode . ".", '', $activityCode);
                $sheet->setCellValueExplicit('A' . ++$row, isset($model->satker_code) ? $model->satker_code : NULL, PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('B' . $row, $code, PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValue('C' . $row, isset($model->name) ? $model->name : NULL);
            }
        }
        $objPHPExcel->getActiveSheet()->setTitle('Daftar Kegiatan');
    }

}
