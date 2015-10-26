var gulp = require('gulp'),
    concat = require('gulp-concat'),
    print = require('gulp-print'),
    path = require('path'),
    del = require('del'),
    less = require('gulp-less'),
    filter = require('gulp-filter'),
    minify = require('gulp-minify-css'),
    uglify = require('gulp-uglify'),
    bowerFiles = require('main-bower-files'),
    shell = require('gulp-shell'),
    es = require('event-stream');

var bundlesRoot = "src";

var bundles = {
    "WellFollowedBundle": {
        "js": {
            "src": "Resources/src/js/**/*.js",
            "dest": "Resources/public/js",
            "fileName": "app.min.js"
        },
        "less": {
            "src": "Resources/src/less/**.less",
            "dest": "Resources/public/css",
            "fileName": "app.min.css"
        }
    }
};

var bowerConfig = {
    "WellFollowedBundle": {
        "js": {
            "dest": "Resources/public/lib/js",
            "fileName": "lib.min.js"
        },
        "css": {
            "dest": "Resources/public/lib/css",
            "fileName": "lib.min.css"
        }
    }
};

var getPath = function(bundleName, directory) {
    return path.join(bundlesRoot, bundleName, directory);
};

var getJsFilter = function() {
    return filter('**.js', {restore: true});
};

var getLessFilter = function() {
    return filter('**.less', {restore: true});
};

gulp.task('clean', function() {
    var srcPaths = [];
    for (var bundleName in bundles) {
        var resources = bundles[bundleName];
        for (var resourceType in resources) {
            var directories = resources[resourceType];

            var srcPath = getPath(bundleName, directories.dest, '**');
            srcPaths.push(srcPath);
        }
    }
    return del(srcPaths);
});

gulp.task('cleanLib', function() {
    var libPaths = [];
    for (var bundleName in bowerConfig) {
        var bowerResouces = bowerConfig[bundleName];

        var jsPath = getPath(bundleName, bowerResouces.js.dest);
        var cssPath = getPath(bundleName, bowerResouces.css.dest);

        libPaths.push(jsPath);
        libPaths.push(cssPath);
    }
    return del(libPaths);
});

gulp.task('bower', ['cleanLib'], function() {
    var srcPaths = [];
    for (var bundleName in bowerConfig) {
        var bowerResouces = bowerConfig[bundleName];

        var jsPath = getPath(bundleName, bowerResouces.js.dest);
        var cssPath = getPath(bundleName, bowerResouces.css.dest);

        var jsFilter = getJsFilter();
        var lessFilter = getLessFilter();

        gulp.src(bowerFiles())
            .pipe(jsFilter)
            //.pipe(uglify())
            .pipe(concat(bowerResouces.js.fileName))
            .pipe(gulp.dest(jsPath))
            .pipe(jsFilter.restore)
            .pipe(lessFilter)
            .pipe(less())
            .pipe(minify())
            .pipe(concat(bowerResouces.css.fileName))
            .pipe(gulp.dest(cssPath))
            .pipe(lessFilter.restore);
    }
});

gulp.task('resources', ['clean'], function() {
    for (var bundleName in bundles) {
        var resources = bundles[bundleName];
        for (var resourceType in resources) {
            var stream;
            var options = resources[resourceType];

            if (!!options.src && !!options.dest) {
                var srcPath = getPath(bundleName, options.src);
                var destPath = getPath(bundleName, options.dest);

                var jsFilter = getJsFilter();
                var lessFilter = getLessFilter();

                stream = gulp.src(srcPath)
                    .pipe(print())
                    .pipe(jsFilter)
                    .pipe(uglify())
                    .pipe(jsFilter.restore)
                    .pipe(lessFilter)
                    .pipe(less())
                    .pipe(minify())
                    .pipe(lessFilter.restore)
                    .pipe(concat(options.fileName))
                    .pipe(gulp.dest(destPath));
            }
        }
    }
});

gulp.task('assetic', ['resources'], shell.task('php app/console assets:install'));

gulp.task('default', ['resources'], function() {
    for (var bundleName in bundles) {
        var resources = bundles[bundleName];
        for (var resourceType in resources) {
            var stream;
            var options = resources[resourceType];

            if (!!options.src && !!options.dest) {
                var srcPath = getPath(bundleName, options.src);

                gulp.watch(srcPath, ['assetic']);
            }
        }
    }
});