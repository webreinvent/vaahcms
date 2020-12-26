<script src="./CheatsheetJs.js"></script>
<template>
  <div style="background: #f1f3f5; padding: 48px 0px;">
    <div class="container">

      <div class="columns">
        <div class="column is-12">




          <div class="screen-sizes ">


            <div >
              <b-tabs type="is-boxed" lass="block">

                <b-tab-item label="Screen sizes">

                  <div v-html="templates.screen_size"></div>

                </b-tab-item>

                <b-tab-item label="Sections (Rows)">

                  <div class="content">
                    <a href="https://www.youtube.com/watch?v=ouI1_tZ1yK4"
                       target="_blank"><i class="mdi mdi-youtube"></i> Watch video tutorial</a>
                  </div>

                  <VhCodeCopy
                    title="100% width, 100% background and content in grid."
                    :code="templates.row_full_hd"/>

                  <VhCodeCopy
                    title="100%  width, 100% background and fluid content."
                    :code="templates.row_full_fluid"/>

                  <VhCodeCopy
                    title="Container width and background in grid."
                    :code="templates.row"/>

                </b-tab-item>


                <b-tab-item label="Columns">

                  <VhCodeCopy
                    title="Responsive Columns"
                    :code="templates.columns"/>

                </b-tab-item>

                <b-tab-item label="Level (Left & Right)">

                  <VhCodeCopy
                    title="For Left Right Items"
                    :code="templates.level"/>

                </b-tab-item>

                <b-tab-item label="Hero">

                  <VhCodeCopy
                    title="For Headers"
                    :code="templates.hero"/>

                </b-tab-item>

                <b-tab-item label="Block">

                  <VhCodeCopy
                    title="For HTML Blocks"
                    :code="templates.block"/>

                </b-tab-item>

                <b-tab-item label="Content">

                  <VhCodeCopy
                    title="For WYSIWYG Content"
                    :code="templates.content"/>

                </b-tab-item>


              </b-tabs>


            </div>


          </div>




        </div>

        <div class="column is-12">

          <input type="text" class="input" v-model="q" placeholder="Search Classes" />


          <ul class="cheathseet-list">
            <li v-if="content" v-for="type in list_filtered">
              <div class="content has-margin-top-10 has-margin-bottom-5">
                <h3 class="has-text-primary title is-5 has-margin-bottom-5"
                v-html="type.name">

                </h3>
              </div>
              <ul>
                <li class="is-inline-block box has-padding-5 has-margin-5" v-for="item in type.list">
                  .{{item.class}} <small class="is-size-7 has-text-info" v-if="item.notes">/ {{item.notes}}</small>
                  <VhCopy :data="item.class" class="is-pulled-right"></VhCopy>

                </li>
              </ul>
            </li>
          </ul>



        </div>


      </div>


      <div class="columns">
        <div class="column is-12">
          <hr/>


          <div class="screen-sizes content">
            <h4 class="title is-4 has-text-primary">
              Columns
            </h4>
            <div class="box">
              <div class="columns">
                <div class="column">
                  <p class="content">.container</p>
                </div>
                <div class="column">
                  <VhCopy :data="'container'" class="is-pulled-right"></VhCopy>
                </div>
              </div>
              <h6 class="is-6 has-background-light" style="border-bottom: 1px solid #e2e2e2; padding: 20px 0px 20px 10px;">Wrap as many .column’s’ as you like in a .columns wrapper</h6>

              <div class="content">
                <VhCopy :data="contentCode" class="is-pulled-right"></VhCopy>
              </div>
              <div class="columns">
                <div class="column">
                  <pre class=" language-html"><code class=" language-html"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>columns<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>column<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>column<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>column<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>column<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>column<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                </code></pre>
                </div>
              </div>
            </div>
          </div>
          <div class="content-class content">
            <h4 class="title is-4 has-text-primary">
              WYSIWYG Content
            </h4>
            <div class="box">
              <div class="columns">
                <div class="column is-12">
                  <SectionCode name="WYSIWYG Content" :code="CheatsheetContentCode">
                    <CheatsheetContent></CheatsheetContent>
                  </SectionCode>
                </div>
              </div>
              <h6 class="is-6 has-background-light" style="border-bottom: 1px solid #e2e2e2; padding: 20px 0px 20px 10px;">To provide default stylings for commonly generated WYSIWYG contents, use the .content class.</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>



