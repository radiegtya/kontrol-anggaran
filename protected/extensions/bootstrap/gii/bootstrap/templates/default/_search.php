<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php echo "<?php \$form=\$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl(\$this->route),
	'method'=>'get',
)); ?>\n"; ?>

<?php foreach ($this->tableSchema->columns as $column): ?>
    <?php
    $field = $this->generateInputField($this->modelClass, $column);
    if (strpos($field, 'password') !== false)
        continue;
    ?>
    <?php
    if ($column->isForeignKey) {
        echo '<?php echo $form->dropDownListRow($model, "' . $column->name . '", ' . $this->getForeignKeyClass($column->name) . '::model()->getOptions(), array("prompt"=>"Please Select", "class"=>"autocomplete"))' . "; ?>\n";
    } elseif ($column->dbType == 'date') {
        echo '<?php echo $form->datepickerRow($model, "' . $column->name . '", array("prepend" => "<i class=\'icon-calendar\'></i>", "options" => array("format" => "yyyy-mm-dd")))' . "; ?>\n";
    } elseif (substr($column->dbType, 0, 4) == 'enum') {
        echo '<?php echo $form->dropDownListRow($model, "' . $column->name . '", ' . 'VEnum::getEnumOptions($model, "' . $column->name . '")' . ', array("prompt"=>"Please Select", "class"=>"autocomplete"))' . "; ?>\n";
    } else {
        echo "<?php echo " . $this->generateActiveRow($this->modelClass, $column) . "; ?>\n";
    }
    ?>

<?php endforeach; ?>
<div class="form-actions">
    <?php echo "<?php \$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>\n"; ?>
</div>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>