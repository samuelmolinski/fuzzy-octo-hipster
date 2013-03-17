<?php
/* @var $this LF_CombinationSetController */
/* @var $model LF_CombinationSet */

$this->breadcrumbs=array(
	'Lf  Combination Sets'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LF_CombinationSet', 'url'=>array('index')),
	array('label'=>'Create LF_CombinationSet', 'url'=>array('create')),
	array('label'=>'View LF_CombinationSet', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage LF_CombinationSet', 'url'=>array('admin')),
);
?>

<h1>Update LF_CombinationSet <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>