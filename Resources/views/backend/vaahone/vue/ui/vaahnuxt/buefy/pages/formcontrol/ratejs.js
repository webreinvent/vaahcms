import globalComponents from "./../../../helpers/globalComponents";
import SideMenu from "../../partials/SideMenu";

import Rate from './../../../../vaahnuxt/buefy/components/FormControl/Rate/Rate'
import RateCode from "!raw-loader!./../../../buefy/components/FormControl/Rate/Rate";

import CustomRate from './../../../../vaahnuxt/buefy/components/FormControl/Rate/CustomRate'
import CustomRateCode from "!raw-loader!./../../../buefy/components/FormControl/Rate/CustomRate";

export default {
  layout: 'ui',
  head () {
    return {
      title: 'Buefy UI Block',
    }
  },
  computed: {
    RateCode() {return RateCode},
    CustomRateCode() {return CustomRateCode},
  },
  components: {
    ...globalComponents,
    SideMenu,
    Rate,
    CustomRate

  },
  methods:{

  },

}
