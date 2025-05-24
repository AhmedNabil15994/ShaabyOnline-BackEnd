<div class="form-group"  id="appVue">
    <label class="col-md-2">
        {{__('catalog::dashboard.products.form.international_code')}}
    </label>
    <div class="col-md-12">
        
        <input type="text" name="international_code" class="form-control" v-model="internationalCode" :value="internationalCode" data-name="international_code" @keyUp="updateInternationalCode">
        <div id="barcode-content" v-if="internationalCode != ''" style="margin: 20px;">
            <a class="btn btn-success" style="padding: 3px;" @click="downloadBarcode"><i class="fa fa-download"></i></a>
            <div id="barcode-print">
                <img id="barcode">
            </div>
        </div>
        <div class="help-block"></div>
    </div>
</div>

@push('scripts')

    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script><!-- JsBarcode is required -->
    <script src="https://unpkg.com/vue@3"></script>

    <script>
        let modelInternationalCode = "{{!empty($product) && $product->international_code ? $product->international_code : rand(111111111111,999999999999)}}";

        const {
            createApp
        } = Vue

        createApp({
            data() {
                return {
                    internationalCode: modelInternationalCode
                }
            },
             methods: {
                updateInternationalCode() {

                    JsBarcode("#barcode", this.internationalCode);
                },
                downloadBarcode(event) {
                    event.preventDefault();
                    let divContents = document.getElementById("barcode-print").innerHTML;
                    let a = window.open('', '', 'height=1000, width=2000');
                    a.document.write('<html>');
                    a.document.write('<body ><center>');
                    a.document.write(divContents);
                    a.document.write('</center></body></html>');
                    a.document.close();
                    a.print();
                }
            },
            mounted(){
                this.updateInternationalCode()
            }
        }).mount('#appVue')

    </script>
@endpush
