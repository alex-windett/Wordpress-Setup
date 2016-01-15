module.exports = function(grunt) {

	grunt.config('sprite', {

		icon: {
			src: ['<%= globalConfig.img_sprites %>/icn/*.{png,jpg,gif}'],
			dest: '<%= globalConfig.img_sprites %>/sprite-icn.png',
			destCss: '<%= globalConfig.scss %>/includes/_sprites-icn.scss',
			padding: 10,
			cssVarMap: function (sprite) {
				sprite.name = 'icn-' + sprite.name;
			},
			cssSelector: function (item) {
				item.name = '.icn-' + item.name;
			},
			'engineOpts': {
	          'imagemagick': true
	        },
			cssFormat: 'scss',
			cssSpritesheetName: 'icon',
			imgPath: '<%= globalConfig.base %>/<%= globalConfig.img_sprites %>/sprite-icn.png?v=<%= globalConfig.timestamp %>'
		},
		decoration: {
			src: ['<%= globalConfig.img_sprites %>/deco/*.{png,jpg,gif}'],
			dest: '<%= globalConfig.img_sprites %>/sprite-deco.png',
			destCss: '<%= globalConfig.scss %>/includes/_sprites-deco.scss',
			padding: 10,
			cssVarMap: function (sprite) {
				sprite.name = 'deco-' + sprite.name;
			},
			cssSelector: function (item) {
				item.name = '.deco-' + item.name;
			},
			'engineOpts': {
	          'imagemagick': true
	        },
			cssFormat: 'scss',
			cssSpritesheetName: 'decoration',
			imgPath: '<%= globalConfig.base %>/<%= globalConfig.img_sprites %>/sprite-deco.png?v=<%= globalConfig.timestamp %>'
		}
	});

	grunt.loadNpmTasks('grunt-spritesmith');
};