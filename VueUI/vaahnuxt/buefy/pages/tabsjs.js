import globalComponents from "../../helpers/globalComponents";
import SideMenu from "../partials/SideMenu";

import Tabs from '../../../vaahnuxt/buefy/components/Tabs/Tabs'
import TabsCode from "!raw-loader!../../buefy/components/Tabs/Tabs";

import Dynamic from '../../../vaahnuxt/buefy/components/Tabs/Dynamic'
import DynamicCode from "!raw-loader!../../buefy/components/Tabs/Dynamic";


import Position from '../../../vaahnuxt/buefy/components/Tabs/Position'
import PositionCode from "!raw-loader!../../buefy/components/Tabs/Position";


import Icons from '../../../vaahnuxt/buefy/components/Tabs/Icons'
import IconsCode from "!raw-loader!../../buefy/components/Tabs/Icons";


import Sizes from '../../../vaahnuxt/buefy/components/Tabs/Sizes'
import SizesCode from "!raw-loader!../../buefy/components/Tabs/Sizes";


import Types from '../../../vaahnuxt/buefy/components/Tabs/Types'
import TypesCode from "!raw-loader!../../buefy/components/Tabs/Types";



import Expanded from '../../../vaahnuxt/buefy/components/Tabs/Expanded'
import ExpandedCode from "!raw-loader!../../buefy/components/Tabs/Expanded";



import CustomHeaders from '../../../vaahnuxt/buefy/components/Tabs/CustomHeaders'
import CustomHeadersCode from "!raw-loader!../../buefy/components/Tabs/CustomHeaders";



import Vertical from '../../../vaahnuxt/buefy/components/Tabs/Vertical'
import VerticalCode from "!raw-loader!../../buefy/components/Tabs/Vertical";

export default {
  layout: 'ui',
  head () {
    return {
      title: 'Buefy UI Block',
    }
  },
  computed: {
    TabsCode() {return TabsCode},
    DynamicCode() {return DynamicCode},
    PositionCode() {return PositionCode},
    IconsCode() {return IconsCode},
    SizesCode() {return SizesCode},
    TypesCode() {return TypesCode},
    ExpandedCode() {return ExpandedCode},
    CustomHeadersCode() {return CustomHeadersCode},
    VerticalCode() {return VerticalCode},

  },
  components: {
    ...globalComponents,
    SideMenu,
    Tabs,
    Dynamic,
    Position,
    Icons,
    Sizes,
    Types,
    Expanded,
    CustomHeaders,
    Vertical,


  },
  methods:{

  },

}
