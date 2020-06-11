<?php
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class TimeUpload extends Model
{
    /**
     * @var UploadedFile
     */
    public $uploadFile;


    public function rules()
    {
        return [
            [['uploadFile'], 'file', 'skipOnEmpty' => false],
   			// [['uploadFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],            
        ];
    }
  	 
    public function upload()
    {
        if ($this->validate()) {
        	$filename = 'uploads/' . $this->uploadFile->baseName . '.' . $this->uploadFile->extension;
            $this->uploadFile->saveAs($filename);
			$this->timeconvert($filename);

            return true;
        } else {
            return false;
        }    
    }

    function timeconvert($filename)
    {

        $alarmtable =  \app\models\Alarm::findBySql("select hour*100+minute as hm,inout from x_alarm order by hour*100+minute")->asArray()->all();


       // $filename = 'uploads/time.txt';
        $lines = file($filename);


        $myfile = fopen("uploads/newtime.txt", "w") or die("Unable to open file!");


        foreach ($lines as $line_num => $line) {
            $line=substr($line,0,23);
            if (trim($line)!="")
            {
                $io=1;
                $ttime=(substr($line,18,2).substr($line,21,2))+0;
                foreach ($alarmtable as $a_num => $alarm) {
                    //echo "---a #<b>{$a_num}</b> : [" . $alarm["hm"] . "]<br />\n";
                    if ($ttime >=$alarm["hm"]){
                        $io=$alarm["inout"];
                    }
                }
                
                
                //PHP_EOL windows = "\r\n"  Linux = "\n"
                $line_out= $line." ".$io." 01"."\r\n" ;
                fwrite($myfile, $line_out);
                //echo "Line #<b>{$line_num}</b> : [" . $line_out . "]<br />\n";
                //echo  $line_out;
            }
        }    
        fclose($myfile);           

    }        
}