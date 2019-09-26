var path = require('path');

module.exports = function (fileTypeDirectory, jsonFileName, fileType) {
    return path.join(fileTypeDirectory, jsonFileName + '.min.' + fileType);
};
