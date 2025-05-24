<template>
    <div class="modal fade" id="refund-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:60%!important">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"><i class="ti-pencil"></i> {{$t("main.show_order")}} <span v-if="order">#{{order.id}}</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="ti-close"></i>
                </button>
            </div>
            <div class="modal-body"  v-if="order">
                <form class="dashboard-form" 
                        method="post" action="#" autocomplete="off"
                          @submit.prevent=""  
                         >
                    <error-laravel  v-if="errors" :errors="errors"/>    
                    <div class="table-items">
                        <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">{{$t("main.product")}}</th>
                                <th scope="col">{{$t("main.type")}}</th>
                                <th scope="col">{{$t("main.qty")}}</th>
                                <th scope="col">{{$t("main.subtotal")}}</th>
                                <th scope="col">{{$t("main.action")}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item , index) in order.products" :key="'refund_product_'+item.id">
                               <th scope="row">
                                    <div class="product-list d-flex">
                                        <div class="p-img">
                                            <img class="img-fluid" :src="item.image" alt="" />
                                        </div>
                                        <h6 class="pr-name">{{ item.title}} <br>{{item.sku}}</h6>
                                    </div>
                                </th>
                                    <td><span class="badge " 
                                        :class="{'badge-info':item.product_type == 'variation', 'badge-primary':item.product_type != 'variation'} "
                                        >{{item.type}} </span> </td>
                                <td>
                                    <template v-if="refund.hasOwnProperty(`${index}`)">
                                        <div class="text-center">
                                            <button class="btn btn-danger"
                                                     :disabled="refund[index].qty == item.qty"
                                                     @click.prevent="()=>$set(refund[index],'qty',refund[index].qty+1)"
                                                     >+</button>
                                            <br />
                                            <span>{{refund[index].qty}}</span>
                                            <button class="btn btn-danger" :disabled="refund[index].qty == 1"
                                             @click.prevent="()=>$set(refund[index],'qty',refund[index].qty-1)"
                                            >-</button>
                                         </div>
                                    </template>
                                    <template v-else>
                                        {{ item.qty }}
                                    </template>
                                </td>
                                <td><span class="p-price">{{ currency }} {{item.total }}</span></td>
                                <td>
                                    <input type="checkbox"   @change="(event)=>addToRefund(event.target, item, index)" />
                                </td>
                            </tr>

                            <tr v-if="order.products.length == 0">
                                <td colspan="5" class="text-center">
                                    <p class="message-nofound"><i class="ti-face-sad"></i> Empty</p>
                                </td>
                            </tr>
                            
                        </tbody>
                        </table>


                    </div>
                   
                    <div class="form-group" v-if="loadingSave == false">
                        <button class="btn btn-block btn-sumbit"
                            @click.prevent="refundItems"
                          
                         :disabled="this.itemsRefund.length == 0 " type="submit">{{$t("main.refund")}} {{this.itemsRefund.length}}</button>
                         <button class="btn btn-block btn-sumbit btn-danger"
                            style="background:#dc3545 !important"
                            @click.prevent="refundOrder"
                         :disabled="this.order.order_status.code == 2 " type="submit">{{$t("main.refund_order")}} {{this.order.total}}</button>
                    </div>
                    <loading v-else />
                </form> 
            </div>

        </div>
    </div>
</div>
</template>

<script>
  
    import errorLaravel from '../error/errorLaravel.vue';
    export default {
        components: { errorLaravel },
        props:["order", "routes"],
        mounted(){
             $("#refund-modal").on("hidden.bs.modal", ()=>{
                        // put your default event here
               this.refund={};
               this.$emit("update:order", null)
            });
        },
        data(){
            return {
               refund:{},
               loadingSave:false,
               errors:null
            }
        },
        computed:{
            itemsRefund(){
                return Object.values(this.refund)
            }
        },
        methods:{
            submit(){
                this.loadingSave = true;    
           
            },
            addToRefund(elment, item, index=-1){
                if(elment.checked){
                
                    this.$set(this.refund, `${index}`, {...item})
                }else{
                    this.$delete(this.refund, `${index}`)
                }
                
            },
            refundItems(){
                this.loadingSave = true; 
                axios.post(this.routes.orderRefund, {
                    order_id: this.order.id ,
                    "type" : "items",
                    "items":this.itemsRefund
                }).then(res=>{
                    console.log(res)
                    let data = res.data
                    swal({
                            title: "",
                            text: this.$t("main.refund_success" ,{num:this.refund.length, money:data.refund}),
                            type: "info",
                            timerProgressBar:true,
                           timer: 2000,
                            animation: true,
                            customClass: {
                                popup: 'animated tada'
                            }
                    })
                    this.$emit("refund", data)
                    this.loadingSave = false;  
                    this.errors = null
                    this.refund = []

                })
                .catch(this.handleErrorInAjex)
            },
            handleErrorInAjex(error){
                this.loadingSave = false;   
                let res = error.response
            
                if("data" in res && res.status  == 422) this.errors = res.data.errors
                else this.errors = null
                if( "data" in res )this.$toast.error(res.data.message);
            },
             refundOrder(){
                   swal({
                    title: "",
                    text: this.$t("main.order_refund"),
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    closeOnConfirm: false,
                    animation: false,
                    customClass: {
                        popup: 'animated tada'
                    }
                }, (isConfirm)=>{
                    if(isConfirm){
                             this.loadingSave = true
                             axios.post(this.routes.orderRefund, {
                                order_id: this.order.id ,
                                "type" : "order",
                            }).then(res=>{
                                console.log(res)
                                let data = res.data
                                swal({
                                        title: "",
                                        text: this.$t("main.refund_order_success" ,{num:this.order.id, money:data.refund}),
                                        type: "info",
                                        timerProgressBar:true,
                                        // timer: 2000,
                                        animation: true,
                                        customClass: {
                                            popup: 'animated tada'
                                        }
                                })
                                this.$emit("refund", data)
                                this.loadingSave = false;  
                                this.errors = null
                                this.refund = []
                                this.idRefunds = []

                            })
                            .catch(this.handleErrorInAjex)
                    }
                    swal.close();
                })
               
            },
        },
    }
</script>
