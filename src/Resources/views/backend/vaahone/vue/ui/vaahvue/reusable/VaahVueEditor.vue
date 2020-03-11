<template>

    <div>
        <div class="tiptap-editor">
            <div class="menu-toolbar">
                <editor-menu-bar :editor="editor" v-slot="{ commands, isActive }">
                    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                        <div class="btn-group mr-2" role="group" aria-label="First group">
                            <button type="button"
                                    :class="{ 'is-active': isActive.bold() }"
                                    @click="commands.bold"
                                    class="btn btn-white btn-icon">
                                <i class="fas fa-bold"></i>
                            </button>
                            <button type="button"
                                    :class="{ 'is-active': isActive.italic() }"
                                    @click="commands.italic"
                                    class="btn btn-white btn-icon">
                                <i class="fas fa-italic"></i>
                            </button>

                            <button type="button"
                                    :class="{ 'is-active': isActive.underline() }"
                                    @click="commands.underline"
                                    class="btn btn-white btn-icon">
                                <i class="fas fa-underline"></i>
                            </button>

                            <button type="button"
                                    :class="{ 'is-active': isActive.heading() }"
                                    @click="commands.heading({ level: 1 })"
                                    class="btn btn-white btn-icon">
                                H1
                            </button>

                            <button type="button"
                                    :class="{ 'is-active': isActive.heading() }"
                                    @click="commands.heading({ level: 2 })"
                                    class="btn btn-white btn-icon">
                                H2
                            </button>

                            <button type="button"
                                    :class="{ 'is-active': isActive.heading() }"
                                    @click="commands.heading({ level: 3 })"
                                    class="btn btn-white btn-icon">
                                H3
                            </button>


                            <button type="button"
                                    :class="{ 'is-active': isActive.bullet_list() }"
                                    @click="commands.bullet_list"
                                    class="btn btn-white btn-icon">
                                <i class="fas fa-list-ul"></i>
                            </button>

                            <button type="button"
                                    :class="{ 'is-active': isActive.ordered_list() }"
                                    @click="commands.ordered_list"
                                    class="btn btn-white btn-icon">
                                <i class="fas fa-list-ol"></i>
                            </button>

                        </div>

                    </div>

                </editor-menu-bar>
            </div>
            <div class="tiptap-editor-content">
                <editor-content  :editor="editor" />
            </div>
        </div>


    </div>


</template>

<script>

    //  IMPORTING EDITOR //
    import { Editor, EditorContent, EditorMenuBar  } from 'tiptap';
    import { Blockquote,  CodeBlock, HardBreak, Heading, OrderedList, BulletList,
        ListItem, TodoItem, TodoList, Bold, Code, Italic, Link, Strike, Underline, History,
    } from 'tiptap-extensions';
    //  END OF IMPORTING EDITOR //

    export default {
        name: "VaahVueEditor",
        props: {
            content:{
                default: '<p>Write...</p>'
            },
        },
        components:{
            EditorContent,
            EditorMenuBar,
        },
        data()
        {
            let obj = {
                editor: null,
                editor_html: null,
            };

            return obj;
        },
        created() {
        },
        mounted(){
            this.editor = this.setupEditor();
            this.setEditorContent();
        },
        watch: {
            '$route' (to, from) {
                if(this.editor)
                {
                    this.editor.destroy();
                    this.editor = this.setupEditor();
                    this.setEditorContent();
                }
            },
            content(newValue)
            {
                if(!newValue)
                {
                    this.editor.clearContent();
                }
            }
        },
        methods: {
            //---------------------------------------------------------------------
            setupEditor: function()
            {
                let editor = new Editor({
                    extensions: [
                        new Blockquote(),
                        new CodeBlock(),
                        new HardBreak(),
                        new Heading({ levels: [1, 2, 3] }),
                        new BulletList(),
                        new OrderedList(),
                        new ListItem(),
                        new TodoItem(),
                        new TodoList(),
                        new Bold(),
                        new Code(),
                        new Italic(),
                        new Link(),
                        new Strike(),
                        new Underline(),
                        new History(),
                    ],
                    content: '<p>Write...</p>',
                    onUpdate: ({ getJSON, getHTML }) => {
                        this.editor_html = getHTML();
                        this.emitEditorHtml();
                    },
                });
                return editor;
            },
            //---------------------------------------------------------------------
            setEditorContent: function () {
                this.editor.setContent(this.content);
            },
            //---------------------------------------------------------------------
            emitEditorHtml: function () {
                this.editor_html = this.editor.getHTML();
                this.$emit('getEditorHtml', this.editor_html);
            }
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
        },
        beforeCreate() {
            console.log('for created-->');
            if(this.editor)
            {
                this.editor.destroy()
            }
        },
        beforeDestroy() {
            //this.editor.destroy()
        },
    }
</script>

