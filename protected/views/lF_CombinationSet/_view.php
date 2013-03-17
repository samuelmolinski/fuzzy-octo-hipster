<?php
/* @var $this LF_CombinationSetController */
/* @var $data LF_CombinationSet */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($data->create_time); ?>
	<br />

	<!-- <b><?php echo CHtml::encode($data->getAttributeLabel('combinations')); ?>:</b>
	<?php echo CHtml::encode($data->combinations); ?>
	<br /> -->


</div>