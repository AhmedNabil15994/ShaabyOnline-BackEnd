/*=========================================================================================
  File Name: i18n.js
  Description: i18n configuration file. Imports i18n data.
  ----------------------------------------------------------------------------------------
=============================*/


import Vue from 'vue'
import VueI18n from 'vue-i18n'
import locales from './locales'

Vue.use(VueI18n)
let  gelang = document.documentElement.lang;

export default new VueI18n({
  locale: gelang, // set default locale
  messages: locales,
  fallbackLocale: 'en',
})
