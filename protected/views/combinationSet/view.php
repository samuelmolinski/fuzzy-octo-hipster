<?php
/* @var $this CombinationSetController */
/* @var $model CombinationSet */

$this->breadcrumbs=array(
	'Combination Sets'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CombinationSet', 'url'=>array('index')),
	array('label'=>'Create CombinationSet', 'url'=>array('create')),
	array('label'=>'Update CombinationSet', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CombinationSet', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CombinationSet', 'url'=>array('admin')),
);
?>

<h1>View Betting Combination Set : <?php echo date('d/m/Y', strtotime($model->create_time)); ?></h1>

<?php echo CHtml::beginForm(array('combinationSet/'.$model->id), 'post', array(
    'id'=>'combinationCheck-form',
)); ?>

<div class="row" style="margin-left:0;">
    <?php echo CHtml::dropDownList('combinationCheck[settingId]', $engineSettingId, $premade, array ( )); ?>
</div>
<div class="row" style="margin-left:0;">
	<?php echo CHtml::submitButton('Check', array('name'=>'combinationCheck[submit]', 'id'=>'combinationCheck_submit')); ?>
</div>

<?php echo CHtml::endForm(); ?>

<?php 
	echo $tables;
?>