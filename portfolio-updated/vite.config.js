import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';

// https://vitejs.dev/config/
export default defineConfig({
  base: '/portfolio/', // Adjust based on your deployment
  plugins: [react()],
  css: {
    preprocessorOptions: {
      scss: {
        silenceDeprecations: ['mixed-decls']
      },
    },
  },
  server: {
    host: true, // Enables access via local IP for development
    port: 3000,
  },
  build: {
    outDir: 'dist', // Production output folder
    sourcemap: false, // Avoid source maps unless needed
    cssCodeSplit: true, // Optimize CSS
  },
});
