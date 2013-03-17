<?php
/* @var $this LF_EngineSettingsController */
/* @var $model LF_EngineSettings */

$this->breadcrumbs=array(
	'Lf  Engine Settings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LF_EngineSettings', 'url'=>array('index')),
	array('label'=>'Manage LF_EngineSettings', 'url'=>array('admin')),
);
?>

<h1>Create LF_EngineSettings</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>