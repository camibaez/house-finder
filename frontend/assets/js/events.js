$(function () {

    checkFavStatus();
    $(".ad-fav-btn").click(favoriteAdBtnClick);
    $('.remove-fav-btn').click(removeFavoriteAdClick)
})

/*
 * A;ade o elimina un favorito.
 * @param {type} e
 * @return {undefined}
 */

var favoriteAdBtnClick = function (e) {
    var houseId = $(this).attr("house-id");
    var button = $(this);
    if ($(this).attr('is-fav') == 0) {
        addFavCookie(houseId);
        button.removeClass("add-fav-btn");
        button.addClass("cancel-fav-btn");
        button.attr("is-fav", 1);
    } else {
        removeFavCookie(houseId);
        button.removeClass("cancel-fav-btn");
        button.addClass("add-fav-btn");
        button.attr("is-fav", 0);
    }
}


/**
 * Hndler del boton eliminar un favorito de la lista de favoritos
 * @param {type} e
 * @return {undefined}
 */
var removeFavoriteAdClick = function (e) {
    var houseId = $(this).attr("house-id");
    removeFavCookie(houseId);
    var button = $(this);
    button.parent().remove();

    if ($("#favs-list").children("div[data-key]").size() == 0) {
        window.location.reload();
    }

}

var getCookieFavIds = function () {
    var ids = Cookies.get("favs-ids");
    if (!ids) {
        Cookies.set('favs-ids', "");
        return [];
    }
    var favsList = ids.split(",");
    return favsList;
}

var setCookiesFavIds = function(ids){
    Cookies.set("favs-ids", ids.toString());
}
/**
 * Añade un favorito en los cookies
 * @param {type} houseId
 * @return {undefined}
 */
var addFavCookie = function (houseId) {
    var ids = getCookieFavIds();
    if(ids.indexOf(houseId) == -1){
        ids.push(houseId);
        setCookiesFavIds(ids);
    }
}

/**
 * Elimina un favorito de los cookies
 * @param {type} houseId
 * @return {undefined}
 */
var removeFavCookie = function (houseId) {
    var ids = getCookieFavIds();
    var i = ids.indexOf(houseId);
    if( i > -1){
        ids.splice(i, 1);
        setCookiesFavIds(ids);
    }
}


/**
 * Carga la vista renderizada de la lista de favoritos de manera asyncronica.
 * @return {undefined}
 */
var loadFavoritesList = function () {
    var ids = getCookieFavIds();
    if ($.isEmptyObject(ids))
        return;
    var idList = [];
    for (var id in ids) {
        idList.push(id);
    }

    $("#favs-content").html('<h4 style="margin-top: 50px; text-align: center">Cargando lista de favoritos...</h4>');
    $.ajax({
        method: "GET",
        url: 'favs-list',
        data: {ids: idList.toString()},
        dataType: "html"
    }).done(function (data) {
        $("#favs-content").html(data);

        if ($("#favs-list").size()) {
            $('.remove-fav-btn').click(removeFavoriteAdClick);
            $('#favs-values').val(idList.toString());
            $("#favs-list-options").prepend('<button id="cleanFavsBtn" class="btn btn-default btn-sm">Limpiar</button>');
            $("#cleanFavsBtn").click(cleanFavsClick);
        }



    })
}



var checkFavStatus = function () {
    var ids = getCookieFavIds();
    $('.ad-fav-btn').each(function (i) {
        var id = $(this).attr('house-id');
        if (ids.indexOf(id) != -1) {
            $(this).attr('is-fav', 1);
            $(this).removeClass('add-fav-btn');
            $(this).addClass('cancel-fav-btn');
        }
    });

}

var cleanFavsClick = function (e) {
    Cookies.set('favs-ids', {});
    window.location.reload();
}