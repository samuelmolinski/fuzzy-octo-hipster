<?php
/* @var $this EngineSettingsController */
/* @var $model EngineSettings */

$this->breadcrumbs=array(
	'Engine Settings'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List EngineSettings', 'url'=>array('index')),
	array('label'=>'Create EngineSettings', 'url'=>array('create')),
	array('label'=>'Update EngineSettings', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete EngineSettings', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EngineSettings', 'url'=>array('admin')),
);
?>

<h1>View EngineSettings #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'users',
		'numOfCombs',
		'amountPerGroup',
		'ruleOrder',
		'ranges1a1',
		'group2_2',
		'permitted1a8',
	),
)); ?>
