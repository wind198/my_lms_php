// resources/js/vuetify.js
import { createVuetify } from 'vuetify'
import 'vuetify/styles'
import { mdi } from 'vuetify/iconsets/mdi'

export default createVuetify({
  icons: {
    defaultSet: 'mdi',
    sets: {
      mdi,
    },
  },
})
