
import printJS from "print-js";
  export default {
    install(Vue, options) {
 
        Vue.prototype.$myPrint = function (selector=null, callback=null , customOptions={}) {
            
            options = {...options, ...customOptions}
            
            if(selector)  options.printable = selector
            var _elm = document.getElementById(options.printable)
            if(!_elm) return void alert("Element to print #" + options.printable + " not found!");
            options.onPrintDialogClose = callback    
            printJS(options)
        }
    }
 }