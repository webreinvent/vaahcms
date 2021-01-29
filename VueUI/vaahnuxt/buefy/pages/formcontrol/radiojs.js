import globalComponents from "./../../../helpers/globalComponents";
import SideMenu from "../../partials/SideMenu";

import Radio from './../../../../vaahnuxt/buefy/components/FormControl/Radio/Radio'
import RadioCode from "!raw-loader!./../../../buefy/components/FormControl/Radio/Radio";

import Sizes from './../../../../vaahnuxt/buefy/components/FormControl/Radio/Sizes'
import SizesCode from "!raw-loader!./../../../buefy/components/FormControl/Radio/Sizes";

import Types from './../../../../vaahnuxt/buefy/components/FormControl/Radio/Types'
import TypesCode from "!raw-loader!./../../../buefy/components/FormControl/Radio/Types";

import RadioButton from './../../../../vaahnuxt/buefy/components/FormControl/Radio/RadioButton'
import RadioButtonCode from "!raw-loader!./../../../buefy/components/FormControl/Radio/RadioButton";

export default {
  layout: 'ui',
  head () {
    return {
      title: 'Buefy UI Block',
    }
  },
  computed: {
    RadioCode() {return RadioCode},
    SizesCode() {return SizesCode},
    TypesCode() {return TypesCode},
    RadioButtonCode() {return RadioButtonCode},
  },
  components: {
    ...globalComponents,
    SideMenu,
    Radio,
    Sizes,
    Types,
    RadioButton,

  },
  methods:{

  },

}
