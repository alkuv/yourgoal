<?php

/**
 * This is the model class for table "tags".
 *
 * The followings are the available columns in table 'tags':
 * @property integer $id
 * @property integer $bp_id
 * @property string $tag
 */
class Tags extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tags';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bp_id, tag', 'required'),
			array('bp_id', 'numerical', 'integerOnly'=>true),
			array('tag', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, bp_id, tag', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'bp_id' => 'Bp',
			'tag' => 'Tag',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('bp_id',$this->bp_id);
		$criteria->compare('tag',$this->tag,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Tags the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function insertTags($tags, $bp_id){
		$tagsarray = explode(",", $tags);
		
		self::model()->deleteAll("bp_id = :id", array(":id" => $bp_id));
		
		foreach ($tagsarray as $value) {
			$model = new Tags();
			$model->bp_id = $bp_id;
			$model->tag = trim($value);
			$model->save(false);
		}
		
	}

	public static function getTags($id){
		$tags = self::model()->findAll('bp_id = :id', array(':id' => $id));
		$tagstring = '';
		foreach ($tags as $value) {
			if (empty($tagstring)){
				$tagstring .= $value->tag;
			}else{
				$tagstring .= ','.$value->tag;
			}
			
		}
		return $tagstring;
	}

	public static function getTagsArray($id){

		return self::model()->findAll('bp_id = :id', array(':id' => $id));

	}

	public static function getAllTags(){
		$criteria = new CDbCriteria();
		$criteria->distinct = true;
		$criteria->group = 'tag';
		return self::model()->findAll($criteria);
	}
}
