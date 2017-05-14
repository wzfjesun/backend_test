<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "jiexi_seo_path".
 *
 * @property integer $id
 * @property string $module_id
 * @property string $controller_id
 * @property string $action_id
 * @property string $create_time
 * @property integer $del
 */
class SeoPath extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jiexi_seo_path';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['module_id', 'controller_id', 'action_id', 'create_time', 'del'], 'required'],
            [['create_time'], 'safe'],
            [['del'], 'integer'],
            [['module_id', 'controller_id', 'action_id'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'module_id' => 'Module ID',
            'controller_id' => 'Controller ID',
            'action_id' => 'Action ID',
            'create_time' => 'Create Time',
            'del' => 'Del',
        ];
    }
    
    public function checkPath(){
            $model = $this->find("module_id=:module_id and controller_id=:controller_id and action_id=:action_id and del = 0",array(
                ":module_id"=>$this->module_id,
                ":controller_id"=>$this->controller_id,
                ":action_id"=>$this->action_id,
            ));
            if( empty($model) || $model->isNewRecord ){
                return true;
            }else if( $model->id != $this->id ){
                    $this->addError('action_id', '此路径页面已经存在！');
            }
    }

    public static function getControllersByModule($module_id){
        if( empty($module_id) ){
            $module_id = null;
        }
        $controllers = Yii::$app->metadata->getControllers($module_id);
        $options = array();
        foreach ($controllers as $key=>&$c)
        {            
            $controller_id = str_ireplace('Controller','',$c);
            $options[$controller_id] = $controller_id;
        }
        return $options;
    }

    public static function getActions($controller_id,$module_id){
        if( empty($controller_id) ){
            return array();
        }
        if( empty($module_id) ){
            $module_id = null;
        }
        $controller_id = $controller_id.'Controller';
        $actions = Yii::app()->metadata->getActions($controller_id,$module_id); 
        $options = array();
        foreach ($actions as $key=>$action_id)
        {            
            $options[$action_id] = $action_id;
        }  
        return $options;
    }
        
}
