<template>
  
    <div class="modal fade" id="pay-methods" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body" v-if="carts && carts.items.length > 0">
                      <error-laravel  v-if="errors" :errors="errors"/>    
                    <div class="order-summery">
                        <h4>{{ $t("main.order_summery") }}</h4>
                        <div class="table-items">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col"># items</th>
                                        <!-- <th scope="col">Shipping</th>
                                        <th scope="col">Taxes</th> -->
                                        <th scope="col" v-for="(conditon, index) in  carts.conditions" :key="'condtion_payment_'+index">
                                            <span class="text-capitalize">
                                                {{ conditon.name.replace("_", " ")}}
                                            </span>
                                        </th>
                                        <!-- <th scope="col">Discount</th> -->
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">{{ carts.items.length}} </th>
                                        <!-- <td><span class="p-price">KD 2.00</span></td>
                                        <td><span class="p-price">KD 3.00</span></td> -->
                                        <!-- <td><span class="p-price">--</span></td> -->
                                        <td v-for="(conditon, index) in  carts.conditions" :key="'condtion_td_payment_'+index">
                                            <span class="p-price" >
                                                      {{ conditon.value}}
                                            </span>
                                        </td>
                                        <td><span class="p-price total-s">{{ currency}} {{carts.total}} </span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="payment-info">
                        <h4></h4>
                        <div class="from-group">
                            <label for="noteTextArea">{{$t("main.note")}}</label>
                             <textarea class="form-control" v-model="notes" id="noteTextArea" rows="3"></textarea>
                        </div>
                        <form>
                            <div class="payment-method d-flex justify-content-between">
                                
                                <div class="select-option-block">
                                    <img src="/pos/images/p1.png" alt="" />
                                    <div class="custom-control custom-radio custom-control-inline choose-cash">
                                        <input type="radio" v-model="paymentMethod" value="cash" id="customRadioInline11" name="customRadioInline1" class="custom-control-input" >
                                        <label class="custom-control-label" for="customRadioInline11">Cash</label>
                                    </div>
                                </div>
                                <div class="select-option-block">
                                    <img src="/pos/images/p2.png" alt="" />
                                    <div class="custom-control custom-radio custom-control-inline choose-debit">
                                        <input type="radio" v-model="paymentMethod" value="visa" id="customRadioInline8" name="customRadioInline1" class="custom-control-input">
                                        <label class="custom-control-label" for="customRadioInline8">Credit Card  / Visa</label>
                                    </div>

                                </div>
                                <div class="select-option-block">
                                    <img src="/pos/images/p3.png" alt="" />
                                    <div class="custom-control custom-radio custom-control-inline choose-bank">
                                        <input type="radio" v-model="paymentMethod" value="keynet" id="customRadioInline9" name="customRadioInline1" class="custom-control-input">
                                        <label class="custom-control-label" for="customRadioInline9">Key Net</label>
                                    </div>
                                </div>
                            </div>


                            <div class="payment-option-content bank-details" v-show="['visa','keynet'].includes(paymentMethod) ">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{$t("main.invoice_number")}}</label>
                                            <input class="form-control" v-model="invoice_number" type="text" name="" placeholder="" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="payment-option-content debit-details" v-show="false">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Enter Card Name</label>
                                            <input class="form-control" type="text" name="" placeholder="XXXX XXXX XXXX XXXX" autocomplete="off">
                                            <span class="focus-border"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Enter Expiry Date</label>
                                            <input class="form-control" type="text" name="" placeholder="MM/YY" autocomplete="off">
                                            <span class="focus-border"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Enter CVV No.</label>
                                            <input class="form-control" type="text" name="" placeholder="XYZ" autocomplete="off">
                                            <span class="focus-border"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pay-option">
                                <loading v-if="loading" />
                                <template v-else>
                                    <button class="btn cancel-btn" :disabled="loading" data-dismiss="modal" aria-label="Close">{{ $t("main.cancle") }}</button>
                                    <button class="btn btn-sumbit" :disabled="loading"   @click.prevent="payment" type="submit"> {{$t("main.pay_for") }} {{ currency}} {{carts.total}}</button>
                                </template>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import services from "../../services/index.js"
    import errorLaravel from '../error/errorLaravel.vue';
    export default {
        props: [ "carts", "auth", "clientId"],
          components: { errorLaravel },
        data(){
            return {
                paymentMethod : "cash" ,
                invoice_number: "" ,
                errors:null ,
                loading:false ,
                notes:"",
            }
        },
        methods:{
            payment(){
                if(['visa','keynet'].includes(this.paymentMethod) && this.invoice_number.length == 0){
                    this.alertMsg(this.$t("main.invoice_number_required"))
                    return 
                }

                this.loading = true
        
                this.saveOrder()
               
            },
            saveOrder(){
                   services.orderService.create({
                    user_id:this.auth.id ,
                    client_id:this.clientId,
                    payment:this.paymentMethod,
                    payment_number:this.invoice_number,
                    from_cashier:1,
                    cashier_id:this.auth.id ,
                    branch_id:this.auth.branch_id ,
                    notes : this.notes

                    }).then((res)=>{
                           let data = res.data.data
                    
                            paymentModal.modal("hide")
                            this.loading = false
                             this.paymentMethod  = "cash";
                            this.invoice_number = ""
                             this.$emit("payment", data)

                    }).catch((error)=>{
                            let res = error.response
                            if("data" in res)this.errors = res.data.errors
                            else this.errors = null
                            if(res) this.$toast.error(res.data.message );
                            this.loading = false; 
                    })
            },
            alertMsg(msg, type="error" ){
               swal({
                            title: "",
                            text:msg ,
                            type,
                            timerProgressBar:true,
                        timer: 2000,
                            animation: true,
                            customClass: {
                                popup: 'animated tada'
                            }
                    })
          }
        },
          computed:{
           couponCondtion(){
               let coupon       =  this.carts.conditions.find((condtion)=>condtion.type == "coupon_discount")
               return coupon   
           },
        //    totalDisplay(){
        //        if(this.couponCondtion) return (this.carts.total + this.couponCondtion.value).toFixed(2)
        //        return this.carts.total 
        //    }
       },
       
    }
</script>

