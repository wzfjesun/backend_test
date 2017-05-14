<?php

class SeoSettingController extends JxadminController
{
//        public $layout='application.views.layouts.admin.column';
        
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
        
        public function actionSave()
	{
            if( empty($_POST['SeoSetting']['id']) ){
                $type = 'add';
            }else{
                $type = 'edit';
            }
            //定义一个验证表单，并设置场景
            $form = new SeoSetting($type);

            //ajax提交验证的情况下
            if(isset($_POST['ajax']) && $_POST['ajax']==='seo-form')
            {
                echo CActiveForm::validate($form);
                Yii::app()->end();
            }

            if(isset($_POST['SeoSetting']))
            {
                $form->attributes = $_POST['SeoSetting'];
                //表单验证
                
                if($form->validate())
                {
                    //验证通过的话，做更新数据处理
                    $ret = $this->doSave($form->attributes);
                    if( $ret === false){
                        $msg = Yii::t('app','Save failed!');
                    }else{
                        $msg = Yii::t('app','Saved Successfully!');
                    }
                    Yii::app()->user->setFlash('result',$msg);
                    //修改
                    $this->redirect(array('index'));
                }
            }
            //显示修改界面、并返回错误信息。
            $this->render('index',array(
                'model'=>$form,
            ));
        }
        
        public function doSave($data)
        {
                if( empty($data['id']) ){
                    $model = new SeoSetting();
                    $type = 'add';
                }else{
                    $model = SeoSetting::getModelById($data['id']);
                    $type = 'edit'; 
                }
                $model->attributes = $data;
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    //Save the model to the database
                    if($model->save()){
                        $transaction->commit();
                        return $model->id;
                    }else{
                        Yii::log(CVarDumper::dumpAsString($model->getErrors() ), CLogger::LEVEL_ERROR );
                        return false;
                    }
                } catch(Exception $e) {
                    $transaction->rollback( );
                    Yii::log(CVarDumper::dumpAsString($e->getMessage() ), CLogger::LEVEL_ERROR );
                    return false;
                }
        }
        
        public function actionAdd()
	{
            $model = new SeoSetting('add');
            $this->render('edit',array(
                'model'=>$model,
            ));
        }
        
        //编辑内容
        public function actionUpdate()
        {
            $id = Yii::app()->request->getParam('id','');
            $form = SeoSetting::getModelById($id);
            $this->render('edit',array(
                'model'=>$form,
            ));
        }

        //复写内容
        public function actionCopy()
        {
            $id = Yii::app()->request->getParam('id','');
            $model = SeoSetting::getModelById($id);
            $model->id = '';
            $this->render('edit',array(
                'model'=>$model,
            ));
        }

        //删除
        public function actionDelete()
        {
            $id = Yii::app()->request->getParam('id','');
            $model = SeoSetting::getModelById($id);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                //Save the model to the database
                $model->del = 1;
                if($model->save()){
                    $transaction->commit();
                }else{
                    Yii::log(CVarDumper::dumpAsString($model->getErrors() ), CLogger::LEVEL_ERROR );
                }
            } catch(Exception $e) {
                $transaction->rollback( );
                Yii::log($e->getMessage() , CLogger::LEVEL_ERROR );
                Yii::app( )->handleException( $e );
            }
        }
            
        public function actionIndex()
        {
            $conditionArr = array( 't.del=0');
            $paramsArr = array();
            $condition = implode(' AND ', $conditionArr);
            $criteria = new CDbCriteria();
            $criteria->condition = $condition;
            $criteria->params = $paramsArr;
            $criteria->order = 't.id DESC';

            $dataProvider=new CActiveDataProvider('SeoSetting', array(
                    'criteria' => $criteria,
                    'pagination'=>array(
                    //所以关于pagination的设置都可以在这里进行
                            'pagesize'=>10, 
                    ),
            ));

            $this->render('index',array('dataProvider' => $dataProvider));
        }
}

