const path = require("path");
const glob = require("glob");
const { rspack } = require("@rspack/core");
const { WebpackManifestPlugin } = require("webpack-manifest-plugin");
const { InjectManifest } = require("@serwist/webpack-plugin");
const { PurgeCSSPlugin } = require("purgecss-webpack-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");

module.exports = {
  mode: "production", // Enables tree shaking + minification
  entry: {
    app: "./app/index.ts",
  },

  output: {
    path: path.resolve(__dirname, "dist"),
    filename: "js/[name].[contenthash].js",
    clean: true,
    publicPath: "/",
  },

  experiments: {
    css: false, // Using CssExtractRspackPlugin instead
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
    usedExports: true, // Tree shaking
    sideEffects: true,
    minimize: true,
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

    // Generates manifest.json automatically if needed
    new WebpackManifestPlugin({
      fileName: "manifest.json",
    }),

    // PWA Service Worker
    new InjectManifest({
      swSrc: path.resolve(__dirname, "app/sw.js"),
      swDest: "sw.js",
      exclude: [/\.map$/, /hot-update\.js$/, /manifest\.json$/],
    }),

    new rspack.DefinePlugin({
      "process.env.NODE_ENV": JSON.stringify("production"),
    }),
  ],

  performance: {
    hints: false,
  },

  stats: "minimal",
};
