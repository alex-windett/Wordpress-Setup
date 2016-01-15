module.exports = function(grunt) {

	grunt.config('replace', {
		images: {
			src: ['<%= globalConfig.css %>/*.css'],
			overwrite: true,
			replacements: [{
				from: /\.\.\/img\/src\//g,
				to: '../../<%= globalConfig.img_min %>/'
			}]
		}/*,
		scss: {
			src: ['<%= globalConfig.scss_includes %>/_sprites-*.scss'],
			overwrite: true,
			replacements: [{
				from: '.png',
				to: '-<%= globalConfig.timestamp %>.png'
			}]	
		}*/
	});

	grunt.loadNpmTasks('grunt-text-replace');
};