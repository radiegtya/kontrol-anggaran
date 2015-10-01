<div class="panel panel-default" style="color: black">
    <div class="panel-header">
        <?php
        /*
          $this->breadcrumbs = array(
          'Dipas' => array('index'),
          $model->id,
          );
         * 
         */
        ?>
        <a href="<?php echo Yii::app()->baseUrl . '/dipa/index'; ?>" class="btn btn-primary"><i class="fa fa-fw fa-table"></i>Kembali Daftar DIPA/POK</a>
        <!--<a href="<?php echo Yii::app()->baseUrl . '/dipa/create'; ?>" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>Tambah</a>-->
        <a href="<?php echo Yii::app()->baseUrl . '/dipa/update/' . $model->id; ?>" class="btn btn-primary"><i class="fa fa-fw fa-pencil"></i>Update Keterangan DIPA/POK</a>
    </div>
    <div class="panel-body">

        <?php
        $this->widget('bootstrap.widgets.TbDetailView', array(
            'data' => $model,
            'attributes' => array(
                'budget_year',
                'dipa_number',
                array(
                    'name' => 'dipa_date',
                    'value' => date("j F Y", strtotime($model->dipa_date)),
                ),
                'type',
                array(
                    'name' => 'dipa_number',
                    'label' => 'Total Anggaran',
                    'value' => "Rp " . Yii::app()->format->number($model->getTotal($model->id), 2),
                ),
                array(
                    'name' => 'created_at',
                    'value' => date("j F Y", strtotime($model->created_at)),
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
<div class="panel panel-default" style="color: black">
    <div class="panel-header">
        <h4>Detail DIPA</h4>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <?php
            $this->widget('bootstrap.widgets.TbGridView', array(
                'id' => 'budget-grid',
                'dataProvider' => $budgetModel->searchBudget($id),
                'columns' => array(
                    array(
                        'header' => 'No',
                        'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                    ),
                    array(
                        'name' => 'code',
                        'value' => '$data->code',
                    ),
                    array(
                        'name' => 'output_code',
                        'value' => 'isset($data->outputCode->name)?$data->outputCode->name:$data->output_code',
                    ),
                    array(
                        'name' => 'suboutput_code',
                        'value' => 'isset($data->suboutputCode->name)?$data->suboutputCode->name:$data->suboutput_code',
                    ),
                    array(
                        'name' => 'component_code',
                        'value' => 'isset($data->componentCode->name)?$data->componentCode->name:$data->component_code',
                    ),
                    array(
                        'name' => 'subcomponent_code',
                        'value' => 'isset($data->subcomponentCode->name)?$data->subcomponentCode->name:$data->subcomponent_code',
                    ),
                    array(
                        'name' => 'account_code',
                        'value' => 'isset($data->accountCode->name)?$data->accountCode->name:$data->account_code',
                    ),
                    array(
                        "name" => "total_budget_limit",
                        "value" => 'Yii::app()->format->number($data->total_budget_limit)',
                        'htmlOptions' => array('style' => 'text-align: right;'),
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>

