<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $content string */
?>

<?php
    $this->registerJsFile("https://cdn.jsdelivr.net/npm/vue/dist/vue.js", ['position' => \yii\web\View::POS_HEAD]);
    $this->registerJsFile("https://unpkg.com/axios/dist/axios.min.js", ['position' => \yii\web\View::POS_HEAD]);
    $this->registerJsFile("https://momentjs.com/downloads/moment.js", ['position' => \yii\web\View::POS_HEAD]);
    $this->registerJsFile("https://unpkg.com/vuejs-datepicker", ['position' => \yii\web\View::POS_HEAD]);
    $this->registerJsFile("https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.js", ['position' => \yii\web\View::POS_HEAD]);       
?>
<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons' rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">           
        
</head>
<body>
<div id="app">    
    <v-app  id="inspire" dark>
  
    <?php $this->beginBody() ?>
 
        <v-navigation-drawer
        v-model="drawer"
        clipped
        fixed
        app
        >
        <v-list dense>
            <v-list-tile @click="">
            <v-list-tile-action>
                <v-icon>dashboard</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
                <v-list-tile-title>Dashboard</v-list-tile-title>
            </v-list-tile-content>
            </v-list-tile>        
        </v-list>
        </v-navigation-drawer>
        <v-toolbar app fixed clipped-left>
        <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
        <v-toolbar-title>Application {{text1}}</v-toolbar-title>
        </v-toolbar>
        <v-content>
            <v-container>
            
                $content      
            
            </v-container>
        </v-content>
        <v-footer app fixed>
            <span>&copy; 2017</span>
        </v-footer>

        <?php $this->endBody() ?>   
    </v-app>    
<div>



</body>
</html>

 
 <?php $this->endPage() ?>

<script>
    var app =   new Vue({ 
        el: '#app' 
        data: () => ({
            drawer: null,
            text1:'aaaaaaaaaaaaa'
        }),
        props: {
        source: String
        }    
    })
</script>