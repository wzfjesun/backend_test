<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Poststatus;
use yii\helpers\ArrayHelper;
use common\models\common\models;
use common\models\SeoPath;


/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="m-b-md">
    <h3 class="m-b-none">
        <?php if(empty($model->id))
            echo Yii::t('app','新建');
        else{
            echo Yii::t('app','编辑');
        }?>
        <span class="pull-right">
            <a class="btn btn-primary" href="<?php echo Url::to('index');?>">
                <i class="fa fa-backward"></i> <?php echo Yii::t('app','BACK'); ?>
            </a>
        </span>
    </h3>
</div>
<div class="row">
    <div class="col-sm-12">
        <?php //CommonFunc::showUserFlashMsg(); ?>
        <?php   $form = ActiveForm::begin([
                    'id'=>'login-form',//基本配置
                    'action'=>['article/add'],  
                    'method'=>'post',
                    'options'=>[
                        'class'=>'login-form',
                        'enctype'=>'multipart/form-data',
                    ],
                ]); ?>
        <?php //echo $form->hiddenField($model,'id'); ?>
        <fieldset>
            <?= $form->field($model,'module_id')
//                ->dropDownList(Poststatus::find()
//						->select(['name','id'])
//						->orderBy('position')
//						->indexBy('id')
//						->column(),
                ->dropDownList(['0'   =>'足球','1'  =>'篮球','2'  =>'羽毛球']);
        
        
        
            $modules = $this->context->getAllModules();
            var_dump($modules);
            
                
                
            ?>
            
            <?= $form->field($model,'controller_id')
//                ->dropDownList(Poststatus::find()
//						->select(['name','id'])
//						->orderBy('position')
//						->indexBy('id')
//						->column(),
                ->dropDownList(['0'   =>'足球','1'  =>'篮球','2'  =>'羽毛球']);
            
            $controllers = SeoPath::getControllersByModule($model->module_id);
            var_dump($controllers);       
            ?>
            
            <?= $form->field($model,'action_id')
//                ->dropDownList(Poststatus::find()
//						->select(['name','id'])
//						->orderBy('position')
//						->indexBy('id')
//						->column(),
                ->dropDownList(['0'   =>'足球','1'  =>'篮球','2'  =>'羽毛球']);
            ?>
            
            
        <?php

//            echo $form->dropDownListControlGroup($model,'module_id', $this->getAllModules(),array(
//                'empty'=>Yii::t('app','不选择module'),  
//                'ajax'=>array(
//                    'url'=>$this->createUrl('dynamicControllers'),
//                    'data'=>array('module_id'=>'js:this.value'),
//                    'update'=>'#SeoPath_controller_id',
//                    'success'=>'function(data) { $(\'#SeoPath_controller_id\').html(data);$(\'#SeoPath_controller_id\').change();}'
//                ),
//                'labelOptions' => array(
//                    'class' => 'col-lg-2'
//                ),
//                'controlOptions' => array(
//                    'class' => 'col-lg-4'
//                ),
//                'groupOptions' => array(
//                    'class' => 'col-lg-12'
//                )
//            ));
//            echo $form->dropDownListControlGroup($model,'controller_id', SeoPath::getControllersByModule($model->module_id),array(
////                echo $form->dropDownListControlGroup($model,'controller_id', array(),array(
//                'empty'=>Yii::t('app','请选择controller'),  
//                'ajax'=>array(
//                    'url'=>$this->createUrl('dynamicActions'),
//                    'data'=>array('controller_id'=>'js:this.value'),
//                    'update'=>'#SeoPath_action_id',
////                        'success'=>'function(data) { $(\'#MailingAddressForm_area_id\').html(data);$(\'#MailingAddressForm_area_id\').change();}'
//                ),
//                'labelOptions' => array(
//                    'class' => 'col-lg-2'
//                ),
//                'controlOptions' => array(
//                    'class' => 'col-lg-4'
//                ),
//                'groupOptions' => array(
//                    'class' => 'col-lg-12'
//                )
//            ));
//            echo $form->dropDownListControlGroup($model,'action_id', SeoPath::getActions($model->controller_id, $model->module_id),array(
////                echo $form->dropDownListControlGroup($model,'action_id', array(),array(
//                'empty'=>Yii::t('app','请选择action'),
//                'labelOptions' => array(
//                    'class' => 'col-lg-2'
//                ),
//                'controlOptions' => array(
//                    'class' => 'col-lg-4'
//                ),
//                'groupOptions' => array(
//                    'class' => 'col-lg-12'
//                )
//            ));

          ?>
          <div style="clear:both"></div>
          <div class="col-lg-6 col-sm-offset-2">
              <?php
//                  echo BsHtml::formActions(array(
//                      BsHtml::submitButton(Yii::t('app','保存'), array(
//                          'id'=>'btn-submit',
//                          'color' => BsHtml::BUTTON_COLOR_PRIMARY,
//                      ))
//                  ));
              ?>
              
              <?php echo Html::submitButton('保存',['class'=>'btn green pull-right']);?>
          </div>   
        </fieldset>
        <?php ActiveForm::end(); ?>
    </div>
</div>