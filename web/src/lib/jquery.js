import $ from "jquery";

export default {
    install(app)
    {
        app.config.globalProperties.$jquery = $;
    }, 
};
