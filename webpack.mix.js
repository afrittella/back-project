/**
 * Created by andreafrittella on 24/02/17.
 */

const { mix } = require('laravel-mix');

mix.copy('vendor/bower_components/jquery-form/dist/jquery.form.min.js', 'src/public/js/');
