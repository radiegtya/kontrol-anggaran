<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php
echo "<?php\n";
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label'=>array('index'),
	'Create',
);\n";
?>

$this->menu=array(
	array('label'=>'List <?php echo $this->modelClass; ?>','url'=>array('index')),
	array('label'=>'Manage <?php echo $this->modelClass; ?>','url'=>array('admin')),
);
?>

<h2>Create <?php echo $this->modelClass; ?></h2>

<?php echo "<?php echo \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>
