module.exports = function(grunt)
{
	grunt.initConfig({

		// Unificar y minificar scripts
		uglify: {

			// Scripst generales
			compresor: {
				files: {
					'js/scripts.min.js': [
						// 'js/jquery-1.12.4.min.js',
						'js/owl.carousel.js',
						// 'js/jquery.placeholder.js',
						'js/jquery.swipebox.js',
						'js/placeholder.js',
						'js/scripts.js'
					]
				}
			},

			// Scripts del multidatepicker
			mi_multidatepicker: {
				/*files: {
					'js/multidatepicker.min.js': [
						'js/jquery-1.11.1.js',
						'js/jquery-ui-1.11.1.js',
						'js/jquery-ui.multidatespicker.js'
					]
				}*/
			}
		},


		// BrowserSync Task
/*        browserSync: {
            default_options: {
                bsFiles: {
                    src: [
                        "css/*.css",
                        "js/*.js",
                        "img/*.jpg",
                        "img/*.png",
                        "img/*.ico",
                        "stylus/*",
                        "*.html"
                    ]
                },
                options: {
                    proxy: "localhost/61._zimmerman/"
                }
            }
        } // browserSync*/

		// Monitorear cambios
		watch: {
			// Los Scripts
			scripts: {
				files: ['js/*.js'],
				tasks: ['uglify'],
				options: {
					spawn: false
				}
			}
			// browserSync : {}
		}
	});


	// grunt.loadNpmTasks('grunt-postcss');
	// grunt.registerTask('css', ['stylus', 'postcss']);
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-watch');
	// grunt.loadNpmTasks("grunt-browser-sync");
	// grunt.registerTask("default", ["browserSync"]);
	// grunt.loadNpmTasks('grunt-contrib-imagemin');
};

// grunt.registerTask('default', ["browserSync", "watch"]);
