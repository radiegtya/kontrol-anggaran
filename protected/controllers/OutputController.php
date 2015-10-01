<?php

class OutputController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    public $title = 'Output';

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
        return VAuth::getAccessRules('output', array('export', 'import', 'clear'));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->title = 'Rincian Output';
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $this->title = 'Tambah Output';
        $model = new Output;

// Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Output'])) {
            $model->attributes = $_POST['Output'];
            $activityCode = isset($_POST['Output']['activity_code']) ? $_POST['Output']['activity_code'] : NULL;
            $code = isset($_POST['Output']['code']) ? $_POST['Output']['code'] : NULL;
            $model->code = $activityCode . "." . $code;
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Data berhasil ditambahkan.');
                //$this->redirect(array('view','id'=>$model->code));
                $this->redirect(array('index'));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionImport() {
        $this->title = 'Import Output';
        $model = new Output;
        if (isset($_POST['Output'])) {
            $model->file = CUploadedFile::getInstance($model, "file");
            if (!$model->file) {
                Yii::app()->user->setFlash('error', 'Pastikan file telah diisi.');
            }
            $filePath = Yii::getPathOfAlias('webroot') . "/imports/" . $model->file;
            if ($model->file->saveAs($filePath)) {
                $objPHPExcel = new PHPExcel();
                $fields = array(
                    array(
                        'name' => 'satker_code', //Kode Satker
                        'col' => 0,
                    ),
                    array(
                        'name' => 'activity_code', //Kode Kegiatan
                        'col' => 1,
                    ),
                    array(
                        'name' => 'code', //Kode Output
                        'col' => 2,
                    ),
                    array(
                        'name' => 'name', //Uraian Nama Output
                        'col' => 3,
                    ),
                );
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
        $this->title = 'Update Output';
        $model = $this->loadModel($id);
        $activityCode = $model->activity_code;
        $satkerCode = $model->satker_code;
        $code = $model->code;
        $model->code = str_replace($activityCode . ".", '', $code);

// Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Output'])) {
            $model->attributes = $_POST['Output'];
            $satkerCodeUpdate = isset($_POST['Output']['satker_code']) ? $_POST['Output']['satker_code'] : NULL;
            $activityCodeUpdate = isset($_POST['Output']['activity_code']) ? $_POST['Output']['activity_code'] : NULL;
            $codeUpdate = isset($_POST['Output']['code']) ? $_POST['Output']['code'] : NULL;
            $model->code = $activityCodeUpdate . '.' . $codeUpdate;
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Data berhasil diupdate.');
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
        $this->title = 'Daftar Output';
        $model = new Output('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Output']))
            $model->attributes = $_GET['Output'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /*
     * edit data through view
     */

    public function actionEditable() {
        Yii::import('bootstrap.widgets.TbEditableSaver');
        $es = new TbEditableSaver('Output');
        $es->update();
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Output::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model, $formId = 'output-form') {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'output-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Import data from excel template
     * @param type $filePath
     * @param type $fields
     * @param Output $model
     * @param type $startingRow
     */
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
            if ($fieldValidate['satker_code'] == 'Kode Satker' AND $fieldValidate['activity_code'] == 'Kode Kegiatan' AND $fieldValidate['code'] == 'Kode Output' AND $fieldValidate['name'] == 'Uraian Output') {
                $validated = TRUE;
            }
            //end of validation
            if ($validated == TRUE) {
                $highestRow = $worksheet->getHighestRow(); // e.g. 10
                $isSuccess = FALSE;
                for ($row = $startingRow; $row <= $highestRow; ++$row) {
                    $attributes = array();
                    //Read data
                    for ($col = 0; $col < count($fields); ++$col) {
                        $val = $worksheet->getCellByColumnAndRow($fields[$col]['col'], $row)->getValue();
                        $attributes[$fields[$col]['name']] = $val;
                    }
                    //Eof read data
                    $activitycode = trim($attributes['satker_code'], " \t\n\r\0\x0B") . '.' . trim($attributes['activity_code'], " \t\n\r\0\x0B");
                    $code = $activitycode . '.' . trim($attributes['code'], " \t\n\r\0\x0B");
                    $recorded = Output::model()->find(array('condition' => "code='$code'"));
                    if ($attributes['satker_code'] != NULL AND $attributes['activity_code'] != NULL AND $attributes['code'] != NULL AND $attributes['name'] != NULL) {
                        if ($recorded) {
                            //Doing update if data with sae code exist
                            $recorded->attributes = $attributes;
                            $satkerCode = isset($attributes['satker_code']) ? trim($attributes['satker_code'], " \t\n\r\0\x0B") : NULL;
                            $activityCode = $activitycode;
                            $outputCode = $code;
                            $recorded->satker_code = $satkerCode;
                            $recorded->activity_code = $satkerCode . '.' . $activityCode;
                            $recorded->code = $satkerCode . '.' . $activityCode . '.' . $outputCode;
                            if ($recorded->update()) {
                                $isSuccess = TRUE;
                            }
                            //Eof update data
                        } else {
                            //Doing create data if no recorded data with same code                        
                            $model = new Output;
                            $model->attributes = $attributes;
                            $satkerCode = isset($attributes['satker_code']) ? trim($attributes['satker_code'], " \t\n\r\0\x0B") : NULL;
                            $activityCode = isset($attributes['activity_code']) ? trim($attributes['activity_code'], " \t\n\r\0\x0B") : NULL;
                            $outputCode = isset($attributes['code']) ? trim($attributes['code'], " \t\n\r\0\x0B") : NULL;
                            $model->satker_code = $satkerCode;
                            $model->activity_code = $satkerCode . '.' . $activityCode;
                            $model->code = $satkerCode . '.' . $activityCode . '.' . $outputCode;
                            if ($model->save()) {
                                $isSuccess = TRUE;
                            }
//                        Eof create data
                        }
                    }
                }
                if ($isSuccess) {
                    unlink($filePath);
                    Yii::app()->user->setFlash('success', "File berhasil diimport ke dalam master");
                    $this->redirect(array('index'));
                }else{
                    unlink($filePath);
                    Yii::app()->user->setFlash('error', "Mohon isikan data secara lengkap");
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
        $exist = Output::model()->exists();
        if ($exist) {
            //Clear Data
            Yii::app()->db->createCommand()->truncateTable(Output::model()->tableName());
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
        $models = Output::model()->findAll();
        /** Error reporting */
        $this->excelErrorReport();
        /** PHPExcel_IOFactory */
        $objReader = new PHPExcel;
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $path = Yii::app()->basePath . '/../export/output.xlsx';
        $pathExport = Yii::app()->basePath . '/../files/Master Output.xlsx';
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
                $activityCode = $model->activity_code;
                $outputCode = $model->code;
                $activity = str_replace($satkerCode . '.', '', $activityCode);
                $code1 = str_replace($satkerCode . ".", '', $outputCode);
                $code2 = str_replace($activity . ".", '', $code1);
                $sheet->setCellValueExplicit('A' . ++$row, $satkerCode, PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('B' . $row, $activity, PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('C' . $row, $code2, PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('D' . $row, isset($model->name) ? $model->name : NULL, PHPExcel_Cell_DataType::TYPE_STRING);
            }
        }
        $objPHPExcel->getActiveSheet()->setTitle('Daftar Output');
    }

}
