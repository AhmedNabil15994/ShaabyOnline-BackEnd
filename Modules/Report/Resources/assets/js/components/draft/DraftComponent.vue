<template>
    <div class="bg-white list-items mt-3">
            <h2 class="h1"> Draft #{{ drafts.length}} </h2>
             <div v-if="drafts.length > 0" class="custdata-table  res-table" style="max-height:200px  !important">
                                                    <table  class="table " >
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">Num. of Products</th>
                                                                <th scope="col">Customer</th>
                                                                <th scope="col">Sub Total</th>
                                                                <th scope="col">Total</th>
                                                               
                                                                <th scope="col" class="dataTable-action">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="table-items">
                                                            <tr v-for="(order, index) in drafts" :key="`draft_${index}_${order.id}`">
                                                                <th scope="row">#{{index+1}}</th>
                                                
                                                                <td>{{order.items.length }}</td>
                                                                <td>{{'user' in order ? order.user.name : ""}}</td>
                                                                <td>{{ currency +" "+ order.subTotal }}</td>
                                                                <td>{{ currency +" "+ order.total }}</td>
                                                                
                                                                <td class="dataTable-action">
                                                                    
                                                                     <button class="btn btn-view"
                                                                     @click.prevent="(event)=>repalceCart(index, event.target)"   
                                                                     type="button"><i class="ti-pencil"></i></button>

                                                                    <button class="btn remove-item"
                                                                     @click.prevent="()=>removeDraft(index)"   
                                                                     type="button"><i class="ti-trash"></i></button>
                                                                </td>
                                                            </tr>

                                                        
                                                        
                                                        
                                                        </tbody>
                                                    </table>
                                                    
             </div>
             <div v-else>
                  <p class="message-nofound text-center"><i class="ti-face-sad"></i> There is no Draft items</p>
             </div>
    </div>
</template>

<script>
    import services from "../../services";
    export default {
        props:["userId"],
        created(){
            this.drafts = this.getLocalStorage()
             // end 
            this.$root.$on('draft_update', (data)=>{
                // alert("ho")
                this.drafts = this.getLocalStorage()
            }) 
            
        },
        methods:{
            getLocalStorage(){
                let drafts = JSON.parse(localStorage.getItem("drafts")) 
                return drafts ? drafts : []
            },
            removeDraft(index){
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
                        this.drafts.splice(index, 1)
                        localStorage.setItem("drafts", JSON.stringify(this.drafts))
                        swal.close()
                    }
                   
                })
                // let drafts = this.getLocalStorage()
                
            },
             repalceCart(index, button){
                let draft = this.drafts[index]
                button.disabled = true
                this.$root.$emit("loading:screen-start")
                services.cartService.replaceCart({user_token:this.userId, cart:draft})
                .then(res=>{
                    let carts = res.data.data.new;
                    this.$emit("selected", carts)
                    this.drafts.splice(index, 1)
                    if(res.data.data.old.items.length > 0){
                        this.drafts.unshift(res.data.data.old);
                    }
                  
                    localStorage.setItem("drafts", JSON.stringify(this.drafts))
                    button.disabled = false
                    this.$toast.success( this.$t("main.draft_selected"));
                    toast.success()
                     this.$root.$emit("loading:screen-end")
                       
                }).catch((error)=>{
                    button.disabled = false
                    this.handleErrorInAjex(error)
                    this.$root.$emit("loading:screen-end")
                })
            },
            handleErrorInAjex(error){
                    let res = error.response
                    if(res) this.$toast.error(res.data.message );
            },
        },
        data() {
            return {
                drafts:[],
            }
        },
    }
</script>
