import { defineConfig } from 'vite';

export default defineConfig({
  build: {
    // Output directly to the dist directory WordPress expects
    outDir: 'dist',
    emptyOutDir: true,
    rollupOptions: {
      input: './src/app.ts', // Points to your source file
      output: {
        entryFileNames: 'app.js', // Forces output to dist/app.js without random hashes
        assetFileNames: 'app.[ext]',
        chunkFileNames: 'chunk.js'
      }
    }
  }
});