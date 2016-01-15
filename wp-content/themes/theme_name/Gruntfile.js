module.exports = function (grunt) {

	var timestamp = new Date().getTime(); 

	var globalConfig = {
		project: 'yesplus',
		assets : 'assets',

		base: '/wp-content/themes/yesplus',

		js           : '<%= globalConfig.assets %>/js',
		css          : '<%= globalConfig.assets %>/css',
		scss         : '<%= globalConfig.assets %>/scss',
		scss_includes: '<%= globalConfig.scss %>/includes',
		bower        : '<%= globalConfig.assets %>/bower_components',
		img          : '<%= globalConfig.assets %>/img',

		img_src    : '<%= globalConfig.img %>/src',
		img_min    : '<%= globalConfig.img %>/min/src',
		img_sprites: '<%= globalConfig.img %>/sprites',

		js_min   : '<%= globalConfig.js %>/min',
		js_concat: '<%= globalConfig.js %>/concat',
		js_custom: '<%= globalConfig.js %>/<%= globalConfig.project %>',

		timestamp: timestamp
	};

	grunt.initConfig({
		pkg         : grunt.file.readJSON('package.json'),
		globalConfig: globalConfig,
	});

	// Load tasks
	grunt.loadTasks('grunt-tasks');
	grunt.loadNpmTasks('grunt-newer');

	// Register tasks
	grunt.registerTask('common', [
		'scss_images',
		'newer:sprite',
		'sass_globbing',
		'concat',
		'uglify',
		'sass:dist'
	]);
	grunt.registerTask('default', [
		'common',
		'newer:imagemin',
		'replace:images'
	]);
	grunt.registerTask('dev', [
		'common',
		'watch'
	]);
};