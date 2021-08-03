# DBML Database

- [Database Table Structure](https://dbdocs.io/webreinvent/vaahcms)
- [Database Relationship](https://dbdocs.io/webreinvent/vaahcms?view=relationships)

### How to Create DB Docs
- Step 1: Export `sql` database structure from `phpmyadmin`
- Step 2: Login to `https://dbdiagram.io/`
- Step 3: Click on `Import > Import from MySql` and select the database file
- Step 4: Once imported, you will be able to see the `dbml` code in left panel
- Step 5: Copy the `dbml` code and save in a file as `vaahcms.dbml`
- Step 6: Open terminal and run `npm install -g dbdocs`
- Step 7: Then run `dbdocs build <dbml_file_name.dbml> --project vaahcms`
- Step 8: This will give a public URL with db docs

## Resources
- https://www.dbml.org/ 
- https://dbdiagram.io/
- https://dbdocs.io/
