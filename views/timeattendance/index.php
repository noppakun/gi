<?php

use yii\helpers\Html;
use yii\data\ArrayDataProvider;
use yii\bootstrap\ActiveForm;
use kartik\grid\GridView;
use app\widgets\ddlMonth;
use app\widgets\ddlYear;
use app\models\Depart;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$dep = '';
foreach ($DeptList as $row) {
    //\app\components\XLib::xprint_r($row['DeptName']);
    $dep .= ' ,' . $row['DeptName'];
    //print_r(explode('/', $row, 1));
    //print_r($row);
}
$dep = ' ( ' . substr($dep, 2) . ' )';


$this->title = 'Time Attendance';
$this->params['breadcrumbs'][] = $this->title . $dep;
//$DeptList



//  AAAAAAAAAAAAAAAAAAAAAAAAAAAA      select form
$form = ActiveForm::begin([
    'method' => 'get',
    'layout' => 'horizontal',
    'options' => [
        'class' => 'well',
    ],
]);
?>

<div class="row">
    <div class="col-md-4">
        <?= ddlYear::widget([
            'form' => $form, 'model' => $SelectForm, 'field' => 'year',
            'options'       => ['onchange' => 'this.form.submit()'],
        ]);   ?>
    </div>
    <div class="col-md-4">
        <?= ddlMonth::widget([
            'form' => $form, 'model' => $SelectForm, 'field' => 'month',
            'options'       => ['onchange' => 'this.form.submit()'],
        ]);    ?>
    </div>
    <!-- <div class="col-md-4  text-right">
        <?= Html::submitButton('Process', ['class' => 'btn btn-primary']); ?>
    </div> -->

</div>
<?php
$form::end();
//  BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBb     select form    
function timelogColumn($r)
{
    return [
        'attribute' => $r,
        'label' => $r == 'r1' ? 'เข้า' : ($r == 'r2' ? 'กลางวัน' : 'เย็น'),
        'width' => '100px',
        'format' => ['time'],
        'content' => function ($model) use ($r) {

            return ($model[$r] == null) ? '--:--' : Yii::$app->formatter->asTime($model[$r]);
        },
        'hAlign' => 'center',

        'contentOptions' => function ($model) use ($r) {


            return
                // issue from query
                (substr($model[$r], 7, 1) == '1')

                // check sunday
                || (($model[$r] == null)    and (date("w", strtotime($model['cdate'])) <> 0))

                // check // holiday
                && ($model['calendardesc'] == null)

                ? ['style' => 'color:red'] : [];
        }
    ];
}
?>


<div class="timeattendance-index">


    <?php
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,        
        'responsiveWrap' => false,
        'columns' => [
            [
                'header' => 'Time',
                'class' => 'kartik\grid\ExpandRowColumn',
                //'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'detail' => function ($model, $key, $index, $column) use ($SelectForm) {
                    $em_code = $model['EmployeeCode'];
                    $sql = "exec xeHrTimeLogs :year1,:month1,:em_code";
                    $connection = \Yii::$app->erpdb;
                    $command = $connection->createCommand($sql);
                    $command->bindParam(":year1", $SelectForm->year);
                    $command->bindParam(":month1", $SelectForm->month);
                    $command->bindParam(":em_code", $em_code);
                    $rows =  $command->queryAll();
                    $dataProvider = new ArrayDataProvider([
                        'allModels' => $rows,
                        'pagination' => [
                            'pageSize' => 31,
                        ],
                    ]);
                    // ----------------------------------------------------------
                    // $sql2 = "
                    // declare @month1 int 
                    // declare @year1 int
                    // declare @em_code varchar(10)

                    // set @month1 = 4
                    // set @year1 = 2019
                    // set @em_code='110013'

                    //     set @month1 = :month1
                    //     set @year1 = :year1
                    //     set @em_code = :em_code



                    // Select 
                    //     -- B.EmployeeCode,
                    //     cast(b.DateRecord as date)  as cdate 
                    //     ,cast (b.TimeRecord AS time) as timerec		
                    // From  EmployeeTransaction B
                    // where (year(b.DateRecord)=@year1 and month(b.DateRecord)=@month1)				 
                    // and b.EmployeeCode=@em_code
                    // order by b.DateRecord,b.TimeRecord				

                    // ";
                    // $connection = \Yii::$app->erpdb;
                    // $command = $connection->createCommand($sql2);
                    // $command->bindParam(":year1", $SelectForm->year);
                    // $command->bindParam(":month1", $SelectForm->month);
                    // $command->bindParam(":em_code", $em_code);
                    // $rawrecs =  $command->queryAll();                         



                    return Yii::$app->controller->renderPartial('detail', [
                        'dataProvider'  =>  $dataProvider,
                        'SelectForm' => $SelectForm,
                        //'rawrecs' =>   $rawrecs,
                    ]);
                },
                //'headerOptions'=>['class'=>'kartik-sheet-style'], 
                'expandOneOnly' => true,

            ],
            [
                'attribute' => 'EmployeeCode',
                'width' => '100px',
            ],
            
            
            // [
            //     'attribute' => 'EmployeeCode',
            //     'content' => function ($model, $key, $index, $column) {
            //         //return Html::a($model->doc_no, ['update', 'id' => $model->id]);
            //         return Html::a($model->EmployeeCode, ['view', 'emcode' => $model->EmployeeCode]);
            //     }
            // ],

            'FirstName_Thai',
            'LastName_Thai',

            [
                'attribute' => 'DeptCode',
                'label'=>'แผนก',                
                'filter' => ArrayHelper::map(
                    $DeptList,
                    'DeptCode',
                    'DeptName'
                ),
                'content' => function ($model, $key, $index, $column) {
                    //return Html::a($model->doc_no, ['update', 'id' => $model->id]);
                    return $model->depart->DeptName.($model->SectionCode == null ?'':' / ').$model->SectionCode;
                }

            ],


            //'depart.DeptName',            
            'employeePosition.EmployeePositionName',
            //'EmployeeStatus',
            // [
            //     'attribute' => 'EmployeePosition',
            //     'content' => function ($model, $key, $index, $column) {
            //         //return Html::a($model->doc_no, ['update', 'id' => $model->id]);
            //         return $model->employeePosition->EmployeePositionName;
            //     }
            // ],


            //'EmployeeStatus'
        ]

    ]); ?>


</div>