<?php
/* @var $this CombinationDrawnController */
/* @var $model CombinationDrawn */

$this->breadcrumbs=array(
	'Combination Drawns'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CombinationDrawn', 'url'=>array('index')),
	array('label'=>'Create CombinationDrawn', 'url'=>array('create')),
	array('label'=>'View CombinationDrawn', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CombinationDrawn', 'url'=>array('admin')),
);
?>

<h1>Update CombinationDrawn <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>