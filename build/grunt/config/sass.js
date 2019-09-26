var path = require('path');

module.exports = {
    dev: {
        options: {
            outputStyle: 'nested',
            sourceMap: true
        },
        files: [{
            src: '<%= sassDirectory %>/<%= scssFileName %>',
            dest: '<%= cssDirectory %>/<%= cssFileName %>'
        }]
    },
    build: {
        options: {
            outputStyle: 'compressed',
            sourceMap: false
        },
        files: [{
            src: '<%= sassDirectory %>/<%= scssFileName %>',
            dest: '<%= cssDirectory %>/<%= cssFileName %>'
        }, {
            src: '<%= sassDirectory %>/GridFallback.scss',
            dest: '<%= cssDirectory %>/GridFallback.css'
        }]
    }
};
