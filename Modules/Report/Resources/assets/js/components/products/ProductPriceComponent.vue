<template>
     <span >{{ currency }} 
            <template v-if="!product.offer">
                <span>{{product.price}}</span>
            </template>
            <template v-else>
                <del style="color:red">{{product.price}}</del>
                <span>{{product.offer.offer_price}}</span>
            </template>
    </span>
</template>

<script>
    export default {
        props: ['product'],
       
    }
</script>
