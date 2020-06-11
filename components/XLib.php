<?php
namespace app\components;
use Yii;
use yii\base\Component;
 /*
  11/09/2018  function dateConv($p_date,$opt) {
 */ 
class XLib extends Component {

  /***************************************
    30/10/2018
      new *** function xisnull($value , $replace_value=null)
    29/10/2018
      new *** function xnumber_format  for convert 0 to '-' or other charector
        use app\components\XLib;
        echo XLib::xnumber_format(32676,2,'-'); 
        or
        \app\components\XLib::xnumber_format(32676,2,'-'); 

    16/10/2018
      new *** function xprint_r($p)     
        how to use
          \app\components\XLib::xprint_r($row); 
    11/09/2018
      How To Use
      use app\components\XLib;
      $this->AssetDate = XLib::dateConv($this->AssetDate,'a'); 
      $this->AssetDate = XLib::dateConv($this->AssetDate,'b');      

      or
    
      $this->AssetDate = \app\components\XLib::dateConv($this->AssetDate,'a'); 
  ****************************************
  how to use 
    use as component // recommend
      - register 'XLib' by configuring the yii\base\Application::$components property inside the config/web.php
        'components' => [ 
          'xlib' => [
              'class' => 'app\components\XLib',
          ],
      - Yii::$app->xlib->dateConv($this->AssetDate,'a'); 
    use direct // not recommend
      \app\components\XLib::xnumber_format(32676,2,'-'); 
  ****************************************/
    public const monthTextArray=[
     
      "1"=>"มกราคม",  
      "2"=>"กุมภาพันธ์",  
      "3"=>"มีนาคม",  
      "4"=>"เมษายน",  
      "5"=>"พฤษภาคม",  
      "6"=>"มิถุนายน",   
      "7"=>"กรกฎาคม",  
      "8"=>"สิงหาคม",  
      "9"=>"กันยายน",  
      "10"=>"ตุลาคม",  
      "11"=>"พฤศจิกายน",  
      "12"=>"ธันวาคม"                    
  ]; 
  // --------------------------------------------------------------------------------
  function xisnull($value , $replace_value=null)
  // --------------------------------------------------------------------------------
  {
    return isset($value)?$value:$replace_value;    
  }  
  // --------------------------------------------------------------------------------
  function xnumber_format ($number , int $decimals = 0,$zero2=null)
  // --------------------------------------------------------------------------------
  {
    return ($zero2!==null)
      ? ( $number == 0 ? $zero2:number_format ($number , $decimals) )
      :number_format ($number , $decimals);
  }

  // --------------------------------------------------------------------------------
  public function xprint_r($p) {     
  // --------------------------------------------------------------------------------    
    echo '<br><br><pre>';
    print_r($p);
    echo '</pre>';
  }

  // --------------------------------------------------------------------------------
  public function dateConv($p_date,$opt) {     
  // --------------------------------------------------------------------------------
    if ($opt == 'a'){ // afterFind
        return $p_date == null ? null : date ('d-m-Y', strtotime($p_date)); 
    } else {    // beforeSave
        return $p_date == null ? null : date('Y-m-d', strtotime(str_replace('/', '-', $p_date)));             
    }
  }

  // --------------------------------------------------------------------------------
  public function dateTimeConv($p_date,$opt) {     
  // --------------------------------------------------------------------------------
    if ($opt == 'a'){ // afterFind
        return $p_date == null ? null : date ('d-m-Y H:i', strtotime($p_date)); 
    } else {    // beforeSave
        return $p_date == null ? null : date('Y-m-d H:i', strtotime(str_replace('/', '-', $p_date)));             
    }
  }
    
  

  // --------------------------------------------------------------------------------
  public function  number_format_text( $number , $decimals = 0)   
  // --------------------------------------------------------------------------------
  {     
    return  ($number==0) ? '' : number_format($number, $decimals, '.', ',');
  } 
  
  public function  log_action( $controller , $action,$details='LOG')   
  {     
    
        $sql = "insert into  gi_logs (username , ipaddress , logtime , controller, action , details ) VALUES ('".Yii::$app->user->identity->username."','".$_SERVER['REMOTE_ADDR']."',getdate(),'".$controller."','".$action."','".$details."')";
        $command = Yii::$app->db->createCommand($sql);
        $command->execute(); 
  } 

}