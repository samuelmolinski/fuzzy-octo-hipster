<?php
/* @var $this CombinationEngineController */

$this->breadcrumbs=array(
	'Combination Engine',
);
?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<?php echo CHtml::beginForm(array('combinationEngine/run'), 'post', array(
    'id'=>'engineRun-form',
    //'enableAjaxValidation'=>true,
    //'enableClientValidation'=>true,
    //'focus'=>array($model,'firstName'),
)); ?>

<?php //echo $form->errorSummary($model); ?>

<div class="row" style="margin-left:0;">
    <?php echo CHtml::dropDownList('settingId', $engineSettingId, $premade, array ( )); ?>
</div>
<div class="row" style="margin-left:0;">
	<?php echo CHtml::submitButton('Save', array('id'=>'savesettings')); ?>
	<?php echo CHtml::submitButton('Run', array()); ?>
</div>

<?php echo CHtml::endForm(); ?>

<p>
	<?php //d($settings); 
		/*[id] => 1
        [name] => default
        [users] => admin
        [numOfCombs] => 1200
        [amountPerGroup] => 120
        [ruleOrder] => a:20:{i:0;a:2:{i:0;s:10:"rule_2_2_2";i:1;s:1:"c";}i:1;a:2:{i:0;s:11:"rule_2_2_1b";i:1;s:1:"c";}i:2;a:2:{i:0;s:11:"rule_2_2_1a";i:1;s:1:"c";}i:3;a:2:{i:0;s:11:"rule_2_2_1c";i:1;s:1:"c";}i:4;a:2:{i:0;s:8:"rule_1a1";i:1;s:1:"c";}i:5;a:3:{i:0;s:9:"rule_2_1a";i:1;s:1:"c";i:2;s:4:"list";}i:6;a:2:{i:0;s:8:"rule_1a2";i:1;s:1:"c";}i:7;a:2:{i:0;s:8:"rule_1a8";i:1;s:1:"c";}i:8;a:2:{i:0;s:8:"rule_1a6";i:1;s:1:"c";}i:9;a:2:{i:0;s:8:"rule_1a5";i:1;s:1:"c";}i:10;a:2:{i:0;s:11:"rule_2_2_1d";i:1;s:1:"c";}i:11;a:2:{i:0;s:8:"rule_1a7";i:1;s:1:"c";}i:12;a:2:{i:0;s:9:"rule_2_1c";i:1;s:1:"c";}i:13;a:2:{i:0;s:11:"rule_2_2_1e";i:1;s:1:"c";}i:14;a:2:{i:0;s:8:"rule_1a3";i:1;s:1:"c";}i:15;a:2:{i:0;s:8:"rule_1a4";i:1;s:1:"c";}i:16;a:3:{i:0;s:8:"rule_1b3";i:1;s:1:"c";i:2;s:4:"list";}i:17;a:2:{i:0;s:9:"rule_2_1b";i:1;s:1:"c";}i:18;a:3:{i:0;s:8:"rule_1b2";i:1;s:1:"c";i:2;s:4:"list";}i:19;a:3:{i:0;s:8:"rule_1b1";i:1;s:1:"c";i:2;s:4:"list";}}
        [ranges1a1] => a:6:{i:0;a:2:{s:3:"min";i:1;s:3:"max";i:30;}i:1;a:2:{s:3:"min";i:2;s:3:"max";i:40;}i:2;a:2:{s:3:"min";i:4;s:3:"max";i:49;}i:3;a:2:{s:3:"min";i:11;s:3:"max";i:55;}i:4;a:2:{s:3:"min";i:18;s:3:"max";i:59;}i:5;a:2:{s:3:"min";i:31;s:3:"max";i:60;}}
        [group2_2] => a:5:{i:0;a:1:{i:0;s:10:"2211-21111";}i:1;a:3:{i:0;s:9:"2211-3111";i:1;s:9:"2211-2211";i:2;s:11:"2211-111111";}i:2;a:2:{i:0;s:11:"21111-21111";i:1;s:10:"3111-21111";}i:3;a:5:{i:0;s:9:"3111-2211";i:1;s:11:"3111-111111";i:2;s:10:"21111-3111";i:3;s:10:"21111-2211";i:4;s:12:"21111-111111";}i:4;a:9:{i:0;s:9:"411-21111";i:1;s:9:"321-21111";i:2;s:9:"222-21111";i:3;s:11:"11111-21111";i:4;s:8:"321-2211";i:5;s:10:"321-111111";i:6;s:9:"3111-3111";i:7;s:8:"2211-321";i:8;s:9:"21111-321";}}
        [permitted1a8] => a:20:{i:0;s:9:"2211-2211";i:1;s:10:"21111-2211";i:2;s:9:"3111-2211";i:3;s:8:"321-2211";i:4;s:10:"3111-21111";i:5;s:9:"321-21111";i:6;s:9:"2211-3111";i:7;s:10:"21111-3111";i:8;s:12:"111111-21111";i:9;s:9:"222-21111";i:10;s:9:"411-21111";i:11;s:9:"3111-3111";i:12;s:10:"2211-21111";i:13;s:11:"2211-111111";i:14;s:11:"21111-21111";i:15;s:12:"21111-111111";i:16;s:10:"321-111111";i:17;s:11:"3111-111111";i:18;s:8:"2211-321";i:19;s:9:"21111-321";}
        [rule_2_2_2_limit] => 0.05*/
	?>
</p>
