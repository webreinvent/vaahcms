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

            <SectionTitle title="Buefy - Tag"
                          link="https://buefy.org/documentation/tag">
            </SectionTitle>


            <SectionCode name="Tag" :code="TagCode">
              <Tag></Tag>
            </SectionCode>



            <SectionCode name="Closable" :code="ClosableCode">
              <Closable></Closable>
            </SectionCode>



            <SectionCode name="TagList" :code="TagListCode">
              <TagList></TagList>
            </SectionCode>



            <SectionCode name="Sizes" :code="SizesCode">
              <Sizes></Sizes>
            </SectionCode>


          </div>

      </div>
    </section>

  </div>




  <Footer></Footer>


  </div>

</template>

<script src="./tagjs.js"></script>
