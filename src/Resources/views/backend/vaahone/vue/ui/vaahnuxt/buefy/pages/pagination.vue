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

          <SectionTitle title="Buefy - Pagination"
                        link="https://buefy.org/documentation/pagination">
          </SectionTitle>


          <SectionCode name="Pagination" :code="PaginationCode">
            <Pagination></Pagination>
          </SectionCode>


          <SectionCode name="Custom Pagination Buttons" :code="CustomPaginationButtonsCode">
            <CustomPaginationButtons></CustomPaginationButtons>
          </SectionCode>


        </div>

      </div>
    </section>

  </div>




  <Footer></Footer>


  </div>

</template>

<script src="./paginationjs.js"></script>
