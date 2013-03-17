<?php
/* @var $this LF_CombinationDrawnController */
/* @var $model LF_CombinationDrawn */

$this->breadcrumbs=array(
	'Lf  Combination Drawns'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List LF_CombinationDrawn', 'url'=>array('index')),
	array('label'=>'Create LF_CombinationDrawn', 'url'=>array('create')),
	array('label'=>'Update LF_CombinationDrawn', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete LF_CombinationDrawn', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LF_CombinationDrawn', 'url'=>array('admin')),
);
?>

<h1>View LF_CombinationDrawn #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'combination',
		'date',
		'group',
	),
)); ?>
