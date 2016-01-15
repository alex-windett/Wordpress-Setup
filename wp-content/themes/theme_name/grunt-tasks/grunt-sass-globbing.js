module.exports = function (grunt) {

	grunt.config('sass_globbing', {
		sccs_includes: {
			files  : {
				'<%= globalConfig.scss_includes %>/__map.scss': '<%= globalConfig.scss_includes %>/*.scss'
			},
			options: {
				useSingleQuotes: false
			}
		}
	});

	grunt.loadNpmTasks('grunt-sass-globbing');
};