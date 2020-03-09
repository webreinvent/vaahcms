import globalComponents from "./../../../helpers/globalComponents";
import SideMenu from "../../partials/SideMenu";

import Slider from './../../../../vaahnuxt/buefy/components/FormControl/Slider/Slider'
import SliderCode from "!raw-loader!./../../../buefy/components/FormControl/Slider/Slider";

import Sizes from './../../../../vaahnuxt/buefy/components/FormControl/Slider/Sizes'
import SizesCode from "!raw-loader!./../../../buefy/components/FormControl/Slider/Sizes";

import Types from './../../../../vaahnuxt/buefy/components/FormControl/Slider/Types'
import TypesCode from "!raw-loader!./../../../buefy/components/FormControl/Slider/Types";

import Customization from './../../../../vaahnuxt/buefy/components/FormControl/Slider/Customization'
import CustomizationCode from "!raw-loader!./../../../buefy/components/FormControl/Slider/Customization";

import TickAndLabel from './../../../../vaahnuxt/buefy/components/FormControl/Slider/TickAndLabel'
import TickAndLabelCode from "!raw-loader!./../../../buefy/components/FormControl/Slider/TickAndLabel";

import RangeSlider from './../../../../vaahnuxt/buefy/components/FormControl/Slider/RangeSlider'
import RangeSliderCode from "!raw-loader!./../../../buefy/components/FormControl/Slider/RangeSlider";

import LazyUpdate from './../../../../vaahnuxt/buefy/components/FormControl/Slider/LazyUpdate'
import LazyUpdateCode from "!raw-loader!./../../../buefy/components/FormControl/Slider/LazyUpdate";

export default {
  layout: 'ui',
  head () {
    return {
      title: 'Buefy UI Block',
    }
  },
  computed: {
    SliderCode() {return SliderCode},
    SizesCode() {return SizesCode},
    TypesCode() {return TypesCode},
    CustomizationCode() {return CustomizationCode},
    TickAndLabelCode() {return TickAndLabelCode},
    RangeSliderCode() {return RangeSliderCode},
    LazyUpdateCode() {return LazyUpdateCode},
  },
  components: {
    ...globalComponents,
    SideMenu,
    Slider,
    Sizes,
    Types,
    Customization,
    TickAndLabel,
    RangeSlider,
    LazyUpdate

  },
  methods:{

  },

}
