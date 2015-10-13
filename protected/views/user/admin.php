<div class="panel panel-default">
    <div class="panel-header">
        <?php
        /*
          $this->breadcrumbs = array(
          'Users' => array('index'),
          'Manage',
          );
         * 
         */
        ?>
        <a href="<?php echo yii::app()->baseUrl; ?>/user/create" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i> Tambah</a>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.TbGridView', array(
            'id' => 'user-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(
                array(
                    'header' => 'No',
                    'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                ),
                'username',
                array(
                    'name' => 'group_id',
                    'value' => '$data->group->name',
                    'filter' => Group::model()->getOptions(),
                ),
                array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                    'template' => '{updatePassword}{profile}{updateAuth}{delete}',
                    /*
                      'template' => '{update}{updatePassword}{updateAuth}{delete}{profile}',
                     * 
                     */
                    'buttons' => array(
                        'profile' => array(
                            'label' => 'Profile',
                            'icon' => 'icon-user',
                            'url' => 'Yii::app()->createUrl("user/profile", array( "id" => $data->id))',
                        ),
                        /*
                          'update' => array(
                          'label' => 'Update',
                          'icon' => 'icon-pencil',
                          'url' => 'Yii::app()->createUrl("user/update", array( "id" => $data->id))',
                          'visible' => '$data->id == Yii::app()->user->id',
                          ),
                         * 
                         */
                        'updatePassword' => array(
                            'label' => 'Update Password',
                            'icon' => 'icon-wrench',
                            'url' => 'Yii::app()->createUrl("user/updatePassword", array( "id" => $data->id))',
                            'visible' => '$data->id == Yii::app()->user->id',
                        ),
                        'updateAuth' => array(
                            'label' => 'Setting',
                            'icon' => 'icon-cog',
                            'url' => 'Yii::app()->createUrl("user/updateAuth", array( "id" => $data->id))',
                            'visible' => '$data->id == Yii::app()->user->id && $data->group->name!="administrator" || Yii::app()->user->id=="1"',
                        ),
                        'delete' => array(
                            'label' => 'Delete',
                            'visible' => 'Yii::app()->user->id == "1" && Yii::app()->user->id!=$data->id',
                        ),
                    ),
                ),
            ),
        ));
        ?>
    </div>
</div>