// rspack.config.js
const path = require("path");
const { rspack } = require("@rspack/core");
const WorkboxPlugin = require("workbox-webpack-plugin");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");

module.exports = {
  mode: "production", // Enables tree shaking + minification
  entry: {
    app: "./app/index.js",
  },

  output: {
    path: path.resolve(__dirname, "dist"),
    filename: "js/[name].[contenthash].js",
    clean: true,
    publicPath: "/",
  },

  experiments: {
    css: false, // Using MiniCssExtractPlugin instead
  },

  module: {
    rules: [
      {
        test: /\.css$/i,
        use: [
          MiniCssExtractPlugin.loader,
          "css-loader",
          "postcss-loader", // optional for autoprefixer
        ],
      },
      {
        test: /\.(png|jpg|gif|svg|woff2?|eot|ttf)$/i,
        type: "asset/resource",
        generator: {
          filename: "assets/[hash][ext][query]",
        },
      },
      {
        test: /\.js$/i,
        exclude: /node_modules/,
        use: {
          loader: "builtin:swc-loader",
          options: {
            jsc: {
              parser: {
                syntax: "ecmascript",
              },
              target: "es2018",
            },
          },
        },
      },
    ],
  },

  resolve: {
    extensions: [".js", ".css"],
  },

  optimization: {
    usedExports: true, // Tree shaking
    sideEffects: true,
    splitChunks: {
      chunks: "all",
    },
    minimize: true,
    minimizer: [
      "...", // Default JS minimizer
      new CssMinimizerPlugin(),
    ],
  },

  plugins: [
    new MiniCssExtractPlugin({
      filename: "css/[name].[contenthash].css",
    }),

    // Generates manifest.json automatically if needed
    new rspack.ManifestPlugin({
      fileName: "manifest.json",
    }),

    // PWA Service Worker
    new WorkboxPlugin.GenerateSW({
      clientsClaim: true,
      skipWaiting: false, // Better for update notifications
      cleanupOutdatedCaches: true,

      runtimeCaching: [
        {
          urlPattern: ({ request }) => request.destination === "document",
          handler: "NetworkFirst",
          options: {
            cacheName: "pages",
          },
        },
        {
          urlPattern: ({ request }) =>
            ["style", "script", "worker"].includes(request.destination),
          handler: "StaleWhileRevalidate",
          options: {
            cacheName: "static-resources",
          },
        },
        {
          urlPattern: ({ request }) => request.destination === "image",
          handler: "CacheFirst",
          options: {
            cacheName: "images",
            expiration: {
              maxEntries: 100,
              maxAgeSeconds: 60 * 60 * 24 * 30, // 30 days
            },
          },
        },
      ],
    }),

    // Define production env
    new rspack.DefinePlugin({
      "process.env.NODE_ENV": JSON.stringify("production"),
    }),
  ],

  performance: {
    hints: false,
  },

  stats: "minimal",
};
