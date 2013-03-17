<?php

class LF_CombinationEngineController extends Controller
{
	public function __construct($arg) {
		parent::__construct($arg);
		Yii::app()->params['engine'] = 'Lotofacil';
	}

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
	{	
		//$this->setEngine();
		//get current setting
		/*$engineSettingId = SystemOptions::model()->findByAttributes(array('name'=>'engineSettingId'));
		//need to get the setting options
		$settings = new EngineSettings;
		$settings = EngineSettings::model()->findAll();

		$premade = array();
		foreach ($settings as $k => $a) {
			$premade[$a->id] = $a->name;
		}*/

		//$this->render('index', array('settings'=>$settings, 'engineSettingId'=>$engineSettingId, 'premade'=>$premade));
		$this->render('index');
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

    	$dc = LF_CombinationDrawn::model()->findAll();
    	$CL = new CombinationList();
    	$CL->classType = 'LF_Combination';

    	foreach ($dc as $k => $c) {
    		$CL->addString($c->combination);
    	}

		if(isset($_POST)&&!empty($_POST['engineRun'])){ $engineRun = $_POST['engineRun']; }

		if(@isset($engineRun['numOfCombs'])){
			$numOfCombinations = $engineRun['numOfCombs'];
		} else {
			$numOfCombinations = 100;
		}

		$numberOfWinningCombinations = count($CL->list);

		//starting the process
		$wC = $CL->toCombinations();
		/*foreach ($wC as $_id => $C) {
			if(isset($wC[$_id-1])){
	            $wC[$_id]->cal_Ns_ta($wC[$_id-1]);
	        }
		}*/

		$p = new Performance();
		$p->start_timer("Over All");
		$LF_cg = new LF_CombinationGenerator(array('wC'=>$wC, 'numOfCombinations'=>$numOfCombinations));		
		$p->end_timer("Over All");
		$p->sortByTotalTime();

		sort($LF_cg->currentBettingCombinations);

		//$cl = new CombinationList($LF_cg->currentBettingCombinations);

		$list = new CombinationList($LF_cg->currentBettingCombinations);		
		$model = new LF_CombinationSet;
		$model->combinations = serialize($list);
		d($model->combinations);

		if($model->save()) {
			$render =array(
				"numOfCombinations"=>$numOfCombinations,
				"numberOfWinningCombinations"=>$numberOfWinningCombinations,
				"cg"=>$LF_cg,
				"totalTested"=>$LF_cg->attemptedCombinations,
				"performance"=>$p,
				//sorted"=>$sorted,
				//"tests"=>$tests,
				'saved'=>true
			);
		} else { 
			$render =array(
				"numOfCombinations"=>$numOfCombinations,
				"numberOfWinningCombinations"=>$numberOfWinningCombinations,
				"cg"=>$LF_cg,
				"totalTested"=>$LF_cg->attemptedCombinations,
				"performance"=>$p,
				//"sorted"=>$sorted,
				//"tests"=>$tests,
				'saved'=>false,
				'save_error'=>$model->getErrors()
			);
		}

		$this->render('run',$render);
	}
}

