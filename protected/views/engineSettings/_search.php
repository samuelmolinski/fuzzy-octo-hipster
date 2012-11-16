<?php
/* @var $this EngineSettingsController */
/* @var $model EngineSettings */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textArea($model,'name',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'users'); ?>
		<?php echo $form->textArea($model,'users',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'numOfCombs'); ?>
		<?php echo $form->textField($model,'numOfCombs'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'amountPerGroup'); ?>
		<?php echo $form->textField($model,'amountPerGroup'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ruleOrder'); ?>
		<?php echo $form->textArea($model,'ruleOrder',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ranges1a1'); ?>
		<?php echo $form->textArea($model,'ranges1a1',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'group2_2'); ?>
		<?php echo $form->textArea($model,'group2_2',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'permitted1a8'); ?>
		<?php echo $form->textArea($model,'permitted1a8',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->