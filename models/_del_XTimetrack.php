<?php

namespace app\models;

class XTimetrack extends   \yii\db\ActiveRecord
{
    public $id;
    public $track_name;
    public $track_color;
 
    private static $tracks  = [
        1 => [
            'id' => '1',
            'track_name' => 'ห้องประชุม ชั้น 2',
            'track_color' => '#6699ff',            
        ],
        2 => [
            'id' => '2',
            'track_name' => 'ห้องรับแขก 1 ชั้น 1',
            'track_color' => '#bf80ff',            
        ],
        3 => [
            'id' => '3',
            'track_name' => 'ห้องรับแขก  ชั้น 1',
            'track_color' => '#ff80bf',            
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public static function findId($id)
    {
        return isset(self::$tracks[$id]) ? new static(self::$tracks[$id]) : null;
    }
 
 
    public function getId()
    {
        return $this->id;
    }
 
}