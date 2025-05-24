<template>
     <div id="invoice"  class="" >
            <div class="contianer-invoice container-fluid " style="margin-top:7em">
                <div id="logo">
                    <!-- <img src="/pos/images/logo2.png" alt=""> -->
                    <h3 class="text-center mb-3" style="margin-bottom:10em">Tocaan POS</h3>
                </div>

                <template v-if="order">     
                    <!-- Client & Supplier -->
                    <div class="header">
                        <div class="row no-gutters">
                            <div class="xs-8">
                                <table class="table ">

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
                            </div>
                        </div>
                    
                    </div>

                    <div class="items">
                        <div class="">
                            <div class="">
                                <table class="table table-striped">
                                    <tr>
                                            <th>Product</th>
                                            <th>Qty</th>
                                            <th>Price</th>
                                            <th>Sub Total</th>
                                    </tr>

                                    <tr v-for="product in order.products" :key="'order_print_'+product.id">
                                        <td>{{product.title}}</td> 
                                        <td>{{product.qty}}</td>
                                        <td> {{product.selling_price}}</td>
                                        <td> {{product.total}}</td>
                                    </tr>

                                    <tr>
                                        <td colspan="3"  >Total</td>
                                        <td  >
                                            <span> {{order.total}} {{currency}}</span>
                                        </td>
                                    </tr>



                                </table>
                            </div>
                        </div>
                    </div>


                    
                    
                </template >

                <!-- Footer -->
                <div id="footer" class="text-center mb-3" style="margin-bottom:2em">
                    <p>Thanks You for purchasing with us.</p>
                    <ul class="list-unstyled">
                        <li>{{getUrl}}</li>
                        <li>(123) 123-456</li>
                    </ul>
                </div>

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
