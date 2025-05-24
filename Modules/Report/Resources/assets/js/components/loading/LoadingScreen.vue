<template>
   <div id="loading-side" class="d-flex justify-content-center  align-items-center" v-if="loading">
       <loading />
   </div>
</template>

<script>
    export default {
        props:['loading'],
        created(){
            this.$root.$on("loading:screen-end",()=>{
                this.loading = false;
            })
             this.$root.$on("loading:screen-start",()=>{
                this.loading = true;
            })
        }
    }
</script>

<style scoped>
#loading-side{
    position: absolute;
    background-color: #a9bcd4c7;;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
}
#loading-side::before{
    content:'';
    position: absolute;
    top: 50%;
    left: 50%;
    transform:translate(-50%,-50%)
}
</style>