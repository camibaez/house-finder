var housesId = [];
var isGuest = true;

$(function () {
    $(".ad-fav-btn").click(favoriteAdBtnClick);
    $(".remove-fav-btn").click(removeFavoriteAdClick);
    $(".fake-filter").change(fakeFilterChange);
})



/*
 * A;ade o elimina un favorito.
 * @param {type} e
 * @return {undefined}
 */


/*
var favoriteAdBtnClick = function (e) {
    var houseId = $(this).attr("house-id");
    var button = $(this);
    if ($(this).attr('is-fav') == 0) {
        addFavAsync(houseId, function (data) {
            button.removeClass("add-fav-btn");
            button.addClass("cancel-fav-btn");
            button.attr("is-fav", 1);
        }, function (data) {
            alert("Se produjo un error agregando un favorito.");
        });
    } else {
        removeFavAsync(houseId, function (data) {
            button.removeClass("cancel-fav-btn");
            button.addClass("add-fav-btn");
            button.attr("is-fav", 0);
        }, function (data) {
            alert("Se produjo un error eliminando un favorito.");
        });
    }
}
*/

/**
 * Hndler del boton eliminar un favorito de la lista de favoritos
 * @param {type} e
 * @return {undefined}
 */
var removeFavoriteAdClick = function (e) {
    var houseId = $(this).attr("house-id");
    var button = $(this);
    removeFavAsync(houseId, function (data) {
        button.parent().remove();
    });

}

/**
 * Añade un favorito de manera asincrona
 * @param {type} houseId
 * @return {undefined}
 */
var addFavAsync = function (houseId, doneCallback, failCallback) {
    var ajaxRequest = $.ajax({
        method: "POST",
        url: "add-fav?id=" + houseId,
    });

    if (failCallback != null) {
        ajaxRequest.fail(failCallback);
    }
    if (doneCallback != null) {
        ajaxRequest.done(doneCallback);
    }
}

/**
 * Elimina un favorito de manera asincrona
 * @param {type} houseId
 * @return {undefined}
 */
var removeFavAsync = function (houseId, doneCallback, failCallback) {
    var ajaxRequest = $.ajax({
        method: "POST",
        url: "remove-fav?id=" + houseId,
    })

    if (failCallback != null) {
        ajaxRequest.fail(failCallback);
    }
    if (doneCallback != null) {
        ajaxRequest.done(doneCallback)
    }
}


/**
 * Añade un favorito en los cookies
 * @param {type} houseId
 * @return {undefined}
 */
var addFavCookie = function (houseId) {
    if (Cookies.get("favs-ids") == null) {
        Cookies.set('favs-ids', {});

    }
    var ids = Cookies.getJSON("favs-ids");
    ids[houseId] = 1;
    Cookies.set('favs-ids', ids);
}

/**
 * Elimina un favorito de los cookies
 * @param {type} houseId
 * @return {undefined}
 */
var removeFavCookie = function (houseId) {
    if (Cookies.get("favs-ids") == null) {
        Cookies.set('favs-ids', {});
        return;
    }
    var ids = Cookies.getJSON("favs-ids");
    delete ids[houseId];
    Cookies.set('favs-ids', ids);
}







var checkFavStatus = function () {
    if (Cookies.get("favs-ids") == null) {
        return;
    }
    var ids = Cookies.getJSON("favs-ids");
    if ($.isEmptyObject(ids))
        return;
    $('.ad-fav-btn').each(function (i) {
        var id = $(this).attr('house-id');
        if (ids.hasOwnProperty(id)) {
            $(this).attr('is-fav', 1);
            $(this).removeClass('add-fav-btn');
            $(this).addClass('cancel-fav-btn');
        }
    });

}





var fakeFilterChange = function (e) {
    var name = $(this).attr('name');
    var value = $(this).val();

    //Checking if is a range input
    if (name.includes("-")) {
        var i = name.indexOf("-");
        var name1 = name.slice(0, i);
        var name2 = name.slice(i + 1);

        var i = value.indexOf(",");
        var value1 = value.slice(0, i);
        var value2 = value.slice(i + 1);


        $('#real-filters input[name="' + name1 + '"]').val(value1);
        $('#real-filters input[name="' + name2 + '"]').val(value2);
    }

    $('#real-filters input[name="' + name + '"]').val(value);
}

var loadImages = function (e) {
    for (var id in housesId) {

    }
}