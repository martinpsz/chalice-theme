import { defineConfig } from 'vite';

export default defineConfig({
  build: {
    // Output directly to the dist directory WordPress expects
    outDir: 'dist',
    emptyOutDir: true,
    rollupOptions: {
      input: './src/app.ts', // Points to your source file
      output: {
        entryFileNames: 'app.js',
        assetFileNames: (assetInfo) => {
          const fileName = assetInfo.names?.[0] ?? '';

          if (fileName.endsWith('.css')){
            return 'style.css';
          }

          return '[name].[ext]'
        }
      }
    }
  }
});