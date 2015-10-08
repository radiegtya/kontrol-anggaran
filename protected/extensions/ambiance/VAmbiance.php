<?php

class VAmbiance extends CWidget {

    public function init() {
        $this->publishAssets();
        $this->render('run');
    }

    protected static function publishAssets() {
        $assets = dirname(__FILE__) . DIRECTORY_SEPARATOR . '/assets';
        $baseUrl = Yii::app()->assetManager->publish($assets);
        if (is_dir($assets)) {
            Yii::app()->clientScript->registerCoreScript('jquery');
            Yii::app()->clientScript->registerScriptFile($baseUrl . '/jquery.ambiance.js');
            Yii::app()->clientScript->registerScriptFile($baseUrl . '/main.js');
            Yii::app()->clientScript->registerCssFile($baseUrl . '/jquery.ambiance.css');
            Yii::app()->clientScript->registerCssFile($baseUrl . '/main.css');
        } else {
            throw new Exception('VAmbiance - Error: Couldn\'t find assets to publish.');
        }
    }

    /*
     * function to automaticatlly run the messager without flash session
     */

    public function getMessage($key, $message) {
        $this->render('getMessage', array(
            'key' => $key,
            'message' => $message,
        ));
    }

    public static function messager($key, $message) {
        echo
        "<script>                       
        $(function(){
            $.ambiance({
                message: '$message', 
                title: '$key',
                type: '$key',
                timeout: 5
            });
        })
        </script>
        ";
    }

}
