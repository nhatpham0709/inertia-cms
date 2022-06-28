module.exports = {
  root: true,
  env: {
    browser: true,
    es2021: true
  },
  extends: [
    'plugin:vue/essential',
    'prettier'
  ],
  parserOptions: {
    ecmaVersion: 'latest'
  },
  plugins: [
    'vue'
  ],
  rules: {
    'vue/multi-word-component-names': 0, "vue/no-multiple-template-root": 0, 'indent': ['error', 2],
  },
}
