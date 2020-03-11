import globalComponents from "../../helpers/globalComponents";
import SideMenu from "../partials/SideMenu";

import Button from '../../../vaahnuxt/buefy/components/Buttons/Button'
import ButtonCode from "!raw-loader!../../buefy/components/Buttons/Button";

import TypesAndStates from '../../../vaahnuxt/buefy/components/Buttons/TypesAndStates'
import TypesAndStatesCode from "!raw-loader!../../buefy/components/Buttons/TypesAndStates";

import Size from '../../../vaahnuxt/buefy/components/Buttons/Sizes'
import SizeCode from "!raw-loader!../../buefy/components/Buttons/Sizes";

import Icons from '../../../vaahnuxt/buefy/components/Buttons/Icons'
import IconsCode from "!raw-loader!../../buefy/components/Buttons/Icons";

import Tags from '../../../vaahnuxt/buefy/components/Buttons/Tags'
import TagsCode from "!raw-loader!../../buefy/components/Buttons/Tags";

import Router from '../../../vaahnuxt/buefy/components/Buttons/Router'
import RouterCode from "!raw-loader!../../buefy/components/Buttons/Router";

export default {
  computed: {
    ButtonCode() {return ButtonCode},
    TypesAndStatesCode() {return TypesAndStatesCode},
    SizeCode() {return SizeCode},
    IconsCode() {return IconsCode},
    TagsCode() {return TagsCode},
    RouterCode() {return RouterCode},
  },
  components: {
    ...globalComponents,

    SideMenu,
    Button,
    TypesAndStates,
    Size,
    Icons,
    Tags,
    Router,

  },
  methods:{

  },

}
