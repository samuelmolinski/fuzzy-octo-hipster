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

<?php echo CHtml::beginForm(array('lF_CombinationSet/'.$model->id), 'post', array(
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
	<?php echo CHtml::link('Export', array('lF_CombinationSet/Export', 'id'=>$model->id)); ?>
</div>
<!-- <div class="row" style="margin-left:0;">
	<a onclick="$('#dialog').dialog('open'); return false;" >Email</a>
</div> -->

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
	<form id="sendEmails" method='post' action='<?php echo Yii::app()->params["root"]."index.php/LF_CombinationSet/email/"; ?>'>
		<input type="hidden" name="cs_id" id='cs_id' value="<?php echo $model->id ?>">
	</form>
</div>

<?php 
	if(@$results[15]){ ?>
		<div class="row" style="margin-left:0;">
			<h3>Winning Tickets (matching 15)</h3>
			<?php echo "<p>".count($results[15])." Combinations with 15N</p>"; ?>
			<?php foreach ($results[15] as $k => $str) {
				echo $str.' ';
			} ?>
		</div>
	<?php }
	if(@$results[14]){ ?>
		<div class="row" style="margin-left:0;">
			<h3>Matching 14N</h3>
			<?php echo "<p>".count($results[14])." Combinations with 14N</p>"; ?>
			<?php foreach ($results[14] as $k => $str) {
				echo $str.' ';
			} ?>
		</div>
	<?php }
	if(@$results[13]){ ?>
		<div class="row" style="margin-left:0;">
			<h3>Matching 13N</h3>
			<?php echo "<p>".count($results[13])." Combinations with 13N</p>"; ?>
			<?php foreach ($results[13] as $k => $str) {
				echo $str.' ';
			} ?>
		</div>
	<?php }
	if(@$results[12]){ ?>
		<div class="row" style="margin-left:0;">
			<h3>Matching 12N</h3>
			<?php echo "<p>".count($results[12])." Combinations with 12N</p>"; ?>
			<?php foreach ($results[12] as $k => $str) {
				echo $str.' ';
			} ?>
		</div>
	<?php }
	if(@$results[11]){ ?>
		<div class="row" style="margin-left:0;">
			<h3>Matching 11N</h3>
			<?php echo "<p>".count($results[11])." Combinations with 11N</p>"; ?>
			<?php foreach ($results[11] as $k => $str) {
				echo $str.' ';
			} ?>
		</div>
	<?php }
	if(@$results[10]){ ?>
		<div class="row" style="margin-left:0;">
			<h3>Matching 10N</h3>
			<?php echo "<p>".count($results[10])." Combinations with 10N</p>"; ?>
			<?php foreach ($results[10] as $k => $str) {
				echo $str.' ';
			} ?>
		</div>
	<?php }
	if(@$results[9]){ ?>
		<div class="row" style="margin-left:0;">
			<h3>Matching 9N</h3>
			<?php echo "<p>".count($results[9])." Combinations with 9N</p>"; ?>
			<?php foreach ($results[9] as $k => $str) {
				echo $str.' ';
			} ?>
		</div>
	<?php }
	if(@$results[8]){ ?>
		<div class="row" style="margin-left:0;">
			<h3>Matching 8N</h3>
			<?php echo "<p>".count($results[8])." Combinations with 8N</p>"; ?>
			<?php foreach ($results[8] as $k => $str) {
				echo $str.' ';
			} ?>
		</div>
	<?php }
	if(@$results[7]){ ?>
		<div class="row" style="margin-left:0;">
			<h3>Matching 7N</h3>
			<?php echo "<p>".count($results[7])." Combinations with 7N</p>"; ?>
			<?php foreach ($results[7] as $k => $str) {
				echo $str.' ';
			} ?>
		</div>
	<?php }
	if(@$results[6]){ ?>
		<div class="row" style="margin-left:0;">
			<h3>Matching 6N</h3>
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
	//d($sorted);
	/*echo "<h3>Group totals</h3>\n\r";
	echo "<ul>";
	for ($i=0; $i < 5; $i++) { 
		$gn = $i +1;
		echo "<li>Group - $gn{$sorted[$i]}</li>";
	}
	echo "</ul>";*/
	
	echo $tables;

?>