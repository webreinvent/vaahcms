<template>
    <div class="grid components-list">
            <Sidebar></Sidebar>
        <div class="col-12">
            <div class="grid">
                <div class="col-12 p-fluid">
                    <div class="card">
                        <CodePreview name="components/Colors.vue" :code="raw.colors">
                            <Colors/>
                        </CodePreview>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <CodePreview name="components/ButtonsComponent.vue" :code="raw.buttons">
                            <ButtonsComponent/>
                        </CodePreview>
                    </div>
                </div>

                <div class="col-12 lg:col-6">
                    <div class="card">
                        <CodePreview name="components/MessagesComponent.vue" :code="raw.message">
                            <MessagesComponent/>
                        </CodePreview>
                    </div>
                </div>

                <div class="col-12 lg:col-6">
                    <div class="card">
                        <CodePreview name="components/ToastsComponent.vue" :code="raw.toasts">
                            <ToastsComponent/>
                        </CodePreview>
                    </div>
                 </div>
                <div class="col-12 md:col-7">
                    <div class="card">
                        <CodePreview name="components/Input.vue" :code="raw.input">
                            <Input/>
                        </CodePreview>
                    </div>
                </div>

                <div class="col-12 md:col-5">
                    <div class="card">
                        <CodePreview name="components/Radio.vue" :code="raw.radio">
                            <Radio/>
                        </CodePreview>
                        <CodePreview name="components/CheckboxComponent.vue" :code="raw.checkBox">
                            <CheckboxComponent/>
                        </CodePreview>
                        <CodePreview name="components/SwitchComponent.vue" :code="raw.switch">
                            <SwitchComponent/>
                        </CodePreview>
                    </div>

                    <div class="card p-fluid">
                        <CodePreview name="components/ListboxComponent.vue" :code="raw.listBox">
                            <ListboxComponent/>
                        </CodePreview>

                        <CodePreview name="components/DropdownComponent.vue" :code="raw.dropDown">
                            <DropdownComponent/>
                        </CodePreview>

                        <CodePreview name="components/MulitSelectComponent.vue" :code="raw.multiSelect">
                            <MulitSelectComponent/>
                        </CodePreview>
                    </div>

                    <div class="card p-fluid">

                        <CodePreview name="components/ToggleButtonComponent.vue" :code="raw.toggleButton">
                            <ToggleButtonComponent/>
                        </CodePreview>

                        <CodePreview name="components/SelectButtonComponent.vue" :code="raw.selectButton">
                            <SelectButtonComponent/>
                        </CodePreview>

                        <CodePreview name="components/MultilipleSelectButtonComponent.vue" :code="raw.multipleSelect">
                            <MultilipleSelectButtonComponent/>
                        </CodePreview>
                    </div>
                </div>


                <div class="col-12 p-fluid">
                    <div class="card">
                        <CodePreview name="components/Level.vue" :code="raw.level">
                            <Level/>
                        </CodePreview>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <CodePreview name="components/DataTableComponent.vue" :code="raw.dataTable">
                            <DataTableComponent/>
                        </CodePreview>
                    </div>
                </div>

                <div class="col-12 md:col-6">
                    <div class="card">
                        <CodePreview name="components/AccordionComponent.vue" :code="raw.accordion">
                            <AccordionComponent/>
                        </CodePreview>
                    </div>
                    <div class="card">
                        <CodePreview name="components/TabViewComponent.vue" :code="raw.tabView">
                            <TabViewComponent/>
                        </CodePreview>
                    </div>
                </div>
                <div class="col-12 md:col-6">
                    <div class="card">
                        <CodePreview name="components/PanelComponent.vue" :code="raw.panel">
                            <PanelComponent/>
                        </CodePreview>
                    </div>
                    <div class="card">
                        <CodePreview name="components/FieldSetComponent.vue" :code="raw.field">
                            <FieldSetComponent/>
                        </CodePreview>
                    </div>
                </div>
                <div class="col-12 md:col-6">
                    <div class="card p-fluid">
                        <CodePreview name="components/OverlayPanelComponent.vue" :code="raw.overlay">
                            <OverlayPanelComponent/>
                        </CodePreview>
                    </div>
                </div>
                <div class="col-12 md:col-6">
                    <div class="card p-fluid">
                        <CodePreview name="components/DialogComponent.vue" :code="raw.dialog">
                            <DialogComponent/>
                        </CodePreview>
                    </div>
                </div>
                <div class="col-12 md:col-6">
                    <div class="card p-fluid">
                        <CodePreview name="components/ConfirmPopupComponent.vue" :code="raw.confirmPopup">
                            <ConfirmPopupComponent/>
                        </CodePreview>
                    </div>
                </div>
                <div class="col-12 md:col-6">
                    <div class="card p-fluid">
                        <CodePreview name="components/ConfirmDialogComponent.vue" :code="raw.confirmDialog">
                            <ConfirmDialogComponent/>
                        </CodePreview>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card card-w-title">
                        <CodePreview name="components/MenubarComponent.vue" :code="raw.menuBar">
                            <MenubarComponent/>
                        </CodePreview>
                    </div>
                </div>
                <div class="col-12 md:col-6">
                    <div class="card">
                        <CodePreview name="components/TieredMenuComponent.vue" :code="raw.tieredMenu">
                            <TieredMenuComponent/>
                        </CodePreview>
                    </div>
                </div>

                <div class="col-12 md:col-6">
                    <div class="card">
                        <CodePreview name="components/PlainMenuComponent.vue" :code="raw.plainMenu">
                            <PlainMenuComponent/>
                        </CodePreview>
                    </div>
                </div>

                <div class="col-12 md:col-6">
                    <div class="card">
                        <CodePreview name="components/OverlayMenuComponent.vue" :code="raw.overlayMenu">
                            <OverlayMenuComponent/>
                        </CodePreview>
                    </div>
                </div>
                <div class="col-12 md:col-6">
                    <div class="card">
                        <CodePreview name="components/ContextMenuComponent.vue" :code="raw.contextMenu">
                            <ContextMenuComponent/>
                        </CodePreview>
                    </div>
                </div>



                <div class="col-12 lg:col-6">
                    <div class="card">
                        <CodePreview name="components/TimelineComponent.vue" :code="raw.timeline">
                            <TimelineComponent/>
                        </CodePreview>
                    </div>
                </div>

                <div class="col-12 lg:col-6">
                    <div class="card">
                        <CodePreview name="components/InlineMessageComponent.vue" :code="raw.inlineMessage">
                            <InlineMessageComponent/>
                        </CodePreview>
                    </div>
                </div>

                <div class="col-12 lg:col-6">
                    <div class="card">
                        <CodePreview name="components/HelperTextComponent.vue" :code="raw.helperText">
                            <HelperTextComponent/>
                        </CodePreview>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import CodePreview from '../../components/organisms/UI-elements/CodePreview.vue';
import Sidebar from "../../components/organisms/UI-elements/Sidebar.vue"
import Level from "../../components/organisms/UI-elements/Level.vue";
import LevelRaw from "../../components/organisms/UI-elements/Level.vue?raw";
import Colors from "../../components/organisms/UI-elements/Colors.vue"
import ColorsRaw from "../../components/organisms/UI-elements/Colors.vue?raw"
import Input from "../../components/organisms/UI-elements/InputComponent.vue";
import InputRaw from "../../components/organisms/UI-elements/InputComponent.vue?raw";
import Radio from "../../components/organisms/UI-elements/Radio.vue";
import RadioRaw from "../../components/organisms/UI-elements/Radio.vue?raw";
import CheckboxComponent from "../../components/organisms/UI-elements/CheckboxComponent.vue";
import CheckboxComponentRaw from "../../components/organisms/UI-elements/CheckboxComponent.vue?raw";
import ToggleButtonComponent from "../../components/organisms/UI-elements/ToggleButtonComponent.vue";
import ToggleButtonComponentRaw from "../../components/organisms/UI-elements/ToggleButtonComponent.vue?raw";
import ListboxComponent from "../../components/organisms/UI-elements/ListboxComponent.vue";
import ListboxComponentRaw from "../../components/organisms/UI-elements/ListboxComponent.vue?raw";
import DropdownComponent from "../../components/organisms/UI-elements/DropdownComponent.vue";
import DropdownComponentRaw from "../../components/organisms/UI-elements/DropdownComponent.vue?raw";
import MulitSelectComponent from "../../components/organisms/UI-elements/MulitSelectComponent.vue";
import MulitSelectComponentRaw from "../../components/organisms/UI-elements/MulitSelectComponent.vue?raw";
import SelectButtonComponent from "../../components/organisms/UI-elements/SelectButtonComponent.vue";
import SelectButtonComponentRaw from "../../components/organisms/UI-elements/SelectButtonComponent.vue?raw";
import MultilipleSelectButtonComponent from "../../components/organisms/UI-elements/MultilipleSelectButtonComponent.vue";
import MultilipleSelectButtonComponentRaw from "../../components/organisms/UI-elements/MultilipleSelectButtonComponent.vue?raw";
import ButtonsComponent from "../../components/organisms/UI-elements/ButtonsComponent.vue";
import ButtonsComponentRaw from "../../components/organisms/UI-elements/ButtonsComponent.vue?raw";
import SwitchComponent from "../../components/organisms/UI-elements/SwitchComponent.vue";
import SwitchComponentRaw from "../../components/organisms/UI-elements/SwitchComponent.vue?raw";
import DataTableComponent from "../../components/organisms/UI-elements/DataTableComponent.vue";
import DataTableComponentRaw from "../../components/organisms/UI-elements/DataTableComponent.vue?raw";
import AccordionComponent from "../../components/organisms/UI-elements/AccordionComponent.vue";
import AccordionComponentRaw from "../../components/organisms/UI-elements/AccordionComponent.vue?raw";
import TabViewComponent from "../../components/organisms/UI-elements/TabViewComponent.vue";
import TabViewComponentRaw from "../../components/organisms/UI-elements/TabViewComponent.vue?raw";
import PanelComponent from "../../components/organisms/UI-elements/PanelComponent.vue";
import PanelComponentRaw from "../../components/organisms/UI-elements/PanelComponent.vue?raw";
import FieldSetComponent from "../../components/organisms/UI-elements/FieldSetComponent.vue";
import FieldSetComponentRaw from "../../components/organisms/UI-elements/FieldSetComponent.vue?raw";
import OverlayPanelComponent from "../../components/organisms/UI-elements/OverlayPanelComponent.vue";
import OverlayPanelComponentRaw from "../../components/organisms/UI-elements/OverlayPanelComponent.vue?raw";
import DialogComponent from "../../components/organisms/UI-elements/DialogComponent.vue";
import DialogComponentRaw from "../../components/organisms/UI-elements/DialogComponent.vue?raw";
import ConfirmPopupComponent from "../../components/organisms/UI-elements/ConfirmPopupComponent.vue";
import ConfirmPopupComponentRaw from "../../components/organisms/UI-elements/ConfirmPopupComponent.vue?raw";
import ConfirmDialogComponent from "../../components/organisms/UI-elements/ConfirmDialogComponent.vue";
import ConfirmDialogComponentRaw from "../../components/organisms/UI-elements/ConfirmDialogComponent.vue?raw";
import MenubarComponent from "../../components/organisms/UI-elements/MenubarComponent.vue";
import MenubarComponentRaw from "../../components/organisms/UI-elements/MenubarComponent.vue?raw";
import TieredMenuComponent from "../../components/organisms/UI-elements/TieredMenuComponent.vue";
import TieredMenuComponentRaw from "../../components/organisms/UI-elements/TieredMenuComponent.vue?raw";
import PlainMenuComponent from "../../components/organisms/UI-elements/PlainMenuComponent.vue";
import PlainMenuComponentRaw from "../../components/organisms/UI-elements/PlainMenuComponent.vue?raw";
import OverlayMenuComponent from "../../components/organisms/UI-elements/OverlayMenuComponent.vue";
import OverlayMenuComponentRaw from "../../components/organisms/UI-elements/OverlayMenuComponent.vue?raw";
import ContextMenuComponent from "../../components/organisms/UI-elements/ContextMenuComponent.vue";
import ContextMenuComponentRaw from "../../components/organisms/UI-elements/ContextMenuComponent.vue?raw";
import MessagesComponent from "../../components/organisms/UI-elements/MessagesComponent.vue";
import MessagesComponentRaw from "../../components/organisms/UI-elements/MessagesComponent.vue?raw";
import ToastsComponent from "../../components/organisms/UI-elements/ToastsComponent.vue";
import ToastsComponentRaw from "../../components/organisms/UI-elements/ToastsComponent.vue?raw";
import InlineMessageComponent from "../../components/organisms/UI-elements/InlineMessageComponent.vue";
import InlineMessageComponentRaw from "../../components/organisms/UI-elements/InlineMessageComponent.vue?raw";
import TimelineComponent from "../../components/organisms/UI-elements/TimelineComponent.vue";
import TimelineComponentRaw from "../../components/organisms/UI-elements/TimelineComponent.vue?raw";
import HelperTextComponent from "../../components/organisms/UI-elements/HelperTextComponent.vue";
import HelperTextComponentRaw from "../../components/organisms/UI-elements/HelperTextComponent.vue?raw";
export default {
    components: {
        DataTableComponent,
        OverlayPanelComponent,
        HelperTextComponent,
        TimelineComponent,
        InlineMessageComponent,
        ToastsComponent,
        MessagesComponent,
        ContextMenuComponent,
        OverlayMenuComponent,
        PlainMenuComponent,
        TieredMenuComponent,
        MenubarComponent,
        ConfirmDialogComponent,
        ConfirmPopupComponent,
        DialogComponent,
        FieldSetComponent,
        PanelComponent,
        TabViewComponent,
        AccordionComponent,
        SwitchComponent,
        ButtonsComponent,
        MultilipleSelectButtonComponent,
        SelectButtonComponent,
        MulitSelectComponent,
        DropdownComponent,
        ListboxComponent,
        ToggleButtonComponent,
        CheckboxComponent, Radio, Input, CodePreview, Level, Sidebar, Colors
    },
    name: "UiElements",
    data() {
        return {
            raw: {
                level: LevelRaw,
                colors: ColorsRaw,
                dataTable:DataTableComponentRaw,
                overlay:OverlayPanelComponentRaw,
                input: InputRaw,
                radio: RadioRaw,
                checkBox: CheckboxComponentRaw,
                toggleButton: ToggleButtonComponentRaw,
                listBox: ListboxComponentRaw,
                dropDown: DropdownComponentRaw,
                multiSelect: MulitSelectComponentRaw,
                selectButton: SelectButtonComponentRaw,
                multipleSelect: MultilipleSelectButtonComponentRaw,
                buttons: ButtonsComponentRaw,
                switch: SwitchComponentRaw,
                accordion: AccordionComponentRaw,
                tabView: TabViewComponentRaw,
                panel: PanelComponentRaw,
                field: FieldSetComponentRaw,
                dialog: DialogComponentRaw,
                confirmPopup: ConfirmPopupComponentRaw,
                confirmDialog: ConfirmDialogComponentRaw,
                menuBar: MenubarComponentRaw,
                tieredMenu: TieredMenuComponentRaw,
                plainMenu: PlainMenuComponentRaw,
                overlayMenu: OverlayMenuComponentRaw,
                contextMenu: ContextMenuComponentRaw,
                message: MessagesComponentRaw,
                toasts: ToastsComponentRaw,
                inlineMessage: InlineMessageComponentRaw,
                timeline: TimelineComponentRaw,
                helperText: HelperTextComponentRaw
            },
        }
    },
    computed: {
        containerClass() {
            return ['grid', {
                'p-input-filled': this.$appState.inputStyle === 'filled',
            }
            ];
        }
    }
}
</script>

<style scoped lang="scss">

</style>
