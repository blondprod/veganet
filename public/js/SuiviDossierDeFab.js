/**
 *
 * Created by blond.
 * File: SuiviDossierDeFab.js
 * Date: 24/05/15 - 21:23
 *
 */

function getPrintButton(check)
{
    //console.log("check: "+check);

    var btnPrint = $('#btnPrint');

    if (tab_store_id.length==1) {
        btnPrint.prop("target","_blank");
        btnPrint.prop("href","PrintDossierDeFab?action=getDataDossierDeFabForFiche&IDDossierDeFab="+tab_store_id[0]+"");
    }

    else {
        btnPrint.prop("target","_self");
        btnPrint.prop("href","#");
    }
}

function getDeleteDossierDeFab(iddossierdefab)
{
    if(iddossierdefab != "") {
        getDelete("IDDossierDeFab","TBL_DOSSIER_DE_FAB");
    }
    $("#deleteDossierDeFab").modal("hide");

    location.reload();
}

function getData2EditDossierDeFabElement()
{
    if(tab_store_id.length=='1') {
//                $("#editDossierDeFab").modal("show");
        $.getJSON(
            'SuiviDossierDeFab',
            {
                'action': 'getData2EditDossierDeFabElement',
                'async': '1',
//                        'async_data': '1',
                'IDDossierDeFab': tab_store_id[0]
            },
            function (data)
            {
//                        //console.log(data);
                $('#modal').html(data.SentData);
                $("#editDossierDeFab").modal("show");
            }
        );
    }
    else if(tab_store_id.length=='0') { getModalAlert("Faite une séléction"); }
    else { getModalAlert("Une seule séléction"); }
}

function getDossierDeFabElement(id)
{
    $.getJSON(
        'SuiviDossierDeFab',
        {
            'action': 'getDossierDeFabElement',
            'async': '1',
//                        'async_data': '1',
            'IDDossierDeFab': id
        },
        function (data)
        {
            $('#body_'+id+'').html(data.SentData);
//                        //console.log(data);
        }
    );
}

function getDossierDeFabHTML(IP,PUBLIC_PATH)
{
    for(n=0;n<tab_store_id.length;n++)
    {
        //console.log(tab_store_id[n]);
        window.open('http://'+IP+'/'+PUBLIC_PATH+'Production?action=imp&IDDossierDeFab='+tab_store_id[n]+'','DossierDeFab_'+tab_store_id[n]+'', '');
    }
}