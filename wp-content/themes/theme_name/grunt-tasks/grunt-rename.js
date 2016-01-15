module.exports = function(grunt) {

	grunt.config('rename', {
		sprite_icn: {
			src: '<%= globalConfig.img_sprites %>/sprite-icn.png',
			dest: '<%= globalConfig.img_sprites %>/sprite-icn-<%= globalConfig.timestamp %>.png'
		},
 
		sprite_deco: {
			src: '<%= globalConfig.img_sprites %>/sprite-deco.png',
			dest: '<%= globalConfig.img_sprites %>/sprite-deco-<%= globalConfig.timestamp %>.png'
		},
	});

	grunt.loadNpmTasks('grunt-rename');
};