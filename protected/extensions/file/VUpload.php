<?php

/**
 * THIS CLASS WAS CREATED BY VLO CORPORATION (AUTHOR: EGA WACHID RADIEGTYA)
 * 1. add this variable to model 
 * public $image;  
 * 2. add rules to model
 * array('file_name', 'file', 'types' => 'jpg, gif, png, jpeg', 'allowEmpty' => true),
 * 3. don't use $model->attributes when saving data, but save it by every POST data
 * 4. add this to form view CActiveForm begin widget array
 * 'htmlOptions' => array('enctype' => 'multipart/form-data'),
 * 5. change textField in view to fileField
 * 6. import VUpload in controller
 * Yii::import('ext.vlo.upload.VUpload');
 * 7. define VUpload in Controller function create or update after line if (isset($_POST['Model'])) {
 * $VUpload = new VUpload();
 * 8. setting the path
 * $VUpload->path = 'images/';
 * 9. do upload
 * $VUpload->doUpload($model, 'image');
 * 10. to delete file, do'nt delete from database first, but call doDelete() first
 * $model = $this->loadModel($id);
  $VUpload = new VUpload();
  $VUpload->path = 'images/slider/';
  $VUpload->doDelete($model, 'image');
  $model->delete();
 * 
 */
class VUpload extends CComponent {

    public $path;

    /**
     * setting the path      
     */
    public function setPath($path) {
        $this->path = Yii::getPathOfAlias('webroot') . "/$path/";
    }

    /**
     * get the path for controller    
     */
    public function getPath() {
        return $this->path;
    }

    /**
     * doing upload     
     */
    public function doUpload($model, $fileName) {
        //set image name for saved to db
        $encryptImage = ip2long(Yii::app()->request->getUserHostAddress()) . date('Ymdhis') . Yii::app()->user->id;
        ${$fileName} = CUploadedFile::getInstance($model, "$fileName");

        //if isset image file uploaded
        if (${$fileName}) {
            //unlink from folder if there is field in db
            if ($model->{$fileName})
                unlink($this->getPath() . $model->{$fileName});
            //saved to db
            $model->{$fileName} = $encryptImage . ${$fileName};
            //upload image as to path and name same with db
            ${$fileName}->saveAs($this->getPath() . $model->{$fileName});
        }
        return $model->{$fileName};
    }

    /**
     * to delete or unlink file     
     */
    public function doDelete($model, $fileName) {
        $model;
        if ($model->{$fileName})
            unlink($this->getPath() . $model->{$fileName});
    }

}
