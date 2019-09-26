var path = require('path');

module.exports = {
    generate: {
        files: [{
            src: '<%= sassDirectory %>/Base/**/!(*_tmp*).scss',
            dest: '<%= sassDirectory %>/_temp_base.scss'
        }, {
            src: '<%= sassDirectory %>/Widgets/**/!(*_tmp*).scss',
            dest: '<%= sassDirectory %>/_temp_widgets.scss'
        }],
        options: {
            useSingleQuotes: false,
            signature: false
        }
    }
};
