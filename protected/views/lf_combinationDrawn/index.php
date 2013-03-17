<?php
/* @var $this LF_CombinationDrawnController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Lf  Combination Drawns',
);

$this->menu=array(
	array('label'=>'Create LF_CombinationDrawn', 'url'=>array('create')),
	array('label'=>'Manage LF_CombinationDrawn', 'url'=>array('admin')),
);
?>

<h1>Lf  Combination Drawns</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
