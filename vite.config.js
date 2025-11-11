import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    base: '/', // مهم لتوليد روابط صحيحة في public/build
    server: {
        // فقط إذا كنت تستخدم سيرفر تطوير محلي عبر HTTPS
        https: false, // ضع true إذا تريد تشغيل السيرفر المحلي عبر https
        host: 'localhost',
        port: 5173,
    },
});
