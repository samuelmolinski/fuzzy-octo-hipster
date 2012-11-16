<?php
/* @var $this SystemOptionsController */
/* @var $model SystemOptions */

$this->breadcrumbs=array(
	'System Options'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List SystemOptions', 'url'=>array('index')),
	array('label'=>'Create SystemOptions', 'url'=>array('create')),
	array('label'=>'Update SystemOptions', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SystemOptions', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SystemOptions', 'url'=>array('admin')),
);
?>

<h1>View SystemOptions #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'value',
		'autoload',
	),
)); ?>
