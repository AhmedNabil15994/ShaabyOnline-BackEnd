<template>

     
    <div class="product-blk" data-toggle="tooltip" data-placement="bottom" title="Product Code">
        <span class="pro-price">
            <product-price :product="variation" />
        </span>
        <div class="img-box">
            <img class="img-fluid" :src="variation.image" alt="" />
        </div>
        <h3 class="pro-name">{{variation.sku}}</h3>
        <p class="pro-category">
            <span v-for="variationItem in  variation.variations" :key="'var_'+variationItem.id" >
                {{ variationItem.option_value }}
            </span>  
        </p>
        <!-- <div class="list-colors">
            <span class="badge badge-primary" v-for="option in variation.variations" :key="'variation_option_'+option.id">
                {{ option.option_value }}
            </span>
        </div>  -->
    </div>
 

</template>

<script>
    import ProductPrice from './ProductPriceComponent'
    export default {
       props:["variation"] ,
       components:{
           ProductPrice
       }
    }
</script>
