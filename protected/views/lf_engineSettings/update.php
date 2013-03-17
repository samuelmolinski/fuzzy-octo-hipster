<?php
/* @var $this LF_EngineSettingsController */
/* @var $model LF_EngineSettings */

$this->breadcrumbs=array(
	'Lf  Engine Settings'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LF_EngineSettings', 'url'=>array('index')),
	array('label'=>'Create LF_EngineSettings', 'url'=>array('create')),
	array('label'=>'View LF_EngineSettings', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage LF_EngineSettings', 'url'=>array('admin')),
);
?>

<h1>Update LF_EngineSettings <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>