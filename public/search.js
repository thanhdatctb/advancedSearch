{
    let categories;
    let blogs;
    let products;
    let canSearch;
    $(document).ready(function () {
        // document.getElementById("myDropdown").classList.toggle("show");
        canSearch = true;
        $("#search_query").keyup("input", function () {
            //console.log(canSearch);
            if (canSearch) {
                ajaxSearch();
                setTimeout(function () {
                    canSearch = true;
                }, 3);
            }
        });
    });

    function ajaxSearch() {
        $.ajax({
            url: "127.0.0.1:8000/api/search",
            type: "post",
            dataType: "json",
            data: {
                "url": "https://dat-smartosc-sandbox.mybigcommerce.com/",
                "keyword": $("#search_query").val(),
            },
            success: function (result) {
                categories = result["categories"];
                blogs = result ["blogs"];
                products = result["products"];
                console.log(categories);
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
            var html = `
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
            var html = `<center><a href="${item["url"]}" style="text-decoration: none;">
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
            item = categories[i]["attributes"];
            //document.getElementById("test").innerHTML = item;
            //document.getElementById("#product").innerHTML += "<tr><td>"+item['id']+"</td><td>"+item['title']+"</td><td>"+item['body']+"</td></tr>";
            // console.log(item);
            var html = ` <center><a href="${item['url']}'" style="text-decoration: none; margin:auto">
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
