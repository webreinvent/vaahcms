import globalComponents from "./../../../helpers/globalComponents";
import SideMenu from "../../partials/SideMenu";

import Upload from './../../../../vaahnuxt/buefy/components/FormControl/Upload/Upload'
import UploadCode from "!raw-loader!./../../../buefy/components/FormControl/Upload/Upload";

import DragAndDrop from './../../../../vaahnuxt/buefy/components/FormControl/Upload/DragAndDrop'
import DragAndDropCode from "!raw-loader!./../../../buefy/components/FormControl/Upload/DragAndDrop";

export default {
  layout: 'ui',
  head () {
    return {
      title: 'Buefy UI Block',
    }
  },
  computed: {
    UploadCode() {return UploadCode},
    DragAndDropCode() {return DragAndDropCode},
  },
  components: {
    ...globalComponents,
    SideMenu,
    Upload,
    DragAndDrop,

  },
  methods:{

  },

}
