module.exports = function (filePath, fileType) {
    return filePath.match(new RegExp(fileType + '-bundle\.(.+)\.json$', 'i'))[1];
};