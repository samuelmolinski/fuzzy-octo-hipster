<?php
/* @var $this CombinationDrawnController */
/* @var $model CombinationDrawn */

$this->breadcrumbs=array(
	'Combination Drawns'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CombinationDrawn', 'url'=>array('index')),
	array('label'=>'Manage CombinationDrawn', 'url'=>array('admin')),
);
?>

<h1>Create CombinationDrawn</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>