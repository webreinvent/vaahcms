import globalComponents from "../../helpers/globalComponents";
import SideMenu from "../partials/SideMenu";

import Menu from '../../../vaahnuxt/buefy/components/Menu/Menu'
import MenuCode from "!raw-loader!../../buefy/components/Menu/Menu";

export default {
  layout: 'ui',
  head () {
    return {
      title: 'Buefy UI Block',
    }
  },
  computed: {
    MenuCode() {return MenuCode},
  },
  components: {
    ...globalComponents,
    SideMenu,
    Menu,

  },
  methods:{

  },

}
