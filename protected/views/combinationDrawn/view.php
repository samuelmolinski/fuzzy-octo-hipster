<?php
/* @var $this CombinationDrawnController */
/* @var $model CombinationDrawn */

$this->breadcrumbs=array(
	'Combination Drawns'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CombinationDrawn', 'url'=>array('index')),
	array('label'=>'Create CombinationDrawn', 'url'=>array('create')),
	array('label'=>'Update CombinationDrawn', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CombinationDrawn', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CombinationDrawn', 'url'=>array('admin')),
);
?>

<h1>View CombinationDrawn #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'combination',
		'date',
	),
)); ?>
