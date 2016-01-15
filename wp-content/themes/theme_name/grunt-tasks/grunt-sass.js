module.exports = function(grunt) {

	grunt.config('sass', {
	        dist: {     
				files: {
					'<%= globalConfig.assets %>/css/app.css':'<%= globalConfig.assets %>/scss/app.scss',
					'<%= globalConfig.assets %>/css/admin.css':'<%= globalConfig.assets %>/scss/admin.scss',
				}
		   	},
		   	options: {
		   		sourceMap: true,
                sourceMapEmbed: true,
				includePaths: [
					'<%= globalConfig.assets %>/bower_components/foundation/scss',
					'<%= globalConfig.bower %>/owl-carousel2/src/scss'
					]
			}
	});

	grunt.loadNpmTasks('grunt-sass');
};