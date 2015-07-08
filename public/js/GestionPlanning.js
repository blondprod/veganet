/**
 *
 * Created by blond.
 * File: GestionPlanning.js
 * Date: 24/03/15 - 21:23
 *
 */

//__ get table planning
function getTablePlanning()
{
            //console.log($('#dossier').val());
    $.getJSON(
        'GestionPlanning',
        {
            'action': 'getDataTableGestionPlanning',
            'IDSecteur': $('#SelectSecteur').val(),
            'IDMachine': $('#SelectMachine').val(),
            'Dossier': $('#dossier').val(),
            'Ref': $('#Ref').val(),
            'async': '1'
        },
        function (data)
        {
            $('#tableGestionPlanning').html(data.SentData);
            ////console.log(data);
        }
    );
    ////console.log('end');
    $('#divJumbotron').prop('hidden',true);
    //$('#collapseSearch').collapse('toggle');
}

function getDisabledCell(nbElement,value)
{
    for(n=0;n<nbElement;n++) {
        $('#Ordre_'+n+'').prop("disabled",value);
        $('#SelectMachine_'+n+'').prop("disabled",value);
    }
    if (value == true) getTablePlanning();
}

function getSavePlanning(nbElement)
{
    var IDDossierTlElementTlMachine = '';
    var Ordre = '';
    var IDMachine = '';

    for(n=0;n<nbElement;n++) {

        Ordre = document.getElementById("Ordre_"+n+"");
        IDDossierTlElementTlMachine = $('#IDDossierTlElementTlMachine_'+n+'');
        IDMachine = $('#SelectMachine_'+n+'');

        Sel_Mngt(IDDossierTlElementTlMachine.val(),true);
        Sel_Mngt_value(Ordre.value,true);
        Sel_Mngt_machine(IDMachine.val(),true);
    }

    //console.log(tab_store_id);
    //console.log(tab_store_value);
    //console.log(tab_store_machine);

    $.getJSON(
        'GestionPlanning',
        {
            'action': 'getUpdatePlanning',
            'array_IDDossierTlElementTlMachine':tab_store_id,
            'array_Ordre':tab_store_value,
            'array_IDMachine':tab_store_machine,
            'async_data': '1',
            'async': '1'
        },
        function (data)
        {
            //console.log(data);
        }
    );

    for(n=0;n<nbElement;n++) {

        Ordre = document.getElementById("Ordre_"+n+"");
        IDDossierTlElementTlMachine = $('#IDDossierTlElementTlMachine_'+n+'');
        IDMachine = $('#SelectMachine_'+n+'');

        Sel_Mngt(IDDossierTlElementTlMachine.val(),false);
        Sel_Mngt_value(Ordre.value,false);
        Sel_Mngt_machine(IDMachine.val(),false);
    }
    getTablePlanning();
}