'use strict';

const NODE_ENV = process.env.NODE_ENV || 'development';
const LANG = process.env.LANG || 'en';
const webpack = require('webpack');
const I18nPlugin = require('i18n-webpack-plugin');
const languageConfig = require(__dirname + '/resources/lang/' + LANG + '.json');

module.exports = {

  context: __dirname + '/resources/assets/js',
  entry: {

    home: './home',

    //user personal info
    'edit-personal': './edit/personal.js',
    'edit-education': './edit/education.js',
    'edit-experience': './edit/experience.js',
  },

  output: {
    path: __dirname + '/public/dist/js',
    filename: '[name].bundle.js',
    publicPath: "/dist/js/"
  },

  module: {
    loaders: [
      {
        test: /\.css$/,
        loader: 'style-loader!css-loader'
      },
      {
        test: /\.js$/,
        exclude: /(node_modules|bower_components)/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: ['babel-preset-es2015']
          }
        }
      }
    ]
  },

  resolve: {
    modules: [
      'node_modules',
      __dirname + '/public/lib'
    ],
    alias: {
      bootstrap: 'bootstrap.min.js',
      'modal-signup': './modal/signup.js',
      'modal-signin': './modal/signin.js',
      fancybox: 'fancybox-3.0/jquery.fancybox.js',
      fileupload: 'jquery-file-upload-9.19.0/js/jquery.fileupload.js',
    },
    extensions: ['.js', '.css']
  },

  plugins: [
    new webpack.ProvidePlugin({
      jQuery: 'jquery',
      'window.jQuery': 'jquery',
      Popper: ['popper.js', 'default'],
      graphql: 'graphql.js'
    }),
    new I18nPlugin(languageConfig),
    new webpack.optimize.CommonsChunkPlugin({
      name: 'common'
    })
  ],

  watch: NODE_ENV === 'development',
  devtool: 'source-map'
};

if (NODE_ENV === 'production') {
  console.log('uglify js');
  module.exports.plugins.push(
    new webpack.optimize.UglifyJsPlugin({
      compress: {
        warnings: false,
        drop_console: true,
        unsafe: true
      }
    })
  )
}