<?php
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class FileUpload extends Model
{
    /**
     * @var UploadedFile
     */
    public $uploadFile;


    public function rules()
    {
        return [
            [['uploadFile'], 'file', 'skipOnEmpty' => false],
   			//[['uploadFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],            
        ];
    }
  	 
    public function upload($uploadspath='',$p_basename=null)
    {
        if ($this->validate()) {
            //$filename = 'images/xpdr/' . $this->uploadFile->baseName . '.' . $this->uploadFile->extension;
            $cust_filename = ($p_basename == null ? $this->uploadFile->baseName : $p_basename )
                .'.'. $this->uploadFile->extension;


            if(file_exists($cust_filename)) unlink($cust_filename);
            
            $filename = $uploadspath.'/'.$cust_filename;
            $this->uploadFile->saveAs($filename);
            return true;
        } else {
            return false;
        }    
    }
    
}