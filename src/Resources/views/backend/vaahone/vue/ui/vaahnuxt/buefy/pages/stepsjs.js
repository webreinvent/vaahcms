import globalComponents from "../../helpers/globalComponents";
import SideMenu from "../partials/SideMenu";

import Steps from '../../../vaahnuxt/buefy/components/Steps/Steps'
import StepsCode from "!raw-loader!../../buefy/components/Steps/Steps";

import Dynamic from '../../../vaahnuxt/buefy/components/Steps/Dynamic'
import DynamicCode from "!raw-loader!../../buefy/components/Steps/Dynamic";

import Icons from '../../../vaahnuxt/buefy/components/Steps/Icons'
import IconsCode from "!raw-loader!../../buefy/components/Steps/Icons";

import Sizes from '../../../vaahnuxt/buefy/components/Steps/Sizes'
import SizesCode from "!raw-loader!../../buefy/components/Steps/Sizes";

import Types from '../../../vaahnuxt/buefy/components/Steps/Types'
import TypesCode from "!raw-loader!../../buefy/components/Steps/Types";

export default {
  layout: 'ui',
  head () {
    return {
      title: 'Buefy UI Block',
    }
  },
  computed: {
    StepsCode() {return StepsCode},
    DynamicCode() {return DynamicCode},
    IconsCode() {return IconsCode},
    SizesCode() {return SizesCode},
    TypesCode() {return TypesCode},

  },
  components: {
    ...globalComponents,
    SideMenu,
    Steps,
    Dynamic,
    Icons,
    Sizes,
    Types,

  },
  methods:{

  },

}
