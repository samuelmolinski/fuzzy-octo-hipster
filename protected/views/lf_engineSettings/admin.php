<?php
/* @var $this LF_EngineSettingsController */
/* @var $model LF_EngineSettings */

$this->breadcrumbs=array(
	'Lf  Engine Settings'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List LF_EngineSettings', 'url'=>array('index')),
	array('label'=>'Create LF_EngineSettings', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('lf--engine-settings-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Lf  Engine Settings</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'lf--engine-settings-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'users',
		'numOfCombs',
		'amountPerGroup',
		'ruleOrder',
		/*
		'ranges1a1',
		'group2_2',
		'permitted1a8',
		'rule_2_2_2_limit',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
