import TheShipping from "./components/TheShipping";
import Vue from "vue";

new Vue({
    el: '#shipping-page',
    components:{
        TheShipping
    }
})

window.addEventListener( "pageshow", function ( event ) {
    const historyTraversal = event.persisted ||
        ( typeof window.performance != "undefined" &&
            window.performance.getEntriesByType("navigation")[0].type === "back_forward" );
    if ( historyTraversal ) {
        window.location.reload();
    }
});