<?php

class LoadMask extends CWidget {

    public function init() {
        $this->publishAssets();        
    }

    protected static function publishAssets() {
        $assets = dirname(__FILE__) . DIRECTORY_SEPARATOR . '/assets';
        $baseUrl = Yii::app()->assetManager->publish($assets);
        if (is_dir($assets)) {
            Yii::app()->clientScript->registerCoreScript('jquery');
            Yii::app()->clientScript->registerScriptFile($baseUrl . '/jquery.loadmask.min.js');            
            Yii::app()->clientScript->registerCssFile($baseUrl . '/jquery.loadmask.css');            
        } else {
            throw new Exception('LoadMask - Error: Couldn\'t find assets to publish.');
        }
    }   

}
