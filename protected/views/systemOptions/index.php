<?php
/* @var $this SystemOptionsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'System Options',
);

$this->menu=array(
	array('label'=>'Create SystemOptions', 'url'=>array('create')),
	array('label'=>'Manage SystemOptions', 'url'=>array('admin')),
);
?>

<h1>System Options</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
