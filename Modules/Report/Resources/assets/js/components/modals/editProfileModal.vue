<template>
    <div class="modal fade" id="edit-profile" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"><i class="ti-pencil"></i> {{$t("main.edit_profile")}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="ti-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form class="dashboard-form" 
                        method="post" action="#" autocomplete="off"
                          @submit.prevent="submit"  
                         >
                    <error-laravel  v-if="errors" :errors="errors"/>    
                    <div class="form-group">
                        <label>{{$t("main.name")}}</label>
                        <input class="form-control" v-model="user.name" type="text" name="name"  required="" autocomplete="off">
                    </div>
                   
                    <div class="form-group">
                        <label>{{$t("main.email")}}</label>
                        <input class="form-control" v-model="user.email" type="email" name="" value="johansmith@gmail.com" required="" autocomplete="off">
                    </div>
                    <div class="form-group phone-block">
                        <label>{{$t("main.mobile")}}</label>
                        <input class="form-control"  v-model="user.mobile" id="phone" type="tel" name=""  value="98658 7856" required="" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>{{$t("main.password")}}</label>
                        <input class="form-control" v-model="user.current_password" type="text" name="" placeholder="Current Password" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>{{$t("main.new_password")}}</label>
                        <input class="form-control" v-model="user.password" type="text" name="" placeholder="New Password" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>{{$t("main.new_password_confirmation")}} </label>
                        <input class="form-control" v-model="user.password_confirmation" type="text" name="" placeholder="Retype Password" autocomplete="off">
                    </div>
                    <div class="form-group" v-if="loadingSave == false">
                        <button class="btn btn-block btn-sumbit" type="submit">{{$t("main.edit_profile")}}</button>
                    </div>
                    <loading v-else />
                </form> 
            </div>
        </div>
    </div>
</div>
</template>

<script>
    import userService from "../../services/user.servie";
import errorLaravel from '../error/errorLaravel.vue';
    export default {
  components: { errorLaravel },
        props:["auth", "url"],
        data(){
            return {
               user:{
                    name:this.auth.name,
                    email:this.auth.email,
                    current_password:"",
                    password:"",
                    password_confirmation:"" ,
                    mobile:this.auth.mobile
                  
               },
               loadingSave:false,
               errors:null
            }
        },
        methods:{
            submit(){
            this.loadingSave = true;    
            userService.updateProfile(this.url, this.user)
                .then((res)=>{
                    this.errors = null
                    this.loadingSave = false; 
                    this.$toast.success("Updated Success")
                    toast.success()
                    this.$emit("update",{
                            ... this.auth ,
                            name:this.user.name,
                            email:this.user.email
                        })

                })
                .catch((error)=>{
                    let res = error.response
                    if("data" in res)this.errors = res.data.errors
                    else this.errors = null
                    this.$toast.error("Error validation check messages")
                    this.loadingSave = false; 
                    
                })
            }
        }
    }
</script>
