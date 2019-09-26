var path = require('path');

module.exports = {
    generate: {
        files: [{
            src: '<%= sassDirectory %>/Base/**/!(*_tmp*).scss',
            dest: '<%= sassDirectory %>/_temp_base.scss'
        }, {
            src: '<%= sassDirectory %>/Layout/**/!(*_tmp*).scss',
            dest: '<%= sassDirectory %>/_temp_layout.scss'
        }, {
            src: '<%= sassDirectory %>/Modules/**/!(*_tmp*).scss',
            dest: '<%= sassDirectory %>/_temp_modules.scss'
        }, {
            src: '<%= sassDirectory %>/Utilities/**/!(*_tmp*).scss',
            dest: '<%= sassDirectory %>/_temp_utilities.scss'
        }],
        options: {
            useSingleQuotes: false,
            signature: false
        }
    }
};