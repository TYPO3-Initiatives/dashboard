var path = require('path'),
    getJsonFileName = require('./getJsonFileName'),
    getJsonFilesDestination = require('./getJsonFilesDestination');

module.exports = function (grunt, jsonFiles, fileType, fileTypeDirectory) {
    var files = [];

    jsonFiles.forEach(function (jsonPath) {
        var json = grunt.file.readJSON(jsonPath),
            jsonFileName = getJsonFileName(jsonPath, fileType),
            destination = getJsonFilesDestination(fileTypeDirectory, jsonFileName, fileType),
            fileObject = {
                src: [],
                dest: destination
            };

        Object.keys(json.files).forEach(function (fileKey) {
            var filePath = path.join(grunt.config.get('extDirectory'), json.files[fileKey]);
            fileObject.src.push(filePath);
        });

        files.push(fileObject);
    });

    return files;
};