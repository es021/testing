<?php ?>

<div id="search_result" class="text-center">
    <div id="search_table" >
    </div>
</div>

<div hidden="hidden" id="paging_parent">
    <div class="search_result_count text-center"><small>Found <strong class="count"></strong> results in <strong class="page"></strong> pages</small></div>
    <div class="search_page text-center">
        <button class="btn btn_first btn-sm btn-link btn-primary"><<</button>
        <button class="btn btn_prev btn-sm btn-link btn-primary"><</button>
        <span class="search_page_number">
        </span>
        <button  class="btn btn_next btn-sm btn-link btn-primary">></button>
        <button  class="btn btn_last btn-sm btn-link btn-primary">>></button>
    </div>
    <br>
</div>


<script>

    //search result setup
    var search_result = jQuery("#search_result");
    var page_container = jQuery("#search_result .search_page");

    //paging setup
    var paging_parent = jQuery("#paging_parent");
    var search_result_count = paging_parent.find(".search_result_count .count");
    var search_result_page = paging_parent.find(".search_result_count .page");
    var search_page_number = paging_parent.find(".search_page .search_page_number");
    var page_next = paging_parent.find(".search_page .btn_next");
    var page_prev = paging_parent.find(".search_page .btn_prev");
    var page_first = paging_parent.find(".search_page .btn_first");
    var page_last = paging_parent.find(".search_page .btn_last");
    var current_page = 1;
    var current_form = null;

    var page_count = 0;
    var buttonPage = jQuery("<button page=0 class='btn btn_page btn-sm btn-link btn-primary'>0</button>");

    page_first.click(function () {
        current_page = 1;
        initSearch();
    });

    page_last.click(function () {
        current_page = page_count;
        initSearch();
    });

    page_next.click(function () {
        current_page++;
        initSearch();
    });

    page_prev.click(function () {
        current_page--;
        initSearch();
    });

    btn_search.click(function () {
        current_page = 1;
        current_form = search_case_form.serializeArray();
        initSearch();
    });

    buttonPage.click(function () {
        var dom = jQuery(this);
        var page = dom.attr("page");
        current_page = page;
        initSearch();
    });



    function createPageButton(page, isBorder) {
        var toAppend = "";
        if (current_page == page) {
            toAppend = "<strong style='padding:5px 10px; border: 1px solid white;'>" + page + "</strong>";
        } else {
            var toAppend = buttonPage.clone(true, true);
            toAppend.attr("page", page);
            toAppend.html(page);

            if (isBorder) {
                toAppend.addClass("page_border");
            }
        }

        return toAppend;
    }

    function setPagingParent(count_row) {
        search_page_number.html("");

        page_count = Math.ceil(count_row / <?= Info::LIMIT_SEARCH_CASE ?>);
        search_result_count.html(count_row);
        search_result_page.html(page_count);

        var start = 0;
        if (current_page > <?= Info::LIMIT_PAGE_VIEW ?> / 2) {
            start = Number(current_page) - Math.ceil(<?= Info::LIMIT_PAGE_VIEW ?> / 2);
        } else {
            var start = 1;
        }

        var end = start + Number(<?= Info::LIMIT_PAGE_VIEW ?> - 1);

        start = (start < 1) ? 1 : start;
        end = (end > page_count) ? page_count : end;

        for (var i = start; i <= end; i++) {
            var page = i;
            if (page == start || page == end) {
                search_page_number.append(createPageButton(page, true));
            } else {
                search_page_number.append(createPageButton(page, false));
            }
        }

        if (count_row === 0) {
            page_container.hide();
        }

        page_prev.show();
        page_next.show();
        page_first.show();
        page_last.show();

        if (current_page === 1) {
            page_prev.hide();
            page_first.hide();
        }

        if (current_page >= page_count) {
            page_next.hide();
            page_last.hide();
        }

    }

    function finishSearch(count_row, page_row_count) {
        setPagingParent(count_row);

        var paging_top = paging_parent.clone(true, true);
        paging_top.attr("id", "paging_clone_top");
        paging_top.removeAttr("hidden");
        search_result.prepend(paging_top);

        if (page_row_count >= <?= Info::LIMIT_SEARCH_CASE ?> / 2) {
            var paging_bottom = paging_parent.clone(true, true);
            paging_bottom.attr("id", "paging_clone_bottom");
            paging_bottom.removeAttr("hidden");
            search_result.append(paging_bottom);
        }

        toggleShowHideDom(load_container, search_result);
    }

    initSearch();

    function initSearch() {
        toggleShowHideDom(load_container, search_result);
        page_container.show();


        //page_value.html(current_page);
        var params = {};
        params["action"] = "ats_custom_query";
        params["query"] = "search_case";
        params["page"] = current_page;

        if (current_form !== null) {
            for (var i in current_form) {
                var val = current_form[i]["value"];
                if (val !== "") {
                    params[current_form[i]["name"]] = val;
                }
            }
        }

        jQuery.ajax({
            type: "POST",
            url: ajaxurl,
            data: params,
            dataType: "json",
            success: function (res) {
                //console.log(res.count);
                if (res.status === "<?= Info::STATUS_SUCCESS ?>") {
                    search_result.html(res.data);
                }
                finishSearch(res.count, res.page_row_count);
            },
            error: function (err) {
                alert("[SERVER ERROR] Failed To Load Info");
                finishSearch(0);
            }
        });

    }



</script>