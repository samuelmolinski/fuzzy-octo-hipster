<?php
/* @var $this LF_CombinationDrawnController */
/* @var $model LF_CombinationDrawn */

$this->breadcrumbs=array(
	'Lf  Combination Drawns'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LF_CombinationDrawn', 'url'=>array('index')),
	array('label'=>'Create LF_CombinationDrawn', 'url'=>array('create')),
	array('label'=>'View LF_CombinationDrawn', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage LF_CombinationDrawn', 'url'=>array('admin')),
);
?>

<h1>Update LF_CombinationDrawn <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>