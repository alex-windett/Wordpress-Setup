module.exports = function(grunt) {

	grunt.config('imagemin', {
		png: {
			options: {
				optimizationLevel: 5
			},
			files: [{
				expand: true,
				cwd: '<%= globalConfig.img_src %>',
				src: ['**/*.png'],
				dest: '<%= globalConfig.img_min %>',
				ext: '.png'
			}]
		},
		jpg: {
			options: {
				progressive: true
			},
			files: [{
				expand: true,
				cwd: '<%= globalConfig.img_src %>',
				src: ['**/*.jpg'],
				dest: '<%= globalConfig.img_min %>',
				ext: '.jpg'
			}]
		}/*,
		icons: {
			options: {
				progressive: true
			},
			files: [{
				expand: true,
				cwd: '<%= globalConfig.sprites %>',
				src: ['icn-*.png', 'logo-*.png'],
				dest: '<%= globalConfig.sprites %>',
				ext: '.png'
			}]
		}
		*/
	});

	grunt.loadNpmTasks('grunt-contrib-imagemin');
};