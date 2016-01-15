module.exports = function(grunt) {
	
	grunt.config('jshint', {
		options: {
			node: true
		},
		all: [
			'Gruntfile.js',
			'<%= globalConfig.js_concat %>/app.js'
		]
	});

	grunt.loadNpmTasks('grunt-contrib-jshint');
};