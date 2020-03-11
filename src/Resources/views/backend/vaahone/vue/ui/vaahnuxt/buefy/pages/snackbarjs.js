import globalComponents from "../../helpers/globalComponents";
import SideMenu from "../partials/SideMenu";

import Snackbar from '../../../vaahnuxt/buefy/components/Snackbar/Snackbar'
import SnackbarCode from "!raw-loader!../../buefy/components/Snackbar/Snackbar";

export default {
  layout: 'ui',
  head () {
    return {
      title: 'Buefy UI Block',
    }
  },
  computed: {
    SnackbarCode() {return SnackbarCode},
  },
  components: {
    ...globalComponents,
    SideMenu,
    Snackbar,

  },
  methods:{

  },

}
