const {
  src,
  dest,
  series,
  watch
} = require('gulp');
const autoprefixer = require('gulp-autoprefixer');
const cleanCSS = require('gulp-clean-css');
const del = require('del');
const browserSync = require('browser-sync').create();
const sass = require('sass');
const gulpSass = require('gulp-sass');
const svgmin = require('gulp-svgmin');
const cheerio = require('gulp-cheerio');
const replace = require('gulp-replace');
const fileInclude = require('gulp-file-include');
const rev = require('gulp-rev');
const revRewrite = require('gulp-rev-rewrite');
const revDel = require('gulp-rev-delete-original');
const htmlmin = require('gulp-htmlmin');
const gulpif = require('gulp-if');
const notify = require('gulp-notify');
const image = require('gulp-imagemin');
const TerserPlugin = require('terser-webpack-plugin');
const {
  readFileSync
} = require('fs');

const webp = require('gulp-webp');
const avif = require('gulp-avif');
const mainSass = gulpSass(sass);
const webpackStream = require('webpack-stream');
const plumber = require('gulp-plumber');
const path = require('path');
const zip = require('gulp-zip');
const rootFolder = path.basename(path.resolve());

const svgstore = require("gulp-svgstore");
const rename = require("gulp-rename");
const ico = require('gulp-to-ico');

// paths
const srcFolder = './source';
const buildFolder = './build'
const themeFolder = '../../eTrans';
const paths = {
  theme: themeFolder,
  srcSvg: `${srcFolder}/img/sprite/*.svg`,
  srcImgFolder: `${srcFolder}/img`,
  buildImgFolder: `${buildFolder}/img`,
  buildSpriteFolder: `${buildFolder}/img/sprite`,
  srcScss: `${srcFolder}/scss/**/*.scss`,
  buildCssFolder: `${buildFolder}/css`,
  srcFullJs: `${srcFolder}/js/**/*.js`,
  srcMainJs: `${srcFolder}/js/main.js`,
  buildJsFolder: `${buildFolder}/js`,
  srcPartialsFolder: `${srcFolder}/partials`,
  resourcesFolder: `${srcFolder}/resources`,
  faviconFolder: `${srcFolder}/favicon`,
};

let isProd = false; // dev by default

const clean = () => {
  return del([buildFolder])
}
const json = () => {
  return src([`${srcFolder}/**/**.json`])
    .pipe(dest(`${buildFolder}`))
};

//svg sprite
const svgSprites = () => {
  return src(paths.srcSvg)
    .pipe(svgstore({
      inlineSvg: true
    }))
    .pipe(rename("sprite.svg"))
    .pipe(dest(paths.buildSpriteFolder));
}

// scss styles
const styles = () => {
  return src(paths.srcScss, { sourcemaps: !isProd })
    .pipe(mainSass())
    .pipe(autoprefixer({}))
    .pipe(gulpif(isProd, cleanCSS({
      level: 2
    })))
    .pipe(dest(paths.buildCssFolder, { sourcemaps: '.' }))
    .pipe(browserSync.stream());
};


// scripts
const scripts = () => {
  return src(paths.srcMainJs)
    .pipe(plumber(
      notify.onError({
        title: "JS",
        message: "Error: <%= error.message %>"
      })
    ))
    .pipe(webpackStream({
      mode: isProd ? 'production' : 'development',
      output: {
        filename: 'main.js',
      },
      module: {
        rules: [
          {
            test: /\.m?js$/,
            exclude: /node_modules/,
            use: {
              loader: 'babel-loader',
              options: {
                presets: [
                  ['@babel/preset-env', {
                    targets: "defaults"
                  }]
                ]
              }
            }
          }
        ]
      },
      devtool: !isProd ? 'source-map' : false
    }))
    .on('error', function (err) {
      console.error('WEBPACK ERROR', err);
      this.emit('end');
    })
    .pipe(dest(paths.buildJsFolder))
    .pipe(browserSync.stream());
}

const resources = () => {
  return src([
    `${paths.resourcesFolder}/**/*`
  ])
    .pipe(dest(buildFolder))
}

const images = () => {
  return src([`${paths.srcImgFolder}/**/**.{jpg,jpeg,png,svg,gif}`])
    .pipe(gulpif(isProd, image([
      image.mozjpeg({
        // quality: 80,
        progressive: true
      }),
      image.optipng({
        optimizationLevel: 2
      }),
    ])))
    .pipe(dest(paths.buildImgFolder))
};


const video = () => {
  return src([`${paths.srcImgFolder}/**/**.{mp4,webm}`])
    .pipe(dest(paths.buildImgFolder));
};



const webpImages = () => {
  return src([`${paths.srcImgFolder}/**/**.{jpg,jpeg,png}`])
    .pipe(webp())
    .pipe(dest(paths.buildImgFolder))
};

const phpWatch = () => {
  return src([`${themeFolder}/**/*.php`])
    .pipe(browserSync.stream());
}

const watchFiles = () => {
  browserSync.init({
    proxy: 'bikas',
  });

  browserSync.watch(`${themeFolder}/*.php`).on('change', browserSync.reload);

  watch(paths.srcScss, styles);
  watch(paths.srcFullJs, scripts);
  watch(`${paths.srcImgFolder}/**/**.{jpg,jpeg,png,svg}`, images);
  watch(`${paths.srcImgFolder}/**/**.{webm,mp4,MPEG-4}`, video);
  watch(`${paths.srcImgFolder}/**/**.{jpg,jpeg,png}`, webpImages);
  watch(paths.srcSvg, svgSprites);
  watch(paths.srcSvg, svgSprites);
  watch(`${themeFolder}/*.php`, phpWatch);
}


exports.default = series(clean, json, scripts, styles, resources, images, video, svgSprites, watchFiles);

