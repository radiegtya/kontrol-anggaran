<?php

class ComponentController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    public $title = 'Komponen';

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
        return VAuth::getAccessRules('component', array('export', 'import', 'clear', 'exportError'));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->title = 'Rincian Komponen';
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $this->title = 'Tambah Komponen';
        $model = new Component;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Component'])) {
            $model->attributes = $_POST['Component'];
            $model->satker_code = '622280';
            $model->activity_code = '2439';
            $model->code = $_POST['Component']['suboutput_code'] . '.' . $_POST['Component']['code'];

            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Data berhasil ditambahkan.');
                //$this->redirect(array('view','id'=>$model->id));
                $this->redirect(array('index'));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionImport() {
        $this->title = 'Import Komponen';
        $model = new Component;
        if (isset($_POST['Component'])) {
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
                        'name' => 'suboutput_code', //Kode Suboutput
                        'col' => 3,
                    ),
                    array(
                        'name' => 'code', //Kode Komponen
                        'col' => 4,
                    ),
                    array(
                        'name' => 'name', //Uraian Nama Komponen
                        'col' => 5,
                    ),
                );
                $this->importExcelToMysql($filePath, $fields);
            }
        }

        //get component error lists
        $componentError = new ComponentError('search');
        $componentError->unsetAttributes();  // clear any default values
        if (isset($_GET['ComponentError']))
            $componentError->attributes = $_GET['ComponentError'];

        $this->render('import', array(
            'model' => $model,
            'componentError' => $componentError
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $this->title = 'Update Komponen';
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

        if (isset($_POST['Component'])) {
            $model->attributes = $_POST['Component'];
            $model->code = $_POST['Component']['suboutput_code'] . '.' . $_POST['Component']['code'];
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
        $this->title = 'Daftar komponen';
        $model = new Component('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Component']))
            $model->attributes = $_GET['Component'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /*
     * edit data through view
     */

    public function actionEditable() {
        Yii::import('bootstrap.widgets.TbEditableSaver');
        $es = new TbEditableSaver('Component');
        $es->update();
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Component::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model, $formId = 'component-form') {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'component-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function importExcelToMysql($filePath, $fields = array(), $model = null, $startingRow = 2) {
        $objPHPExcel = PHPExcel_IOFactory::load($filePath);

        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            //field validation
            $fieldValidate = array();
            for ($col = 0; $col < count($fields); ++$col) {
                $val = $worksheet->getCellByColumnAndRow($fields[$col]['col'], 1)->getValue();
                $fieldValidate[$fields[$col]['name']] = $val;
            }
            $validated = FALSE;
            if ($fieldValidate['satker_code'] == 'Kode Satker' AND $fieldValidate['activity_code'] == 'Kode Kegiatan' AND $fieldValidate['output_code'] == 'Kode Output' AND $fieldValidate['suboutput_code'] == 'Kode Suboutput' AND $fieldValidate['code'] == 'Kode Komponen' AND $fieldValidate['name'] == 'Uraian Komponen') {
                $validated = TRUE;
            }//end of validation

            if ($validated == TRUE) {
                $highestRow = $worksheet->getHighestRow();
                $isSuccess = FALSE;

                //check if RKAKL data subcomponent already removed, but app master data already realize        
                $this->validateRemovedData($filePath, $fields, $worksheet, $highestRow, $startingRow);

                for ($row = $startingRow; $row <= $highestRow; ++$row) {
                    $attributes = array();
                    for ($col = 0; $col < count($fields); ++$col) {
                        $val = $worksheet->getCellByColumnAndRow($fields[$col]['col'], $row)->getValue();
                        $attributes[$fields[$col]['name']] = $val;
                    }
                    $suboutputcode = trim($attributes['satker_code'], " \t\n\r\0\x0B") . '.' . trim($attributes['activity_code'], " \t\n\r\0\x0B") . '.' . trim($attributes['output_code'], " \t\n\r\0\x0B") . '.' . trim($attributes['suboutput_code'], " \t\n\r\0\x0B");
                    $code = $suboutputcode . '.' . trim($attributes['code'], " \t\n\r\0\x0B");
                    $recorded = Component::model()->find(array('condition' => "code='$code'"));
                    if ($attributes['satker_code'] != NULL AND $attributes['activity_code'] != NULL AND $attributes['output_code'] != NULL AND $attributes['suboutput_code'] != NULL AND $attributes['code'] != NULL AND $attributes['name'] != NULL) {
                        if ($recorded) {
                            $recorded->attributes = $attributes;
                            $satkerCode = isset($attributes['satker_code']) ? trim($attributes['satker_code'], " \t\n\r\0\x0B") : NULL;
                            $activityCode = isset($attributes['activity_code']) ? trim($attributes['activity_code'], " \t\n\r\0\x0B") : NULL;
                            $outputCode = isset($attributes['output_code']) ? trim($attributes['output_code'], " \t\n\r\0\x0B") : NULL;
                            $suboutputCode = isset($attributes['suboutput_code']) ? trim($attributes['suboutput_code'], " \t\n\r\0\x0B") : NULL;
                            $subcomponentCode = isset($attributes['code']) ? trim($attributes['code'], " \t\n\r\0\x0B") : NULL;
                            //set value
                            $recorded->satker_code = $satkerCode;
                            $recorded->activity_code = $satkerCode . '.' . $activityCode;
                            $recorded->output_code = $satkerCode . '.' . $activityCode . '.' . $outputCode;
                            $recorded->suboutput_code = $satkerCode . '.' . $activityCode . '.' . $outputCode . '.' . $suboutputCode;
                            $recorded->code = $satkerCode . '.' . $activityCode . '.' . $outputCode . '.' . $suboutputCode . '.' . $subcomponentCode;
                            if ($recorded->update()) {
                                $isSuccess = TRUE;
                            }
                        } else {

                            $model = new Component;
                            $model->attributes = $attributes;
                            $satkerCode = isset($attributes['satker_code']) ? trim($attributes['satker_code'], " \t\n\r\0\x0B") : NULL;
                            $activityCode = isset($attributes['activity_code']) ? trim($attributes['activity_code'], " \t\n\r\0\x0B") : NULL;
                            $outputCode = isset($attributes['output_code']) ? trim($attributes['output_code'], " \t\n\r\0\x0B") : NULL;
                            $suboutputCode = isset($attributes['suboutput_code']) ? trim($attributes['suboutput_code'], " \t\n\r\0\x0B") : NULL;
                            $componentCode = isset($attributes['code']) ? trim($attributes['code'], " \t\n\r\0\x0B") : NULL;
                            //set value
                            $model->satker_code = $satkerCode;
                            $model->activity_code = $satkerCode . '.' . $activityCode;
                            $model->output_code = $satkerCode . '.' . $activityCode . '.' . $outputCode;
                            $model->suboutput_code = $satkerCode . '.' . $activityCode . '.' . $outputCode . '.' . $suboutputCode;
                            $model->code = $satkerCode . '.' . $activityCode . '.' . $outputCode . '.' . $suboutputCode . '.' . $componentCode;
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

    //check if RKAKL data component already removed, but app master data already realize    
    private function validateRemovedData($filePath, $fields = array(), $worksheet, $highestRow, $startingRow = 2) {
        /* ===== (IMPORT DATA CHECKER) check if RKAKL data component already removed, but app master data already realize === */
        //clear ComponentError table if exists
        $exist = ComponentError::model()->exists();
        if ($exist)
            Yii::app()->db->createCommand()->truncateTable(ComponentError::model()->tableName());

        $componentCodeFromExcel = [];
        for ($row = $startingRow; $row <= $highestRow; ++$row) {
            $attributes = array();
            for ($col = 0; $col < count($fields); ++$col) {
                $val = $worksheet->getCellByColumnAndRow($fields[$col]['col'], $row)->getValue();
                $attributes[$fields[$col]['name']] = $val;
            }

            //(IMPORT DATA CHECKER) get all excel component
            $code = $attributes['satker_code'] . "." . $attributes['activity_code'] . "." . $attributes['output_code'] . "." . $attributes['suboutput_code'] . "." . $attributes['code'];
            array_push($componentCodeFromExcel, $code);
        }

        // (IMPORT DATA CHECKER) compare excel.component with current data component removed
        $criteria = new CDbCriteria();
        $criteria->addNotInCondition('code', $componentCodeFromExcel);
        $removedComponents = Component::model()->findAll($criteria);

//        //(IMPORT DATA CHECKER) compare $removedComponents with realization.package_code
//        $removedComponentsArray = [];
//        foreach ($removedComponents as $r) {
//            array_push($removedComponentsArray, $r->code);
//        }

        if (count($removedComponents) > 0) {
            $criteria = new CDbCriteria();
//            $criteria->addInCondition('package_code', $removedComponentsArray);
            foreach ($removedComponents as $r) {
                $criteria->addSearchCondition('package_code', $r->code, true, 'OR');
            }
            $realizationsError = Realization::model()->findAll($criteria);

            //insert to ComponentError table
            $whereInComponent = [];
            foreach ($realizationsError as $r) {
                $codeArray = explode(".", $r->package_code);
                $code = $codeArray[0] . "." . $codeArray[1] . "." . $codeArray[2] . "." . $codeArray[3] . "." . $codeArray[4]; //get only package code till latest 4 dot (.)
                array_push($whereInComponent, $code);
            }
            $criteria = new CDbCriteria();
            $criteria->addInCondition('code', $whereInComponent);
            $componentsError = Component::model()->findAll($criteria);
            foreach ($componentsError as $s) {
                $model = new ComponentError();
                $model->attributes = [
                    'code' => $s->code,
                    'satker_code' => $s->satker_code,
                    'activity_code' => $s->activity_code,
                    'output_code' => $s->output_code,
                    'suboutput_code' => $s->suboutput_code,
                    'name' => $s->name,
                ];
                $model->save();
            }
            if (count($componentsError) > 0) {
                unlink($filePath);
                Yii::app()->user->setFlash('error', "Terdapat data terhapus di RKAKL, dimana data tsb sudah terealisasi.");
                $this->redirect(array('import'));
            }
        }
        /* ===== EOF (IMPORT DATA CHECKER) check if RKAKL data component already removed, but app master data already realize === */
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
            $code = $codeArray[0] . "." . $codeArray[1] . "." . $codeArray[2] . "." . $codeArray[3]. "." . $codeArray[4]; //get only package code till latest 4 dot (.)
            array_push($realizationCodeArray, $code);
        }

        $criteria = new CDbCriteria();
        $criteria->addNotInCondition('code', $realizationCodeArray);
        $componentsAllowDelete = Component::model()->findAll($criteria);

        foreach ($componentsAllowDelete as $s) {
            //remove components
            $s->delete();
        }

        if (count($componentsAllowDelete) < Component::model()->count()) {
            Yii::app()->user->setFlash('error', "Terdapat beberapa data yang sudah terealisasi, sehingga data tidak bisa dihapus.");
            $this->redirect(array('index'));
        }

//        //Check record data on database
//        $exist = Component::model()->exists();
//        if ($exist) {
//            //Clear Data
//            Yii::app()->db->createCommand()->truncateTable(Component::model()->tableName());
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
        $models = Component::model()->findAll();
        /** Error reporting */
        $this->excelErrorReport();

        /** PHPExcel_IOFactory */
        $objReader = new PHPExcel;
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $path = Yii::app()->basePath . '/../export/component.xlsx';
        $pathExport = Yii::app()->basePath . '/../files/Master Komponen.xlsx';
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
     * Export Data to Excel
     */
    public function actionExportError() {
        /** Get model */
        $models = ComponentError::model()->findAll();
        /** Error reporting */
        $this->excelErrorReport();

        /** PHPExcel_IOFactory */
        $objReader = new PHPExcel;
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $path = Yii::app()->basePath . '/../export/component.xlsx';
        $pathExport = Yii::app()->basePath . '/../files/Error Komponen.xlsx';
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
                $sheet->setCellValueExplicit('D' . $row, isset($model->suboutput_code) ? str_replace($model->output_code . '.', '', $model->suboutput_code) : NULL, PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('E' . $row, isset($model->code) ? str_replace($model->suboutput_code . '.', '', $model->code) : NULL, PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValue('F' . $row, isset($model->name) ? $model->name : NULL);
            }
        }
        $objPHPExcel->getActiveSheet()->setTitle('Komponen');
    }

}
