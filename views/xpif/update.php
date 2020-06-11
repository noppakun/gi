<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\builder\Form;
use kartik\tabs\TabsX;
use app\models\XPifAttachedfile;
use dosamigos\tinymce\TinyMce;
use yii\data\ActiveDataProvider;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $model app\models\Araptran */
 
$tablecaption = $TABLECAPTION;
$this->title = $tablecaption . (($model->isNewRecord)?'': ' : '. $model->pif_id); 
$this->params['breadcrumbs'][] = ['label' => $tablecaption, 'url' => ['index']];
$this->params['breadcrumbs'][] = (($model->isNewRecord) ? 'Create' : (($viewmode) ? 'View':'Update'));

$staticOnly = true;
$staticOnly = $viewmode;
 

?>
 

<div class="etable-update">
    <div class="etable-form">
        <div class="panel  panel-primary">
            <div class="panel-heading"><?=$this->title?>
                <div class="pull-right">

                    <?php
                    $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]);
                    if ( !$viewmode) {
                        echo Form::widget([
                            'model'=>$model,
                            'form'=>$form,
                            'columns'=>2,
                            'staticOnly'=>$staticOnly,
                            'attributes'=>[
                                'actions'=>['type'=>Form::INPUT_RAW, 'value'=>Html::submitButton('Save', ['class'=>'btn btn-success btn-xs'])],
                                
                            ],
                        ]);    
                        }
                    ?>
                </div>
            </div>


            <div class="panel-body">
            <?php
                // ***AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
              
                
 

                echo Form::widget([
                    'model'=>$model,
                    'form'=>$form,
                    'columns'=>12,
                    'staticOnly'=>$staticOnly,
                    'attributes'=>[
                        'pif_id'=>[
                            'type'=>Form::INPUT_TEXT,
                            'columnOptions'=>['colspan'=>2],  
                        ],
                        'items_ref'=>[
                            'type'=>Form::INPUT_TEXT,          
                            'columnOptions'=>['colspan'=>3],            
                        ],                         
                        'pif_name'=>[
                            'type'=>Form::INPUT_TEXT,          
                            'columnOptions'=>['colspan'=>5],            
                        ],                        
                        'actions' => (!$model->isNewRecord) && (!$viewmode)? [
                            'type'=>Form::INPUT_RAW, 
                            'value'=>Html::a('Attached files' ,
                                ['xpif/createattached','idh'=>$model->id],
                                ['class' => 'btn btn-primary'])
                        ]:null,
                    ],
                ]);
                echo '<hr/>';
                echo Form::widget([
                    'model'=>$model,
                    'form'=>$form,
                    //'columns'=>6,
                    'staticOnly'=>$staticOnly,
                    'attributes'=>[
                            
            
                        'description'=>[                    
                            'label'=>false,
                            'type'=>Form::INPUT_WIDGET,                              
                            'widgetClass'=>'\dosamigos\tinymce\TinyMce',                    
                            'options' => [
                                'options' => ['rows' => 50],

                                'clientOptions' => [                            
        
                                    'plugins' => [
                                        "advlist autolink lists link charmap print preview anchor",
                                        "searchreplace visualblocks code fullscreen",
                                        "insertdatetime media table contextmenu paste",
                                        "pagebreak",
                                        "image imagetools",
                                        
                                    ],
                                    'toolbar' => "fontselect | fontsizeselect | undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",                                                                                                          
                                    //'fontsize_formats' => "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
                                    //'font_formats'=>"Arial=arial,helvetica,sans-serif;Courier New=courier new,courier,monospace;AkrutiKndPadmini=Akpdmi-n",
                                    // 'file_browser_callback'=> new yii\web\JsExpression("function(field_name, url, type, win) {
                                    //     win.document.getElementById(field_name).value = 'my browser value';
                                    // }"),
                                    // 'file_browser_callback_types'=> 'file image media',
                                    // 'file_picker_types'=> 'file image media',
                                    // 'file_picker_callback'=> new yii\web\JsExpression("function(callback, value, meta) {
                                    //     // Provide file and text for the link dialog
                                    //     if (meta.filetype == 'file') {
                                    //     callback('mypage.html', {text: 'My text'});
                                    //     }
                                    
                                    //     // Provide image and alt text for the image dialog
                                    //     if (meta.filetype == 'image') {
                                    //     callback('myimage.jpg', {alt: 'My alt text'});
                                    //     }
                                    
                                    //     // Provide alternative source and posted for the media dialog
                                    //     if (meta.filetype == 'media') {
                                    //     callback('movie.mp4', {source2: 'alt.ogg', poster: 'image.jpg'});
                                    //     }
                                    // }"),
                                    // 'images_upload_url'=> 'postAcceptor.php',
                                    // 'automatic_uploads'=> false,

            
                                ]    
                            ],    
                        ],                                    
                    ],
            ]);

                
            
                // ***BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB
                ActiveForm::end();    
            ?>
            </div>
        </div>




 
 <?php 
if($viewmode){

    // $query = XPifAttachedfile::find()->andWhere(['master_id' => $model->id])->orderby('filegroup,description');
    // $modelattachedlist = new ActiveDataProvider([
    //     'query' => $query,
    // ]);   



    $modelattachedlist = new ActiveDataProvider([
        'query' => $model->getXPifAttachedfiles()->orderby('filegroup,description'),
    ]);
 
    echo GridView::widget([
        'dataProvider' => $modelattachedlist,            
        'responsiveWrap' => false,        
        'columns'=>[
            [
                'attribute'=>'description',
                'label'=>'Attached Files',
                'content'=>function($model, $key, $index, $column){                        
                    return Html::a(
                        $model->description,
                        [Yii::$app->controller->id.'/viewattached',
                            'id' => $model->id,
                            'idh' => $model->master_id]);
                }
            ],
        ]
    ]);
}
if((!$model->isNewRecord) && (!$viewmode)){
    echo Html::a('Approve', 
    [
        'xpif/approve',    
        'id'=>$model->id,
    ],
    [
        'class' => 'btn btn-primary',  
    ]); 
}
?>


    </div>
</div>
