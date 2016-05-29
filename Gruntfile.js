require('dotenv').config();
var path = require('path');

module.exports = function(grunt) {

  var assets = grunt.file.readJSON('bower.json');
  var pckg   = grunt.file.readJSON('package.json');

  var sassFile = 'theme/style.sass';

  function createDeployConfig (exclusions) {
    return {
      auth: {
        host: process.env.FTP_HOST,
        port: 21,
        username: process.env.FTP_USERNAME,
        password: process.env.FTP_PASSWORD
      },
      src: 'theme',
      dest: pckg.name,
      forceVerbose: true,
      exclusions: exclusions.map(function (file){
        return 'theme/'+file;
      })
    }
  }

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
        dest: path.join(process.env.WP_THEMES_DIR, pckg.name),
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
      build: createDeployConfig(['.DS_Store','screenshot.png','lib', 'images', 'hype.hyperesources', 'config.php']),
      images: createDeployConfig(['.DS_Store','lib','hype.hyperesources'])
    }
  });

  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-ftp-deploy');
  grunt.registerTask('default', ['watch']);
  grunt.registerTask('deploy', ['ftp-deploy:build']);
  grunt.registerTask('images', ['ftp-deploy:images']);
};