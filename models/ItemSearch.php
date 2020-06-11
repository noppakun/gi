<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use app\models\Item;
use yii\db\Query;

/**
 * ItemSearch represents the model behind the search form about `app\models\Item`.
 */

class ItemSearch extends Item
{
  
    public $calQty;
    public $calQuarantine;

    // for sales by product
    public $amt1, $amt2, $amt3, $amt4, $amt5, $amt6, $amt7, $amt8, $amt9, $amt10, $amt11, $amt12, $totalamt;
    public $qty1, $qty2, $qty3, $qty4, $qty5, $qty6, $qty7, $qty8, $qty9, $qty10, $qty11, $qty12, $totalqty;
    // -------------------------------------------------------------------------------

    public $docyear_first;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Item_Number', 'WhCode', 'Loc_Number', 'Item_Name', 'Uom', 'Type_Invent_Code', 'Group_Product', 'Product', 'Brand', 'Type', 'SubType', 'Tariff_Code', 'Industry_Code', 'InsteadCode', 'PackUom', 'Price', 'Supp_Number', 'Uom_Buy', 'LastBuyDate', 'LastBuyCurrency_type', 'Uom_Sale', 'LastSaleDate', 'Class', 'Source', 'Account_Code', 'Order_Policy', 'Cost_Type', 'Picture', 'CompanyCode', 'Item_Type', 'CSCode', 'LastPclDate', 'OHCode', 'UserName', 'LastUpdate', 'Remark', 'FormatDateCoding', 'CateCode', 'ControlItemType', 'Sale_Category_Code', 'Account_Code_Credit', 'StorageConditionCode', 'Cust_No', 'Barcode', 'Remark1_Coding', 'Remark2_Coding'], 'safe'],
            [['Pack', 'Flag_Ana', 'LeadTime', 'Iqc_Check', 'Life_Check', 'RetestDate_Check', 'Shrink', 'ShrinkSize', 'Lot_Size', 'Retest_Cycle', 'ShelfLife', 'Std_Approve_Purchase_LeadTime', 'Std_Apprv_Production_LeadTime', 'Std_Purchase_LeadTime', 'Tag_Qty', 'Pallet_Row', 'Pallet_Layer', 'NotActive'], 'integer'],
            [['PackSize', 'QtyOnhand', 'Price_A', 'Price_B', 'Price_C', 'Price_D', 'Minimum', 'Maximum', 'LastBuyPrice', 'LastSalePrice', 'Balbf', 'Balbf_Avg_Cost', 'Balbf_Fifo_Cost', 'Sales_Reserved', 'Prodn_Reserved', 'Scrap_Qty', 'QtyOnhand_OH', 'Buffer', 'LabelPrice', 'Waste_Qty', 'Defective_Qty', 'Good_Qty', 'AvgSale_OH', 'VariableCost', 'FixedCost', 'Pallet', 'StandardCost', 'WeightPerCorbox', 'AvgCost', 'Carton_Width', 'Carton_Hight', 'Carton_Depth', 'Box_Width', 'Box_Hight', 'Box_Depth', 'Box_Weight', 'Box_Weight_Qty', 'Keep_Temperature', 'CostOfAssay', 'QtyPerPackSize', 'WeightPerPackSize'], 'number'],
            [['calQty'], 'number'],

            [['calQty'], 'safe'],
            [['docyear_first'], 'safe'],
            
            //public $order_number;
            //public $order_date;
            //[['order_date'], 'safe'],            
            //public $price;
            //public $order_qty;            
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */


    // ***********************************************************************************
    public function searchByTypeInventCode($params, $SelectForm)
    // ***********************************************************************************
    {
        return $this->quotationPriceSearch($params, $SelectForm);
    }


    // ***********************************************************************************
    public function quotationPriceSearch($params, $SelectForm)
    // ***********************************************************************************
    {



        $query = Item::find();

        $subQuery = QuoteDet::find()
            ->select('Item_Number, count(*) as qcnt')
            ->groupBy('Item_Number');

        $query->leftJoin(['QuoteDet' => $subQuery], 'QuoteDet.Item_Number = Item.Item_Number');



        $query->andFilterWhere(['=', 'item.type_invent_code', $SelectForm->ti_code]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'item.Item_Number', $this->Item_Number])
            //->andFilterWhere(['>','QuoteDet.qcnt',0])  // เฉพาะที่มีข้อมูลการเสนอราคา
            ->andFilterWhere(['like', 'Item_Name', $this->Item_Name]);

        return $dataProvider;
    }


    
    private function _andFilterWhere()
    {
        return [
            'Pack' => $this->Pack,
            'PackSize' => $this->PackSize,
            'QtyOnhand' => $this->QtyOnhand,
            'Price_A' => $this->Price_A,
            'Price_B' => $this->Price_B,
            'Price_C' => $this->Price_C,
            'Price_D' => $this->Price_D,
            'Minimum' => $this->Minimum,
            'Maximum' => $this->Maximum,
            'LastBuyDate' => $this->LastBuyDate,
            'LastBuyPrice' => $this->LastBuyPrice,
            'LastSaleDate' => $this->LastSaleDate,
            'LastSalePrice' => $this->LastSalePrice,
            'Flag_Ana' => $this->Flag_Ana,
            'LeadTime' => $this->LeadTime,
            'Balbf' => $this->Balbf,
            'Balbf_Avg_Cost' => $this->Balbf_Avg_Cost,
            'Balbf_Fifo_Cost' => $this->Balbf_Fifo_Cost,
            'Sales_Reserved' => $this->Sales_Reserved,
            'Prodn_Reserved' => $this->Prodn_Reserved,
            'Iqc_Check' => $this->Iqc_Check,
            'Life_Check' => $this->Life_Check,
            'RetestDate_Check' => $this->RetestDate_Check,
            'Shrink' => $this->Shrink,
            'ShrinkSize' => $this->ShrinkSize,
            'Lot_Size' => $this->Lot_Size,
            'Retest_Cycle' => $this->Retest_Cycle,
            'Scrap_Qty' => $this->Scrap_Qty,
            'LastPclDate' => $this->LastPclDate,
            'QtyOnhand_OH' => $this->QtyOnhand_OH,
            'LastUpdate' => $this->LastUpdate,
            'Buffer' => $this->Buffer,
            'LabelPrice' => $this->LabelPrice,
            'ShelfLife' => $this->ShelfLife,
            'Waste_Qty' => $this->Waste_Qty,
            'Defective_Qty' => $this->Defective_Qty,
            'Good_Qty' => $this->Good_Qty,
            'AvgSale_OH' => $this->AvgSale_OH,
            'VariableCost' => $this->VariableCost,
            'FixedCost' => $this->FixedCost,
            'Std_Approve_Purchase_LeadTime' => $this->Std_Approve_Purchase_LeadTime,
            'Std_Apprv_Production_LeadTime' => $this->Std_Apprv_Production_LeadTime,
            'Std_Purchase_LeadTime' => $this->Std_Purchase_LeadTime,
            'Tag_Qty' => $this->Tag_Qty,
            'Pallet' => $this->Pallet,
            'StandardCost' => $this->StandardCost,
            'WeightPerCorbox' => $this->WeightPerCorbox,
            'AvgCost' => $this->AvgCost,
            'Carton_Width' => $this->Carton_Width,
            'Carton_Hight' => $this->Carton_Hight,
            'Carton_Depth' => $this->Carton_Depth,
            'Box_Width' => $this->Box_Width,
            'Box_Hight' => $this->Box_Hight,
            'Box_Depth' => $this->Box_Depth,
            'Box_Weight' => $this->Box_Weight,
            'Box_Weight_Qty' => $this->Box_Weight_Qty,
            'Keep_Temperature' => $this->Keep_Temperature,
            'Pallet_Row' => $this->Pallet_Row,
            'Pallet_Layer' => $this->Pallet_Layer,
            'NotActive' => $this->NotActive,
            'CostOfAssay' => $this->CostOfAssay,
            'QtyPerPackSize' => $this->QtyPerPackSize,
            'WeightPerPackSize' => $this->WeightPerPackSize,
        ];
    }
    private function _andFilterWhere_like(&$query){ 
        $query->andFilterWhere(['like', 'Item.Item_Number', $this->Item_Number])
            ->andFilterWhere(['like', 'WhCode', $this->WhCode])
            ->andFilterWhere(['like', 'Loc_Number', $this->Loc_Number])
            ->andFilterWhere(['like', 'Item_Name', $this->Item_Name])
            ->andFilterWhere(['like', 'Uom', $this->Uom])
            ->andFilterWhere(['like', 'Type_Invent_Code', $this->Type_Invent_Code])
            ->andFilterWhere(['like', 'Item.Group_Product', $this->Group_Product])
            ->andFilterWhere(['like', 'Product', $this->Product])
            ->andFilterWhere(['like', 'Brand', $this->Brand])
            ->andFilterWhere(['like', 'Type', $this->Type])
            ->andFilterWhere(['like', 'SubType', $this->SubType])
            ->andFilterWhere(['like', 'Tariff_Code', $this->Tariff_Code])
            ->andFilterWhere(['like', 'Industry_Code', $this->Industry_Code])
            ->andFilterWhere(['like', 'InsteadCode', $this->InsteadCode])
            ->andFilterWhere(['like', 'PackUom', $this->PackUom])
            ->andFilterWhere(['like', 'Price', $this->Price])
            ->andFilterWhere(['like', 'Supp_Number', $this->Supp_Number])
            ->andFilterWhere(['like', 'Uom_Buy', $this->Uom_Buy])
            ->andFilterWhere(['like', 'LastBuyCurrency_type', $this->LastBuyCurrency_type])
            ->andFilterWhere(['like', 'Uom_Sale', $this->Uom_Sale])
            ->andFilterWhere(['like', 'Class', $this->Class])
            ->andFilterWhere(['like', 'Source', $this->Source])
            ->andFilterWhere(['like', 'Account_Code', $this->Account_Code])
            ->andFilterWhere(['like', 'Order_Policy', $this->Order_Policy])
            ->andFilterWhere(['like', 'Cost_Type', $this->Cost_Type])
            ->andFilterWhere(['like', 'Picture', $this->Picture])
            ->andFilterWhere(['like', 'CompanyCode', $this->CompanyCode])
            ->andFilterWhere(['like', 'Item_Type', $this->Item_Type])
            ->andFilterWhere(['like', 'CSCode', $this->CSCode])
            ->andFilterWhere(['like', 'OHCode', $this->OHCode])
            ->andFilterWhere(['like', 'UserName', $this->UserName])
            ->andFilterWhere(['like', 'Remark', $this->Remark])
            ->andFilterWhere(['like', 'FormatDateCoding', $this->FormatDateCoding])
            ->andFilterWhere(['like', 'CateCode', $this->CateCode])
            ->andFilterWhere(['like', 'ControlItemType', $this->ControlItemType])
            ->andFilterWhere(['like', 'Sale_Category_Code', $this->Sale_Category_Code])
            ->andFilterWhere(['like', 'Account_Code_Credit', $this->Account_Code_Credit])
            ->andFilterWhere(['like', 'StorageConditionCode', $this->StorageConditionCode])
            ->andFilterWhere(['like', 'Cust_No', $this->Cust_No])
            ->andFilterWhere(['like', 'Barcode', $this->Barcode])
            ->andFilterWhere(['like', 'Remark1_Coding', $this->Remark1_Coding])
            ->andFilterWhere(['like', 'Remark2_Coding', $this->Remark2_Coding]);        
    
    }


    public function searchPackaging($params, $option = null)
    {


        $query = Item::find();
 

        $dataProvider = new ActiveDataProvider([
            'query' => $query,

            'pagination' => [
                'pageSize' => 40,
            ],
            'sort' => [
                'defaultOrder' => [
                    'Group_Product' => SORT_ASC,
                    'Product' => SORT_ASC,
                    //'Item_Number' => SORT_DESC,
                    'Item_Number' => SORT_ASC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $this->Type_Invent_Code='05';
        $query->andFilterWhere($this->_andFilterWhere());
        $this->_andFilterWhere_like($query);     




        return $dataProvider;
    }
    // *************************************************************************************     
    public function search($params, $option = null)
    // *************************************************************************************
    {


        $query = Item::find();
        //$subQuery = XItemlastpo::find();     
        //$query->leftJoin(['itemlastpo' => $subQuery], 'itemlastpo.item_number = Item.Item_Number');
        if (Yii::$app->controller->id == 'item-info') {
            $subquery = new Query;
            $subquery->select("b.Item_Number,min(year(a.DocDate))  as docyear_first ")
                ->from('StHead a ')
                ->join(
                    'LEFT JOIN',
                    'StCard b',
                    ['a.CompanyCode' => 'b.CompanyCode', 'a.VoucherNo' => 'b.VoucherNo', 'a.DocType' => 'b.DocType']
                )
                //->where(['like', 'item_number', $q])
                ->groupBy('b.Item_Number');

            $query->leftJoin(['xstcard' => $subquery], 'xstcard.Item_Number = Item.Item_Number');
            //$query->Select(["Item.*","docyear_first"]);
            $query->Select("*");
            echo '<br><br><br>xxxxxxxxxxx';
            echo $query->createCommand()->getRawSql();

            //$query->joinWith(['customer']);  
            //$query->joinWith(['xInvoiceExt']);  

        }


        $dataProvider = new ActiveDataProvider([
            'query' => $query,

            'pagination' => [
                'pageSize' => 40,
            ],
            // 'sort' => [
            //     'defaultOrder' => [
            //         'Item_Number' => SORT_ASC,
            //     ]
            // ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere($this->_andFilterWhere());
        $this->_andFilterWhere_like($query);     


        return $dataProvider;
    }

    // ***********************************************************************************
    public function salesbyproductSearch($params, $SelectForm)
    // ***********************************************************************************
    {
        //$query = Item::find()->select('Item.*,salesSum.*');   
        $query = self::find()->select('Item.*,salesSum.*');

        $subQuery = XSalesinfo::find()
            ->select('            
                item_number as ino ,
                ,sum(case when tryear=' . $SelectForm->year . ' and trmonth =   1 then  amt else 0 end) as amt1
                ,sum(case when tryear=' . $SelectForm->year . ' and trmonth =   2 then  amt else 0 end) as amt2
                ,sum(case when tryear=' . $SelectForm->year . ' and trmonth =   3 then  amt else 0 end) as amt3
                ,sum(case when tryear=' . $SelectForm->year . ' and trmonth =   4 then  amt else 0 end) as amt4
                ,sum(case when tryear=' . $SelectForm->year . ' and trmonth =   5 then  amt else 0 end) as amt5
                ,sum(case when tryear=' . $SelectForm->year . ' and trmonth =   6 then  amt else 0 end) as amt6
                ,sum(case when tryear=' . $SelectForm->year . ' and trmonth =   7 then  amt else 0 end) as amt7
                ,sum(case when tryear=' . $SelectForm->year . ' and trmonth =   8 then  amt else 0 end) as amt8
                ,sum(case when tryear=' . $SelectForm->year . ' and trmonth =   9 then  amt else 0 end) as amt9
                ,sum(case when tryear=' . $SelectForm->year . ' and trmonth =  10 then  amt else 0 end) as amt10
                ,sum(case when tryear=' . $SelectForm->year . ' and trmonth =  11 then  amt else 0 end) as amt11
                ,sum(case when tryear=' . $SelectForm->year . ' and trmonth =  12 then  amt else 0 end) as amt12
                ,sum(case when tryear=' . $SelectForm->year . ' then  amt else 0 end) as totalamt            
            
                ,sum(case when tryear=' . $SelectForm->year . ' and trmonth =   1 then  qty else 0 end) as qty1
                ,sum(case when tryear=' . $SelectForm->year . ' and trmonth =   2 then  qty else 0 end) as qty2
                ,sum(case when tryear=' . $SelectForm->year . ' and trmonth =   3 then  qty else 0 end) as qty3
                ,sum(case when tryear=' . $SelectForm->year . ' and trmonth =   4 then  qty else 0 end) as qty4
                ,sum(case when tryear=' . $SelectForm->year . ' and trmonth =   5 then  qty else 0 end) as qty5
                ,sum(case when tryear=' . $SelectForm->year . ' and trmonth =   6 then  qty else 0 end) as qty6
                ,sum(case when tryear=' . $SelectForm->year . ' and trmonth =   7 then  qty else 0 end) as qty7
                ,sum(case when tryear=' . $SelectForm->year . ' and trmonth =   8 then  qty else 0 end) as qty8
                ,sum(case when tryear=' . $SelectForm->year . ' and trmonth =   9 then  qty else 0 end) as qty9
                ,sum(case when tryear=' . $SelectForm->year . ' and trmonth =  10 then  qty else 0 end) as qty10
                ,sum(case when tryear=' . $SelectForm->year . ' and trmonth =  11 then  qty else 0 end) as qty11
                ,sum(case when tryear=' . $SelectForm->year . ' and trmonth =  12 then  qty else 0 end) as qty12
                ,sum(case when tryear=' . $SelectForm->year . ' then  qty else 0 end) as totalqty                
            
            
            ')
            //->andFilterWhere(['=', 'tryear', $SelectForm->year])
            //->where(['whcode'=>$SelectForm->wh_code,'status'=>'Y'])
            ->groupBy('item_number');
        /*

*/
        $query->leftJoin(['salesSum' => $subQuery], 'salesSum.ino = Item.Item_Number');
        $query->andFilterWhere(['<>', 'salesSum.totalamt', 0]);




        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                // 'attributes' => ['Item_Number', 'Item_Name'],
                'defaultOrder' => [
                    'Item_Name' => SORT_ASC,
                ]
            ],
            // 'pagination'=>[
            //     'pageSize'=>100,
            // ],            

        ]);



        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'Item.Item_Number', $this->Item_Number])
            ->andFilterWhere(['like', 'Item.Item_Name', $this->Item_Name]);


        // echo '<br><br><br>';
        // echo $query->createCommand()->sql;
        return $dataProvider;
    }
    // ***********************************************************************************
    public function onhandSearch($params, $SelectForm)
    // ***********************************************************************************
    {

        $query = $this::find()
            ->select('Item.Item_Number,Item_Name
            ,Group_Product, Product
            ,onhandSum.calQty,onhandSum.calQuarantine   ');
        $subQuery = ItemLoc::find()
            ->select(
                "
                    Item_Number, SUM(ana_qty) as calqty
                    ,sum(Quarantine) as calquarantine
                   
                    
                "
            )
            //->where(['whcode'=>$SelectForm->wh_code,'status'=>'Y'])
            ->where(['whcode' => $SelectForm->wh_code])
            ->groupBy('Item_Number');
        //-- ,sum(case status when "Y" then 0 else ana_qty end) as qty_not_y                    
        $query->leftJoin(['onhandSum' => $subQuery], 'onhandSum.Item_Number = Item.Item_Number');
        $query->andFilterWhere(['<>', 'onhandSum.calqty', 0]);
        $query->andFilterWhere(['=', 'item.type_invent_code', $SelectForm->ti_code]);
        if ($SelectForm->co_code !== '*') {
            $query->andFilterWhere(['=', 'item.companycode', $SelectForm->co_code]);
        }


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'item.Item_Number', $this->Item_Number])
            ->andFilterWhere(['like', 'Item_Name', $this->Item_Name])
            ->andFilterWhere(['like', 'Group_Product', $this->Group_Product])
            ->andFilterWhere(['like', 'Product', $this->Product])
            //,Group_Product, Product
        ;

        return $dataProvider;
    }
    // ***********************************************************************************
    public function onhandMovement($wh_code, $item_number, $co_code)
    // ***********************************************************************************
    {
        $sql = "
        
            declare @bf_date datetime
            declare @wh_code varchar(10)
            declare @item_number varchar(20)
            declare @companycode varchar(3)
            
            set @bf_date='20150101'
            set @bf_date=getdate()-(365*2)
            -- 12/7/19  ปรับยอด movement เป็น 2 ปี -- k.jeed 

            set @wh_code='FIN'
            set @item_number='8850279105157'
            set @companycode='GPM'
            
            set @wh_code=:wh_code
            set @item_number=:item_number
            set @companycode=:companycode
            
            
            --  ยอดยกมา ---------------------- 
            select * from (
                select '' as voucherno,cast(null as datetime) as docdate
                ,'ยอดยกมา' as doctypedesc
                ,case when a.bf_qty > 0 then a.bf_qty else 0 end as recv_qty 
                ,case when a.bf_qty < 0 then a.bf_qty else 0 end as issue_qty
                from (
                    select sum(isnull(recv_qty,0)-isnull(issue_qty,0)) as bf_qty 
                    from sthead a 
                    left join stcard b
                        on a.companycode=b.companycode
                        and a.doctype=b.doctype
                        and a.voucherno=b.voucherno
                    
                    where a.companycode=@companycode
                    and b.whcode = @wh_code
                    and a.docdate < @bf_date 
                    and b.item_number = @item_number
                )a
            )a
            union
            -- movement ---------------------- 
            select a.voucherno as voucherno,a.docdate,c.doctypedesc
                ,isnull(recv_qty,0) as recv_qty 
                ,isnull(issue_qty,0) as issue_qty
            from sthead a 
            left join stcard b
                on a.companycode=b.companycode
                and a.doctype=b.doctype
                and a.voucherno=b.voucherno
            left join  Doctype c 
                on b.doctype=c.doctype
            where a.companycode=@companycode
            and b.whcode=@wh_code
            and a.docdate>=@bf_date 
            and b.item_number = @item_number
            order by a.docdate

            
            ";




        $connection = \Yii::$app->erpdb;
        $command = $connection->createCommand($sql);
        $command->bindParam(":wh_code", $wh_code);
        $command->bindParam(":item_number", $item_number);
        $command->bindParam(":companycode", $co_code);
        $rows = $command->queryAll();
        $qty = 0;
        foreach ($rows as $key => $row) {
            $qty += ($row['recv_qty'] - $row['issue_qty']);

            $rows[$key]['_calonhand'] = $qty;
        }
        $dataProvider = new ArrayDataProvider([
            'allModels' => $rows,
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);;

        return $dataProvider;
    }

    // ***********************************************************************************
    //  for Quotation Price ***************************************************************
    // ***********************************************************************************
    //public function poHistory($id_no,$cho=0,$option=['byItems'])
    public function poHistory($id_no, $opts = ['byItems'])
    // ***********************************************************************************
    {


        //if ($cho==0){   // by items
        if (in_array('byItems', $opts)) {   // by items

            $sql = "
            
                declare @item_number varchar(20)

                set @item_number=:id_no
                select "
                . (in_array('top10', $opts) ? " top 10 " : "")
                . " * from
                (	
                    select  b.item_number,b.order_qty,b.price,a.order_date,a.order_number
                    ,a.supp_number
                    -- row_number() OVER (PARTITION BY b.item_number order by b.item_number,a.order_number,a.order_date desc ) seq
                    from po a 
                    left join podetail b on a.companycode=b.companycode
                        and a.order_number=b.order_number
                    where isnull(b.item_number,'') <>''
                    and  b.item_number=@item_number
                )a 
                order by a.order_date desc ,a.order_number desc 
                --  where seq  <= 5  edit to show all by p kai 5/9/2017
                
            ";
            //} else if ($cho==1) {   // by supplier
        } else if (in_array('bySupplier', $opts)) {   // by supplier            
            $sql = "            
                declare @supp_no varchar(20)

                set @supp_no=:id_no
                select "
                . (in_array('top10', $opts) ? " top 10 " : "")
                . " * from
                (	
                    select  b.item_number,b.order_qty,b.price,a.order_date,a.order_number
                    -- row_number() OVER (PARTITION BY b.item_number order by b.item_number,a.order_date,a.order_number desc ) seq
                    from po a 
                    left join podetail b on a.companycode=b.companycode
                        and a.order_number=b.order_number
                    where isnull(b.item_number,'') <>''
                    and  a.supp_number=@supp_no
                )a 
                order by a.order_date desc ,a.order_number desc 
                --  where seq  <= 5  edit to show all by p kai 5/9/2017                
            ";
        }

        $connection = \Yii::$app->erpdb;
        $command = $connection->createCommand($sql);
        $command->bindParam(":id_no", $id_no);
        $rows = $command->queryAll();
        $dataProvider = new ArrayDataProvider([
            'allModels' => $rows,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);;

        return $dataProvider;
    }
    // ***********************************************************************************
    //  for Quotation Price ***************************************************************
    // ***********************************************************************************




    function quotaQuery($id_no, $opts = ['byItems'])
    {
        //\app\components\XLib::xprint_r($opts);
        //if ($cho==0){   // by items        
        if (in_array('byItems', $opts)) {   // by items
            $sql = "

                declare @item_number varchar(20)
                -- declare @topline integer
            
                set @item_number=:id_no
                -- set @topline = :topline
                -- set @item_number='R0090'

                select "
                . (in_array('top10', $opts) ? " top 10 " : "")
                . " b.seq_number as id,b.item_number  ,a.quotedate as  doc_date,                
                    a.supp_name,
                    b.per_Qty as qty,b.uom as unit,b.unitprice as price
                from quote a left join quotedet b on a.quote=b.quote
                left join supplier c on a.supp_number=c.supp_number
                where b.item_number=@item_number
                order by a.quotedate desc
            ";
            //} else  if ($cho==1){   // by supplier
        } else if (in_array('bySupplier', $opts)) {   // by supplier    
            $sql = "
                declare @supp_number varchar(20)
                -- declare @topline integer
            
                set @supp_number=:id_no
                -- set @topline = :topline
                 

                select "
                . (in_array('top10', $opts) ? " top 10 " : "")
                . "b.seq_number as id,b.item_number ,a.quotedate as  doc_date,                
                    a.supp_name,
                    b.per_Qty as qty,b.uom as unit,b.unitprice as price
                from quote a left join quotedet b on a.quote=b.quote
                left join supplier c on a.supp_number=c.supp_number
                where a.supp_number=@supp_number
                order by a.quotedate desc
            ";
        }
        // $topline=100;
        $connection = \Yii::$app->erpdb;
        $command = $connection->createCommand($sql);
        $command->bindParam(":id_no", $id_no);
        //$command->bindParam(":topline",$topline);        
        $rows = $command->queryAll();
        return  $rows;
    }

    // ***********************************************************************************
    public function quotationPrice($item_number, $opts = ['byItems'])
    // ***********************************************************************************
    {

        $rows = $this->quotaQuery($item_number, $opts);
        if (in_array('array', $opts)) {
            return $rows;
        } else {
            return new ArrayDataProvider([
                'allModels' => $rows,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
        }
    }
    public function attributeLabels()
    {
        return array_merge($this->labels, [
            'calQty' => 'จำนวนคงเหลือ',
            'calQuarantine' => 'Quarantine'
        ]);
    }
}
