<div class="panel panel-default" style="color: black">
    <?php if ($showContent): ?>
        <div class="panel-header">
            <?php
            /*
              $this->breadcrumbs = array(
              'Dipas' => array('index'),
              'Create',
              );
             * 
             */
            ?>
            <a href="<?php echo Yii::app()->baseUrl . '/dipa/admin'; ?>" class="btn btn-primary"><i class="fa fa-fw fa-table"></i>Daftar</a>
        </div>
        <div class="panel-body">
            <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
        </div>
    <?php else: ?>
        <div class="panel-header">
            <h4>Data master belum diinput dengan lengkap.</h4>
        </div>
        <div class="panel-body">
            <h4>Silahkan lengkapi data master terlebih dahulu.</h4>
        </div>
    <?php endif; ?>
</div>