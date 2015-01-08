<?php 
// This controller handles the administration, upload and the deletion 
// of an Avatar image for the user profile.

Yii::import('application.modules.user.controllers.YumController');

class YumAvatarController extends YumController {
	public function beforeAction($action) {
		// Disallow guests
	 if($action->id!="people") 
            {
		// Disallow guests
		if(Yii::app()->user->isGuest)
			$this->redirect(Yum::module()->loginUrl);

		if (Yii::app()->user->isAdmin())
			$this->layout = Yum::module('avatar')->adminLayout;
		else
			$this->layout = Yum::module('avatar')->layout;
            }

		return parent::beforeAction($action);
	}

	public function actionRemoveAvatar($id = null) {
		if($id && Yii::app()->user->isAdmin())
			$model = YumUser::model()->findByPk($id);
		else
			$model = YumUser::model()->findByPk(Yii::app()->user->id);

		if(!$model)
			throw new CHttpException(404);

		$model = YumUser::model()->findByPk(Yii::app()->user->id);
		$model->avatar = '';
		$model->save();
		$this->redirect(array('//goal/dashboard'));	
	}

	public function actionEnableGravatar($id = null) {
		if($id && Yii::app()->user->isAdmin())
			$model = YumUser::model()->findByPk($id);
		else
			$model = YumUser::model()->findByPk(Yii::app()->user->id);

		if(!$model)
			throw new CHttpException(404);

		$model->avatar = 'gravatar';
		$model->save();
		$this->redirect(array(
					Yum::module('profile')->profileViewRoute));	
	}

	public function actionEditAvatar($id = null) {
		if($id && Yii::app()->user->isAdmin())
			$model = YumUser::model()->findByPk($id);
		else
			$model = YumUser::model()->findByPk(Yii::app()->user->id);

		if(!$model)
			throw new CHttpException(404);
		
		if(isset($_POST['YumUser'])) {
			//print_r($_POST['YumUser']);die;
			$model->attributes = $_POST['YumUser'];
			$model->setScenario('avatarUpload');

			if($_FILES['YumUser']['tmp_name']['file']!='')                       
			{ 
			// include("resize-class.php");
				$tmpName=$_FILES['YumUser']['tmp_name']['file'];
				$extension=explode(".", $_FILES['YumUser']['name']['file']);
				$ext=end($extension);
				
				if($ext=='jpeg' || $ext=='jpg' || $ext=='gif' || $ext=='png' || $ext=='bmp')
				{
						$name=$_FILES['YumUser']['name']['file'];
						//$filename = substr($name,0,((strlen($name))-(strlen($ext)+1))).'_'.time().'.'.$ext;
						$filename = $model->id . '_' . $_FILES['YumUser']['name']['file'];
						$original='images/' . $filename;
						$thumbs='images/' . $filename;                                    
						if(move_uploaded_file($tmpName, $original))
						{
							// *** 1) Initialise / load image
							$resizeObj1 = new resize($original);
							// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
							$resizeObj1 -> resizeImage(255, 255, 'crop');
							// *** 3) Save image
							$resizeObj1 -> saveImage($thumbs, 100);
							$model->avatar=$original;
							if($model->save()) {
							$this->redirect(array('//goal/dashboard'));	
							}
						}
				}
				else
				{
					Yii::app()->user->setFlash('notice','Please upload only .jpeg, .jpg, .gif, .png or .bmp files only.');
				}

		   }
			/*if(Yum::module('avatar')->avatarMaxWidth != 0)
				$model->setScenario('avatarSizeCheck');

			$model->avatar = CUploadedFile::getInstanceByName('YumUser[avatar]');
			if($model->validate()) {
				if ($model->avatar instanceof CUploadedFile) {
					//Prepend the id of the user to avoid filename conflicts
					$filename = Yum::module('avatar')->avatarPath .'/'.  $model->id . '_' . $_FILES['YumUser']['name']['avatar'];
					$model->avatar->saveAs($filename);
					$model->avatar = $filename;
					if($model->save()){
						Yum::setFlash(Yum::t('The image was uploaded successfully'));
						Yum::log(Yum::t('User {username} uploaded avatar image {filename}', array(
										'{username}' => $model->username,
										'{filename}' => $model->avatar)));
						$this->redirect(array('//profile/profile/view'));	
					}
				}
			}*/
		}
		$this->render('edit_avatar', array('model' => $model));
	}

	public function actionAdmin() {
		$model = new YumUser();
		$model->unsetAttributes(); // display all users
		$this->render('admin', array('model' => $model));
	}
        
      /*   public function actionpeople() {
              $this->layout = '//layouts/main';
              
              
		$search = '';
		if(isset($_POST['search_username']))
			$search = $_POST['search_username'];

		$criteria = new CDbCriteria;

				if(Yum::hasModule('profile')) {
                                    if($search) {
			
                
					$criteria->join = 'LEFT JOIN '.Yum::module('profile')->profileTable .' on t.id = profile.user_id';
                                      //  $criteria->addCondition("firstname = '{$search}'",'OR'); 
//                                        $criteria->addSearchCondition("city = '{$search}'",'OR'); 
					
					}
                                        }

		
		if($search) {
			$criteria->addCondition("username = '{$search}'");
                }
                        $criteria->addCondition('status = 1 or status = 2 or status = 3');
                       // echo '<pre>';print_r($criteria);echo '</pre>';
		$dataProvider=new CActiveDataProvider('YumUser', array(
					'criteria' => $criteria, 
					'pagination'=>array(
						'pageSize'=>10,
						)));

		$this->render('people',array(
					'dataProvider'=>$dataProvider,
					'search_username' => $search ? $search : '',
					));
              
              /*
                $model = new YumUser();
		$model->unsetAttributes(); // display all users
		$this->render('people', array('model' => $model));
                
                }
                */
                
                
                public function actionpeople($string='') {
              $this->layout = '//layouts/main';
              
              
		$search = '';
		if(isset($_REQUEST['string']))
			$search = $_REQUEST['string'];

		$criteria = new CDbCriteria;
//                 $criteria->addCondition('status = 1 or status = 2 or status = 3');
//if($search) {
//			$criteria->addCondition("username = '{$search}','OR'");
//                }
				if(Yum::hasModule('profile')) {
                                    if($search) {
			
                                        $criteria->with=array('profile');
                                         $criteria->addSearchCondition('profile.firstname',$search,true,"OR","LIKE");
                                         $criteria->addSearchCondition('profile.city',$search,true,"OR","LIKE");
                                         $criteria->addSearchCondition('profile.lastname',$search,true,"OR","LIKE");
                                         $criteria->addSearchCondition('profile.nickname',$search,true,"OR","LIKE");
                                   /* $criteria->join = 'LEFT JOIN '.Yum::module('profile')->profileTable .' on t.id = profile.user_id';
                                       $criteria->addCondition("firstname = '{$search}'",'OR'); 
                                       $criteria->addCondition("city = '{$search}'",'OR'); 
					*/
					}
                                        }

		
		
                       
                     //   echo '<pre>';print_r($criteria);echo '</pre>';
                        
		$dataProvider=new CActiveDataProvider('YumUser', array(
					'criteria' => $criteria, 
					'pagination'=>array(
						'pageSize'=>10,
						)));

		$this->render('test',array(
					'dataProvider'=>$dataProvider,
					'search_username' => $search ? $search : '',
					));
              
              /*
                $model = new YumUser();
		$model->unsetAttributes(); // display all users
		$this->render('people', array('model' => $model));
                */
                }
                
}
