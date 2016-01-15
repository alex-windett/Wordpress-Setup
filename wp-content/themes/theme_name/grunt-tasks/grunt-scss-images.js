module.exports = function(grunt) {

	grunt.config('scss_images', {
		dist: {
			options: {
				imageRoot: '<%= globalConfig.img %>',
				prefix: 'img-helper',
				relativePath: '../img/src/'
			},
			files: {
				'assets/scss/includes/_images.scss': ['<%= globalConfig.img %>/**/*.{png,jpg,gif}', '!<%= globalConfig.img_sprites %>/**/*.{png,jpg,gif}']
			}
		}
	});

	grunt.loadNpmTasks('grunt-scss-image-helpers');
};