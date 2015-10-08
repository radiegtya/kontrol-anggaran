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
* 11. to upload file, add this after if(isset($_POST['Blah']))
$model->attributes = $_POST['Post'];
            $VUpload = new VUpload();
            $VUpload->path = 'images/post/';
            $VUpload->doUpload($model, 'image');
            if(!$model->image){
                $model->image = Post::model()->findByPk($id)->image;
            }
 * 
 */

COPYRIGHT BY VLO CORPORATION 
AUTHOR: EGA WACHID RADIEGTYA
EMAIL: RADIEGTYA@YAHOO.CO.ID
PHONE: 085641278479