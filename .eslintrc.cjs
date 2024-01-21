module.exports = {
  env: {
    browser: true,
    es2021: true,
  },
  globals: {
    route: 'readonly',
  },
  extends: [
    'airbnb-base',
    'plugin:vue/vue3-essential',
  ],
  overrides: [
    {
      env: {
        node: true,
      },
      files: [
        '.eslintrc.{js,cjs}',
      ],
      parserOptions: {
        sourceType: 'script',
      },
    },
  ],
  parserOptions: {
    ecmaVersion: 'latest',
    sourceType: 'module',
  },
  plugins: [
    'vue',
  ],
  rules: {
    'import/extensions': [
      'error',
      'ignorePackages',
      {
        js: 'never',
        // add other extensions if needed
      },
    ],
  },
  settings: {
    'import/resolver': {
      alias: {
        map: [['@', './resources/js']],
        extensions: ['.ts', '.js', '.jsx', '.json'],
      },
    },
  },
};
