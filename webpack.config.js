'use strict';

const NODE_ENV = process.env.NODE_ENV || 'development';
const LANG = process.env.LANG || 'en';
const webpack = require('webpack');
const I18nPlugin = require('i18n-webpack-plugin');
const languageConfig = require(__dirname + '/resources/lang/' + LANG + '.json');

module.exports = {

  context: __dirname + '/resources/assets/js',
  entry: {

    //user personal info
    'edit-education': './edit/education.js',
  },

  output: {
    path: __dirname + '/public/dist/js',
    filename: '[name].bundle.js',
    publicPath: "/dist/js/"
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
      fancybox: 'fancybox-3.0/jquery.fancybox.js'
    }
  },

  plugins: [
    new webpack.ProvidePlugin({
      jQuery: 'jquery',
      'window.jQuery': 'jquery',
      Popper: ['popper.js', 'default'],
    }),
    new I18nPlugin(languageConfig),
    new webpack.optimize.CommonsChunkPlugin({
      name: 'common'
    })
  ],

  watch: NODE_ENV === 'development',
  devtool: 'source-map'
};