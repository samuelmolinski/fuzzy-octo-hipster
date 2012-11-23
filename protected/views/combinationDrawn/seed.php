<?php
/* @var $this CombinationDrawnController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Combination Drawns',
);

$this->menu=array(
	array('label'=>'Create CombinationDrawn', 'url'=>array('create')),
	array('label'=>'Manage CombinationDrawn', 'url'=>array('admin')),
);
?>

<h1>Combination Drawns</h1>

<?php 	
		set_time_limit(0);
		$cache = null;

		$MegaSenaDownloadURL = SystemOptions::model()->findByAttributes(array('name'=>'lotteryDownloadURL'));
		$MegaSenaURL = SystemOptions::model()->findByAttributes(array('name'=>'lotteryResult'));
		//d($MegaSenaURL);
		$url = $MegaSenaURL->value;
		$path = dirname(__FILE__).'/../../../winningCombinations/d_megasc.htm';
		d($path);

		$megaSc = mLoadXml($path);
		$megaSc = $megaSc->body->table->xpath('tr');
		array_shift($megaSc);

		$winningNumbers = array();
		foreach($megaSc as $k=>$combination) {
			$d = array();
			$date = (string)$combination->td[1];
			$s = (string)$combination->td[2];
			$s .= (string)$combination->td[3];
			$s .= (string)$combination->td[4];
			$s .= (string)$combination->td[5];
			$s .= (string)$combination->td[6];
			$s .= (string)$combination->td[7];
			//$c = new CombinationStatistics($d);
			//d($date);
			$winningNumbers[] = array($date, $s);
		}
		//d($winningNumbers);

		d($url);
		$new_ms = mLoadXml($url);
		//$new_ms = $megaSc->body->table->xpath('tr');
		d($new_ms);
 ?>
