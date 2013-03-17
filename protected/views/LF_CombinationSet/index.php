<?php
/* @var $this LF_CombinationSetController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Lf  Combination Sets',
);

$this->menu=array(
	array('label'=>'Create LF_CombinationSet', 'url'=>array('create')),
	array('label'=>'Manage LF_CombinationSet', 'url'=>array('admin')),
);
?>

<h1>Lf  Combination Sets</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
