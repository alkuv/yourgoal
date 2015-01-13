<?php

class BlogpostsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	// public $layout='//layouts/column2';

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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'like'),
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
	public function actionView($alias)
	{
				
		$model = new BlogPosts();

		$id = $model->getIdByAlias($alias);

		$this->pageTitle = BlogPosts::getTitle($id)." / YourGoal";
        $this->pageDescription = BlogPosts::getMetaDescription($id);
        $this->pageTags = Tags::getTags($id);

		
		$nextpost = $model->getNextPost($id);
		$prevpost = $model->getPrevPost($id);
		$commentmodel = new BlogComments();
		$comments = $commentmodel->getComments($id);
		$category = Categories::model()->findAll();
		$tags = Tags::getAllTags();
		$archive = $model->getArchiveList();

		if(isset($_POST['BlogComments'])) 
		    { 
		    	$_POST['BlogComments']['author_id'] = Yii::app()->user->id;
		    	$_POST['BlogComments']['bp_id'] = $id;

		    	//var_dump($_POST['BlogComments']);die();
		        $commentmodel->attributes=$_POST['BlogComments']; 
		        if($commentmodel->validate()) 
		        { 
		            $commentmodel->save();
		            $this->refresh();
		            // form inputs are valid, do something here 
		            //return; 
		        } 
		    } 

		
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'nextpost' => $nextpost,
			'prevpost' => $prevpost,
			'commentmodel' => $commentmodel,
			'comments' => $comments,
			'category' => $category,
			'tags' => $tags,
			'archive' => $archive
		));
	}


	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->pageTitle = "Blog Yourgoal";
		// Вы можете здесь добавить дескрипшин и теги для главной блога
		$this->pageDescription = "";
		$this->pageTags = "";

		$model = new BlogPosts();
		$posts = $model->getPosts();
		$category = Categories::model()->findAll();
		$tags = Tags::getAllTags();
		$archive = $model->getArchiveList();

		$this->render('index',array(
			'posts'=>$posts,
			'category' => $category,
			'tags' => $tags,
			'archive' => $archive
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

	public function actionLike(){
		
		$arr = array();
		if(!empty($_POST['postid'])){
			if(BlogLikes::model()->exists("bp_id = :postid and user_id = :uid", array(":postid" => $_POST['postid'], ":uid" => Yii::app()->user->id))){
				BlogLikes::model()->deleteAll("bp_id = :postid and user_id = :uid", array(":postid" => $_POST['postid'], ":uid" => Yii::app()->user->id));
				$arr['count'] = BlogLikes::model()->count("bp_id = :postid", array(":postid" => $_POST['postid']));
			}else{
				$likes = new BlogLikes();
				$likes->bp_id = $_POST['postid'];
				$likes->user_id = Yii::app()->user->id;
				$likes->save();
				$arr['count'] = BlogLikes::model()->count("bp_id = :postid", array(":postid" => $_POST['postid']));
			}
		}

		$this->layout=false;
		header('Content-type: application/json');
		echo CJavaScript::jsonEncode($arr);
		Yii::app()->end(); 
	}

}
