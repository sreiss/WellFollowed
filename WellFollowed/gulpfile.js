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
    ngAnnotate = require('gulp-ng-annotate'),
    templateCache = require('gulp-angular-templatecache'),
    shell = require('gulp-shell'),
    es = require('event-stream');

var bundlesRoot = "src";

var bundles = {
    "WellFollowedBundle": {
        "js": {
            "src": "Resources/src/js/**/*.js",
            "dest": "Resources/public/js",
            "fileName": "scripts.min.js"
        },
        "less": {
            "src": "Resources/src/less/**.less",
            "dest": "Resources/public/css",
            "fileName": "app.min.css"
        },
        "appTemplates": {
            "src": "Resources/src/app/**/*.html",
            "dest": "Resources/public/js",
            "module": "wfTemplates",
            "standalone": true
        },
        "appJs": {
            "src": ["Resources/src/app/**/*.js", "Resources/src/app/**.js"],
            "dest": "Resources/public/js",
            "fileName": "app.min.js"
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
        },
        "templates": {
            "dest": "Resources/public/lib/js",
            "module": "wfLibTemplates",
            "standalone": true,
            "transformUrl": function(url) {
                return "template/" + url;
            },
            "filePaths": [
                "bower_components/angular-ui-bootstrap/template/**/*.html"
            ]
        }
    }
};

var getPath = function(bundleName, directory) {
    if (Array.isArray(directory)) {
        var srcs = [];
        directory.forEach(function(dir) {
            srcs.push(path.join(bundlesRoot, bundleName, dir));
        });
        return srcs;
    }
    return path.join(bundlesRoot, bundleName, directory);
};

var getJsFilter = function() {
    return filter('**.js', {restore: true});
};

var getLessFilter = function() {
    return filter('**.less', {restore: true});
};

var getCssFilter = function() {
    return filter('**.css', {restore: true});
};

var getHtmlFilter = function () {
    return filter('**.html', {restore: true});
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
        var cssFilter = getCssFilter();
        var htmlFilter = getHtmlFilter();

        gulp.src(bowerResouces.templates.filePaths)
            .pipe(print())
            .pipe(templateCache({
                module: bowerResouces.templates.module,
                standalone: bowerResouces.templates.standalone,
                transformUrl: bowerResouces.templates.transformUrl
                //templateBody: bowerResouces.templates.templateBody
            }))
            .pipe(gulp.dest(jsPath));

        return gulp.src(bowerFiles())
            .pipe(jsFilter)
            .pipe(print())
            //.pipe(uglify())
            .pipe(concat(bowerResouces.js.fileName))
            .pipe(gulp.dest(jsPath))
            .pipe(jsFilter.restore)
            .pipe(lessFilter)
            .pipe(print())
            .pipe(less())
            .pipe(minify())
            .pipe(concat(bowerResouces.css.fileName))
            .pipe(lessFilter.restore)
            .pipe(cssFilter)
            .pipe(print())
            .pipe(minify())
            .pipe(concat(bowerResouces.css.fileName))
            .pipe(gulp.dest(cssPath))
            .pipe(cssFilter.restore);
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
                var htmlFilter = getHtmlFilter();
                var lessFilter = getLessFilter();

                if (resourceType == 'appJs') {
                    stream = gulp.src(srcPath)
                        .pipe(print())
                        .pipe(jsFilter)
                        .pipe(ngAnnotate())
                        .pipe(jsFilter.restore)
                        .pipe(concat(options.fileName))
                        .pipe(gulp.dest(destPath));
                } else if (resourceType == 'appTemplates') {
                    stream = gulp.src(srcPath)
                        .pipe(print())
                        .pipe(templateCache({
                            module: options.module,
                            standalone: options.standalone
                        }))
                        .pipe(gulp.dest(destPath));
                } else {
                    stream = gulp.src(srcPath)
                        .pipe(print())
                        .pipe(jsFilter)
                        //.pipe(uglify())
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
    }
    return;
});

gulp.task('bowerAssetic', ['bower'], shell.task('php app/console assets:install'));

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