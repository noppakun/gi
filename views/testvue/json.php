<?php
use yii\helpers\Url;
 
?>

 
<div id="app">
{{ report() }}
          <table class="table table-bordered table-striped">
            
            <thead>
            <tr>
                <th>code</th>
                <th>name</th>
 
            </tr>
            </thead>
            <tbody>
            <tr v-for="data in Results">
             
                <td>{{ data.cust_no }}</td>
                <td>{{ data.cust_name }}</td>
 
            </tr>
            </tbody>
        </table>
</div>

<script>
 
    app = new Vue({
        el: "#app",
        data: {
            AcademicYear: "",
            TermID: "",
            CurriculumID: "",
            Results: []
        },
        methods: {
            report: function (event) {
                var vm = this;
                axios.get("<?=Url::to(['/testvue/jsondata', true])?>", {
 
                })
                    .then(function (response) {
                        vm.Results = response.data
                        //console.log(response);
                    })
                    .catch(function (error) {
                        //console.log(error);
                    })
            }
        }
    })

</script>