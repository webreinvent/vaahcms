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

          <SectionTitle title="Buefy - Autocomplete"
                        link="https://buefy.org/documentation/autocomplete/">
          </SectionTitle>


          <SectionCode name="AutoComplete" :code="AutoCompleteCode">
            <AutoComplete></AutoComplete>
          </SectionCode>


          <SectionCode name="Object Array" :code="ObjectArrayCode">
            <ObjectArray></ObjectArray>
          </SectionCode>


          <SectionCode name="Header" :code="HeaderCode">
            <Header></Header>
          </SectionCode>


          <SectionCode name="Footer" :code="FooterCode">
            <Footer></Footer>
          </SectionCode>


          <SectionCode name="Async With Custom Template" :code="AsyncWithCustomTemplateCode">
            <AsyncWithCustomTemplate></AsyncWithCustomTemplate>
          </SectionCode>


          <SectionCode name="Async With Infinite Scroll" :code="AsyncWithInfiniteScrollCode">
            <AsyncWithInfiniteScroll></AsyncWithInfiniteScroll>
          </SectionCode>


        </div>

      </div>
    </section>

  </div>




  <Footer></Footer>


  </div>

</template>

<script src="./autocompleteJs.js"></script>
