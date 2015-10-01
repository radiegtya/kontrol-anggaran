<?php

class DashboardController extends Controller {

    public $layout = '//layouts/column2';
    public $title = 'Dashboard';

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

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules() {
        return VAuth::getAccessRules('dashboard', array('tableReport', 'performanceDashboard', 'index', 'ppkPackageAccountChart', 'ppkActivityChart', 'ppkOutputChart', 'ppkSuboutputChart', 'ppkComponentChart', 'ppkPackageChart'));
    }

    public function actionIndex() {
        $this->redirect('mainChart');
    }

    public function actionMainChart() {
        $models = Satker::model()->findAll();
        $rate = array();
        $realization = array();
        $limit = array();
        $rest = array();
        $legend = FALSE;
        foreach ($models as $model) {
            $packages = PackageAccount::model()->findAllByAttributes(array('satker_code' => $model->code));
            $packageRealization = 0;
            $packageLimit = 0;
            foreach ($packages as $package) {
                $packageRealization +=intval($package->getTotal($package->code)['realization']);
                $packageLimit +=intval($package->limit);
            }
            if ($packages) {
                $rate[$model->id] = $packageRealization / $packageLimit;
                $realization[$model->id] = $packageRealization;
                $limit[$model->id] = $packageLimit;
                $rest[$model->id] = $packageLimit - $packageRealization;
                $legend = TRUE;
            }
        }
        $modelPpks = Ppk::model()->findAll();
        $legendPpk = FALSE;
        $ratePpk = array();
        $realizationPpk = array();
        $limitPpk = array();
        $restPpk = array();
        foreach ($modelPpks as $modelPpk) {
            $packagePpks = PackageAccount::model()->findAllByAttributes(array('ppk_code' => $modelPpk->code));
            $packageRealizationPpk = 0;
            $packageLimitPpk = 0;
            foreach ($packagePpks as $packagePpk) {
                $packageRealizationPpk +=intval($packagePpk->getTotal($packagePpk->code)['realization']);
                $packageLimitPpk +=intval($packagePpk->limit);
            }
            if ($packagePpks) {
                $ratePpk[$modelPpk->id] = $packageRealizationPpk / $packageLimitPpk;
                $limitPpk[$modelPpk->id] = $packageLimitPpk;
                $realizationPpk[$modelPpk->id] = $packageRealizationPpk;
                $restPpk[$modelPpk->id] = $packageLimitPpk - $packageRealizationPpk;
                $legendPpk = TRUE;
            }
        }

        $this->render('mainChart', array(
            'legend' => $legend,
            'models' => $models,
            'rate' => $rate,
            'realization' => $realization,
            'limit' => $limit,
            'rest' => $rest,
            'legendPpk' => $legendPpk,
            'modelPpks' => $modelPpks,
            'ratePpk' => $ratePpk,
            'realizationPpk' => $realizationPpk,
            'limitPpk' => $limitPpk,
            'res
         * @param type $idtPpk' => $restPpk,
        ));
    }

    public function actionActivityChart($id) {
        $satker = Satker::model()->findByPk($id);
        $activities = Activity::model()->findAllByAttributes(array('satker_code' => $satker->code));
        $rate = array();
        $limit = array();
        $realization = array();
        $rest = array();
        $legend = FALSE;
        foreach ($activities as $activity) {
            $packages = PackageAccount::model()->findAllByAttributes(array('satker_code' => $satker->code));
            $packageRealization = 0;
            $packageLimit = 0;
            foreach ($packages as $package) {
                $packageRealization +=intval($package->getTotal($package->code)['realization']);
                $packageLimit +=intval($package->limit);
            }
            if ($packages) {
                $rate[$activity->id] = $packageRealization / $packageLimit;
                $limit[$activity->id] = $packageLimit;
                $realization[$activity->id] = $packageRealization;
                $rest[$activity->id] = $packageLimit - $packageRealization;
                $legend = TRUE;
            }
        }
        $this->render('activityChart', array(
            'legend' => $legend,
            'activities' => $activities,
            'rate' => $rate,
            'limit' => $limit,
            'realization' => $realization,
            'rest' => $rest,
            'satker' => $satker,
        ));
    }

    public function actionOutputChart($id) {
        $activity = Activity::model()->findByPk($id);
        $outputs = Output::model()->findAllByAttributes(array('activity_code' => $activity->code));
        $rate = array();
        $limit = array();
        $realization = array();
        $rest = array();
        $legend = FALSE;
        foreach ($outputs as $output) {
            $packages = PackageAccount::model()->findAllByAttributes(array('output_code' => $output->code));
            $packageRealization = 0;
            $packageLimit = 0;
            foreach ($packages as $package) {
                $packageRealization +=intval($package->getTotal($package->code)['realization']);
                $packageLimit +=intval($package->limit);
            }
            if ($packages) {
                $rate[$output->id] = $packageRealization / $packageLimit;
                $limit[$output->id] = $packageLimit;
                $realization[$output->id] = $packageRealization;
                $rest[$output->id] = $packageLimit - $packageRealization;
                $legend = TRUE;
            }
        }

        $this->render('outputChart', array(
            'legend' => $legend,
            'outputs' => $outputs,
            'rate' => $rate,
            'limit' => $limit,
            'realization' => $realization,
            'rest' => $rest,
            'activity' => $activity,
        ));
    }

    public function actionSuboutputChart($id) {
        $output = Output::model()->findByPk($id);
        $suboutputs = Suboutput::model()->findAllByAttributes(array('output_code' => "$output->code"));
        $rate = array();
        $limit = array();
        $realization = array();
        $rest = array();
        $legend = FALSE;
        foreach ($suboutputs as $suboutput) {
            $packages = PackageAccount::model()->findAllByAttributes(array('suboutput_code' => "$suboutput->code"));
            $packageRealization = 0;
            $packageLimit = 0;
            foreach ($packages as $package) {
                $packageRealization +=intval($package->getTotal("$package->code")['realization']);
                $packageLimit +=intval($package->limit);
            }
            if ($packages) {
                $rate[$suboutput->id] = $packageRealization / $packageLimit;
                $limit[$suboutput->id] = $packageLimit;
                $realization[$suboutput->id] = $packageRealization;
                $rest[$suboutput->id] = $packageLimit - $packageRealization;
                $legend = TRUE;
            }
        }
        $this->render('suboutputChart', array(
            'legend' => $legend,
            'output' => $output,
            'suboutputs' => $suboutputs,
            'rate' => $rate,
            'limit' => $limit,
            'realization' => $realization,
            'rest' => $rest,
        ));
    }

    public function actionComponentChart($id) {
        $suboutput = Suboutput::model()->findByPk($id);
        $components = Component::model()->findAllByAttributes(array('suboutput_code' => $suboutput->code));
        $rate = array();
        $limit = array();
        $realization = array();
        $rest = array();
        $legend = FALSE;
        foreach ($components as $component) {
            $packages = PackageAccount::model()->findAllByAttributes(array('component_code' => "$component->code"));
            $packageRealization = 0;
            $packageLimit = 0;
            foreach ($packages as $package) {
                $packageRealization +=intval($package->getTotal("$package->code")['realization']);
                $packageLimit +=intval($package->limit);
            }
            if ($packages) {
                $rate[$component->id] = $packageRealization / $packageLimit;
                $limit[$component->id] = $packageLimit;
                $realization[$component->id] = $packageRealization;
                $rest[$component->id] = $packageLimit - $packageRealization;
                $legend = TRUE;
            }
        }
        $this->render('componentChart', array(
            'legend' => $legend,
            'components' => $components,
            'suboutput' => $suboutput,
            'rate' => $rate,
            'limit' => $limit,
            'realization' => $realization,
            'rest' => $rest,
        ));
    }

    public function actionSubcomponentChart($id) {
        $component = Component::model()->findByPk($id);
        $subcomponents = Subcomponent::model()->findAllByAttributes(array('component_code' => $component->code));
        $rate = array();
        $limit = array();
        $realization = array();
        $rest = array();
        $legend = FALSE;
        foreach ($subcomponents as $subcomponent) {
            $packages = PackageAccount::model()->findAllByAttributes(array('package_code' => "$subcomponent->code"));
            $packageRealization = 0;
            $packageLimit = 0;
            foreach ($packages as $package) {
                $packageRealization +=intval($package->getTotal("$package->code")['realization']);
                $packageLimit +=intval($package->limit);
            }
            if ($packages) {
                $rate[$subcomponent->id] = $packageRealization / $packageLimit;
                $limit[$subcomponent->id] = $packageLimit;
                $realization[$subcomponent->id] = $packageRealization;
                $rest[$subcomponent->id] = $packageLimit - $packageRealization;
                $legend = TRUE;
            }
        }
        $this->render('subcomponentChart', array(
            'subcomponents' => $subcomponents,
            'legend' => $legend,
            'component' => $component,
            'rate' => $rate,
            'limit' => $limit,
            'realization' => $realization,
            'rest' => $rest,
        ));
    }

    public function actionAccountChart($id) {
        $subcomponent = Subcomponent::model()->findByPk($id);
        $package = Package::model()->findByAttributes(array('code' => $subcomponent->code));
        $limit = array();
        $realization = array();
        $rest = array();
        $rate = array();
        $legend = FALSE;
        $packageAccounts = PackageAccount::model()->findAllByAttributes(array('package_code' => $package->code));
        if ($packageAccounts) {
            foreach ($packageAccounts as $packageAccount) {
                $limit[$packageAccount->id] = $packageAccount->limit;
                $realization[$packageAccount->id] = $packageAccount->getTotal($packageAccount->code)['realization'];
                $rest[$packageAccount->id] = $packageAccount->getTotal($packageAccount->code)['restMoney'];
                $rate[$packageAccount->id] = $packageAccount->getTotal($packageAccount->code)['rate'];
            }
            $legend = TRUE;
        }
        $this->render('accountChart', array(
            'legend' => $legend,
            'packageAccounts' => $packageAccounts,
            'package' => $package,
            'rate' => $rate,
            'limit' => $limit,
            'realization' => $realization,
            'rest' => $rest,
        ));
    }

    public function actionPpkActivityChart($id) {
        $ppk = Ppk::model()->findByPk($id);
        $packageAccounts = PackageAccount::model()->findAllByAttributes(array('ppk_code' => $ppk->code));
        $activityLists = array();
        if ($packageAccounts) {
            foreach ($packageAccounts as $packageAccount) {
                $activity = $packageAccount->activity->name;
                if (!in_array($activity, $activityLists, true)) {
                    array_push($activityLists, $activity);
                }
            }
        }
        $activityIdLists = array();
        if ($packageAccounts) {
            foreach ($packageAccounts as $packageAccount) {
                $activity = $packageAccount->activity->id;
                if (!in_array($activity, $activityIdLists, true)) {
                    array_push($activityIdLists, $activity);
                }
            }
        }
        $activityCodes = array();
        if ($packageAccounts) {
            foreach ($packageAccounts as $packageAccount) {
                $code = $packageAccount->activity_code;
                if (!in_array($code, $activityCodes, true)) {
                    array_push($activityCodes, $code);
                }
            }
        }
        $limits = array();
        for ($i = 0; $i < count($activityLists); $i++) {
            $accounts = PackageAccount::model()->findAllByAttributes(array('activity_code' => $activityCodes[$i], 'ppk_code' => $ppk->code));
            $limit = 0;
            if ($accounts) {
                foreach ($accounts as $account) {
                    $limit += $account->limit;
                }
                array_push($limits, $limit);
            }
        }
        $realizations = array();
        for ($i = 0; $i < count($activityLists); $i++) {
            $accounts = PackageAccount::model()->findAllByAttributes(array('activity_code' => $activityCodes[$i], 'ppk_code' => $ppk->code));
            $realization = 0;
            if ($accounts) {
                foreach ($accounts as $account) {
                    $realization += $account->getTotal($account->code)['realization'];
                }
                array_push($realizations, $realization);
            }
        }
        $rests = array();
        for ($i = 0; $i < count($activityLists); $i++) {
            $accounts = PackageAccount::model()->findAllByAttributes(array('activity_code' => $activityCodes[$i], 'ppk_code' => $ppk->code));
            $rest = 0;
            if ($accounts) {
                foreach ($accounts as $account) {
                    $rest += $account->getTotal($account->code)['restMoney'];
                }
                array_push($rests, $rest);
            }
        }
        $rates = array();
        for ($i = 0; $i < count($activityLists); $i++) {
            $accounts = PackageAccount::model()->findAllByAttributes(array('activity_code' => $activityCodes[$i], 'ppk_code' => $ppk->code));
            $realization = 0;
            $limit = 0;
            if ($accounts) {
                foreach ($accounts as $account) {
                    $realization += $account->getTotal($account->code)['realization'];
                    $limit +=$account->limit;
                }
                $rate = $realization / $limit;
                array_push($rates, $rate);
            } else {
                array_push($rates, 0);
            }
        }
        $this->render('ppkActivityChart', array(
            'ppk' => $ppk,
            'id' => $activityIdLists,
            'activityLists' => $activityLists,
            'limits' => $limits,
            'realizations' => $realizations,
            'rests' => $rests,
            'rates' => $rates,
        ));
    }

    public function actionPpkOutputChart($id, $ppkId) {
        $activity = Activity::model()->findByPk($id);
        $ppk = Ppk::model()->findByPk($ppkId);
        $packageAccounts = PackageAccount::model()->findAllByAttributes(array('activity_code' => "$activity->code", 'ppk_code' => "$ppk->code"));
        $outputLists = array();
        if ($packageAccounts) {
            foreach ($packageAccounts as $packageAccount) {
                $output = $packageAccount->output->name;
                if (!in_array($output, $outputLists, true)) {
                    array_push($outputLists, $output);
                }
            }
        }
        $outputIdLists = array();
        if ($packageAccounts) {
            foreach ($packageAccounts as $packageAccount) {
                $outputId = $packageAccount->output->id;
                if (!in_array($outputId, $outputIdLists, true)) {
                    array_push($outputIdLists, $outputId);
                }
            }
        }
        $outputCodes = array();
        if ($packageAccounts) {
            foreach ($packageAccounts as $packageAccount) {
                $code = $packageAccount->output_code;
                if (!in_array($code, $outputCodes, true)) {
                    array_push($outputCodes, $code);
                }
            }
        }
        $limits = array();
        for ($i = 0; $i < count($outputLists); $i++) {
            $accounts = PackageAccount::model()->findAllByAttributes(array('output_code' => $outputCodes[$i], 'ppk_code' => $ppk->code));
            $limit = 0;
            if ($accounts) {
                foreach ($accounts as $account) {
                    $limit += $account->limit;
                }
                array_push($limits, $limit);
            }
        }
        $realizations = array();
        for ($i = 0; $i < count($outputLists); $i++) {
            $accounts = PackageAccount::model()->findAllByAttributes(array('output_code' => $outputCodes[$i], 'ppk_code' => $ppk->code));
            $realization = 0;
            if ($accounts) {
                foreach ($accounts as $account) {
                    $realization += $account->getTotal($account->code)['realization'];
                }
                array_push($realizations, $realization);
            }
        }
        $rests = array();
        for ($i = 0; $i < count($outputLists); $i++) {
            $accounts = PackageAccount::model()->findAllByAttributes(array('output_code' => $outputCodes[$i], 'ppk_code' => $ppk->code));
            $rest = 0;
            if ($accounts) {
                foreach ($accounts as $account) {
                    $rest += $account->getTotal($account->code)['restMoney'];
                }
                array_push($rests, $rest);
            }
        }
        $rates = array();
        for ($i = 0; $i < count($outputLists); $i++) {
            $accounts = PackageAccount::model()->findAllByAttributes(array('output_code' => $outputCodes[$i], 'ppk_code' => $ppk->code));
            $realization = 0;
            $limit = 0;
            if ($accounts) {
                foreach ($accounts as $account) {
                    $realization += $account->getTotal($account->code)['realization'];
                    $limit +=$account->limit;
                }
                $rate = $realization / $limit;
                array_push($rates, $rate);
            } else {
                array_push($rates, 0);
            }
        }
        $this->render('ppkOutputChart', array(
            'ppk' => $ppk,
            'outputLists' => $outputLists,
            'id' => $outputIdLists,
            'limits' => $limits,
            'realizations' => $realizations,
            'rests' => $rests,
            'rates' => $rates,
        ));
    }

    public function actionPpkSuboutputChart($id, $ppkId) {
        $output = Output::model()->findByPk($id);
        $ppk = Ppk::model()->findByPk($ppkId);
        $packageAccounts = PackageAccount::model()->findAllByAttributes(array('output_code' => "$output->code", 'ppk_code' => "$ppk->code"));
        $suboutputLists = array();
        if ($packageAccounts) {
            foreach ($packageAccounts as $packageAccount) {
                $suboutput = $packageAccount->suboutput->name;
                if (!in_array($suboutput, $suboutputLists, true)) {
                    array_push($suboutputLists, $suboutput);
                }
            }
        }
        $suboutputIdLists = array();
        if ($packageAccounts) {
            foreach ($packageAccounts as $packageAccount) {
                $suboutputId = $packageAccount->suboutput->id;
                if (!in_array($suboutputId, $suboutputIdLists, true)) {
                    array_push($suboutputIdLists, $suboutputId);
                }
            }
        }
        $suboutputCodes = array();
        if ($packageAccounts) {
            foreach ($packageAccounts as $packageAccount) {
                $code = $packageAccount->suboutput_code;
                if (!in_array($code, $suboutputCodes, true)) {
                    array_push($suboutputCodes, $code);
                }
            }
        }
        $limits = array();
        for ($i = 0; $i < count($suboutputLists); $i++) {
            $accounts = PackageAccount::model()->findAllByAttributes(array('suboutput_code' => $suboutputCodes[$i], 'ppk_code' => $ppk->code));
            $limit = 0;
            if ($accounts) {
                foreach ($accounts as $account) {
                    $limit += $account->limit;
                }
                array_push($limits, $limit);
            }
        }
        $realizations = array();
        for ($i = 0; $i < count($suboutputLists); $i++) {
            $accounts = PackageAccount::model()->findAllByAttributes(array('suboutput_code' => $suboutputCodes[$i], 'ppk_code' => $ppk->code));
            $realization = 0;
            if ($accounts) {
                foreach ($accounts as $account) {
                    $realization += $account->getTotal($account->code)['realization'];
                }
                array_push($realizations, $realization);
            }
        }
        $rests = array();
        for ($i = 0; $i < count($suboutputLists); $i++) {
            $accounts = PackageAccount::model()->findAllByAttributes(array('suboutput_code' => $suboutputCodes[$i], 'ppk_code' => $ppk->code));
            $rest = 0;
            if ($accounts) {
                foreach ($accounts as $account) {
                    $rest += $account->getTotal($account->code)['restMoney'];
                }
                array_push($rests, $rest);
            }
        }
        $rates = array();
        for ($i = 0; $i < count($suboutputLists); $i++) {
            $accounts = PackageAccount::model()->findAllByAttributes(array('suboutput_code' => $suboutputCodes[$i], 'ppk_code' => $ppk->code));
            $realization = 0;
            $limit = 0;
            if ($accounts) {
                foreach ($accounts as $account) {
                    $realization += $account->getTotal($account->code)['realization'];
                    $limit +=$account->limit;
                }
                $rate = $realization / $limit;
                array_push($rates, $rate);
            } else {
                array_push($rates, 0);
            }
        }
        $this->render('ppkSuboutputChart', array(
            'ppk' => $ppk,
            'suboutputLists' => $suboutputLists,
            'id' => $suboutputIdLists,
            'limits' => $limits,
            'realizations' => $realizations,
            'rests' => $rests,
            'rates' => $rates,
        ));
    }

    public function actionPpkComponentChart($id, $ppkId) {
        $suboutput = Suboutput::model()->findByPk($id);
        $ppk = Ppk::model()->findByPk($ppkId);
        $packageAccounts = PackageAccount::model()->findAllByAttributes(array('suboutput_code' => "$suboutput->code", 'ppk_code' => "$ppk->code"));
        $componentLists = array();
        if ($packageAccounts) {
            foreach ($packageAccounts as $packageAccount) {
                $component = $packageAccount->component->name;
                if (!in_array($component, $componentLists, true)) {
                    array_push($componentLists, $component);
                }
            }
        }
        $componentIdLists = array();
        if ($packageAccounts) {
            foreach ($packageAccounts as $packageAccount) {
                $componentId = $packageAccount->component->id;
                if (!in_array($componentId, $componentIdLists, true)) {
                    array_push($componentIdLists, $componentId);
                }
            }
        }
        $componentCodes = array();
        if ($packageAccounts) {
            foreach ($packageAccounts as $packageAccount) {
                $code = $packageAccount->component_code;
                if (!in_array($code, $componentCodes, true)) {
                    array_push($componentCodes, $code);
                }
            }
        }
        $limits = array();
        for ($i = 0; $i < count($componentLists); $i++) {
            $accounts = PackageAccount::model()->findAllByAttributes(array('component_code' => $componentCodes[$i], 'ppk_code' => $ppk->code));
            $limit = 0;
            if ($accounts) {
                foreach ($accounts as $account) {
                    $limit += $account->limit;
                }
                array_push($limits, $limit);
            }
        }
        $realizations = array();
        for ($i = 0; $i < count($componentLists); $i++) {
            $accounts = PackageAccount::model()->findAllByAttributes(array('component_code' => $componentCodes[$i], 'ppk_code' => $ppk->code));
            $realization = 0;
            if ($accounts) {
                foreach ($accounts as $account) {
                    $realization += $account->getTotal($account->code)['realization'];
                }
                array_push($realizations, $realization);
            }
        }
        $rests = array();
        for ($i = 0; $i < count($componentLists); $i++) {
            $accounts = PackageAccount::model()->findAllByAttributes(array('component_code' => $componentCodes[$i], 'ppk_code' => $ppk->code));
            $rest = 0;
            if ($accounts) {
                foreach ($accounts as $account) {
                    $rest += $account->getTotal($account->code)['restMoney'];
                }
                array_push($rests, $rest);
            }
        }
        $rates = array();
        for ($i = 0; $i < count($componentLists); $i++) {
            $accounts = PackageAccount::model()->findAllByAttributes(array('component_code' => $componentCodes[$i], 'ppk_code' => $ppk->code));
            $realization = 0;
            $limit = 0;
            if ($accounts) {
                foreach ($accounts as $account) {
                    $realization += $account->getTotal($account->code)['realization'];
                    $limit +=$account->limit;
                }
                $rate = $realization / $limit;
                array_push($rates, $rate);
            } else {
                array_push($rates, 0);
            }
        }
        $this->render('ppkComponentChart', array(
            'ppk' => $ppk,
            'componentLists' => $componentLists,
            'id' => $componentIdLists,
            'limits' => $limits,
            'realizations' => $realizations,
            'rests' => $rests,
            'rates' => $rates,
        ));
    }

    public function actionPpkPackageChart($id, $ppkId) {
        $component = Component::model()->findByPk($id);
        $ppk = Ppk::model()->findByPk($ppkId);
        $packageAccounts = PackageAccount::model()->findAllByAttributes(array('component_code' => "$component->code", 'ppk_code' => "$ppk->code"));
        $packageLists = array();
        if ($packageAccounts) {
            foreach ($packageAccounts as $packageAccount) {
                $package = $packageAccount->package->name;
                if (!in_array($package, $packageLists, true)) {
                    array_push($packageLists, $package);
                }
            }
        }
        $packageIdLists = array();
        if ($packageAccounts) {
            foreach ($packageAccounts as $packageAccount) {
                $packageId = $packageAccount->package->id;
                if (!in_array($packageId, $packageIdLists, true)) {
                    array_push($packageIdLists, $packageId);
                }
            }
        }
        $packageCodes = array();
        if ($packageAccounts) {
            foreach ($packageAccounts as $packageAccount) {
                $code = $packageAccount->package_code;
                if (!in_array($code, $packageCodes, true)) {
                    array_push($packageCodes, $code);
                }
            }
        }
        $limits = array();
        for ($i = 0; $i < count($packageCodes); $i++) {
            $accounts = PackageAccount::model()->findAllByAttributes(array('package_code' => $packageCodes[$i], 'ppk_code' => $ppk->code));
            $limit = 0;
            if ($accounts) {
                foreach ($accounts as $account) {
                    $limit += $account->limit;
                }
                array_push($limits, $limit);
            }
        }
        $realizations = array();
        for ($i = 0; $i < count($packageCodes); $i++) {
            $accounts = PackageAccount::model()->findAllByAttributes(array('package_code' => $packageCodes[$i], 'ppk_code' => $ppk->code));
            $realization = 0;
            if ($accounts) {
                foreach ($accounts as $account) {
                    $realization += $account->getTotal($account->code)['realization'];
                }
                array_push($realizations, $realization);
            }
        }
        $rests = array();
        for ($i = 0; $i < count($packageCodes); $i++) {
            $accounts = PackageAccount::model()->findAllByAttributes(array('package_code' => $packageCodes[$i], 'ppk_code' => $ppk->code));
            $rest = 0;
            if ($accounts) {
                foreach ($accounts as $account) {
                    $rest += $account->getTotal($account->code)['restMoney'];
                }
                array_push($rests, $rest);
            }
        }
        $rates = array();
        for ($i = 0; $i < count($packageCodes); $i++) {
            $accounts = PackageAccount::model()->findAllByAttributes(array('package_code' => $packageCodes[$i], 'ppk_code' => $ppk->code));
            $realization = 0;
            $limit = 0;
            if ($accounts) {
                foreach ($accounts as $account) {
                    $realization += $account->getTotal($account->code)['realization'];
                    $limit +=$account->limit;
                }
                $rate = $realization / $limit;
                array_push($rates, $rate);
            } else {
                array_push($rates, 0);
            }
        }
        $this->render('ppkPackageChart', array(
            'ppk' => $ppk,
            'packageLists' => $packageLists,
            'id' => $packageIdLists,
            'limits' => $limits,
            'realizations' => $realizations,
            'rests' => $rests,
            'rates' => $rates,
        ));
    }

    public function actionPpkPackageAccountChart($id, $ppkId) {
        $package = Package::model()->findByPk($id);
        $ppk = Ppk::model()->findByPk($ppkId);
        $packageAccounts = PackageAccount::model()->findAllByAttributes(array('package_code' => "$package->code", 'ppk_code' => "$ppk->code"));
        $this->render('ppkPackageAccountChart', array(
            'ppk' => $ppk,
            'package' => $package,
            'packageAccounts' => $packageAccounts,
        ));
    }

//Show performance Dashboard
    public function actionPerformanceDashboard() {
        //Get satker data
        $satker = Satker::model()->findByAttributes(array('code' => '622280'));
        //Define needed variable
        $limit = 0;
        $realization = 0;
        $rate = 0;
        //Get budget information value
        if ($satker) {
            /** --Find all package account data on current satker-- */
            $packageAccounts = PackageAccount::model()->findAllByAttributes(array('satker_code' => "$satker->code"));
            if ($packageAccounts) {
                //Calculate limit, realization, and rate
                foreach ($packageAccounts as $data) {
                    $limit +=$data->limit;
                    //Calculate realization
                    $realization +=PackageAccount::model()->getTotal($data->code)['realization'];
                }
                if ($limit != 0) {
                    $rate = ($realization / $limit) * 100;
                }
            }
        }
        //Get budget information for each ppk
        $ppks = Ppk::model()->findAll();
        $limitPpk = array();
        if ($ppks) {
            foreach ($ppks as $ppk) {
                $limitPpk[$ppk->code] = 0;
                $realizationPpk[$ppk->code] = 0;
                $ratePpk[$ppk->code] = 0;
                $packageAccountPpks = PackageAccount::model()->findAllByAttributes(array('ppk_code' => "$ppk->code"));
                if ($packageAccountPpks) {
                    foreach ($packageAccountPpks as $paPpk) {
                        $limitPpk[$ppk->code]+=$paPpk->limit;
                        $realizationPpk[$ppk->code]+=PackageAccount::model()->getTotal($paPpk->code)['realization'];
                    }
                    if ($limitPpk[$ppk->code] != 0) {
                        $ratePpk[$ppk->code] = ( $realizationPpk[$ppk->code] / $limitPpk[$ppk->code]) * 100;
                    }
                }
            }
        }
        $this->render('performanceDashboard', array(
            'data' => $satker,
            'limit' => $limit,
            'realization' => $realization,
            'rate' => $rate,
            'ppks' => $ppks,
            'ratePpk' => $ratePpk,
            'limitPpk' => $limitPpk,
            'realizationPpk' => $realizationPpk,
        ));
    }

    public function actionTableReport() {
        $data = Satker::model()->findByAttributes(array('code' => '622280'));
        $ppk = array();
        $limit = array();
        $realization = array();
        $rate = array();
        $countData = array();
        $ratePpk = array();
        $limitPpk = array();
        $totalRealPpk = array();

        if ($data) {
            $packageAccount = PackageAccount::model()->findAllByAttributes(array('satker_code' => "$data->code"));
            $countData[$data->code] = 0;
            $limit[$data->code] = 0;
            $realization[$data->code] = 0;
            $rate[$data->code] = 0;
            if ($packageAccount) {
                $countData[$data->code] = count($packageAccount);

                foreach ($packageAccount as $pa) {
                    $limit[$data->code] +=$pa->limit;
                    $realData = Realization::model()->findAllByAttributes(array('packageAccount_code' => "$data->code"));
                    $totalRealization = 0;
                    if ($realData) {
                        foreach ($realData as $r) {
                            $totalRealization +=$r->total_spm;
                        }
                    }
                    $realization[$data->code]+=$totalRealization;
                }
            }
            if ($limit[$data->code] != 0) {
                $rate[$data->code] = ($realization[$data->code] / $limit[$data->code]) * 100;
            }
            $ppks = Ppk::model()->findAll();
            if ($ppks) {
                foreach ($ppks as $ppk) {
                    $paPpk = PackageAccount::model()->findAllByAttributes(array('ppk_code' => "$ppk->code"));
                    $limitPpk[$ppk->code] = 0;
                    $ratePpk[$ppk->code] = 0;
                    $totalRealPpk[$ppk->code] = 0;
                    if ($paPpk) {
                        foreach ($paPpk as $p) {
                            $limitPpk[$ppk->code] +=$p->limit;
                            $realPpk = Realization::model()->findAllByAttributes(array('packageAccount_code' => "$p->code"));
                            $realizationPpk = 0;
                            if ($realPpk) {
                                foreach ($realPpk as $dataReal) {
                                    $realizationPpk +=$dataReal->total_spm;
                                }
                            }
                            $totalRealPpk[$ppk->code]+=$realizationPpk;
                        }
                        if ($limitPpk != 0) {
                            $ratePpk[$ppk->code] = ($totalRealPpk[$ppk->code] / $limitPpk[$ppk->code]) * 100;
                        }
                    }
                }
            }
        }
        echo $data->name . "</br>";
        echo $limit[$data->code] . "</br>";
        echo $realization[$data->code] . "</br>";
//        $this->title = 'Tabel Penggunaan Anggaran';
//        $say = 'Ini adalah page report penggunaan anggaran';
//        $this->render('tableReport', array(
//            'say' => $say,
//        ));
    }

}
