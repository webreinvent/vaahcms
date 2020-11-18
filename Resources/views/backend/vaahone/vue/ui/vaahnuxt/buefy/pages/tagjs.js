import globalComponents from "../../helpers/globalComponents";
import SideMenu from "../partials/SideMenu";

import Tag from '../../../vaahnuxt/buefy/components/Tag/Tag'
import TagCode from "!raw-loader!../../buefy/components/Tag/Tag";

import Closable from '../../../vaahnuxt/buefy/components/Tag/Closable'
import ClosableCode from "!raw-loader!../../buefy/components/Tag/Closable";

import TagList from '../../../vaahnuxt/buefy/components/Tag/TagList'
import TagListCode from "!raw-loader!../../buefy/components/Tag/TagList";

import Sizes from '../../../vaahnuxt/buefy/components/Tag/Sizes'
import SizesCode from "!raw-loader!../../buefy/components/Tag/Sizes";

export default {
  layout: 'ui',
  head () {
    return {
      title: 'Buefy UI Block',
    }
  },
  computed: {
    TagCode() {return TagCode},
    ClosableCode() {return ClosableCode},
    TagListCode() {return TagListCode},
    SizesCode() {return SizesCode},

  },
  components: {
    ...globalComponents,
    SideMenu,
    Tag,
    Closable,
    TagList,
    Sizes,

  },
  methods:{

  },

}
