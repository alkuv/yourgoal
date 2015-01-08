<?php

/**
 * This is the model class for table "blog_posts".
 *
 * The followings are the available columns in table 'blog_posts':
 * @property string $id
 * @property string $title
 * @property string $description
 * @property string $image
 * @property integer $cat_id
 * @property integer $user_id
 * @property string $created
 */
class BlogPosts extends CActiveRecord
{
	public $tag;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'blog_posts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, description, cat_id, user_id, url', 'required'),
			array('cat_id, user_id', 'numerical', 'integerOnly'=>true),
			array('title, image', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, description, image, cat_id, user_id, created', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user'=>array(self::BELONGS_TO, 'user', 'user_id'),
			'cat'=>array(self::BELONGS_TO, 'categories', 'cat_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'description' => 'Description',
			'image' => 'Image',
			'cat_id' => 'Cat',
			'user_id' => 'User',
			'created' => 'Created',
			'url' => 'URL',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('cat_id',$this->cat_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('created',$this->created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BlogPosts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getPosts(){
    	
    	$criteria = new CDbCriteria();
    	$criteria->with = array("user");
    	$criteria->alias = "post";
    	if (isset($_GET['tag'])){
    		$criteria->join = "LEFT JOIN `tags` ON `post`.`id` = `tags`.`bp_id`";
    		$criteria->condition = "tags.tag = '".$_GET['tag']."'";
    	}
    	if (isset($_GET['category'])){
    		if (!empty($criteria->condition)) $criteria->condition .= " and ";
    		$criteria->condition .= " cat_id = ".$_GET['category'];
    	}
    	if(isset($_GET['date'])){
    		if (!empty($criteria->condition)) $criteria->condition .= " and ";
    		$date = strtotime($_GET['date']);
    		$month = date("m",$date);
    		$year = date("Y",$date);
    		$criteria->condition .= "MONTH(created) = '".$month."' and YEAR(created) = '".$year."'";
    	}
    	$criteria->order = "post.id DESC";
    	
    	return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
				'pageSize' => 10,
			),
		));
    }

    public function getNextPost($id){

    	return $list= Yii::app()->db->createCommand('SELECT id,title,url FROM `blog_posts` WHERE (
    	 `id` = (SELECT MIN(`id`) FROM `blog_posts` WHERE `id` >'.$id.')
				)')->queryAll();
    }

    public function getPrevPost($id){

    	return $list= Yii::app()->db->createCommand('SELECT id,title,url FROM `blog_posts` WHERE (
				`id` = (SELECT MAX(`id`) FROM `blog_posts`WHERE `id` <'.$id.')
				)')->queryAll();
    }

    public function getArchiveList(){
    	return $list = Yii::app()->db->createCommand('SELECT DATE_FORMAT(`created`, "%b") as month, YEAR(`created`) as year 
    		FROM `blog_posts` GROUP by MONTHNAME(`created`) ORDER BY `created` DESC')->queryAll();
    }

    public static function getIdByAlias($alias){
        $r = self::model()->find('url = :alias', array(":alias" => $alias));
        return $r->id;
    }

    public static function translitIt($str)
    {
        $str = str_replace(' ', '_', $str);
        $tr = array(
            "А" => "A", "Б" => "B", "В" => "V", "Г" => "G",
            "Д" => "D", "Е" => "E", "Ж" => "J", "З" => "Z", "И" => "I",
            "Й" => "Y", "К" => "K", "Л" => "L", "М" => "M", "Н" => "N",
            "О" => "O", "П" => "P", "Р" => "R", "С" => "S", "Т" => "T",
            "У" => "U", "Ф" => "F", "Х" => "H", "Ц" => "TS", "Ч" => "CH",
            "Ш" => "SH", "Щ" => "SCH", "Ъ" => "", "Ы" => "YI", "Ь" => "",
            "Э" => "E", "Ю" => "YU", "Я" => "YA", "а" => "a", "б" => "b",
            "в" => "v", "г" => "g", "д" => "d", "е" => "e", "ж" => "j",
            "з" => "z", "и" => "i", "й" => "y", "к" => "k", "л" => "l",
            "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
            "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "h",
            "ц" => "ts", "ч" => "ch", "ш" => "sh", "щ" => "sch", "ъ" => "y",
            "ы" => "yi", "ь" => "", "э" => "e", "ю" => "yu", "я" => "ya",
            "і" => "y", "I" => "Y"
        );
        return strtr($str, $tr);
    }

    public static function getTitle($id){
        $r = self::model()->findByPk($id);
        return $r->title;
    }

    public static function getShortDescription($id){
        $r = self::model()->findByPk($id);
        
        $string = $r->description;
		$string = strip_tags($string);
		$string = substr($string, 0, 500);
		$string = rtrim($string, "!,.-");

		$string = substr($string, 0, strrpos($string, ' '));
        
        return trim($string);
    }  
}
