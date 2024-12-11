import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'

// https://vitejs.dev/config/
export default defineConfig({
  base: '/react-portfolio-template/',
  plugins: [react()],

  build: {
    outDir: 'custom-dist', // Change the output directory
    assetsDir: 'static-assets', // Customize assets directory
    sourcemap: true, // Generate source maps
  },
  css: {
    preprocessorOptions: {
      scss: {
        silenceDeprecations: ['mixed-decls'],
      },
    },
  },

  server: {
    host: true, // Enables listening on local IP
    port: 3000, // Optional: Specify a port
  },
})
