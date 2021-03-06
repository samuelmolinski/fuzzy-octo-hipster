<?php

class LF_CombinationDrawnController extends Controller
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
				'actions'=>array('index','view','seed'),
				'roles'=>array('admin','authenticated'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'roles'=>array('admin',),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'roles'=>array('admin','authenticated'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionSeed()
	{
		set_time_limit(0);

		$path = yii::app()->params['root'].'combination/D_LOTFAC.HTM';
		//d($path);

		$winningNumbers = Seed_LF::get_wC_raw($path);
		//d($winningNumbers);

		$modeltemp = new LF_CombinationDrawn;
		foreach ($winningNumbers as $k => $wc) {
			$model = new LF_CombinationDrawn;
			//echo Yii::trace(CVarDumper::dumpAsString($model),'LF_CombinationDrawn');

			$model->attributes = $wc;
			$criteria=new CDbCriteria;
			$criteria->select='*';  // only select the 'title' column
			$criteria->condition='combination=:combination AND date=:date';
			$criteria->params=array(':combination'=>$wc['combination'], ':date'=>$wc['date']);
			$modeltemp=LF_CombinationDrawn::model()->find($criteria); // $params is not needed

			if(null == $modeltemp) {
				//d('Saving');
				/*$model->save();*/	
				if($model->save()){
					d('Saved');
				} else {
					d($model->getErrors());
				}			
			}
			
		}

		$this->render('seed',array('totalCombinations'=>count($winningNumbers),
		));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new LF_CombinationDrawn;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['LF_CombinationDrawn']))
		{
			$model->attributes=$_POST['LF_CombinationDrawn'];
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

		if(isset($_POST['LF_CombinationDrawn']))
		{
			$model->attributes=$_POST['LF_CombinationDrawn'];
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
		$dataProvider=new CActiveDataProvider('LF_CombinationDrawn');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new LF_CombinationDrawn('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['LF_CombinationDrawn']))
			$model->attributes=$_GET['LF_CombinationDrawn'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return LF_CombinationDrawn the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=LF_CombinationDrawn::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param LF_CombinationDrawn $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='combination-drawn-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
