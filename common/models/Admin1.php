<?php

/**
 * This is the model class for table "128_user".
 *
 * The followings are the available columns in table '128_user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $realname
 * @property string $usericon
 * @property string $create_time
 * @property string $last_login_time
 * @property string $self_introduction
 * @property integer $business_id
 * @property integer $rent_id
 * @property integer $job_id
 * @property integer $event_id
 * @property integer $comment_id
 * @property integer $status
 */
class Admin extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return 'jiexi_admin';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
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
		);
	}
                
        public static function getModelById($id){
            $model = Customer::model()->findByPk($id);
            if( empty($model) ){
                $msg = '对应的user信息不存在！';
                if( Yii::app()->request->isAjaxRequest ){
                    echo json_encode(array('result'=>'error','msg'=>$msg));
                    Yii::app()->end();
                }else{
                    throw new CHttpException(Consts::EXCEPTION_DATA_ERROR, $msg);
                }
            }
            return $model;
        }
        
}