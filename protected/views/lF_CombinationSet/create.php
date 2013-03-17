<?php
/* @var $this LF_CombinationSetController */
/* @var $model LF_CombinationSet */

$this->breadcrumbs=array(
	'Lf  Combination Sets'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LF_CombinationSet', 'url'=>array('index')),
	array('label'=>'Manage LF_CombinationSet', 'url'=>array('admin')),
);
?>

<h1>Create LF_CombinationSet</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>