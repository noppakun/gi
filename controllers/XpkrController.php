<?php

namespace app\controllers;

use Yii;

use yii\data\ActiveDataProvider;
use app\models\XPkr;
use app\models\XPkrD;
//class XfdaregisterController extends \app\components\XETableController

//class XpdrController extends \app\components\XQEdit\XQEditController
class XpkrController extends XpdrController
{
    protected $MAIN_MODEL         =   'app\models\XPkr';
    protected $SEARCH_MODEL     =   'app\models\XPkrSearch';
    protected $VIEWPARA      =   [
        'TABLECAPTION' =>  'ใบแจ้งความต้องการบรรจุภัณฑ์'
    ];
    protected $IMAGE_PATH      =   'images/xpkr/';
    // --------------------------
    // ------------------------------------------------- detail -----------------------------------------------------
    // ------------------------------------------------- detail -----------------------------------------------------
    // ------------------------------------------------- detail -----------------------------------------------------
    public function actionCreate_detail($idh)
    { //actionCreate
        return $this->actionUpdate_detail(null, $idh);
    }
    public function actionUpdate_detail($id = null, $idh, $viewmode = false)
    {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;

        if ($id == null) { // create
            $model = new XPkrD();
            //$model->Doc_No = $idh;
            $model->pkr_id = $idh;
            $model->owner = 'G';
        } else {
            //$model = XPkrD::findOne($id);            
            $model = XPkrD::findOne(['id' => $id]);
        }

        if ($model->load(Yii::$app->request->post())) {

            //$page = isset($_GET['page'])?$_GET['page']:1;                      


            $model->save();


            //echo '<br><br><br<br><br><br>cc11cccccccccc : ';
            //echo $page;
            return $this->redirect(['create_detail', 'idh' => $idh, 'page' => $page]);
        } else {


            $query = XPkrD::find()->andFilterWhere(['pkr_id' => $idh]);

            //$query = QuotationD::find()->andFilterWhere(['Doc_No' => $idh]);

            $modeld = new ActiveDataProvider([
                'query' => $query,
            ]);



            // $modeld2 = QuotationD::find()->andFilterWhere(['Doc_No' => $idh])->asArray()->all();
            // $key = array_search($id, array_column($modeld2, 'seq'));
            // echo '<br><br><br>------';
            // echo $key ;
            // echo '<pre>';
            // print_r($modeld2);
            // echo '</pre>';

            $this->VIEWPARA['modelh'] = $this->findModel($idh);
            $this->VIEWPARA['model'] = $model;
            $this->VIEWPARA['modeld'] = $modeld;
            $this->VIEWPARA['viewmode'] = $viewmode;
            $this->VIEWPARA['page'] = $page;
            return $this->render($this->VIEWPATH . 'update_pkr_detail', $this->VIEWPARA);
        }
    }
    public function actionDelete_detail($id, $idh)
    {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $model = XPkrD::findOne(['id' => $id]);
        $model->delete();
        return $this->redirect(['create_detail', 'idh' => $idh, 'page' => $page]);
    }
    public function actionPrint($id = null)
    {
        $model = XPkr::findOne($id);
        // เปรียบเทียบกับตัวเอง
        if (substr($model->doc_no, 10, 1) <> 'R') {
            $modelCompare = $model;
            $modelXPkrD = null;
            // เปรียบเทียบกับตัวล่าสุด
        } else {
            $pre_no = substr($model->doc_no, 11) - 1;
            $pre_docno = substr($model->doc_no, 0, 10)
                . ($pre_no == 0 ? '' : 'R' . $pre_no);
            $modelCompare = XPkr::find()
                ->where('doc_no = :doc_no', [':doc_no' => ($pre_docno)])->one();
            // ถ้าตัวก่อนหน้านี้ไม่มี ให้ เปรียบเทียบกับตัวเอง
            if (!$modelCompare) {
                $modelCompare = $model;
                $modelXPkrD = null;
            } else {
                $modelXPkrD = XPkrD::find()
                    ->where('pkr_id = :pkr_id', [':pkr_id' => ($modelCompare->id)])->asArray()->all();
            }
        }
        //\app\components\XLib::xprint_r($modelXPkrD); 
        //$$modelXPkrD
        $rowCompareD = [];
        if ($modelXPkrD !== null) {
            foreach ($modelXPkrD as $row) {
                $rowCompareD[] = rtrim($row['item'])
                    . '|' . rtrim($row['material'])
                    . '|' . rtrim($row['owner'])
                    . '|' . rtrim($row['remark']);
            }
        }

        $params = [
            'IMAGE_PATH' => $this->IMAGE_PATH,
            'modelCompare' => $modelCompare,
            'rowCompareD' => $rowCompareD,
            // 'WatermarkText'=>'revised'
        ];
        $form = new _XPrintForm($model, [], $params);
        //\app\components\XLib::xprint_r($rowCompareD); 
        //\app\components\XLib::xprint_r($rowCompareD[0]);
        return $form->print();
    }
}

use yii\helpers\Html;


class _XPrintForm extends \app\components\XPrintForm
{
    // public $modelArray;
    // public function __construct($model, $rows = [])
    // {
    //     parent::__construct($model, $rows); 
    //     //$this::parent;        

    // }

    private function cbImg($check)
    {
        return Html::img(($check ? 'images/icons8-checked-checkbox-50.png' : 'images/icons8-unchecked-checkbox-50.png'), ['width' => '20']);
    }
    // tc = textCompare
    private function tc($_text, $same = true)
    {
        // if (\Yii::$app->user->identity->username !== 'noppakun') {
        //     return $_text;
        // }
        return (!$same) ? '<font color="red">' . $_text . '</font>' : $_text;
    }
    private function renderPageDetail_Table()
    {
        $_styleH = 'padding-left: 5px;border:1px solid gray;';
        $_styleD = 'padding-left: 5px;border-left: 1px solid gray;';


        $rowds = $this->model->d;
        $_dr = '';



        foreach ($rowds as $row) {
            if ($this->rowCompareD == null) {
                $same = true;
            } else {
                $same = (array_search(rtrim($row->item)
                    . '|' . rtrim($row->material)
                    . '|' . rtrim($row->owner)
                    . '|' . rtrim($row->remark), $this->rowCompareD) !== false);
            }


            $_dr .= $this->tr(
                [
                    [
                        $this->tc($row->item, $same), ['style' => $_styleD . ' border-left: none']
                    ],
                    [
                        $this->tc($row->material, $same), ['style' => $_styleD]


                        // $row->item
                        // .'|'.$row->material
                        // .'|'.$row->owner
                        // .'|'.$row->remark                        
                        // , ['style' => $_styleD]
                    ],
                    [
                        $this->tc($row->owner == 'G' ? 'GPM' : 'Customer', $same), ['style' => $_styleD]
                    ],
                    [
                        $this->tc($row->remark, $same), ['style' => $_styleD]
                    ]
                ]
                //,['bgcolor'=>"#5D7B9D"]
                ,
                ["style" => "bgcolor:red;"]
            );
        }

        return Html::tag(
            'table',
            Html::tag(
                'tr',
                Html::tag('th', 'ITEM', ['style' => $_styleH, 'width' => '40%'])
                    . Html::tag('th', 'Material', ['style' => $_styleH])
                    . Html::tag('th', 'OWNER', ['style' => $_styleH])
                    . Html::tag('th', 'หมายเหตุ', ['style' => $_styleH, 'width' => '40%'])
            ) . $_dr,
            ['width' => '100%', 'style' => ' border: 1px solid gray;']
        );
    }
    public function renderPageDetail($rows)
    {

        $_header = parent::tr([['<br>']])
            . $this->tr([
                [
                    Html::tag('h3', 'ใบแจ้งความต้องการบรรจุภัณฑ์<br>( Packaging Requirements )'),
                    [
                        'style' => 'text-align: center',
                        'colspan' => "2"
                    ]
                ]
            ])
            . $this->tr([['<br>']]);
        $content2 = $_header .
            $this->tr([
                [$this->dl('cust_name')],
                [$this->dl('doc_no', false, false, false), ['style' => 'text-align: right']]
            ])
            . $this->tr([[$this->dl('product_name')]])
            . $this->tr([
                [$this->dl('product_cat', true) . ' : ' .  \app\models\xpkr::$product_cat_LIST[$this->model->product_cat]
                    . ($this->model->product_cat == '9' ? '  ' . $this->model->product_cat_other : '')]
            ])
            . $this->tr([
                [$this->dl('bulk', true) . ' : ' .  \app\models\xpkr::$bulk_LIST[$this->model->bulk]],
                [$this->dl('bulk_note')],
            ])
            . $this->tr([[$this->dl('benchmark'), ['colspan' => '2', 'width' => '100%']]])
            . $this->tr([[$this->dl('target_group'), ['colspan' => '2', 'width' => '100%']]])
            . $this->tr([
                [$this->dl('size_text')],
                [$this->dl('order_text')]
            ])
            // . $this->tr(
            //     [[
            //         Html::tag(
            //             'table',
            //             $this->tr([
            //                 [$this->dl('size', false, 0) . ' ' . \app\models\xpkr::$size_unit_LIST[$this->model->size_unit]],
            //                 [$this->dl('first_order', false, 0) . ' ' .  \app\models\xpkr::$order_unit_LIST[$this->model->order_unit]],
            //                 // RD ไม่เอา
            //                 // [$this->dl('total_order', false, 0) . ' ' .  \app\models\xpkr::$order_unit_LIST[$this->model->order_unit]],
            //             ]),
            //             [
            //                 'width' => '100%',
            //             ]
            //         ), ['colspan' => '2']
            //     ]]
            // )

            . $this->tr([[
                Html::tag('h4', 'รายละเอียดบรรจุภัณฑ์'),
                [
                    'colspan' => '2',
                    'style' => 'text-align: center',
                    'width' => '100%'
                ]
            ]])
            . $this->tr([[$this->dl('artwork_design', true) . ' : ' . \app\models\xpkr::$artwork_design_LIST[$this->model->artwork_design]]])

            . $this->tr(
                [[
                    Html::tag(
                        'table',
                        $this->tr([
                            ['รายละเอียดอื่นๆ(ถ้ามี)', ['width' => '20%']],
                            //                        ['cccc' . '  ' . $this->dl('other_detail_picture', true)],
                            [$this->cbImg($this->model->other_detail_picture), ['style' => 'text-align: right']],
                            [$this->dl('other_detail_picture', true)],
                            [$this->cbImg($this->model->other_detail_sample), ['style' => 'text-align: right']],
                            [$this->dl('other_detail_sample', true)],
                            [$this->cbImg($this->model->other_detail_other), ['style' => 'text-align: right']],
                            [$this->dl('other_detail_other', true)],
                            //['']
                        ]),
                        [
                            'width' => '100%',
                        ]
                    ), ['colspan' => '2']
                ]]
            )
            . $this->tr(
                [[
                    $this->renderPageDetail_Table(), ['colspan' => '2']
                ]]
            )

            . $this->tr([[$this->dl('other_detail_other_text'), ['colspan' => '2']]])
            
            . $this->tr([
                [$this->dl('present_req_date')],
                [$this->dl('price_req_date')]
            ])
            . $this->tr([['<br>', ['style' => 'border-top:1pt solid', 'colspan' => '2']]])
            . $this->tr(
                [
                    [
                        'ผู้แจ้ง : ' . $this->model->user_inform . '<br>' . $this->model->doc_date . '<br>Customer / BD',
                        ['style' => 'text-align: center', 'width' => '50%']
                    ],
                    [
                        'ผู้อนุมัติ : ' . $this->model->user_approve . '<br>' . $this->model->user_approve_date . '<br>BD Manager',
                        [
                            'style' => 'text-align: center', 'width' => '50%'
                        ],

                    ],
                ]
            )
            . $this->tr([['<br>']])
            . $this->tr([['<br>', ['style' => 'border-top:1pt solid', 'colspan' => '2', 'width' => '100%']]])
            . $this->tr([
                [
                    'ผลตอบรับงานวิจัยและพัฒนาผลิตภัณฑ์',
                    [
                        'colspan' => '2',
                        'style' => 'text-align: center',
                        'width' => '100%'
                    ]

                ]
            ])
            . $this->tr([
                [
                    ($this->model->manager_approve_date == null ? '-' : ($this->model->manager_accept == 'Y' ? 'Yes' : ($this->model->manager_accept == 'N' ? 'No' : '?'))), [
                        'colspan' => '2',
                        'width' => '100%',
                        'style' => 'text-align: center'
                    ]
                ]
            ])
            . $this->tr([
                [
                    'Remark : ' . $this->model->manager_remark,
                    [
                        'colspan' => '2',
                        'width' => '100%'
                    ]
                ]
            ])

            . $this->tr([
                [
                    'R&D Manager : ' . $this->model->manager_approve . '<br>' . $this->model->manager_approve_date . '',
                    [
                        'colspan' => '2',
                        'width' => '100%',
                        'height' => '100%',
                        'style' => 'text-align: center; '
                    ],
                ],
            ])
            . $this->tr([['<br>']]);
        $content = Html::tag(
            'table',
            $content2,
            [
                'class' => 'formBody',
                'width' => '100%',
                'style' => "border:1pt solid black; "
            ]
        );
        $image_file = $this->params['IMAGE_PATH'] . $this->model->doc_no . '.jpg';

        if (file_exists($image_file)) {
            $content .= Html::tag('center', Html::img(
                $image_file,
                ['style' => 'border:1pt solid;' . 'display: block; margin-left: auto; margin-right: auto;width:100%;']
            ));
        }
        return $content;
    }
    protected function renderPageFooter()
    {
        
        return 'FM227 Rev.2  :  Effective : 22/01/2020';        
//         return 'M227 Rev.1  :  Effective : 20/06/19';
    }
}
