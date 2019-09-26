var path = require('path');

module.exports = function (fileTypeDirectory, jsonFileName, fileType) {
    return path.join(fileTypeDirectory, 'dist.' + jsonFileName + '.min.' + fileType);
};