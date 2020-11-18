import globalComponents from "./../../../helpers/globalComponents";
import SideMenu from "../../partials/SideMenu";

import Select from './../../../../vaahnuxt/buefy/components/FormControl/Select/Select'
import SelectCode from "!raw-loader!./../../../buefy/components/FormControl/Select/Select";

import Multiple from './../../../../vaahnuxt/buefy/components/FormControl/Select/Multiple'
import MultipleCode from "!raw-loader!./../../../buefy/components/FormControl/Select/Multiple";

import Icons from './../../../../vaahnuxt/buefy/components/FormControl/Select/Icons'
import IconsCode from "!raw-loader!./../../../buefy/components/FormControl/Select/Icons";

import Sizes from './../../../../vaahnuxt/buefy/components/FormControl/Select/Sizes'
import SizesCode from "!raw-loader!./../../../buefy/components/FormControl/Select/Sizes";

export default {
  layout: 'ui',
  head () {
    return {
      title: 'Buefy UI Block',
    }
  },
  computed: {
    SelectCode() {return SelectCode},
    MultipleCode() {return MultipleCode},
    IconsCode() {return IconsCode},
    SizesCode() {return SizesCode},
  },
  components: {
    ...globalComponents,
    SideMenu,
    Select,
    Multiple,
    Icons,
    Sizes,

  },
  methods:{

  },

}
