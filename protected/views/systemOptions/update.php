<?php
/* @var $this SystemOptionsController */
/* @var $model SystemOptions */

$this->breadcrumbs=array(
	'System Options'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SystemOptions', 'url'=>array('index')),
	array('label'=>'Create SystemOptions', 'url'=>array('create')),
	array('label'=>'View SystemOptions', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SystemOptions', 'url'=>array('admin')),
);
?>

<h1>Update SystemOptions <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>