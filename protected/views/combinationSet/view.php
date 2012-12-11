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
    <?php echo CHtml::dropDownList('combinationCheck[settingId]', $testedCombination, $premade, array ( )); ?>
</div>
<div class="row" style="margin-left:0;">
	<?php echo CHtml::submitButton('Check', array('name'=>'combinationCheck[submit]', 'id'=>'combinationCheck_submit')); ?>
</div>

<?php echo CHtml::endForm(); ?>

<div class="row" style="margin-left:0;">
	<?php echo CHtml::link('Export', array('CombinationSet/Export', 'id'=>$model->id)); ?>
</div>

<?php 
	if(@$results[6]){ ?>
		<div class="row" style="margin-left:0;">
			<h3>Winning Tickets (matching 6N)</h3>
			<?php echo "<p>".count($results[6])." Combinations with 6N</p>"; ?>
			<?php foreach ($results[6] as $k => $str) {
				echo $str.' ';
			} ?>
		</div>
	<?php }
	if(@$results[5]){ ?>
		<div class="row" style="margin-left:0;">
			<h3>Matching 5N</h3>
			<?php echo "<p>".count($results[5])." Combinations with 5N</p>"; ?>
			<?php foreach ($results[5] as $k => $str) {
				echo $str.' ';
			} ?>
		</div>
	<?php }
	if(@$results[4]){ ?>
		<div class="row" style="margin-left:0;">
			<h3>Matching 4N</h3>
			<?php echo "<p>".count($results[4])." Combinations with 4N</p>"; ?>
			<?php foreach ($results[4] as $k => $str) {
				echo $str.' ';
			} ?>
		</div>
	<?php }
	if(@$results[3]){ ?>
		<div class="row" style="margin-left:0;">
			<h3>Matching 3N</h3>
			<?php echo "<p>".count($results[3])." Combinations with 3N</p>"; ?>
			<?php foreach ($results[3] as $k => $str) {
				echo $str.' ';
			} ?>
		</div>
	<?php }
	if(@$results[2]){ ?>
		<div class="row" style="margin-left:0;">
			<h3>Matching 2N</h3>
			<?php echo "<p>".count($results[2])." Combinations with 2N</p>"; ?>
			<?php foreach ($results[2] as $k => $str) {
				echo $str.' ';
			} ?>
		</div>
	<?php }
	if(@$results[1]){ ?>
		<div class="row" style="margin-left:0;">
			<h3>Matching 1N</h3>
			<?php echo "<p>".count($results[1])." Combinations with 1N</p>"; ?>
		</div>
	<?php }
	if(@$results[0]){ ?>
		<div class="row" style="margin-left:0;">
			<h3>Matching 0N</h3>
			<?php echo "<p>".count($results[0])." Combinations with 0N</p>"; ?>
		</div>
	<?php }
?>
<br />
<?php 
	echo $tables;
?>