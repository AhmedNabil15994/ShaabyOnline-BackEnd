<template>
    <div>
       <div v-if="errors" style="background:red" class=" text-white p-2 mb-2">
        <div v-for="(v, k) in errors" :key="k">
            <ul style="list-style:decimal;important">
                <li v-for="error in v" :key="error" class="text-sm">
                {{ error }}
                </li>
            </ul>
        </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['errors'],
        
    }
</script>
