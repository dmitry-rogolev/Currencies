import cookie from "js-cookie";

export default {
    install(app)
    {
        app.config.globalProperties.$cookie = cookie;
    }, 
};
