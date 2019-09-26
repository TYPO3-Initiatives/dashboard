module.exports = {
    dev: {
        options: {
            configFile: '../../.sass-lint.yml'
        },
        files: [
            {src: '<%= sassDirectory %>/**/*.scss'},
        ]
    },
    build: {
        options: {
            configFile: '../../.sass-lint.yml',
            formatter: 'junit',
            outputFile: '../log/sass-lint.xml'
        },
        files: [
            {src: '<%= sassDirectory %>/**/*.scss'},
        ]
    }
};