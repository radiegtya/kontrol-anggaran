<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php
echo "<?php\n";
$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label'=>array('index'),
	\$model->{$nameColumn},
);\n";
?>

$this->menu=array(
	array('label'=>'List <?php echo $this->modelClass; ?>','url'=>array('index')),
	array('label'=>'Create <?php echo $this->modelClass; ?>','url'=>array('create')),
	array('label'=>'Update <?php echo $this->modelClass; ?>','url'=>array('update','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>)),
	array('label'=>'Delete <?php echo $this->modelClass; ?>','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage <?php echo $this->modelClass; ?>','url'=>array('admin')),
);
?>

<h2>View <?php echo $this->modelClass." #<?php echo \$model->{$this->tableSchema->primaryKey}; ?>"; ?></h2>

<?php echo "<?php"; ?> $this->widget('bootstrap.widgets.TbEditableDetailView',array(
'url' => $this->createUrl('<?php echo strtolower($this->modelClass); ?>/editable'),
	'data'=>$model,
	'attributes'=>array(
<?php
foreach($this->tableSchema->columns as $column)
        if($column->isForeignKey){
            echo "\t\tarray("."\n";
            echo "\t\t\t'name'=>'".$column->name."',\n";
            echo "\t\t\t'value'=>".'$model->'.$this->getForeignKeyColumn($column->name)."->name,\n";
            echo "\t\t\t'editable'=>array(\n";
            echo "\t\t\t\t'type'=>'select',\n";
            echo "\t\t\t\t'source'=>".$this->getForeignKeyClass($column->name)."::model()->getOptions(),\n";            
            echo "\t\t\t),\n";
            echo "\t\t),\n";
        }elseif($column->size == 257){        
            echo 'array('."\n";
            echo "\t\t'name'=>'".$column->name."',\n";
            echo "\t\t'value'=>".'($model->image)?CHtml::image(Yii::app()->baseUrl."/images/'.$this->class2id($this->modelClass).'/".$model->image, $model->id, array("width"=>"100px", "height"=>"100px")):CHtml::image(Yii::app()->baseUrl."/images/'.$this->class2id($this->modelClass).'/noimage.gif", $model->id, array("width"=>"100px", "height"=>"100px"))'.",\n";
            echo "\t\t'type'=>'raw',\n";
            echo '),'."\n";
        }elseif(substr ($column->dbType, 0, 4) == 'enum'){
            echo "\t\tarray("."\n";
            echo "\t\t\t'name'=>'".$column->name."',\n";
            echo "\t\t\t'value'=>".'$model->'.$column->name.",\n";
            echo "\t\t\t'editable'=>array(\n";
            echo "\t\t\t\t'type'=>'select',\n";
            echo "\t\t\t\t'source'=>".'VEnum::getEnumOptions($model, "'.$column->name.'")'.",\n";            
            echo "\t\t\t),\n";
            echo "\t\t),\n";
        }else{
            echo "\t\t'".$column->name."',\n";
        }	
?>
	),
)); ?>
