var app = new Vue({
    el: '#app',

    // data() { <===== not work
    //     return {
    data: function () {
        return {


            //------------                
            items: [],
            itemDefault: {},
            itemEdit: { id: 0 },    // <== pre init by id

            // itemEdit: {
            //     id: 0,
            //     // -------------------
            //     item_desc: '',
            //     qty: 0,
            //     uom: '',
            //     price: 0,
            //     remark: '',
            // },
            vat_type: '',
            vat_percent: 0,
            vat_amount: 0,
            amount: 0,
            total_amount: 0,

        }
    },

    async mounted() {
        //async created() {
        var mastermodel = JSON.parse(document.getElementById("mastermodel").value)
        this.vat_type = mastermodel.vat_type
        this.vat_percent = mastermodel.vat_percent

        let vm = this
        //var _v = new Object();
        //console.log(e1.value)
        //await axios.get('index.php?r=/xpr/api_detail&id=' + e1.value)            
        console.log('================')
        console.log(  mastermodel)
        await axios.get('?r=/xpr/api_detail&id=' + mastermodel.id)
            //await axios.get('?r=/xpr/api_detail&id=12')            
            .then(r => {
                //console.log( r.data.rows)
                vm.items = r.data.rows
                vm.itemDefault = r.data.row // <---- single row
                vm.itemDefault.id = 0
                vm.itemDefault.rec_status = ''

            });
        this.calTotalAmt()
    },
    filters: {
        formatNumber(value) {
            return new Intl.NumberFormat().format(value)
            //return numeral(value).format("0,0"); // displaying other groupings/separators is possible, look at the docs
        }
    },

    methods: {
        onVat_percentChange(e) {
            this.vat_percent = e.event.target.value
            this.calTotalAmt()
        },
        onVat_typeClick(e) {

            this.vat_type = e.event.target.value
            this.calTotalAmt()
        },
        // display aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
        calTotalAmt() {
            var _price
            this.amount = 0
            this.total_amt = 0
            this.items.forEach(r => {
                if (r.rec_status !== 'd') {
                    this.amount = this.amount + (Math.round(r.qty * r.price * 100) / 100);
                }
            })
            let _vat_percent = parseFloat(this.vat_percent)
            this.vat_amount = (this.vat_type == 'i') ?
                (this.amount * (_vat_percent / (100 + _vat_percent))) :
                (this.amount * (_vat_percent / 100))

            this.amount = (this.vat_type == 'i') ?
                this.amount - this.vat_amount :
                this.amount

            this.total_amount = this.amount + this.vat_amount

        },

        onClickDelete(para) {
            //console.log('-------------onClickDelete----',para)
            let i = this.items.findIndex((e) => (e.id == para.id))
            if (this.items[i].rec_status == 'n') {
                this.items.splice(i, 1)
            } else {
                this.items[i].rec_status = 'd'
            }
            this.calTotalAmt()
        },
        onClickCreate() {
            //     id: 0,
            //console.log(this.itemDefault)
            //console.log(this.itemEdit)

            Object.assign(this.itemEdit, this.itemDefault)
            //this.$refs.itemE.focus();
            //console.log(this.$refs.itemE)                
        },
        onClickEdit(_item) {
            //$('#myModal').modal('show')
            //console.log('-------onClickEdit---------')
            //console.log(document.getElementById('itemEdit.item_desc'))
            //$('#myModal').focus()
            //document.getElementById('itemEdit.item_desc').focus()
            // setTimeout(() => {
            //     document.getElementById('itemEdit.item_desc').focus()

            // }, 100)
            //console.log(_item)
            Object.assign(this.itemEdit, _item)
            //console.log(this.itemEdit)

            //let vm = this
            //Object.assign(vm.itemEdit, this.itemDefault)
        },
        onClickDone() {

            //console.log('-------onClickDone---------', this.items.length)
            if (this.itemEdit.id == 0) { // Create                    
                this.itemEdit.id = -(this.items.filter(r => r.rec_status !== 'a').length + 1)
                this.itemEdit.rec_status = 'n'
                let _v = new Object();
                Object.assign(_v, this.itemEdit)
                this.items.push(_v)
            } else { // update
                let _i = this.items.findIndex((e) => (e.id == this.itemEdit.id))
                //console.log(i)
                if (this.itemEdit.id > 0) {
                    this.itemEdit.rec_status = 'e'
                }
                Object.assign(this.items[_i], this.itemEdit)
            }
            // update hidden field for post to server
            this.calTotalAmt()
            //var e1 = document.getElementById("modeldjson")
            //e1.value = JSON.stringify(this.items)
            document.getElementById("modeldjson").value = JSON.stringify(this.items)

        }
    },
}) 