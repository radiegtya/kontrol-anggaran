<?php

class PackageController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    public $title = 'Paket';

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
        return VAuth::getAccessRules('package', array('getCity', 'clear', 'export', 'entry', 'input', 'childUpdate','index'));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->title = 'Rincian Paket';
        $packageAccount = new PackageAccount('searchPackage');
//        $realization = new Realization('searchPackage');
        $packageAccount->unsetAttributes();  // clear any default values
//        $realization->unsetAttributes();  // clear any default values
        if (isset($_GET['PackageAccount']))
            $model->attributes = $_GET['PackageAccount'];
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'packageAccount' => $packageAccount,
//            'realization' => $realization,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $this->title = 'Tambah Paket';
        $model = new Package;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Package'])) {
            if ($_POST['Package']['code'] == NULL && $_POST['Package']['province_code'] == NULL && $_POST['Package']['city_code'] == NULL && $_POST['Package']['ppk_code'] == NULL) {
                Yii::app()->user->setFlash('error', 'Mohon isikan data pada form.');
            } else {
                $model->attributes = $_POST['Package'];
                $model->code = $_POST['Package']['code'];
                $dipa = Dipa::model()->find(array('order' => 'id DESC'));
                $budgets = Budget::model()->findAllByAttributes(array('subcomponent_code' => "$model->code", 'dipa_id' => $dipa->id));
                $budgetAttributes = Budget::model()->findByAttributes(array('subcomponent_code' => "$model->code"));
                $limit = 0;
                foreach ($budgets as $budget) {
                    $limit +=$budget->total_budget_limit;
                }
                $model->limit = $limit;
                $model->satker_code = $budgetAttributes->satker_code;
                $model->activity_code = $budgetAttributes->activity_code;
                $model->output_code = $budgetAttributes->output_code;
                $model->suboutput_code = $budgetAttributes->suboutput_code;
                $model->component_code = $budgetAttributes->component_code;
                $model->name = $budgetAttributes->subcomponentCode->name;
                $model->up = 'LS';
                if ($model->save()) {
                    foreach ($budgets as $budget) {
                        $packageAccount = new PackageAccount;
                        $packageAccount->package_code = $model->code;
                        $packageAccount->province_code = $model->province_code;
                        $packageAccount->city_code = $model->city_code;
                        $packageAccount->ppk_code = $model->ppk_code;
                        $packageAccount->code = $budget->code;
                        $packageAccount->budget_code = $budget->code;
                        $packageAccount->satker_code = $budget->satker_code;
                        $packageAccount->activity_code = $budget->activity_code;
                        $packageAccount->output_code = $budget->output_code;
                        $packageAccount->suboutput_code = $budget->suboutput_code;
                        $packageAccount->component_code = $budget->component_code;
                        $packageAccount->account_code = $budget->account_code;
                        $packageAccount->limit = $budget->total_budget_limit;
                        $packageAccount->up = 'LS';
                        $packageAccount->save();
                    }
                    Yii::app()->user->setFlash('success', 'Data berhasil ditambahkan.');
                    //$this->redirect(array('view','id'=>$model->id));
                    $this->redirect(array('index'));
                }
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
        $this->title = 'Update Paket';
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Package'])) {
            $model->attributes = $_POST['Package'];


            if ($model->save()) {
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
            if ($model->getTotal($model->code)['realization'] > 0) {
                Yii::app()->user->setFlash('error', 'Paket sudah direalisasi. Paket gagal dihapus.');
            } else {
                $code = $model->code;
                if ($model->delete()) {
                    $packageAccounts = PackageAccount::model()->findAllByAttributes(array('package_code' => $code));
                    if ($packageAccounts) {
                        foreach ($packageAccounts as $packageAccount) {
                            $packageAccount->delete();
                        }
                    }
                }
            }
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
        $this->title = 'Daftar Paket';
        $model = new Package('search');
        $model->unsetAttributes();  // clear any default values
        //Check existed dipa (used to show & hide submit button)
        $showContent = FALSE;
        $parent = Dipa::model()->exists();
        if ($parent) {
            $showContent = TRUE;
        }
        //Admin search data record
        if (isset($_GET['Package']))
            $model->attributes = $_GET['Package'];

        $this->render('index', array(
            'model' => $model,
            'showContent' => $showContent,
        ));
    }

    /*
     * edit data through view
     */

    public function actionExport() {
        $models = Package::model()->findAll();
        //code
        $objPHPExcel = new PHPExcel();
        /** Error reporting */
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        date_default_timezone_set('Europe/London');
        /** PHPExcel_IOFactory */
        $objReader = new PHPExcel;
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $path = Yii::app()->basePath . '/../export/template.xlsx';
        $pathExport = Yii::app()->basePath . '/../export/daftar paket.xlsx';
        $objPHPExcel = $objReader->load($path);
        $objPHPExcel->setActiveSheetIndex(0);
//       " Add new data to the template"
        $sheet = $objPHPExcel->getActiveSheet();
        $row = 5;
        $rowData1 = $row - 1;
        $rowData2 = $row - 1;
        $rowData3 = $row - 1;
        $rowData4 = $row - 1;
        $rowData5 = $row - 1;
        $sheet->insertNewRowBefore($row, (count($models) - 1));
        for ($i = 1; $i <= count($models); $i++) {
            $sheet->setCellValue('A' . (($row - 2) + $i), $i);
        }
        foreach ($models as $model) {
            $sheet->setCellValue('B' . $rowData1++, "$model->code");
            $sheet->setCellValueExplicit('C' . $rowData2++, $model->ppk_code, PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValue('D' . $rowData3++, $model->limit);
            $sheet->setCellValue('E' . $rowData4++, $model->getTotal($model->code)["realization"]);
            $sheet->setCellValue('F' . $rowData5++, $model->getTotal($model->code)["restMoney"]);
        }
        $objPHPExcel->getActiveSheet()->setTitle('Daftar Paket');

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
        readfile($pathExport);
        unlink($pathExport);
        exit;
//code
    }

    public function actionEditable() {
        Yii::import('bootstrap.widgets.TbEditableSaver');
        $es = new TbEditableSaver('Package');
        $es->onBeforeUpdate = function($event) {
            $event->sender->setAttribute('updated_at', date('Y-m-d H:i:s'));
        };
        $es->update();
        echo CJSON::encode($es);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Package::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model, $formId = 'package-form') {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'package-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGetCity() {
        $parentId = $_POST['province'];
        $model = City::model()->findAllByAttributes(array(//set the model according to your model Class Name
            'province_code' => $parentId //set according to your parentId ex:category_id and it must from database FK
        ));

        $option = array('0' => 'Please Select'); //set null value
        $options = CHtml::listData($model, 'code', 'name'); //list data according to your db field
        $options = CMap::mergeArray($option, $options);
        echo json_encode($options);
    }

    /**
     * Input multiple data to database
     */
    public function actionEntry() {
        $model = new Package;
        $lastDipa = Dipa::model()->find(array('order' => 'id DESC'));
        $lastDipaId = $lastDipa->id;

        if (isset($_POST['code'])) {
            if ($lastDipa) {
                $total = count($_POST['code']);
                for ($i = 0; $i <= $total; $i++) {
                    if (isset($_POST['code'][$i]) && $_POST['code'][$i] != NULL && $_POST['ppk_code'][$i] != NULL && $_POST['city_code'][$i] != NULL) {
                        $code = $_POST['code'][$i];
                        //Check existed record
                        $record = Package::model()->findByAttributes(array('code' => $code));
                        if ($record) {
                            $budgets = Budget::model()->findAllByAttributes(array('subcomponent_code' => "$record->code", 'dipa_id' => "$lastDipaId"));
                            $record->ppk_code = $_POST['ppk_code'][$i];                            
                            $record->city_code = $_POST['city_code'][$i];
                            $record->province_code = City::model()->findByAttributes(array('code'=>"$record->city_code"))->province_code;
                            if ($budgets) {
                                foreach ($budgets as $budgetData) {
                                    $pAccount = PackageAccount::model()->findByAttributes(array('code' => "$budgetData->code"));
                                    if ($pAccount) {
                                        $pAccount->limit = $budgetData->total_budget_limit;
                                        $pAccount->ppk_code = $record->ppk_code;
                                        $pAccount->province_code = $record->province_code;
                                        $pAccount->city_code = $record->city_code;
                                        $pAccount->update();
                                    }
                                }
                            }
                            $record->update();
                        } else {
                            $data = new Package();
                            $data->code = $_POST['code'][$i];
                            $budget = Budget::model()->findByAttributes(array('subcomponent_code' => $_POST['code'][$i]), array('order' => 'dipa_id DESC'));
                            if ($budget) {
                                $data->satker_code = "$budget->satker_code";
                                $data->activity_code = "$budget->activity_code";
                                $data->output_code = "$budget->output_code";
                                $data->suboutput_code = "$budget->suboutput_code";
                                $data->name = $budget->subcomponentCode->name;
                                $data->component_code = "$budget->component_code";
                                $data->ppk_code = $_POST['ppk_code'][$i];                                
                                $data->city_code = $_POST['city_code'][$i];
                                $data->province_code = City::model()->findByAttributes(array('code'=>"$data->city_code"))->province_code;
                                $budgets = Budget::model()->findAllByAttributes(array('subcomponent_code' => "$data->code", 'dipa_id' => "$lastDipaId"));
                                if ($budgets) {
                                    foreach ($budgets as $dataBudget) {
                                        $paModel = new PackageAccount();
                                        $paModel->code = "$dataBudget->code";
                                        $paModel->satker_code = "$dataBudget->satker_code";
                                        $paModel->activity_code = "$dataBudget->activity_code";
                                        $paModel->output_code = "$dataBudget->output_code";
                                        $paModel->suboutput_code = "$dataBudget->suboutput_code";
                                        $paModel->component_code = "$dataBudget->component_code";
                                        $paModel->package_code = "$dataBudget->subcomponent_code";
                                        $paModel->account_code = "$dataBudget->account_code";
                                        $paModel->ppk_code = "$data->ppk_code";
                                        $paModel->province_code = "$data->province_code";
                                        $paModel->city_code = "$data->city_code";
                                        $paModel->limit = "$dataBudget->total_budget_limit";
                                        $paModel->save();
                                    }
                                }
                                $data->save();
                            } else {
                                Yii::app()->user->setFlash('notice', 'Data DIPA belum diinput dengan lengkap. Beberapa data informasi tambahan gagal ditambahkan.');
                                $this->redirect(array('index'));
                            }
                        }
                    }
                }
            } else {
                Yii::app()->user->setFlash('error', 'Data DIPA/POK belum diinput.');
                $this->redirect(array('index'));
            }
            Yii::app()->user->setFlash('success', 'Data berhasil disimpan.');
            $this->redirect(array('index'));
        }
        $this->render('entry', array(
            'model' => $model,
        ));
    }

    /**
     * Clear data on database
     */
    public function actionClear() {
        //Check record data on database
        $exist = Package::model()->exists();
        if ($exist) {
            //Clear Data
            Yii::app()->db->createCommand()->truncateTable(Package::model()->tableName());
            Yii::app()->db->createCommand()->truncateTable(PackageAccount::model()->tableName());
            Yii::app()->user->setFlash('success', 'Data berhasil dibersihkan.');
            $this->redirect(array('index'));
        } else {
            Yii::app()->user->setFlash('error', 'Data tidak ditemukan.');
            $this->redirect(array('index'));
        }
    }

    /**
     * Updata package_account data after editable column successfully updated
     */
    public function actionChildUpdate() {
        $code = $_GET['code'];
        $provinceCode = $_GET['provinceCode'];
        $cityCode = $_GET['cityCode'];
        $ppkCode = $_GET['ppkCode'];
        $models = PackageAccount::model()->findAllByAttributes(array('package_code' => "$code"));
        if ($models) {
            foreach ($models as $model) {
                $model->province_code = $provinceCode;
                $model->city_code = $cityCode;
                $model->ppk_code = $ppkCode;
                $model->update();
            }
        }
    }

}
