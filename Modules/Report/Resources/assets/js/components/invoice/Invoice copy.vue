<template>
     <div id="invoice"  class="container-fluid" >
            <div id="logo">
                <!-- <img src="/pos/images/logo2.png" alt=""> -->
                <h3>Tocaan POS</h3>
            </div>      
            <template v-if="order">     
                <!-- Client & Supplier -->
                <div class="info">
                    <p class="d-flex">
                        <strong class="flex-1">Order ID</strong>
                        <span> #{{order.id}}</span>
                    </p>
                    <p class="d-flex">
                        <strong class="flex-1">Customer</strong>
                        <span> {{order.user.name}}</span>
                    </p>
                    <p class="d-flex">
                        <strong class="flex-1">Seller</strong>
                        <span> {{user.name}}</span>
                    </p>
                    <p class="d-flex">
                        <strong class="flex-1">Status</strong>
                        <span > {{order.order_status.title}}</span>
                    </p>
                    <p class="d-flex">
                        <strong class="flex-1">Date</strong>
                        <span> {{order.created_at}}</span>
                    </p>
                </div>


                <!-- Invoice -->
                <div class="row">
                    <div class="col-md-12">
                        <table class="margin-top-20">
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
                        
                        </table>
                    </div>

                    <div id="totals">	
                        <table>
                            <!-- <tr>
                                <td>Shipping</td> 
                                <td><span> 10.00</span></td>
                            </tr> -->
                            <!-- <tr>
                                <td>Taxes</td> 
                                <td><span> 12.00</span></td>
                            </tr> -->
                            <tr class="total-price">
                                <td>Total</td> 
                                <td><span> {{order.total}} {{currency}}</span></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Footer -->
                <div id="footer">
                    <p>Thanks You for purchasing with us.</p>
                    <ul>
                        <li>{{getUrl}}</li>
                        <li>(123) 123-456</li>
                    </ul>
                </div>
            </template >
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
