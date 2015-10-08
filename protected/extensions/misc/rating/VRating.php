<?php

class VRating extends CWidget {
    
    public $url;
    public $selector;

    public function init() {
        $this->publishAssets();        
    }

    public function run() {        
        $this->render('run', array(                        
            'url'=>$this->url,    
            'selector'=>$this->selector,
        ));
    }

    protected static function publishAssets() {
        $assets = dirname(__FILE__) . DIRECTORY_SEPARATOR . '/assets';
        $baseUrl = Yii::app()->assetManager->publish($assets);
        if (is_dir($assets)) {
            //jquery core
            Yii::app()->clientScript->registerCoreScript('jquery');
            
            //css
            Yii::app()->clientScript->registerCssFile($baseUrl . '/css/jquery.rating.css');                    
            
            //js
            Yii::app()->clientScript->registerScriptFile($baseUrl . '/js/jquery.rating.js');                     
        } else {
            throw new Exception('VRating - Error: Couldn\'t find assets to publish.');
        }
    }

}