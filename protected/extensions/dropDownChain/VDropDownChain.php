<?php

/**
 * Add this to the view
 * 
  <?php $this->widget('ext.vlo.form.VDropDownChain', array(
  'parentId'=>'category_id',
  'childId'=>'sub_category_id',
  'url'=>'post/GetSubCategoryOptions',
  'valueField'=>'id', //child value field
  'textField'=>'name', //child text field
  ));?>
 * 
 * then add to controller actionGetChainOptions()
 * 
 */
class VDropDownChain extends CWidget {

    public $parentId;
    public $childId;
    public $url;
    public $valueField;
    public $textField;

    public function init() {
        $this->publishAssets();
    }

    public function run() {
        $this->render('run', array(
            'parentId' => $this->parentId,
            'childId' => $this->childId,
            'url' => $this->url,
            'valueField' => $this->valueField,
            'textField' => $this->textField,
        ));
    }

    protected static function publishAssets() {
        //$assets = dirname(__FILE__) . DIRECTORY_SEPARATOR . '/assets';
        //$baseUrl = Yii::app()->assetManager->publish($assets);
        Yii::app()->clientScript->registerCoreScript('jquery');
        /*
          if (is_dir($assets)) {
          Yii::app()->clientScript->registerCoreScript('jquery');
          } else {
          throw new Exception('VDropDownChain - Error: Couldn\'t find assets to publish.');
          }
         */
    }

    /**
     * AJAX dropdownList get child chain, add this to controller
     */
    public function actionGetChainOptions() {
        $parentId = $_POST['parentId']; //set according to your parentId ex:category_id and it must from database FK
        $model = TheModel::model()->findAllByAttributes(array(//set the model according to your model Class Name
            'parentId' => $parentId //set according to your parentId ex:category_id and it must from database FK
                ));

        $option = array('0' => 'Please Select'); //set null value
        $options = CHtml::listData($model, 'id', 'name'); //list data according to your db field
        $options = CMap::mergeArray($option, $options);
        echo json_encode($options);
    }
    
    

}