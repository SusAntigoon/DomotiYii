<?php

/**
 * This is the model class for table "settings_callerid".
 *
 * The followings are the available columns in table 'settings_callerid':
 * @property integer $id
 * @property boolean $enabled
 * @property string $countrycode
 * @property string $areacode
 * @property string $prefixnational
 * @property string $prefixinternational
 * @property boolean $autocreatecontacts
 * @property boolean $debug
 */
class SettingsCallerid extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SettingsCallerid the static model class
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
		return 'settings_callerid';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id', 'required'),
			array('id', 'numerical', 'integerOnly'=>true),
			array('countrycode, areacode, prefixnational, prefixinternational', 'length', 'max'=>16),
			array('enabled, autocreatecontacts, debug', 'boolean', 'trueValue'=>-1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, enabled, countrycode, areacode, prefixnational, prefixinternational, autocreatecontacts, debug', 'safe', 'on'=>'search'),
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
			'enabled' => 'Enabled',
			'countrycode' => 'Countrycode',
			'areacode' => 'Areacode',
			'prefixnational' => 'Prefix national',
			'prefixinternational' => 'Prefix international',
			'autocreatecontacts' => 'Autocreate contacts',
			'debug' => 'Debug',
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
		$criteria->compare('enabled',$this->enabled);
		$criteria->compare('countrycode',$this->countrycode,true);
		$criteria->compare('areacode',$this->areacode,true);
		$criteria->compare('prefixnational',$this->prefixnational,true);
		$criteria->compare('prefixinternational',$this->prefixinternational,true);
		$criteria->compare('autocreatecontacts',$this->autocreatecontacts);
		$criteria->compare('debug',$this->debug);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
