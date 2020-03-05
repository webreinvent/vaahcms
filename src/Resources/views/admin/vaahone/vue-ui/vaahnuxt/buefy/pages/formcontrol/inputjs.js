import globalComponents from "./../../../helpers/globalComponents";
import SideMenu from "../../partials/SideMenu";

import Input from './../../../../vaahnuxt/buefy/components/FormControl/Input/Input'
import InputCode from "!raw-loader!./../../../buefy/components/FormControl/Input/Input";

import TypesAndStates from './../../../../vaahnuxt/buefy/components/FormControl/Input/TypesAndStates'
import TypesAndStatesCode from "!raw-loader!./../../../buefy/components/FormControl/Input/TypesAndStates";

import Icons from './../../../../vaahnuxt/buefy/components/FormControl/Input/Icons'
import IconsCode from "!raw-loader!./../../../buefy/components/FormControl/Input/Icons";

import Validation from './../../../../vaahnuxt/buefy/components/FormControl/Input/Validation'
import ValidationCode from "!raw-loader!./../../../buefy/components/FormControl/Input/Validation";

import Password from './../../../../vaahnuxt/buefy/components/FormControl/Input/Password'
import PasswordCode from "!raw-loader!./../../../buefy/components/FormControl/Input/Password";

import Sizes from './../../../../vaahnuxt/buefy/components/FormControl/Input/Sizes'
import SizesCode from "!raw-loader!./../../../buefy/components/FormControl/Input/Sizes";

export default {
  layout: 'ui',
  head () {
    return {
      title: 'Buefy UI Block',
    }
  },
  computed: {
    InputCode() {return InputCode},
    TypesAndStatesCode() {return TypesAndStatesCode},
    IconsCode() {return IconsCode},
    ValidationCode() {return ValidationCode},
    PasswordCode() {return PasswordCode},
    SizesCode() {return SizesCode},
  },
  components: {
    ...globalComponents,
    SideMenu,
    Input,
    TypesAndStates,
    Icons,
    Validation,
    Password,
    Sizes,

  },
  methods:{

  },

}
