import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { viteStaticCopy } from 'vite-plugin-static-copy';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),

        viteStaticCopy({
            targets: [
                {
                    src: 'resources/assets/client/lgpd/',
                    dest: 'client'
                },
                {
                    src: 'resources/assets/client/themes/',
                    dest: 'client'
                },
                {
                    src: 'resources/assets/client/images',
                    dest: 'client'
                },
                {
                    src: 'resources/assets/client/bootstrap',
                    dest: 'client'
                },
                {
                    src: 'resources/assets/client/bootstrap-icons',
                    dest: 'client'
                },              
                {
                    src: 'resources/assets/client/css',
                    dest: 'client'
                },              
                {
                    src: 'resources/assets/client/js',
                    dest: 'client'
                },              
                {
                    src: 'resources/assets/admin/css',
                    dest: 'admin'
                },
                {
                    src: 'resources/assets/admin/data',
                    dest: 'admin'
                },
                {
                    src: 'resources/assets/admin/fonts',
                    dest: 'admin'
                },
                {
                    src: 'resources/assets/admin/images',
                    dest: 'admin'
                },
                {
                    src: 'resources/assets/admin/js',
                    dest: 'admin'
                },
            ]
        })
    ]
});
