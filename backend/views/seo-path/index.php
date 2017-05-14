<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
?>
<div class="m-b-md">
    <h3 class="m-b-none">
        <?php echo Yii::t('app','seo 页面管理'); ?>
        <span class="pull-right">
            <a class="btn btn-primary" href="<?php echo Url::to('add');?>">
                <i class="fa fa-plus-circle"></i> <?php echo Yii::t('app','CREATE'); ?>
            </a>
            
            <?= Html::a('创建文章', ['add'], ['class' => 'btn btn-success']) ?>
            
        </span>
    </h3>
</div>
<div class="row">
    <div class="col-sm-12">
        <?php //CommonFunc::showUserFlashMsg(); ?>
        
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
               // ['class' => 'yii\grid\SerialColumn'],

                //'id',
                ['attribute'=>'id',
                'contentOptions'=>['width'=>'30px'],
                ],
                'controller_id',
                'action_id',
                    //'author_id',


                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
        
        
        <?php 
//            $this->widget('bootstrap.widgets.BsGridView', array(
//                'id'=>'link-grid',
//                'type' => BsHtml::GRID_TYPE_STRIPED,
//                'dataProvider'=>$dataProvider,
//                'emptyText' => Yii::t('app','It\'s empty!'),
//                'template' => '{items}{pager}',
//                'dataProvider'=>$dataProvider,
//                'htmlOptions'=>array(
//                    'class'=>'b-t b-light'  
//                ),
//                'pagerCssClass' => 'pagination pull-right',
//                'enablePagination' => true,
//                'pager' => array(
//                    'class' => 'bootstrap.widgets.BsPager',
//                    'maxButtonCount' => '10'
//                ),
//                'columns'=>array(
//                        array(
//                            'name'=>'module_id',
//                            'type' => 'raw',
//                            'value'=>'$data->module_id',
//                            'headerHtmlOptions' => array(
//                                'style'=>'text-align:left;white-space: nowrap',
//                                ),
//                            'htmlOptions'=>array(
//                                'style'=>'text-align:left;white-space: nowrap',
//                            ),
//                        ),
//                        array(
//                            'name'=>'controller_id',
//                            'type' => 'raw',
//                            'value'=>'$data->controller_id',
//                            'headerHtmlOptions' => array(
//                                'style'=>'text-align:left;white-space: nowrap',
//                                ),
//                            'htmlOptions'=>array(
//                                'style'=>'text-align:left;white-space: nowrap',
//                            ),
//                        ),
//                        array(
//                            'name'=>'action_id',
//                            'type' => 'raw',
//                            'value'=>'$data->action_id',
//                            'headerHtmlOptions' => array(
//                                'style'=>'text-align:left;white-space: nowrap',
//                                ),
//                            'htmlOptions'=>array(
//                                'style'=>'text-align:left;white-space: nowrap',
//                            ),
//                        ),
//                        array(
//                            'name'=>'create_time',
//                            'type' => 'raw',
//                            'value'=>'$data->create_time',
//                            'headerHtmlOptions' => array(
//                                'style'=>'text-align:left;white-space: nowrap',
//                                ),
//                            'htmlOptions'=>array(
//                                'style'=>'text-align:left;white-space: nowrap',
//                            ),
//                        ),
//                        array(
//                            'header'=>Yii::t('app','Option'),
//                            'class'=>'CButtonColumn',
//                            'template'=>'{update}{delete}',
//                            'deleteConfirmation' => "js:'" . Yii::t('app', '确定删除此数据和此相关的seo信息吗？') . "'",
//                            'buttons' => array(
//                            ),
//                            'headerHtmlOptions' => array(
//                                'style'=>'text-align:left;white-space: nowrap',
//                                ),
//                            'htmlOptions'=>array(
//                                'style'=>'text-align:left;white-space: nowrap',
//                            ),
//                        ),
//                ),
//            )); 
        ?>
    </div>
</div>