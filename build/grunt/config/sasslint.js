module.exports = function (grunt) {
  return {
    dev: {
      options: {
        configFile: '../../.sass-lint.yml'
      },
      files: [
        {src: grunt.config.get('sassDirectory') + '/**/*.scss'}
      ]
    },
    build: {
      options: {
        configFile: '../../.sass-lint.yml',
        formatter:
          'junit',
        outputFile:
          '../log/sass-lint.xml'
      },
      files: [
        {src: grunt.config.get('sassDirectory') + '/**/*.scss'}
      ]
    }
  }
};
