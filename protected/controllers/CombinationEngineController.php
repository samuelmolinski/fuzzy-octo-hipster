<?php

class CombinationEngineController extends Controller
{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index'),
				//'users'=>array('@'),
				'roles'=>array('admin','authenticated'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('run'),
				//'users'=>array('admin'),
				'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
				//'roles'=>array('*'),
			),
		);
	}

	public function actionIndex()
	{	//get current setting
		$engineSettingId = SystemOptions::model()->findByAttributes(array('name'=>'engineSettingId'));
		//need to get the setting options
		$settings = new EngineSettings;
		$settings = EngineSettings::model()->findAll();

		$premade = array();
		foreach ($settings as $k => $a) {
			$premade[$a->id] = $a->name;
		}

		$this->render('index', array('settings'=>$settings, 'engineSettingId'=>$engineSettingId, 'premade'=>$premade));
	}

	public function actionCheck($id)
	{			
		$this->render(array('combinationSet/view', $id));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionRun()
	{	
		//d($_POST);
		$engineSettingId = SystemOptions::model()->findByAttributes(array('name'=>'engineSettingId'));
		if(isset($_POST)&&!empty($_POST['engineRun'])){
			$engineRun = $_POST['engineRun'];
			d($engineRun);
			// do a save if desired
			if(@$engineRun['save']){

			}
			if(@$engineRun['settingId']){
				$engineSettings = EngineSettings::model()->findByAttributes(array('id'=>$engineRun['settingId']));
			} else {
				$engineSettings = EngineSettings::model()->findByAttributes(array('id'=>$engineSettingId->value));
			}
			if(@$engineRun['numOfCombs']){
				$numOfCombinations = $engineRun['numOfCombs'];
			} else {
				$numOfCombinations = $engineSettings->numOfCombs;
			}
			if(@$engineRun['amountPerGroup']){

			} else {
				
			}
			if(@$engineRun['ruleOrder']){
				$tests = unserialize($engineSettings->ruleOrder);
			} else {
				$tests = unserialize($engineSettings->ruleOrder);
			}
		} else {			
			$engineSettings = EngineSettings::model()->findByAttributes(array('id'=>$engineSettingId->value));

	    	// The order of the test to be used
			$numOfCombinations = $engineSettings->numOfCombs;
			$tests = unserialize($engineSettings->ruleOrder);
		}
		
		set_time_limit(0);
		$p = new Performance();
    	$winningNumbers = array();

    	$dc = CombinationDrawn::model()->findAll();
    	$CL = new CombinationList;
    	foreach ($dc as $k => $c) {
    		$CL->addString($c->combination);
    	}
    	$cgSettings = array('winningCombinations'=>$CL, 'ranges1a1'=> unserialize($engineSettings->ranges1a1), 'permitted1a8'=> unserialize($engineSettings->permitted1a8), 'group2_2'=> unserialize($engineSettings->group2_2), 'rule_2_2_2_limit'=>$engineSettings->rule_2_2_2_limit);
    	
    	$cg = new CombinationGenerator($cgSettings);
		$numberOfWinningCombinations = count($cg->wCombs);

		//starting the process
		$p->start_timer("Over All");
		$fail = 0;
		$count = 0;
		$comb = array();
		do {
			do {
				$list = array();
				for ($i=0; $i < 6; $i++) { 
					$comb[$i] = $cg->genUniqueRand($list);
					$list[] = $comb[$i]->n;
				}
				$c = new CombinationStatistics($comb);
			} while (in_array($c, $cg->currentBettingCombinations));
			$count++;
			foreach ($tests as $j => $test) {
				$currentFunction = $test[0];
				if(2 < count($test)) {
					//echo "<li>requires \$list</li>";
					$r = $cg->$currentFunction($c, $cg->wCombs);
					if(!$r) {
						$fail++;
						continue 2;
					}
				} else {
					$r = $cg->$currentFunction($c);
					
					if(!$r) {
						$fail++;
						continue 2;
					}
				}
			}
			// if all is well we add it 
			$cg->currentBettingCombinations[] = $c;
		} while ($numOfCombinations > count($cg->currentBettingCombinations));
		$p->end_timer("Over All");
		$p->sortByTotalTime();
		sort($cg->currentBettingCombinations);

		$list = new CombinationList($cg->currentBettingCombinations);		
		$model = new CombinationSet;
		$model->combinations = serialize($list);
		if($model->save()) {
			$render =array(
				"numOfCombinations"=>$numOfCombinations,
				"numberOfWinningCombinations"=>$numberOfWinningCombinations,
				"cg"=>$cg,
				"totalTested"=>$count,
				"performance"=>$p,
				"tests"=>$tests,
				'saved'=>true
			);
		} else {
			$render =array(
				"numOfCombinations"=>$numOfCombinations,
				"numberOfWinningCombinations"=>$numberOfWinningCombinations,
				"cg"=>$cg,
				"totalTested"=>$count,
				"performance"=>$p,
				"tests"=>$tests,
				'saved'=>false
			);
		}

		$this->render('run',$render);
	}
}