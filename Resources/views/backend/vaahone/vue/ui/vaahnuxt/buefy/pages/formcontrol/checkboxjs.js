import globalComponents from "./../../../helpers/globalComponents";
import SideMenu from "../../partials/SideMenu";

import Checkbox from './../../../../vaahnuxt/buefy/components/FormControl/Checkbox/Checkbox'
import CheckboxCode from "!raw-loader!./../../../buefy/components/FormControl/Checkbox/Checkbox";

import Grouped from './../../../../vaahnuxt/buefy/components/FormControl/Checkbox/Grouped'
import GroupedCode from "!raw-loader!./../../../buefy/components/FormControl/Checkbox/Grouped";

import Sizes from './../../../../vaahnuxt/buefy/components/FormControl/Checkbox/Sizes'
import SizesCode from "!raw-loader!./../../../buefy/components/FormControl/Checkbox/Sizes";

import Types from './../../../../vaahnuxt/buefy/components/FormControl/Checkbox/Types'
import TypesCode from "!raw-loader!./../../../buefy/components/FormControl/Checkbox/Types";

import CheckboxButton from './../../../../vaahnuxt/buefy/components/FormControl/Checkbox/CheckboxButton'
import CheckboxButtonCode from "!raw-loader!./../../../buefy/components/FormControl/Checkbox/CheckboxButton";

export default {
  layout: 'ui',
  head () {
    return {
      title: 'Buefy UI Block',
    }
  },
  computed: {
    CheckboxCode() {return CheckboxCode},
    GroupedCode() {return GroupedCode},
    SizesCode() {return SizesCode},
    TypesCode() {return TypesCode},
    CheckboxButtonCode() {return CheckboxButtonCode},
  },
  components: {
    ...globalComponents,
    SideMenu,
    Checkbox,
    Grouped,
    Sizes,
    Types,
    CheckboxButton,

  },
  methods:{

  },

}
