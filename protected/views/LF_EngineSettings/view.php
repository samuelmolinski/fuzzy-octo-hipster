<?php
/* @var $this LF_EngineSettingsController */
/* @var $model LF_EngineSettings */

$this->breadcrumbs=array(
	'Lf  Engine Settings'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List LF_EngineSettings', 'url'=>array('index')),
	array('label'=>'Create LF_EngineSettings', 'url'=>array('create')),
	array('label'=>'Update LF_EngineSettings', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete LF_EngineSettings', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LF_EngineSettings', 'url'=>array('admin')),
);
?>

<h1>View LF_EngineSettings #<?php echo $model->id; ?></h1>

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
		'rule_2_2_2_limit',
	),
)); ?>
