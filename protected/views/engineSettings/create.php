<?php
/* @var $this EngineSettingsController */
/* @var $model EngineSettings */

$this->breadcrumbs=array(
	'Engine Settings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List EngineSettings', 'url'=>array('index')),
	array('label'=>'Manage EngineSettings', 'url'=>array('admin')),
);
?>

<h1>Create EngineSettings</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>