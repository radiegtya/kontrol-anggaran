<?php

class PpkController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    public $title = 'PPK';

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
        return VAuth::getAccessRules('ppk', array('export', 'import', 'clear'));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->title = 'Rincian PPK';
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $this->title = 'Tambah PPK';
        $model = new Ppk;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Ppk'])) {
            $model->attributes = $_POST['Ppk'];
            //upload image
//            $VUpload = new VUpload();
//            $VUpload->path = 'images/ppk/';
//            $VUpload->doUpload($model, 'image');
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Data successfully created');
                //$this->redirect(array('view','id'=>$model->code));
                $this->redirect(array('index'));
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
        $this->title = 'Update PPK';
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Ppk'])) {
            $model->attributes = $_POST['Ppk'];
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
        $this->title = 'Daftar PPK';
        $model = new Ppk('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Ppk']))
            $model->attributes = $_GET['Ppk'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /*
     * edit data through view
     */

    public function actionEditable() {
        Yii::import('bootstrap.widgets.TbEditableSaver');
        $es = new TbEditableSaver('Ppk');
        $es->update();
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Ppk::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model, $formId = 'ppk-form') {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'ppk-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Import data from excel template
     */
    public function actionImport() {
        $this->title = 'Import Ppk';
        $model = new Ppk;
        if (isset($_POST['Ppk'])) {
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
                        'name' => 'code', //code
                        'col' => 0,
                    ),
                    array(
                        'name' => 'ppk_name', //Ppk Name
                        'col' => 1,
                    ),
                    array(
                        'name' => 'official_name', //Official Name
                        'col' => 2,
                    ),
                    array(
                        'name' => 'official_nip', //Official NIP
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
     * Export data to excel
     */
    public function actionExport() {
        /** Get model */
        $models = Ppk::model()->findAll();
        /** Error reporting */
        $this->excelErrorReport();

        /** PHPExcel_IOFactory */
        $objReader = new PHPExcel;
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $path = Yii::app()->basePath . '/../export/ppk.xlsx';
        $pathExport = Yii::app()->basePath . '/../files/Master Ppk.xlsx';
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
                $sheet->setCellValueExplicit('A' . ++$row, isset($model->code) ? $model->code : NULL, PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValue('B' . $row, isset($model->ppk_name) ? $model->ppk_name : NULL);
                $sheet->setCellValue('C' . $row, isset($model->official_name) ? $model->official_name : NULL);
                $sheet->setCellValue('D' . $row, isset($model->official_nip) ? $model->official_nip : NULL);
            }
        }
        $objPHPExcel->getActiveSheet()->setTitle('Daftar PPK');
    }

//Write data to database
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
            if ($fieldValidate['code'] == 'Kode PPK' AND $fieldValidate['ppk_name'] == 'Nama Kegiatan PPK' AND $fieldValidate['official_name'] == 'Nama Pejabat PPK' AND $fieldValidate['official_nip'] == 'NIP Pejabat PPK') {
                $validated = TRUE;
            }
            //end of validation
            $isSuccess = FALSE;
            if ($validated == TRUE) {
                $highestRow = $worksheet->getHighestRow(); // e.g. 10
                for ($row = $startingRow; $row <= $highestRow; ++$row) {
                    $attributes = array();
                    for ($col = 0; $col < count($fields); ++$col) {
                        $val = $worksheet->getCellByColumnAndRow($fields[$col]['col'], $row)->getValue();
                        $attributes[$fields[$col]['name']] = $val;
                    }
                    if ($attributes['code'] != NULL && $attributes['ppk_name'] != NULL && $attributes['official_name'] != NULL && $attributes['official_nip'] != NULL) {
                        $code = $attributes['code'];
                        $recorded = Ppk::model()->find(array('condition' => "code='$code'"));
                        if ($recorded) {
                            $recorded->attributes = $attributes;
                            if ($recorded->update()) {
                                $isSuccess = TRUE;
                            }
                        } else {
                            $model = new Ppk;
                            $model->attributes = $attributes;
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
                } else {
                    unlink($filePath);
                    Yii::app()->user->setFlash('error', "Mohon isikan data secara lengkap.");
                }
            } else {
                unlink($filePath);
                Yii::app()->user->setFlash('error', "Pastikan file yang Anda upload sudah benar!");
                $this->redirect(array('import'));
            }
        }
    }

    //Clear All Data
    public function actionClear() {
        //Check record data on database
        $exist = Ppk::model()->exists();
        if ($exist) {
            //Clear Data
            Yii::app()->db->createCommand()->truncateTable(Ppk::model()->tableName());
            Yii::app()->user->setFlash('success', 'Data berhasil dibersihkan.');
            $this->redirect(array('index'));
        } else {
            Yii::app()->user->setFlash('error', 'Data tidak ditemukan.');
            $this->redirect(array('index'));
        }
    }

}
