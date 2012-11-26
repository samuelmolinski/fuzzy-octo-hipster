<?php

class CombinationSetController extends Controller
{
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
				'actions'=>array('index','view', 'check'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
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
		$model = $this->loadModel($id);
		$tables = '';
		//get test combinations
	    $criteria = new CDbCriteria(array(
	        'order' => 'id DESC',
	        'limit' => 10,
	    ));
		$wc = CombinationDrawn::model()->findAll($criteria);

		$premade = array();
		foreach ($wc as $k => $a) {
			$c = new CombinationStatistics($a->combination);
			$premade[$a->id] = $a->date.' : '.$c->print_id();
		}

		//get current setting
		$engineSettingId = SystemOptions::model()->findByAttributes(array('name'=>'engineSettingId'));
		$engineSettings = EngineSettings::model()->findByAttributes(array('id'=>$engineSettingId->value));
		$combinationSet = CombinationSet::model()->findByAttributes(array('id'=>$id));
		//$perGroup = $engineSettings->amountPerGroup;
		$perGroup = 30;
		//d($engineSettings);

		if(isset($_POST)&&!empty($_POST['combinationCheck'])){
			$cc = $_POST['combinationCheck'];
			$criteria = new CDbCriteria(array(
				'condition' => 'id = :id',
				'params' => array(':id'=>$cc['settingId']),
		        'order' => 'id DESC',
		        'limit' => 1,
		    ));
			$wcc = CombinationDrawn::model()->findAll($criteria);
			$wcc = new CombinationStatistics($wc[0]->combination);

			//d($model->combinations);
			$combs = unserialize($model->combinations);
			//d($combs);
			$CL = new CombinationList($combs);
			$combs = $CL->toCombinations();
			$totalCombs = count($combs);
			//d($combs);
			$count = 0;
			//echo '<table class="table table-striped"><tbody>';

			foreach ($combs as $k => $c) {
				$count++;
				if(0 == ($count-1)%$perGroup){
					//heading			
					if($totalCombs != $count) {
						$tables .= '<table class="table table-striped CombinationsSet"><tbody>';
					}
					
				}
				$matching = 0;
				foreach ($c->d as $key => $N) {
					if(0 != $key){
						if(in_array($N, $wcc->d)) {
							$matching++;
							$str .= '-<span class="match">'.$N->n.'</span>';
						} else {
							$str .= '-'.$N->n;
						}
					} else {
						if(in_array($N, $wcc->d)) {
							$matching++;
							$str = '<span class="match">'.$N->n.'</span>';
						} else {
							$str = $N->n;
						}
					}
				}
				if($matching){
					$matched = "<td class='matching$matching'>$str</td>";
				} else {
					$matched = "<td>$str</td>";
				}
				$tables .= "<tr><td>$count</td>$matched</tr>";

				if(0 == ($count)%$perGroup){
					//close previous
					if(0 != $count-1) {
						$tables .= '</tbody></table>';
					}					
				}
			}
		} else {			
			$combs = unserialize($model->combinations);
			$CL = new CombinationList($combs);
			$combs = $CL->toCombinations();
			$totalCombs = count($combs);
			$count = 0;

			foreach ($combs as $k => $c) {
				$count++;
				if(0 == ($count-1)%$perGroup){
					//heading			
					if($totalCombs != $count) {
						$tables .= '<table class="table table-striped CombinationsSet"><tbody>';
					}
				}
				$tables .= "<tr><td>$count</td><td>".$c->print_id()."</td></tr>";

				if(0 == ($count)%$perGroup){
					//close previous
					if(0 != $count-1) {
						$tables .= '</tbody></table>';
					}
				}
			}
		}
		
		$this->render('view', array('model'=>$this->loadModel($id),'engineSettings'=>$engineSettings, 'engineSettingId'=>$engineSettingId, 'wc'=>$wc, 'premade'=>$premade, 'tables'=>$tables));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new CombinationSet;

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
		$model=new CombinationSet('search');
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
		$model=CombinationSet::model()->findByPk($id);
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
