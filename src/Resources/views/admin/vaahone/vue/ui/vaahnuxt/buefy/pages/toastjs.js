import globalComponents from "../../helpers/globalComponents";
import SideMenu from "../partials/SideMenu";

import Toast from '../../../vaahnuxt/buefy/components/Toast/Toast'
import ToastCode from "!raw-loader!../../buefy/components/Toast/Toast";

export default {
  layout: 'ui',
  head () {
    return {
      title: 'Buefy UI Block',
    }
  },
  computed: {
    ToastCode() {return ToastCode},

  },
  components: {
    ...globalComponents,
    SideMenu,
    Toast,

  },
  methods:{

  },

}
