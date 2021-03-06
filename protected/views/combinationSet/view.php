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
<div class="row" style="margin-left:0;">
	<a onclick="$('#dialog').dialog('open'); return false;" >Email</a>
</div>

<div id="dialog" title="Send Emails:">
    <p>Select the users to be added to be emailed and drag their names into the green box.  To remove them from recieving the email, drag them to the redbox.</p>
	<div id="emailsort">	
		<ul id="toEmail" class="connectedSortable">
		</ul>
		 
		<ul id="notToEmail" class="connectedSortable">
			<?php 
				foreach ($users as $k => $u) {
					echo "<li class='ui-state-default'><span class='name'>{$u->name}</span><br/><span class='email'>{$u->email}</span></li>";
				}
			?>
		</ul>
	</div>
	<form id="sendEmails" method='post' action='<?php echo Yii::app()->params["root"]."index.php/combinationSet/email/"; ?>'>
		<input type="hidden" name="cs_id" id='cs_id' value="<?php echo $model->id ?>">
	</form>
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
	
	echo "<h3 style=\"clear:both\">Group Totals</h3>\n\r";
	echo "<ul>";
	for ($i=0; $i < count($sorted[0]); $i++) { 
		$gn = $i +1;
		echo "<li>Group $gn - {$sorted[0][$i]}".
			($sorted[1][$i]['321']? " (321) ".$sorted[1][$i]['321']: "").
			" ".($sorted[1][$i]['3111']? " (3111) ".$sorted[1][$i]['3111']: "").
			" ".($sorted[1][$i]['222_111111']? " (222/111111) ".$sorted[1][$i]['222_111111']: "").
			"</li>";
	}
	echo "</ul>";

	$nTotal = array();
	foreach ($cl->list as $k => $c_string) {
		$c = new CombinationStatistics($c_string);
		foreach ($c->d as $k => $N) {
			if(isset($nTotal[$N->n])) {
				$nTotal[$N->n]++;
			} else {
				$nTotal[$N->n] = 1;
			}
		}
	}
	ksort($nTotal);
	//d($c);
	echo "<div class='' style=\"clear:both\">";
	foreach ($nTotal as $k => $vez) {
		echo "<span> $k [$vez],</span>";
	}
	echo "</div>"
?>