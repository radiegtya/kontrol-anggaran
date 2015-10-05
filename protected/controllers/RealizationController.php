<?php

class RealizationController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    public $title = 'Realisasi';

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
        return VAuth::getAccessRules('realization', array('clear', 'export', 'entry', 'import', 'clearError', 'exportError'));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Realization;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Realization'])) {
            $model->attributes = $_POST['Realization'];
            $code = $_POST['Realization']['packageAccount_code'];
            $packageAccount = PackageAccount::model()->findByAttributes(array('code' => "$code"));
            if ($packageAccount) {
                $model->package_code = $packageAccount->package_code;
            }

            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Data successfully created');
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
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Realization'])) {
            $model->attributes = $_POST['Realization'];

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
        $this->title = 'Daftar Realisasi';
        //Check existed dipa (used to show & hide submit button)
        $showContent = FALSE;
        $parent = Package::model()->exists();
        $errors = ErrorRealization::model()->findAll();
        $limit = array();
        $realization = array();
        $rest = array();
        if ($errors) {
            foreach ($errors as $data) {
                $limit[$data->packageAccount_code] = 0;
                $realization[$data->packageAccount_code] = 0;
                $rest[$data->packageAccount_code] = 0;

                $pAccount = PackageAccount::model()->findByAttributes(array('code' => "$data->packageAccount_code"));
                if ($pAccount) {
                    $limit[$data->packageAccount_code] = $pAccount->limit;
                    $realization[$data->packageAccount_code] = PackageAccount::model()->getTotal($pAccount->code)['realization'];
                    $rest[$data->packageAccount_code] = PackageAccount::model()->getTotal($pAccount->code)['restMoney'];
                }
            }
        }
        if ($parent) {
            $showContent = TRUE;
        }
        $model = new Realization('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Realization']))
            $model->attributes = $_GET['Realization'];

        $this->render('index', array(
            'model' => $model,
            'showContent' => $showContent,
            'errors' => $errors,
            'limit' => $limit,
            'realization' => $realization,
            'rest' => $rest,
        ));
    }

    /*
     * edit data through view
     */

    public function actionEditable() {
        Yii::import('bootstrap.widgets.TbEditableSaver');
        $es = new TbEditableSaver('Realization');
        $es->update();
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Realization::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model, $formId = 'realization-old-form') {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'realization-old-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionClear() {
        //Check record data on database
        $exist = Realization::model()->exists();
        if ($exist) {
            //Clear Data
            Yii::app()->db->createCommand()->truncateTable(Realization::model()->tableName());
            Yii::app()->user->setFlash('success', 'Data berhasil dibersihkan.');
            $this->redirect(array('index'));
        } else {
            Yii::app()->user->setFlash('error', 'Data tidak ditemukan.');
            $this->redirect(array('index'));
        }
    }

    public function actionClearError() {
        //Check record data on database
        $exist = ErrorRealization::model()->exists();
        if ($exist) {
            //Clear Data
            Yii::app()->db->createCommand()->truncateTable(ErrorRealization::model()->tableName());
            Yii::app()->user->setFlash('success', 'Notifikasi error berhasil dibersihkan.');
            $this->redirect(array('index'));
        } else {
            Yii::app()->user->setFlash('error', 'Data tidak ditemukan.');
            $this->redirect(array('index'));
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionEntry() {
        $model = new Realization;

        if (isset($_POST['packageAccount_code'])) {
            $total = count($_POST['packageAccount_code']);
            for ($i = 0; $i <= $total; $i++) {
                if (isset($_POST['packageAccount_code'][$i]) && $_POST['packageAccount_code'][$i] != NULL && $_POST['total_spm'][$i] != NULL) {
                    $overlimit = PackageAccount::model()->overlimit($_POST['packageAccount_code'][$i], $_POST['total_spm'][$i]);
                    $code = $_POST['packageAccount_code'][$i];
                    $packageAccount = PackageAccount::model()->findByAttributes(array('code' => "$code"));
                    $packageCode = NULL;
                    if ($packageAccount) {
                        $packageCode = $packageAccount->package_code;
                    }
                    if ($overlimit == TRUE) {
                        $error = new ErrorRealization();
                        $error->packageAccount_code = $_POST['packageAccount_code'][$i];
                        $error->package_code = $packageCode;
                        $error->total_spm = $_POST['total_spm'][$i];
                        $error->spm_number = $_POST['spm_number'][$i];
                        $error->spm_date = $_POST['spm_date'][$i];
                        $error->up_ls = $_POST['up_ls'][$i];
                        $error->description = "Terjadi pagu minus pada akun paket $code";
                        $error->save();

                        Yii::app()->user->setFlash('error', "Terjadi pagu minus pada akun paket $code");
                        $this->redirect(array('index'));
                    } else {
                        $data = new Realization();
                        $data->packageAccount_code = $_POST['packageAccount_code'][$i];
                        $data->package_code = $packageCode;
                        $data->total_spm = $_POST['total_spm'][$i];
                        $data->spm_number = $_POST['spm_number'][$i];
                        $data->spm_date = $_POST['spm_date'][$i];
                        $data->up_ls = $_POST['up_ls'][$i];
                        $data->save();

                        Yii::app()->user->setFlash('success', "Data berhasil disimpan.");
                        $this->redirect(array('index'));
                    }
                } else {
                    Yii::app()->user->setFlash('error', "Mohon isikan Kode Akun Paket dan Total SPM.");
                }
            }
        }
        $this->render('entry', array(
            'model' => $model,
        ));
    }

    public function actionImport() {
        $this->title = 'Import Realisasi';
        $model = new Realization;
        if (isset($_POST['Realization'])) {
            $model->file = CUploadedFile::getInstance($model, "file");
            if (!$model->file) {
                Yii::app()->user->setFlash('error', 'Pastikan file telah diisi.');
                $this->redirect('entry');
            }
            $filePath = Yii::getPathOfAlias('webroot') . "/imports/" . $model->file;
            if ($model->file->saveAs($filePath)) {
                $objPHPExcel = new PHPExcel();
                $fields = array(
                    array(
                        'name' => 'packageAccount_code', //akun paket code
                        'col' => 1,
                    ),
//                    array(
//                        'name' => 'total_realized', //Akumulasi realisasi akun paket
//                        'col' => 5,
//                    ),
                    array(
                        'name' => 'total_spm', //jumlah spm
                        'col' => 6,
                    ),
                    array(
                        'name' => 'up_ls', //UP/LS
                        'col' => 7,
                    ),
                    array(
                        'name' => 'ppn', //PPN
                        'col' => 8,
                    ),
                    array(
                        'name' => 'pph', //PPH
                        'col' => 9,
                    ),
                    array(
                        'name' => 'receiver', //Penerima
                        'col' => 10,
                    ),
                    array(
                        'name' => 'nrs', //Nomor Register Suplier
                        'col' => 11,
                    ),
                    array(
                        'name' => 'nrk', //Nomor Register Kontrak
                        'col' => 12,
                    ),
                    array(
                        'name' => 'spm_number', //Nomor Register Kontrak
                        'col' => 13,
                    ),
                    array(
                        'name' => 'spm_date', //Nomor Register Kontrak
                        'col' => 14,
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
            if ($fieldValidate['packageAccount_code'] == 'Kode Akun Paket' AND $fieldValidate['total_spm'] == 'Realisasi sampai saat ini') {
                $validated = TRUE;
            }
            //end of validation
            if ($validated == TRUE) {
                $highestRow = $worksheet->getHighestRow(); // e.g. 10
                $highestColumn = $worksheet->getHighestColumn();
                //Doing import data
                for ($row = $startingRow; $row <= $highestRow; ++$row) {
                    $attributes = array();
                    for ($col = 0; $col < count($fields); ++$col) {
                        $val = $worksheet->getCellByColumnAndRow($fields[$col]['col'], $row)->getCalculatedValue();
                        $attributes[$fields[$col]['name']] = $val;
                    }
                    if ($attributes['packageAccount_code'] != NULL AND $attributes['total_spm'] != NULL AND $attributes['total_spm'] != 0) {
                        $packageAccountCode = isset($attributes['packageAccount_code']) ? trim($attributes['packageAccount_code'], " \t\n\r\0\x0B") : NULL;
                        $overlimitValidate = PackageAccount::model()->overlimit($packageAccountCode, $attributes['total_spm']);
                        if ($overlimitValidate == FALSE) {
                            $model = new Realization;
                            $model->packageAccount_code = $packageAccountCode;
                            $pA = PackageAccount::model()->findByAttributes(array('code' => "$packageAccountCode"));
                            $packageCode = NULL;
                            if ($pA) {
                                $packageCode = $pA->package_code;
                            }
                            $model->package_code = $packageCode;
                            $model->total_spm = $attributes['total_spm'];
                            $model->up_ls = $attributes['up_ls'];
                            $model->ppn = $attributes['ppn'];
                            $model->pph = $attributes['pph'];
                            $model->receiver = $attributes['receiver'];
                            $model->nrs = $attributes['nrs'];
                            $model->nrk = $attributes['nrk'];
                            $model->spm_number = $attributes['spm_number'];
                            $model->spm_date = $attributes['spm_date'];
                            $model->save();
                        } else {
                            $errorModel = new ErrorRealization;
                            $errorModel->packageAccount_code = $packageAccountCode;
                            $pA = PackageAccount::model()->findByAttributes(array('code' => "$packageAccountCode"));
                            $packageCode = NULL;
                            if ($pA) {
                                $packageCode = $pA->package_code;
                            }
                            $errorModel->package_code = $packageCode;
                            $errorModel->total_spm = $attributes['total_spm'];
                            $errorModel->up_ls = $attributes['up_ls'];
                            $errorModel->ppn = $attributes['ppn'];
                            $errorModel->pph = $attributes['pph'];
                            $errorModel->receiver = $attributes['receiver'];
                            $errorModel->nrs = $attributes['nrs'];
                            $errorModel->nrk = $attributes['nrk'];
                            $errorModel->spm_number = $attributes['spm_number'];
                            $errorModel->spm_date = $attributes['spm_date'];
                            $errorModel->description = 'Terjadi pagu minus.';
                            $errorModel->save();
                        }
                    }
                }
                //Action when import process done
                unlink($filePath);
                Yii::app()->user->setFlash('success', "Data realisasi berhasil diinput.");
                $this->redirect(array('index'));
            } else {
                unlink($filePath);
                Yii::app()->user->setFlash('error', "Pastikan file yang Anda upload sudah benar!");
                $this->redirect(array('entry'));
            }
        }
    }

    /**
     * Export data form
     */
    public function actionExport() {
        /** Get model */
        $models = PackageAccount::model()->findAll();
        /** Error reporting */
        $this->excelErrorReport();

        /** PHPExcel_IOFactory */
        $objReader = new PHPExcel;
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $path = Yii::app()->basePath . '/../export/realizationForm.xlsx';
        $pathExport = Yii::app()->basePath . '/../files/Form Realisasi.xlsx';
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
     * Export data form
     */
    public function actionExportError() {
        /** Get model */
        $models = ErrorRealization::model()->findAll();
        /** Error reporting */
        $this->excelErrorReport();

        /** PHPExcel_IOFactory */
        $objReader = new PHPExcel;
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $path = Yii::app()->basePath . '/../export/realizationError.xlsx';
        $pathExport = Yii::app()->basePath . '/../files/Error Realisasi.xlsx';
        $objPHPExcel = $objReader->load($path);
        $objPHPExcel->setActiveSheetIndex(0);

        /* " Add new data to template" */
        $this->exportExcelError($objPHPExcel, $models);
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
        $number = 0;
        $models = PackageAccount::model()->findAll();
        if ($models) {
            foreach ($models as $model) {
                $package = Subcomponent::model()->findByAttributes(array('code' => "$model->package_code"));
                $account = Account::model()->findByAttributes(array('code' => "$model->account_code"));
                $packageName = isset($package->name) ? $package->name : NULL;
                $accountName = isset($account->name) ? $account->name : NULL;
                $sheet->setCellValue('A' . ++$row, ++$number);
                $sheet->setCellValueExplicit('B' . $row, $model->code, PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValue('C' . $row, $packageName);
                $sheet->setCellValue('D' . $row, $accountName);
                $sheet->setCellValue('E' . $row, $model->limit);
                $sheet->setCellValue('F' . $row, PackageAccount::model()->getTotal("$model->code")['realization']);
                $sheet->setCellValue('G' . $row, 0);
            }
        }
        $objPHPExcel->getActiveSheet()->setTitle('Realisasi');
    }

    //Write data to excel cell
    private function exportExcelError($objPHPExcel, $models) {
        $sheet = $objPHPExcel->getActiveSheet();
        $row = 1;
        if ($models) {
            foreach ($models as $data) {
                $limit[$data->packageAccount_code] = 0;
                $realization[$data->packageAccount_code] = 0;
                $rest[$data->packageAccount_code] = 0;

                $pAccount = PackageAccount::model()->findByAttributes(array('code' => "$data->packageAccount_code"));
                
                $sheet->setCellValue('A' . ++$row, $data->packageAccount_code);
                $sheet->setCellValue('B' . $row, $pAccount->limit);
                $sheet->setCellValue('C' . $row, PackageAccount::model()->getTotal($pAccount->code)['realization']);
                $sheet->setCellValue('D' . $row, PackageAccount::model()->getTotal($pAccount->code)['restMoney']);
                $sheet->setCellValue('E' . $row, $data->total_spm);
                $sheet->setCellValue('F' . $row, $data->description);
            }
        }
        $objPHPExcel->getActiveSheet()->setTitle('Realisasi');
    }

    public function actionGetPackageAccountOptionsCodeName() {
        echo json_encode(PackageAccount::model()->getOptionsCodeName());
    }

}
