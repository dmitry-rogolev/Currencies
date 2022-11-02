import "../node_modules/bootstrap/dist/css/bootstrap.min.css";

import { createApp, reactive, ref }     from 'vue';
import { createStore }                  from 'vuex';
import $ from "jquery";

import router   from "./lib/Router";
import cookie from "./lib/cookie";
import jquery from "./lib/jquery";
import bootstrap from "./lib/bootstrap"

import App from "./App.vue";

import FlexComponent from "./components/FlexComponent.vue";
import ModalComponent from "./components/ModalComponent.vue";
import SpinnerComponent from "./components/SpinnerComponent.vue";
import SelectComponent from "./components/form/SelectComponent.vue";
import InputComponent from "./components/form/InputComponent.vue";

const store = createStore({
    state()
    {
        return {
            header: null, 
            currencies: null, 
            originals: null, 
            visibles: null, 
            interval: null, 
            token: $('meta[name="csrf-token"]').attr('content'), 
        };
    }, 

    mutations: {
        header(state, header)
        {
            state.header = ref(header);
        }, 

        currencies(state, currencies)
        {
            state.currencies = currencies ? reactive(currencies) : ref(currencies);
        }, 

        originals(state, originals)
        {
            state.originals = originals ? reactive(originals) : ref(originals);
        }, 

        visibles(state, visibles)
        {
            state.visibles = visibles ? reactive(visibles) : ref(visibles);
        }, 

        interval(state, interval)
        {
            state.interval = ref(interval);
        }, 

        token(state, token)
        {
            state.token = ref(token);
            $('meta[name="csrf-token"]').attr('content', token);
        }, 
    }, 

    actions: {
        async currencies(context)
        {
            let data = await $.ajax({
                url: "/", 
                method: "POST", 
                data: {
                    _token: context.state.token, 
                }, 
                headers: {
                    "X-CSRF-TOKEN": context.state.token, 
                }, 
            });

            context.commit("header", data.header)
            context.commit("currencies", data.currencies);
            context.commit("originals", data.originals);
            context.commit("visibles", data.visibles);
            context.commit("interval", data.interval);
        }, 
    }, 
});

const app = createApp(App);

app.config.unwrapInjectedRef = true;

app.use(store);
app.use(router);
app.use(cookie);
app.use(jquery);
app.use(bootstrap);

app.component("FlexComponent", FlexComponent);
app.component("ModalComponent", ModalComponent);
app.component("SpinnerComponent", SpinnerComponent);
app.component("SelectComponent", SelectComponent);
app.component("InputComponent", InputComponent);

app.mount("#app");
