<?php

class GoalController extends Controller
{
       public $layout='//layouts/main';
    
        /**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;
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
				'actions'=>array('index','dashboard','all','finished','interesting','following','complete','template','Status','deleteGoal','view','love'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','edit','step','dashboard','subscribe','love','complete','goaldelete','follow','unfollow', 'checkPointDone'),
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
        
	public function actionIndex()
	{
                $criteria=new CDbCriteria(array(
			//'condition'=>'status='.Post::STATUS_PUBLISHED,
			'order'=>'update_time DESC',
			'with'=>'commentCount',
		));
//		if(isset($_GET['tag']))
//			$criteria->addSearchCondition('tags',$_GET['tag']);

		$dataProvider=new CActiveDataProvider('Goal', array(
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['postsPerPage'],
			),
			'criteria'=>$criteria,
		));

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
		
	}
        public function actionall()
	{
            //$criteria = new CDbCriteria;
            $criteria=new CDbCriteria(array(
			//'condition'=>'status='.Post::STATUS_PUBLISHED,
			'order'=>'update_time DESC',
			'with'=>'commentCount',
                  
		));
             
			if(isset($_GET['tag']))
			{
			$criteria->addSearchCondition('tags',$_GET['tag']);
			}
            elseif(isset($_GET['cat'])){
			$criteria->addSearchCondition('category_id',$_GET['cat']);
			}else{
				$criteria->addSearchCondition('visibility','yes');
			}
            
            $total = Goal::model()->count();
 
            $pages = new CPagination($total);
            $pages->pageSize = 6;
            $pages->applyLimit($criteria);
  
            $posts = Goal::model()->findAll($criteria);
   //echo '<pre>';print_r($criteria); print_r($posts); echo '</pre>';
        $this->render('allnew', array(
                'posts' => $posts,
                'pages' => $pages,
            ));
      
             /*   $criteria=new CDbCriteria(array(
			//'condition'=>'status='.Post::STATUS_PUBLISHED,
			'order'=>'update_time DESC',
			'with'=>'commentCount',
                  
		));
//		if(isset($_GET['tag']))
//			$criteria->addSearchCondition('tags',$_GET['tag']);

		$dataProvider=new CActiveDataProvider('Goal', array(
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['postsPerPage'],
			),
			'criteria'=>$criteria,
		));

		$this->render('all',array(
			'dataProvider'=>$dataProvider,
		));
		*/
	}
          public function actionfinished()
	{
               $criteria=new CDbCriteria(array(
			'condition'=>'status=:finished',
			'order'=>'update_time DESC',
			'with'=>'commentCount',
                   
		));
                 $criteria->params = array(':finished' => "finished");
              // echo '<pre>';print_r($criteria);   echo '</pre>';
              // die("eddie");
            $total = Goal::model()->count();
            if(isset($_GET['cat']))
			$criteria->addSearchCondition('category_id',$_GET['cat']);
            $pages = new CPagination($total);
            $pages->pageSize = 6;
            $pages->applyLimit($criteria);
 
            $posts = Goal::model()->findAll($criteria);
 
        $this->render('allnew', array(
                'posts' => $posts,
                'pages' => $pages,
            ));
              /*
                $criteria=new CDbCriteria(array(
			'condition'=>'status=:finished',
			'order'=>'update_time DESC',
			'with'=>'commentCount',
                   
		));
                  $criteria->params = array(':finished' => "finished");
//		if(isset($_GET['tag']))
//			$criteria->addSearchCondition('tags',$_GET['tag']);

		$dataProvider=new CActiveDataProvider('Goal', array(
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['postsPerPage'],
			),
			'criteria'=>$criteria,
		));

		$this->render('all',array(
			'dataProvider'=>$dataProvider,
		));
		*/
	}
        
        public function actionfollowing()
	{
               $criteria=new CDbCriteria(array(
			'condition'=>'type=:finished',
			
		));
                $criteria->params = array(':finished' => "subscribe");
              //  $criteria->distinct = true;
               // $criteria->select = array('goal_id',);
              // echo '<pre>';print_r($criteria);   echo '</pre>';
              // die("eddie");
            $total = Subscrbe::model()->count();
 
            $pages = new CPagination($total);
//            $pages->pageSize = 10;
            $pages->applyLimit($criteria);
 //echo '<pre>';print_r($criteria); echo '</pre>';
            $posts = Subscrbe::model()->findAll($criteria);
  //echo '<pre>';print_r($posts); echo '</pre>';
//            die("Eddie");
        $this->render('allnews', array(
                'posts' => $posts,
                'pages' => $pages,
            ));
           
	}
        
		public function actionunfollow($following=null)
		{
		if(!empty($_REQUEST['follow']))
		{
			$following=$_REQUEST['follow'];
		//$model->following_id=$following;
			Subscrbe::model()->deleteAllByAttributes(array(
			'author_id'=>Yii::app()->user->id,'following_id'=>$following
                  ));
                Yii::app()->user->setFlash('notice',"You have successfully unsubscribed");
			     $path=Yii::app()->createAbsoluteUrl("/avatar/avatar/people");	
				$this->redirect($path);
				return 0;	
		}
		}
		
		function actioncheckPointDone()
		{
			 $stepId = $_GET['id'];
			 $goalId = $_GET['goalId'];
			 $ischecked = $_GET['ischecked'];
			 
			 if(isset($goalId) && ($goalId!=""))
			 {
				$connection = Yii::app()->db;
				$command = $connection->createCommand('select * from steps_achieved WHERE goal_id="'.$goalId.'" AND step_no ="'.$stepId.'"');
				$row = $command->queryAll();
				if(count($row)>0)
				{
					 
					$connection1 = Yii::app()->db;
					$command1 = $connection1->createCommand('UPDATE steps_achieved SET status="'.$ischecked.'" WHERE goal_id="'.$goalId.'"AND step_no="'.$stepId.'"');
					if($command1->execute())
					{
						echo "Data Stored Sucessfully";
						exit();
					}

				}else{ 
					 
					//$connection1 = Yii::app()->db;
					$command1 = $connection->createCommand('INSERT into steps_achieved SET status="'.$ischecked.'", goal_id="'.$goalId.'", step_no="'.$stepId.'"');
					if($command1->execute())
					{
						echo "Data Stored Sucessfully";
						exit();
					}
					  
				}
			 }
			 
			 
			 	
		}
        public function actionfollow($following=null)
		{
		//echo $following; 
		if(!empty($_REQUEST['follow']))
		{
			$following=$_REQUEST['follow'];
			
			if($following!=Yii::app()->user->id) {
			
			//echo $following;
			$goallist=Goal::model()->findAllByAttributes(array('author_id'=>$following)); 
			if(!empty($goallist))
			{
			foreach($goallist as $goalinfo)
				{
					$model= new Subscrbe;
					$model->type="subscribe";
					$model->author_id=Yii::app()->user->id;
					$model->goal_id=$goalinfo->id;
					$model->following_id=$following;
					$model->save(false);					

				}
									
				 Yii::app()->user->setFlash('notice',"You have successfully subscribed");
			     $path=Yii::app()->createAbsoluteUrl("/avatar/avatar/people");	
				$this->redirect($path);
				return 0;					 
					
			
			}
			else
			{
			
			  Yii::app()->user->setFlash('notice',"We didn't find any goal for this User.");
			  $path=Yii::app()->createAbsoluteUrl("/avatar/avatar/people");			 
			  $this->redirect($path);
			  return 0;
			  exit("exit");
			}
			}
			else { Yii::app()->user->setFlash('notice',"You can't follow your own goal.");
			  $path=Yii::app()->createAbsoluteUrl("/avatar/avatar/people");			 
			  $this->redirect($path);
			  return 0;
			  exit("exit");}
			//echo '<pre>';print_r($goallist); echo '</pre>';
		}
		//$record=Ipaddress::model()->findByAttributes(array('ip_address'=>$ip_adress,'goal_id'=>$model->id,'user_id'=>Yii::app()->user->id)); 
		
		}
            public function actioninteresting()
	{
                
                 $criteria=new CDbCriteria(array(
			'condition'=>'interesting_status=:interest',
			'order'=>'update_time DESC',
			'with'=>'commentCount',
                   
		));
                 $criteria->params = array(':interest' => "Yes");
            $total = Goal::model()->count();
             if(isset($_GET['cat']))
			$criteria->addSearchCondition('category_id',$_GET['cat']);
            $pages = new CPagination($total);
            $pages->pageSize = 6;
            $pages->applyLimit($criteria);
 
            $posts = Goal::model()->findAll($criteria);
 
        $this->render('allnew', array(
                'posts' => $posts,
                'pages' => $pages,
            ));
                
            /*    $criteria=new CDbCriteria(array(
			'condition'=>'interesting_status=:interest',
			'order'=>'update_time DESC',
			'with'=>'commentCount',
                    
		));
                  $criteria->params = array(':interest' => "Yes");
//		if(isset($_GET['tag']))
//			$criteria->addSearchCondition('tags',$_GET['tag']);

		$dataProvider=new CActiveDataProvider('Goal', array(
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['postsPerPage'],
			),
			'criteria'=>$criteria,
		));

		$this->render('all',array(
			'dataProvider'=>$dataProvider,
		));*/
		
	}
        
          public function actiontemplate()
	{
                $criteria=new CDbCriteria(array(
			'condition'=>'author_id=:interest',
			'order'=>'update_time DESC',
			'with'=>'commentCount',
                    
		));
                  $criteria->params = array(':interest' => "1");
//		if(isset($_GET['tag']))
//			$criteria->addSearchCondition('tags',$_GET['tag']);

		$dataProvider=new CActiveDataProvider('Goal', array(
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['postsPerPage'],
			),
			'criteria'=>$criteria,
		));
//echo '<pre>'; print_r($criteria);echo '</pre>'; 
		$this->render('all',array(
			'dataProvider'=>$dataProvider,
		));
		
	}
        
        
        
	public function actionCreate($step)
	{
             unset(Yii::app()->SESSION['tag']);
             unset(Yii::app()->SESSION['checkbox']);
             unset(Yii::app()->SESSION['stage']);
             unset(Yii::app()->SESSION['description']);
            $this->layout = '//layouts/step';
           $id = Yii::app()->user->id;
             $user_detail = User::model()->findByPk("$id");
            if(!empty ($user_detail)){
		$model=new Goal;
               //
		if(isset($_POST['Goal']))
		{
//                    echo '<pre>'; print_r($_POST);    echo '</pre>';
//                     die("eddie");
                        $model->stage= serialize($_POST['Goal']['stage']);
                        $model->stage_description= serialize($_POST['Goal']['description']);
                        
                        $model->termination= serialize($_POST['Goal']['checkbox']);
                        Yii::app()->SESSION['tag']=$_POST['Goal']['tags'];
                        Yii::app()->SESSION['checkbox']=$_POST['Goal']['checkbox'];
                        Yii::app()->SESSION['stage']=serialize($_POST['Goal']['stage']);
                        Yii::app()->SESSION['description']=serialize($_POST['Goal']['description']);
                        $model->attributes=$_POST['Goal'];                        
                      // echo '<pre>'; print_r($_FILES); echo $_FILES['Goal']['name']['file']; die;
                        if($_FILES['Goal']['tmp_name']['file']!='')                       
                        { 
                        // include("resize-class.php");
                            $tmpName=$_FILES['Goal']['tmp_name']['file'];
                            $extension=explode(".", $_FILES['Goal']['name']['file']);
                            $ext=end($extension);
                            if($ext=='jpeg' || $ext=='jpg' || $ext=='gif' || $ext=='png' || $ext=='bmp')
                            {
                                    $name=$_FILES['Goal']['name']['file'];
                                    $filename = substr($name,0,((strlen($name))-(strlen($ext)+1))).'_'.time().'.'.$ext;
                                    
                                    $original='images/goalIcons/original/' . $filename;
                                    $thumb='images/goalIcons/thumb/' . $filename;                                    
                                    if(move_uploaded_file($tmpName, $original))
                                    {
                                        // *** 1) Initialise / load image
                                        $resizeObj1 = new resize($original);
                                        // *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
                                        $resizeObj1 -> resizeImage(471, 264, 'crop');
                                        // *** 3) Save image
                                        $resizeObj1 -> saveImage($thumb, 100);
                                        $model->image=$thumb;
                                    }
                            }
                            else
                            {
                                Yii::app()->user->setFlash('notice','Please upload only .jpeg, .jpg, .gif, .png or .bmp files only.');
                            }

                       }
                      
			if($model->save()) 
                            {
                             unset(Yii::app()->SESSION['tag']);
                             unset(Yii::app()->SESSION['checkbox']);
                             unset(Yii::app()->SESSION['stage']);
                             unset(Yii::app()->SESSION['description']);
                      
                             Yii::app()->user->setFlash('success', "You are successfully created goal.");
                             $this->redirect(array('view','id'=>$model->id));
                            // $this->redirect(array('dashboard'));
                            }
                 //  $this->redirect(array('view','id'=>$model->id));
		
                    }
		$this->render('step',array(
			'model'=>$model,
		));
            }
              else{
                   Yii::app()->user->setState('targetUrl', Yii::app()->createUrl('goal/create'));   
                    $this->redirect(Yii::app()->createAbsoluteUrl("/user/login"));
                   }
	}
	
	public function actionEdit($id)
	{
		  $this->layout = '//layouts/step';
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Goal']))
		{
		//echo '<pre>';print_r($_POST);echo '<pre>';
		
			            $model->stage= serialize($_POST['Goal']['stage']);
                        $model->stage_description= serialize($_POST['Goal']['description']);                        
                        $model->termination= serialize($_POST['Goal']['checkbox']);                        
                        $model->attributes=$_POST['Goal'];
						//print_r($_FILES['Goal']);die;
                          if($_FILES['Goal']['tmp_name']['image']!='')                       
                        { 
                        // include("resize-class.php");
                            $tmpName=$_FILES['Goal']['tmp_name']['image'];
                            $extension=explode(".", $_FILES['Goal']['name']['image']);
                            $ext=end($extension);
							
                            if($ext=='jpeg' || $ext=='jpg' || $ext=='gif' || $ext=='png' || $ext=='bmp')
                            {
                                    $name=$_FILES['Goal']['name']['image'];
                                    $filename = substr($name,0,((strlen($name))-(strlen($ext)+1))).'_'.time().'.'.$ext;
                                    
                                    $original='images/goalIcons/original/' . $filename;
                                    $thumbs='images/goalIcons/thumb/' . $filename;                                    
                                    if(move_uploaded_file($tmpName, $original))
                                    {
                                        // *** 1) Initialise / load image
                                        $resizeObj1 = new resize($original);
                                        // *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
                                        $resizeObj1 -> resizeImage(471, 264, 'crop');
                                        // *** 3) Save image
                                        $resizeObj1 -> saveImage($thumbs, 100);
                                        $model->image=$thumbs;
                                    }
                            }
                            else
                            {
                                Yii::app()->user->setFlash('notice','Please upload only .jpeg, .jpg, .gif, .png or .bmp files only.');
                            }

                       }
                      
			if($model->save()) {
                            
                            
                             $all_subcriber=Subscrbe::model()->findAll(array("condition"=>"goal_id =  '$model->id' AND type = 'subscribe'"));
                                  if(!empty ($all_subcriber)) 
                                      {
                                        foreach($all_subcriber as $subcriber)
                                            { $connection = Yii::app()->db;
                                                $sub_id=$subcriber->author_id;
                                                $sql="select * from profile where user_id=$sub_id";
                                                  $command = $connection->createCommand($sql);
                                                  $subscriber_record = $command->queryRow(); 
                                                  $email=$subscriber_record['email'];
                                                  $mainname=$subscriber_record['firstname'];
                                                  $goalname=$model->name;
                                                  //$email="abhirahul032@gmail.com";
                                                 MailHelpers::createGoalupdatetoall($goalname,$email,$mainname);
                                             
                                             }
                                      }
//                              echo '<pre>';print_r($all_subcriber); echo '</pre>';
//                              die();
//                            
				$this->redirect(array('goal/view','id'=>$model->id));
				}
		}

		$this->render('update',array(
			'model'=>$model,
		));
		
		
		
	}        
        
        /**
	 * Displays a particular model.
	 */
	public function actionView()
	{   
            
		$post=$this->loadModel();
		$comment=$this->newComment($post);
               
		$this->render('view',array(
			'model'=>$post,
			'comment'=>$comment,
		));
                
	}
        
		
	public function actionComplete()
	{   
			$goal_id=$_REQUEST['goal_id'];
            $goal = Goal::model()->findByPk("$goal_id");
			$goal->status="Finished";
			if($goal->save(false)) 
			{
				echo "1";
				exit();
			}
		
	}
		
        	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
			{
//				if(Yii::app()->user->isGuest)
//					$condition='status='.Post::STATUS_PUBLISHED.' OR status='.Post::STATUS_ARCHIVED;
//				else
					$condition='';
				$this->_model=Goal::model()->findByPk($_GET['id'], $condition);
			}
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}
        
        public function actiondashboard()
        {
        	
             $id = Yii::app()->user->id;
             $user_detail = User::model()->findByPk("$id");
             if(!empty ($user_detail)){
             $this->render('dashboard',array('model'=>$user_detail));
			 }
             
             else{
                   Yii::app()->user->setState('targetUrl', Yii::app()->createUrl('goal/dashboard'));   
                  $this->redirect(Yii::app()->createAbsoluteUrl("/user/login"));
                   }
        }
        
        	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Goal('search');
		if(isset($_GET['Goal']))
			$model->attributes=$_GET['Goal'];
		$this->render('admin',array(
			'model'=>$model,
		));
	}
        
        protected function newComment($post)
	{
		$comment=new Comment;
		if(isset($_POST['ajax']) && $_POST['ajax']==='comment-form')
		{
			echo CActiveForm::validate($comment);
			Yii::app()->end();
		}
		if(isset($_POST['Comment']))
		{
			$comment->attributes=$_POST['Comment'];
			if($post->addComment($comment))
			{
				if($comment->status==Comment::STATUS_PENDING)
					Yii::app()->user->setFlash('commentSubmitted','Thank you for your comment. Your comment will be posted once it is approved.');
				$this->refresh();
			}
		}
		return $comment;
	}
        
        
          public function actionsubscribe()
            {
            $type=$_REQUEST['type'];
            $login_id=$_REQUEST['login_id'];
            $goal_id=$_REQUEST['goal_id'];            
            $record=Subscrbe::model()->findByAttributes(array('goal_id'=>$goal_id,'author_id'=>$login_id,'type'=>$type)); 
            if(empty ($record))
            {
                $model= new Subscrbe();
                $model->type=$type;
                $model->author_id=$login_id;
                $model->goal_id=$goal_id;
                $model->save(false); 

                 
                    $connection = Yii::app()->db;
                    $sql="select * from profile where user_id=$login_id";
                    $command = $connection->createCommand($sql);
                    $row = $command->queryRow();
                    $providername=$row['firstname'];
                    $createdemail=$row['email'];
                 
                
                 $goalrecord=Goal::model()->findByPk($goal_id); 
                 $author_id=$goalrecord->author_id;
                 $connection = Yii::app()->db;
                    $sql="select * from profile where user_id=$author_id";
                    $command = $connection->createCommand($sql);
                    $rowcr = $command->queryRow();
                    $name=$rowcr['firstname'];
                    $adminemail=$rowcr['email'];
                 //echo '<pre>';print_r($email); print_r($name); print_r($providername); echo '</pre>';
                // $createdemail="abhirahul032@gmail.com";
                MailHelpers::createGoalMailtoadmin($name,$adminemail,$providername);
                MailHelpers::createGoalMailtouser($providername,$createdemail);
               // MailHelpers::createGoalMailtoadmin($name,$email,$providername);
                
                
                  echo "1";
              
                  exit();                
            }
            else
            {
                echo "2";
                exit();
            }
            }
            public function actionlove()
            {
            $type=$_REQUEST['type'];
            $login_id=$_REQUEST['login_id'];
            $goal_id=$_REQUEST['goal_id'];            
            $record=Subscrbe::model()->findByAttributes(array('goal_id'=>$goal_id,'author_id'=>$login_id,'type'=>$type)); 			
            if(empty ($record))
            {
                $model= new Subscrbe();
                $model->type=$type;
                $model->author_id=$login_id;
                $model->goal_id=$goal_id;
                $model->save(false);                
                  echo "1";
                  exit();                
            }
            else
            {
                $record->delete();
                echo "2";
                exit();
            }
            }
			
			public function actionStatus()
			{
			 $status=$_REQUEST['status'];
           
            $goal_id=$_REQUEST['goal_id'];            
            $record=Goal::model()->findByPk($goal_id); 
			if(!empty($record)) 
			{
				$record->status=$status;
				$record->save(false);
				echo "1";
				exit();
			}
				
			}
			public function actiondeleteGoal()
			{
				//print_r($_REQUEST); die;
				$goalId = $_REQUEST['goal_id'];  
				$record = Goal::model()->deleteByPk($goalId); 
				echo "1";
				exit();
				 			
			}
                        public function actiongoaldelete()
			{
				
                                	$model=$this->loadModel();
                                        $model->delete();
                                         Yii::app()->user->setFlash('notice', "Your Goal succssfully Deleted.");
                                         $path= Yii::app()->createAbsoluteUrl("/goal/all");
                                         $this->redirect($path);

				 			
			}
        
}