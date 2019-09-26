var path = require('path');

module.exports = {
    options: {
        map: true,
        processors: [
            require('autoprefixer')({
                browsers: ['> 1% in NL', 'last 2 versions', 'IE >= 9', 'Android >= 4', 'Safari >= 7', 'iOS >= 7'],
                cascade: false,
                remove: false
            }),
            require('postcss-pxtorem')({
                rootValue: 16,
                unitPrecision: 5,
                propList: ['*', '!letter-spacing', '!*box*', '!line-height', '!border*', '!background*'],
                selectorBlackList: [],
                replace: true,
                mediaQuery: true,
            })
        ]
    },
    dev: {
        files: [{
            src: '<%= cssDirectory %>/<%= cssFileName %>',
            dest: '<%= cssDirectory %>/<%= cssFileName %>'
        }]
    },
    build: {
        files: [{
            src: '<%= cssDirectory %>/<%= cssFileName %>',
            dest: '<%= cssDirectory %>/<%= cssFileName %>'
        }, {
            src: '<%= cssDirectory %>/GridFallback.css',
            dest: '<%= cssDirectory %>/GridFallback.css'
        }]
    }
};
