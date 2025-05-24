<template>
  <div class="inner-page">
      <div class="cust-pad">
          <div class="row">

            <!-- left for orders -->
            <div class="col-md-6">
                  <orders 
                     :carts.sync="carts" :user-id="auth.id"
                     :users="users"
                     :client="client_id"
                     v-on:remove="setCart"
                     v-on:update="setCart"
                     @updateClient="(value)=>client_id =value "
                  
                      />
                     
            </div>

          <!--  tab for rigth for priducts -->
            <div class="col-md-6">
                <!-- start products -->
                <div class="card bg-white list-products">
                      <!-- filter -->
                     
                      <div
                        class="card-header search-products d-flex align-items-center"
                        id="headingOne"
                      >
                        <div class="head-item">
                          <div class="row">
                            <div class="col-md-12">
                              <div class="search-barcode">
                                <img src="/pos/images/barcode.jpg" />
                                <input
                                  class="form-control"
                                  type="text"
                                  v-model="search"
                                  @input="filterInput"
                                  @keypress.enter="fireProductHandlerFiler"
                                  :placeholder="$t('main.search_by')"
                                />
                              </div>
                            </div>
                            <div class="col-md-6">
                              <select class="select form-control" v-model="category_id" name="category_id"  v-select2="category_id">
                                <option value="">{{ $t("main.all_catagroies") }}</option>
                                <template v-for="category in categories">
                                  
                                  <optgroup
                                    v-if="category.sub_categories.length > 0"
                                    :label="category.title"
                                    :key="'cate' + category.id"
                                  >
                                    <option
                                      v-for="subcategory in category.sub_categories"
                                      :value="subcategory.id"
                                      :key="`sub_${category.id}_${subcategory.id}`"
                                    >
                                      {{ subcategory.title }}
                                    </option>
                                  </optgroup>
                                  <option v-else :key="'cate' + category.id" :value="category.id">
                                    {{ category.title }}
                                  </option>
                                </template>
                              </select>
                            </div>
                            <div class="col-md-6">
                              <select class="select form-control" v-model="brand_id" name="brand_id" v-select2="brand_id">
                                <option value="">{{ $t("main.all_brands") }}</option>
                                <option v-for="brand in brands" 
                                :key="'brnad' + brand.id" 
                                :value="brand.id"
                                >
                                {{ brand.title}}
                                </option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <button
                          class="btn btn-link btn-block text-left"
                          type="button"
                          data-toggle="collapse"
                          data-target="#collapseOne"
                          aria-expanded="true"
                          aria-controls="collapseOne"
                        ></button>
                      </div>

                      <!-- end filter -->

                      <!-- list products  -->
                      <div
                        id="collapseOne"
                        class="collapse show"
                        aria-labelledby="headingOne"
                        
                      >
                        <div class="card-body">
                          <div class="products">
                          
                              <div class="row">

                                  <div
                                  class="col-md-3 col-6"
                                
                                  v-for="(product, index) in products"
                                  :key="`${index}_products`"
                                    
                                  >
                                      <template v-if="!loadinginsAdd.hasOwnProperty(`product_${product.id}`)">
                                         <product-component :product="product" @click.native="()=>openModelProduct(index)"/>
                                      </template> 
                                      <template  v-else>
                                         <div class="product-blk d-flex justify-content-center  align-items-center" data-toggle="tooltip" data-placement="bottom" title="Product Code" 
                                         style="min-height:165px" >
                                                 <loading />
                                         </div>
                                      </template>
                                   
                                  </div> 

                              </div>
                              <div class="row">
                                  <div class="col-md-12">
                                      <infinite-loading :identifier="productinfiniteId"  @infinite="productsHandler">
                                                  <div slot="no-results">No More</div>
                                      </infinite-loading>
                                  </div>
                              </div>
                          
                          </div>
                        </div>
                      </div>
                      <!-- end list product  -->
                </div>
                <!-- end products -->
                <!-- start transaction -->
                <transaction
                   :routes="routes" 
                   v-on:refund="(refund)=> $emit('total',refund*-1 )" 
                   :user="auth"
                   />
                <!-- end transaction -->
            </div>

          </div>
      </div>

      <!-- variation Model -->
      <product-variation-modal  v-on:add="setCart" :product="product" :user-id="auth.id" />

      <!-- Payment Model  -->
      
      <payment-modal :carts="carts" :user-id="auth.id"
        :auth="auth"
        :client-id="client_id"
        v-on:payment="paymentConfrim"
       
       />

  </div>
</template>

<script>
import ProductComponent from "./ProductComponent";
import ProductAddonModal from "../modals/productAddonModal";
import service from "../../services/index.js"
import productVariationModal from '../modals/productVariationModal.vue';
import services from '../../services/index.js';
import PaymentModal from '../modals/paymentModal.vue';
import Transaction from '../transaction/Transaction.vue';
export default {
  props:["auth","users", "defultClient", "totalDisplay", "routes"],
  components: {
    ProductComponent,
    productctModal :ProductAddonModal,
    productVariationModal :productVariationModal,
    PaymentModal,
    Transaction
  },
  computed:{
      filterSearch(){
          return `${this.brand_id}&${this.category_id}`
      }
  },
  watch:{
      filterSearch:function(){
          this.fireProductHandlerFiler()
      }
  },
  methods:{
      addTest(){
          this.categories.push({...this.categories[0]})
      },
      productsHandler($state){
        service.productService.list({
            page:this.pageProducts ,
            search:this.search,
            // branch_id:this.auth.branch_id ,
            category_id:this.category_id ,
            display_type:"pos"

        }).then(res=>{
            let products = res.data.data.products
            if(products.data.length > 0)  this.products.push(...products.data)
            if(products.links.next){
                 this.pageProducts += 1;
                  $state.loaded();
                 
            }else{
                $state.complete();
            }
           
        })   
      },
      getCartContent(){
        services.cartService.current(this.auth.id)
          .then((res)=>{this.carts =  res.data.data;this.orderLoading = true })
          .catch((err)=>{
            this.handleErrorInAjex
            this.orderLoading = true
          })
      },
      filterInput:_.debounce(function(){
         this.fireProductHandlerFiler()
      }, 500),
      fireProductHandlerFiler(){
            this.pageProducts = 1;
            this.productinfiniteId +=1;
            this.products=[]
      },
      openModelProduct(index){
         
        this.product = this.products[index]
        if(productAddonModal && this.product.variations_values.length > 0){
           productAddonModal.modal()
         
          
        }
        else{
          this.addProduct(this.product)
        }
      
      },
      addProduct(product){

              this.$set( this.loadinginsAdd,`product_${product.id}`, product.id  )
              service.cartService.addToCart({
                  user_token:this.auth.id,
                  product_type:'product',
                  product_id:product.id,
                  // qty:1

              })
              .then((res)=>{
                this.$delete(this.loadinginsAdd, `product_${product.id}`) 
                this.successAdded(res)
              })
              .catch(err=>{
                this.handleErrorInAjex(err)
                this.$delete(this.loadinginsAdd, `product_${product.id}`) 
              })
       },
       successAdded(data){
              
                this.$toast.success(this.$t("main.add_success"));
                toast.success()
                this.setCart(data.data.data)
      },
      setCart(data){
        if(data)
          data.items.sort((a, b) => (a.add_at > b.add_at) ? 1 : -1)
        this.carts = data
      } ,
      handleErrorInAjex(error){
            let res = error.response
            if(res) this.$toast.error(res.data.message );
      },
      paymentConfrim(data){
        
                this.$toast.success( this.$t("main.order_created"));
                toast.success()
                this.carts = null
                this.$emit("total",  data.total)
                this.$root.$emit('order_created', data) 
              
      }

  },
  created() {
    //set 
    this.client_id = this.defultClient
    // set client id
    // if(this.users.length > 0) this.client_id = this.users[0].id
    // get current cart
    this.getCartContent()
    //  get categories 
    service.categoryService.getMianCategory()
                    .then(res=>this.categories = res.data.data)
    // brands
    service.brnadService.list()
                    .then(res=>this.brands = res.data.data)   
                    
   
  },
 
  mounted(){

    // register event for model
    var _instance = this
    $("#product-addon").on("hidden.bs.modal", function(){
                // put your default event here
          _instance.product = null  
    });
   
       
  },
  data() {
    return {
      categories:[],
      brands:[],
      products:[],
      product:null,
      test: "",
      brand_id:"",
      category_id:"",
      search:"",
      pageProducts: 1,
      productinfiniteId: new Date(),
      carts:null ,
      client_id:null,
      orderLoading:false,
      loadingSaveOrder : false ,
      loadinginsAdd : {},
    };
  },
};
</script>
