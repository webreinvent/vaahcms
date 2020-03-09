import globalComponents from "./../../../helpers/globalComponents";
import SideMenu from "../../partials/SideMenu";

import Numberinput from './../../../../vaahnuxt/buefy/components/FormControl/Numberinput/Numberinput'
import NumberinputCode from "!raw-loader!./../../../buefy/components/FormControl/Numberinput/Numberinput";

import Types from './../../../../vaahnuxt/buefy/components/FormControl/Numberinput/Types'
import TypesCode from "!raw-loader!./../../../buefy/components/FormControl/Numberinput/Types";

import MinMax from './../../../../vaahnuxt/buefy/components/FormControl/Numberinput/MinMax'
import MinMaxCode from "!raw-loader!./../../../buefy/components/FormControl/Numberinput/MinMax";

import Steps from './../../../../vaahnuxt/buefy/components/FormControl/Numberinput/Steps'
import StepsCode from "!raw-loader!./../../../buefy/components/FormControl/Numberinput/Steps";

import Sizes from './../../../../vaahnuxt/buefy/components/FormControl/Numberinput/Sizes'
import SizesCode from "!raw-loader!./../../../buefy/components/FormControl/Numberinput/Sizes";

import Customization from './../../../../vaahnuxt/buefy/components/FormControl/Numberinput/Customization'
import CustomizationCode from "!raw-loader!./../../../buefy/components/FormControl/Numberinput/Customization";

export default {
  layout: 'ui',
  head () {
    return {
      title: 'Buefy UI Block',
    }
  },
  computed: {
    NumberinputCode() {return NumberinputCode},
    TypesCode() {return TypesCode},
    MinMaxCode() {return MinMaxCode},
    StepsCode() {return StepsCode},
    SizesCode() {return SizesCode},
    CustomizationCode() {return CustomizationCode},
  },
  components: {
    ...globalComponents,
    SideMenu,
    Numberinput,
    Types,
    MinMax,
    Steps,
    Sizes,
    Customization,

  },
  methods:{

  },

}
