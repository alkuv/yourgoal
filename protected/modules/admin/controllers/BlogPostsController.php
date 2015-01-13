<?php

class BlogpostsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='manager';


	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array(),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view','create','update', 'fileupload', 'delete'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin'),
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
		if(YII::app()->user->isGuest){
			$this->redirect('/admin/site/login');
		}
		$this->layout = 'manager';
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	    if(YII::app()->user->isGuest){
			$this->redirect('/admin/site/login');
		}

		$model=new BlogPosts;
		$this->layout = 'manager';
		// var_dump($_POST['BlogPosts']['user_id']);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$tags = new Tags();
		

		if(isset($_POST['BlogPosts']))
		{

			$model->attributes=$_POST['BlogPosts'];
			
			if($model->save())

				if(isset($_POST['BlogPosts']['tag'])){
					$tags->insertTags($_POST['BlogPosts']['tag'], $model->id);
				}
				$this->redirect(array('index'));
		 }

		$this->render('create',array(
			'model'=>$model, 'tags' => $tags
			));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		if(YII::app()->user->isGuest){
			$this->redirect('/admin/site/login');
		}
		$this->layout = 'manager';
		$model=$this->loadModel($id);
		$tagsmodel = new Tags();

		$model->tag = $tagsmodel->getTags($id);
		// var_dump($model->tags);die();
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['BlogPosts']))
		{
			$model->attributes=$_POST['BlogPosts'];
			if($model->save())
				if(isset($_POST['BlogPosts']['tag'])){
					$tagsmodel->insertTags($_POST['BlogPosts']['tag'], $model->id);
				}
				$this->redirect(array('index'));
		}

		$this->render('update',array(
			'model'=>$model
			));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(YII::app()->user->isGuest){
			$this->redirect('/admin/site/login');
		}
		$this->layout = 'manager';
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
		if(YII::app()->user->isGuest){
			$this->redirect('/admin/site/login');
		}
		$this->layout = 'manager';
		$model = new BlogPosts();
		$dataProvider=new CActiveDataProvider('BlogPosts', array(
                'sort'=>array(
                	'defaultOrder' => 'id DESC',
                	),
                'pagination'=>array(
                        'pageSize'=>15,

                ),
			));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'model' => $model
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return BlogPosts the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=BlogPosts::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param BlogPosts $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='blog-posts-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionTrans(){
		
		if (isset($_POST['str']))
		$arr['trans'] = BlogPosts::translitIt($_POST['str']);
	
		$this->layout=false;
		header('Content-type: application/json');
		echo CJavaScript::jsonEncode($arr);
		Yii::app()->end(); 
	}
}
