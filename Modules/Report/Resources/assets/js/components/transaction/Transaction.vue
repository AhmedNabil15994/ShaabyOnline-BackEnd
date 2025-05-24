<template>
    <div>
           <div class="card bg-white list-products">
                                <div class="card-header search-products d-flex align-items-center" id="headingTwo">
                                    <div class="head-item">
                                        <h6>{{$t("main.transction_list")}}</h6>
                                    </div>
                                    <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"></button>
                                </div>
                                <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" >
                                    <div class="card-body">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="home" aria-selected="true"><i class="ti-check"></i> Final</a>
                                            </li>
                                            <!-- <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="profile" aria-selected="false"><i class="ti-files"></i> Quotations</a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="contact" aria-selected="false"><i class="ti-save-alt"></i> Drafts</a>
                                            </li> -->
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="home-tab">
                                                <!--<p class="message-nofound"><i class="ti-face-sad"></i> There is no Final items</p>-->
                                                <div>
                                                    <input class="form-control"
                                                        @keypress.enter="handleOrderSerach"
                                                        :placeholder="$t('main.search_orders')" 
                                                        v-model="searchOrders" 
                                                    />
                                                </div>
                                                <div class="custdata-table  res-table" style="max-height:200px  !important">
                                                    <table  class="table " >
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <!-- <th scope="col">Order Code</th> -->
                                                                <th scope="col">Num. of Products</th>
                                                                <th scope="col">Customer</th>
                                                                <th scope="col">Amount</th>
                                                                <th scope="col">Status</th>
                                                                <th scope="col">Payment Method</th>
                                                                <!-- <th scope="col">Refund</th> -->
                                                                <th scope="col" class="dataTable-action">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="table-items">
                                                            <tr v-for="(order, index) in ordersFinal" :key="`orders_${order.id}`">
                                                                <th scope="row">#{{order.id}}</th>
                                                                <!-- <td>20210308-1246216</td> -->
                                                                <td>{{order.products.length }}</td>
                                                                <td>{{order.user.name}}</td>
                                                                <td>{{ currency +" "+ order.total }}</td>
                                                                <td><span class="cbadge badge-info">{{order.order_status.title}}</span></td>
                                                                <td><span class="cbadge badge-primary">{{order.transaction}}</span></td>
                                                                <!-- <td>No Refund</td> -->
                                                                <td class="dataTable-action">
                                                                    <a href="#" @click.prevent="()=>openRefund(order, index)" class="btn btn-view"><i class="ti-eye"></i></a>
                                                                    <a href="#" @click.prevent="()=>print(order)" class="btn btn-download"><i class="ti-printer"></i></a>
                                                                    <!-- <a :href="routes.invoice.replace(':id',order.id)" class="btn btn-download"><i class="ti-download"></i></a> -->

                                                                    <!-- <button class=" btn remove-item" type="submit"><i class="ti-trash"></i></button> -->
                                                                </td>
                                                            </tr>

                                                        
                                                        
                                                        
                                                        </tbody>
                                                    </table>
                                                    <div>
                                                        <infinite-loading :identifier="orderIfiniteId"  @infinite="orderHandler">
                                                                        <div slot="no-results">No More</div>
                                                        </infinite-loading>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- tab 1 -->
                                            <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="profile-tab">
                                                <!--<p class="message-nofound"><i class="ti-face-sad"></i> There is no Quotations items</p>-->
                                                <div class="dashboard-list-box invoices with-icons margin-top-20">
                                                    <ul>
                                                        <li><i class="list-box-icon ti-receipt"></i>
                                                            <strong>Professional Plan</strong>
                                                            <ul>
                                                                <li class="unpaid">Unpaid</li>
                                                                <li>Order: #00124</li>
                                                                <li>Date: 20/03/2021</li>
                                                            </ul>
                                                            <div class="buttons-to-right">
                                                                <a href="invoice.html" class="btn btn-sumbit" target="_blank">View Invoice</a>
                                                            </div>
                                                        </li>
                                                        
                                                        
                                                    </ul>
                                                </div>
                                            </div>
                                            <!-- tab 2 -->
                                            <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="contact-tab">
                                                <div class="table-items">
                                                    <table class="table">
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row">
                                                                    <div class="product-list d-flex">
                                                                        <div class="p-img">
                                                                            <img class="img-fluid" src="/pos/images/2.jpg" alt="" />
                                                                        </div>
                                                                        <h6 class="pr-name">Samsung Galaxy S9 <br>SM-G960FZPGINS</h6>
                                                                    </div>
                                                                </th>
                                                                <td><span class="p-price">KD 25.00</span></td>
                                                                <td>
                                                                    <button class="edit-item" type="submit"><i class="ti-pencil"></i></button>
                                                                    <button class="remove-item" type="submit"><i class="ti-trash"></i></button>
                                                                </td>
                                                            </tr>
                                                        
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
            </div>
            <refund-modal 
                        :order.sync="refund" 
                        :routes="routes"
                        v-on:refund="refunHandler"
                        v-on:update:order="(value)=> refund = value"
             />
            <div class="d-none d-print-block">
                     <invoice :order="printItem" :user="user" />
             </div>
    </div>
</template>

<script>
import Invoice from '../invoice/Invoice.vue';
import RefundModal from '../modals/RefundModal.vue';
    export default {
  components: { RefundModal, Invoice },
      props:["routes", "user"] , 
      data() {
          return {
              searchOrders:"" ,
              pageOrders:1 ,
              orderIfiniteId:new Date(),
              ordersFinal:[] ,
              refund:null ,
              refundIndex:-1,
              printItem:null
          }
      },
    
      created(){
        // list currentOrder
      
        // end 
        this.$root.$on('order_created', (data)=>{
            // alert("ho")
            this.ordersFinal.unshift(data)
            this.print(data)
        }) 

      },
      methods: {
           print (item) {
               this.printItem = item
            // Pass the element id here
                this.$nextTick(()=>{
                    this.$htmlToPaper('invoice', null, ()=>{
                       
                        this.printItem = null
                   });
                    // this.$myPrint("invoice", ()=>{
                    //    this.printItem = null
                    // })
                })
          },
          handleErrorInAjex(error){
                let res = error.response
              
               if( "data" in res )this.$toast.error(res.data.message);
          },
          orderHandler($state){
                axios.get(this.routes.listOrders, {
                    params: {
                        search:this.searchOrders ,
                        page:this.pageOrders
                        }
                }).then((res)=>{
                   let data =  res.data
                   if(data.data.length > 0) this.ordersFinal.push(...data.data)
                   if(data.links.next){
                        this.pageOrders += 1;
                        $state.loaded();
                        
                    }else{
                        $state.complete();
                    }
                }).catch(this.handleErrorInAjex)
          },
          handleOrderSerach(){
              this.pageOrders = 1;
              this.ordersFinal = [],
              this.orderIfiniteId +=1
          },
          openRefund(item, index=-1){
              if(refundModal){
                  refundModal.modal()
                  this.refund =  item
                  this.refundIndex = index
              }
          },
          refunHandler(data){
              this.$emit("refund", data.refund)
              refundModal.modal('hide');
            //   this.ordersFinal[this.refundIndex] = data.order
              this.$set(this.ordersFinal, this.refundIndex, data.order)
              this.refund =  null
              this.refundIndex = -1
              toast.success()


          },
          
          
      },
    }
</script>
