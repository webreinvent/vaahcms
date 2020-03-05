import globalComponents from "../../helpers/globalComponents";
import SideMenu from "../partials/SideMenu";

import Dropdown from '../../../vaahnuxt/buefy/components/Dropdown/Dropdown'
import DropdownCode from "!raw-loader!../../buefy/components/Dropdown/Dropdown";

import ContentAndPosition from '../../../vaahnuxt/buefy/components/Dropdown/ContentAndPosition'
import ContentAndPositionCode from "!raw-loader!../../buefy/components/Dropdown/ContentAndPosition";

import LinksWithin from '../../../vaahnuxt/buefy/components/Dropdown/LinksWithin'
import LinksWithinCode from "!raw-loader!../../buefy/components/Dropdown/LinksWithin";

import CustomizingWithVModel from '../../../vaahnuxt/buefy/components/Dropdown/CustomizingWithVModel'
import CustomizingWithVModelCode from "!raw-loader!../../buefy/components/Dropdown/CustomizingWithVModel";

import Multiple from '../../../vaahnuxt/buefy/components/Dropdown/Multiple'
import MultipleCode from "!raw-loader!../../buefy/components/Dropdown/Multiple";

export default {
  layout: 'ui',
  head () {
    return {
      title: 'Buefy UI Block',
    }
  },
  computed: {
    DropdownCode() {return DropdownCode},
    ContentAndPositionCode() {return ContentAndPositionCode},
    LinksWithinCode() {return LinksWithinCode},
    CustomizingWithVModelCode() {return CustomizingWithVModelCode},
    MultipleCode() {return MultipleCode},
  },
  components: {
    ...globalComponents,
    SideMenu,
    Dropdown,
    ContentAndPosition,
    LinksWithin,
    CustomizingWithVModel,
    Multiple,

  },
  methods:{

  },

}
