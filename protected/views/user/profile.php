<div class="panel-default panel">
    <div class="panel-header">
        <a href="<?php echo Yii::app()->baseUrl . '/user/admin'; ?>" class="btn btn-primary"><i class="fa fa-fw fa-table"></i>Daftar</a>
        <?php if (Yii::app()->user->id == $model->id): ?>
            <a class="btn" href="<?php echo Yii::app()->baseUrl . '/user/updatePassword/' . $model->id; ?>"><i class="fa fa-fw fa-wrench"></i>Ubah Password</a>
        <?php endif; ?>

<!--<a class="btn" href="<?php // echo Yii::app()->baseUrl . '/user/update/' . $model->id;          ?>">Ubah Username</a>-->
        <?php if ($role == 'super-admin' && Yii::app()->user->id != $model->id): ?>
            <a class="btn" href="<?php echo Yii::app()->baseUrl . '/user/updateAuth/' . $model->id; ?>"><i class="fa fa-fw fa-cog"></i>Ubah Hak Akses</a> 
        <?php endif; ?>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="span6">
                <br/>

                <table class="table table-h-border">
                    <tbody>
                        <tr>
                            <td><b>Username</b></td>
                            <td><?php echo $model->username; ?></td>
                        </tr>
                        <tr>
                            <td><b>Level User</b></td>
                            <td><?php echo $model->group->name; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


