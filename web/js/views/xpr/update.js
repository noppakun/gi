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
            mastermodel: {},    // <== pre init by id

            // itemEdit: {
            //     id: 0,
            //     // -------------------
            //     item_desc: '',
            //     qty: 0,
            //     uom: '',
            //     price: 0,
            //     remark: '',
            // },


        }
    },

    async mounted() {
        //async created() {
        this.mastermodel = JSON.parse(document.getElementById("mastermodel").value)
        let vm = this
        //var _v = new Object();
        //console.log(e1.value)
        //await axios.get('index.php?r=/xpr/api_detail&id=' + e1.value)            
        // console.log('================')
        // console.log(  mastermodel)
        await axios.get('?r=/xpr/api_detail&id=' + this.mastermodel.doc_no)
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
        onClickFocus(e) {
            //itemEdit.item_desc
            //            document.getElementById('itemEdit.item_desc').focus()
            setTimeout(() => {
                document.getElementById('itemEdit.item_desc').focus()
            }, 1000)
        },
        onVat_percentChange(e) {
            this.mastermodel.vat_percent = e.event.target.value
            this.calTotalAmt()
        },
        onVat_typeClick(e) {

            this.mastermodel.vat_type = e.event.target.value
            this.calTotalAmt()
        },
        // display aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
        calTotalAmt() {

            this.mastermodel.amount = 0

            this.items.forEach(r => {
                if (r.rec_status !== 'd') {
                    this.mastermodel.amount = this.mastermodel.amount + (Math.round(r.qty * r.price * 100) / 100);
                }
            })
            let _vat_percent = parseFloat(this.mastermodel.vat_percent)
            this.mastermodel.vat_amount = (this.mastermodel.vat_type == 'i') ?
                (this.mastermodel.amount * (_vat_percent / (100 + _vat_percent))) :
                (this.mastermodel.amount * (_vat_percent / 100))

            this.mastermodel.amount = (this.mastermodel.vat_type == 'i') ?
                this.mastermodel.amount - this.mastermodel.vat_amount :
                this.mastermodel.amount

            this.mastermodel.total_amount = this.mastermodel.amount + this.mastermodel.vat_amount

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
        onClickEdit(_item = null) { // _item = null  for creater
            //            console.log('-------------onClickEdit----', _item)
            Object.assign(this.itemEdit, (_item == null) ? this.itemDefault : _item)
            setTimeout(() => {
                document.getElementById('itemEdit.item_desc').focus()
            }, 500)
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