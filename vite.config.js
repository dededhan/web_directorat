import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import fs from 'fs';
import path from 'path';

// Function to recursively find all files with a given extension
const getFiles = (dir, ext, fileList = []) => {
    // Check if the directory exists to prevent errors
    if (!fs.existsSync(dir)) {
        return fileList;
    }

    const files = fs.readdirSync(dir);
    files.forEach(file => {
        const filePath = path.join(dir, file);
        if (fs.statSync(filePath).isDirectory()) {
            getFiles(filePath, ext, fileList);
        } else if (path.extname(file) === ext) {
            // Use forward slashes for Vite compatibility
            fileList.push(filePath.replace(/\\/g, '/'));
        }
    });
    return fileList;
};

// Find all CSS and JS files
const cssFiles = getFiles('resources/css', '.css');
const jsFiles = getFiles('resources/js', '.js');

export default defineConfig({
    plugins: [
        laravel({
            // The input is now the dynamic list of all discovered files
            input: [...cssFiles, ...jsFiles],
            refresh: true,
        }),
    ],
});