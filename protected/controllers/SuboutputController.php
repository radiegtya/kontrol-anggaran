<?php

class SuboutputController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    public $title = 'Sub Output';

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
        return VAuth::getAccessRules('suboutput', array('import', 'export', 'clear'));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->title = 'Rincian Suboutput';
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $this->title = 'Tambah Suboutput';
        $model = new Suboutput;

// Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Suboutput'])) {
            $model->attributes = $_POST['Suboutput'];
            $model->satker_code = '622280';
            $model->activity_code = '2439';
            $model->code = $_POST['Suboutput']['output_code'] . '.' . $_POST['Suboutput']['code'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Data successfully created');
                $this->redirect(array('index'));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionImport() {
        $this->title = 'Import Suboutput';
        $model = new Suboutput;
        if (isset($_POST['Suboutput'])) {
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
                        'name' => 'satker_code', //Kode Satker
                        'col' => 0,
                    ),
                    array(
                        'name' => 'activity_code', //Kode Kegiatan
                        'col' => 1,
                    ),
                    array(
                        'name' => 'output_code', //Kode Output
                        'col' => 2,
                    ),
                    array(
                        'name' => 'code', //Kode Suboutput
                        'col' => 3,
                    ),
                    array(
                        'name' => 'name', //Uraian Nama Suboutput
                        'col' => 4,
                    ),
                );
                $this->importExcelToMysql($filePath, $fields);
            }
        }

        //get suboutput error lists
        $suboutputError = new SuboutputError('search');
        $suboutputError->unsetAttributes();  // clear any default values
        if (isset($_GET['SuboutputError']))
            $suboutputError->attributes = $_GET['SuboutputError'];

        $this->render('import', array(
            'model' => $model,
            'suboutputError' => $suboutputError
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $this->title = 'Update Suboutput';
        $model = $this->loadModel($id);
        $modelCode = $model->code;
        $code = explode(".", $modelCode);
        $codeResult = '';
        for ($i = 1; $i <= count($codeResult); $i++) {
            $codeResult .=$code[$i] . '.';
        }
        $model->code = substr($codeResult, 0, -1);

// Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Suboutput'])) {
            $model->attributes = $_POST['Suboutput'];
            $model->code = $_POST['Suboutput']['output_code'] . '.' . $_POST['Suboutput']['code'];

            if ($model->update()) {
                Yii::app()->user->setFlash('success', 'Data successfully updated');
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
        $this->title = 'Daftar Suboutput';
        $model = new Suboutput('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Suboutput']))
            $model->attributes = $_GET['Suboutput'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /*
     * edit data through view
     */

    public function actionEditable() {
        Yii::import('bootstrap.widgets.TbEditableSaver');
        $es = new TbEditableSaver('Suboutput');
        $es->update();
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Suboutput::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model, $formId = 'suboutput-form') {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'suboutput-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function importExcelToMysql($filePath, $fields = array(), $model = null, $startingRow = 2) {
        $objPHPExcel = PHPExcel_IOFactory::load($filePath);
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {

            $fieldValidate = array(); //field validation
            $validated = FALSE;
            for ($col = 0; $col < count($fields); ++$col) {
                $val = $worksheet->getCellByColumnAndRow($fields[$col]['col'], 1)->getValue();
                $fieldValidate[$fields[$col]['name']] = $val;
            }
            if ($fieldValidate['satker_code'] == 'Kode Satker' AND $fieldValidate['activity_code'] == 'Kode Kegiatan' AND $fieldValidate['output_code'] == 'Kode Output' AND $fieldValidate['code'] == 'Kode Suboutput' AND $fieldValidate['name'] == 'Uraian Suboutput') {
                $validated = TRUE;
            }//end of validation

            if ($validated == TRUE) {
                $highestRow = $worksheet->getHighestRow(); // e.g. 10
                $isSuccess = FALSE;

                //check if RKAKL data subcomponent already removed, but app master data already realize        
                $this->validateRemovedData($filePath, $fields, $worksheet, $highestRow, $startingRow);

                for ($row = $startingRow; $row <= $highestRow; ++$row) {
                    $attributes = array();
                    for ($col = 0; $col < count($fields); ++$col) {
                        $val = $worksheet->getCellByColumnAndRow($fields[$col]['col'], $row)->getValue();
                        $attributes[$fields[$col]['name']] = $val;
                    }
                    $outputcode = trim($attributes['satker_code'], " \t\n\r\0\x0B") . '.' . trim($attributes['activity_code'], " \t\n\r\0\x0B") . '.' . trim($attributes['output_code'], " \t\n\r\0\x0B");
                    $code = $outputcode . '.' . trim($attributes['code'], " \t\n\r\0\x0B");
                    $recorded = Suboutput::model()->find(array('condition' => "code='$code'"));
                    if ($attributes['satker_code'] != NULL AND $attributes['activity_code'] != NULL AND $attributes['output_code'] != NULL AND $attributes['code'] != NULL AND $attributes['name'] != NULL) {
                        if ($recorded) {
                            $recorded->attributes = $attributes;
                            $satkerCode = isset($attributes['satker_code']) ? $attributes['satker_code'] : NULL;
                            $activityCode = isset($attributes['activity_code']) ? $attributes['activity_code'] : NULL;
                            $outputCode = isset($attributes['output_code']) ? $attributes['output_code'] : NULL;
                            $suboutputCode = isset($attributes['code']) ? $attributes['code'] : NULL;
                            //set value
                            $recorded->satker_code = $satkerCode;
                            $recorded->activity_code = $satkerCode . '.' . $activityCode;
                            $recorded->output_code = $satkerCode . '.' . $activityCode . '.' . $outputCode;
                            $recorded->code = $satkerCode . '.' . $activityCode . '.' . $outputCode . '.' . $suboutputCode;
                            if ($recorded->update()) {
                                $isSuccess = TRUE;
                            }
                        } else {
                            $model = new Suboutput;
                            $model->attributes = $attributes;
                            $satkerCode = isset($attributes['satker_code']) ? $attributes['satker_code'] : NULL;
                            $activityCode = isset($attributes['activity_code']) ? $attributes['activity_code'] : NULL;
                            $outputCode = isset($attributes['output_code']) ? $attributes['output_code'] : NULL;
                            $suboutputCode = isset($attributes['code']) ? $attributes['code'] : NULL;
                            //set value
                            $model->satker_code = $satkerCode;
                            $model->activity_code = $satkerCode . '.' . $activityCode;
                            $model->output_code = $satkerCode . '.' . $activityCode . '.' . $outputCode;
                            $model->code = $satkerCode . '.' . $activityCode . '.' . $outputCode . '.' . $suboutputCode;
                            if ($model->save()) {
                                $isSuccess = TRUE;
                            }
                        }
                    }
                }
                if ($isSuccess) {
                    unlink($filePath);
                    Yii::app()->user->setFlash('success', "File berhasil diimport ke dalam master");
                    $this->redirect(array('index'));
                } else {
                    unlink($filePath);
                    Yii::app()->user->setFlash('error', "Mohon masukkan data secara lengkap.");
                }
            } else {
                unlink($filePath);
                Yii::app()->user->setFlash('error', "Pastikan file yang Anda upload sudah benar!");
                $this->redirect(array('import'));
            }
        }
    }

    //check if RKAKL data suboutput already removed, but app master data already realize    
    private function validateRemovedData($filePath, $fields = array(), $worksheet, $highestRow, $startingRow = 2) {
        /* ===== (IMPORT DATA CHECKER) check if RKAKL data suboutput already removed, but app master data already realize === */
        //clear SuboutputError table if exists
        $exist = SuboutputError::model()->exists();
        if ($exist)
            Yii::app()->db->createCommand()->truncateTable(SuboutputError::model()->tableName());

        $suboutputCodeFromExcel = [];
        for ($row = $startingRow; $row <= $highestRow; ++$row) {
            $attributes = array();
            for ($col = 0; $col < count($fields); ++$col) {
                $val = $worksheet->getCellByColumnAndRow($fields[$col]['col'], $row)->getValue();
                $attributes[$fields[$col]['name']] = $val;
            }

            //(IMPORT DATA CHECKER) get all excel suboutput
            $code = $attributes['satker_code'] . "." . $attributes['activity_code'] . "." . $attributes['output_code'] . "." . $attributes['code'];
            array_push($suboutputCodeFromExcel, $code);
        }

        // (IMPORT DATA CHECKER) compare excel.suboutput with current data suboutput removed
        $criteria = new CDbCriteria();
        $criteria->addNotInCondition('code', $suboutputCodeFromExcel);
        $removedSuboutputs = Suboutput::model()->findAll($criteria);

//        //(IMPORT DATA CHECKER) compare $removedSuboutputs with realization.package_code
//        $removedSuboutputsArray = [];
//        foreach ($removedSuboutputs as $r) {
//            array_push($removedSuboutputsArray, $r->code);
//        }

        if (count($removedSuboutputs) > 0) {
            $criteria = new CDbCriteria();
//            $criteria->addInCondition('package_code', $removedSuboutputsArray);
            foreach ($removedSuboutputs as $r) {
                $criteria->addSearchCondition('package_code', $r->code, true, 'OR');
            }
            $realizationsError = Realization::model()->findAll($criteria);

            //insert to SuboutputError table
            $whereInSuboutput = [];
            foreach ($realizationsError as $r) {
                $codeArray = explode(".", $r->package_code);
                $code = $codeArray[0] . "." . $codeArray[1] . "." . $codeArray[2] . "." . $codeArray[3];//get only package code till latest 3 dot (.)
                array_push($whereInSuboutput, $code);
            }
            $criteria = new CDbCriteria();
            $criteria->addInCondition('code', $whereInSuboutput);
            $suboutputsError = Suboutput::model()->findAll($criteria);
            foreach ($suboutputsError as $s) {
                $model = new SuboutputError();
                $model->attributes = [
                    'code' => $s->code,
                    'satker_code' => $s->satker_code,
                    'activity_code' => $s->activity_code,
                    'output_code' => $s->output_code,
                    'name' => $s->name,
                ];
                $model->save();
            }
            if (count($suboutputsError) > 0) {
                unlink($filePath);
                Yii::app()->user->setFlash('error', "Terdapat data terhapus di RKAKL, dimana data tsb sudah terealisasi.");
                $this->redirect(array('import'));
            }
        }
        /* ===== EOF (IMPORT DATA CHECKER) check if RKAKL data suboutput already removed, but app master data already realize === */
    }

    /**
     * Clear all data
     */
    public function actionClear() {
        //validate if data already used for realization
        $realizations = Realization::model()->findAll();
        $realizationCodeArray = [];
        foreach ($realizations as $r) {
            $codeArray = explode(".", $r->package_code);
            $code = $codeArray[0] . "." . $codeArray[1] . "." . $codeArray[2] . "." . $codeArray[3]; //get only package code till latest 3 dot (.)
            array_push($realizationCodeArray, $code);
        }

        $criteria = new CDbCriteria();
        $criteria->addNotInCondition('code', $realizationCodeArray);
        $suboutputsAllowDelete = Suboutput::model()->findAll($criteria);

        foreach ($suboutputsAllowDelete as $s) {
            //remove suboutputs
            $s->delete();
        }

        if (count($suboutputsAllowDelete) < Suboutput::model()->count()) {
            Yii::app()->user->setFlash('error', "Terdapat beberapa data yang sudah terealisasi, sehingga data tidak bisa dihapus.");
            $this->redirect(array('index'));
        }

//        //Check record data on database
//        $exist = Suboutput::model()->exists();
//        if ($exist) {
//            //Clear Data
//            Yii::app()->db->createCommand()->truncateTable(Suboutput::model()->tableName());
//            Yii::app()->user->setFlash('success', 'Data berhasil dibersihkan.');
//            $this->redirect(array('index'));
//        } else {
//            Yii::app()->user->setFlash('error', 'Data tidak ditemukan.');
//            $this->redirect(array('index'));
//        }
    }

    /**
     * Export Data to Excel
     */
    public function actionExport() {
        /** Get model */
        $models = Suboutput::model()->findAll();
        /** Error reporting */
        $this->excelErrorReport();

        /** PHPExcel_IOFactory */
        $objReader = new PHPExcel;
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $path = Yii::app()->basePath . '/../export/suboutput.xlsx';
        $pathExport = Yii::app()->basePath . '/../files/Master Suboutput.xlsx';
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
                $sheet->setCellValueExplicit('A' . ++$row, isset($model->satker_code) ? $model->satker_code : NULL, PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('B' . $row, isset($model->activity_code) ? str_replace($model->satker_code . '.', '', $model->activity_code) : NULL, PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('C' . $row, isset($model->output_code) ? str_replace($model->activity_code . '.', '', $model->output_code) : NULL, PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('D' . $row, isset($model->code) ? str_replace($model->output_code . '.', '', $model->code) : NULL, PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValue('E' . $row, isset($model->name) ? $model->name : NULL);
            }
        }
        $objPHPExcel->getActiveSheet()->setTitle('Suboutput');
    }

}
