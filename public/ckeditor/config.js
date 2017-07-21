/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function (config) {
  // Define changes to default configuration here. For example:
  // config.language = 'fr';
  // config.uiColor = '#AADC6E';

  config.contentsCss = [
    CKEDITOR.basePath + 'contents.css',
    '/lib/bootstrap-4.0.0-alpha.6/css/bootstrap-grid.css',
    '/css/admin/ckeditor.min.css'
  ];

  config.height = 500;
};