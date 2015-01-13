<?php

/**
 * This is the model class for table "blog_comments".
 *
 * The followings are the available columns in table 'blog_comments':
 * @property string $id
 * @property string $author_id
 * @property string $bp_id
 * @property string $answer_id
 * @property string $comment
 * @property string $created
 */
class BlogComments extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'blog_comments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('author_id, bp_id, comment', 'required'),
			array('author_id, bp_id, answer_id', 'length', 'max'=>10),
			array('created', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, author_id, bp_id, answer_id, comment, created', 'safe', 'on'=>'search'),
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
			'user'=>array(self::BELONGS_TO, 'user', 'author_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'author_id' => 'Author',
			'bp_id' => 'Bp',
			'answer_id' => 'Answer',
			'comment' => 'Comment',
			'created' => 'Created',
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
		$criteria->compare('author_id',$this->author_id,true);
		$criteria->compare('bp_id',$this->bp_id,true);
		$criteria->compare('answer_id',$this->answer_id,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('created',$this->created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BlogComments the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getComments($bp_id){
		return self::model()->findAll("bp_id = :id and answer_id = 0 ORDER BY id DESC", array(":id" => $bp_id));
	}

	public static function getSubComments($bp_id ,$answer_id){
		return self::model()->findAll("bp_id = :id and answer_id = :aid  ORDER BY id DESC", array(":id" => $bp_id, ":aid" => $answer_id));
	}
}
