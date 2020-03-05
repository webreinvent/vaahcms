import globalComponents from "./../../../helpers/globalComponents";
import SideMenu from "../../partials/SideMenu";

import TagInput from './../../../../vaahnuxt/buefy/components/FormControl/TagInput/TagInput'
import TagInputCode from "!raw-loader!./../../../buefy/components/FormControl/TagInput/TagInput";

import AutoComplete from './../../../../vaahnuxt/buefy/components/FormControl/TagInput/AutoComplete'
import AutoCompleteCode from "!raw-loader!./../../../buefy/components/FormControl/TagInput/AutoComplete";

import TemplatedAutocomplete from './../../../../vaahnuxt/buefy/components/FormControl/TagInput/TemplatedAutocomplete'
import TemplatedAutocompleteCode from "!raw-loader!./../../../buefy/components/FormControl/TagInput/TemplatedAutocomplete";

import Limits from './../../../../vaahnuxt/buefy/components/FormControl/TagInput/Limits'
import LimitsCode from "!raw-loader!./../../../buefy/components/FormControl/TagInput/Limits";

import States from './../../../../vaahnuxt/buefy/components/FormControl/TagInput/States'
import StatesCode from "!raw-loader!./../../../buefy/components/FormControl/TagInput/States";

import TagTypes from './../../../../vaahnuxt/buefy/components/FormControl/TagInput/TagTypes'
import TagTypesCode from "!raw-loader!./../../../buefy/components/FormControl/TagInput/TagTypes";

import Sizes from './../../../../vaahnuxt/buefy/components/FormControl/TagInput/Sizes'
import SizesCode from "!raw-loader!./../../../buefy/components/FormControl/TagInput/Sizes";

import Modifiers from './../../../../vaahnuxt/buefy/components/FormControl/TagInput/Modifiers'
import ModifiersCode from "!raw-loader!./../../../buefy/components/FormControl/TagInput/Modifiers";

import Validation from './../../../../vaahnuxt/buefy/components/FormControl/TagInput/Validation'
import ValidationCode from "!raw-loader!./../../../buefy/components/FormControl/TagInput/Validation";

export default {
  layout: 'ui',
  head () {
    return {
      title: 'Buefy UI Block',
    }
  },
  computed: {
    TagInputCode() {return TagInputCode},
    AutoCompleteCode() {return AutoCompleteCode},
    TemplatedAutocompleteCode() {return TemplatedAutocompleteCode},
    LimitsCode() {return LimitsCode},
    StatesCode() {return StatesCode},
    TagTypesCode() {return TagTypesCode},
    SizesCode() {return SizesCode},
    ModifiersCode() {return ModifiersCode},
    ValidationCode() {return ValidationCode},
  },
  components: {
    ...globalComponents,
    SideMenu,
    TagInput,
    AutoComplete,
    TemplatedAutocomplete,
    Limits,
    States,
    TagTypes,
    Sizes,
    Modifiers,
    Validation,

  },
  methods:{

  },

}
