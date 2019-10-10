const path = require('path');

module.exports = function (grunt) {
    const files = {};

    grunt.config('extensions')
        .filter(extension => extension.cssOutputFile !== '')
        .forEach(extension => {
            const cssFilePath = path.join(grunt.config('extDirectory'), extension.name, grunt.config('cssDirectory'), extension.cssOutputFile);

            files[cssFilePath] = cssFilePath
        });

    return {
        build: {
            files: files
        }
    }
};
