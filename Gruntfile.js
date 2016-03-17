module.exports = function(grunt) {

  var assets = grunt.file.readJSON('bower.json');
  var pckg   = grunt.file.readJSON('package.json');

  var sassFile = 'theme/style.sass';

  grunt.initConfig({
    pkg: pckg,
    watch: {
      options: {
        livereload: true
      },
      copy: {
        files: ['theme/**', '!'+sassFile],
        tasks: ['copy']
      },
      sass: {
        files: [sassFile],
        tasks: ['sass']
      }
    },
    copy: {
      main: {
        src: '**',
        dest: '../themes/'+pckg.name,
        cwd: 'theme/',
        expand: true
      }
    },
    sass: {
      dist: {
        files: {
          'theme/style.css': sassFile
        }
      }
    },
    'ftp-deploy': {
      build: {
        auth: {
          host: 'pradadesigners.com',
          port: 21,
          authKey: 'key'
        },
        src: 'theme',
        dest: pckg.name,
        forceVerbose: true,
        exclusions: ['.DS_Store','screenshot.png','lib', 'images', 'hype.hyperesources', 'config.php'].map(function (file){
          return 'theme/'+file;
        })
      },
      images: {
        auth: {
          host: 'pradadesigners.com',
          port: 21,
          authKey: 'key'
        },
        src: 'theme',
        dest: pckg.name,
        forceVerbose: true,
        exclusions: ['.DS_Store','lib','hype.hyperesources'].map(function (file){
          return 'theme/'+file;
        })
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-ftp-deploy');
  grunt.registerTask('default', ['watch']);
  grunt.registerTask('deploy',    ['ftp-deploy:build']);
  grunt.registerTask('deployAll', ['ftp-deploy:images']);
};