<?php
/* @var $this LF_EngineSettingsController */
/* @var $model LF_EngineSettings */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'lf--engine-settings-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textArea($model,'name',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'users'); ?>
		<?php echo $form->textArea($model,'users',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'users'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'numOfCombs'); ?>
		<?php echo $form->textField($model,'numOfCombs'); ?>
		<?php echo $form->error($model,'numOfCombs'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'amountPerGroup'); ?>
		<?php echo $form->textField($model,'amountPerGroup'); ?>
		<?php echo $form->error($model,'amountPerGroup'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ruleOrder'); ?>
		<?php echo $form->textArea($model,'ruleOrder',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'ruleOrder'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ranges1a1'); ?>
		<?php echo $form->textArea($model,'ranges1a1',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'ranges1a1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'group2_2'); ?>
		<?php echo $form->textArea($model,'group2_2',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'group2_2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'permitted1a8'); ?>
		<?php echo $form->textArea($model,'permitted1a8',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'permitted1a8'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rule_2_2_2_limit'); ?>
		<?php echo $form->textField($model,'rule_2_2_2_limit'); ?>
		<?php echo $form->error($model,'rule_2_2_2_limit'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->