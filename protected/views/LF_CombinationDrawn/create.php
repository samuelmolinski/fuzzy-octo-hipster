<?php
/* @var $this LF_CombinationDrawnController */
/* @var $model LF_CombinationDrawn */

$this->breadcrumbs=array(
	'Lf  Combination Drawns'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LF_CombinationDrawn', 'url'=>array('index')),
	array('label'=>'Manage LF_CombinationDrawn', 'url'=>array('admin')),
);
?>

<h1>Create LF_CombinationDrawn</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>