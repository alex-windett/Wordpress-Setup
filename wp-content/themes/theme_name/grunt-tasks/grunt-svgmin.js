module.exports = function(grunt) {
	
	grunt.config('svgmin', {
		dist: {
			files: [{
				expand: true,
				cwd: 'images',
				src: ['<%= globalConfig.img %>/**/*.svg'],
				dest: '<%= globalConfig.img_min %>'
			}]
		}
	});

	grunt.loadNpmTasks('grunt-svgmin');
};