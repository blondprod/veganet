/**
 *
 * Created by blond.
 * File: ProductionReclame.js
 * Date: 24/05/15 - 21:23
 *
 */

function getClotureReclame()
{
//            console.log(tab_store_id);
    if (tab_store_id.length > 0){
        $('#IDReclameModalCloture').val(tab_store_id);
        $('#clotureReclame').modal('show');
    } else {
        getModalAlert("Choisir au moins un dossier");
    }
}

function getDeleteReclame()
{
//            console.log(tab_store_id);
    if (tab_store_id.length > 0){
        $('#IDReclameModalDelete').val(tab_store_id);
        $('#deleteReclame').modal('show');
    } else {
        getModalAlert("Choisir au moins un dossier");
    }
}

function getReponseReclame()
{
//            console.log(tab_store_id);
    if (tab_store_id.length > 0){
        $('#IDReclame').val(tab_store_id);
        $('#addReponse').modal('show');
    } else {
        getModalAlert("Choisir au moins un dossier");
    }
}

function getUpdateDemande()
{
    //console.log(tab_store_id);
    if (tab_store_id.length == 1){

        $.getJSON(
            'ProductionReclame',
            {
                'action': 'getDataReclameToFillModalEdit',
                'async': '1',
                'async_data': '1',
                'IDReclame': tab_store_id[0]
            },
            function (data) {
                $('#IDReclameModalUp').val(data['DATA_RECLAME'][0]['IDReclame']);
                $('#DossierModalUp').val(data['DATA_RECLAME'][0]['Dossier']);
                $('#RefModalUp').val(data['DATA_RECLAME'][0]['Ref']);
                $('#DemandeModalUp').val(data['DATA_RECLAME'][0]['Demande']);
                $('#QuantiteModalUp').val(data['DATA_RECLAME'][0]['Quantite']);
                $('#DateExpeditionModalUp').val(data['DATA_RECLAME'][0]['DateExpedition']);

                $('#upDemande').modal('show');
            }
        );
    } else {
        getModalAlert("Choisir un seul dossier");
    }
}