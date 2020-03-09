import globalComponents from "../../helpers/globalComponents";
import SideMenu from "../partials/SideMenu";

import Collapse from '../../../vaahnuxt/buefy/components/Collapse/Collapse'
import CollapseCode from "!raw-loader!../../buefy/components/Collapse/Collapse";

import Panel from '../../../vaahnuxt/buefy/components/Collapse/Panel'
import PanelCode from "!raw-loader!../../buefy/components/Collapse/Panel";

import Card from '../../../vaahnuxt/buefy/components/Collapse/Card'
import CardCode from "!raw-loader!../../buefy/components/Collapse/Card";

import Position from '../../../vaahnuxt/buefy/components/Collapse/Position'
import PositionCode from "!raw-loader!../../buefy/components/Collapse/Position";

import AccordionEffect from '../../../vaahnuxt/buefy/components/Collapse/AccordionEffect'
import AccordionEffectCode from "!raw-loader!../../buefy/components/Collapse/AccordionEffect";

export default {
  layout: 'ui',
  head () {
    return {
      title: 'Buefy UI Block',
    }
  },
  computed: {
    CollapseCode() {return CollapseCode},
    PanelCode() {return PanelCode},
    CardCode() {return CardCode},
    PositionCode() {return PositionCode},
    AccordionEffectCode() {return AccordionEffectCode},
  },
  components: {
    ...globalComponents,
    SideMenu,
    Collapse,
    Panel,
    Card,
    Position,
    AccordionEffect,

  },
  methods:{

  },

}
