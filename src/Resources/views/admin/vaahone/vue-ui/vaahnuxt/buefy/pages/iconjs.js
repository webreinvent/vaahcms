import globalComponents from "../../helpers/globalComponents";
import SideMenu from "../partials/SideMenu";

import Icon from '../../../vaahnuxt/buefy/components/Icon/Icon'
import IconCode from "!raw-loader!../../buefy/components/Icon/Icon";

import FontAwesome from '../../../vaahnuxt/buefy/components/Icon/FontAwesome'
import FontAwesomeCode from "!raw-loader!../../buefy/components/Icon/FontAwesome";

import ObjectSyntax from '../../../vaahnuxt/buefy/components/Icon/ObjectSyntax'
import ObjectSyntaxCode from "!raw-loader!../../buefy/components/Icon/ObjectSyntax";

import CustomIconPack from '../../../vaahnuxt/buefy/components/Icon/CustomIconPack'
import CustomIconPackCode from "!raw-loader!../../buefy/components/Icon/CustomIconPack";

export default {
  layout: 'ui',
  head () {
    return {
      title: 'Buefy UI Block',
    }
  },
  computed: {
    IconCode() {return IconCode},
    FontAwesomeCode() {return FontAwesomeCode},
    ObjectSyntaxCode() {return ObjectSyntaxCode},
    CustomIconPackCode() {return CustomIconPackCode},
  },
  components: {
    ...globalComponents,
    SideMenu,
    Icon,
    FontAwesome,
    ObjectSyntax,
    CustomIconPack,

  },
  methods:{

  },

}
