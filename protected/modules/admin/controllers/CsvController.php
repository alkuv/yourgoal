<?php 
/**
 * 
 **/
class CsvController extends Controller
{
	public function accessRules() {
		return array(
				array('allow',
					'actions'=>array('select', 'export'),
					'expression' => 'Yii::app()->user->isAdmin()'
					),
				array('deny',  // deny all other users
						'users'=>array('*'),
						),
				);
	}

	public function actionExport() {
             $this->layout = 'adminmain'; 
		if(isset($_POST['profile_fields'])) {

			$fields = '';
			foreach($_POST['profile_fields'] as $field)
				$fields .= $field .',';
			$fields = substr($fields, 0, -1);

			Yii::import('application.modules.user.components.CSVExport');
			$sql = sprintf('select %s from %s where %s',
					$fields, 
					Yum::module('profile')->profileTable,
					Yum::module()->customCsvExportCriteria);
			$result = Yii::app()->db->createCommand($sql)->queryAll();
			$csv = new CSVExport($result);
			$content = $csv->toCSV();
			$filename = Yii::app()->basePath.'/runtime/yum_user_export.csv';
			$content = $csv->toCSV($filename, ",", "\"");                 
			Yii::app()->getRequest()->sendFile(basename($filename),
					@file_get_contents($filename),
					"text/csv", false);
			exit();
		}
	}

	public function actionSelect() {
             $this->layout = 'adminmain'; 
		$profile = new YumProfile;
		$this->render('select', array(
					'user' => new YumUser,
					'profile_fields' => $profile->getProfileFields(),
					));
	}
}
