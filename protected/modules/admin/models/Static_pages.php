<?php

/**
 * This is the model class for table "static_pages".
 *
 * The followings are the available columns in table 'static_pages':
 * @property integer $id
 * @property string $about_us
 * @property string $contact_us
 * @property string $privacy_policy
 */
class Static_pages extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Static_pages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'static_pages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('about_us, contact_us, privacy_policy', 'required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('about_us', 'required', 'on'=>'aboutus'),
			array('contact_us', 'required', 'on'=>'contactus'),
			array('privacy_policy', 'required', 'on'=>'privacy'),
            array('links', 'required', 'on'=>'links'),
            array('podcasts', 'required', 'on'=>'podcasts'),
			array('textpage', 'required', 'on'=>'textpage'),
			array('help', 'required', 'on'=>'help'),
			array('id, about_us, contact_us, privacy_policy, links,textpage', 'safe', 'on'=>'search'),
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
			'about_us' => 'About Us',
			'contact_us' => 'Contact Us',
			'privacy_policy' => 'Privacy Policy',
                        'links' => 'Links',
                        'podcasts' => 'Podcasts',
						'textpage' => 'Textpage',
						'help' => 'Help',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('about_us',$this->about_us,true);
		$criteria->compare('contact_us',$this->contact_us,true);
		$criteria->compare('privacy_policy',$this->privacy_policy,true);
                $criteria->compare('links',$this->links,true);
                $criteria->compare('podcats',$this->links,true);
				 $criteria->compare('textpage',$this->links,true);
				  $criteria->compare('help',$this->links,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}