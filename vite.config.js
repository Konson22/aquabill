import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import html from '@rollup/plugin-html';
import globalExternals from 'vite-plugin-global-externals';
import { glob } from 'glob';

function GetFilesArray(query) {
  return glob.sync(query);
}

const pageJsFiles = GetFilesArray('resources/assets/js/*.js');
const vendorJsFiles = GetFilesArray('resources/assets/vendor/js/*.js');
const LibsJsFiles = GetFilesArray('resources/assets/vendor/libs/**/*.js');
const CoreScssFiles = GetFilesArray('resources/assets/vendor/scss/**/!(_)*.scss');
const LibsScssFiles = GetFilesArray('resources/assets/vendor/libs/**/!(_)*.scss');
const LibsCssFiles = GetFilesArray('resources/assets/vendor/libs/**/*.css');
const FontsScssFiles = GetFilesArray('resources/assets/vendor/fonts/**/!(_)*.scss');

function libsWindowAssignment() {
  return {
    name: 'libsWindowAssignment',
    transform(src, id) {
      if (id.includes('jkanban.js')) {
        return src.replace('this.jKanban', 'window.jKanban');
      } else if (id.includes('vfs_fonts')) {
        return src.replaceAll('this.pdfMake', 'window.pdfMake');
      }
    }
  };
}

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/assets/css/demo.css',
        'resources/js/app.js',
        ...pageJsFiles,
        ...vendorJsFiles,
        ...LibsJsFiles,
        'resources/js/laravel-user-management.js',
        ...CoreScssFiles,
        ...LibsScssFiles,
        ...LibsCssFiles,
        ...FontsScssFiles
      ],
      refresh: true
    }),
    html(),
    libsWindowAssignment(),
    globalExternals({
      jquery: '$'
    })
  ]
});
