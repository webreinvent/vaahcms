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

            <SectionTitle title="Buefy - Table"
                          link="https://buefy.org/documentation/table">
            </SectionTitle>


            <SectionCode name="Table" :code="TableCode">
              <Table></Table>
            </SectionCode>


            <SectionCode name="Sandbox With Custom Template" :code="SandboxWithCustomTemplateCode">
              <SandboxWithCustomTemplate></SandboxWithCustomTemplate>
            </SectionCode>


            <SectionCode name="Selection" :code="SelectionCode">
              <Selection></Selection>
            </SectionCode>


            <SectionCode name="Checkable" :code="CheckableCode">
              <Checkable></Checkable>
            </SectionCode>


            <SectionCode name="Searchable" :code="SearchableCode">
              <Searchable></Searchable>
            </SectionCode>


            <SectionCode name="Pagination And Sorting" :code="PaginationAndSortingCode">
              <PaginationAndSorting></PaginationAndSorting>
            </SectionCode>


            <SectionCode name="Detailed Rows" :code="DetailedRowsCode">
              <DetailedRows></DetailedRows>
            </SectionCode>


            <SectionCode name="Custom Detailed Rows" :code="CustomDetailedRowsCode">
              <CustomDetailedRows></CustomDetailedRows>
            </SectionCode>


            <SectionCode name="Row Status" :code="RowStatusCode">
              <RowStatus></RowStatus>
            </SectionCode>


            <SectionCode name="Custom Headers" :code="CustomHeadersCode">
              <CustomHeaders></CustomHeaders>
            </SectionCode>


            <SectionCode name="Subheadings" :code="SubheadingsCode">
              <Subheadings></Subheadings>
            </SectionCode>


            <SectionCode name="Toggle Columns" :code="ToggleColumnsCode">
              <ToggleColumns></ToggleColumns>
            </SectionCode>


            <SectionCode name="Footer" :code="FooterCode">
              <Footer></Footer>
            </SectionCode>


            <SectionCode name="Async Data" :code="AsyncDataCode">
              <b-notification
                type="is-warning"
                aria-close-label="Close notification"
                role="alert">
                Async Data Generating errors and needs to be fixed.
              </b-notification>
        <!--      <AsyncData></AsyncData>-->
            </SectionCode>


            <SectionCode name="Draggable Rows" :code="DraggableRowsCode">
              <DraggableRows></DraggableRows>
            </SectionCode>


          </div>

      </div>
    </section>

  </div>




  <Footer></Footer>


  </div>

</template>

<script src="./tablejs.js"></script>
