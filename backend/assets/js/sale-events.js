/**
 * Created by El Teta on 06/08/2016.
 */

$(function () {
    $("#cmbProvince").find("select").change(cmbProvinceChange);
    $("#cmbMunicipality").find("select").change(cmbMunicipalityChange).click(cmbMunicipalityChange);
    $("#fakeFileInput").click(function (e) {
        $("#fileInputArea input").trigger("click");
    });
    $("#fileInputArea input").change(imagesInputChange);
})

var cmbProvinceChange = function (e) {
    $('#cmbProvince').find('select>option[value=""]').remove();
    var id = $(this).val();

    $("#cmbMunicipality").find("select").html("<option value=''> Cargando municipios </option>");


    $.ajax({
        type: "GET",
        url: 'municipalities',
        data: {parentId: id}
    }).done(function (msg) {
        var html = "<option value=''> Seleccione el municipio </option>" + msg
        $("#cmbMunicipality").find("select").html(html);

    }).fail(function (e) {
        alert('Error obteniendo los Municipios')
    });
    ;

    //cmbMunicipalityChange(null);
}

var cmbMunicipalityChange = function (e) {
    var id = $("#cmbMunicipality").find("select").val();
    $("#cmbNeighborhood").find("select").html("<option value=''> Cargando barrios </option>");
    $.ajax({
        type: "GET",
        url: 'neighborhoods',
        data: {parentId: id}
    }).done(function (msg) {
        var html = "<option value=''>Seleccione el barrio</option>" + msg;
        $("#cmbNeighborhood").find("select").html(html);
    }).fail(function (e) {
        alert('Error obteniendo los vecindarios')
    });
}

var imagesInputChange = function (e) {
    var count = this.files.length;
    $("#fakeFileInputInfo").html("Agregar Fotos (" + count + " / 3)");

    var html = '';
    $("#imagesView").html("");
    for (var i = 0; i < count; i++) {
        var f = this.files[i];


        var data = f.slice(0, f.size, f.type);

        var reader = new FileReader();
        reader.addEventListener('loadend', function () {
            var imageData = this.result;
            var imageLabel = "<img class='col-xs-4' src='" + imageData + "'>";
            $("#imagesView").append(imageLabel);
        });
        reader.readAsDataURL(data);
    }

}