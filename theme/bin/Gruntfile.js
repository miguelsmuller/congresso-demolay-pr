/*global module:false, require:false*/
module.exports = function(grunt) {

  require('load-grunt-tasks')(grunt);

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    dirs: {
        css:  '../assets/css',
        sass: '../assets/sass',
        js:   '../assets/js',
        img:  '../assets/images',
        root    : '../../../../../public/.'
    },

    // Watch for changes
    watch: {
      options: {
        livereload: false
      },
      css: {
        files: ['<%= dirs.sass %>/{,*/}*.{scss,sass}'],
        tasks: ['compass']
      },
      js: {
        files: ['<%= jshint.all %>'],
        tasks: ['jshint', 'uglify']
      },
      html: {
        files: [
          '/*.{html,htm,shtml,shtm,xhtml,php,jsp,asp,aspx,erb,ctp}'
        ]
      }
    },

    // Javascript linting with jshint
    jshint: {
      options: {
        jshintrc: '.jshintrc'
      },
      all: [
        'Gruntfile.js',
        '<%= dirs.js %>/javascript.js',
        '!<%= dirs.scripts %>/*.min.js',
        'components/bootstrap-sass/vendor/assets/javascripts/bootstrap.js'
      ]
    },

    // Uglify to concat and minify
    uglify: {
      options: {
        force: true,
        mangle: false
      },
      dist: {
        files: {
          '<%= dirs.js %>/javascript.min.js': [
            //JQUERY AND JQUERY-UI
            '../assets/components/jquery/dist/jquery.min.js',
            '../assets/components/jquery-ui/ui/jquery-ui.js',

            //BOOTSTRAP SASS
            '../assets/components/bootstrap-sass/vendor/assets/javascripts/bootstrap/button.js',
            '../assets/components/bootstrap-sass/vendor/assets/javascripts/bootstrap/collapse.js',
            '../assets/components/bootstrap-sass/vendor/assets/javascripts/bootstrap/dropdown.js',
            '../assets/components/bootstrap-sass/vendor/assets/javascripts/bootstrap/tab.js',
            '../assets/components/bootstrap-sass/vendor/assets/javascripts/bootstrap/transition.js',
            '../assets/components/bootstrap-sass/vendor/assets/javascripts/bootstrap/modal.js',
            '../assets/components/bootstrap-sass/vendor/assets/javascripts/bootstrap/tooltip.js',
            '../assets/components/bootstrap-sass/vendor/assets/javascripts/bootstrap/popover.js',

            '../assets/components/superslides/examples/javascripts/jquery.easing.1.3.js',
            '../assets/components/superslides/examples/javascripts/jquery.animate-enhanced.min.js',
            '../assets/components/superslides/dist/jquery.superslides.js',

            '../assets/components/jquery.countdown/dist/jquery.countdown.js',

            '<%= dirs.js %>/javascript.js'
          ]
        }
      }
    },

    // Compile scss/sass files to CSS
    compass: {
      dist: {
        options: {
          force: true,

          config: 'config.rb',

          sassDir: 'assets/sass',
          cssDir: 'assets/css',
          imagesDir: 'assets/images',
          fontsDir: 'cpod-theme/<%= dirs.fonts %>/',
          javascriptsDir: 'cpod-theme/<%= dirs.scripts %>',

          outputStyle: 'compressed',
          relativeAssets: true,
          noLineComments: true
        }
      }
    },

    // Image optimization
    imagemin: {
      dist: {
        options: {
          optimizationLevel: 5,
          progressive: true
        },
        files: [{
          expand: true,
          cwd: '<%= dirs.images %>/',
          src: ['**/*.{png,jpg,gif}'],
          dest: '<%= dirs.images %>/'
        }]
      },
      upload: {
        files: [{
          expand: true,
          cwd: '<%= dirs.root %>/arquivos-web/',
          src: ['**/*.{png,jpg,gif}'],
          dest: '<%= dirs.root %>/arquivos-web/'
        }]
      }
    }
  });

  grunt.registerTask( 'default', ['jshint', 'uglify']);
  grunt.registerTask( 'css', [ 'compass' ]);
  grunt.registerTask( 'js', [ 'jshint', 'uglify' ]);
  grunt.registerTask( 'image', [ 'imagemin' ] );
  grunt.registerTask( 'complete', [ 'compass', 'jshint', 'uglify' ] );
};
