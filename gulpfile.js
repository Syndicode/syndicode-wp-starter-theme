// Libraries
const {src, dest, watch, series, parallel, lastRun} = require('gulp');
const autoprefixer = require('autoprefixer');
const {getBabelOutputPlugin} = require('@rollup/plugin-babel');
const commonjs = require('@rollup/plugin-commonjs');
const cssnano = require('cssnano');
const del = require('del');
const gulpLoadPlugins = require('gulp-load-plugins');
const inlineSVG = require('postcss-inline-svg');
const {nodeResolve} = require('@rollup/plugin-node-resolve');
const rollup = require('rollup');
const sortMQ = require('postcss-sort-media-queries');
const {terser} = require('rollup-plugin-terser');

// Variables
const $ = gulpLoadPlugins();
const isProd = process.env.NODE_ENV === 'production';
const isTest = process.env.NODE_ENV === 'test';
const isDev = !isProd && !isTest;

// Functions
function styles() {
  const postCssPlugins = [
    autoprefixer(),
    sortMQ({
      sort: 'mobile-first'
    })
  ];

  if (isProd) {
    postCssPlugins.push(cssnano({
      preset: 'advanced'
    }));
    postCssPlugins.push(inlineSVG());
  }

  return src('source/styles/*.scss')
    .pipe($.plumber())
    .pipe($.if(!isProd, $.sourcemaps.init()))
    .pipe($.sass.sync({
      outputStyle: 'expanded',
      precision: 10,
      includePaths: ['.']
    }).on('error', $.sass.logError))
    .pipe($.postcss(postCssPlugins))
    .pipe($.if(!isProd, $.sourcemaps.write()))
    .pipe($.rename({
      suffix: ".min"
    }))
    .pipe(dest('assets/styles'));
}

function scripts() {
  const filesList = [
    './source/scripts/main.js'
  ];

  const rollupPlugins = [
    nodeResolve(),
    commonjs(),
    getBabelOutputPlugin({
      presets: ['@babel/preset-env'],
      allowAllFormats: true
    })
  ];

  if (isProd) {
    rollupPlugins.push(terser());
  }

  return rollup.rollup({
    input: filesList,
    plugins: rollupPlugins
  }).then(bundle => {
    return bundle.write({
      dir: 'assets/scripts',
      entryFileNames: '[name].min.js',
      format: 'iife',
      sourcemap: !isProd,
      compact: true
    });
  });
}

function images() {
  return src('source/images/**/*', {
    since: lastRun(images)
  })
    .pipe($.if(isProd, $.imagemin()))
    .pipe(dest('assets/images'));
}

function fonts() {
  return src('source/fonts/**/*.{eot,svg,ttf,woff,woff2}')
    .pipe(dest('assets/fonts'));
}

function clean() {
  return del(['assets']);
}

function measureSize() {
  return src('assets/**/*')
    .pipe($.size({title: 'build', gzip: true}));
}

const build = series(
  clean,
  parallel(
    parallel(styles, scripts),
    images,
    fonts
  ),
  measureSize
);

function watcher() {
  watch('source/styles/**/*.scss', styles);
  watch('source/scripts/**/*.js', scripts);
  watch('source/fonts/**/*', fonts);
  watch('source/images/**/*', images);
}

let serve;
if (isDev) {
  serve = series(clean, parallel(styles, scripts, fonts, images), watcher);
} else if (isProd) {
  serve = build;
}

exports.serve = serve;
exports.build = build;
exports.default = build;
