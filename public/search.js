{
    let categories;
    let blogs;
    let products;
    let canSearch;
    let baseUrl = "https://129eebe6.ngrok.io";
    let storeUrl = getUrl();
    let keywordSearch = getKeywordSearch(storeUrl);
    //main
    $(document).ready(function () {

        var abc = ["acb","ma", "am"];
        setTimeout(function () {
            console.log("abcacs")
            console.log(keywordSearch);
            $("#search_query").css({"position": "relative", "z-index": "10"});
            $('#search_query').suggest(keywordSearch);
        }, 3400);

        canSearch = true;
        $("#search_query").keyup("input",function (e) {

            if(canSearch)
            {
                var keyword = $("#search_query").val();

                //console.log(su);
                //getKeywordSearch(storeUrl);
                let domain = getDomain(storeUrl);
                changeFormAction(domain, $("#search_query").val());
                ajaxSearch();
                setTimeout(function(){
                    canSearch = true;
                } , 3);
            }
        });
    });

    //end main

    function getDomain(url) {
        var hostname = $('<a>').prop('href', url).prop('hostname');
       return hostname;
    }

    function changeFormAction(domain, keyword) {
        //alert(getDomain(getUrl()))
        var url = baseUrl + "/result/" + domain + "/products/" + keyword;
        $(".form").attr('action', url);
    }


    function getKeywordSearch(url) {
        $.ajax({
            url: baseUrl + "/api/keywords",
            type: "post",
            dataType: "json",
            data: {
                "url" : url
            },
            success: function (result) {
                //console.log(result);
                var keywordsSearch = [];
                for(var i = result.length -1 ; i >= 0; i--)
                {
                    keywordsSearch.push(result[i].key_word);
                }
                keywordSearch = keywordsSearch;
                 return keywordsSearch;
            },
            error: function (result) {
                console.log(result);
                keywordSearch =  null;
            }
        });
    }
    function ajaxSearch() {
        $.ajax({
            url: baseUrl + "/api/search",
            type: "post",
            dataType: "json",
            data: {
                "url": storeUrl,
                "keyword": $("#search_query").val(),
            },
            success: function (result) {
                categories = result["categories"];
                blogs = result ["blogs"];
                products = result["products"];
                document.getElementsByClassName("quickSearchResults")[0].innerHTML = "";
                foreachProducts(products);
                foreachBlogs(blogs);
                foreachCategories(categories);
             },
            error: function (result) {
                console.log(result);
            }
        });
        canSearch = false;
    }
    function foreachBlogs(blogs) {
        for (var i = 0; i < blogs.length; i++) {
            item = blogs[i];
            //console.log(item);
            //document.getElementById("test").innerHTML = item;
            //document.getElementById("blogs").innerHTML += "<a href='#'>"+item['title']+"</a>";
            var html  = `
                         <center><a href="${item["url"]}" style="text-decoration: none;">
                            <div class="form-input" style="width: 390px;">
                                ${item['title']} - ${item['author']}
                             </div>
                          </a></center>`
            document.getElementsByClassName("quickSearchResults")[0].innerHTML += html;

        }
    }
    function foreachProducts(products) {
        for (var i = 0; i < products.length; i++) {
            item = products[i];
            var html =  `<center><a href="${item["url"]}" style="text-decoration: none;">
                            <div class="product form-input" style="width: 390px">
                                <img src="${item["image_url"]}"/>
                                ${item['name']}
                          </div>
                           </a></center>`
            document.getElementsByClassName("quickSearchResults")[0].innerHTML += html;
        }
    }
    function foreachCategories(categories) {
        for (var i = 0; i < categories.length; i++) {
            item = categories[i];
            //document.getElementById("test").innerHTML = item;
            //document.getElementById("#product").innerHTML += "<tr><td>"+item['id']+"</td><td>"+item['title']+"</td><td>"+item['body']+"</td></tr>";
            var html = ` <center><a href="${item['url']}" style="text-decoration: none; margin:auto">
                                <div class="form-input" style="width: 390px">
                                    <img src="${item['image_url']}" width="44px"/>
                                    ${item['title']}
                                </div>
                        </a></center>`
            document.getElementsByClassName("quickSearchResults")[0].innerHTML += html;
        }
    }
    function getUrl() {
        return window.location.href;
    }
}
