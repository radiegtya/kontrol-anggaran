1. ADD THIS TO _form WHICH TEXTAREA

<?php
                $this->widget('ext.vlo.redactorjs.Redactor', array( 
                    'model' => $model,
                    'attribute' => 'article',
                    'editorOptions' => array( 
                        'imageUpload' => Yii::app()->createAbsoluteUrl('post/uploadRedactor/?type=image'),
                        'imageGetJson' => Yii::app()->createAbsoluteUrl('post/uploadRedactor/1/?type=image'),
                        'fileUpload'  => Yii::app()->createAbsoluteUrl('post/uploadRedactor/?type=file'),
                        'fileGetJson'  => Yii::app()->createAbsoluteUrl('post/uploadRedactor/1/?type=file'),
                        ),
                    ));
                ?>

2. ADD THIS ACTION TO CONTROLLER
    
public function actionUploadRedactor($get = null, $type = null) {
        Yii::import('ext.vlo.redactorjs.Redactor');
        $redactor = new Redactor();

        //if get true, then get file to render at editor, else upload the file
        if ($get)
            $redactor->getFile();
        else {
            //set path by it's type
            if ($type == 'image') {
                $redactor->setPath('images/post'); //set image path here
                $redactor->uploadImage();
            } else {
                $redactor->setPath('files/post'); //set file path here
                $redactor->uploadFile();
            }
        }
    }