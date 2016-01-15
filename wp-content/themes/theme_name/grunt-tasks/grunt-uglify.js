module.exports = function(grunt) {

	grunt.config('uglify', {
		options: {
			mangle: false
		},
		js_files: {
			files: {	
				'<%= globalConfig.js_min %>/vendor.min.js': ['<%= globalConfig.js_concat %>/vendor.js'],
				'<%= globalConfig.js_min %>/ie-vendor.min.js': ['<%= globalConfig.js_concat %>/ie-vendor.js'],
				'<%= globalConfig.js_min %>/app.min.js': ['<%= globalConfig.js_concat %>/app.js']
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-uglify');
};