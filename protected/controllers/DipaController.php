<?php

class DipaController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    public $title = 'DIPA/POK';

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
        return VAuth::getAccessRules('dipa', array('clear', 'import', 'printError', 'foo'));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->title = 'Rincian DIPA/POK';
        $budgetModel = new Budget('searchBudget');
        $budgetModel->unsetAttributes();  // clear any default values
        if (isset($_GET['Budget']))
            $model->attributes = $_GET['Budget'];
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'budgetModel' => $budgetModel,
            'id' => $id,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $this->title = 'Tambah DIPA/POK';
        //Check Completeness data of master
        $showContent = $this->checkMaster();
        $model = new Dipa;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Dipa'])) {
            $model->attributes = $_POST['Dipa'];
            $model->file = CUploadedFile::getInstance($model, "file");
            $year = isset($_POST['Dipa']['budget_year']) ? $_POST['Dipa']['budget_year'] : NULL;
            $status = $this->checkYear($year);
            if ($status == FALSE) {
                Yii::app()->user->setFlash('error', 'Tahun anggaran berbeda, silahkan bersihkan data terlebih dahulu.');
                $this->redirect(array('index'));
            } elseif (!$model->file) {
                Yii::app()->user->setFlash('error', 'Pastikan file telah diisi.');
            } else {
                $filePath = Yii::getPathOfAlias('webroot') . "/imports/" . $model->file;
                if ($model->file->saveAs($filePath)) {
                    $objPHPExcel = new PHPExcel();
                    $fields = array(
                        array(
                            'name' => 'budget_year', //code
                            'col' => 0,
                        ),
                        array(
                            'name' => 'satker_code', //satker
                            'col' => 1,
                        ),
                        array(
                            'name' => 'activity_code', //satker
                            'col' => 5,
                        ),
                        array(
                            'name' => 'output_code', //satker
                            'col' => 6,
                        ),
                        array(
                            'name' => 'suboutput_code', //satker
                            'col' => 7,
                        ),
                        array(
                            'name' => 'component_code', //satker
                            'col' => 8,
                        ),
                        array(
                            'name' => 'subcomponent_code', //satker
                            'col' => 9,
                        ),
                        array(
                            'name' => 'account_code', //satker
                            'col' => 10,
                        ),
                        array(
                            'name' => 'total_budget_limit', //satker
                            'col' => 11,
                        ),
                    );
                }
                if ($model->save()) {
                    $validated = $this->validateFieldExcel($filePath, $fields);
                    if ($validated == FALSE) {
                        Yii::app()->user->setFlash('error', "Pastikan file yang Anda upload sudah benar!");
                        $filePath = Yii::getPathOfAlias('webroot') . "/imports/" . $model->file;
                        unlink($filePath);
                        $model->delete();
                    } else {
                        $id = $model->id;
                        $this->importExcelToMysql($id, $filePath, $fields);
                    }
                }
            }
        }

        $this->render('create', array(
            'model' => $model,
            'showContent' => $showContent,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $this->title = 'Update DIPA/POK';
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Dipa'])) {
            $model->attributes = $_POST['Dipa'];
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
            $dipa = Dipa::model()->find(array('order' => 'id DESC'));
            $model = $this->loadModel($id);
            if ($dipa->id != $id) {
                Yii::app()->user->setFlash('error', 'Hanya dapat menghapus dipa terakhir');
            } else {
                if ($model->delete()) {
                    $lastDipa = Dipa::model()->find(array('order' => 'id DESC'));
                    $idLastDipa = $lastDipa->id;
                    $packages = Package::model()->findAll();
                    if ($packages) {
                        foreach ($packages as $package) {
                            $budgets = Budget::model()->findAllByAttributes(array('dipa_id' => "$idLastDipa", 'subcomponent_code' => "$package->code"));
                            $limit = 0;
                            foreach ($budgets as $budget) {
                                $limit +=$budget->total_budget_limit;
                            }
                            $package->limit = $limit;
                            if ($package->update()) {
                                $packageAccounts = PackageAccount::model()->findAllByAttributes(array('package_code' => "$package->code"));
                                if ($packageAccounts) {
                                    foreach ($packageAccounts as $packageAccount) {
                                        $budgetAccount = Budget::model()->findByAttributes(array('dipa_id' => $idLastDipa, 'code' => "$packageAccount->code"));
                                        if ($budgetAccount) {
                                            $packageAccount->limit = $budgetAccount->total_budget_limit;
                                            $packageAccount->update();
                                        }
                                    }
                                }
                            }
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
        $this->title = 'Daftar DIPA/POK';
        //Check completeness of all master data
        $showContent = $this->checkMaster();
        $errors = ErrorDipa::model()->findAll();
        $errorCompleteness = ErrorDipaCompleteness::model()->findAll();
        //Search data content to show
        $model = new Dipa('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Dipa']))
            $model->attributes = $_GET['Dipa'];

        $this->render('index', array(
            'model' => $model,
            'showContent' => $showContent,
            'errors' => $errors,
            'errorCompleteness' => $errorCompleteness,
        ));
    }

    /*
     * edit data through view
     */

    public function actionEditable() {
        Yii::import('bootstrap.widgets.TbEditableSaver');
        $es = new TbEditableSaver('Dipa');
        $es->update();
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Dipa::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model, $formId = 'dipa-form') {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'dipa-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function validateFieldExcel($filePath, $fields = array()) {
        $objPHPExcel = PHPExcel_IOFactory::load($filePath);
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            //field validation
            $fieldValidate = array();
            $validate = FALSE;
            for ($col = 0; $col < count($fields); ++$col) {
                $val = $worksheet->getCellByColumnAndRow($fields[$col]['col'], 1)->getValue();
                $fieldValidate[$fields[$col]['name']] = $val;
            }
            if ($fieldValidate['budget_year'] == 'thang' AND $fieldValidate['satker_code'] == 'kdsatker' AND $fieldValidate['activity_code'] == 'kdgiat' AND $fieldValidate['output_code'] == 'kdoutput' AND $fieldValidate['suboutput_code'] == 'kdsoutput' AND $fieldValidate['component_code'] == 'kdkmpnen' AND $fieldValidate['subcomponent_code'] == 'kdskmpnen' AND $fieldValidate['account_code'] == 'kdakun') {
                $validate = TRUE;
            }
            //return value
            return $validate;
        }
    }

    public function importExcelTemporary($year, $filePath, $fields, $startingRow) {
        $objPHPExcel = PHPExcel_IOFactory::load($filePath);
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $highestRow = $worksheet->getHighestRow(); // e.g. 10
            for ($row = $startingRow; $row <= $highestRow; ++$row) {
                $attributes = array();
                for ($col = 0; $col < count($fields); ++$col) {
                    $val = $worksheet->getCellByColumnAndRow($fields[$col]['col'], $row)->getValue();
                    $attributes[$fields[$col]['name']] = $val;
                }
                //concate code
                $activityCode = trim($attributes['satker_code'], " \t\n\r\0\x0B\ ") . '.' . trim($attributes['activity_code'], " \t\n\r\0\x0B\ ");
                $outputCode = $activityCode . '.' . trim($attributes['output_code'], " \t\n\r\0\x0B\ ");
                $suboutputCode = $outputCode . '.' . trim($attributes['suboutput_code'], " \t\n\r\0\x0B\ ");
                $componentCode = $suboutputCode . '.' . trim($attributes['component_code'], " \t\n\r\0\x0B\ ");
                $subcomponentCode = $componentCode . '.' . trim($attributes['subcomponent_code'], " \t\n\r\0\x0B\ ");
                $code = trim($subcomponentCode, " \t\n\r\0\x0B\ ") . '.' . trim($attributes['account_code'], " \t\n\r\0\x0B\ ");
                //end of concate code
                //validation budget year
                if ($attributes['budget_year'] != NULL AND $attributes['satker_code'] != NULL AND $attributes['satker_code'] != NULL) {
                    if ($year == $attributes['budget_year']) {
                        $dipaId = 1;
                        $lastDipa = Dipa::model()->find(array('order' => 'id DESC'));
                        if ($lastDipa) {
                            $dipaId = $lastDipa->id + 1;
                        }
                        $model = new BudgetTemp;
                        $model->attributes = $attributes;
                        $model->budget_year = $attributes['budget_year'];
                        $model->code = $code;
                        $model->dipa_id = $dipaId;
                        $model->activity_code = $activityCode;
                        $model->output_code = $outputCode;
                        $model->suboutput_code = $suboutputCode;
                        $model->component_code = $componentCode;
                        $model->subcomponent_code = $subcomponentCode;
                        $model->save();
                    } elseif ($year != $attributes['budget_year']) {
                        $error = new ErrorDipa;
                        $error->attributes = $attributes;
                        $error->code = $code;
                        $error->budget_year = $attributes['budget_year'];
                        $error->satker_code = trim($attributes['satker_code'], " \t\n\r\0\x0B\ ");
                        $error->activity_code = $activityCode;
                        $error->output_code = $outputCode;
                        $error->suboutput_code = $suboutputCode;
                        $error->component_code = $componentCode;
                        $error->subcomponent_code = $subcomponentCode;
                        $error->account_code = $activityCode;
                        $error->total_budget_limit = $attributes['total_budget_limit'];
                        $error->description = 'Tahun anggaran pada dipa yang diinput berbeda dengan tahun anggaran pada  file excel';
                        $error->save();
                    }
                }
            }
            $errorCheck = ErrorDipa::model()->exists();
            if ($errorCheck) {
                Yii::app()->db->createCommand()->truncateTable(BudgetTemp::model()->tableName());
            }
        }
    }

    public function importExcelToMysql($id, $filePath, $fields = array(), $model = null, $startingRow = 2) {
        $objPHPExcel = PHPExcel_IOFactory::load($filePath);
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $highestRow = $worksheet->getHighestRow(); // e.g. 10
            $isSuccess = FALSE;
            for ($row = $startingRow; $row <= $highestRow; ++$row) {
                $attributes = array();
                for ($col = 0; $col < count($fields); ++$col) {
                    $val = $worksheet->getCellByColumnAndRow($fields[$col]['col'], $row)->getValue();
                    $attributes[$fields[$col]['name']] = $val;
                }
                //concate code
                $activityCode = trim($attributes['satker_code'], " \t\n\r\0\x0B\ ") . '.' . trim($attributes['activity_code'], " \t\n\r\0\x0B\ ");
                $outputCode = $activityCode . '.' . trim($attributes['output_code'], " \t\n\r\0\x0B\ ");
                $suboutputCode = $outputCode . '.' . trim($attributes['suboutput_code'], " \t\n\r\0\x0B\ ");
                $componentCode = $suboutputCode . '.' . trim($attributes['component_code'], " \t\n\r\0\x0B\ ");
                $subcomponentCode = $componentCode . '.' . trim($attributes['subcomponent_code'], " \t\n\r\0\x0B\ ");
                $code = trim($subcomponentCode, " \t\n\r\0\x0B\ ") . '.' . trim($attributes['account_code'], " \t\n\r\0\x0B\ ");
                //end of concate code
                $model = new Budget;
                $model->attributes = $attributes;
                $model->budget_year = $attributes['budget_year'];
                $model->code = $code;
                $model->dipa_id = $id;
                $model->activity_code = $activityCode;
                $model->output_code = $outputCode;
                $model->suboutput_code = $suboutputCode;
                $model->component_code = $componentCode;
                $model->subcomponent_code = $subcomponentCode;
                $isSuccess = FALSE;
                if ($model->save()) {
                    $isSuccess = TRUE;
                }
            }
            /*
             * If New DIPA succesfully added, Update Package limit and Package Account Limit
             */
            if ($isSuccess) {
                //Remove uploaded excel file
                unlink($filePath);
                //Find all listed Package to update it limit value
                $packages = Package::model()->findAll();
                if ($packages) {
                    //Get latest needed information dipa data  
                    $dipa = Dipa::model()->find(array('order' => 'id DESC'));
                    $id = $dipa->id;
                    //Begin update each limit package
                    foreach ($packages as $package) {
                        $budgets = Budget::model()->findAllByAttributes(array('dipa_id' => $id, 'subcomponent_code' => "$package->code"));
                        //Sum total package limit value each account package
                        $limit = 0;
                        foreach ($budgets as $budget) {
                            $limit +=$budget->total_budget_limit;
                        }
                        //Update package limit value
                        $package->limit = $limit;
                        //if package succesfully updated, start to update package account limit value
                        if ($package->update()) {
                            //Find all package account
                            $packageAccounts = PackageAccount::model()->findAllByAttributes(array('package_code' => $package->code));
                            //Begin to update  package account limit value
                            foreach ($packageAccounts as $packageAccount) {
                                $budgetforupdate = Budget::model()->findByAttributes(array('code' => "$packageAccount->code"), array('order' => 'id Desc'));
                                $packageAccount->limit = $budgetforupdate->total_budget_limit;
                                $packageAccount->update();
                            }
                        }
                    }
                }
                Yii::app()->user->setFlash('success', "File berhasil diimport ke dalam master");
                $this->redirect(array('index'));
            }
        }
    }

    public function checkLimit($code) {
        $overLimit = FALSE;
        $realizations = Realization::model()->findAllByAttributes(array('packageAccount_code' => "$code"));
        $newData = BudgetTemp::model()->findByAttributes(array('code' => "$code"), array('order' => 'dipa_id DESC'));
        $newPaLimit = $newData->total_budget_limit;
        $totalRealization = 0;
        if ($realizations) {
            foreach ($realizations as $data) {
                $totalRealization +=$data->total_spm;
            }
        }
        if ($newPaLimit < $totalRealization) {
            $overLimit = TRUE;
        }
        return $overLimit;
    }

    /**
     * Compare budget year of old and new record
     * @param type $year
     * @return boolean
     */
    public function checkYear($year) {
        $status = TRUE;
        //New Budget Year
        $newData = $year;
        //Recorded Budget Year
        $lastDipa = Dipa::model()->find(array('order' => 'id DESC'));
        if ($lastDipa) {
            if ($lastDipa->budget_year != $newData) {
                $status = FALSE;
            }
        } else {
            $status = TRUE;
        }
        return $status;
    }

    /**
     * Clear all DIPA, Budget, Package, Account Package, and Realization data from database record
     */
    public function actionClear() {
        //Check record data on database
        $realization = Realization::model()->exists();
        $packageAccount = PackageAccount::model()->exists();
        $package = Package::model()->exists();
        $budget = Budget::model()->exists();
        $dipa = Dipa::model()->exists();

        //Clear data
        if ($realization) {
            //Truncate realization table on anggaran database
            Yii::app()->db->createCommand()->truncateTable(Realization::model()->tableName());
        }
        if ($packageAccount) {
            //Truncate package_account table on anggaran database
            Yii::app()->db->createCommand()->truncateTable(PackageAccount::model()->tableName());
        }
        if ($package) {
            //Truncate package table on anggaran database
            Yii::app()->db->createCommand()->truncateTable(Package::model()->tableName());
        }
        if ($budget) {
            //Truncate budget table on anggaran database
            Yii::app()->db->createCommand()->truncateTable(Budget::model()->tableName());
        }
        if ($dipa) {
            //Truncate dipa table on anggaran database

            Yii::app()->db->createCommand()->truncateTable(Dipa::model()->tableName());
        }
        //Redirect to DIPA index page
        Yii::app()->user->setFlash('success', 'Data berhasil dibersihkan. </br> Anda dapat memasukkan anggaran baru.');
        $this->redirect(array('index'));
    }

    /**
     * Check completeness data of master
     * @return boolean
     */
    public function checkMaster() {
        $complete = false;
        $ppk = Ppk::model()->exists();
        $satker = Satker::model()->exists();
        $activity = Activity::model()->exists();
        $output = Output::model()->exists();
        $suboutput = Suboutput::model()->exists();
        $component = Component::model()->exists();
        $subcomponent = Subcomponent::model()->exists();
        $account = Account::model()->exists();
        $province = Province::model()->exists();
        $city = City::model()->exists();
        if ($ppk && $satker && $activity && $output && $suboutput & $component && $subcomponent && $account && $province && $city) {
            $complete = TRUE;
        }
        return $complete;
    }

    /**
     * Check Existing of Realization
     * Part of check structure validation
     * @param type $code
     * @return boolean
     */
    public function checkRealization($code) {
        $status = array();
        $status['exist'] = FALSE;
        $status['overLimit'] = FALSE;
        //Search for realization
        $realization = Realization::model()->findByAttributes(array('packageAccount_code' => "$code"));
        //There is realization on budget if realization exist
        if ($realization) {
            $status['exist'] = TRUE;
            $status['overLimit'] = $this->checkLimit($code);
        }
        return $status;
    }

    /**
     * get overlimit budget temporary
     * @return array
     */
    public function getOverlimitBudget() {
        $overlimitBudget = array();
        $budgets = BudgetTemp::model()->findAll();
        if ($budgets) {
            foreach ($budgets as $data) {
                $total = 0;
                $realizations = Realization::model()->findAllByAttributes(array('packageAccount_code' => "$data->code"));
                if ($realizations) {
                    foreach ($realizations as $rData) {
                        $total +=$rData->total_spm;
                    }
                }
                if ($data->total_budget_limit < $total) {
                    array_push($overlimitBudget, $data);
                }
            }
        }
        return $overlimitBudget;
    }

    /**
     * Search for deleted records on budget
     * @return boolean
     */
    public function deletedRecords() {
        $dipa = Dipa::model()->find(array('order' => 'id DESC'));
        $deleted = FALSE;

        if ($dipa) {
            $dipaId = $dipa->id;
            //Search for deleted budget record on budget_temp
            $deletedRecords = Budget::model()->findAllBySql("SELECT budget.* FROM budget LEFT JOIN budget_temp ON budget_temp.code=budget.code WHERE budget_temp.code IS NULL AND budget.dipa_id=$dipaId");
            //There is deleted records if deletedRecords exist
            if ($deletedRecords) {
                $deleted = TRUE;
            }
        }

        return $deleted;
    }

    /**
     * Compare old budget with new budget temp structure
     * Part of check structure validation
     * @param type $code
     * @return boolean
     */
    public function addedRecords($code) {
        $added = TRUE;
        //Check Existing of Budget Record
        $dipa = Dipa::model()->find(array('order' => 'id DESC'));
        if ($dipa) {
            $dipaId = $dipa->id;
            $budget = Budget::model()->findByAttributes(array('code' => $code, 'dipa_id' => $dipaId));
            if ($budget) {
                $added = FALSE;
            }
        }

        return $added;
    }

    /**
     * Check completeness of inputed data
     * @return boolean
     */
    public function checkDataCompleteness() {
        $status = array();
        $status['dipa'] = TRUE; // True if dipa data complete
        $status['master'] = TRUE; //True if master data complete
        //Find  missing master data
        $master = Subcomponent::model()->findAllBySql("SELECT subcomponent.* FROM subcomponent LEFT JOIN budget_temp ON subcomponent.code=budget_temp.subcomponent_code WHERE budget_temp.subcomponent_code IS NULL");
        //FInd missing dipa data input
        $dipa = BudgetTemp::model()->findAllBySql("SELECT budget_temp.* FROM budget_temp LEFT JOIN subcomponent ON budget_temp.subcomponent_code=subcomponent.code WHERE subcomponent.code IS NULL");

        if ($master) {
            $status['dipa'] = FALSE;
        }
        if ($dipa) {
            $status['master'] = FALSE;
        }
        return $status;
    }

    /**
     * Structure validation
     * @param type $code
     * @return string
     */
    public function checkStructure() {
        $status = array();
        $status['addedRecord'] = FALSE;
        $status['operation'] = FALSE;
        //Doing Validation
        $budget_temps = BudgetTemp::model()->findAll();
        if ($budget_temps) {
            foreach ($budget_temps as $data) {
                if ($status['addedRecord'] == TRUE) {
                    if ($this->addedRecords($data->code) == FALSE) {
                        $status['addedRecord'] = FALSE;
                    }
                }
            }
            $status['operation'] = TRUE;
        }
        $status['deletedRecord'] = $this->deletedRecords();

        return $status;
    }

    /**
     * Action import DIPA data
     */
    public function actionImport() {
        $this->title = 'Import DIPA/POK';
        $model = new Dipa;

        //Check Completeness data of master (reference data)
        $showContent = $this->checkMaster();
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        if (isset($_POST['Dipa'])) {
            $model->attributes = $_POST['Dipa'];
            $model->file = CUploadedFile::getInstance($model, "file");
            //Define upload path
            $filePath = Yii::getPathOfAlias('webroot') . "/imports/" . $model->file;
            //Move file to server
            $model->file->saveAs($filePath);
            //Define excel file field
            $fields = array(
                array(
                    'name' => 'budget_year', //Tahun Anggaran
                    'col' => 0,
                ),
                array(
                    'name' => 'satker_code', //Kode Satker
                    'col' => 1,
                ),
                array(
                    'name' => 'activity_code', //Kode Kegiatan
                    'col' => 5,
                ),
                array(
                    'name' => 'output_code', //Kode Output
                    'col' => 6,
                ),
                array(
                    'name' => 'suboutput_code', //Kode Suboutput
                    'col' => 7,
                ),
                array(
                    'name' => 'component_code', //Kode Komponen
                    'col' => 8,
                ),
                array(
                    'name' => 'subcomponent_code', //Kode Subkomponen/Paket
                    'col' => 9,
                ),
                array(
                    'name' => 'account_code', //Kode AKun
                    'col' => 10,
                ),
                array(
                    'name' => 'total_budget_limit', //Pagu
                    'col' => 11,
                ),
            );
            //Import PHP Excel class
            $objPHPExcel = new PHPExcel();

            //Check validity of budget year (new budget year document must be same with Last DIPA budget year)
            $yearStatus = $this->checkYear($_POST['Dipa']['budget_year']);

            //Check validity of excel file field (must be same with normalized d_item excel file from RKAKL)
            $fieldValidated = $this->validateFieldExcel($filePath, $fields);

            if (!$model->file) {
                //File validity error message
                Yii::app()->user->setFlash('error', 'Pastikan file import sudah diinput.');
            } elseif ($yearStatus = FALSE) {
                //Budget Year validity error message
                Yii::app()->user->setFlash('error', 'Periksa kembali input data tahun anggaran DIPA.');
                $this->redirect(array('index'));
            } elseif ($fieldValidated == FALSE) {
                unlink($filePath);
                Yii::app()->user->setFlash('error', 'Pastikan file yang Anda upload sudah benar!');
            } else {
                $this->importExcelTemporary($_POST['Dipa']['budget_year'], $filePath, $fields, 2);
                $structureValidation = $this->checkStructure();
                $dataCompleteness = $this->checkDataCompleteness();
                if ($structureValidation['operation'] == FALSE) {
                    unlink($filePath);
                    Yii::app()->db->createCommand()->truncateTable(BudgetTemp::model()->tableName());
                    Yii::app()->user->setFlash('error', 'Terdapat error pada data yang diinputkan.');
                    $this->redirect(array('index'));
                } else {
                    if ($dataCompleteness['master'] == FALSE || $dataCompleteness['dipa'] == FALSE) {
                        //Write data anggaran yang belum diinput dalam master subkomponen
                        $nonRecordedBudgetOnMaster = BudgetTemp::model()->findAllBySql("SELECT budget_temp.* FROM budget_temp LEFT JOIN subcomponent ON budget_temp.subcomponent_code=subcomponent.code WHERE subcomponent.code IS NULL");
                        if ($nonRecordedBudgetOnMaster) {
                            foreach ($nonRecordedBudgetOnMaster as $emptyData) {
                                $description = "Kode paket $emptyData->subcomponent_code belum ada dalam master subkomponen";
                                $this->createErrorCompleteness($emptyData, $description);
                            }
                        }
                        //write non inputed subcomponent budget to error database
                        $packages = Subcomponent::model()->findAllBySql("SELECT subcomponent.* FROM subcomponent LEFT JOIN budget_temp ON subcomponent.code=budget_temp.subcomponent_code WHERE budget_temp.subcomponent_code IS NULL");
                        //@OPTIMIZE QUERY get only used field
                        if ($packages) {
                            foreach ($packages as $data) {
                                $description = "Data anggaran dengan kode paket [ $data->code ] belum diinput dalam dokumen DIPA/POK.";
                                $this->createErrorCompleteness($data, $description);
                            }
                        }
                        //write code here
                        unlink($filePath);
                        Yii::app()->db->createCommand()->truncateTable(BudgetTemp::model()->tableName());
                        Yii::app()->user->setFlash('error', 'Data yang diimport belum lengkap/belum diinput dalam master subcomponen.');
                        $this->redirect(array('index'));
                    } else {
                        if ($structureValidation['deletedRecord'] == TRUE) {//Ada akun paket yang dihapus
                            $dipa = Dipa::model()->find(array('order' => 'id DESC'));
                            if ($dipa) {
                                $dipaId = $dipa->id;
                                $deletedBudgets = Budget::model()->findAllBySql("SELECT budget.* FROM budget LEFT JOIN budget_temp ON budget_temp.code=budget.code WHERE budget_temp.code IS NULL AND budget.dipa_id=$dipaId");
                                //@OPTIMIZE QUERY get only used field
                                $addedData = BudgetTemp::model()->findAllBySql("SELECT budget_temp.* FROM budget_temp LEFT JOIN budget ON budget.code=budget_temp.code WHERE budget.code IS NULL");
                                //@OPTIMIZE QUERY get only used field
                                $continue = TRUE;
                                if ($deletedBudgets) {//Cek apakah sudah ada realisasi pada akun paket yang dihapus
                                    foreach ($deletedBudgets as $data) {
                                        $statusRealization = $this->checkRealization($data->code);
                                        if ($continue == TRUE) {
                                            if ($statusRealization['exist'] == TRUE) {
                                                $continue = FALSE;
                                            }
                                        }
                                    }
                                }
                                //Eof dipa exist boolean true
                                if ($continue == FALSE) {//Proses input dihentikan karena pada data yag dihapus sudah ada realisasi
                                    foreach ($deletedBudgets as $data) {//Simpan data yang sudah terealisasi
                                        $statusRealization = $this->checkRealization($data->code);
                                        if ($statusRealization['exist'] == TRUE) {
                                            $description = "Anggaran dengan kode akun paket $data->code sudah direalisasikan. Tidak boleh dihapus.";
                                            $this->createErrorDipa($data, $description);
                                        }
                                    }
                                    Yii::app()->db->createCommand()->truncateTable(BudgetTemp::model()->tableName());
                                    unlink($filePath);
                                    $model->save();
                                    Yii::app()->user->setFlash('error', 'Terjadi penghapusan pada akun paket yang sudah terealisasi.');
                                    $this->redirect(array('index'));
                                } else {//Proses input dilanjutkan karena belum ada realisasi pada data yang dihapus
                                    if ($addedData) {//Jika ada penambahan data
                                        foreach ($addedData as $data) {
                                            $paModel = new PackageAccount;
                                            $paModel->code = $data->code;
                                            $paModel->satker_code = $data->satker_code;
                                            $paModel->activity_code = $data->activity_code;
                                            $paModel->output_code = $data->output_code;
                                            $paModel->suboutput_code = $data->suboutput_code;
                                            $paModel->component_code = $data->component_code;
                                            $paModel->package_code = $data->subcomponent_code;
                                            $paModel->account_code = $data->account_code;
                                            $paModel->limit = $data->total_budget_limit;
                                            $package = Package::model()->findByAttributes(array('code' => "$data->subcomponent_code"));
                                            //@OPTIMIZE QUERY get only used field
                                            if ($package) {
                                                $paModel->ppk_code = $package->ppk_code;
                                                $paModel->province_code = $package->province_code;
                                                $paModel->city_code = $package->city_code;
                                            }
                                            $paModel->save();
                                        }
                                    }
                                    $temps = BudgetTemp::model()->findAll();
                                    //@OPTIMIZE QUERY get only used field
                                    if ($temps) {//Pindahkan data dari tabel temporari ke tabel budget
                                        $continue = TRUE;
                                        foreach ($temps as $data) {
                                            $overLimit = $this->checkRealization($data->code)['overLimit'];
                                            if ($continue == TRUE) {
                                                if ($overLimit == TRUE) {
                                                    $continue = FALSE;
                                                }
                                            }
                                        }

                                        if ($continue == FALSE) {
                                            $overlimitBudgets = $this->getOverlimitBudget();
                                            if (count($overlimitBudgets) != 0) {
                                                foreach ($overlimitBudgets as $data) {
                                                    $description = "Terjadi pagu minus pada anggaran dengan kode $data->code";
                                                    $this->createErrorDipa($data, $description);
                                                }
                                                Yii::app()->db->createCommand()->truncateTable(BudgetTemp::model()->tableName());
                                                unlink($filePath);
                                                $model->save();
                                                Yii::app()->user->setFlash('error', 'Terjadi pagu minus pada beberapa data. Mohon cek kembali.');
                                                $this->redirect(array('index'));
                                            }
                                        } else {
                                            $overlimitBudgets = $this->getOverlimitBudget();
                                            if (count($overlimitBudgets) != 0) {
                                                foreach ($overlimitBudgets as $data) {
                                                    $description = "Terjadi pagu minus pada anggaran dengan kode $data->code";
                                                    $this->createErrorDipa($data, $description);
                                                }
                                                Yii::app()->db->createCommand()->truncateTable(BudgetTemp::model()->tableName());
                                                unlink($filePath);
                                                $model->save();
                                                Yii::app()->user->setFlash('error', 'Terjadi pagu minus pada beberapa data. Mohon cek kembali.');
                                                $this->redirect(array('index'));
                                            } else {
                                                foreach ($temps as $data) {
                                                    $budget = new Budget;
                                                    $budget->code = $data->code;
                                                    $budget->dipa_id = $data->dipa_id;
                                                    $budget->budget_year = $data->budget_year;
                                                    $budget->satker_code = $data->satker_code;
                                                    $budget->activity_code = $data->activity_code;
                                                    $budget->output_code = $data->output_code;
                                                    $budget->suboutput_code = $data->suboutput_code;
                                                    $budget->component_code = $data->component_code;
                                                    $budget->subcomponent_code = $data->subcomponent_code;
                                                    $budget->account_code = $data->account_code;
                                                    $budget->total_budget_limit = $data->total_budget_limit;
                                                    if ($budget->save()) {
                                                        $pacModel = PackageAccount::model()->findByAttributes(array('code' => "$budget->code"));
                                                        //@OPTIMIZE QUERY get only used field
                                                        if ($pacModel) {
                                                            $pacModel->limit = $budget->total_budget_limit;
                                                            $pacModel->update();
                                                        }
                                                    }
                                                    //Delete package account data with code equal to deleted budget
                                                    foreach ($deletedBudgets as $data) {//Hapus akun paket untuk data yang dihapus
                                                        $packageAccount = PackageAccount::model()->findByAttributes(array('code' => "$data->code"));
                                                        //@OPTIMIZE QUERY get only used field
                                                        if ($packageAccount) {
                                                            $packageAccount->delete();
                                                        }
                                                    }
                                                    Yii::app()->db->createCommand()->truncateTable(BudgetTemp::model()->tableName());
                                                    unlink($filePath);
                                                    $model->save();
                                                    Yii::app()->user->setFlash('success', 'Data berhasil diimport ke database.cc');
                                                    $this->redirect(array('index'));
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            //Eof exist deleted record logic
                        } else {//Tidak ada akun paket yang dihapus
                            if ($structureValidation['addedRecord'] == TRUE) {//Ada Penambahan Akun Paket
                                //If added package account data is exist
                                //Create new package account with added data 
                                $addedData = BudgetTemp::model()->findAllBySql("SELECT budget_temp.* FROM budget_temp LEFT JOIN budget ON budget.code=budget_temp.code WHERE budget.code IS NULL");
                                //@OPTIMIZE QUERY get only used field
                                $temps = BudgetTemp::model()->findAll();
                                if ($temps) {
                                    $overlimitBudgets = $this->getOverlimitBudget();
                                    if (count($overlimitBudgets) != 0) {
                                        foreach ($overlimitBudgets as $data) {
                                            $description = "Terjadi pagu minus pada anggaran dengan kode $data->code.";
                                            $this->createErrorDipa($data, $description);
                                        }
                                        Yii::app()->db->createCommand()->truncateTable(BudgetTemp::model()->tableName());
                                        unlink($filePath);
                                        $model->save();
                                        Yii::app()->user->setFlash('error', 'Terjadi pagu minus pada beberapa data. Mohon cek kembali.');
                                        $this->redirect(array('index'));
                                    } else {
                                        if ($addedData) {
                                            foreach ($addedData as $data) {
                                                $paModel = new PackageAccount;
                                                $paModel->code = $data->code;
                                                $paModel->satker_code = $data->satker_code;
                                                $paModel->activity_code = $data->activity_code;
                                                $paModel->output_code = $data->output_code;
                                                $paModel->suboutput_code = $data->suboutput_code;
                                                $paModel->component_code = $data->component_code;
                                                $paModel->package_code = $data->subcomponent_code;
                                                $paModel->account_code = $data->account_code;
                                                $paModel->limit = $data->total_budget_limit;
                                                $package = Package::model()->findByAttributes(array('code' => "$data->subcomponent_code"));
                                                //@OPTIMIZE QUERY get only used field
                                                if ($package) {
                                                    $paModel->ppk_code = $package->ppk_code;
                                                    $paModel->province_code = $package->province_code;
                                                    $paModel->city_code = $package->city_code;
                                                }
                                                $paModel->save();
                                            }
                                        }
                                        foreach ($temps as $data) {
                                            $this->createBudget($data);
                                        }
                                        Yii::app()->db->createCommand()->truncateTable(BudgetTemp::model()->tableName());
                                        unlink($filePath);
                                        $model->save();
                                        Yii::app()->user->setFlash('success', 'Data berhasil diimport ke database.bb');
                                        $this->redirect(array('index'));
                                    }
                                }
                            } else {//Tidak ada perubahan struktur
                                //If added package account data isn't exist
                                //If deleted package account data isn't exist
                                $temps = BudgetTemp::model()->findAll();
                                //@OPTIMIZE QUERY get only used field
                                if ($temps) {
                                    $overlimitBudgets = $this->getOverlimitBudget();
                                    if (count($overlimitBudgets) != 0) {
                                        foreach ($overlimitBudgets as $data) {
                                            $description = "Terjadi pagu minus pada anggaran dengan kode $data->code.";
                                            $this->createErrorDipa($data, $description);
                                        }
                                        Yii::app()->db->createCommand()->truncateTable(BudgetTemp::model()->tableName());
                                        unlink($filePath);
                                        $model->save();
                                        Yii::app()->user->setFlash('error', 'Terjadi pagu minus pada beberapa data. Mohon cek kembali.');
                                        $this->redirect(array('index'));
                                    } else {
                                        foreach ($temps as $data) {
                                            $budget = new Budget;
                                            $budget->code = $data->code;
                                            $budget->dipa_id = $data->dipa_id;
                                            $budget->budget_year = $data->budget_year;
                                            $budget->satker_code = $data->satker_code;
                                            $budget->activity_code = $data->activity_code;
                                            $budget->output_code = $data->output_code;
                                            $budget->suboutput_code = $data->suboutput_code;
                                            $budget->component_code = $data->component_code;
                                            $budget->subcomponent_code = $data->subcomponent_code;
                                            $budget->account_code = $data->account_code;
                                            $budget->total_budget_limit = $data->total_budget_limit;
                                            //Update package account limit
                                            if ($budget->save()) {
                                                $paModel = PackageAccount::model()->findByAttributes(array('code' => "$budget->code"));
                                                //@OPTIMIZE QUERY get only used field
                                                if ($paModel) {
                                                    $paModel->limit = $budget->total_budget_limit;
                                                    $paModel->update();
                                                }
                                            }
                                        }
                                    }
                                }
                                Yii::app()->db->createCommand()->truncateTable(BudgetTemp::model()->tableName());
                                unlink($filePath);
                                $model->save();
                                Yii::app()->user->setFlash('success', 'Data berhasil diimport ke database.aa');
                                $this->redirect(array('index'));
                            }
                        }
                    }
                }
            }
        }
        $this->render('import', array(
            'model' => $model,
            'showContent' => $showContent,
        ));
    }

    public function actionPrintError() {
        //code print
        /** Get model */
        $models = ErrorDipa::model()->findAll();
        /** Error reporting */
        $this->excelErrorReport();

        /** PHPExcel_IOFactory */
        $objReader = new PHPExcel;
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $path = Yii::app()->basePath . '/../export/dipa_error.xlsx';
        $pathExport = Yii::app()->basePath . '/../files/Error.xlsx';
        $objPHPExcel = $objReader->load($path);
        $objPHPExcel->setActiveSheetIndex(0);

        /* " Add new data to template" */ $this->exportExcel($objPHPExcel, $models);
        /** Export to excel* */
        $this->excel($objPHPExcel, $pathExport);
        //Truncate error record
        Yii::app()->db->createCommand()->truncateTable(ErrorDipa::model()->tableName());
        readfile($pathExport);
        unlink($pathExport);
        exit;
        Yii::app()->user->setFlash('success', 'Daftar error berhasil diprint.');
        //Eof code print
        $this->redirect(array
            ('index'));
    }

    /**
     * PHP Excel error report
     */
    public function excelErrorReport() {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        date_default_timezone_set(
                'Asia/Jakarta');
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
        header(
                'Content-Length: ' . filesize($pathExport));
    }

    //Write data to excel cell
    public function exportExcel($objPHPExcel, $models) {
        $sheet = $objPHPExcel->getActiveSheet();
        $row = 1;
        if ($models) {
            foreach ($models as $model) {
                $code = $model->code;
                $sheet->setCellValueExplicit('A' . ++$row, $code, PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValue('K' . $row, isset($model->description) ? $model->description : NULL);
            }
        }
        $objPHPExcel->getActiveSheet()->setTitle('Daftar Error');
    }

    public function createErrorDipa($data, $description) {
        $error = new ErrorDipa;
        $error->code = $data->code;
        $error->budget_year = $data->budget_year;
        $error->satker_code = $data->satker_code;
        $error->activity_code = $data->activity_code;
        $error->output_code = $data->output_code;
        $error->suboutput_code = $data->suboutput_code;
        $error->component_code = $data->component_code;
        $error->subcomponent_code = $data->subcomponent_code;
        $error->account_code = $data->account_code;
        $error->total_budget_limit = $data->total_budget_limit;
        $error->description = $description;
        $error->save();
    }

    public function createErrorCompleteness($data, $description) {
        $error = new ErrorDipaCompleteness;
        $error->code = $data->code;
        $error->description = $description;
        $error->save();
    }

    public function createBudget($data) {
        $budget = new Budget;
        $budget->code = $data->code;
        $budget->dipa_id = $data->dipa_id;
        $budget->budget_year = $data->budget_year;
        $budget->satker_code = $data->satker_code;
        $budget->activity_code = $data->activity_code;
        $budget->output_code = $data->output_code;
        $budget->suboutput_code = $data->suboutput_code;
        $budget->component_code = $data->component_code;
        $budget->subcomponent_code = $data->subcomponent_code;
        $budget->account_code = $data->account_code;
        $budget->total_budget_limit = $data->total_budget_limit;
        $budget->save();
    }

}
