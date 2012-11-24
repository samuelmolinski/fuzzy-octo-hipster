<?php
/* @var $this CombinationDrawnController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Combination Drawns',
);

$this->menu=array(
	array('label'=>'Create CombinationDrawn', 'url'=>array('create')),
	array('label'=>'Manage CombinationDrawn', 'url'=>array('admin')),
);
?>

<h1>Combination Drawns</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
