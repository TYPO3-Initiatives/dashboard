var getFileArray = require('../util/getFileArray');

module.exports = function (grunt) {
    return {
        build: {
            files: getFileArray(grunt, grunt.config.get('cssJsonFiles'), 'css', grunt.config.get('cssDirectory'))
        }
    };
};