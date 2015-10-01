<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php echo "<?php \$form=\$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'".$this->class2id($this->modelClass)."-form',
	'enableAjaxValidation'=>true,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>\n"; ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo "<?php echo \$form->errorSummary(\$model); ?>\n"; ?>

<?php
foreach($this->tableSchema->columns as $column)
{
	if($column->autoIncrement)
		continue;
?>	
        <?php         
        if($column->isForeignKey){
            echo '<?php echo $form->dropDownListRow($model, "'.$column->name.'", '.$this->getForeignKeyClass($column->name).'::model()->getOptions(), array("prompt"=>"Please Select", "class"=>"autocomplete"))'."; ?>\n";
        }elseif($column->size == '257'){
            echo '<?php echo $form->fileFieldRow($model, "'.$column->name.'")'."; ?>\n";
            echo "<div class=\"form-horizontal\">\n";
            echo "<?php \n";
            echo '$image = ($model->image)?$model->image:"noimage.gif"'.";\n";
            echo 'echo CHtml::image(Yii::app()->baseUrl."/images/'.$this->class2id($this->modelClass).'/".$image, $model->id, array("width"=>"100","height"=>"100"));'."\n";
            echo "?> \n";
            echo "</div> \n";            
        }elseif($column->dbType == 'date'){
            echo '<?php echo $form->datepickerRow($model, "'.$column->name.'", array("prepend" => "<i class=\'icon-calendar\'></i>", "options" => array("format" => "yyyy-mm-dd")))'."; ?>\n";            
        }elseif(substr ($column->dbType, 0, 4) == 'enum'){
            echo '<?php echo $form->dropDownListRow($model, "'.$column->name.'", '.'VEnum::getEnumOptions($model, "'.$column->name.'")'.', array("prompt"=>"Please Select", "class"=>"autocomplete"))'."; ?>\n";
        }else{
            echo "<?php echo ".$this->generateActiveRow($this->modelClass,$column)."; ?>\n";            
        }
        ?>

<?php
}
?>
	<div class="form-actions">
		<?php echo "<?php \$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>\$model->isNewRecord ? 'Create' : 'Save',
		)); ?>\n"; ?>
	</div>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>
