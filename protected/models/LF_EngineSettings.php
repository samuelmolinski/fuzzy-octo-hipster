<?php

/**
 * This is the model class for table "ni_lf_enginesettings".
 *
 * The followings are the available columns in table 'ni_lf_enginesettings':
 * @property integer $id
 * @property string $name
 * @property string $users
 * @property integer $numOfCombs
 * @property integer $amountPerGroup
 * @property string $ruleOrder
 * @property string $ranges1a1
 * @property string $group2_2
 * @property string $permitted1a8
 * @property double $rule_2_2_2_limit
 */
class LF_EngineSettings extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LF_EngineSettings the static model class
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
		return 'ni_lf_enginesettings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, users, numOfCombs, amountPerGroup, ruleOrder, ranges1a1, group2_2, permitted1a8, rule_2_2_2_limit', 'required'),
			array('numOfCombs, amountPerGroup', 'numerical', 'integerOnly'=>true),
			array('rule_2_2_2_limit', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, users, numOfCombs, amountPerGroup, ruleOrder, ranges1a1, group2_2, permitted1a8, rule_2_2_2_limit', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'users' => 'Users',
			'numOfCombs' => 'Num Of Combs',
			'amountPerGroup' => 'Amount Per Group',
			'ruleOrder' => 'Rule Order',
			'ranges1a1' => 'Ranges1a1',
			'group2_2' => 'Group2 2',
			'permitted1a8' => 'Permitted1a8',
			'rule_2_2_2_limit' => 'Rule 2 2 2 Limit',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('users',$this->users,true);
		$criteria->compare('numOfCombs',$this->numOfCombs);
		$criteria->compare('amountPerGroup',$this->amountPerGroup);
		$criteria->compare('ruleOrder',$this->ruleOrder,true);
		$criteria->compare('ranges1a1',$this->ranges1a1,true);
		$criteria->compare('group2_2',$this->group2_2,true);
		$criteria->compare('permitted1a8',$this->permitted1a8,true);
		$criteria->compare('rule_2_2_2_limit',$this->rule_2_2_2_limit);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}