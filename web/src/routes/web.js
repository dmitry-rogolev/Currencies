import Welcome from "../views/Welcome.vue";
import Route from "../lib/Route";

export default [

    Route.new("", Welcome).name("welcome").get(), 
    
];
