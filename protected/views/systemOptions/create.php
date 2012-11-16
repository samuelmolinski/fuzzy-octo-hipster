<?php
/* @var $this SystemOptionsController */
/* @var $model SystemOptions */

$this->breadcrumbs=array(
	'System Options'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SystemOptions', 'url'=>array('index')),
	array('label'=>'Manage SystemOptions', 'url'=>array('admin')),
);
?>

<h1>Create SystemOptions</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>