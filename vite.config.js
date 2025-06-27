// vite.config.js

import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import fs from 'fs';
import path from 'path';

const getFiles = (dir, ext, fileList = []) => {
    if (!fs.existsSync(dir)) {
        return fileList;
    }

    const files = fs.readdirSync(dir);
    files.forEach(file => {
        const filePath = path.join(dir, file);
        if (fs.statSync(filePath).isDirectory()) {
            getFiles(filePath, ext, fileList);
        } else if (path.extname(file) === ext) {
            fileList.push(filePath.replace(/\\/g, '/'));
        }
    });
    return fileList;
};

const cssFiles = getFiles('resources/css', '.css');
const jsFiles = getFiles('resources/js', '.js');

export default defineConfig({
    plugins: [
        laravel({
            input: [...cssFiles, ...jsFiles],
            refresh: true,
        }),
    ],
});