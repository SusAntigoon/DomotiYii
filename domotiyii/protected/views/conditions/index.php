<?php
/* @var $this ConditionsController */
/* @var $dataProvider CActiveDataProvider */

$this->widget('bootstrap.widgets.TbBreadcrumb', array(
    'links' => array(
        Yii::t('translate','Conditions'),
    ),
));

$this->beginWidget('zii.widgets.CPortlet', array(
        'htmlOptions'=>array(
                'class'=>''
        )
));
$this->widget('bootstrap.widgets.TbNav', array(
        'type'=>TbHtml::NAV_TYPE_PILLS,
        'items'=>array(
                array('label'=>Yii::t('translate','Create'), 'icon'=>'icon-plus', 'url'=>Yii::app()->controller->createUrl('create'), 'linkOptions'=>array()),
                array('label'=>Yii::t('translate','List'), 'icon'=>'icon-th-list', 'url'=>Yii::app()->controller->createUrl('index'),'active'=>true, 'linkOptions'=>array()),
                array('label'=>Yii::t('translate','Search'), 'icon'=>'icon-search', 'url'=>'#', 'linkOptions'=>array('class'=>'search-button')),
        ),
));
$this->endWidget();

$this->widget('domotiyii.LiveGridView', array(
    'id'=>'all-conditions-grid',
    'refreshTime'=>Yii::app()->params['refreshConditions'], // x second refresh as defined in config
    'type'=>'striped condensed',
    'dataProvider'=>$model->getConditions(true),
    'template'=>'{items}{pager}',
    'columns'=>array(
        array('name'=>'id', 'header'=>'#', 'htmlOptions'=>array('width'=>'20')),
        array('name'=>'name', 'header'=>Yii::t('translate','Name'), 'htmlOptions'=>array('width'=>'150')),
        array('name'=>'description', 'header'=>Yii::t('translate','Description'), 'htmlOptions'=>array('width'=>'100')),
        array('name'=>'formula', 'header'=>Yii::t('translate','Formula'), 'htmlOptions'=>array('width'=>'150')),
        array('class'=>'bootstrap.widgets.TbButtonColumn',
           'template'=> Yii::app()->user->isGuest ? '{view}' : '{view}{update}{delete}',
           'header'=>Yii::t('translate','Actions'),
           'htmlOptions'=>array('style'=>'width: 40px'),
           'buttons'=>array(
              'view' => array(
                 'label'=>Yii::t('translate','View condition'),
                 'url'=>'Yii::app()->controller->createUrl("view", array("id"=>$data["id"]))',
              ),
              'update' => array(
                 'label'=>Yii::t('translate','Edit condition'),
                 'url'=>'Yii::app()->controller->createUrl("update", array("id"=>$data["id"]))',
              ),
              'delete' => array(
                 'label'=>Yii::t('translate','Delete condition'),
                 'url'=>'Yii::app()->controller->createUrl("delete", array("id"=>$data["id"],"command"=>"delete"))',
              ),
           ),
        ),
    ),
));
?>