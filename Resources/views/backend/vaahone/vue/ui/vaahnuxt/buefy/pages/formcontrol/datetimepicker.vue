<template>

  <div>

  <TopMenu></TopMenu>
  <PageHeader></PageHeader>
  <div class="container" >

    <section class="main-content columns">
      <aside class="column is-2 section">
        <SideMenu></SideMenu>
      </aside>

      <div class="container column is-10">

        <div class="main-content">

          <SectionTitle title="Buefy - Datetimepicker"
                        link="https://buefy.org/documentation/datetimepicker/">
          </SectionTitle>


          <SectionCode name="DateTimePicker" :code="DateTimePickerCode">
            <DateTimePicker></DateTimePicker>
          </SectionCode>


          <SectionCode name="Editable (non readonly)" :code="EditableCode">
            <Editable></Editable>
          </SectionCode>


          <SectionCode name="Range" :code="RangeCode">
            <Range></Range>
          </SectionCode>


          <SectionCode name="Footer" :code="FooterCode">
            <Footer></Footer>
          </SectionCode>


          <SectionCode name="Inline" :code="InlineCode">
            <Inline></Inline>
          </SectionCode>


        </div>

      </div>
    </section>

  </div>




  <Footer></Footer>


  </div>

</template>

<script src="./datetimepickerjs.js"></script>
