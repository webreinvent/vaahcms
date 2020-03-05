import globalComponents from "../../helpers/globalComponents";
import SideMenu from "../partials/SideMenu";

import Loading from '../../../vaahnuxt/buefy/components/Loading/Loading'
import LoadingCode from "!raw-loader!../../buefy/components/Loading/Loading";

import ProgrammaticallyOpening from '../../../vaahnuxt/buefy/components/Loading/ProgrammaticallyOpening'
import ProgrammaticallyOpeningCode from "!raw-loader!../../buefy/components/Loading/ProgrammaticallyOpening";

import Templated from '../../../vaahnuxt/buefy/components/Loading/Templated'
import TemplatedCode from "!raw-loader!../../buefy/components/Loading/Templated";

export default {
  layout: 'ui',
  head () {
    return {
      title: 'Buefy UI Block',
    }
  },
  computed: {
    LoadingCode() {return LoadingCode},
    ProgrammaticallyOpeningCode() {return ProgrammaticallyOpeningCode},
    TemplatedCode() {return TemplatedCode},
  },
  components: {
    ...globalComponents,
    SideMenu,
    Loading,
    ProgrammaticallyOpening,
    Templated,

  },
  methods:{

  },

}
