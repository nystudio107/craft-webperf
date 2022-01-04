import { createVuePlugin } from 'vite-plugin-vue2'
import ViteRestart from 'vite-plugin-restart';
import { viteExternalsPlugin } from 'vite-plugin-externals'
import { nodeResolve } from '@rollup/plugin-node-resolve';
import path from 'path';

// https://vitejs.dev/config/
export default ({ command }) => ({
  base: command === 'serve' ? '' : '/dist/',
  build: {
    emptyOutDir: true,
    manifest: true,
    outDir: '../src/web/assets/dist',
    rollupOptions: {
      input: {
        'alerts': 'src/js/alerts.js',
        'dashboard': 'src/js/dashboard.js',
        'errors-detail': 'src/js/errors-detail.js',
        'errors-index': 'src/js/errors-index.js',
        'performance-detail': 'src/js/performance-detail.js',
        'performance-index': 'src/js/performance-index.js',
        'sidebar': 'src/js/sidebar.js',
        'webperf': 'src/js/webperf.js',
      },
      output: {
        sourcemap: true
      },
    }
  },
  plugins: [
    nodeResolve({
      moduleDirectories: [
         path.resolve('./node_modules'),
      ],
    }),
    ViteRestart({
      reload: [
          './src/templates/**/*',
      ],
    }),
    createVuePlugin(),
    viteExternalsPlugin({
      vue: 'Vue',
    }),
  ],
  publicDir: '../src/web/assets/public',
  resolve: {
    alias: {
      '@': path.resolve(__dirname, './src'),
      'vue': 'vue/dist/vue.esm.js',
    },
    preserveSymlinks: true,
  },
  server: {
    fs: {
      strict: false
    },
    host: '0.0.0.0',
    origin: 'http://localhost:3001/',
    port: 3001,
    strictPort: true,
  }
});
