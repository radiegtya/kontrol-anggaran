<?php

class SiteController extends Controller {

    /**
     * Declares class-based actions.
     */
    public $layout = '//layouts/column2';
    public $title = 'Site';

    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    public function accessRules() {
        return VAuth::getAccessRules('site', array('report', 'login', 'about', 'guide'));
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        $this->title = 'Home';
        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->baseUrl . '/site/login');
//        }else{
//             $this->redirect(Yii::app()->baseUrl . '/dashboard/mainChart');
        }
        $this->render('index');
    }

    public function actionAbout() {
        $this->title = 'About';
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->render('about');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                        "Reply-To: {$model->email}\r\n" .
                        "MIME-Version: 1.0\r\n" .
                        "Content-type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {
        $this->title = 'Login';
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login())
//                $this->redirect(Yii::app()->baseUrl . '/site/index');
                $this->redirect(Yii::app()->baseUrl . '/dashboard/performanceDashboard');
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionGuide() {
        $this->title = 'User Guide.';
        $this->render('guide');
    }

    public function actionReport() {
        /** Get model */
        $models = PackageAccount::model()->findAll();
        /** Error reporting */
        $this->excelErrorReport();

        /** PHPExcel_IOFactory */
        $objReader = new PHPExcel;
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $path = Yii::app()->basePath . '/../export/report.xlsx';
        $pathExport = Yii::app()->basePath . '/../files/Laporan.xlsx';
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
        $sheet->setCellValueExplicit('J2', "Tanggal:  " . date('j F Y'), PHPExcel_Cell_DataType::TYPE_STRING);
        $row = 3;
        if ($models) {
            foreach ($models as $model) {
                $sheet->setCellValueExplicit('A' . ++$row, isset($model->code) ? $model->code : NULL, PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('B' . $row, isset($model->satker_code) ? $model->satker_code : NULL, PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('C' . $row, isset($model->activity_code) ? str_replace($model->satker_code . '.', '', $model->activity_code) : NULL, PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('D' . $row, isset($model->output_code) ? str_replace($model->activity_code . '.', '', $model->output_code) : NULL, PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('E' . $row, isset($model->suboutput_code) ? str_replace($model->output_code . '.', '', $model->suboutput_code) : NULL, PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('F' . $row, isset($model->component_code) ? str_replace($model->suboutput_code . '.', '', $model->component_code) : NULL, PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('G' . $row, isset($model->package_code) ? str_replace($model->component_code . '.', '', $model->package_code) : NULL, PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('H' . $row, isset($model->account_code) ? $model->account_code : NULL, PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValue('I' . $row, isset($model->limit) ? $model->limit : NULL);
                $realization = PackageAccount::model()->getTotal($model->code)['realization'];
                $sheet->setCellValue('J' . $row, $realization);
            }
        }
        $objPHPExcel->getActiveSheet()->setTitle('Laporan');
    }

}
