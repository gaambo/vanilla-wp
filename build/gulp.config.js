export default {
  srcDir: "./src",
  dstDir: "./public/wp-content/themes/vanilla",
  styles: {
    srcDir: "./src/css",
    src: "main.scss",
    dstDir: "./public/wp-content/themes/vanilla/assets/css",
    prefixBrowsers: ["last 2 versions", "> 2%"]
  },
  scripts: {
    srcDir: "./src/js",
    src: "**/*.js",
    dstDir: "./public/wp-content/themes/vanilla/assets/js",
    babelPreset: "@babel/preset-env",
    bundleName: "bundle",
    requires: []
  },
  images: {
    srcDir: "./src/images",
    dstDir: "./public/wp-content/themes/vanilla/assets/images"
  },
  translate: {
    srcDir: "./public/wp-content/themes/vanilla",
    dstDir: "./public/wp-content/themes/vanilla/languages"
  },
  otherFiles: [
    // examples:
    // "./src/fonts/**/*",
    // {
    //   origPath: ["node_modules/optinout.js/dist/optinout.js"],
    //   path: "web/app/themes/efs/assets/libs/"
    // },
    // {
    //   origPath: ["node_modules/optinout.js/dist/optinout.js"],
    //   base: "node_modules/optinout.js",
    //   path: "web/app/themes/efs/assets/libs/"
    // }
  ]
};
