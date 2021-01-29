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

          <SectionTitle title="Buefy - Datepicker"
                        link="https://buefy.org/documentation/datepicker/">
          </SectionTitle>


          <SectionCode name="Datepicker" :code="DatepickerCode">
            <Datepicker></Datepicker>
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


          <SectionCode name="Header" :code="HeaderCode">
            <Header></Header>
          </SectionCode>


          <SectionCode name="Month Picker" :code="MonthPickerCode">
            <MonthPicker></MonthPicker>
          </SectionCode>


          <SectionCode name="Programmatically Opening" :code="ProgrammaticallyOpeningCode">
            <ProgrammaticallyOpening></ProgrammaticallyOpening>
          </SectionCode>


          <SectionCode name="Inline" :code="InlineCode">
            <Inline></Inline>
          </SectionCode>


          <SectionCode name="Events" :code="EventsCode">
            <Events></Events>
          </SectionCode>


          <SectionCode name="Select A Range Of Dates" :code="SelectARangeOfDatesCode">
            <SelectARangeOfDates></SelectARangeOfDates>
          </SectionCode>


          <SectionCode name="Select Multiple Dates" :code="SelectMultipleDatesCode">
            <SelectMultipleDates></SelectMultipleDates>
          </SectionCode>


        </div>

      </div>
    </section>

  </div>




  <Footer></Footer>


  </div>

</template>

<script src="./datepickerjs.js"></script>
