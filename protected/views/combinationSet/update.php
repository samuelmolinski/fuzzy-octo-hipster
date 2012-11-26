<?php
/* @var $this CombinationSetController */
/* @var $model CombinationSet */

$this->breadcrumbs=array(
	'Combination Sets'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CombinationSet', 'url'=>array('index')),
	array('label'=>'Create CombinationSet', 'url'=>array('create')),
	array('label'=>'View CombinationSet', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CombinationSet', 'url'=>array('admin')),
);
?>

<h1>Update CombinationSet <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>