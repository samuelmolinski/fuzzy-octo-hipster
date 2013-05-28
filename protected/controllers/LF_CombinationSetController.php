<?php

class LF_CombinationSetController extends Controller
{
	public function __construct($arg) {
		parent::__construct($arg);
		Yii::app()->params['engine'] = 'Lotofacil';
	}
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view', 'check', 'export'),
				//'users'=>array('*'),
				'roles'=>array('admin','authenticated'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','email'),
				//'users'=>array('@'),
				'roles'=>array('admin'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				//'users'=>array('admin'),
				'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$users = new User;
		$users = User::model()->findAll();

		$model = $this->loadModel($id);
		$tables = '';
		//get test combinations
	    $criteria = new CDbCriteria(array(
	        'order' => 'id DESC',
	        'limit' => 10,
	    ));
		$wc = LF_CombinationDrawn::model()->findAll($criteria);

		$premade = array();
		foreach ($wc as $k => $a) {
			$c = new LF_Combination($a->combination);
			$premade[$a->id] = $a->date.' : '.$c->print_id();
		}

		//$perGroup = $engineSettings->amountPerGroup;

		$combs = unserialize($model->combinations);
		//d($combs);
		$CL = new CombinationList($combs);
		$CL->classType = 'LF_Combination';
		$testedCombination = '';

		if(isset($_POST)&&!empty($_POST['combinationCheck'])){
			$cc = $_POST['combinationCheck'];
			//d($cc);
			/*$criteria = new CDbCriteria(array(
				'condition' => 'id = :id',
				'params' => array(':id'=>$cc['settingId']),
		        //'order' => 'id DESC',
		        //'limit' => 1,
		    ));*/
			$wcc = LF_CombinationDrawn::model()->findByPk($cc['settingId']);
			$testedCombination = $cc['settingId'];
			$wcc = new LF_Combination($wcc->combination);
			$tables = $CL->printListTable($wcc);
		} else {
			$tables = $CL->printListTable();
		}
		
		$this->render('view', array('model'=>$this->loadModel($id), 'wc'=>$wc, 'premade'=>$premade, 'tables'=>$tables['table'], 'results'=>$tables['results'], 'testedCombination'=>$testedCombination, 'users'=>$users));
	}
	/**
	 * Export a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionExport($id)
	{
		$model=$this->loadModel($id);
		$d = date("Y-m-d-Hi");
		//d($model);
		$CL = unserialize($model->combinations);
		//d($CL);

		header('Content-Type: text/plain');
		header("Content-Disposition: attachment;filename=Lotofacil_Combinations_$d.txt");
		header('Cache-Control: max-age=0');
		foreach ($CL->list as $k => $c) {
			$C = new LF_Combination($c);
			for ($i=0; $i < count($C->d); $i++) { 
				echo $C->d[$i]->n;
				if(count($C->d)-1 == $i){
					echo "\r\n";
				} else {
					echo " ";
				}
			}
		}
		Yii::app()->end();
	}

	public function actionEmail()
	{
		
		print_r($_POST);
		if(isset($_POST['cs_id'])&&isset($_POST['email'])){
			print_r('\n Inside: ');
			$emails = $_POST['email'];
			$id = $_POST['cs_id'];

			//divide combinations
			$tables = array();
			$model = $this->loadModel($id);
			$CL = unserialize($model->combinations);
			$combs = $CL->toCombinations();
			$results =  array();
			$totalCombs = count($combs);
			$count = 0;

			$perGroup = ceil($totalCombs/count($emails));

			$ttemp = '<table class="table table-striped CombinationsSet"><tbody>';
	    	
			foreach ($combs as $k => $c) {
				$count++;					
				if((0 == ($count-1)%$perGroup)&&(0 != $count-1)){
					$tables[] =  $ttemp.'</tbody></table>';
					$ttemp = '<table class="table table-striped CombinationsSet"><tbody>';					
				}
				$ttemp .= "<tr><td>$count</td><td>".$c->print_id()."</td></tr>";
			}

			$ttemp .= '</tbody></table>';
			$tables[] = $ttemp;

			//d($tables);
			foreach ($emails as $k => $email) {
				$to      = $email;
				$subject = 'MegaSena';
				$message = $tables[$k];
				$headers = 'From: no-reply@Nissenidea.com' . "\r\n" .
				    'Reply-To: no-reply@Nissenidea.com' . "\r\n" .
				    'X-Mailer: PHP/' . phpversion();

				mail($to, $subject, $message, $headers);
			}
			$to      = 'sjmolinski@gmail.com';
			$subject = 'MegaSena';
			$message = 'hello';
			$headers = 'From: no-reply@Nissenidea.com' . "\r\n" .
			    'Reply-To: no-reply@Nissenidea.com' . "\r\n";

			mail($to, $subject, $message, $headers);
			print_r('\n Sent: ');

			phpinfo();

		}
		
		/*$model=$this->loadModel($id);
		$d = date("Y-m-d-Hi");
		//d($model);
		$CL = unserialize($model->combinations);
		//d($CL);

		header('Content-Type: text/plain');
		header("Content-Disposition: attachment;filename='Megasena_Combinations_$d.txt'");
		header('Cache-Control: max-age=0');
		foreach ($CL->list as $k => $c) {
			$C = new Combination($c);
			for ($i=0; $i < 6; $i++) { 
				echo $C->d[$i]->n;
				if(5 == $i){
					echo "\r\n";
				} else {
					echo "\t";
				}
			}
		}*/
		Yii::app()->end();
	}
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new LF_CombinationSet;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CombinationSet']))
		{
			$model->attributes=$_POST['CombinationSet'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CombinationSet']))
		{
			$model->attributes=$_POST['CombinationSet'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('CombinationSet');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new LF_CombinationSet('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CombinationSet']))
			$model->attributes=$_GET['CombinationSet'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return CombinationSet the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=LF_CombinationSet::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CombinationSet $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='combination-set-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
