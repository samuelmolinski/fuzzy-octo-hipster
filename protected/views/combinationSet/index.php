<?php
/* @var $this CombinationSetController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Combination Sets',
);

$this->menu=array(
	array('label'=>'Create CombinationSet', 'url'=>array('create')),
	array('label'=>'Manage CombinationSet', 'url'=>array('admin')),
);
?>

<h1>Combination Sets</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
