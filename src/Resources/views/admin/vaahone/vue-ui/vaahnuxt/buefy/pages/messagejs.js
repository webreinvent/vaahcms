import globalComponents from "../../helpers/globalComponents";
import SideMenu from "../partials/SideMenu";

import Message from '../../../vaahnuxt/buefy/components/Message/Message'
import MessageCode from "!raw-loader!../../buefy/components/Message/Message";

import Types from '../../../vaahnuxt/buefy/components/Message/Types'
import TypesCode from "!raw-loader!../../buefy/components/Message/Types";

import Icons from '../../../vaahnuxt/buefy/components/Message/Icons'
import IconsCode from "!raw-loader!../../buefy/components/Message/Icons";

import Headerless from '../../../vaahnuxt/buefy/components/Message/Headerless'
import HeaderlessCode from "!raw-loader!../../buefy/components/Message/Headerless";

import Sizes from '../../../vaahnuxt/buefy/components/Message/Sizes'
import SizesCode from "!raw-loader!../../buefy/components/Message/Sizes";

import AutoClose from '../../../vaahnuxt/buefy/components/Message/AutoClose'
import AutoCloseCode from "!raw-loader!../../buefy/components/Message/AutoClose";

export default {
  layout: 'ui',
  head () {
    return {
      title: 'Buefy UI Block',
    }
  },
  computed: {
    MessageCode() {return MessageCode},
    TypesCode() {return TypesCode},
    IconsCode() {return IconsCode},
    HeaderlessCode() {return HeaderlessCode},
    SizesCode() {return SizesCode},
    AutoCloseCode() {return AutoCloseCode},
  },
  components: {
    ...globalComponents,
    SideMenu,
    Message,
    Types,
    Icons,
    Headerless,
    Sizes,
    AutoClose

  },
  methods:{

  },

}
