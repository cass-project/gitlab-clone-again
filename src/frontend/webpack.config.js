var webpack = require("webpack");

function WebpackConfigBuilder() {
  this.publicPath = __dirname + '/../www/app/dist';
  this.wwwPath = '/dist';
  this.bundlesDir = 'bundles';
}

WebpackConfigBuilder.prototype = {
  build: function() {
    return {
      entry: {
        main: './src/app/frontend-app/app.ts'
      },
      output: {
        filename: '[name].js',
        path: this.publicPath + '/' + this.bundlesDir,
        publicPath: this.wwwPath + '/' + this.bundlesDir + '/'
      },
      resolve: {
        extensions: ['', '.webpack.js', '.web.js', '.ts', '.js']
      },
      watchOptions: {
        poll: true
      },
      module: {
        loaders: [
          {
            test: /\.css$/,
            loader: "style-loader!css-loader"
          },
          {
            test: /\.ts$/,
            loader: 'ts-loader',
            exclude: [
              /\.(spec|e2e)\.ts$/,
              /node_modules\/(?!(ng2-.+))/
            ]
          },
          {
            test: /\.json$/,
            loader: 'json-loader'
          },
          {
            test: /\.html$/,
            loader: 'raw-loader'
          },
          {
            test: /\.head.scss$/,
            loaders: ["style", "css", "sass"]
          },
          {
            test: /\.shadow.scss$/,
            loaders: ["raw-loader", "sass"]
          },
          {
            test: /\.scss$/,
            loaders: ["style", "css", "sass"],
            exclude: /head|shadow\.scss$/
          },
          {
            test: /\.woff(2)?(\?v=[0-9]\.[0-9]\.[0-9])?$/,
            loader: "url-loader?limit=10000&minetype=application/font-woff"
          },
          {
            test: /\.(ttf|eot|svg)(\?v=[0-9]\.[0-9]\.[0-9])?$/,
            loader: "file-loader"
          },
          {
            test: /\.jade$/,
            loaders: ['raw-loader', 'jade-html']
          }
        ] 
      },
      plugins: [
        new webpack.ProvidePlugin({
          $: "jquery",
          jQuery: "jquery",
          "window.jQuery": "jquery",
          Tether: 'tether',
          "window.Tether": 'tether'
        })
      ]      
    }
  }
};

module.exports = (new WebpackConfigBuilder()).build();