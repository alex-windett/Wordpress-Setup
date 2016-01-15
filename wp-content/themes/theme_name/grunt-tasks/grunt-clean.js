module.exports = function(grunt) {

	grunt.config('clean', {
		dist: [
			'<%= globalConfig.css %>/**/*.css',
			'<%= globalConfig.js_concat %>/**/*.js',
			'<%= globalConfig.js_min %>/**/*.js',
			'<%= globalConfig.img_min %>/**/*',
			'<%= globalConfig.img_sprites %>/sprite-*-*.png'
		]
	});

	grunt.loadNpmTasks('grunt-contrib-clean');
};