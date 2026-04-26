const path = require("path");
const glob = require("glob");
const { rspack } = require("@rspack/core");
const { WebpackManifestPlugin } = require("webpack-manifest-plugin");
const { InjectManifest } = require("@serwist/webpack-plugin");
const { PurgeCSSPlugin } = require("purgecss-webpack-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");
const WebpackShellPluginNext = require("webpack-shell-plugin-next");

module.exports = {
  mode: process.env.NODE_ENV === "production" ? "production" : "development",
  entry: {
    app: "./app/index.ts",
  },

  output: {
    path: path.resolve(__dirname, "dist"),
    filename: "js/[name].[contenthash].js",
    clean: true,
    publicPath: process.env.APP_BASE_PATH || "/",
  },

  experiments: {
    css: false,
  },

  devServer: {
    static: {
      directory: path.join(__dirname, "dist"),
    },
    watchFiles: ["index.php", "templates/**/*.twig", "common/**/*.txt"],
    hot: true,
    liveReload: true,
  },

  module: {
    rules: [
      {
        test: /\.css$/i,
        use: [
          rspack.CssExtractRspackPlugin.loader,
          "css-loader",
          "postcss-loader",
        ],
      },
      {
        test: /\.(png|jpg|jpeg|gif|svg|webp|woff2?|eot|ttf)$/i,
        type: "asset/resource",
        generator: {
          filename: "assets/[hash][ext][query]",
        },
      },
      {
        test: /\.(j|t)s$/i,
        exclude: /node_modules/,
        use: {
          loader: "builtin:swc-loader",
          options: {
            jsc: {
              parser: {
                syntax: "typescript",
              },
              target: "es2018",
            },
          },
        },
      },
    ],
  },

  resolve: {
    extensions: [".ts", ".js", ".css"],
  },

  optimization: {
    usedExports: true,
    sideEffects: true,
    minimize: process.env.NODE_ENV === "production",
    minimizer: ["...", new CssMinimizerPlugin()],
  },

  plugins: [
    new rspack.CssExtractRspackPlugin({
      filename: "css/[name].[contenthash].css",
    }),

    new PurgeCSSPlugin({
      paths: [
        ...glob.sync(path.join(__dirname, "templates/**/*.twig"), {
          nodir: true,
        }),
        ...glob.sync(path.join(__dirname, "app/**/*.ts"), { nodir: true }),
      ],
      safelist: {
        standard: ["active", /^btn-/, "btn"],
      },
    }),

    new WebpackManifestPlugin({
      fileName: "manifest.json",
    }),

    new InjectManifest({
      swSrc: path.resolve(__dirname, "app/sw.js"),
      swDest: "sw.js",
      exclude: [/\.map$/, /hot-update\.js$/, /manifest\.json$/],
    }),

    new rspack.DefinePlugin({
      "process.env.NODE_ENV": JSON.stringify(
        process.env.NODE_ENV || "development",
      ),
    }),

    // Custom plugin to handle watching and PHP regeneration
    {
      apply(compiler) {
        // 1. Tell Rspack to watch non-JS files
        compiler.hooks.afterCompile.tap(
          "WatchDependenciesPlugin",
          (compilation) => {
            compilation.fileDependencies.add(
              path.resolve(__dirname, "index.php"),
            );
            compilation.contextDependencies.add(
              path.resolve(__dirname, "templates"),
            );
            compilation.contextDependencies.add(
              path.resolve(__dirname, "common"),
            );
          },
        );

        // 2. Run PHP command after every successful compilation
        compiler.hooks.done.tap("RunPHPPlugin", () => {
          const { exec } = require("child_process");
          exec("php index.php > dist/index.html", (err, stdout, stderr) => {
            if (err) {
              console.error("\x1b[31m%s\x1b[0m", "PHP Generation Error:", err);
            } else {
              console.log(
                "\x1b[32m%s\x1b[0m",
                "PHP: dist/index.html regenerated",
              );
            }
            if (stderr) console.error(stderr);
          });
        });
      },
    },
  ],

  performance: {
    hints: false,
  },

  stats: "minimal",
};
