<template>
   <div class="modal fade" id="product-addon" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i>
                    </button>
                    <template v-if="product">
                        <div class="item-addon d-flex align-items-center">
                            <div class="p-img">
                                <img class="img-fluid" :src="product.image" alt="">
                            </div>
                            <div>
                                 <h3>{{ product.title }}</h3>
                                 <div class="text-secondary">{{ product.sku }} -  <product-price :product="product" /> </div>
                                
                            </div>
                           
                            
                            
                        </div>
                        
                       

                        <form class="dashboard-form" autocomplete="off">
                            <template v-if="product.variations_values.length  > 0">
                                <div class="form-group" v-for="(option , index ) in product.products_options" :key="'model_option_'+option.id">
                                    <template v-if="option.id == 1">
                                            <label class="d-block">{{option.title}}</label>
                                            <div class="list-colors">

                                                <div   v-for="optionValue in option.option_values "  :key="'valeu_option_'+optionValue.option_value_id"
                                                    :class="{color:1,'selected': search[`${index}`] == optionValue.option_value_id }"
                                                >
                                                    <input type="radio" name="color" :value="optionValue.option_value_id"  
                                                        @change="(event)=>addSearchOption(index, event.target.value)"
                                                    />
                                                   

                                                    <span >
                                                        <i  class="bullet" :style="{ backgroundColor: optionValue.option_value.toLowerCase() }" > </i>
                                                        {{ optionValue.option_value }}
                                                    </span>

                                                </div>


                                                
                                                
                                            </div>
                                    </template> 

                                   <template v-else>
                                            <label class="d-block">{{option.title}}</label>
                                            <div class="list-colors">

                                                <div   v-for="optionValue in option.option_values "  :key="'valeu_option_'+optionValue.option_value_id"
                                                    :class="{color:1,'selected': search[`${index}`] == optionValue.option_value_id }"
                                                >
                                                    <input type="radio" name="color" :value="optionValue.option_value_id"  
                                                        @change="(event)=>addSearchOption(index, event.target.value)"
                                                    />
                                                   

                                                    <span >
                                                        <!-- <i  class="bullet" :style="{ backgroundColor: optionValue.option_value.toLowerCase() }" > </i> -->
                                                        {{ optionValue.option_value }}
                                                    </span>
                                                    
                                                </div>


                                                
                                                
                                            </div>
                                    </template>      

                                    <!-- <template v-else>
                                        <label class="d-block">{{ option.title }}</label>
                                        <select class="nice-select form-control"
                                            @change="(event)=>addSearchOption(index, event.target.value)"
                                        >
                                            <option selected  :value="-1">{{$t("main.select", {name: option.title })}}</option>
                                            <option v-for="optionValue in option.option_values  " :value="optionValue.option_value_id" :key="'valeu_option'+optionValue.id">{{ optionValue.option_value }}</option>
                                        </select>
                                    </template> -->

                                </div>
                                <div class="text-center">
                                    <button class="btn btn-lg btn-info" type="button" @click.prevent="searchFind" >
                                        {{ $t("main.find_variation")}}
                                    </button>
                                </div>
                                <div v-if="variation" class="my-3">
                                        <div class="item-addon d-flex align-items-center">
                                            <div class="p-img">
                                                <img class="img-fluid" :src="variation.image" alt="">
                                            </div>
                                            <div>
                                                <h4>{{ variation.sku }}</h4>
                                                <div class="text-secondary"> -  <product-price :product="variation" /> </div>
                                                
                                            </div>
                                        
                                            
                                            
                                        </div>
                                </div>
                            </template>
                            

                            <!--    
                                <label class="d-block">More Options</label>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" id="customRadio1" name="customRadio" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio1">Choose Option - 1</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" id="customRadio2" name="customRadio" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio2">Choose Option - 2</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" id="customRadio3" name="customRadio" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio3">Choose Option - 3</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" id="customRadio4" name="customRadio" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio4">Choose Option - 4</label>
                                </div>
                            </div> -->
                            
                            <div class="form-group mt-20">
                                
                            <button class="btn btn-block btn-sumbit add-product" type="button"  v-if="allowAdded">
                                {{ variation ? $t("main.add_variation") :$t("main.add_product") }}
                            </button>
                                 <button class="btn btn-block btn-danger disabled " type="button"  v-else>{{ $t("main.out_of_stock") }}</button>
                               
                            </div>
                        </form> 
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ProductPrice from '../products/ProductPriceComponent'
    export default {
      components:{
           ProductPrice
          
        },
         watch:{
            product(val){
                if(val == null){
                   this.search = [] ,
                   this.variation = null
                }
            }
        },
        props:["product"],
        created(){
            
        },
        methods:{
            addSearchOption(index, value, type="select"){
             
              if(type == "checkbox" && value == false){
                  delete this.search[index]
              }  
              this.$set(this.search, `${index}`, Number(value)) 
            },
            searchFind(){
                let values = Object.values(this.search)
                values.sort(function(a, b){return a - b});
               
                var variation = this.product.variations_values.find(variations_value => {
        
                    let valuesPluck = valuesPluck= variations_value.variations.map((value)=>value.option_value_id)
                    valuesPluck.sort(function(a, b){return a - b});

                    return JSON.stringify(values) === JSON.stringify(valuesPluck)
                });
               this.variation = variation
               if(!this.variation){
                  swal({
                        title: "",
                        text: this.$t("main.no_vairaition"),
                        type: "error",
                       timerProgressBar:true,
                       timer: 2000,
                        animation: true,
                        customClass: {
                            popup: 'animated tada'
                        }
                    })
               }
            }
        },
        computed:{
            allowAdded(){
                if(this.variation){
                    return true
                }else if(this.product){
                    return this.product.qty > 0
                }else{
                    return false
                }
            }
        },
        data(){
            return {
                variation:null ,
                search:{}, 
            }
        }
    }
</script>
