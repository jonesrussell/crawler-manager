import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

const port = 5173; // Set the port to match the one exposed via DDEV
const origin = `${process.env.DDEV_PRIMARY_URL}:${port}`;

export default defineConfig({
  server: {
    host: '0.0.0.0',
    strictPort: true,
    port,
    origin,
    hmr: {
      protocol: 'wss',
      host: 'crawler-manager.ddev.site',
    },
  },
  plugins: [
    laravel({
      input: 'resources/js/app.js',
      refresh: true,
    }),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false,
        },
      },
    }),
  ],
});
