var path = require('path');
var fs = require('fs');
var glob = require("glob");

// options is optional
glob(process.argv[2], {}, function (er, files) {
  files.forEach(function(file) {

    var destFile = path.normalize(rename(process.argv[3], file));

    mkdirp(path.dirname(destFile));

    fs.writeFileSync(destFile, fs.readFileSync(file));
  });
});

function mkdirp(dir) {
  var newDir = path.resolve(__dirname + '/../');
  for (var i = 0; i < dir.split('/').length; i++) {
    newDir = path.join(newDir, dir.split('/')[i]);
    if (!fs.existsSync(newDir)) {
      fs.mkdir(newDir)
    }
  }
}

function rename(dest, src) {
  var srcPath = src.split('/').reverse();
  return dest + srcPath[2] + '/' + srcPath[0];
}
