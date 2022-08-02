import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/scss/app.scss', 
                "node_modules/bootstrap/dist/css/bootstrap.min.css", 
                "node_modules/bootstrap/dist/js/bootstrap.bundle.min.js", 
                "node_modules/jquery/dist/jquery.min.js", 
            ],
            refresh: true,
        }),
    ],
});
