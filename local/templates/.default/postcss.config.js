const isProduction = process.env.NODE_ENV === 'production' || process.argv.includes('-p');

const presetEnv = require('postcss-preset-env')({
    autoprefixer: {
        cascade: true,
        grid: true,
        flexbox: true,
    },
    minimize: isProduction
});

module.exports = ({file, options, env}) => {
    let plugins = [];

    plugins.push(presetEnv);

    return {
        plugins: plugins,
        sourceMap: true,
    };
};
