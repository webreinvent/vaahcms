<template>
  <div>
    <div class="container">
      <div class="columns">
        <div class="column is-12">
          <div class="content">
            <h6 class="is-6 has-background-light" style="border-bottom: 1px solid #e2e2e2; padding: 20px 0px 20px 10px;">Headings</h6>
            <h1>Heading 1</h1>
            <h2>Heading 2</h2>
            <h3>Heading 3</h3>
            <h4>Heading 4</h4>
            <h5>Heading 5</h5>
            <h6>Heading 6</h6>
            <h6 class="is-6 has-background-light" style="border-bottom: 1px solid #e2e2e2; padding: 20px 0px 20px 10px;">Ordered List</h6>
            <ol>
              <li>List Item One</li>
              <li>List Item Two</li>
              <li>List Item Three</li>
              <li>List Item Four</li>
            </ol>
            <h6 class="is-6 has-background-light" style="border-bottom: 1px solid #e2e2e2; padding: 20px 0px 20px 10px;">Unordered List</h6>
            <ul>
              <li>List Item One</li>
              <li>List Item Two</li>
              <li>List Item Three</li>
              <li>List Item Four</li>
            </ul>
            <h6 class="is-6 has-background-light" style="border-bottom: 1px solid #e2e2e2; padding: 20px 0px 20px 10px;">Paragraph</h6>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A amet beatae commodi debitis distinctio earum esse expedita magnam, magni maxime, natus nisi nobis odit quod quos reprehenderit rerum sequi sint tempora tempore, tenetur vero vitae? Dolorem facilis laudantium natus quae.</p>
            <h6 class="is-6 has-background-light" style="border-bottom: 1px solid #e2e2e2; padding: 20px 0px 20px 10px;">Strike Through Text</h6>
            <del>Lorem ipsum dolor sit amet.</del>
            <h6 class="is-6 has-background-light" style="border-bottom: 1px solid #e2e2e2; padding: 20px 0px 20px 10px;">Italic Paragraph</h6>
            <p><i>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores, sunt!</i></p>
            <h6 class="is-6 has-background-light" style="border-bottom: 1px solid #e2e2e2; padding: 20px 0px 20px 10px;">Bold Paragraph</h6>
            <p><b>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi cum eius eos ex explicabo necessitatibus nemo nihil nisi quas, rem?</b></p>
            <h6 class="is-6 has-background-light" style="border-bottom: 1px solid #e2e2e2; padding: 20px 0px 20px 10px;">Hyperlink</h6>
            <a href="#!">Lorem ipsum dolor sit.</a>
            <h6 class="is-6 has-background-light" style="border-bottom: 1px solid #e2e2e2; padding: 20px 0px 20px 10px;">Table</h6>
            <b-table :data="data" :columns="columns"></b-table>
            <h6 class="is-6 has-background-light" style="border-bottom: 1px solid #e2e2e2; padding: 20px 0px 20px 10px;">Blockquote</h6>
            <blockquote cite="http://www.worldwildlife.org/who/index.html">
              For 50 years, WWF has been protecting the future of nature. The world's leading conservation organization, WWF works in 100 countries and is supported by 1.2 million members in the United States and close to 5 million globally.
            </blockquote>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>


  export default {
    props: ['content'],
    data() {
      return {
        data: [
          { 'id': 1, 'first_name': 'Jesse', 'last_name': 'Simmons', 'date': '2016-10-15 13:43:27', 'gender': 'Male' },
          { 'id': 2, 'first_name': 'John', 'last_name': 'Jacobs', 'date': '2016-12-15 06:00:53', 'gender': 'Male' },
          { 'id': 3, 'first_name': 'Tina', 'last_name': 'Gilbert', 'date': '2016-04-26 06:26:28', 'gender': 'Female' },
          { 'id': 4, 'first_name': 'Clarence', 'last_name': 'Flores', 'date': '2016-04-10 10:28:46', 'gender': 'Male' },
          { 'id': 5, 'first_name': 'Anne', 'last_name': 'Lee', 'date': '2016-12-06 14:38:38', 'gender': 'Female' }
        ],
        columns: [
          {
            field: 'id',
            label: 'ID',
            width: '40',
            numeric: true
          },
          {
            field: 'first_name',
            label: 'First Name',
          },
          {
            field: 'last_name',
            label: 'Last Name',
          },
          {
            field: 'date',
            label: 'Date',
            centered: true
          },
          {
            field: 'gender',
            label: 'Gender',
          }
        ]
      }
    }
  }
</script>

