<?php
/* @var $this EngineSettingsController */
/* @var $model EngineSettings */

$this->breadcrumbs=array(
	'Engine Settings'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List EngineSettings', 'url'=>array('index')),
	array('label'=>'Create EngineSettings', 'url'=>array('create')),
	array('label'=>'View EngineSettings', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage EngineSettings', 'url'=>array('admin')),
);
?>

<h1>Update EngineSettings <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>