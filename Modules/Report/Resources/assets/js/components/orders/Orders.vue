<template>
    <div>
        <div class="bg-white list-items">
                        <div class="search-customer">
                            <div class="d-flex align-items-center">
                                <select class="select form-control" 
                                    v-select2="clientId"
                                    @change="handleClient"
                                     name="customers">
                                    <option :selected="user.id == clientId" v-for="user in users" :value="user.id" :key="'customer_'+user.id">
                                        {{ user.name }}
                                    </option>
                                    
                                </select>
                                <!-- <button title="New Customer" data-toggle="modal" data-target="#new-customer"><i class="ti-plus"></i></button> -->
                            </div>
                        </div>
                        <template v-if="carts && carts.items.length > 0">
                            <!--  items -->
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
                                        <tr v-for="(item) in carts.items " :key="'cart_'+item.id">
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
                                                    >{{item.product_type}} </span> </td>
                                            <td>
                                                <div class="buttons-added quantity">
                                                        <template v-if="!laodingActionsOrder.hasOwnProperty(`item_${item.id}`)">
                                                            <button class="sign plus"
                                                                :disabled="item.qty > item.max_qty "
                                                                @click.prevent="()=> increase(item)"
                                                                ><i class="fa fa-plus"></i></button>
                                                            <input type="number" :value="item.qty"
                                                                        min="1" :max="item.max_qty" 
                                                                        @keyup.enter="(event)=>changeInput(item, event.target.value)"
                                                                        title="Qty" class="input-text qty text" size="1">
                                                            <button class="sign minus"
                                                                :disabled="item.qty <= 1 "
                                                                @click.prevent="()=> decrease(item)"
                                                                ><i class="fa fa-minus"></i></button>
                                                        </template>
                                                         <loading v-else />
                                                </div>   
                                            </td>
                                            <td><span class="p-price">{{ currency }} {{item.price }}</span></td>
                                            <td>
                                                <template v-if="!laodingActionsOrder.hasOwnProperty(`item_${item.id}`)">
                                                     <button class="remove-item" @click="(event)=>delteItem(item, event.target)" type="submit"><i class="ti-trash"></i></button>
                                                </template>
                                                <loading v-else />

                                            </td>
                                        </tr>
                                        
                                    
                                    </tbody>
                                </table>
                            </div>

                            <!-- summary -->
                            <div class="total-summary">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="price-block d-flex align-items-center">
                                            <h6>No. Items</h6>
                                            <p>{{ $t("main.items_count", {number: 'count' in carts ? carts.count : 0}) }}</p>
                                        </div>
                                        <div class="price-block d-flex align-items-center">
                                            <h6>Sub Total</h6>
                                            <p>{{ currency}} {{ 'subTotal' in carts?  carts.subTotal : 0 }}</p>
                                        </div>
                                        <template 
                                        v-for="(conditon, index) in  carts.conditions"  
                                        >
                                            <div class="price-block d-flex align-items-center"  :key="'condtion_'+index" v-if="conditon.type != 'coupon_discount'">
                                                <h6>Total {{conditon.name}} </h6>
                                                <p>{{currency}} {{conditon.value}}</p>
                                            </div>
                                        </template>
                                        <!-- <div class="price-block d-flex align-items-center">
                                            <h6>Total Shipping</h6>
                                            <p>KD 27.00</p>
                                        </div> -->
                                    </div>
                                    <div class="col-md-6">
                                        <div class="price-block d-flex align-items-center">
                                            <h6>Discount</h6>
                                            <input type="text" :value="couponCondtion ? couponCondtion.value : '' " readonly class="form-control discount-inpt" />
                                            <span></span>
                                        </div>
                                        <div class="price-block d-flex align-items-center">
                                            <h6>Coupon</h6>
                                            <input type="text" @keypress.enter="(event) =>applyCoupon(event.target.value)" 
                                                :value="couponCondtion ? couponCondtion.attributes.coupon.code : '' " class="form-control discount-inpt" />
                                                <button class="btn btn-danger" v-if="couponCondtion" @click="deleteCoupon"><i class="fa fa-trash"></i> </button>
                                        </div>
                                        <div class="d-flex total-price align-items-center">
                                            <h6>Total</h6>
                                            <p>{{ currency}} {{ 'total' in carts ?  carts.total : 0 }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- buttons -->
                            <div class="total-summary final">
                                <div class="summ-actions d-flex align-items-center" >
                                    <template v-if="loading == false">
                                        <button class="btn btn-danger" @click="(event)=>deleteCart(event.target)"><i class="ti-trash"></i>{{$t("main.clear_carts")}}</button>
                                            <!-- <a class="btn btn-sumbit3" href="invoice.html" target="_blank"><i class="ti-files"></i> Quotation</a> -->
                                            <button class="btn btn-sumbit2" @click.prevent="handleDraft"><i class="ti-save-alt"></i> Draft</button>
                                            <button class="btn btn-sumbit" data-toggle="modal" data-target="#pay-methods"><i class="ti-credit-card"></i> Pay</button>
                                    </template>
                                    <template v-else >
                                        <loading />
                                    </template>
                                
                                </div>
                            </div>
                        </template>
                        <template v-else>
                            <div style="min-height:360px" class="d-flex d-flex justify-content-center  align-items-center">
                                <p class="message-nofound text-center"><i class="ti-face-sad"></i> There is no items in</p>
                            </div>
                        </template>
        </div>

        <draft-component :user-id="userId" v-on:selected="(carts)=>$emit('update', carts)" />
              
        
    </div>
</template>

<script>

import DraftComponent from '../draft/DraftComponent.vue';
import LoadingScreen from '../loading/LoadingScreen.vue';
import services from '../../services/index.js';
    export default {
  components: { DraftComponent, LoadingScreen },
       props:["carts", "userId", "users", "client"],
       created(){
           this.clientId = this.client
       },
       mounted(){
           $(".select-ajex").select2({
               ajax:{
                   "url" :"/api/users/list" ,
                    delay: 500 ,
                     data: function (params) {
                        return {
                            q: params.term, // search term
                            selectId:this.clientId,
                            "user_id":this.userId
                        };
                    },
                     processResults:  (data)=> {
                            this.users = data.data
                            return {
                                  results: data.data
                            };
                    },
               } ,
           })
       },
       methods:{
           increase(item){
               if(this.checxMaxQuqntity(item)){
                    item.qty +=1
                    this.updateItem(item)
               }
               
           },
            decrease(item){
               if(this.checxMinQuqntity(item)){
                    item.qty -=1
                     this.updateItem(item)
               }
               
           },
           changeInput(item, value){
              console.log(value)
              if(value >  item.max_qty){
                  this.alertMsg(this.$t("main.qty_max_alert"))
                 value = item.max_qty
              }
              if(value <  1){
                  this.alertMsg(this.$t("main.qty_min_alert"))
                  value = 1
              }
              item.qty  = value
              this.updateItem(item)


               
           },
           checxMaxQuqntity(item){
               if(item.qty < item.max_qty){
                   return true
               };
               this.alertMsg(this.$t("main.qty_max_alert"))
           },
           checxMinQuqntity(item){
               if(item.qty >= 1){
                   return true
               };
               this.alertMsg(this.$t("main.qty_min_alert"))
           },
           
           delteItem(item, button){
                button.disabled = true
                swal({
                    title: "",
                    text: 'Are you sure removing this item?',
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
                            this.$set( this.laodingActionsOrder,`item_${item.id}`, item.id )
                            services.cartService.removeItem(item.id, {user_token:this.userId})
                                    .then((res)=>{
                                         button.disabled = false;
                                         this.successDelteItem(res)
                                         this.$delete(this.laodingActionsOrder, `item_${item.id}`) 
                                        })
                                    .catch((error)=>{
                                        button.disabled = false;
                                         this.$delete(this.laodingActionsOrder, `item_${item.id}`) 
                                        this.handleErrorInAjex(error)
                                    })
                            swal.close()
                    }
                })
             
           
           },
           updateItem(item){
               let id           = item.id ,
                  product_type  = item.product_type 

               if(item.product_type == "variation"){
                   id = (id.split("-"))[1]
               }
               services.cartService.addToCart({
                   user_token:this.userId ,
                   product_type,
                   qty:item.qty,
                   product_id:id,
                   add_at:item.add_at
               })
               .then(this.successUpdateItem)
               .catch(this.handleErrorInAjex)
               
           
           },
            successUpdateItem(res){
               
               toast.success()
               this.$emit("update", res.data.data)
           },
           successDelteItem(res){
               
               this.$toast.success(this.$t("main.remove_success"));
               toast.success()
               this.$emit("remove", res.data.data)
           },
           handleErrorInAjex(error){
                let res = error.response
               
                this.loading = false
             
               if( "data" in res )this.$toast.error(res.data.message);
          },
          alertMsg(msg, type="error" ){
           
            this.$toast.open({
                message: msg,
                type: type,
                // all of other options may go here
            });
                
          },
          getVendors(){
              return [...new Set(this.carts.items.map((object)=>object.vendor_id ?? 0))]
          },
          applyCoupon(coupon){
            
              if(coupon.length > 0){
                  services.couponService.applyCoupon({
                      code:coupon ,
                      user_token:this.userId ,
                      vendors:this.getVendors()
                  }).then((res)=>{
                      this.carts.conditions = res.data.data.conditions
                      this.$set(this.carts,"subTotal", (this.carts.subTotal - res.data.data.discount_value).toFixed(2))
                        this.$set(this.carts,"total", (this.carts.total - res.data.data.discount_value).toFixed(2))
                      })
                  .catch(this.handleErrorInAjex)
              }else{

              }
          },
          deleteCoupon(){
            services.cartService.deleteCondtion("coupon_discount",{user_token:this.userId})
                .then(this.successUpdateItem)
            .catch(this.handleErrorInAjex)
             
          },
          deleteCart(button){
            button.disabled = true
              swal({
                    title: "",
                    text: 'Are you sure removing this Cart ؛?',
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
                           this.loading = true;
                            services.cartService.deleteCarts({user_token:this.userId})
                                .then((res)=>{
                                    this.alertMsg(this.$t("main.clear_carts"), "success")
                                    this.$emit("update", null)
                                    button.disabled = false
                                    this.loading = false;
                                })
                                .catch((error)=>{
                                    this.handleErrorInAjex(error);
                                    button.disabled = false;
                                    this.loading = false;

                                    })
                                swal.close()
                    }else{
                         button.disabled = false
                    }
                })
             
          },
          handleDraft(){
              this.loading = true
              services.cartService.handleDraft(this.userId)
              .then(res=>{
                  let draft = res.data.data;
                  if(draft){
                        draft.user = this.users.find((user)=> user.id == this.clientId)
                        let drafts = JSON.parse(localStorage.getItem("drafts"))
                        drafts ? drafts.push(draft) : drafts = [draft]
                        localStorage.setItem("drafts", JSON.stringify(drafts))
                        this.loading = false
                        this.$emit("update", null)
                        this.$root.$emit("draft_update", draft)
                  }
                 
              }).catch(this.handleErrorInAjex)
          },
          repalceCart(){
             let drafts = JSON.parse(localStorage.getItem("drafts")) 
             drafts = drafts ? drafts : []
             this.loading = true
              services.cartService.replaceCart({user_token:this.userId, cart:drafts[0]})
              .then(res=>{
                  let carts = res.data.data;
                   this.$emit("update", carts)
                    this.loading = false
                  console.log(carts);
              }).catch(this.handleErrorInAjex)
          },
          handleClient(event){
              this.clientId = event.target.value 
          }
       },
       computed:{
           couponCondtion(){
               let coupon       =  this.carts.conditions.find((condtion)=>condtion.type == "coupon_discount")
               return coupon   
           },
   
       },
       data(){
           return {
               have_discount:false,
               coupon:"",
               loading:false,
               user:null,
               laodingActionsOrder:{},
               clientId:null


           }
       }
    }
</script>
