(function() {
  module.exports = function(config) {
    return config.set({
      basePath: '',
      frameworks: ['jasmine'],
      files: ['test/polyfills/bind.js', 'bower_components/jquery/dist/jquery.js', 'bower_components/angular/angular.js', 'bower_components/angular-mocks/angular-mocks.js', 'src/renderer/canvas.js', 'src/easypiechart.js', 'src/jquery.plugin.js', 'src/angular.directive.js', 'test/**/*.js'],
      exclude: [],
      port: 8080,
      logLevel: config.LOG_INFO,
      autoWatch: true,
      reporters: ['progress', 'dots'],
      browsers: ['Chrome'],
      singleRun: false
    });
  };

}).call(this);
