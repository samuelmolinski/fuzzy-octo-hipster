<?php
/* @var $this EngineSettingsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Engine Settings',
);

$this->menu=array(
	array('label'=>'Create EngineSettings', 'url'=>array('create')),
	array('label'=>'Manage EngineSettings', 'url'=>array('admin')),
);
?>

<h1>Engine Settings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
