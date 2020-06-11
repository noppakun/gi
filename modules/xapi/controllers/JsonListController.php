<?php
namespace app\modules\xapi\controllers;

use yii\db\Query;

class JsonListController extends \yii\web\Controller
{
    public function actionItem($q = null, $id = null) 
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;            
            $query->select(['id'=>'item_number','text'=>"concat(concat(rtrim(item_number),' : '),item_name)"])
                ->from('item')
                ->where(['like', 'concat(item_number,item_name)', $q])
                ->orderBy('item_number')
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Item::find($id)->Item_Name];
        }
        return $out;
    }

}
