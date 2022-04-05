const path = require('path');
const glob = require('glob');

const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const {CleanWebpackPlugin} = require('clean-webpack-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const OptimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin');

// const isWatch = process.argv.includes('--watch');
const isProduction = process.env.NODE_ENV === 'production';
const isDevelopment = !isProduction;

let __config = {
    common: {
        publicPath: '/dist/prog/',
        dest: path.join(__dirname, '../../../dist/prog/'),
        context: 'assets-prog/'
    },
    css: {
        src: 'assets-prog/scss/[a-z0-9]*.scss',
        dest: '',
    },
    js: {
        src: 'assets-prog/js/[a-z0-9]*.js',
        dest: '',
    }
};

module.exports = {
    mode: isProduction ? 'production' : 'development',
    entry: () => {
        let entries = {};

        // добавляем entry-поинты на основе масок
        [
            __config.js.src,
            __config.css.src
        ]
            .forEach((mask) => {
                glob.sync(mask)
                    .forEach(filePath => {
                        const name = path.parse(filePath).name;
                        entries[name] = entries[name] || [];
                        entries[name].push(path.resolve(__dirname, filePath));
                    });
            });

        return entries;
    },

    output: {
        filename: `${__config.js.dest}[name].js`,
        chunkFilename: `${__config.js.dest}[name].chunk.js`,
        path: __config.common.dest,
        publicPath: __config.common.publicPath
    },

    watchOptions: {
        aggregateTimeout: 300
    },

    devtool: isProduction
        ? false
        : 'eval-source-map',

    module: {
        rules: [
            {
                test: /\.js$/,
                use: [
                    {
                        loader: 'babel-loader',
                        options: {
                            presets: ['@babel/preset-env'],
                            plugins: [
                                require('@babel/plugin-proposal-object-rest-spread'),
                                require('@babel/plugin-transform-object-assign')
                            ],
                        }
                    }
                ]
            },
            {
                test: /\.s[ac]ss$/,
                use: [
                    {
                        loader: MiniCssExtractPlugin.loader,
                        options: {
                            hmr: false,
                        },
                    },
                    {
                        loader: 'css-loader',
                        options: {
                            sourceMap: true,
                        }
                    },
                    {
                        loader: 'postcss-loader',
                        options: {
                            config: {
                                path: __dirname
                            },
                        }
                    },
                    {
                        loader: 'sass-loader',
                        options: {
                            sourceMap: isDevelopment,
                        }
                    }
                ]
            },
            {
                test: /\.(png|jpg|gif|svg|woff|woff2|eot|ttf|otf)$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: '[path][name].[ext]',
                            context: __config.common.context,
                            publicPath: './',
                        }
                    }
                ]
            },
        ]
    },

    plugins: [
        new MiniCssExtractPlugin({
            filename: `${__config.css.dest}[name].css`,
            chunkFilename: `${__config.css.dest}[name].chunk.css`
        }),
        ...isDevelopment ? [] : [new CleanWebpackPlugin()],
    ],

    optimization: {
        minimize: isProduction,
        minimizer: isProduction
            ?
            [
                new TerserPlugin(),
                new OptimizeCssAssetsPlugin()
            ]
            :
            [],
    },
};
