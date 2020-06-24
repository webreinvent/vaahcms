import globalComponents from "../../helpers/globalComponents";
import SideMenu from "../partials/SideMenu";

import ToolTip from '../../../vaahnuxt/buefy/components/ToolTip/ToolTip'
import ToolTipCode from "!raw-loader!../../buefy/components/ToolTip/ToolTip";

import Styles from '../../../vaahnuxt/buefy/components/ToolTip/Styles'
import StylesCode from "!raw-loader!../../buefy/components/ToolTip/Styles";

import Multilined from '../../../vaahnuxt/buefy/components/ToolTip/Multilined'
import MultilinedCode from "!raw-loader!../../buefy/components/ToolTip/Multilined";

import Toggle from '../../../vaahnuxt/buefy/components/ToolTip/Toggle'
import ToggleCode from "!raw-loader!../../buefy/components/ToolTip/Toggle";

export default {
  layout: 'ui',
  head () {
    return {
      title: 'Buefy UI Block',
    }
  },
  computed: {
    ToolTipCode() {return ToolTipCode},
    StylesCode() {return StylesCode},
    MultilinedCode() {return MultilinedCode},
    ToggleCode() {return ToggleCode},

  },
  components: {
    ...globalComponents,
    SideMenu,
    ToolTip,
    Styles,
    Multilined,
    Toggle,

  },
  methods:{

  },

}
