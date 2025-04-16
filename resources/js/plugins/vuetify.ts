import "vuetify/styles";
import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";

import { fa } from "vuetify/iconsets/fa";
import { aliases, mdi } from "vuetify/lib/iconsets/mdi";

export default createVuetify({
  theme: {
    defaultTheme: 'myCustomTheme',
    themes: {
      myCustomTheme: {
        dark: false,
        colors: {
          primary: '#1f2937',      // Your custom purple
        },
      },
    },
  },
  icons: {
    defaultSet: "mdi",
    aliases,
    sets: {
        mdi,
        fa,
    },
  },  
  components,
  directives,
});