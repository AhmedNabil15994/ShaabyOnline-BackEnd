<template>
     <div id="invoice"  class="" >
            <div class="ticket">
            <!-- <img src="/pos/images/logo2.png" width="50" height="50" alt=""> -->
            <p class="centered">Tocaan POS </p>

           <template v-if="order">    
                  <table  style="margin-bottom:14px">

                        <tr>
                            <th>Order ID</th>
                            <td>#{{order.id}}</td>
                        </tr>

                        <tr>
                            <th>Customer</th>
                            <td>{{order.user.name}}</td>
                        </tr>

                        <tr>
                            <th>Seller</th>
                            <td>
                                {{order.cashier.name}}
                            </td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td>{{order.order_status.title}}</td>
                        </tr>

                        <tr>
                            <th>Date</th>
                            <td>{{order.created_at}}</td>
                        </tr>


                </table>   
                <table class="table-border">
                    <thead>
                        <tr>
                            <th class="description">Product</th>
                            <th class="quantity">Q.</th>
                            <th class="price">$$</th>
                            <th class="sub-total">Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                        <tr v-for="product in order.products" :key="'order_print_'+product.id">
                                        <td class="description">{{product.title}}</td> 
                                        <td class="quantity centered">{{product.qty}}</td>
                                        <td  class="price"> {{product.selling_price}}</td>
                                        <td class="sub-total"> {{product.total}} </td>
                        </tr>
                       
                       <tr>
                            <td class="description" colspan="3"  >Total</td>
                            <td  class="total" >
                                <span> {{order.total}} {{currency}}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
           </template>
            <p class="centered">Thanks You for purchasing with us.
                <br />{{getUrl}}
                <br />(123) 123-456
            </p>
        </div>
     </div>
</template>

<script>
    export default {
        props: ['order', "user"],
        computed:{
            getUrl(){
               return $origin
            }
        }
        
    }
</script>

<style scoped>

    
</style>

