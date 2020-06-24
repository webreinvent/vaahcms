import globalComponents from "../../helpers/globalComponents";
import SideMenu from "../partials/SideMenu";

import Progress from '../../../vaahnuxt/buefy/components/Progress/Progress'
import ProgressCode from "!raw-loader!../../buefy/components/Progress/Progress";

import Types from '../../../vaahnuxt/buefy/components/Progress/Types'
import TypesCode from "!raw-loader!../../buefy/components/Progress/Types";

import Sizes from '../../../vaahnuxt/buefy/components/Progress/Sizes'
import SizesCode from "!raw-loader!../../buefy/components/Progress/Sizes";

import Values from '../../../vaahnuxt/buefy/components/Progress/Values'
import ValuesCode from "!raw-loader!../../buefy/components/Progress/Values";

import SlotProgress from '../../../vaahnuxt/buefy/components/Progress/SlotProgress'
import SlotProgressCode from "!raw-loader!../../buefy/components/Progress/SlotProgress";

export default {
  layout: 'ui',
  head () {
    return {
      title: 'Buefy UI Block',
    }
  },
  computed: {
    ProgressCode() {return ProgressCode},
    TypesCode() {return TypesCode},
    SizesCode() {return SizesCode},
    ValuesCode() {return ValuesCode},
    SlotProgressCode() {return SlotProgressCode},
  },
  components: {
    ...globalComponents,
    SideMenu,
    Progress,
    Types,
    Sizes,
    Values,
    SlotProgress,

  },
  methods:{

  },

}
