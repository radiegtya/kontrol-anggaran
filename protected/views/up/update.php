<div class="panel panel-default">
    <div class="panel-header">
        <?php
        /*
          $this->breadcrumbs = array(
          'Ups' => array('index'),
          $model->id => array('view', 'id' => $model->id),
          'Update',
          );
         * 
         */
        ?>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial('_form', array('model' => $model, 'detail' => $detail)); ?>
    </div>
</div>