<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['test'],
        created() {
            // alert("ss")
            // console.log(this.$props)
            // axios.get("http://127.0.0.1:8000/en/cashier-dashboard/test").then(res=>console.log(res))
        }
    }
</script>
