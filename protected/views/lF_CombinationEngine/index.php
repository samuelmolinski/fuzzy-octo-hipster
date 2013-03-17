<?php
/* @var $this CombinationEngineController */

$this->breadcrumbs=array(
	'Lotofacil Combination Engine',
);
?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<?php echo CHtml::beginForm(array('lF_CombinationEngine/run'), 'post', array(
    'id'=>'engineRun-form',
)); ?>

<div class="row" style="margin-left:0;">
    <?php echo CHtml::label('Number of Combinations Override', 'engineRun[numOfCombs]', array()); ?>
    <?php echo CHtml::textField('engineRun[numOfCombs]', '', array ()); ?>
</div>

<div class="row" style="margin-left:0;">
	<!--<?php echo CHtml::submitButton('Save', array('id'=>'savesettings')); ?>-->
	<?php echo CHtml::submitButton('Run', array()); ?>
</div>

<?php echo CHtml::endForm(); ?>

<?php echo Yii::app()->params['engine']; ?>