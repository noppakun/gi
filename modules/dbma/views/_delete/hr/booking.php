<?php
  $events = [];
  //Testing
  $Event = new \yii2fullcalendar\models\Event();
  $Event->id = 1;
  $Event->title = 'Testing1';
  $Event->start = date('Y-m-d\TH:i:s\Z');
  $Event->nonstandard = [
    'field1' => 'Something I want to be included in object #1',
    'field2' => 'Something I want to be included in object #2',
  ];
  $events[] = $Event;

  $Event = new \yii2fullcalendar\models\Event();
  $Event->id = 2;
  $Event->title = 'Testing2';
  $Event->start = date('Y-m-d\TH:i:s\Z',strtotime('tomorrow 8:01'));  
  $Event->end   = date('Y-m-d\TH:i:s\Z',strtotime('tomorrow 12:01'));
  $Event->backgroundColor = ['red'];
  //$Event->url ="http://www.greaterman.com";
  $events[] = $Event;
 
  // echo   $Event->start;
  // echo $Event->end;
  ?>

  <?= \yii2fullcalendar\yii2fullcalendar::widget(array(
      'events'=> $events,
  ));
  ?>