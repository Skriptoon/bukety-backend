module.exports = {
  env: {
    browser: true,
    es2021: true,
  },
  extends: [
    'eslint:recommended',
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
    quotes: ['warn', 'single'],
    'no-undef': 'off',
    'vue/no-reserved-component-names': 'off',
    'comma-dangle': ['warn', 'always-multiline'],
    'space-before-function-paren': ['warn', 'never'],
    'vue/multi-word-component-names': 'off',
  },
}
