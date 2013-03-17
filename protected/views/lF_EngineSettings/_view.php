<?php
/* @var $this LF_EngineSettingsController */
/* @var $data LF_EngineSettings */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('users')); ?>:</b>
	<?php echo CHtml::encode($data->users); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('numOfCombs')); ?>:</b>
	<?php echo CHtml::encode($data->numOfCombs); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('amountPerGroup')); ?>:</b>
	<?php echo CHtml::encode($data->amountPerGroup); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ruleOrder')); ?>:</b>
	<?php echo CHtml::encode($data->ruleOrder); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ranges1a1')); ?>:</b>
	<?php echo CHtml::encode($data->ranges1a1); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('group2_2')); ?>:</b>
	<?php echo CHtml::encode($data->group2_2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('permitted1a8')); ?>:</b>
	<?php echo CHtml::encode($data->permitted1a8); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rule_2_2_2_limit')); ?>:</b>
	<?php echo CHtml::encode($data->rule_2_2_2_limit); ?>
	<br />

	*/ ?>

</div>