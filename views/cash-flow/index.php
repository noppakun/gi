 
<?php 
    //  ----   vue app  --
    $this->registerJsFile("https://cdn.jsdelivr.net/npm/vue/dist/vue.js", ['position' => \yii\web\View::POS_HEAD]);
    $this->registerJsFile("https://unpkg.com/axios/dist/axios.min.js", ['position' => \yii\web\View::POS_HEAD]);
    $this->registerJsFile("https://momentjs.com/downloads/moment.js", ['position' => \yii\web\View::POS_HEAD]);
    $this->registerJsFile("https://unpkg.com/vuejs-datepicker", ['position' => \yii\web\View::POS_HEAD]); 


    //            <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
    
    //$this->registerJsFile("https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.js", ['position' => \yii\web\View::POS_HEAD]);
    //$this->registerJsFile("https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js", ['position' => \yii\web\View::POS_HEAD]);

?>

<div id="app">
    <v-app>
    <v-content>
    <v-container>
    <div class="well">
        <div class="row">
            <div class="col-md-2 col-sm-2 col-xs-5">    
                <div class="form-group">                              
                    <label for="date1">วันที่</label>        
                    <vuejs-datepicker id="date1"  
                        v-model="date1" 
                        format="dd-MM-yyyy" input-class="form-control"></vuejs-datepicker>
                </div>    
            </div>    
            <div class="col-md-2 col-sm-2 col-xs-5">
                <div class="form-group">                    
                    <label for="date2">ถึงวันที่</label>        
                    <vuejs-datepicker id="date2" 
                        v-model="date2" 
                        format="dd-MM-yyyy" input-class="form-control"></vuejs-datepicker>                       
                </div>    
            </div>          
        </div>         
        <div class="row"> 
            <div class="col-md-3 col-sm-2 col-xs-5">
                <div class="form-check">             
                    <input type="checkbox" id="checkbox" v-model="showPayDet" class="form-check-input">
                    <label class="form-check-label" for="checkbox">แสดงรายระเอียดการจ่ายชำระ</label>                                                                        
                 </div>                                      
            </div>  
            <div class="col-md-6" style="text-align: left">              
                <button v-on:click="fetchData(0)" class="btn btn-primary">Process</button>                    
            </div>
            <div class="col-md-3" style="text-align: right">              
                <b-btn @click="showCollapse = !showCollapse"
                    :class="showCollapse ? 'collapsed' : null"
                    aria-controls="collapse4"
                    :aria-expanded="showCollapse ? 'true' : 'false'">
                    <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>
                </b-btn>
            </div>
        </div>        
    </div>
 
 
    <b-collapse  v-model="showCollapse" id="collapse4">
        <div class="well">
            <!-- <form class=" form-inline" v-on:submit.prevent="onSubmit"> -->          
            <input id="form-token"  type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
            
            <div class="row">
                <div class="col-md-2 col-sm-2 col-xs-5">            
                    <label for="cfrec.tr_date">วันที่</label>        
                    <vuejs-datepicker input-class="form-control" id="cfrec.tr_date"  
                        v-model="cfrec.tr_date" 
                        format="dd-MM-yyyy"></vuejs-datepicker>
                </div>  
                <div class="col-md-4 col-sm-4 col-xs-5" >            
                    <label for="cfrec.description">รายการ</label>                            
                    <input type="text" class="form-control" id="cfrec.description"  v-model="cfrec.description">
                </div>                        
                <div class="col-md-2 col-sm-2 col-xs-5">            
                    <label for="cfrec.amt">รับ/จ่าย ( +/- )</label>        
                    <input type="text" class="form-control" id="cfrec.amt"  v-model="cfrec.amt" >
                </div>                        
                <div class="col-md-4 col-sm-4 col-xs-5 form-group" >            
                    <label for="cfrec.note">หมายเหตุ</label>        
                    <input type="text" class="form-control" id="cfrec.note"  v-model="cfrec.note">
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <button v-if="cfrec.xid==0" v-on:click="onSubmit(0)" class="btn btn-primary">Save</button>            
                    <button v-else v-on:click="onSubmit(0)" class="btn btn-primary">Update</button>            
                    <button v-on:click="onNew" class="btn btn-primary">New</button>            
                </div>             
                <div class="col-md-6" style="text-align: right">
                    <span   v-if="cfrec.xid!=0" v-on:click="onSubmit(cfrec.xid)" class="glyphicon glyphicon-trash alink"></span>             
                </div>           
            </div>             
        </div>  
    </b-collapse>
        

    <div class="row">
        <div class="col-md-6 vcenter">
            Showing {{ offset + 1 }}
            - {{ offset + rowcount }} 
            of {{pages.totalCount}} items.                
        </div>
        <div class="col-md-6 text-right">
            <b-pagination :total-rows="Number(pages.totalCount)" v-model="currentPage" :per-page="pages.defaultPageSize"></b-pagination> 
            
        </div>             
    </div>    
    
    <table class="table table-bordered table-striped detail-view">  
        <thead>
            <tr>
                <th>วันเดือนปี</th>
                <th>รายการ</th>
                <th>รับ</th>
                <th>จ่าย</th>    
                <th>คงเหลือ</th>    
                <th>หมายเหตุ</th>    
                <th style="min-width: 40px;"><span class="glyphicon glyphicon-cog"></span></th>    
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in cfrows">                  
                <td class ="tddate">                
                    {{item.tr_date | formatDate}}                    
                </td>
                <td>
                    {{item.description}}
                </td>
                <td class ="tdnum">
                    {{item.amt_receive | formatPrice(2,'')}}
                </td>
                <td class ="tdnum">
                    {{item.amt_pay | formatPrice(2,'')}}
                </td>
                <td class ="tdnum">
                    {{item.balance | formatPrice(2,'')}}
                </td>
                <td>
                    {{item.note}}
                </td>
                <td style="text-align:center">
                    <span  v-if="item.xid!=0" v-on:click="onEdit(item)" class="glyphicon glyphicon-pencil alink"></span>                                      
                </td>
        
            </tr>
        </tbody>
    </table>   
    <div class="row"> 
        <div class="col-md-12 text-right">
            <b-pagination :total-rows="Number(pages.totalCount)" v-model="currentPage" :per-page="pages.defaultPageSize"></b-pagination> 
        </div>            
    </div>    
    </v-container>
    </v-content>    
    </v-app>
</div>
<!---------------------------------------------------------------------------------------------- -->
<style>
    .tdnum {
        text-align:right;
        width:120px;    
    }   
    .tddate {
        text-align:left;
        width:110px;  
        min-width: 110px;
    }
    th {
        text-align:center;
    }

    .pagination {
        margin-top:0px;
        margin-bottom:0px;
    }
    .alink  {
        cursor: pointer;
    }
}
</style>
 

<script>   
    Vue.filter('formatPrice', function(value,fixed=2,zero2=null) {
    if (value) {
            let ret = ((value/1).toFixed(fixed)).toString() //.replace('.', '#')
                .replace(/\d(?=(\d{3})+\.)/g, '$&,');  // 12,345.67    
            return (zero2!=null) ? ((value==0)?zero2:ret):ret ;
    }
    })
    Vue.filter('formatDate', function(value) {
    if (value) {
        return moment(String(value)).format('DD-MM-YYYY')      
    }
    })
 
    axios.defaults.baseURL = 'http://greaterman.ddns.info:50004/gi/web/index.php?r=/xapi/'; 
    
    //axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';
    //axios.defaults.headers.common['Authorization'] = AUTH_TOKEN;

    var app = new Vue({
        el: '#app',
        components: {
            vuejsDatepicker
        },  
        data: function (){ 
            return {
                _csrf:'xxxxx',
                showCollapse: false,                
                date1: new Date(),
                date2: new Date(), 
                showPayDet:false,
                cfrows:[],   
                currentPage:1,
                pages:[],
                cfrec:{
                    id: 0,
                    xid: 0,
                    tr_date: new Date(),
                    description:'ddd',
                    amt:0,
                    note:'nnn'
                },
                offset:0,
                rowcount:0,
            }
        },
        watch: {            
            currentPage: function (newQuestion, oldQuestion) {
                this.fetchData();
            },  
        },
        methods: {
            onEdit:function(item){
                

                this.cfrec.id           = item.id
                this.cfrec.xid          = item.xid
                this.cfrec.tr_date      = item.tr_date
                this.cfrec.description  = item.description
                this.cfrec.amt          = item.amt_receive-item.amt_pay
                this.cfrec.note         = item.note

                this.showCollapse       = true            
            },
            onNew:function(e){
                this.cfrec.id = 0
                this.cfrec.xid = 0
                this.cfrec.tr_date =  new Date(),
                this.cfrec.description = ''
                this.cfrec.amt = 0
                this.cfrec.note = ''
            },
            
            onSubmit:function(xid){
                var vm = this;  
                var url = "/deletedata";
                var formData = {
                        xid   : xid,                                     
                    }
                if(xid == 0){ // new / update
                    this.cfrec.tr_date = moment(this.cfrec.tr_date).format('YYYY-MM-DD');
                    url = "/postdata"                
                    formData = {                    
                        XCashflow   : this.cfrec,
                        _csrf       : this._csrf,                                       
                    }
                    console.log(this.cfrec);
                }            
                
                axios.post("cash-flow"+url,
                    formData,{
                        headers: {
                            'Content-type': 'application/x-www-form-urlencoded',                     
                        }                                               
                    }
                )
                .then(function(res){                  
                    console.log(res);
                    vm.onNew();
                    vm.fetchData(1);                                
                })
                .catch(function (error) {        
                    console.log(error);
                })
            }, 
        
            fetchData:function(page=0){
                if(page!=0){
                    this.currentPage=page;
                }
                var vm = this;     
                //axios.get("http://gi.greaterman.com/gij/web/index.php?r=cash-flow/getdata",{
                    console.log(vm.showPayDet   );     
                axios.get("cash-flow/getdata",{
                    params: {
                        date1:moment(this.date1).format('YYYYMMDD'),
                        date2:moment(this.date2).format('YYYYMMDD'),                        
                        currentPage:this.currentPage,
                        showPayDet:vm.showPayDet,
                    }                
                })
                .then(function(res){            
                     
                    vm.cfrows   = res.data.rows  
                    vm.pages    = res.data.pages        
                    vm.offset   = res.data.pages.params.offset 
                    vm.rowcount = res.data.pages.params.rowcount
                })
                .catch(function (error) {        
                    console.log(error);
                })
            }
        },      
        created() {
            this._csrf=document.getElementById("form-token").value ;
            this.date1.setDate(this.date1.getDate() - 30);    
            // this.date1=new Date(2018, 9,29);    
            // this.date2=new Date(2018, 10,30);    
    
            // this.date1=new Date(2018, 10,8);    
            // this.date2=new Date(2018, 10,30);    
    
            this.fetchData(1);
            this.onNew();
        },
    })
</script>
 