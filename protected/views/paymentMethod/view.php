<?php
$this->breadcrumbs = array(
    'Payment Methods' => array('index'),
    $model->name,
);
?>
<div class="panel panel-default">
    <div class="panel-header">
        <a href="<?php echo Yii::app()->baseUrl . '/paymentMethod/admin'; ?>" class="btn btn-primary"><i class="fa fa-fw fa-table"></i>Daftar</a>
        <a href="<?php echo Yii::app()->baseUrl . '/paymentMethod/create'; ?>" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>Tambah</a>
        <a href="<?php echo Yii::app()->baseUrl . '/paymentMethod/update/' . $model->id; ?>" class="btn btn-primary"><i class="fa fa-fw fa-pencil"></i>Update</a>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.TbDetailView', array(
            'data' => $model,
            'attributes' => array(
                'code',
                'name',
                array(
                    'name' => 'created_at',
                    'value' => Yii::app()->dateFormatter->format('dd MMM yyyy', $model->created_at),
                ),
                array(
                    'name' => 'created_by',
                    'value' => $model->createdBy->username,
                    'source' => User::model()->getOptions(),
                ),
            ),
        ));
        ?>
    </div>
</div>
