/* * * * * * * * * * * * * * * * *
 * Pagination
 * javascript page navigation
 * * * * * * * * * * * * * * * * */

var Pagination = {

    data: {},
    size: 0,
    page: 1,
    step: 3,
    Init: function (size, page, step) {
        Pagination.size = parseInt(size);
        Pagination.page = page;
        Pagination.step = step;

        console.log(Pagination.page);

        return Pagination.Start();
    },
    Start: function() {

        var pages;
        if (Pagination.size < Pagination.step * 2 + 6) {
            pages = Pagination.Add(1, Pagination.size + 1);

        }
        else if (Pagination.page < Pagination.step * 2 + 1) {

            pages = Pagination.Add(1, Pagination.step * 2 + 4);
            pages.push("...");
            pages.push(Pagination.Last());
        }
        else if (Pagination.page > Pagination.size - Pagination.step * 2) {
            pages = Pagination.Add(Pagination.size - Pagination.step * 2 - 2, Pagination.size + 1);
            pages.unshift("...");
            pages.unshift(Pagination.First());
        }
        else {
            var start = Pagination.page - Pagination.step;
            var end = Pagination.page + Pagination.step + 1;
            pages = Pagination.Add(start, end);
            pages.unshift("...");
            pages.unshift(Pagination.First());
            pages.push("...");
            pages.push(Pagination.Last());
        }

        return pages;
    },
    // add pages by number (from [s] to [f])
    Add: function(s, f) {
        var pages = [];
        for (var i = s; i < f; i++) {
            pages.push(i);
        }
        return pages;
    },
    // add last page with separator
    Last: function() {
        return Pagination.size;
    },
    First: function() {
        return 1;
    },

};
