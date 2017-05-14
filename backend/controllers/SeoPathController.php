<?php
namespace backend\controllers;

use Yii;
use common\models\SeoPath;
use common\models\SeoPathSearch;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class SeoPathController extends Controller
{
        //public $layout='application.views.layouts.column_backend';
//        public $layout='application.views.layouts.admin.column';
	
        /**
         * @inheritdoc
         */
//        public function behaviors()
//        {
//            return [
//                'access' => [
//                    'class' => AccessControl::className(),
//                    'rules' => [
//                        [
//                            'actions' => ['login', 'error'],
//                            'allow' => true,
//                        ],
//                        [
//                            'actions' => ['logout', 'index'],
//                            'allow' => true,
//                            'roles' => ['@'],
//                        ],
//                    ],
//                ],
//                'verbs' => [
//                    'class' => VerbFilter::className(),
//                    'actions' => [
//                        'logout' => ['post'],
//                    ],
//                ],
//            ];
//        }
    
//        /**
//	 * Declares class-based actions.
//	 */
//	public function actions()
//	{
//		return array(
//			// captcha action renders the CAPTCHA image displayed on the contact page
//			'captcha'=>array(
//				'class'=>'CCaptchaAction',
//				'backColor'=>0xFFFFFF,
//			),
//			// page action renders "static" pages stored under 'protected/views/site/pages'
//			// They can be accessed via: index.php?r=site/page&view=FileName
//			'page'=>array(
//				'class'=>'CViewAction',
//			),
//		);
//	}

        
        //获取内容编辑列表
        public function actionIndex()
        {
//            var_dump( Yii::app()->modules );
//            die();
            
//            $conditionArr = array( 't.del=0');
//            $paramsArr = array();
//            $condition = implode(' AND ', $conditionArr);
//            $criteria = new CDbCriteria();
//            $criteria->condition = $condition;
//            $criteria->params = $paramsArr;
//            $criteria->order = 't.id DESC';
//
//            $dataProvider=new CActiveDataProvider('SeoPath', array(
//                    'criteria' => $criteria,
//                    'pagination'=>array(
//                    //所以关于pagination的设置都可以在这里进行
//                            'pagesize'=>20, 
//                    ),
//            ));
//
//            $this->render('index',array('dataProvider' => $dataProvider));
            
            $searchModel = new SeoPathSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        
        }

        public function actionSave()
        {
            if( empty($_POST['SeoPath']['id']) ){
                $type = 'add';
            }else{
                $type = 'edit';
            }
            //定义一个验证表单，并设置场景
            $form = new SeoPath($type);

            //ajax提交验证的情况下
            if(isset($_POST['ajax']) && $_POST['ajax']==='seo-form')
            {
                echo CActiveForm::validate($form);
                Yii::app()->end();
            }

            if(isset($_POST['SeoPath']))
            {
                $form->attributes = $_POST['SeoPath'];
//                var_dump($form->attributes);die();
                //表单验证
                if($form->validate())
                {
                    //验证通过的话，做更新数据处理
//                        $ret = $this->doSave($form->attributes);
                    $ret = $this->doSave($_POST['SeoPath']);
                    if( $ret === false){
                        $msg = Yii::t('app','Save failed!');
                    }else{
                        $msg = Yii::t('app','Saved successfully!');
                    }

                    Yii::app()->user->setFlash('result',$msg);

                    if( $type == 'add' ){
                        $this->redirect(array('add'));
                    }else{
                        //修改
                        $this->redirect(array('index'));
                    }
                }
            }
            //显示修改界面、并返回错误信息。
            $this->render('edit',
                    array('model'=>$form));
        }


        public function doSave($data)
        {
                if( empty($data['id']) ){
                    $model = new SeoPath();
                    $type = 'add';
                }else{
                    $model = SeoPath::getModelById($data['id']);
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
                    Yii::log($e->getMessage(), CLogger::LEVEL_ERROR );
                    return false;
                }
        }

        public function actionAdd()
        {
            $model = new SeoPath();
        
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('edit', [
                    'model' => $model,
                ]);
            }
        
//                $model = new SeoPath('add');
//                $this->render('edit',array(
//                    'model'=>$model,
//                    'items'=>array()
//                ));
        }

        //编辑内容
        public function actionUpdate()
        {
            $id = Yii::app()->request->getParam('id','');
            $form = SeoPath::getModelById($id);
            $this->render('edit',array(
                'model'=>$form,
            ));
        }
        
        public function actionDelete()
	{
            $id = Yii::app()->request->getParam('id','');
            $model = SeoPath::getModelById($id);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                //Save the model to the database
                $model->del = 1;
                if($model->save(false)){
                    SeoSetting::model()->updateAll(array('del'=>1),'del=0 and path_id=:path_id ',array(':path_id'=>$model->id));
                    $transaction->commit();
                }else{
                    Yii::log(CVarDumper::dumpAsString($model->getErrors() ), CLogger::LEVEL_ERROR );
                }
            } catch(Exception $e) {
                $transaction->rollback( );
                Yii::app( )->handleException( $e );
            }
        }
    
        public function getAllModules(){
            $modules = Yii::$app->modules ;
//            return array_keys($modules);
            $ret = array();
            $exceptionArr = array('gii','sitemap','backend','jxsuper');
            foreach( $modules as $module_id=>$v ){
                if( in_array($module_id,$exceptionArr) ){
                    continue;
                }
                $ret[$module_id] = $module_id;
            }
            return $ret;
        }
        
        
        //得到特定省份下的城市
        public function actionDynamicControllers(){
            $module_id = Yii::app()->request->getParam('module_id','');
            
            $options = SeoPath::getControllersByModule($module_id);
            if( empty($options) ){
                echo CHtml::tag('option',array('value'=>''),Yii::t('app','City'),true);
            }else{
                foreach($options as $key=>$value)
                {
                    echo CHtml::tag('option',array('value'=>$key),CHtml::encode($value),true);
                }
            }
        }
        
        //得到特定城市下的区/县
        public function actionDynamicActions(){
            $module_id = Yii::app()->request->getParam('module_id','');
            $controller_id = Yii::app()->request->getParam('controller_id','');
            
            $options =  SeoPath::getActions($controller_id, $module_id);
            if( empty($options) ){
                echo CHtml::tag('option',array('value'=>''),Yii::t('app','Area'),true);
            }else{
                foreach($options as $key=>$value)
                {
                    echo CHtml::tag('option',array('value'=>$key),CHtml::encode($value),true);
                }
            }
        }
}