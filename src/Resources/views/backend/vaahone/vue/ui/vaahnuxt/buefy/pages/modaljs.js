import globalComponents from "../../helpers/globalComponents";
import SideMenu from "../partials/SideMenu";

import Modal from '../../../vaahnuxt/buefy/components/Modal/Modal'
import ModalCode from "!raw-loader!../../buefy/components/Modal/Modal";

import ComponentModal from '../../../vaahnuxt/buefy/components/Modal/ComponentModal'
import ComponentModalCode from "!raw-loader!../../buefy/components/Modal/ComponentModal";

import Programmatic from '../../../vaahnuxt/buefy/components/Modal/Programmatic'
import ProgrammaticCode from "!raw-loader!../../buefy/components/Modal/Programmatic";

import FullScreen from '../../../vaahnuxt/buefy/components/Modal/FullScreen'
import FullScreenCode from "!raw-loader!../../buefy/components/Modal/FullScreen";

export default {
  layout: 'ui',
  head () {
    return {
      title: 'Buefy UI Block',
    }
  },
  computed: {
    ModalCode() {return ModalCode},
    ComponentModalCode() {return ComponentModalCode},
    ProgrammaticCode() {return ProgrammaticCode},
    FullScreenCode() {return FullScreenCode},
  },
  components: {
    ...globalComponents,
    SideMenu,
    Modal,
    ComponentModal,
    Programmatic,
    FullScreen,

  },
  methods:{

  },

}
