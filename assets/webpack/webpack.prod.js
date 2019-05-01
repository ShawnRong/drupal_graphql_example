const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const commonPaths = require('./paths');

module.exports = {
    mode: 'production',
    output: {
        filename: `${commonPaths.jsFolder}/[name].js`,
        path: commonPaths.outputPath,
        chunkFilename: '[name].[chunkhash].js',
    },
    module: {
        rules: [
            {
                test: /\.(css|scss)$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    {
                        loader: 'css-loader',
                        options: {
                            sourceMap: false,
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
    plugins: [
        new CleanWebpackPlugin(),
        new MiniCssExtractPlugin({
            filename: `${commonPaths.cssFolder}/[name].css`,
            chunkFilename: '[id].css',
        }),
    ],
    devtool: 'source-map',
};
