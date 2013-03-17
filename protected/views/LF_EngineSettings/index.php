<?php
/* @var $this LF_EngineSettingsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Lf  Engine Settings',
);

$this->menu=array(
	array('label'=>'Create LF_EngineSettings', 'url'=>array('create')),
	array('label'=>'Manage LF_EngineSettings', 'url'=>array('admin')),
);
?>

<h1>Lf  Engine Settings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
