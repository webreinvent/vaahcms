import globalComponents from "../../helpers/globalComponents";
import SideMenu from "../partials/SideMenu";

export default {
  layout: 'ui',
  head () {
    return {
      title: 'Buefy UI Block',
    }
  },
  computed: {
  },
  components: {
     ...globalComponents,
    SideMenu,

  },
  methods:{

  },

}
