<?php

/**
 * Redactorjs widget
 *
 * @author Vincent Gabriel
 * v 1.0
 */
class Redactor extends CInputWidget {

    public $path;

    /**
     * Editor language
     * Supports: de, en, fr, lv, pl, pt_br, ru, ua
     */
    public $lang = 'en';

    /**
     * Editor toolbar
     * Supports: default, mini
     */
    public $toolbar = 'default';

    /**
     * Html options that will be assigned to the text area
     */
    public $htmlOptions = array();

    /**
     * Editor options that will be passed to the editor
     */
    public $editorOptions = array();

    /**
     * Debug mode
     * Used to publish full js file instead of min version
     */
    public $debugMode = false;

    /**
     * Editor width
     */
    public $width = '100%';

    /**
     * Editor height
     */
    public $height = '250px';

    /**
     * Display editor
     */
    public function run() {       
        // Resolve name and id
        list($name, $id) = $this->resolveNameID();

        // Get assets dir
        $baseDir = dirname(__FILE__);
        $assets = Yii::app()->getAssetManager()->publish($baseDir . DIRECTORY_SEPARATOR . 'assets');

        // Publish required assets
        $cs = Yii::app()->getClientScript();

        $jsFile = $this->debugMode ? 'redactor.js' : 'redactor.min.js';
        $cs->registerScriptFile($assets . '/' . $jsFile);
        $cs->registerCssFile($assets . '/css/redactor.css');

        $this->htmlOptions['id'] = $id;

        if (!array_key_exists('style', $this->htmlOptions)) {
            $this->htmlOptions['style'] = "width:{$this->width};height:{$this->height};";
        }

        $options = CJSON::encode(array_merge($this->editorOptions, array('lang' => $this->lang, 'toolbar' => $this->toolbar)));

        $js = <<<EOP
		$('#{$id}').redactor({$options});
EOP;
        // Register js code
        $cs->registerScript('Yii.' . get_class($this) . '#' . $id, $js, CClientScript::POS_READY);

        // Do we have a model
        if ($this->hasModel()) {
            $html = CHtml::activeTextArea($this->model, $this->attribute, $this->htmlOptions);
        } else {
            $html = CHtml::textArea($name, $this->value, $this->htmlOptions);
        }

        echo $html;
    }

    public function setPath($path) {
        $this->path = $path;
    }

    /**
     * upload image to server
     */
    public function uploadImage() {
        $file = CUploadedFile::getInstanceByName('file');
        if ($file->saveAs(Yii::app()->basePath . '/../' . $this->path . '/' . $file->name)) {
            echo CHtml::image(Yii::app()->baseUrl . '/' . $this->path . '/' . $file->name);
            Yii::app()->end();
        }

        throw new CHttpException(403, 'The server is crying in pain as you try to upload bad stuff');
    }

    /**
     * upload file to server
     */
    public function uploadFile() {
        $file = CUploadedFile::getInstanceByName('file');        
        if ($file->saveAs(Yii::app()->basePath . '/../' . $this->path . '/' . $file->name)) {                        
            echo CHtml::link($file->name, Yii::app()->baseUrl . '/' . $this->path . '/' . $file->name, array('class'=>$this->getIconByExt($file)));            
            Yii::app()->end();
        }

        throw new CHttpException(403, 'The server is crying in pain as you try to upload bad stuff');
    }

    /**
     * get file to show at editor
     */
    public function getFile() {
        $images = array();

        $handler = opendir(Yii::app()->basePath . '/../' . $this->path);

        while ($file = readdir($handler)) {
            if ($file != "." && $file != "..")
                $images[] = $file;
        }
        closedir($handler);

        $jsonArray = array();

        foreach ($images as $image)
            $jsonArray[] = array(
                'thumb' => Yii::app()->baseUrl . '/' . $this->path . '/' . $image,
                'image' => Yii::app()->baseUrl . '/' . $this->path . '/' . $image
            );

        header('Content-type: application/json');
        echo CJSON::encode($jsonArray);
    }

    /**
     * get icon by extension
     */
    function getIconByExt($file) {
        if ($file) {
            $file = explode('.', $file);
            $fileExt = $file[1];

            switch ($fileExt) {
                case 'doc' : $class = 'icon file-word';
                    break;
                case 'docx' : $class = 'icon file-word';
                    break;
                case 'pdf' : $class = 'icon file-pdf';
                    break;
                case 'zip' : $class = 'icon file-zip';
                    break;
                case 'rar' : $class = 'icon file-zip';
                    break;
                case 'jpg' : $class = 'icon file-image';
                    break;
                case 'jpeg' : $class = 'icon file-image';
                    break;
                case 'png' : $class = 'icon file-image';
                    break;
                case 'gif' : $class = 'icon file-image';
                    break;
                case 'xls' : $class = 'icon file-excel';
                    break;
                case 'xlsx' : $class = 'icon file-excel';
                    break;
                case 'ppt' : $class = 'icon file-ppt';
                    break;
                case 'pptx' : $class = 'icon file-excel';
                    break;
                default : $class = 'icon file-zip';
                    break;
            }

            return $class;
        } else {
            return '';
        }
    }

}

?>
