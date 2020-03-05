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

          <SectionTitle title="Buefy - TagInput"
                        link="https://buefy.org/documentation/taginput/">
          </SectionTitle>


          <SectionCode name="TagInput" :code="TagInputCode">
            <TagInput></TagInput>
          </SectionCode>


          <SectionCode name="AutoComplete" :code="AutoCompleteCode">
            <AutoComplete></AutoComplete>
          </SectionCode>


          <SectionCode name="Templated Autocomplete" :code="TemplatedAutocompleteCode">
            <TemplatedAutocomplete></TemplatedAutocomplete>
          </SectionCode>


          <SectionCode name="Limits" :code="LimitsCode">
            <Limits></Limits>
          </SectionCode>


          <SectionCode name="States" :code="StatesCode">
            <States></States>
          </SectionCode>


          <SectionCode name="Tag Types" :code="TagTypesCode">
            <TagTypes></TagTypes>
          </SectionCode>


          <SectionCode name="Sizes" :code="SizesCode">
            <Sizes></Sizes>
          </SectionCode>


          <SectionCode name="Modifiers" :code="ModifiersCode">
            <Modifiers></Modifiers>
          </SectionCode>


          <SectionCode name="Validation" :code="ValidationCode">
            <Validation></Validation>
          </SectionCode>


        </div>

      </div>
    </section>

  </div>




  <Footer></Footer>


  </div>

</template>

<script src="./taginputjs.js"></script>
