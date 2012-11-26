<?php
/* @var $this CombinationSetController */
/* @var $model CombinationSet */

$this->breadcrumbs=array(
	'Combination Sets'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CombinationSet', 'url'=>array('index')),
	array('label'=>'Manage CombinationSet', 'url'=>array('admin')),
);
?>

<h1>Create CombinationSet</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>