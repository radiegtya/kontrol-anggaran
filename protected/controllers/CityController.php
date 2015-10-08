<?php

class CityController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    public $title = 'Kab / Kota';

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
        return VAuth::getAccessRules('city', array('search', 'export', 'import', 'clear'));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->title = 'Rincian Kota';
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $this->title = 'Tambah Kab/Kota';
        $model = new City;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['City'])) {
            $model->attributes = $_POST['City'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Data successfully created');
                //$this->redirect(array('view','id'=>$model->id));
                $this->redirect(array('index'));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionImport() {
        $this->title = 'Import Kab/Kota';
        $model = new City;
        if (isset($_POST['City'])) {
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
                        'name' => 'province_code', //Kode Provinsi
                        'col' => 0,
                    ),
                    array(
                        'name' => 'code', //Kode Kab/Kota
                        'col' => 1,
                    ),
                    array(
                        'name' => 'name', //Nama Kab/Kota
                        'col' => 2,
                    ),
                );
//                $this->checkaja($filePath, $fields);
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
        $this->title = 'Update Kab/Kota';
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['City'])) {
            $model->attributes = $_POST['City'];

            if ($model->update()) {
                Yii::app()->user->setFlash('success', 'Data successfully updated');
                //$this->redirect(array('view','id'=>$model->id));
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
        $this->title = 'Daftar Kab/Kota';
        $model = new City('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['City']))
            $model->attributes = $_GET['City'];
        $this->render('index', array(
            'model' => $model,
        ));
    }

    /*
     * edit data through view
     */

    public function actionEditable() {
        Yii::import('bootstrap.widgets.TbEditableSaver');
        $es = new TbEditableSaver('City');
        $es->update();
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = City::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model, $formId = 'city-form') {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'city-form') {
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
            if ($fieldValidate['province_code'] == 'Kode Provinsi' AND $fieldValidate['code'] == 'Kode Kab/Kota' AND $fieldValidate['name'] == 'Nama Kab/Kota') {
                $validated = TRUE;
            }
            //end of validation
            if ($validated == TRUE) {
                $highestRow = $worksheet->getHighestRow(); // e.g. 10
                $isSuccess = FALSE;
                //Read data
                for ($row = $startingRow; $row <= $highestRow; ++$row) {
                    $attributes = array();
                    for ($col = 0; $col < count($fields); ++$col) {
                        $val = $worksheet->getCellByColumnAndRow($fields[$col]['col'], $row)->getValue();
                        $attributes[$fields[$col]['name']] = $val;
                    }
                    //Define code from readed data
                    $code = $attributes['province_code'] . '.' . $attributes['code'];
                    if ($attributes['province_code'] != NULL AND $attributes['code'] != NULL AND $attributes['name'] != NULL) {
                        //Check data is new record or old record
                        $recorded = City::model()->find(array('condition' => "code='$code'"));
                        if ($recorded) {
                            //If old record, update data
                            $recorded->attributes = $attributes;
                            $recorded->code = $code;
                            $recorded->name = ucwords(strtolower($attributes['name']));
                            if ($recorded->update()) {
                                $isSuccess = TRUE;
                            }
                        } else {
                            //If new record, create new data
                            $model = new City;
                            $model->attributes = $attributes;
                            $model->code = $code;
                            $model->name = ucwords(strtolower($attributes['name']));
                            if ($model->save()) {
                                $isSuccess = TRUE;
                            } 
                        }
                    }
                }
                if ($isSuccess) {
                    unlink($filePath);
                    Yii::app()->user->setFlash('success', "Data berhasil diimport.");
                    $this->redirect(array('index'));
                }else{
                    unlink($filePath);
                    Yii::app()->user->setFlash('error', "Mohon masukkan data secara lengkap.");
                }
            } else {
                //Process if operator input wrong file
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
        $exist = City::model()->exists();
        if ($exist) {
            //Clear Data
            Yii::app()->db->createCommand()->truncateTable(City::model()->tableName());
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
        $models = City::model()->findAll();
        /** Error reporting */
        $this->excelErrorReport();

        /** PHPExcel_IOFactory */
        $objReader = new PHPExcel;
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $path = Yii::app()->basePath . '/../export/city.xlsx';
        $pathExport = Yii::app()->basePath . '/../files/Master Kab Kota.xlsx';
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
        $referenceRow = 2;
        $reference = Province::model()->findAll();
        //Write main data that used on import to cell
        if ($models) {
            foreach ($models as $model) {
                $provinceCode = $model->province_code;
                $cityCode = str_replace($provinceCode . '.', '', $model->code);
                $sheet->setCellValueExplicit('A' . ++$row, $provinceCode, PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('B' . $row, $cityCode, PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValue('C' . $row, isset($model->name) ? $model->name : NULL);
            }
        }
        //Write reference data to cell
        if ($reference) {
            foreach ($reference as $data) {
                $sheet->setCellValueExplicit('D' . ++$referenceRow, isset($data->code) ? $data->code : NULL, PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValue('E' . $referenceRow, isset($data->name) ? $data->name : NULL);
            }
        }
        $objPHPExcel->getActiveSheet()->setTitle('Daftar Kota');
    }

    public function checkaja($filePath, $fields = array(), $model = null, $startingRow = 2) {
        $objPHPExcel = PHPExcel_IOFactory::load($filePath);
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            //field validation
            $fieldValidate = array();
            $validated = FALSE;
            for ($col = 0; $col < count($fields); ++$col) {
                $val = $worksheet->getCellByColumnAndRow($fields[$col]['col'], 1)->getValue();
                $fieldValidate[$fields[$col]['name']] = $val;
            }
            if ($fieldValidate['province_code'] == 'Kode Provinsi' AND $fieldValidate['code'] == 'Kode Kab/Kota' AND $fieldValidate['name'] == 'Nama Kab/Kota') {
                $validated = TRUE;
            }
            //end of validation
            if ($validated == TRUE) {
                $highestRow = $worksheet->getHighestRow(); // e.g. 10
                $cityCode = array();
                for ($row = $startingRow; $row <= $highestRow; ++$row) {
                    $attributes = array();
                    for ($col = 0; $col < count($fields); ++$col) {
                        $val = $worksheet->getCellByColumnAndRow($fields[$col]['col'], $row)->getValue();
                        $attributes[$fields[$col]['name']] = $val;
                    }
                    if ($attributes['province_code'] != NULL && $attributes['code'] != NULL) {
                        $code = $attributes['province_code'] . "." . $attributes['code'];
                        array_push($cityCode, $code);
                    }
                }
                print_r($cityCode);
//                $deletedRecords = City::model()->findAllBySql("SELECT * FROM city WHERE city.code NOT IN ($newArray)");
//                if ($deletedRecords) {
//                  print_r($deletedRecords->code);   
//                }
                unlink($filePath);
            } else {
                unlink($filePath);
                Yii::app()->user->setFlash('error', "Pastikan file yang Anda upload sudah benar!");
                $this->redirect(array('import'));
            }
        }
    }

}
