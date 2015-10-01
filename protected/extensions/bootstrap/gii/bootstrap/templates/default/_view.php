<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<div class="view">

    <?php
    echo "\t<b><?php echo CHtml::encode(\$data->getAttributeLabel('{$this->tableSchema->primaryKey}')); ?>:</b>\n";
    echo "\t<?php echo CHtml::link(CHtml::encode(\$data->{$this->tableSchema->primaryKey}),array('view','id'=>\$data->{$this->tableSchema->primaryKey})); ?>\n\t<br />\n\n";
    $count = 0;
    foreach ($this->tableSchema->columns as $column) {
        if ($column->isPrimaryKey)
            continue;
        if (++$count == 7)
            echo "\t<?php /*\n";
        echo "\t<b><?php echo CHtml::encode(\$data->getAttributeLabel('{$column->name}')); ?>:</b>\n";

        if ($column->isForeignKey) {
            echo "\t<?php echo CHtml::encode(\$data->" . $this->getForeignKeyColumn($column->name) . "->name); ?>\n\t<br />\n\n";
        } elseif ($column->size == '257') {
            echo "<?php \n";
            echo '$image = ($data->image)?$data->image:"noimage.gif"'.";\n";
            echo 'echo CHtml::image(Yii::app()->baseUrl."/images/'.$this->class2id($this->modelClass).'/".$image, $data->id, array("width"=>"100","height"=>"100"));'."\n";
            echo "?> \n";
        } else {
            echo "\t<?php echo CHtml::encode(\$data->{$column->name}); ?>\n\t<br />\n\n";
        }
    }
    if ($count >= 7)
        echo "\t*/ ?>\n";
    ?>

</div>