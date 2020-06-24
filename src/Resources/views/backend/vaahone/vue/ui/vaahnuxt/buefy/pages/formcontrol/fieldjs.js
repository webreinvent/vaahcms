import globalComponents from "./../../../helpers/globalComponents";
import SideMenu from "../../partials/SideMenu";

import Field from './../../../../vaahnuxt/buefy/components/FormControl/Field/Field'
import FieldCode from "!raw-loader!./../../../buefy/components/FormControl/Field/Field";

import LabelPosition from './../../../../vaahnuxt/buefy/components/FormControl/Field/LabelPosition'
import LabelPositionCode from "!raw-loader!./../../../buefy/components/FormControl/Field/LabelPosition";

import ObjectSyntax from './../../../../vaahnuxt/buefy/components/FormControl/Field/ObjectSyntax'
import ObjectSyntaxCode from "!raw-loader!./../../../buefy/components/FormControl/Field/ObjectSyntax";

import Addons from './../../../../vaahnuxt/buefy/components/FormControl/Field/Addons'
import AddonsCode from "!raw-loader!./../../../buefy/components/FormControl/Field/Addons";

import Groups from './../../../../vaahnuxt/buefy/components/FormControl/Field/Groups'
import GroupsCode from "!raw-loader!./../../../buefy/components/FormControl/Field/Groups";

import NestedGroups from './../../../../vaahnuxt/buefy/components/FormControl/Field/NestedGroups'
import NestedGroupsCode from "!raw-loader!./../../../buefy/components/FormControl/Field/NestedGroups";

import ResponsiveGroups from './../../../../vaahnuxt/buefy/components/FormControl/Field/ResponsiveGroups'
import ResponsiveGroupsCode from "!raw-loader!./../../../buefy/components/FormControl/Field/ResponsiveGroups";

import Positions from './../../../../vaahnuxt/buefy/components/FormControl/Field/Positions'
import PositionsCode from "!raw-loader!./../../../buefy/components/FormControl/Field/Positions";

import CombiningAddonsAndGroups from './../../../../vaahnuxt/buefy/components/FormControl/Field/CombiningAddonsAndGroups'
import CombiningAddonsAndGroupsCode from "!raw-loader!./../../../buefy/components/FormControl/Field/CombiningAddonsAndGroups";

import Horizontal from './../../../../vaahnuxt/buefy/components/FormControl/Field/Horizontal'
import HorizontalCode from "!raw-loader!./../../../buefy/components/FormControl/Field/Horizontal";

import LabelClasses from './../../../../vaahnuxt/buefy/components/FormControl/Field/LabelClasses'
import LabelClassesCode from "!raw-loader!./../../../buefy/components/FormControl/Field/LabelClasses";

import LabelSlot from './../../../../vaahnuxt/buefy/components/FormControl/Field/LabelSlot'
import LabelSlotCode from "!raw-loader!./../../../buefy/components/FormControl/Field/LabelSlot";

export default {
  layout: 'ui',
  head () {
    return {
      title: 'Buefy UI Block',
    }
  },
  computed: {
    FieldCode() {return FieldCode},
    LabelPositionCode() {return LabelPositionCode},
    ObjectSyntaxCode() {return ObjectSyntaxCode},
    AddonsCode() {return AddonsCode},
    GroupsCode() {return GroupsCode},
    NestedGroupsCode() {return NestedGroupsCode},
    ResponsiveGroupsCode() {return ResponsiveGroupsCode},
    PositionsCode() {return PositionsCode},
    CombiningAddonsAndGroupsCode() {return CombiningAddonsAndGroupsCode},
    HorizontalCode() {return HorizontalCode},
    LabelClassesCode() {return LabelClassesCode},
    LabelSlotCode() {return LabelSlotCode},
  },
  components: {
    ...globalComponents,
    SideMenu,
    Field,
    LabelPosition,
    ObjectSyntax,
    Addons,
    Groups,
    NestedGroups,
    ResponsiveGroups,
    Positions,
    CombiningAddonsAndGroups,
    Horizontal,
    LabelClasses,
    LabelSlot,

  },
  methods:{

  },

}
