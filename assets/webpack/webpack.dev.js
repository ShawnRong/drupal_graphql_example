const webpack = require('webpack');

const commonPaths = require('./paths');

module.exports = {
    mode: 'development',
    output: {
        filename: '[name].js',
        path: commonPaths.outputPath,
        chunkFilename: '[name].js',
    },
    module: {
        rules: [
            {
                test: /\.(css|scss)$/,
                use: [
                    'style-loader',
                    {
                        loader: 'css-loader',
                        options: {
                            sourceMap: true,
                            modules: true,
                            camelCase: true,
                            // localIdentName: '[local]___[hash:base64:5]',
                            localIdentName: '[local]',
                        },
                    },
                    'sass-loader',
                    'postcss-loader',
                ],
            },
        ],
    },
    devServer: {
        contentBase: commonPaths.outputPath,
        compress: true,
        hot: true,
    },
    plugins: [new webpack.HotModuleReplacementPlugin()],
};