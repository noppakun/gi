<?php
namespace app\modules\dbma\controllers;

use Yii;

use yii\data\ArrayDataProvider;

use kartik\builder\Form;
use yii\web\Response;
//use app\components\XNotify;

// use app\components\XExport;			
// $rows = $command->queryAll();  			
// XExport::x2xls($rows,$filename);



const GIPP190101 = 49;
const GIRD190501 = 51;
const GIPP190301 = 45;
const GIHR190601 = 53;
const GIRD190801 = 63;
const GIPD190801 = 64;
const GIRD200101 = 72;
const GIRD200201 = 73;
const GIRD200401 = 74;



class XqueryController extends \app\components\XQEdit\XQEditController
{
    protected $MAIN_MODEL         =   'app\models\XQuery';
    //protected $VIEWPATH         =   '@app/modules/dbma/views/xbooking/';


    private function xquery_view($queryid, $TOSPREADSHEET = false, $viewOptions = ['export_xls' => true])
    {
        return  $TOSPREADSHEET ? $this->tospreadsheet($queryid) : $this->queryview($queryid, $viewOptions);
    }
    // -----------------------------------------------------------------------------
    // -----------------------------------------------------------------------------
    // -----------------------------------------------------------------------------
    // **************************************************************************   
    public function actionV_packaging($TOSPREADSHEET = false)
    {
        return $this->xquery_view(GIRD200401, $TOSPREADSHEET);
    }      
    public function actionV_pm_use($TOSPREADSHEET = false)
    {
        return $this->xquery_view(GIRD200201, $TOSPREADSHEET);
    }      
    public function actionV_rm_use($TOSPREADSHEET = false)
    {
        return $this->xquery_view(GIRD200101, $TOSPREADSHEET);
    }   
    public function actionV_waste_tube($TOSPREADSHEET = false)
    {
        return $this->xquery_view(GIPD190801, $TOSPREADSHEET);
    }     
    public function actionV_packaging_tube($TOSPREADSHEET = false)
    {
        return $this->xquery_view(GIRD190801, $TOSPREADSHEET);
    }     
    public function actionV_parcel_list($TOSPREADSHEET = false)
    {
        return $this->xquery_view(GIHR190601, $TOSPREADSHEET, ['export_xls' => false]);
    }
    // **************************************************************************    
    public function actionV_slow_moving_items($TOSPREADSHEET = false)
    {
        return $this->xquery_view(GIPP190101, $TOSPREADSHEET);
    }
    // **************************************************************************    
    public function actionV_top50packaging_use($TOSPREADSHEET = false)
    {
        return $this->xquery_view(GIRD190501, $TOSPREADSHEET);
    }
    // **************************************************************************    
    public function actionV_prnotpo($TOSPREADSHEET = false)
    {
        return $this->xquery_view(GIPP190301, $TOSPREADSHEET); //            
    }
    // **************************************************************************    
    public function init()
    {

        $_count_on = false;
        $_count_on = true;
        parent::init();



        $this->VIEWPARA['XQEDIT']['update_columns'] = [
            'code',
            'description',
            'query' => [
                'type' => Form::INPUT_TEXTAREA,
                'options' => ['rows' => 15],
                'columnOptions' => ['colspan' => 3],
            ],
            'colsoption' => [
                'type' => Form::INPUT_TEXTAREA,
                'options' => ['rows' => 15],
                'columnOptions' => ['colspan' => 3],
            ],
            'tablenote' => [
                'label' => false,
                'type' => Form::INPUT_TEXTAREA,
                'options' => ['rows' => 15],
                'columnOptions' => [
                    'colspan' => 3,
                    'class' => "btn-info"
                ],
                'readonly' => true,

            ],


        ];
        $this->VIEWPARA['XQEDIT']['index_columns'] = [
            'code',
            [
                'attribute' => 'description',
                'value' => function ($model) { },
                'value' => function ($model) use ($_count_on) {
                    // if (rtrim($model->code)=='AC181101'){
                    //     $sql = $model->query;
                    //     $p = strpos($sql,'order by');
                    //     \app\components\XLib::xprint_r($sql);
                    //     if ($p){
                    //         $sql = substr($sql,0,$p);

                    //     }
                    //     echo '<br><br>';
                    //     //\app\components\XLib::xprint_r($command);
                    //     \app\components\XLib::xprint_r($sql);


                    // }

                    if (strpos($model->description, '#count') and ($_count_on)) {
                        $sql = $model->query;
                        $p = stripos($sql, 'order by');
                        if ($p) {
                            $sql = substr($sql, 0, $p);
                        }


                        $sql = 'select count(*) as reccount from (' . $sql . ') a';
                        $connection = \Yii::$app->erpdb;
                        $command = $connection->createCommand($sql);
                        //echo '<br><br>';
                        //\app\components\XLib::xprint_r($command);
                        $rows = $command->queryAll();

                        //    return  $rows[0]['reccount'];                        
                        // echo '----------------<br>';
                        // print_r($sql);
                        // echo '----------------<br>';
                        // return $model->code;

                        $count = ($rows[0]['reccount'] <> 0 ? ' <span class="label label-danger">' . $rows[0]['reccount'] . '</span>' : '');
                        return str_replace("#count", "<span class='badge'>#count</span>" . $count, $model->description);
                    } else {
                        return $model->description;
                    }
                    // return str_replace("#count","<span class='badge'>#count</span>",$model->description);
                },
                'format' => 'raw',
            ],

            // [                
            //     'label'=>'result',
            //     'value'=>function($model){                    
            //         if(strpos($model->description,'#count')){

            //             $sql = 'select count(*) as reccount from ('.$model->query.') a';
            //             $connection = \Yii::$app->erpdb;      
            //             $command = $connection->createCommand($sql);
            //             $rows = $command->queryAll();
            //             return  $rows[0]['reccount'];                        
            //             // echo '----------------<br>';
            //             // print_r($sql);
            //             // echo '----------------<br>';
            //             // return $model->code;
            //         }else{
            //             return '';
            //         }

            //     },
            //     'contentOptions' => 
            //     [
            //         'align' => 'right',               
            //     ],
            // ]

        ];
    }

    private function tospreadsheet($id)
    {
        //xnotify::notify('test','XTOSPREADSHEET');

        $model = $this->findModel($id);

        $sql = $model->query;
        $connection = \Yii::$app->db;
        $command = $connection->createCommand($sql);
        $rows = $command->queryAll();

        $filename = trim($model->code) . '.xls';
        $options = json_decode($model->colsoption, true);
        //print_r($option);
        \app\components\XExport::x2xls($rows, $filename, $options);
        (new Response())->sendFile($filename)->send();
        unlink($filename);
    }
    //---------------------------------------------
    private function queryview($id, $viewOptions = ['export_xls' => true])
    //---------------------------------------------
    {
        $model = $this->findModel($id);
        $options = json_decode($model->colsoption, true);

        $sql = $model->query;
        $connection = \Yii::$app->db;
        $command = $connection->createCommand($sql);
        $rows = $command->queryAll();


        if (!empty($rows)) {
            $searchAttributes = array_keys($rows[0]);
            $searchModel = [];
            $searchColumns = [];
            foreach ($searchAttributes as $searchAttribute) {
                $filterName = 'filter' . $searchAttribute;
                $filterValue = Yii::$app->request->getQueryParam($filterName, '');
                $searchModel[$searchAttribute] = $filterValue;
                $sc = [
                    'attribute' => $searchAttribute,
                    'filter' => '<input class="form-control" name="' . $filterName . '" value="' . $filterValue . '" type="text">',
                    'value' => $searchAttribute,
                ];
                if (isset($options["columns"][$searchAttribute]['DateFormat'])) {
                    $sc['format'] = ['date', $options["columns"][$searchAttribute]['DateFormat']];
                };
                if (isset($options["columns"][$searchAttribute]['NumberFormat'])) {
                    $f = $options["columns"][$searchAttribute]['NumberFormat'];
                    $sc['format'] = ['decimal', strpos($f, '.') ? strlen($f) - strpos($f, '.') - 1 : 0];
                    $sc['contentOptions'] = ['align' => 'right'];
                };

                $searchColumns[] = $sc;

                $rows = array_filter($rows, function ($row) use (&$filterValue, &$searchAttribute) {
                    return strlen($filterValue) > 0 ? stripos('/^' . strtolower($row[$searchAttribute]) . '/', strtolower($filterValue)) : true;
                });
            }
        } else {
            $searchAttributes = [];
            $searchModel = [];
            $searchColumns = [];
        }
        $dataProvider = new ArrayDataProvider([
            'allModels' => $rows,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort' => [
                'attributes' => $searchAttributes,
            ],
        ]);
        //return $this->renderPartial('viewexec', [
        return $this->render('viewexec', [
            'searchModel' => $searchModel,
            'searchColumns' => $searchColumns,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'id' => $id,
            'viewOptions' => $viewOptions,
        ]);
    }
    public function actionView($id, $TOSPREADSHEET = false)
    {
        //XNotify::notify('ทดสอบหัวข้อ', 'ทดสอบข้อความ');

        return  $TOSPREADSHEET ? $this->tospreadsheet($id) : $this->queryview($id);
    }
    // --------------------------------------------------------------------------------------------
    public function actionIndex()
    // --------------------------------------------------------------------------------------------
    {

        //        $this->layout = '/iframe'; 

        $SelectForm = new \app\models\SelectForm();
        if (isset(Yii::$app->request->queryParams['SelectForm'])) {
            $SelectForm->checkbox   = Yii::$app->request->queryParams['SelectForm']['checkbox'];
        } else {
            $SelectForm->checkbox   = 0;
        };
        $this->VIEWPARA['SelectForm'] = $SelectForm;

        $searchModel = new $this->SEARCH_MODEL();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->VIEWPARA['searchModel'] = $searchModel;
        $this->VIEWPARA['dataProvider'] = $dataProvider;
        return $this->render($this->VIEWPATH . 'index', $this->VIEWPARA);
    }
}
