<?php

namespace app\modules\dbma\controllers;

use Yii;
use \app\components\XLib;

use yii\helpers\ArrayHelper;


use kartik\builder\Form;
use kartik\datetime\DateTimePicker;

/**
 * XBookingController implements the CRUD actions for XBooking model.
 */
//class XbookingController extends \yii\web\Controller /* base class */


class XbookingController extends \app\components\XQEdit\XQEditController
{





    protected $MAIN_MODEL         =   'app\models\XBooking';
    protected $VIEWPATH         =   '@app/modules/dbma/views/xbooking/';
    //index_text_before

    // **************************************************************************************************************
    public function afterInsert($model)
    {

        $model->doc_no = $model->genDocNumber();
        $model->doc_date = Yii::$app->formatter->asDate('now');


        $session = Yii::$app->session;
        $sessionSelectForm = $session->get('sessionSelectForm');
        
        // $session->close();
        // $session->destroy();
         // \app\components\XLib::xprint_r($sessionSelectForm);

        if (isset($sessionSelectForm)){
            $d1 = XLib::dateConv(
                XLib::dateConv('01-' . $sessionSelectForm['month'] . '-' . $sessionSelectForm['year'], 'b'),
                'a'
            );                
            $model->track_id =  $sessionSelectForm['var1'];
        }else{
            $d1 = date('d-m-Y ');
            $model->track_id =  1;
        }

        $model->dt_start    = $d1 . ' 09:00';
        $model->dt_end      = $d1 . ' 10:00';

        $model->username = Yii::$app->user->identity->username;
        $model->status = 'N';
    }
    // **************************************************************************************************************        
    public function init()
    {
        parent::init();



        // $this->VIEWPARA['XQEDIT']['index_text_before'] =
        //     '<div class="row"><div class="col-md-6">'
        //     . $this->calendar()
        //     . '</div></div>';


        $this->VIEWPARA['XQEDIT']['update_columns'] = [
            'track_id' => [
                'label' => 'Track',
                'type' => Form::INPUT_DROPDOWN_LIST,
                //'type' => Form::INPUT_STATIC,
                'items' => ArrayHelper::map(\app\models\XBooking::$track_LIST, 'id', 'track_name'),
                'staticValue' => function ($model, $index, $widget) {
                    return (\app\models\XBooking::$track_LIST[$model->track_id]['track_name']);
                }
            ],
            'doc_no' => [
                'type' => Form::INPUT_STATIC,
            ],
            'doc_date' => [
                'type' => Form::INPUT_STATIC,
            ],

            'title',

            'dt_start' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => 'kartik\datetime\DateTimePicker',
                'options' => [
                    'removeButton' => false,
                    'pluginOptions' => [
                        'todayHighlight' => true,
                        'todayBtn' => true,
                        'autoclose' => true,
                        'format' => 'dd-mm-yyyy hh:ii',
                    ],
                ],
                'staticValue' => function ($model, $index, $widget) {
                    return XLib::datetimeConv($model->dt_start, 'a');
                }
            ],
            'dt_end' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => 'kartik\datetime\DateTimePicker',
                'name' => 'dt_end',
                'options' => [
                    //'bsVersion'=>4,                    
                    'removeButton' => false,
                    'pluginOptions' => [
                        'todayHighlight' => true,
                        'todayBtn' => true,
                        'autoclose' => true,
                        'format' => 'dd-mm-yyyy hh:ii',
                    ],
                ],
                'staticValue' => function ($model, $index, $widget) {
                    return XLib::datetimeConv($model->dt_end, 'a');
                }
            ],




            'remark' => [
                'type' => Form::INPUT_TEXTAREA,
            ],
            'username' => [

                'type' => Form::INPUT_STATIC,
            ],
            // 'status' => [
            //     'type' => Form::INPUT_STATIC,
            // ],


        ];
    }
    private function events($SelectForm)
    {
        $times = \app\models\XBooking::find()
            //->where('dt_start = 2')
            ->andFilterWhere([
                'track_id' => $SelectForm->var1,
                'year(dt_start)' => $SelectForm->year,
                'month(dt_start)' => $SelectForm->month,
            ])
            ->all();
        $events = [];
        foreach ($times as $time) {
            //Testing
            $Event = new \yii2fullcalendar\models\Event();
            $Event->id = $time->doc_no;
            $Event->title = $time->title;
            $Event->start   = XLib::dateTimeConv($time->dt_start, 'b');
            $Event->end     = XLib::dateTimeConv($time->dt_end, 'b');

            $Event->backgroundColor = (\app\models\XBooking::$track_LIST[$time->track_id]['track_color']);
            $events[] = $Event;
        }
        return $events;
    }
    // --------------------------------------------------------------------------------------------
    public function actionIndex()
    // --------------------------------------------------------------------------------------------
    {
        $SelectForm = new \app\models\SelectForm();


        if (isset(Yii::$app->request->queryParams['SelectForm'])) {
            $SelectForm->year       = Yii::$app->request->queryParams['SelectForm']['year'];
            $SelectForm->month      = Yii::$app->request->queryParams['SelectForm']['month'];
            $SelectForm->var1       = Yii::$app->request->queryParams['SelectForm']['var1'];
        } else {
            $SelectForm->year   = date("Y");
            $SelectForm->month  = date("n");
            $SelectForm->var1  = 1;
        };

        // $session = Yii::$app->session;
        // $sessionSelectForm = $session->get('sessionSelectForm');        

        // if (isset($sessionSelectForm)){
        //     $SelectForm->year       = $sessionSelectForm['year'];
        //     $SelectForm->month      = $sessionSelectForm['month'];
        //     $SelectForm->var1       = $sessionSelectForm['var1'];

        // }

        $searchModel = new $this->SEARCH_MODEL();


        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere([
            'track_id' => $SelectForm->var1,
            'year(dt_start)' => $SelectForm->year,
            'month(dt_start)' => $SelectForm->month,
        ]);

        $this->VIEWPARA['searchModel'] = $searchModel;
        $this->VIEWPARA['dataProvider'] = $dataProvider;



        $this->VIEWPARA['events'] = $this->events($SelectForm);
        $this->VIEWPARA['SelectForm'] = $SelectForm;

        

        $session = Yii::$app->session;
        $session['sessionSelectForm'] = $SelectForm;

        return $this->render($this->VIEWPATH . 'index', $this->VIEWPARA);
    }
}
